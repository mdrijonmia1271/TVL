<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of my_controller
 * Custom Controller that check user logedin/authentication status
 */
class My_Controller extends CI_Controller{
    public function __construct() {
       parent::__construct();
	   
//        if ($this->session->userdata('is_login')== false){
//            redirect('sm/home/page');
//        }        
    }
}
