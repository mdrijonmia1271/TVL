<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Admin
 * @author bigm
 * Date : 30-10-16
 * @property Mod_admin $Mod_admin
 */
class Login extends My_Controller
{

    private $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sm/Mod_admin');
        $this->load->model('sm/Mod_common');
        $this->load->model('sm/Mod_engineer');
        $this->load->model('sm/Mod_customer');
        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('common_lib');
        $this->load->library('session');
    }

    /*
     * admin login option
     */

    function index()
    {
        $this->load->view('sm/admin/view_login_admin', $this->data);
    }

    function admin_login()
    {
        $this->load->view('sm/admin/view_login_admin', $this->data);
    }

    /*
     * admin login process
     */

    function admin_verify_login()
    {

        $login_reset_data = array(
            'is_engineer_login' => false,
            'is_customer_login' => false
        );

        $this->session->set_userdata($login_reset_data);

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  Admin redirected to login page;
            $this->load->view('sm/admin/view_login_admin', $this->data);
        } else {
            $arr = $this->Mod_admin->validate_login();

            if ($arr['valid_login_admin'] == true) { // login OK, show the welcome page
                // $this->session->sess_destroy();
                $auto_id = $arr['admin_id'];
                $name    = $arr['name'];

                // set session data
                $login_data = array(
                    'is_login'          => true,
                    'is_admin_login'    => true,
                    'admin_auto_id'     => $auto_id,
                    'login_admin_name'  => $name,
                    'root_admin'        => $arr['root_admin'],
                    'admin_user_type'   => $arr['admin_user_type'],
                    'assinged_customer' => $arr['assinged_customer']
                );

                //$this->session->set_flashdata('login_msg', 'success');
                $this->session->set_userdata($login_data);

                if ($arr['root_admin'] == "yes") {
                    redirect('sm/dashboard/admin');
                } elseif ($arr['admin_user_type'] == 'marketing') {

                    redirect('sm/customer/notification');
                } else {
                    redirect('sm/manager/ticketlist');
                }

            } else { // login  failed
                $this->session->set_flashdata('login_msg', 'UserName or Password did not match');
                redirect('sm/login/admin_login');
            }
        }
    }

    /*
     * admin logout
     */

    function admin_logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }

    /*
     * engineer login option
     */

    function eng_login()
    {

        $this->load->view('sm/engineer/view_login_engineer', $this->data);
    }

    /*
     * engineer login process
     */

    function eng_verify_login()
    {
        $login_reset_data = array(
            'is_admin_login'    => false,
            'is_customer_login' => false
        );

        $this->session->set_userdata($login_reset_data);

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  engineer redirected to login page;
            $this->load->view('sm/engineer/view_login_engineer', $this->data);
        } else {
            $arr = $this->Mod_engineer->validate_login();

            if ($arr['valid_login_engineer'] == true) { // login OK, show the welcome page
                //$this->session->sess_destroy();
                $auto_id = $arr['engineer_id'];
                $mobile  = $this->security->xss_clean($this->input->post('mobile'));
                // set session data
                $login_data = array(
                    'is_login'             => true,
                    'is_engineer_login'    => true,
                    'engineer_auto_id'     => $auto_id,
                    'login_engineer_phone' => $mobile
                );

                $this->session->set_userdata($login_data);
                $this->session->set_flashdata('login_msg', 'success');
                //redirect('sm/dashboard/engineer');
                redirect('sm/serviceengineer/records');
            } else { // login  failed
                $this->session->set_flashdata('login_msg', 'Mobile number or Password did not match');
                redirect('sm/login/eng_login');
            }
        }
    }

    /*
     * engineer logout
     */

    function eng_logout()
    {
        $login_data = array(
            'is_login'             => false,
            'is_engineer_login'    => false,
            'engineer_auto_id'     => '',
            'login_engineer_phone' => ''
        );
        $this->session->set_userdata($login_data);
        $this->session->sess_destroy();
        redirect('sm/login/eng_login');
    }

    /*
     * customer login option
     */

    function customer_login()
    {

        $this->load->view('sm/customer/view_login_customer', $this->data);
    }

    /*
     * customer login process
     */

    function customer_verify_login()
    {
        $login_reset_data = array(
            'is_admin_login'    => false,
            'is_engineer_login' => false
        );

        $this->session->set_userdata($login_reset_data);

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  Customer redirected to login page;
            $this->load->view('sm/customer/view_login_customer', $this->data);
        } else {
            $arr = $this->Mod_customer->validate_login();

            if ($arr['valid_login_customer'] == true) { // login OK, show the welcome page
                // $this->session->sess_destroy();
                $auto_id = $arr['customer_id'];
                $name    = $arr['name'];
                $mobile  = $this->security->xss_clean($this->input->post('mobile'));

                // set session data
                $login_data = array(
                    'is_login'             => true,
                    'is_customer_login'    => true,
                    'customer_auto_id'     => $auto_id,
                    'login_customer_phone' => $arr['mobile'],
                    'customer_name'        => $name
                );
                if (isset($arr['sub_customer_id'])) {
                    $login_data['sub_customer_id'] = $arr['sub_customer_id'];
                }

                $this->session->set_userdata($login_data);
                $this->session->set_flashdata('login_msg', 'success');
                //redirect('sm/dashboard/customer');
                //redirect('sm/ticket/records');
                redirect('sm/customer/view');
            } else { // login  failed
                $this->session->set_flashdata('login_msg', 'Mobile number or Password did not match');
                redirect('sm/login/customer_login');
            }
        }
    }

    /*
     * customer logout
     */

    function customer_logout()
    {
        $this->session->sess_destroy();
        redirect('sm/login/customer_login');
    }

}
