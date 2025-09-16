<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Ticket
 * @author iplustraining
 * Date : 30-10-16
 * @property Mod_ticket $Mod_ticket
 */
class Ticket extends My_Controller
{

    private $record_per_page = 50;
    private $record_num_links = 5;
    private $data = '';

    public function __construct()
    {
        parent::__construct();

        $this->data['module_name'] = "Ticket Information";

        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */

        $this->load->model('sm/Mod_ticket');
        $this->load->model('sm/Mod_common');

        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }
    }

    function index()
    {

        if ($this->session->userdata('is_customer_login') == true) {

            $customer_id = $this->session->userdata('customer_auto_id');
            $this->data['machine'] = $this->Mod_ticket->get_customer_wise_machine($customer_id);
        }

        $this->data['division_list'] = $this->Mod_common->get_division_list();
        $this->load->view('sm/ticket/view_create_ticket', $this->data);
    }


    //================ support type information =================
    public function get_support_type_info($machine_id)
    {

        $customer_id = $this->session->userdata('customer_auto_id');

        $data['support_type'] = $this->Mod_ticket->get_machine_supporttype_info($machine_id, $customer_id);

        $support = $this->load->view('sm/ticket/view_machine_support_type', $data, true);

        $respons = [

            'id' => $data['support_type']->su_type_id,
            'content' => $support
        ];

        echo json_encode($respons);
    }

    function save()
    {

        if ($this->session->userdata('is_customer_login') == true) {

            $customer_id = $this->session->userdata('customer_auto_id');
            $this->data['machine'] = $this->Mod_ticket->get_customer_wise_machine($customer_id);
        }

        $this->data['division_list'] = $this->Mod_common->get_division_list();

        $customer_id = $this->session->userdata('customer_auto_id');
        $machine_id = $this->security->xss_clean($this->input->post('machine'));

        $this->form_validation->set_rules('machine', 'Machine', 'required');
        $this->form_validation->set_rules('cp_name', 'Contact Person Name', 'required');
        $this->form_validation->set_rules('cp_number', 'Contact Person Phone Number', 'required');
        $this->form_validation->set_rules('request_details', 'Problem Details', 'required');

        if ($this->form_validation->run()) {

            $valid_support = $this->Mod_ticket->support_type_validation($customer_id,$machine_id);

            if ($valid_support == 1){

                $generate_ticket_no = $this->Mod_ticket->save_customer_ticket();

                if (!empty($generate_ticket_no)) {
                    $this->session->set_flashdata('generate_ticket_no', $generate_ticket_no);
                    redirect('sm/ticket/success');
                } else { //error, show the ticket generating page again
                    $this->session->set_flashdata('ticket_creation_error', 'Something went wrong, please try again.');
                    redirect('sm/ticket/');
                }

            }else{
                $this->session->set_flashdata('ticket_creation_error', 'Your Support Time Already Exists.');
                redirect('sm/ticket/');
            }


        } else {
            $this->data['ticket_creation_error'] = 'Please fill the required fields and try again.';
            $this->load->view('sm/ticket/view_create_ticket', $this->data);
        }
    }

    function success()
    {
        $this->load->view('sm/ticket/view_create_ticket_success', $this->data);
    }

    function ajax_get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url = base_url() . 'sm/ticket/';
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
        $this->data['division_list'] = $this->Mod_common->get_division_list();

        /*  for pagination */
        $row = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }


        $this->data['support_type'] = $this->Mod_ticket->get_support_type();

        $this->data['record'] = $this->Mod_ticket->get_ticket_list($this->record_per_page, $row);

        $config['per_page'] = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/ticket/records/';
        $config['total_rows'] = $this->Mod_ticket->ticket_total_rows();                  /*  for get table total rows number */

        $page_config = get_pagination_paramter();
        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page'] = $config['per_page'];

        $this->load->view('sm/ticket/view_list_ticket', $this->data);
    }


    function edit()
    {
        $auto_id = $this->uri->segment(3);
        $get_details = $this->Mod_ticket->get_details($auto_id);

        $this->data['res'] = $get_details;
        $this->load->view('sm/ticket/view_edit_ticket', $this->data);
    }

    function update()
    {

        $auto_id = $this->security->xss_clean($this->input->post('auto_id'));

        $this->form_validation->set_rules('cust_category', 'Ticket Category', 'required');
        $this->form_validation->set_rules('cust_name', 'Ticket Name', 'required');
        $this->form_validation->set_rules('cust_status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $get_details = $this->Mod_ticket->get_details($auto_id);

            $this->data['res'] = $get_details;
            $this->load->view('ticket/view_edit_ticket', $this->data);
        } else {
            $res_flag = $this->Mod_ticket->update_data();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Ticket information updated successfully.');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to update information.');
            }
            redirect('ticket/records');
        }
    }

    function view()
    {
        $auto_id = $this->uri->segment(4);
        $get_details = $this->Mod_ticket->get_details($auto_id);

        $this->data['view'] = $get_details;
        $this->load->view('sm/ticket/view_details_ticket', $this->data);
    }

    function action()
    {
        $auto_id = $this->uri->segment(4);//ticketId
        $this->data['view'] = $this->Mod_ticket->get_details($auto_id);

        /*  for pagination */
        $row = 0;
        $record_pos = $this->uri->segment(5);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $this->data['record'] = $this->Mod_ticket->get_ticket_comment_list(3, $row);

        $config['per_page'] = '3';
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/ticket/records/';
        $config['total_rows'] = $this->Mod_ticket->ticket_comment_total_rows();                  /*  for get table total rows number */

        $page_config = get_pagination_paramter();
        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page'] = $config['per_page'];

        $this->load->view('sm/ticket/view_ticket_action', $this->data);
    }


