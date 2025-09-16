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

     $this->load->view('sm/home/view_landing');
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
