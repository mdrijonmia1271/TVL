<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Report
 * @author iplustraining
 * Date : 30-10-16
 * @property Mod_report $Mod_report
 * @property Mod_common $Mod_common
 * @property MedicalDep $MedicalDep
 */
class Report extends My_Controller
{

    private $record_per_page = 20;
    private $record_num_links = 5;
   
    public function __construct()
    {
        parent::__construct();

        $this->data['module_name'] = "Service Management Information";

        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */
        $this->load->helper('utility_helper');

        $this->load->model('sm/Mod_report');
        $this->load->model('sm/Mod_common');
        $this->load->model('sm/MedicalDep');

        $this->data['year_array']  = $this->common_lib->get_year_array();
        $this->data['month_array'] = $this->common_lib->get_month_array();
        $this->data['day_array']   = $this->common_lib->get_day_array();


        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }


    }


    function service_eng_wise_list()
    {
        $this->data['title'] = "Service Eng Wise List";

        $this->data['service_engineer_list'] = $this->Mod_common->get_service_engineer_array();
        $this->data['support_type_list']     = $this->Mod_report->get_support_type_list();
        $this->data['priority_list']         = $this->Mod_report->get_priority_list();

        /*  for pagination */
        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $this->data['record'] = $this->Mod_report->get_service_engineer_list(30, $row);


        $config['per_page']    = '30';
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/report/service_eng_wise_list/';
        $config['total_rows']  = $this->Mod_report->service_engineer_total_rows();                  /*  for get table total rows number */

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

        $this->load->view('sm/report/view_service_eng_wise_list', $this->data);

    }

    function service_eng_wise_list_search()
    {

        $search                              = '';
        $searchUrl                           = '';
        $config                              = '';
        $this->data['service_engineer_list'] = $this->Mod_common->get_service_engineer_array();
        $this->data['support_type_list']     = $this->Mod_report->get_support_type_list();
        $this->data['priority_list']         = $this->Mod_report->get_priority_list();


        /* Start search page pagination */
        $row            = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }
        $name      = trim($this->security->xss_clean($this->input->post('name')));  /* get search field name */
        $code      = trim($this->security->xss_clean($this->input->post('code')));
        $dob_year  = trim($this->security->xss_clean($this->input->post('dob_year')));
        $dob_month = trim($this->security->xss_clean($this->input->post('dob_month')));
        $date_from = trim($this->security->xss_clean($this->input->post('date_from')));
        $date_to   = trim($this->security->xss_clean($this->input->post('date_to')));
        $status    = trim($this->security->xss_clean($this->input->post('status')));

        $sess_and_arry = array(
            'name'      => $name,
            'code'      => $code,
            'dob_year'  => $dob_year,
            'dob_month' => $dob_month,
            'date_from' => $date_from,
            'date_to'   => $date_to,
            'status'    => $status,
            'search'    => TRUE
        );

        $this->session->set_userdata($sess_and_arry);

        $results = $this->Mod_report->search_service_eng_list(30, $row);

        $config   = [];
        $config['per_page']    = '30';
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/report/service_eng_wise_list_search/';
        $config['total_rows']  = $this->Mod_report->count_search_service_eng_record();                  /*  for get table total rows number */

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
        //print_r($this->data['search'] );exit;
        $this->load->view('sm/report/view_service_eng_wise_list_search', $this->data);

    }


    function customer_wise_list()
    {
        $this->data['title']         = "Customer Wise List";
        $this->data['department']    = $this->MedicalDep->get_all_status_wise();
        $this->data['customer_list'] = $this->Mod_common->get_customer_array_dropdown();

        $this->data['support_type_list'] = $this->Mod_report->get_support_type_list();
        $this->data['priority_list']     = $this->Mod_report->get_priority_list();


        /*  for pagination */
        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $this->data['record'] = $this->Mod_report->get_customer_list(30, $row);


        $config['per_page']    = '30';
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/report/customer_wise_list/';
        $config['total_rows']  = $this->Mod_report->customer_total_rows();                  /*  for get table total rows number */

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

        $this->load->view('sm/report/view_customer_wise_list', $this->data);
    }

    function customer_wise_list_search()
    {

        $search    = '';
        $searchUrl = '';
        $config    = [];

        $this->data['department']    = $this->MedicalDep->get_all_status_wise();
        $this->data['customer_list']     = $this->Mod_common->get_customer_array_dropdown();
        $this->data['support_type_list'] = $this->Mod_report->get_support_type_list();
        $this->data['priority_list']     = $this->Mod_report->get_priority_list();

        /* Start search page pagination */
        $row            = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }
        $name       = trim($this->security->xss_clean($this->input->post('name')));  /* get search field name */
        $code       = trim($this->security->xss_clean($this->input->post('code')));
        $dob_year   = trim($this->security->xss_clean($this->input->post('dob_year')));
        $dob_month  = trim($this->security->xss_clean($this->input->post('dob_month')));
        $date_from  = trim($this->security->xss_clean($this->input->post('date_from')));
        $date_to    = trim($this->security->xss_clean($this->input->post('date_to')));
        $status     = trim($this->security->xss_clean($this->input->post('status')));
        $department = trim($this->security->xss_clean($this->input->post('department')));

        $sess_and_arry = array(
            'name'       => $name,
            'code'       => $code,
            'dob_year'   => $dob_year,
            'dob_month'  => $dob_month,
            'date_from'  => $date_from,
            'date_to'    => $date_to,
            'status'     => $status,
            'department' => $department,
            'search'     => TRUE
        );

        $this->session->set_userdata($sess_and_arry);

        $this->data['search'] = $this->Mod_report->search_customer_list(30, $row);

//print_r($this->data['search'] );exit;
        $config['per_page']    = '30';
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/report/customer_wise_list_search/';
        $config['total_rows']  = $this->Mod_report->count_search_customer_record();                  /*  for get table total rows number */

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


        $this->load->view('sm/report/view_customer_wise_list_search', $this->data);
    }


    function ajax_get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url     = base_url() . 'sm/customer/';
        $options = $this->Mod_common->get_disrict_list_by_div($division_id, $url);
        echo $options;
    }

    function ajax_get_upazila()
    {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));
        $options     = $this->Mod_common->get_upazila_list_by_dis($district_id);
        echo $options;
    }


    function view()
    {
        $auto_id     = $this->uri->segment(3);
        $get_details = $this->Mod_manager->get_details($auto_id);

        $this->data['res'] = $get_details;
        $this->load->view('manager/view_list_manager', $this->data);
    }


}
