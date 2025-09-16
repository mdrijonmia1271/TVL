<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');

/**
 * Description of home
 * @author iplustraining
 * Date : 30-10-16
 */
class Home extends CI_Controller {  

        public function __construct() {
        parent::__construct();
             
        $this->data['module_name']= "Admin Information";
             
        $this->load->model('sm/Mod_common');
        $this->load->library('common_lib');      /*  load pagination library */
        $this->load->helper('utility_helper');
        
        }
    
    
    
    public function index() {
        print_r(send_push_notification("e_c7Fw43TaOrDVsLwvXBon:APA91bHvQooMVR0VmgBK2ZrqPkce4WRMATvX6XyIqB_dEO_j5igPD9zkst9sfAHvlM-U0QK6TRP1ecofftUL6OFMlXIUKssuTv1u5gNQpGQLZSan0DcNvd6flKCVOGnCsDTVjlvdPhvA", "This is Test message", "Hello world", ['status' => true]));
        die();
        $this->load->view('sm/home/view_homepage');
    }
    
    
    public function testpage() {

     $this->load->view('sm/home/view_home');
    }

    function errorpage() {
       $this->load->view('sm/home/view_error404');
    }

    
    function logout() {

        $this->session->unset_userdata('is_login');
        $this->session->unset_userdata('is_admin_login');
        $this->session->unset_userdata('is_customer_login');
        $this->session->unset_userdata('is_engineer_login');
        
        redirect('sm/home/page');
    }
    
    function page() {
        $this->load->view('sm/home/view_homepage');
    }
    
    
    
    public function pagetest() {

        $this->load->view('sm/home/view_page');
    }

}
