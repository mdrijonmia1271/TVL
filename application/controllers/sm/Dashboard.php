<?php

/**
 * Description of Dashboard
 *
 * @author iPLUS DATA
 * Date : 22-October-2016

* @property Mod_admin $Mod_admin
 *
 */


class Dashboard extends My_Controller {

    private $record_per_page = 20;
    private $record_num_links = 5;

    public function __construct() {
        parent::__construct();
        $this->load->model('sm/Mod_admin');
        $this->load->model('sm/Mod_common');
        $this->load->model('sm/Mod_engineer');
        $this->load->model('sm/Mod_customer');
        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');
        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');            
        }
        $this->data['year_array'] = $this->common_lib->get_year_array();
    }

    function index() {
         $sess_customer = $this->session->userdata('is_customer_login');
         $sess_engineer = $this->session->userdata('is_engineer_login');
         $sess_admin = $this->session->userdata('is_admin_login');
         
            if($sess_customer){
                //redirect('sm/dashboard/customer');
                redirect('sm/ticket/records');
            }else if($sess_engineer){
                //redirect('sm/dashboard/engineer');
                redirect('sm/serviceengineer/records');
            }else if($sess_admin){
                redirect('sm/dashboard/admin');
            }
    }
    
    function admin() {
        //$this->output->cache(5); //cache admin dashboard for 5min
        
         if($this->session->userdata('root_admin') == "no") {  //only supper admin can access dashboard
             redirect('sm/manager/ticketlist');
         }
         
        $this->data['customer_list_for_dashboard'] = $this->Mod_admin->get_customer_list_for_dashboard();

        $this->data['total_ticket_list_dashboard_notice'] = $this->Mod_admin->get_total_ticket_list_admin_dashboard_notice();

        $this->data['total_ticket_list_pending'] = $this->Mod_admin->get_status_wise_total_ticket_list_for_admin('P');
        $this->data['total_ticket_list_working'] = $this->Mod_admin->get_status_wise_total_ticket_list_for_admin('W');
        $this->data['total_ticket_list_progress'] = $this->Mod_admin->get_status_wise_total_ticket_list_for_admin('O');
        $this->data['total_ticket_list_approve'] = $this->Mod_admin->get_status_wise_total_ticket_list_for_admin('A');
        $this->data['total_ticket_list_cancel'] = $this->Mod_admin->get_status_wise_total_ticket_list_for_admin('C');

        $this->data['ticket_list_daily_pending'] = $this->Mod_admin->get_status_wise_ticket_list_daily_for_admin('P');
        $this->data['ticket_list_daily_working'] = $this->Mod_admin->get_status_wise_ticket_list_daily_for_admin('W');
        $this->data['ticket_list_daily_progress'] = $this->Mod_admin->get_status_wise_ticket_list_daily_for_admin('O');
        $this->data['ticket_list_daily_approve'] = $this->Mod_admin->get_status_wise_ticket_list_daily_for_admin('A');
        $this->data['ticket_list_daily_cancel'] = $this->Mod_admin->get_status_wise_ticket_list_daily_for_admin('C');

        $this->data['ticket_list_monthly_pending'] = $this->Mod_admin->get_status_wise_ticket_list_monthly_for_admin('P');
        $this->data['ticket_list_monthly_working'] = $this->Mod_admin->get_status_wise_ticket_list_monthly_for_admin('W');
        $this->data['ticket_list_monthly_progress'] = $this->Mod_admin->get_status_wise_ticket_list_monthly_for_admin('O');
        $this->data['ticket_list_monthly_approve'] = $this->Mod_admin->get_status_wise_ticket_list_monthly_for_admin('A');
        $this->data['ticket_list_monthly_cancel'] = $this->Mod_admin->get_status_wise_ticket_list_monthly_for_admin('C');

        $this->load->view('sm/admin/view_admin_dashboard', $this->data);
    }

    public function customer_list(){
        $config = [];

        /*  for pagination */
        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $this->data['customer_list_summary'] = $this->Mod_admin->get_all_customer_list_summary(16, $row);

        $config['per_page']    = '8';
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/dashboard/customer_list/';
        $config['total_rows']  = $this->Mod_admin->customer_total_rows();

//        echo '<pre>';
//        print_r($this->data['customer_list_summary']);
//        exit;

        $page_config = get_pagination_paramter();

        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];

        $this->load->view('sm/admin/view_customar_summary', $this->data);
    }
    
    function engineer() {
        //$this->output->cache(5); //cache admin engineer for 5min
        
        $this->data['total_ticket_list_dashboard_notice'] = $this->Mod_engineer->get_total_ticket_list_ser_eng_dashboard_notice();

        $this->data['total_ticket_list_pending'] = $this->Mod_engineer->get_status_wise_total_ticket_list_for_ser_eng('P');
        $this->data['total_ticket_list_working'] = $this->Mod_engineer->get_status_wise_total_ticket_list_for_ser_eng('W');
        $this->data['total_ticket_list_approve'] = $this->Mod_engineer->get_status_wise_total_ticket_list_for_ser_eng('A');
        $this->data['total_ticket_list_cancel'] = $this->Mod_engineer->get_status_wise_total_ticket_list_for_ser_eng('C');

        $this->data['ticket_list_daily_pending'] = $this->Mod_engineer->get_status_wise_ticket_list_daily_for_ser_eng('P');
        $this->data['ticket_list_daily_working'] = $this->Mod_engineer->get_status_wise_ticket_list_daily_for_ser_eng('W');
        $this->data['ticket_list_daily_approve'] = $this->Mod_engineer->get_status_wise_ticket_list_daily_for_ser_eng('A');
        $this->data['ticket_list_daily_cancel'] = $this->Mod_engineer->get_status_wise_ticket_list_daily_for_ser_eng('C');

        $this->data['ticket_list_monthly_pending'] = $this->Mod_engineer->get_status_wise_ticket_list_monthly_for_ser_eng('P');
        $this->data['ticket_list_monthly_approve'] = $this->Mod_engineer->get_status_wise_ticket_list_monthly_for_ser_eng('A');
        $this->data['ticket_list_monthly_cancel'] = $this->Mod_engineer->get_status_wise_ticket_list_monthly_for_ser_eng('C');
        
        $this->load->view('sm/engineer/view_engineer_dashboard', $this->data);        
    }
    
    function customer() {
        $this->data['total_ticket_list_dashboard_notice'] = $this->Mod_customer->get_total_ticket_list_cus_dashboard_notice();

        $this->data['total_ticket_list_pending'] = $this->Mod_customer->get_status_wise_total_ticket_list_for_cus('P');
        $this->data['total_ticket_list_working'] = $this->Mod_customer->get_status_wise_total_ticket_list_for_cus('W');
        $this->data['total_ticket_list_approve'] = $this->Mod_customer->get_status_wise_total_ticket_list_for_cus('A');
        $this->data['total_ticket_list_cancel'] = $this->Mod_customer->get_status_wise_total_ticket_list_for_cus('C');

        $this->data['ticket_list_daily_pending'] = $this->Mod_customer->get_status_wise_ticket_list_daily_for_cus('P');
        $this->data['ticket_list_daily_working'] = $this->Mod_customer->get_status_wise_ticket_list_daily_for_cus('W');
        $this->data['ticket_list_daily_approve'] = $this->Mod_customer->get_status_wise_ticket_list_daily_for_cus('A');
        $this->data['ticket_list_daily_cancel'] = $this->Mod_customer->get_status_wise_ticket_list_daily_for_cus('C');

        $this->data['ticket_list_monthly_pending'] = $this->Mod_customer->get_status_wise_ticket_list_monthly_for_cus('P');
        $this->data['ticket_list_monthly_approve'] = $this->Mod_customer->get_status_wise_ticket_list_monthly_for_cus('A');
        $this->data['ticket_list_monthly_cancel'] = $this->Mod_customer->get_status_wise_ticket_list_monthly_for_cus('C');

        $this->load->view('sm/customer/view_customer_dashboard', $this->data);        
    }

 }
    