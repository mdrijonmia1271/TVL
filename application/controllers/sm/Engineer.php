<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of dc
 * @author iplustraining
 * Date : 30-10-16
 * @property Mod_engineer $Mod_engineer
 */
class Engineer extends My_Controller
{

    private $record_per_page  = 8;
    private $record_num_links = 5;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_engineer');
        $this->load->model('sm/Mod_common');
        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */

        //$this->load->plugin('dhtmlgoodies_calendar');
        $this->data['cust_status_type']      = $this->common_lib->cust_status_type_array();
        $this->data['year_array']            = $this->common_lib->get_year_array();
        $this->data['month_array']           = $this->common_lib->get_month_array();
        $this->data['day_array']             = $this->common_lib->get_day_array();
        $this->data['has_email_phone_array'] = $this->common_lib->cust_has_email_phone_array();

        if ($this->session->userdata('is_login') != true || $this->session->userdata('root_admin') == "no") { //only supper admin can access
            redirect('sm/home');
        }
    }

    function index()
    {
        $this->data['division_list'] = $this->Mod_common->get_division_list();

        $this->data['designation_list'] = $this->Mod_common->get_designation_array();
        $this->data['department_list']  = $this->Mod_common->get_department_array();

        $this->load->view('sm/engineer/view_create_service_eng', $this->data);

    }


    function add_serviceEng()
    {
        $this->load->view('engineer/view_create_service_eng', $this->data);
    }


    function save()
    {

        $this->data['division_list']    = $this->Mod_common->get_division_list();
        $this->data['designation_list'] = $this->Mod_common->get_designation_array();
        $this->data['department_list']  = $this->Mod_common->get_department_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required');
        $this->form_validation->set_rules('ser_eng_code', 'Service Engineer Code', 'required');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile',
            'required|callback_validate_uniqe_mobile|integer|max_length[16]');

        $this->form_validation->set_rules('department', 'department', 'required');
        $this->form_validation->set_rules('designation', 'designation', 'required');

        $this->form_validation->set_rules('experience', 'Service Engineer experience', 'required');

