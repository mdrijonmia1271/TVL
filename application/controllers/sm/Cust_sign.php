<?php
/**
 * Created by PhpStorm.
 * User: Manjurul
 * Date: 5/13/2018
 * Time: 12:15 AM
 */


/**
 * Class Cust_sign
 * @property Mod_sign_up $Mod_sign_up
 */
class Cust_sign extends My_Controller
{
    protected $response;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('sm/Mod_sign_up');
        $this->load->model('sm/Mod_common');
        $this->load->model('sm/Mod_install');

        $this->response = [
            'status'      => 'Failed',
            'status_code' => 404,
            'data'        => '',
            'msg'         => '',
        ];
    }


    public function index()
    {
        $this->load->model('sm/Mod_install');
        $this->load->model('sm/MedicalDep');

        $data['division_list'] = $this->Mod_common->get_division_list();
        $data['customer_list'] = (['' => 'Select Client/Customer'] + $this->Mod_sign_up->get_customer_list());
        $data['machine']    = $this->Mod_install->get_machine_data();
        $data['support']    = $this->Mod_install->get_support_type();
        $data['business']   = $this->Mod_install->get_business_area();
        //$data['serial']     = $this->Mod_install->get_serial();
        $data['department'] = $this->MedicalDep->get_all_status_wise();
        //dd($data);
        $this->load->view('sm/sign_up/view_sign_up', $data);
    }


    public function save()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cMobile', 'Mobile Number', 'required|is_unique[customer_sub_login.phone]|is_unique[customer.mobile]|is_unique[sm_admin.mobile]|is_unique[sm_service_engineer.mobile]|integer|max_length[11]');
        $this->form_validation->set_rules('cUsername', 'Username', 'required|is_unique[customer_sub_login.username]|max_length[40]');
        $this->form_validation->set_rules('cPass', 'Password', 'required|min_length[6]|max_length[16]');
        $this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[cPass]');
        $this->form_validation->set_rules('cEmail', 'Email', 'required|valid_email|is_unique[customer_sub_login.email]|is_unique[customer.email]');
        $this->form_validation->set_rules('cUsername', 'Username', 'required|max_length[20]');
        $this->form_validation->set_rules('machine', 'Machine', 'required|integer');
        $this->form_validation->set_rules('dep_ref_id', 'Department', 'required|integer');
        $this->form_validation->set_rules('bArea', 'Area', 'required|integer');
        $this->form_validation->set_rules('mcSrial', 'Serial', 'required|integer');

        $this->_validate();

        if ($_POST && $this->form_validation->run()) {
            $datetime = date('Y-m-d H:i:s');

            //======= customer basic info ========
            $cName    = $this->input->post('cName');
            $cUsername= $this->input->post('cUsername');
            $cMobile  = $this->input->post('cMobile');
            $cEmail   = $this->input->post('cEmail');
            $password = $this->input->post('cPass');
            $confirm  = $this->input->post('confirm');

            //======== Machine Details ========
            $machine   = $this->input->post('machine');
            $dep_ref_id = $this->input->post('dep_ref_id');
            $bArea  = $this->input->post('bArea');
            $sector = $this->input->post('sector');
            $mcSrial = $this->input->post('mcSrial');
            $otp = random_num();

            $username_exist = $this->Mod_sign_up->check_username($cUsername);

            if ($username_exist == 1) {
                $data['inputerror'][]   = 'cUsername';
                $data['error_string'][] = 'Username Already Exist';
                $data['status']         = FALSE;
                echo json_encode($data);
                exit();
            } elseif ($password != $confirm) {
                $data['inputerror'][]   = 'confirm';
                $data['error_string'][] = 'Password Do Not Match';
                $data['status']         = FALSE;
                echo json_encode($data);
                exit();
            } else {

                $data = array(
                    'customer_id'          => $cName,
                    'username'             => $cUsername,
                    'password'             => md5($confirm),
                    'email'                => $cEmail,
                    'phone'                => $cMobile,
                    'created_at'           => $datetime,
                    'otp_pass'             => $otp,
                    'login_token_id'       => md5(random_num())
                );


                $insert_id = $this->Mod_sign_up->save_data($data, 'customer_sub_login');
                if ($insert_id) {
                    $data['password'] = $confirm;

                    // CUSTOMER SUCCESS SIGNUP MESSAGE
                    $message_details = get_temp_details('SIGNUP');
                    if ($message_details) {
                        $msg = message_format($message_details->message, $data);
                        send_sms($cMobile, $msg);
                    }

                    $machine_details = [
                        'insb_customer'         => $cName,
                        'dep_ref_id'            => $dep_ref_id,
                        'insb_business_area'    => $bArea,
                        'insb_sector'           => $sector,
                        'insb_machine'          => $machine,
                        'insb_serial'           => $mcSrial,
                        'status'                => '1',
                        'support_type'          => '4',
                        'customer_id_sub'       => $insert_id
                    ];

                    $install_base_id = $this->Mod_install->save_install_base($machine_details);
                    if (!empty($_FILES['picture']['name'])) {
                        $picture                  = $this->_do_upload_machine($install_base_id);
                        $upload_images['picture'] = $picture;
                        $this->db->update('install_base', $upload_images, array('insb_id' => $install_base_id));
                    }

                    $datetime = date('Y-m-d H:i:s');
                    $support_type = array(
                        'su_type_id'          => '4',
                        'su_cust_ref_id'      => $cName,
                        'su_machine_id'       => $machine,
                        'install_base_ref_id' => $install_base_id,
                        'status'              => '1',
                        'created'             => $datetime
                    );
                    $this->Mod_install->save_insb_support_type($support_type);

                }

            }

            echo json_encode(array("status" => TRUE));
        } else {
            foreach ($this->form_validation->error_array() as $field => $message) {
                $data['inputerror'][]   = $field;
                $data['error_string'][] = $message;
            }
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }

    }


    function ajax_get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url     = base_url() . 'sm/cust_sign/';
        $options = $this->Mod_common->get_disrict_list_by_div($division_id, $url);
        echo $options;
    }

    function ajax_get_upazila()
    {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));
        $options     = $this->Mod_common->get_upazila_list_by_dis($district_id);
        echo $options;
    }


    private function _do_upload($master_insert_id, $my_real_file_name)
    {


        $structure = './upload/customer_image/' . $master_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }


        $config['upload_path']   = $structure;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 2200;
        $config['file_name']     = $my_real_file_name;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('cPhoto')) //upload and validate
        {
            $data['inputerror'][]   = 'cPhoto';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status']         = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    private function _do_upload_machine($master_insert_id)
    {


        $structure = './upload/install_base/' . $master_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }


        $config['upload_path']   = $structure;
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
        $config['max_size']      = 2200;
        $config['encrypt_name']  = true;
        $config['overwrite']     = false;

        $this->load->library('upload', $config);
        $this->load->initialize($config);

        if (!$this->upload->do_upload('picture')) //upload and validate
        {
            $data['inputerror'][]   = 'insReport';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status']         = FALSE;
            echo json_encode($data);
            exit();
        }

        return $this->upload->data('file_name');
    }


    //================= otp verify page =========
    public function verify()
    {
        $this->load->view('sm/sign_up/view_otp_verify');
    }

    public function otp_verify()
    {
        if ($_POST) {

            $this->otp_validate();
            $cMobile = $this->input->post('cMobile');
            $otp     = $this->input->post('otp');

            $mobile_exist = $this->Mod_sign_up->check_exist($cMobile, $otp);


            if ($mobile_exist) {
                $this->response['status'] = true;

                // SIGNUP SUCCESS MESSAGE
                $message_details = get_temp_details('SIGNUP_SUCCESS');
                if ($message_details) {
                    $msg = message_format($message_details->message, (array) $mobile_exist);
                    send_sms($cMobile, $msg);
                }

                // ADMIN APPROVAL MESSAGE
                $message_details = get_temp_details('USER_APPROVAL_ADMIN');
                $message_details_number = get_temp_details('USER_APPROVAL_NUMBER');
                if ($message_details && $message_details_number) {
                    $msg = message_format($message_details->message, []);
                    send_sms($message_details_number->message, $msg);
                }

                $this->Mod_sign_up->check_exist($cMobile, $otp, 'verified');
            } else {

                $this->response['status'] = false;
                $this->response['msg']    = 'Mobile number and OTP does not match ';
            }
        }

        echo json_encode($this->response);
    }


    private function otp_validate()
    {

        $data                 = [];
        $data['error_string'] = [];
        $data['inputerror']   = [];
        $data['status']       = TRUE;

        $mobile = $this->input->post('cMobile');
        $otp    = $this->input->post('otp');

        if ($mobile == '' || (!empty($mobile) && !ctype_digit(strval($mobile)))) {
            $data['inputerror'][]   = 'cMobile';
            $data['error_string'][] = 'Type a valid mobile number';
            $data['status']         = FALSE;
        }

        if ($otp == '') {
            $data['inputerror'][]   = 'otp';
            $data['error_string'][] = 'OTP is required';
            $data['status']         = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }


    //===================== validation ==========================

    private function _validate()
    {
        $data                 = array();
        $data['error_string'] = array();
        $data['inputerror']   = array();
        $data['status']       = TRUE;

        if ($this->input->post('cName') == '') {
            $data['inputerror'][]   = 'cName';
            $data['error_string'][] = 'Name is required';
            $data['status']         = FALSE;
        }

        $email = $this->input->post('cEmail');
        if ($email == '') {
            $data['inputerror'][]   = 'cEmail';
            $data['error_string'][] = 'Email is required';
            $data['status']         = FALSE;
        } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $data['inputerror'][]   = 'cEmail';
            $data['error_string'][] = 'Type valid email address';
            $data['status']         = FALSE;

        }

        $int = $this->input->post('cMobile');

        if ($this->input->post('cMobile') == '') {
            $data['inputerror'][]   = 'cMobile';
            $data['error_string'][] = 'Type a valid mobile number';
            $data['status']         = FALSE;
        } elseif (!empty($int) && !ctype_digit(strval($int))) {
            $data['inputerror'][]   = 'cMobile';
            $data['error_string'][] = 'Mobile Number Only Integer';
            $data['status']         = FALSE;
        }


        //========================================


        $password = $this->input->post('cPass');
        $confirm  = $this->input->post('confirm');

        if ($password == '') {
            $data['inputerror'][]   = 'cPass';
            $data['error_string'][] = 'Password is required';
            $data['status']         = FALSE;
        }

        if ($confirm == '') {
            $data['inputerror'][]   = 'confirm';
            $data['error_string'][] = 'Confirm your password';
            $data['status']         = FALSE;
        }

        //======================================

        /*if ($this->input->post('cFlat') == '') {
            $data['inputerror'][] = 'cFlat';
            $data['error_string'][] = 'Please type your address info';
            $data['status'] = FALSE;
        }

        if ($this->input->post('cRoad') == '') {
            $data['inputerror'][] = 'cRoad';
            $data['error_string'][] = 'Please type road or sector no';
            $data['status'] = FALSE;
        }*/


//        if ($this->input->post('cPost') == '') {
//            $data['inputerror'][]   = 'cPost';
//            $data['error_string'][] = 'Please type post office info';
//            $data['status']         = FALSE;
//        }
//
//        if ($this->input->post('cPCode') == '') {
//            $data['inputerror'][]   = 'cPCode';
//            $data['error_string'][] = 'Post Code is required';
//            $data['status']         = FALSE;
//        }
//        if ($this->input->post('contact_add_division') == '') {
//            $data['inputerror'][]   = 'contact_add_division';
//            $data['error_string'][] = 'Please select division';
//            $data['status']         = FALSE;
//        }
//        if ($this->input->post('pName') == '') {
//            $data['inputerror'][]   = 'pName';
//            $data['error_string'][] = 'Name is required';
//            $data['status']         = FALSE;
//        }
//        if ($this->input->post('pDes') == '') {
//            $data['inputerror'][]   = 'pDes';
//            $data['error_string'][] = 'Designation is required';
//            $data['status']         = FALSE;
//        }
//
//        $pemail = $this->input->post('pEmail');
//
//        if ($pemail == '') {
//            $data['inputerror'][]   = 'pEmail';
//            $data['error_string'][] = 'Email is required';
//            $data['status']         = FALSE;
//        } elseif (!empty($pemail) && !filter_var($pemail, FILTER_VALIDATE_EMAIL)) {
//
//            $data['inputerror'][]   = 'pEmail';
//            $data['error_string'][] = 'Type valid email address';
//            $data['status']         = FALSE;
//
//        }

        //============================================
//        $pint = $this->input->post('pMobile');
//
//        if ($pint == '') {
//            $data['inputerror'][]   = 'pMobile';
//            $data['error_string'][] = 'Mobile Number is required';
//            $data['status']         = FALSE;
//        } elseif (!empty($pint) && !ctype_digit(strval($pint))) {
//            $data['inputerror'][]   = 'pMobile';
//            $data['error_string'][] = 'Mobile Number Only Integer';
//            $data['status']         = FALSE;
//        }
        //=============================================

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

// =================== forgot password ===========================

    public function forgot()
    {
        $this->load->view('sm/sign_up/view_forgot_pass');
    }


    public function forgot_pass()
    {

        if ($_POST) {

            $this->_validate_pass();

            $data     = array();
            $mobile   = $this->input->post('mobile');
            $new_pass = $this->input->post('nPass');
            $confirm  = $this->input->post('cPass');

            $mobile_exist = $this->Mod_sign_up->mobile_exists($mobile);

            if ($mobile_exist == true) {

                $pass['password'] = $new_pass;

                $this->Mod_sign_up->update_password(array('mobile' => $mobile), $pass);
                $data['status'] = TRUE;
            } else {
                $data['inputerror'][]   = 'mobile';
                $data['error_string'][] = 'Type your registered mobile number';
                $data['status']         = FALSE;
                exit();
            }


            echo json_encode($data);


        }


    }


    private function _validate_pass()
    {

        $data                 = array();
        $data['error_string'] = array();
        $data['inputerror']   = array();
        $data['status']       = TRUE;


        $int = $this->input->post('mobile');

        if ($this->input->post('mobile') == '') {
            $data['inputerror'][]   = 'mobile';
            $data['error_string'][] = 'Mobile Number is required';
            $data['status']         = FALSE;
        } elseif (!empty($int) && !ctype_digit(strval($int))) {
            $data['inputerror'][]   = 'mobile';
            $data['error_string'][] = 'Mobile Number Only Integer';
            $data['status']         = FALSE;
        }


        //========================================


        $password = $this->input->post('nPass');
        $confirm  = $this->input->post('cPass');

        if ($password == '') {
            $data['inputerror'][]   = 'nPass';
            $data['error_string'][] = 'Password is required';
            $data['status']         = FALSE;
        }

        if ($confirm == '') {
            $data['inputerror'][]   = 'cPass';
            $data['error_string'][] = 'Confirm your password';
            $data['status']         = FALSE;
        }

        if ($password != $confirm) {
            $data['inputerror'][]   = 'cPass';
            $data['error_string'][] = 'Confirm Password Not Match';
            $data['status']         = FALSE;
        }


        //=============================================

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }


}