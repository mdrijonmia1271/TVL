<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Manager
 * @author iplustraining
 * Date : 30-10-16
 * @property Mod_manager $Mod_manager
 * @property Mod_common $Mod_common
 * @property Mod_ticket $Mod_ticket
 *
 */
class Manager extends My_Controller
{

    private $record_per_page = 50;//50
    private $record_num_links = 5;
    private $data = '';

    public function __construct()
    {
        parent::__construct();

        $this->data['module_name'] = "Service Management Information";

        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */
        $this->load->helper('utility_helper');

        $this->load->model('sm/Mod_manager');
        $this->load->model('sm/Mod_common');

        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }
    }

    function index()
    {


        $this->data['customer_list'] = get_customer_array_dropdown_admin(); //$this->Mod_common->get_customer_array_dropdown();
        $this->data['division_list'] = $this->Mod_common->get_division_list();

        $this->load->view('sm/manager/view_create_ticket', $this->data);
    }

    public function ajax_get_machine_list()
    {
        $customer_id = $this->input->post('id');


        $options = '<option value="">Select</option>';
        if (!empty($customer_id)) {

            $machines = $this->Mod_manager->get_machine_list($customer_id);

            if (!empty($machines)){

                foreach ($machines as $machine) {

                    if (empty($machine->mc_version)){

                        $my_machine_name = $machine->mc_name . "  ( Model: " . $machine->mc_model . ", Serial:". $machine->insb_serial. ")";
                        $options .= "<option value='{$machine->mc_id}'>{$my_machine_name}</option>";

                    }elseif (empty($machine->insb_serial)){
                        $my_machine_name = $machine->mc_name . "  ( Model: " . $machine->mc_model . ", Version: " . $machine->insb_version . ")";
                        $options .= "<option value='{$machine->mc_id}'>{$my_machine_name}</option>";
                    }
                    else{
                        $my_machine_name = $machine->mc_name . "  ( Model: " . $machine->mc_model . ", Version: " . $machine->insb_version . ", Serial:". $machine->insb_serial. ")";
                        $options .= "<option value='{$machine->mc_id}'>{$my_machine_name}</option>";
                    }

                }
            }

        }

        echo $options;
    }


    public function ajax_get_machine_info()
    {

        $machine_id = $this->input->post('machine_id');
        $customer_id = $this->input->post('customer_id');
        $data['support_type'] = $this->Mod_manager->get_machine_supporttype_info($machine_id, $customer_id);

        $support = $this->load->view('sm/manager/view_machine_support_type', $data, true);

        $respons = [

            'id' => $data['support_type']->su_type_id,
            'content' => $support
        ];

        echo json_encode($respons);

    }


    function save()
    {

        $customer_id = $this->security->xss_clean($this->input->post('send_from'));
        $machine_id = $this->security->xss_clean($this->input->post('machine'));

        $this->form_validation->set_rules('send_from', 'Customer Selection', 'required');
        $this->form_validation->set_rules('hidden_support_type_id', 'Support type', 'required');
        $this->form_validation->set_rules('request_details', 'Ticket Details', 'required');
        $this->form_validation->set_rules('cp_name', 'Contact Person Name', 'required');
        $this->form_validation->set_rules('cp_number', 'Contact Person Number', 'required');
        $this->form_validation->set_rules('machine', 'Machine', 'required');

        if ($this->form_validation->run()) {

            $valid_support = $this->Mod_manager->support_type_validation($customer_id, $machine_id);

            if ($valid_support == 1) {
                $res_flag = $this->Mod_manager->savedata();

                if (!empty($res_flag)) {
                    $this->session->set_flashdata('flashOK', 'Ticket created successfully');
                    redirect('sm/manager/ticketlist');
                } else {
                    $this->session->set_flashdata('flashOK', 'Ticket created Failed');
                    redirect('sm/manager/index');
                }
            } else {
                $this->session->set_flashdata('flashOK', 'Your Support Time Already Exists');
                redirect('sm/manager/index');
            }

        } else {
            $this->data['customer_list'] = get_customer_array_dropdown_admin();
            $this->load->view('sm/manager/view_create_ticket', $this->data);
        }
    }

    function ticketlist()
    {

        $this->data['service_engineer_list'] = $this->Mod_common->get_service_engineer_array();
        /*  for pagination */
        $row = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }


        $this->data['support_type'] = $this->Mod_manager->get_serivce_type();
        $this->data['record'] = $this->Mod_manager->get_ticket_list($this->record_per_page, $row);

        $ticket_total_rows = $this->Mod_manager->ticket_total_rows();

        $config['per_page'] = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/manager/ticketlist/';
        $config['total_rows'] = $ticket_total_rows;            /*  for get table total rows number */

        $page_config = get_pagination_paramter();
        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['total_rows'] = $ticket_total_rows;
        $this->data['per_page'] = $config['per_page'];

        $this->load->view('sm/manager/view_ticketlist_manager', $this->data);
    }

    function ticketsearch()
    {
        $config = [];

        /* Start search page pagination */
        $row = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }

        if ($_POST) {
            $ticket_no = trim($this->security->xss_clean($this->input->post('ticket_no')));  /* get search field name */
            $customer_list = trim($this->security->xss_clean($this->input->post('customer_list')));
            $engineer_list = trim($this->security->xss_clean($this->input->post('engineer_list')));
            $priority = trim($this->security->xss_clean($this->input->post('priority')));
            $support_type = trim($this->security->xss_clean($this->input->post('support_type')));
            $status = trim($this->security->xss_clean($this->input->post('status')));

            $sess_and_arry = array(
                'ticket_no' => $ticket_no,
                'customer_list' => $customer_list,
                'engineer_list' => $engineer_list,
                'priority' => $priority,
                'support_type' => $support_type,
                'status' => $status,
                'search' => TRUE
            );

            $this->session->set_userdata($sess_and_arry);
        }

        $results = $this->Mod_manager->search_admin_ticket($this->record_per_page, $row);
        $total_rows = $this->Mod_manager->search_admin_ticket_count();     /*  for get table total rows number */

        $config['per_page'] = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/manager/ticketsearch/';
        $config['total_rows'] = $total_rows;

        $page_config = get_pagination_paramter();
        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links'] = '';//$this->pagination->create_links();  //**************to be fix later, for ajax search
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page'] = $config['per_page'];

        $this->data['record'] = $results;
        $ticket_list = $this->load->view('sm/manager/view_admin_ticket_list_ajax', $this->data, true);
        $arr = array(
            'ticket_list' => $ticket_list,
            'total_ticket' => count($results)
        );
        echo json_encode($arr);
        //$this->load->view('sm/manager/view_ticket_list_search', $this->data);
    }

    function ajax_get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url = base_url() . 'sm/customer/';
        $options = $this->Mod_common->get_disrict_list_by_div($division_id, $url);
        echo $options;
    }

    function ajax_get_upazila()
    {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));
        $options = $this->Mod_common->get_upazila_list_by_dis($district_id);
        echo $options;
    }

    function records()
    {
        $config = [];
        $this->data['title'] = "Customer List";
        $this->data['division_list'] = $this->Mod_common->get_division_list();

        /*  for pagination */
        $row = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $this->data['record'] = $this->Mod_customer->get_customer_list(20, $row);

        $config['per_page'] = '20';
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/customer/records/';
        $config['total_rows'] = $this->Mod_customer->customer_total_rows();                  /*  for get table total rows number */

        $config['first_link'] = '&lsaquo; First';
        $config['last_link'] = 'Last &rsaquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&lsaquo;';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&rsaquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="paginate_button active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page'] = $config['per_page'];

        $this->load->view('sm/customer/view_customer_list', $this->data);
    }

    function edit()
    {
        $auto_id = $this->uri->segment(3);
        $get_details = $this->Mod_customer->get_details($auto_id);

        $this->data['res'] = $get_details;
        $this->load->view('sm/customer/view_edit_customer', $this->data);
    }

    function update()
    {

        $auto_id = $this->security->xss_clean($this->input->post('auto_id'));

        $this->form_validation->set_rules('cust_category', 'Customer Category', 'required');
        $this->form_validation->set_rules('cust_name', 'Customer Name', 'required');
        // $this->form_validation->set_rules('cust_phone1','Customer Phone1','required');
        //$this->form_validation->set_rules('dob_year','DOB Year','required');
        //$this->form_validation->set_rules('dob_month','DOB Month','required');
        //$this->form_validation->set_rules('dob_day','DOB Day','required');
        $this->form_validation->set_rules('cust_status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $get_details = $this->Mod_customer->get_details($auto_id);

            $this->data['res'] = $get_details;
            $this->load->view('customer/view_edit_customer', $this->data);
        } else {
            $res_flag = $this->Mod_customer->update_data();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Customer Information updated successfully.');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to update information.');
            }
            redirect('customer/records');
        }
    }

    function view()
    {
        $auto_id = $this->uri->segment(3);
        $get_details = $this->Mod_manager->get_details($auto_id);

        $this->data['res'] = $get_details;
        $this->load->view('manager/view_list_manager', $this->data);
    }

    function get_ticket_info()
    {

        $this->data['service_engineer_list'] = $this->Mod_common->get_service_engineer_array();
        $get_details = $this->Mod_manager->get_ticket_info();

        echo $get_details;
    }

    function single_ticket_details()
    {

        $this->data['service_engineer_list'] = $this->Mod_common->get_service_engineer_array();

        $ticketId = $this->uri->segment(4);
        $this->data['ticket'] = $this->Mod_manager->get_details($ticketId);

        $this->load->view('sm/manager/view_ticket_singledetails', $this->data);
    }

    function save_assign_se_ticket()
    {

        $this->form_validation->set_rules('select_servie_eng', 'Ticket liability', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_manager->assignSETicket();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Ticket has been assigned successfully');
                redirect('sm/manager/ticketlist');
            } else {
                $this->session->set_flashdata('flashError', 'Ticket assigned Failed');
                $srd_id = $this->input->post('srd_id');
                redirect('sm/manager/single_ticket_details/' . $srd_id);
            }
        } else {
            $this->data['service_engineer_list'] = $this->Mod_common->get_service_engineer_array();
            $srd_id = $this->uri->segment(4);
            $this->data['ticket'] = $this->Mod_manager->get_details($srd_id);
            $this->load->view('sm/manager/view_ticket_singledetails', $this->data);
        }
    }

    function assign_ticket_status()
    {
        $arr = '';
        $status = $this->security->xss_clean($this->input->post('status'));
        $engineer_list = $this->security->xss_clean($this->input->post('engineer_list'));

        if (!empty($status) || !empty($engineer_list)) {

            $hidden_ticket_no = $this->security->xss_clean($this->input->post('hidden_ticket_no'));
            $hidden_ticket_autoid = $this->security->xss_clean($this->input->post('hidden_ticket_autoid'));
            $this->Mod_manager->update_admin_ticket_status();
            $updated_status = '';
            if (!empty($status)) {
                $status_arr = ticket_status_array();
                $updated_status = $status_arr[$status];
            }

            $arr = array(
                'updated' => 'yes',
                'updated_status' => $updated_status,
                'ticket_no' => $hidden_ticket_no,
                'autoid' => $hidden_ticket_autoid,
            );
        } else {
            $arr = array(
                'updated' => 'no',
            );

        }

        echo json_encode($arr);
    }

    function admin_ticket_details()
    {
        $this->load->model('sm/Mod_ticket');
        $ticket_no = trim($this->security->xss_clean($this->input->post('ticket_no')));
        $ticket_details_data = $this->Mod_ticket->get_ticket_details($ticket_no);

        $this->data['ticket_details_data'] = $ticket_details_data;
        $this->data['ticket_comment_list'] = $this->Mod_ticket->get_ticket_comment_list_tab($ticket_no);
        $this->data['ticket_trans_flow'] = $this->Mod_ticket->get_ticket_trans_flow_tab($ticket_no);

        $ticket_details = $this->load->view('sm/manager/view_admin_ticket_details', $this->data, true);
        $arr = array(
            'ticket_details' => $ticket_details
        );
        echo json_encode($arr);
    }


    function ajax_get_customer_tasklist()
    {
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $options = $this->Mod_common->get_task_list_by_customer($customer_id);
        echo $options;
    }

    function ajax_get_customer_support_type()
    {
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $options = $this->Mod_common->get_supporttype_by_customer($customer_id);
        echo $options;
    }

}
