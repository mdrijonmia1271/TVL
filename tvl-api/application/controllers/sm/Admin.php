<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');
/**
 * Description of Admin
 * @author iplustraining
 * Date : 30-10-16
 */
class Admin extends My_Controller{

    private $record_per_page = 20;
    private $record_num_links = 5;
    private $data = '';
         
    public function __construct() {
        parent::__construct();
                          
        $this->load->model('sm/Mod_admin');
        $this->load->model('sm/Mod_common');
        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */
        
        if ($this->session->userdata('is_login') != true || $this->session->userdata('root_admin') == "no") { //only supper admin can access
            redirect('sm/home');            
        }        

        //$this->load->plugin('dhtmlgoodies_calendar');
        $this->data['cust_status_type'] = $this->common_lib->cust_status_type_array();
        $this->data['year_array'] = $this->common_lib->get_year_array();
        $this->data['month_array'] = $this->common_lib->get_month_array();
        $this->data['day_array'] = $this->common_lib->get_day_array();
        $this->data['has_email_phone_array'] = $this->common_lib->cust_has_email_phone_array();        
    }
    
    function index(){
        $this->data['division_list'] = $this->Mod_common->get_division_list();
        
        $this->data['designation_list'] = $this->Mod_common->get_designation_array();
        $this->data['department_list'] = $this->Mod_common->get_department_array();
                    
        $this->load->view('sm/admin/view_create_admin',$this->data);
            
    }


  
      function save() {

        $this->data['division_list'] = $this->Mod_common->get_division_list();
        
        $this->data['designation_list'] = $this->Mod_common->get_designation_array();
        $this->data['department_list'] = $this->Mod_common->get_department_array();
        
        
        $this->form_validation->set_rules('firstname', 'Firstname', 'required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required');
        $this->form_validation->set_rules('ser_eng_code', 'Admin Engineer Code', 'required');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('telephone_no', 'telephone_no', 'required');

        $this->form_validation->set_rules('department', 'department', 'required');
        $this->form_validation->set_rules('designation', 'designation', 'required');

//        $this->form_validation->set_rules('contact_add_details', 'Address', 'required');
//        $this->form_validation->set_rules('contact_add_division', 'Division', 'required');
//        $this->form_validation->set_rules('contact_add_district', 'District', 'required');
//        $this->form_validation->set_rules('contact_add_upazila', 'Upazila', 'required');


        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_admin->save_data();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'admin created successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to create admin');
            }
            redirect('sm/admin/index');
        } else {
            $this->load->view('sm/admin/view_create_admin', $this->data);
        }
    }

    function ajax_get_district() {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url = base_url() . 'sm/admin/';
        $options = $this->Mod_common->get_disrict_list_by_div($division_id, $url);
        echo $options;
    }

    function ajax_get_upazila() {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));
        $options = $this->Mod_common->get_upazila_list_by_dis($district_id);
        echo $options;
    }

    function records() {
        $this->data['title'] = "Admin List";
        $this->data['division_list'] = $this->Mod_common->get_division_list();
        $this->data['designation_list'] = $this->Mod_common->get_designation_array();
        $this->data['department_list'] = $this->Mod_common->get_department_array();
        
        
        
        $row = 0;
        $temp_record_postion = $this->uri->segment(4);

        if (!empty($temp_record_postion)) {
            $row = $temp_record_postion;
        }

        $config['base_url'] = base_url() . 'sm/admin/records';
        $config['per_page'] = $this->record_per_page;
        $config['num_links'] = $this->record_num_links;
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config);


        $this->data['record_pos'] = $row;
        $this->data['total_rows'] = $this->Mod_admin->service_engineer_total_rows();

        $this->data['links'] = $this->pagination->create_links();
        $this->data['record'] = $this->Mod_admin->get_service_engineer_list($this->record_per_page, $row);
        $this->load->view('sm/admin/view_admin_list', $this->data);
    }
    function paging() {
        $row = 0;
        $temp_record_postion = $this->uri->segment(3);
        
        if(!empty ($temp_record_postion)){
            $row = $temp_record_postion;
        }
        
        $config['base_url'] = base_url().'admin/paging';        
        $config['total_rows'] = $this->Mod_admin->count_records();
        $config['per_page'] =  $this->record_per_page;
        $config['num_links'] = $this->record_num_links;
        
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config);
        
        $this->data['record_pos'] = $row;
        $this->data['total_rows'] = $this->Mod_admin->count_records();
        $this->data['links']=$this->pagination->create_links();  
          
        $this->data['rec'] = $this->Mod_admin->get_records($this->record_per_page,$row);
        $this->load->view('admin/view_admin_list',$this->data);
    }

    function edit() {
        $auto_id =  $this->uri->segment(3);
        $get_details =  $this->Mod_admin->get_details($auto_id);
        
        $this->data['res'] = $get_details;
        $this->load->view('admin/view_edit_admin',$this->data);      
    }

    

    function search(){
        
        $search = '';
        $searchUrl = '';
        $config = [];
      
        /* Start search page pagination */
        $row = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        } 
        $name= trim($this->security->xss_clean($this->input->post('name')));  /* get search field name */     
        $email = trim($this->security->xss_clean($this->input->post('email')));
        $mobile = trim($this->security->xss_clean($this->input->post('mobile')));
        $status = trim($this->security->xss_clean($this->input->post('status')));
        
               $sess_and_arry = array(
                'name' => $name,
                'email' =>  $email,
                'mobile' =>  $mobile,
                'status' =>  $status,
                'search' => TRUE
            );

        $this->session->set_userdata($sess_and_arry);

        $results = $this->Mod_admin->search_all_list(1, $row);
       
        $config['per_page'] = '1';
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/admin/records/';
        $config['total_rows'] = $this->Mod_admin->count_search_record();                  /*  for get table total rows number */
		
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
       $this->load->view('sm/admin/view_admin_list_search', $this->data);
    }
    
   
    
    }