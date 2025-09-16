<?php
/**
 * Created by PhpStorm.
 * User: BIGM
 * Date: 9/25/2018
 * Time: 2:31 PM
 */

class Privacy_policy extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function index(){

        $this->load->view('sm/privacy/view_privacy_policy');
    }


}