//        $this->form_validation->set_rules('contact_add_details', 'Address', 'required');
//        $this->form_validation->set_rules('contact_add_division', 'Division', 'required');
//        $this->form_validation->set_rules('contact_add_district', 'District', 'required');
//        $this->form_validation->set_rules('contact_add_upazila', 'Upazila', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_engineer->save_data();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Engineer created successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to create engineer');
            }
            redirect('sm/engineer/index');
        } else {
            $this->load->view('sm/engineer/view_create_service_eng', $this->data);
        }
    }

    function ajax_get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url     = base_url() . 'sm/engineer/';
        $options = $this->Mod_common->get_disrict_list_by_div($division_id, $url);
        echo $options;
    }

    function ajax_get_upazila()
    {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));
        $options     = $this->Mod_common->get_upazila_list_by_dis($district_id);
        echo $options;
    }

    function records()
    {
        $this->data['title']            = "Service Engineer List";
        $this->data['division_list']    = $this->Mod_common->get_division_list();
        $this->data['designation_list'] = $this->Mod_common->get_designation_array();
        $this->data['department_list']  = $this->Mod_common->get_department_array();

        $row                 = 0;
        $temp_record_postion = $this->uri->segment(4);

        if (!empty($temp_record_postion)) {
            $row = $temp_record_postion;
        }

        $this->data['record'] = $this->Mod_engineer->get_service_engineer_list($this->record_per_page, $row);

        $config['per_page']    = $this->record_per_page;
        $config["uri_segment"] = 4;
        $config['base_url']    = base_url() . 'sm/engineer/records';
        $config['total_rows']  = $this->Mod_engineer->service_engineer_total_rows();

        $page_config = get_pagination_paramter();
        $config      = array_merge($config, $page_config);
        $this->pagination->initialize($config);

        //$this->data['record_pos'] = $row;

        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];

        $this->load->view('sm/engineer/view_service_eng_list', $this->data);
    }


    function paging()
    {
        $row                 = 0;
        $temp_record_postion = $this->uri->segment(3);

        if (!empty ($temp_record_postion)) {
            $row = $temp_record_postion;
        }

        $config['base_url']   = base_url() . 'engineer/paging';
        $config['total_rows'] = $this->Mod_engineer->count_records();
        $config['per_page']   = $this->record_per_page;
        $config['num_links']  = $this->record_num_links;

        $config['full_tag_open']  = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config);

        $this->data['record_pos'] = $row;
        $this->data['total_rows'] = $this->Mod_engineer->count_records();
        $this->data['links']      = $this->pagination->create_links();

        $this->data['rec'] = $this->Mod_engineer->get_records($this->record_per_page, $row);
        $this->load->view('engineer/view_service_eng_list', $this->data);
    }

    function edit()
    {
        $this->data['division_list']    = $this->Mod_common->get_division_list();
        $this->data['designation_list'] = $this->Mod_common->get_designation_array();
        $this->data['department_list']  = $this->Mod_common->get_department_array();

        $auto_id            = $this->uri->segment(4);
        $get_details        = $this->Mod_engineer->edit_details($auto_id);
        $this->data['edit'] = $get_details;
        $this->load->view('sm/engineer/view_edit_service_eng', $this->data);
    }

    function update()
    {

        $hidden_ser_eng_id = $this->security->xss_clean($this->input->post('hidden_ser_eng_id'));


        $this->form_validation->set_rules('name', 'Full Name', 'required');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile',
            'required|callback_validate_uniqe_mobile_edit|integer|max_length[16]');

        $this->form_validation->set_rules('department', 'department', 'required');
        $this->form_validation->set_rules('designation', 'designation', 'required');


        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_engineer->update_data();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Engineer Edited Successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to Edit Engineer');
            }
            redirect('sm/engineer/index');
        } else {
            $hidden_ser_eng_id  = $this->security->xss_clean($this->input->post('hidden_ser_eng_id'));
            $get_details        = $this->Mod_engineer->edit_details($hidden_ser_eng_id);
            $this->data['edit'] = $get_details;
            $this->load->view('sm/engineer/view_edit_service_eng', $this->data);
        }

    }


    function search()
    {

        $search    = '';
        $searchUrl = '';
        $config    = [];

        /* Start search page pagination */
        $row            = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }
        $name   = trim($this->security->xss_clean($this->input->post('name')));  /* get search field name */
        $email  = trim($this->security->xss_clean($this->input->post('email')));
        $mobile = trim($this->security->xss_clean($this->input->post('mobile')));
        $status = trim($this->security->xss_clean($this->input->post('status')));

        $sess_and_arry = array(
            'name'   => $name,
            'email'  => $email,
            'mobile' => $mobile,
            'status' => $status,
            'search' => true
        );

        $this->session->set_userdata($sess_and_arry);

        $results = $this->Mod_engineer->search_all_list($this->record_per_page, $row);

        $config['per_page']    = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/engineer/records/';
        $config['total_rows']  = $this->Mod_engineer->count_search_record();                  /*  for get table total rows number */

        $config['first_link']      = '&lsaquo; First';
        $config['last_link']       = 'Last &rsaquo;';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link']       = '&lsaquo;';
        $config['prev_tag_open']   = '<li class="prev">';
        $config['prev_tag_close']  = '</li>';
        $config['next_link']       = '&rsaquo;';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="paginate_button active"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';

        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];

        $this->data['search'] = $results;
        $this->load->view('sm/engineer/view_engineer_list_search', $this->data);
    }


    function view()
    {

        $login_customer_phone = $this->session->userdata('login_engineer_phone');

        $get_details = $this->Mod_engineer->get_details($login_customer_phone);

        $this->data['view'] = $get_details;

        $this->load->view('sm/engineer/view_profile_engineer', $this->data);
    }


    function validate_uniqe_mobile($user_mobile)
    {
        $flag = $this->Mod_engineer->check_user_mobile_uniq($user_mobile);

        if ($flag == true) {
            $this->form_validation->set_message('validate_uniqe_mobile',
                '<span style="color:red;" >Mobile: <i>' . $user_mobile . '</i> has already been taken.</span>');
            return false;
        } else {
            return true;
        }
    }


    function validate_uniqe_mobile_edit($user_mobile)
    {
        $hidden_ser_eng_id = $this->security->xss_clean($this->input->post('hidden_ser_eng_id'));
        $flag              = $this->Mod_engineer->check_user_mobile_uniq_edit($user_mobile, $hidden_ser_eng_id);

        if ($flag == true) {
            $this->form_validation->set_message('validate_uniqe_mobile_edit',
                '<span style="color:red;" >Mobile: <i>' . $user_mobile . '</i> has already been taken.</span>');
            return false;
        } else {
            return true;
        }
    }


}