//=========================== view customer ticket details ======================
    function customer_ticket_details()
    {
        $ticket_no = trim($this->security->xss_clean($this->input->post('ticket_no')));
        $ticket_details_data = $this->Mod_ticket->get_ticket_details($ticket_no);

        $this->data['ticket_details_data'] = $ticket_details_data;
        $this->data['ticket_comment_list'] = $this->Mod_ticket->get_ticket_comment_list_tab($ticket_no);
        $this->data['ticket_trans_flow'] = $this->Mod_ticket->get_ticket_trans_flow_tab($ticket_no);

        $this->data['service_engineer'] = $this->Mod_ticket->get_service_eng_details($ticket_no);


        $ticket_details = $this->load->view('sm/ticket/view_customer_ticket_details', $this->data, true);
        $arr = array(
            'ticket_details' => $ticket_details
        );
        echo json_encode($arr);
    }

    function customer_ticket_cancel()
    {
        $arr = '';

        $ticket_no = trim($this->security->xss_clean($this->input->post('ticket_no')));
        $customer_auto_id = $this->session->userdata('customer_auto_id');

        if (!empty($ticket_no)) {
            $arr = array(
                'ticket_no' => $ticket_no,
                'cancel_from' => 'customer',
                'action_by' => $customer_auto_id,
                'label' => 'Cancel'
            );
            $this->Mod_ticket->cancel_ticket($arr);
        }
        echo json_encode($arr);
    }

    function customer_ticket_search()
    {
        $config = [];

        /* Start search page pagination */
        $row = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }
        $ticket_no = trim($this->security->xss_clean($this->input->post('ticket_no')));  /* get search field name */
        $send_from = trim($this->security->xss_clean($this->input->post('send_from')));
        $subject = trim($this->security->xss_clean($this->input->post('subject')));
        $status = trim($this->security->xss_clean($this->input->post('status')));

        $sess_and_arry = array(
            'ticket_no' => $ticket_no,
            'send_from' => $send_from,
            'subject' => $subject,
            'status' => $status,
            'search' => TRUE
        );

        $this->session->set_userdata($sess_and_arry);

        $results = $this->Mod_ticket->customer_ticket_search($this->record_per_page, $row);
        $total_rows = $this->Mod_ticket->customer_ticket_search_count();

        $config['per_page'] = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/ticket/records/';
        $config['total_rows'] = $total_rows;                 /*  for get table total rows number */

        $page_config = get_pagination_paramter();
        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links'] = '';//$this->pagination->create_links();//******** TO BE FIX later, for ajax search
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page'] = $config['per_page'];


        $this->data['record'] = $results;
        $ticket_list = $this->load->view('sm/ticket/view_search_list_ticket_ajax', $this->data, true);

        $arr = array(
            'ticket_list' => $ticket_list,
            'total_ticket' => $total_rows,
        );

        echo json_encode($arr);
    }

    function ticketsearch()
    {

        $search = '';
        $searchUrl = '';
        $config = [];

        /* Start search page pagination */
        $row = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }
        $ticket_no = trim($this->security->xss_clean($this->input->post('ticket_no')));  /* get search field name */
        $send_from = trim($this->security->xss_clean($this->input->post('send_from')));
        $subject = trim($this->security->xss_clean($this->input->post('subject')));
        $status = trim($this->security->xss_clean($this->input->post('status')));

        $sess_and_arry = array(
            'ticket_no' => $ticket_no,
            'send_from' => $send_from,
            'subject' => $subject,
            'status' => $status,
            'search' => TRUE
        );

        $this->session->set_userdata($sess_and_arry);

        $results = $this->Mod_ticket->search_all_list(1, $row);

        $config['per_page'] = '1';
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/ticket/records/';
        $config['total_rows'] = $this->Mod_ticket->count_search_record();                  /*  for get table total rows number */

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

        $this->data['search'] = $results;
        $this->load->view('sm/ticket/view_ticket_list_search', $this->data);
    }
}
