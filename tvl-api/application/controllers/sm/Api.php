<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Description of Api
 *
 * @author Mhabub
 * @property Mod_api $Mod_api
 * @property Mod_ticket $Mod_ticket
 */
class Api extends CI_Controller
{

    private   $customer_token_id = null;
    protected $response;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('M_pdf');
        $this->load->library('form_validation');
        $this->load->model('sm/Mod_api');
        $this->load->model('sm/Mod_ticket');
        $this->customer_token_id = $this->security->xss_clean($this->input->post('customer_tokenid'));

        $this->response = [
            'status'      => 'Failed',
            'status_code' => 404,
            'data'        => null,
            'msg'         => '',
        ];
        header("Content-type: application/json; charset=utf-8");
    }

    /*
     api function to validate customer login request
     return: json
    */

    public function customer_login()
    {
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            $this->response['data'] = null;
            $mobile   = $this->security->xss_clean($this->input->post('mobile'));
            $password = $this->security->xss_clean($this->input->post('password'));

            $arr = $this->Mod_api->validate_customer_login($mobile, $password);

            if ($arr['customer_valid_login'] == true && $arr['customer_acc_status'] == "active") {
                $this->response['data']        = count($arr) ? $arr : null;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;
                $this->response['msg']         = 'Successfully Login';

                if (!empty($this->input->post('player_id'))) {
                    $this->Mod_api->set_player_id($arr['customer_id'], ['player_id' => $this->input->post('player_id')]);
                }

            } elseif ($arr['customer_valid_login'] == true && $arr['is_phone_number_verified'] == false) { // login OK, show the welcome page
                http_response_code(200);
                $this->response['msg']         = 'Your phone is not verified';
                $this->response['status']      = true;
                $this->response['data']        = count($arr) ? $arr : null;
                $this->response['status_code'] = 200;

            } elseif ($arr['customer_valid_login'] == true && $arr['customer_acc_status'] == "inactive") { // login OK, show the welcome page
                header('HTTP/1.1 433 In-active');
                $this->response['msg']         = 'Account is not approved. Please contact '.COMPANY_NAME.' authority';
                $this->response['status']      = false;
                $this->response['status_code'] = 433;

            } else { // login  Failed
                http_response_code(401);
                $this->response['msg']         = 'Invalid mobile or password';
                $this->response['status']      = false;
                $this->response['status_code'] = 401;

            }

        } else {
            header('HTTP/1.1 '.Required_Field_Missing.' Required Field Missing');
            $this->response['msg']         = 'Required Field Missing';
            $this->response['status']      = false;
            $this->response['status_code'] = Required_Field_Missing;

        }
        echo json_encode($this->response);
    }


    //=========================== get player id ==============

    public function set_customer_player_id()
    {

        $response    = array('status' => false, 'msg' => null);
        $customer_id = $this->input->post('customer_id');
        $player_id   = $this->input->post('player_id');


        if (!empty($customer_id && $player_id)) {

            $data['player_id'] = $player_id;

            $set_id = $this->Mod_api->set_player_id($customer_id, $data);

            if ($set_id == true) {

                $response['status'] = true;
                $response['msg']    = 'Player id set';

            } else {
                $response['status'] = false;
                $response['msg']    = 'Player id not set';
            }

        } else {
            $response['status'] = 'set player id';
        }


        echo json_encode($response);


    }


//============================== forgot password =============================
    public function forgot_password()
    {

        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[11]');

        if ($this->form_validation->run() == true) {

            $mobile = $this->input->post('phone');
            $valid  = $this->Mod_api->check_valid_mobile($mobile);

            if ($valid) {
                $random = $this->rand6();

                $this->Mod_api->store_one_time_pass($mobile, $random, $valid);

                $msg = 'আপনার ওয়ান টাইম পাসওয়ার্ড ' . $random ;
                send_sms($mobile, $msg);

                $this->response ['msg']         = 'One time password send to your mobile';
                $this->response ['status']      = true;
                $this->response ['status_code'] = 200;


            } else {

                $this->response['msg']          = "This Mobile Number is Not Exist.";
                $this->response ['status']      = false;
                $this->response ['status_code'] = 500;
            }

        } else {
            $arr                            = $this->form_validation->error_array();
            $this->response['data']         = implode(', ', array_values($arr));
            $this->response ['status']      = false;
            $this->response ['status_code'] = 500;
        }

        echo json_encode($this->response);

    }

    function rand6()
    {
        $digits = 6;
        $min    = pow(10, $digits - 1);
        $max    = pow(10, $digits) - 1;
        return mt_rand($min, $max);
    }

    public function valid_otp_pass()
    {

        $mobile = $this->input->post('mobile');
        $pass   = $this->input->post('otp_pass');

        $valid = $this->Mod_api->check_valid_otp($mobile, $pass);

        if ($valid == true) {

            $password = $this->input->post('password');
            $confirm  = $this->input->post('confirm');

            if ($password == $confirm) {

                $update = $this->Mod_api->update_pass($mobile, $password);

                if ($update == true) {

                    $this->Mod_api->blank_one_time_pass($mobile);

                    $this->response['msg']          = 'Your password has been changed successfully';
                    $this->response ['status']      = true;
                    $this->response ['status_code'] = 200;

                } else {

                    $this->response['msg']          = 'Your one time password already Expire';
                    $this->response ['status']      = false;
                    $this->response ['status_code'] = 500;
                }

            } else {

                $this->response['msg']          = 'Your confirm password not match';
                $this->response ['status']      = false;
                $this->response ['status_code'] = 500;
            }

        } else {

            $this->response['msg']          = 'Your OTP is invalid';
            $this->response ['status']      = false;
            $this->response ['status_code'] = 500;
        }

        echo json_encode($this->response);
    }

//=========================== customer sign-up =========================


    public function get_division()
    {

        $data = $this->Mod_api->get_division_list();

        echo json_encode($data);
    }

    public function get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        if (!empty($division_id)) {

            $data = $this->Mod_api->get_district_list($division_id);

            echo json_encode($data);
        }

    }

    public function get_thana()
    {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));

        if (!empty($district_id)) {
            $data = $this->Mod_api->get_thana_list($district_id);
            echo json_encode($data);
        }

    }


    public function customer_signup()
    {
        $this->form_validation->set_rules('cust_id', 'Customer ID', 'required|integer');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Mobile Number',
            'required|is_unique[customer_sub_login.phone]|is_unique[customer.mobile]|is_unique[sm_admin.mobile]|is_unique[sm_service_engineer.mobile]|integer|max_length[11]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[16]');
        $this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[password]');

        $this->form_validation->set_rules('machine_id', 'Machine', 'required|integer');
        $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
        $this->form_validation->set_rules('business_id', 'Business', 'required|integer');
        $this->form_validation->set_rules('sector', 'Sector', 'required');
        $this->form_validation->set_rules('serial', 'Serial', 'required');

        if ($this->form_validation->run() == true) {

            $insert = $this->Mod_api->save_customer_signup_info();

            if ($insert['status'] == true) {

                $datetime    = date('Y-m-d H:i:s');
                $sub_customer_id = $insert['data']['sub_cust_id'];
                $customer    = $this->Mod_api->get_by_id(['id' => $sub_customer_id], 'customer_sub_login');

                // $msg = "প্রিয় গ্রাহক, ট্রেড ভিশন লিমিটেডের পক্ষ থেকে শুভেচ্ছা। অনুগ্রহ করে আপনার অ্যাকাউন্ট যাচাই করুন ওটিপি {$customer->otp_pass} এবং সম্পূর্ণ নিবন্ধন";

                // $sms = send_sms($customer->phone, $msg);

                // if ($sms) {
                //     sms_log_write($customer->phone, $datetime);
                // }

                $data = [];
                $data['otp_pass'] = $customer->otp_pass;

                // CUSTOMER SUCCESS SIGNUP MESSAGE
                $message_details = get_temp_details('SIGNUP');
                if ($message_details) {
                    $msg = message_format($message_details->message, $data);
                    send_sms($customer->phone, $msg);
                }


                // $supervisor = $this->Mod_api->get_supervisor();
                // $supervisor_number = array_column(json_decode(json_encode($supervisor), true), "mobile");
                
                // $title   = 'A New Customer Signup';
                // $message = "একটি নতুন গ্রাহক সাইন আপ আপনার অনুমোদনের জন্য অপেক্ষা করছে। অনুগ্রহ করে এই ব্যবহারকারীকে অনুমোদন/বাতিল করুন।\nধন্যবাদ";
                // $app     = ['type' => 'engineer'];

                // if (count($supervisor_number)) {
                //     send_sms(implode(",", $supervisor_number), $message);
                // }

                // if (!empty($supervisor)) {
                //     foreach ($supervisor as $sm) {
                //         if ($sm->player_id) {
                //             send_push_notification($sm->player_id, $message, $title, $app);
                //         }
                //     }
                // }

                $this->response ['msg']    = 'You are registered.';
                $this->response ['status'] = true;
                $this->response ['data'] = $insert['data'];
                $this->response ['status_code'] = 200;

            } else {
                $this->response ['msg']    = $insert['msg'];
                $this->response ['status'] = false;
            }

        } else {
            $arr                            = $this->form_validation->error_array();
            $this->response['msg']          = implode(', ', array_values($arr));
            $this->response ['status']      = false;
            $this->response ['status_code'] = 419;
        }

        echo json_encode($this->response);

    }



    /**
     * CUSTOMER LIST FETCH BY ID AND TYPE
     * @post $cust_type example data 'customer' | 'sub_customer'
     * @return array
     */
    public function get_customer_list() {
        $customer_id = $this->security->xss_clean($this->input->get('cust_id'));
        $sub_customer_id = $this->security->xss_clean($this->input->get('sub_cust_id'));
        $customer_type = $this->security->xss_clean($this->input->get('cust_type'));
        if (!empty($customer_type)) {
            $data = $this->Mod_api->get_customer_list($customer_type, $customer_id, $sub_customer_id);
            if ($data) {
                $this->response['status'] = 'success';
                $this->response['status_code'] = 200;
                $this->response['data'] = $data;
            }
        }
        echo json_encode($this->response);
    }

    public function get_machine_list() {
        $data = $this->Mod_api->get_machine_list();
        if ($data) {
            $this->response['status'] = 'success';
            $this->response['status_code'] = 200;
            $this->response['data'] = $data;
        }
        echo json_encode($this->response);
    }

    public function get_business_area_list() {
        $data = $this->Mod_api->get_business_area_list();
        if ($data) {
            $this->response['status'] = 'success';
            $this->response['status_code'] = 200;
            $this->response['data'] = $data;
        }
        echo json_encode($this->response);
    }

    public function otp_verify()
    {
        if ($_POST) {

            $this->form_validation->set_rules('phone', 'Mobile Number', 'required');
            $this->form_validation->set_rules('otp', 'OTP Number', 'required');

            if ($this->form_validation->run() == true) {

                try {

                    $mobile_exist = $this->Mod_api->check_exist();

                    if ($mobile_exist) {
                        $cMobile = $this->input->post('phone');

                        $verified = 'verified';
                        $data    = ['otp_pass' => $verified];
                        $where   = ['phone' => $cMobile];
                        $update  = $this->Mod_api->update('customer_sub_login', $where, $data);

                        if ($update) {

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

                            // $msg = "প্রিয় গ্রাহক, টিভিএলের পক্ষ থেকে শুভেচ্ছা। টিভিএল শুধুমাত্র আমাদের গ্রাহকের ব্যবহারের জন্য। আপনার নিবন্ধন সফলভাবে সম্পন্ন হয়েছে. আপনার অ্যাকাউন্টে লগ ইন করুন.";
                            // send_sms($cMobile, $msg);

                            $login_arr = $this->Mod_api->validate_customer_login_otp($cMobile, $verified);
                            $this->response['msg']    = "Successfully OTP verified.";
                            if ($login_arr && array_key_exists('customer_acc_status', $login_arr)) {
                                $this->response['msg'] .= ($login_arr['customer_acc_status'] == 'inactive') ? "But your account waiting for approval." : "";
                            }
                            $this->response['status'] = true;
                            $this->response['data'] = $login_arr;
                            $this->response['status_code'] = 200;

                        } else {
                            $this->response['msg']    = "NOT UPDATED!";
                            $this->response['status'] = false;
                        }

                    } else {
                        $this->response['msg']    = 'Mobile number and OTP does not match ';
                        $this->response['status'] = false;
                    }
                } catch (Exception $e) {
                    $this->response['error'] = $e->getMessage();
                }


            } else {
                $arr                       = $this->form_validation->error_array();
                $this->response['data']    = implode(', ', array_values($arr));
                $this->response ['status'] = false;
            }

            echo json_encode($this->response);
        }
    }
//========================== end process customer registration ============================

    /*function test_upload()
    {


        $insert_id = 1110;
        $path = './upload/customer_image/' . $insert_id;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $data = "dfgdfgdffdhfghfghfghf";

        $type = 'jpg';

        $base64 = 'data:image/' . $type . ';base64,' . $data;
       // die($base64);

       $image = '456';

        $status = base64_image_upload( $base64,$path,$image );

        die( json_encode( $status ) );
    }*/


//================== customer profile ======================================
    public function view_profile()
    {
        //$token = $this->security->xss_clean($this->input->post('token_id'));
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {

            $array = $this->Mod_api->get_view($customer_id);

            $data = array(

                'customer_id'        => $array['c_id'],
                'customer_name'      => $array['c_name'],
                'customer_email'     => $array['c_email'],
                'customer_mobile'    => $array['c_mobile'],
                'customer_telephone' => $array['c_telephone_no'],
                'c_division'         => check_value($array['c_division']),
                'c_district'         => check_value($array['c_district']),
                'c_thana'            => check_value($array['c_thana']),
                'cPhoto'             => check_value($array['picture']),

                'customer_flat'  => $array['customer_flat'],
                'customer_road'  => $array['customer_road'],
                'customer_post'  => $array['customer_post'],
                'cust_post_code' => $array['cust_post_code'],

                'contact_person'             => $array['contact_person'],
                'contact_person_email'       => $array['contact_person_email'],
                'contact_person_designation' => $array['contact_person_des'],
                'contact_person_phone'       => $array['contact_person_phone'],


            );
        } else {
            $data = array(
                'status' => 'required customer id',
            );
        }

        echo json_encode($data);
    }

//=========== profile edit and update ==========================================
    public function profile_edit()
    {

        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {

            $array = $this->Mod_api->get_profile($customer_id);

            $data = [
                'customer_id' => $array['c_id'],
                'cName'       => $array['c_name'],
                'cEmail'      => $array['c_email'],
                'cMobile'     => $array['c_mobile'],
                'cTel'        => $array['c_telephone_no'],
                'password'    => $array['password'],
                'cPhoto'      => $array['cPhoto'],

                'cFlat'  => $array['cFlat'],
                'cRoad'  => $array['cRoad'],
                'cPost'  => $array['cPost'],
                'cPCode' => $array['cPCode'],

                'pName'   => $array['contact_person'],
                'pDes'    => $array['contact_person_des'],
                'pEmail'  => $array['contact_person_email'],
                'pMobile' => $array['contact_person_phone'],
            ];

            $this->response['data']        = $data;
            $this->response['status']      = true;
            $this->response['status_code'] = 200;
            $this->response['msg']         = 'Successfully fetch customer editable data';

        } else {
            $this->response['msg']         = 'Customer id not found';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);

    }


    function update_profile()
    {

        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {

            $this->form_validation->set_rules('cName', 'Name', 'required');
            $this->form_validation->set_rules('cEmail', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('cMobile', 'Mobile Number',
                'required|callback_validate_uniqe_mobile_edit|integer|max_length[11]');
            $this->form_validation->set_rules('cPost', 'Post', 'required');
            $this->form_validation->set_rules('cPCode', 'Post Code', 'required');
            $this->form_validation->set_rules('pName', 'Name', 'required');
            $this->form_validation->set_rules('pDes', 'Designation', 'required');
            $this->form_validation->set_rules('pEmail', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('pMobile', 'Mobile', 'required|integer|max_length[11]');

            if ($this->form_validation->run() == true) {

                $update = $this->Mod_api->update_profile($customer_id);

                if ($update['status'] == true) {

                    $array = $this->Mod_api->get_last_update_data($customer_id);
                    //print_r($update);die();
                    $data = [
                        'customer_id'   => $array['c_id'],
                        'customer_name' => $array['c_name'],
                        'cEmail'        => $array['c_email'],
                        'cMobile'       => $array['c_mobile'],
                        'cTel'          => $array['c_telephone_no'],
                        //'password'      => $array['password'],
                        'cPhoto'        => ROOT_IMG_URL . "upload/customer_image/". $array['c_id'] . "/" . $update['data']['picture'],

                        'cFlat'  => $array['cFlat'],
                        'cRoad'  => $array['cRoad'],
                        'cPost'  => $array['cPost'],
                        'cPCode' => $array['cPCode'],

                        'pName'   => $array['contact_person'],
                        'pDes'    => $array['contact_person_des'],
                        'pEmail'  => $array['contact_person_email'],
                        'pMobile' => $array['contact_person_phone'],
                    ];


                    $this->response['data']        = $data;
                    $this->response['status']      = true;
                    $this->response['status_code'] = 200;
                    $this->response['msg']         = 'Successfully Updated';

                } else {

                    $this->response['msg']         = $update['msg'];
                    $this->response['status']      = false;
                    $this->response['status_code'] = 500;
                }

            } else {

                $arr                           = $this->form_validation->error_array();
                $this->response['data']        = implode(', ', array_values($arr));
                $this->response['status']      = false;
                $this->response['status_code'] = 500;
            }


        } else {
            $this->response['msg']         = 'Customer id not found';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }
        echo json_encode($this->response);
    }


    function validate_uniqe_mobile_edit($user_mobile)
    {
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $flag        = $this->Mod_api->check_user_mobile_uniq_edit($user_mobile, $customer_id);

        if ($flag == true) {
            $this->form_validation->set_message(' Mobile Number already taken.');
            return false;
        } else {
            return true;
        }
    }

//================= customer ticket save =============================


    public function cutomer_get_machine_list()
    {
        $arr         = array();
        $customer_id = $this->security->xss_clean($this->input->post('customer_id')); //1;

        if (!empty($customer_id)) {
            $machine_arr = $this->Mod_api->get_customer_wise_machine($customer_id);
            if (!empty($machine_arr)) {
                foreach ($machine_arr as $key => $value) {

                    $arr[] = array(
                        "machine_id"          => $value->mc_id,
                        "insb_id"             => $value->insb_id,
                        "machine_serial"      => $value->insb_serial,
                        "machine_name"        => $value->mc_name . " (" . $value->mc_model . "," . $value->insb_serial . ")",
                        "machine_manufacture" => $value->mc_manufacture,
                        "department_id"       => $value->dep_ref_id
                    );
                }
            }
            echo json_encode($arr);
        }

    }

    public function customer_get_support_type()
    {
        $response    = array();
        $customer_id = $this->security->xss_clean($this->input->post('customer_id')); //1; //
        $machine_id  = $this->security->xss_clean($this->input->post('machine_id'));//1; //

        if (!empty($customer_id && $machine_id)) {

            $support_type_data = $this->Mod_api->get_machine_supporttype_info($machine_id, $customer_id);

            if (!empty($support_type_data)) {


                $start_date = $support_type_data->su_start_date;
                $startDate  = date("d M Y", strtotime($start_date));

                $end_date = $support_type_data->su_end_date;
                $endtDate = date("d M Y", strtotime($end_date));


                $now = date('Y-m-d');


                $response = array(
                    'support_type_id'   => $support_type_data->su_type_id,
                    'support_type_name' => $support_type_data->service_type_title,
                    'department'        => $support_type_data->dep_ref_id ? get_department_name_by_id($support_type_data->dep_ref_id) : '',
                );

                if ($support_type_data->su_type_id == 1 || $support_type_data->su_type_id == 2) {
                    if (!empty($start_date && $end_date)) {
                        if ($now >= $start_date && $now <= $end_date) {

                            $response['support_type_start_date'] = $startDate;
                            $response['support_type_end_date']   = $endtDate;

                            $response['status'] = 'ok';
                        } else {

                            $response['support_type_start_date'] = $startDate;
                            $response['support_type_end_date']   = $endtDate;

                            $response['status'] = 'Failed';
                            $response['msg']    = 'Your Support Time Already Expire';
                        }
                    }
                } elseif ($support_type_data->su_type_id == 3) {
                    $response['status'] = 'ok';
                    $response['msg']    = 'Warranty Service';
                } elseif ($support_type_data->su_type_id == 4) {
                    $response['status'] = 'ok';
                    $response['msg']    = 'On Call Service';
                }

            }

            echo json_encode($response);
        }

    }

    public function department_list()
    {
        $department = $this->Mod_api->get_department();

        if (!empty($department)) {
            foreach ($department as $key => $value) {

                $arr[] = [
                    "id"     => $value->id,
                    "name"   => $value->name,
                    "status" => $value->status,
                ];
            }

            $this->response['data']        = $arr;
            $this->response['status']      = true;
            $this->response['status_code'] = 200;
        } else {
            $this->response['msg']         = 'Data Not Found';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }


        echo json_encode($this->response);

    }


    public function customer_save_ticket()
    {
        $customer_id     = $this->security->xss_clean($this->input->post('customer_id'));
        $machine_id      = $this->security->xss_clean($this->input->post('machine_id'));
        $support_type_id = $this->security->xss_clean($this->input->post('support_type_id'));
        if (!isset($_POST['department'])) $_POST['department'] = 0;


        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('machine_id', 'Machine', 'required');
        $this->form_validation->set_rules('request_details', 'Problem Details', 'required');

        $this->form_validation->set_rules('contact_person_name', 'Contact Person Name', 'required');
        $this->form_validation->set_rules('contact_person_mobile', 'Contact Person Mobile', 'required');

        if ($this->form_validation->run()) {

            $contact    = $this->security->xss_clean($this->input->post('contact_person_mobile'));
            $supervisor = $this->Mod_api->get_supervisor();
            $supervisor_number = array_column(json_decode(json_encode($supervisor), true), "mobile");

            if ($support_type_id == 1 || $support_type_id == 2) {

                $valid_support = $this->Mod_api->support_type_validation($customer_id, $machine_id);

                if ($valid_support == 1) {

                    $generate_ticket_no = $this->Mod_api->save_customer_ticket();

                    if (!empty($generate_ticket_no)) {

                        $arr['status']    = true;
                        $arr['data']['ticket_no'] = $generate_ticket_no[0];
                        $arr['msg'] = "Ticket successfully created.";

                        $message_details = get_temp_details('CREATE_TICKET');
                        if ($message_details) {
                            $msg = message_format($message_details->message, [
                                'ticket_no' => $generate_ticket_no[0],
                            ]);
                            send_sms($contact, $msg);
                        }


                        // send push notify
                        $title   = 'New ticket created';
                        $message = get_temp_details('CREATE_TICKET_MANAGER');
                        $app     = ['type' => 'engineer'];

                        if (!empty($supervisor)) {
                            foreach ($supervisor as $sm) {
                                send_sms($sm->mobile, message_format($message->message, [
                                    'ticket_no' => $generate_ticket_no[0],
                                    'name' => $sm->name
                                ]));
                                if ($sm->player_id) {
                                    send_push_notification($sm->player_id, $message, $title, $app);
                                }
                            }
                        }


                    } else { //error, show the ticket generating page again
                        $arr['status'] = false;
                        $arr['data']    = [];
                        $arr['msg']    = 'Something went wrong, please try again.';
                    }
                } else {
                    $arr['status'] = false;
                    $arr['data']    = [];
                    $arr['msg']    = 'Your Support Time Already Over';
                }
            } elseif ($support_type_id == 3 || $support_type_id == 4) {
                $generate_ticket_no = $this->Mod_api->save_customer_ticket();

                if (!empty($generate_ticket_no)) {

                    $arr['status']    = true;
                    $arr['data']['ticket_no'] = $generate_ticket_no[0];
                    $arr['msg']       = 'Your ticket has been submitted. Ticket No. :' . $generate_ticket_no[0];

                    $message_details = get_temp_details('CREATE_TICKET');
                    if ($message_details) {
                        $msg = message_format($message_details->message, [
                            'ticket_no' => $generate_ticket_no[0],
                        ]);
                        send_sms($contact, $msg);
                    }

                    // push notify
                    $title   = 'New ticket created';
                    $message = get_temp_details('CREATE_TICKET_MANAGER');
                    $app     = ['type' => 'engineer'];

                    if (!empty($supervisor)) {
                        foreach ($supervisor as $sm) {
                            send_sms($sm->mobile, message_format($message->message, [
                                'ticket_no' => $generate_ticket_no[0],
                                'name' => $sm->name
                            ]));
                            if ($sm->player_id) {
                                send_push_notification($sm->player_id, $message, $title, $app);
                            }
                        }
                    }

                } else {
                    $arr['status'] = false;
                    $arr['data']    = [];
                    $arr['msg']    = 'Something went wrong, please try again.';
                }
            }

        } else {
            $arr['status'] = false;
            $arr['data']    = [];
            $arr['msg']    = 'Please fill the required fields and try again.';
        }

        echo json_encode($arr);
    }

//======================== ticket list ===========================

    public function customer_get_ticket_list()
    {
        $ticket_status_array = ticket_status_array();
        $service_type_array  = get_service_type_array_dropdown();

        $arr_json = array();

        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $customer_id_sub = $this->security->xss_clean($this->input->post('sub_customer_id'));

        if (!empty($customer_id)) {

            $arr = $this->Mod_api->get_customer_ticket_list($customer_id, $customer_id_sub);
            
            if (!empty($arr)) {
                foreach ($arr as $value) {

                    $ticket_status_label = '';
                    $support_type_label  = '';

                    if (!empty($value['status'])) {
                        $ticket_status_label = $ticket_status_array[$value['status']];
                    }

                    if (!empty($value['support_type'])) {
                        $support_type_label = $service_type_array[$value['support_type']];
                    }


                    //$machine = $value['mc_name'] . ',' . $value['mc_model'] . ',' . $value['insb_serial'] . ',' . $value['insb_version'];


                    $arr_json[] = array(
                        'id'                    => $value['srd_id'],
                        'ticket_no'             => $value['ticket_no'],
                        'customer_id'           => $value['send_from'],
                        'support_type'          => $support_type_label,
                        'request_date_time'     => date_convert($value['request_date_time']),
                        'created_date_time'     => date_convert($value['created_date_time']),
                        'status'                => $ticket_status_label,
                        'request_details'       => $value['request_details'],
                        'send_to'               => $value['send_to'],
                        'machine_ref_id'        => $value['machine_ref_id'],
                        'machine_name'          => $value['mc_name'],
                        'department'            => $value['department'] ? $value['department'] : '',
                        'machine_serial'        => $value['insb_serial'],
                        'machine_model'         => $value['insb_version'],
                        'last_action_by'        => $value['last_action_by'],
                        'last_action_date_time' => $value['last_action_date_time']
                    );

                }

                $this->response['data']        = $arr_json;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;
            } else {
                $this->response['msg']         = 'Data Not available';
                $this->response['status']      = true;
                $this->response['status_code'] = 204;
            }
        } else {
            $this->response['mgs']    = 'customer id not define';
            $this->response['status'] = false;
        }
        echo json_encode($this->response);
    }

    /*
     api funciton to get customer ticket details
     return : json
    */
    public function customer_get_ticket_details()
    {
        $arr = array();

        $ticket_no = trim($this->security->xss_clean($this->input->post('ticket_no')));

        if (!empty($ticket_no)) {

            $ticket = $this->Mod_api->get_ticket_details($ticket_no);

            $ticket_status = ticket_status($ticket->status);
            $data['ticket_details_data'] = array(
                "srd_id"             => $ticket->srd_id,
                "machine_ref_id"     => $ticket->machine_ref_id,
                "machine_name"       => $ticket->mc_name,
                "machine_serial"     => $ticket->insb_serial,
                "machine_version"    => $ticket->insb_version,
                "ticket_no"          => $ticket->ticket_no,
                "contact_person"     => $ticket->contact_person,
                "contact_person_phn" => $ticket->contact_person_phn,
                "request_details"    => $ticket->request_details,
                "support_type"       => $ticket->support_type,
                "created_date_time"  => date_convert($ticket->created_date_time),
                "status"             => is_array($ticket_status) ? 'Undefined' : $ticket_status,
                "customer_id"        => $ticket->customer_id,
                "name"               => $ticket->name,
                "service_type_title" => $ticket->service_type_title,
            );


            $data['ticket_comment_list'] = $this->Mod_api->get_ticket_comment_list_tab($ticket_no);
            $trans                       = $this->Mod_api->get_ticket_trans_flow_tab($ticket_no);

            if (!empty($trans)) {

                foreach ($trans as $tr) {

                    $Name              = '';
                    $created_by_autoId = $tr->created_by;
                    $created_by_type   = $tr->created_by_type;
                    if ($created_by_type == 'admin') {
                        $Name = get_admin_name_by_id($created_by_autoId);
                    } elseif ($created_by_type == 'customer') {
                        $Name = get_customer_name_by_id($created_by_autoId);
                    } elseif ($created_by_type == 'engineer') {
                        $Name = get_engineer_name_by_id($created_by_autoId);
                    }

                    $trans_flaw_status = ticket_status($tr->status);
                    $arr[] = array(
                        'owner_name' => $Name,
                        'Date'       => date_convert($tr->created_date_time),
                        'status'     => is_array($trans_flaw_status) ? 'Undefined' : $trans_flaw_status,
                    );

                    $data['ticket_trans_flow'] = $arr;
                }
            } else {
                $data['ticket_trans_flow'] = '';
            }

            $eng = $this->Mod_api->get_service_eng_details($ticket_no);

            if (!empty($eng)) {

                $data['service_engineer'] = array(

                    'ser_eng_id'     => $eng->ser_eng_id,
                    'ser_eng_code'   => $eng->ser_eng_code,
                    'name'           => $eng->name,
                    'email'          => $eng->email,
                    'mobile'         => $eng->mobile,
                    'eng_depart'     => $eng->eng_depart,
                    'login_token_id' => $eng->login_token_id,
                    'experience'     => $eng->experience,
                    'eng_desig'      => $eng->eng_desig,
                    'picture'        => ROOT_IMG_URL . 'upload/service_engineer/' . $eng->ser_eng_id . '/' . $eng->picture

                );
            } else {
                $data['service_engineer'] = '';
            }

            echo json_encode($data);
        }
    }


    public function customer_comment()
    {

        $response = array();

        $this->form_validation->set_rules('ticket_id', 'Ticket ID', 'required');
        $this->form_validation->set_rules('comment', 'Customer comment', 'required');

        if ($this->form_validation->run() == true) {

            $comment = $this->Mod_api->save_customer_comment();

            if ($comment == true) {
                $supervisor = $this->Mod_api->get_supervisor();
                $title   = 'New Comment';
                $message = $this->input->post('comment');
                $app     = ['type' => 'engineer'];

                if (!empty($supervisor)) {
                    foreach ($supervisor as $sm) {
                        if ($sm->player_id) {
                            send_push_notification($sm->player_id, $message, $title, $app);
                        }
                    }
                }

                $response['status'] = true;
                $response['msg']    = "We get comments successfully";
            } else {
                $response['status'] = false;
                $response['msg']    = "Your comments not submit";
            }

        } else {
            $response['status'] = false;
            $response['msg']    = strip_tags(validation_errors());
        }

        echo json_encode($response);
    }


    //============== ticket search ==============================
    public function search()
    {
        $status_arr  = array();
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $sub_customer_id = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {
            $data['support_type'] = $this->Mod_api->get_support_type($customer_id);
            $arr                  = ticket_status();
            foreach ($arr as $key => $value) {
                $status_arr[] = array('state' => $key, 'msg' => $value);
            }
            $data['status'] = $status_arr;

            $department = $this->Mod_api->get_department();
            $dept = [];
            foreach ($department as $key => $value) {
                $dept[] = [
                    "id"     => $value->id,
                    "name"   => $value->name,
                    "status" => $value->status,
                ];
            }

            $data['department'] = $dept;
            echo json_encode($data);
        }
    }


    public function get_search_ticket_list()
    {
        $ticket_status_array = ticket_status_array();
        $service_type_array  = get_service_type_array_dropdown();
        $customer_id         = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {

            $arr_json = array();

            $arr = $this->Mod_api->get_customer_search_ticket_list($customer_id);

            if (!empty($arr)) {

                foreach ($arr as $key => $value) {

                    $ticket_status_label = '';
                    $support_type_label  = '';

                    if (!empty($value['status'])) {
                        $ticket_status_label = $ticket_status_array[$value['status']];
                    }

                    if (!empty($value['support_type'])) {
                        $support_type_label = $service_type_array[$value['support_type']];
                    }


                    $machine = $value['mc_name'] . ',' . $value['mc_model'] . ',' . $value['insb_serial'] . ',' . $value['insb_version'];


                    $arr_json[] = array(
                        'id'                    => $value['srd_id'],
                        'ticket_no'             => $value['ticket_no'],
                        'customer_id'           => $value['send_from'],
                        'support_type'          => $support_type_label,
                        'request_date_time'     => date_convert($value['request_date_time']),
                        'created_date_time'     => date_convert($value['created_date_time']),
                        'status'                => $ticket_status_label,
                        'request_details'       => $value['request_details'],
                        'send_to'               => $value['send_to'],
                        'machine_ref_id'        => $value['machine_ref_id'],
                        'machine_name'          => $value['mc_name'],
                        'department'            => $value['department'] ? $value['department'] : '',
                        'machine_serial'        => $value['insb_serial'],
                        'machine_model'         => $value['insb_version'],
                        'last_action_by'        => $value['last_action_by'],
                        'last_action_date_time' => $value['last_action_date_time']

                    );

                }

                $this->response['data']        = $arr_json;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {
                $this->response['msg']         = "Data Not Found";
                $this->response['status']      = false;
                $this->response['status_code'] = 204;
            }

        } else {
            $this->response['msg']         = "Customer id not found";
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }
        echo json_encode($this->response);
    }


    //=============================== admin notification ========================
    public function notification()
    {
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {
            $sub_customer_id = $this->security->xss_clean($this->input->post('sub_customer_id'));

            $notifications = $this->Mod_api->customer_wise_notification($customer_id, $sub_customer_id);

            if ($notifications) {

                $notif = [];
                foreach ($notifications as $ntf) {

                    $notif[] = [
                        'message' => $ntf->description,
                        'created' => $ntf->created_at ? date("d M Y", strtotime($ntf->created_at)) : '',
                    ];
                }
                $this->response['data']        = $notif;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {

                $this->response['msg']         = 'Data Not Found';
                $this->response['status']      = true;
                $this->response['status_code'] = 204;

            }

        } else {
            $this->response['msg']         = 'Customer Id Not Define';
            $this->response['status']      = false;
            $this->response['status_code'] = 400;
        }

        echo json_encode($this->response);
    }

    //======================= Machine Details =======================
    public function machine_details()
    {
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $sub_customer_id = $this->security->xss_clean($this->input->post('sub_customer_id'));
        if (!empty($customer_id)) {
            $machine_list = $this->Mod_api->get_customer_wise_machine($customer_id, $sub_customer_id);

            if (!empty($machine_list)) {
                $machines = [];
                foreach ($machine_list as $machine) {
                    $customer_support_type = machine_support_info($customer_id, $machine->mc_id);
                    $start_date = $customer_support_type->su_start_date;
                    $startDate  = date("d M Y", strtotime($start_date));
                    $end_date   = $customer_support_type->su_end_date;
                    $endtDate   = date("d M Y", strtotime($end_date));

                    $machines[] = [
                        'mc_name'       => $machine->mc_name,
                        'insb_serial'   => $machine->insb_serial,
                        'mc_model'      => $machine->mc_model,
                        'insb_version'  => $machine->insb_version,
                        'picture'       => $machine->picture ? ROOT_IMG_URL . 'upload/install_base/' . $machine->insb_id . '/' . $machine->picture : '',
                        'support_type'  => $customer_support_type->service_type_title,
                        'support_start' => $startDate ? $startDate : '',
                        'support_end'   => $endtDate ? $endtDate : '',
                    ];
                }

                $this->response['data']        = $machines;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {
                $this->response['msg']         = 'Data Not Found';
                $this->response['status']      = true;
                $this->response['status_code'] = 204;
            }

        } else {
            $this->response['msg']         = 'Customer id not define';
            $this->response['status']      = false;
            $this->response['status_code'] = 419;
        }

        echo json_encode($this->response);
    }

//================== customer logout =============================

    public function customer_logout()
    {
        $res      = array();
        $token_id = $this->security->xss_clean($this->input->post('token_id'));

        if (!empty($token_id)) {

            $data = array(
                'login_token_id' => ''
            );
            $this->db->where('login_token_id', $token_id);
            $login = $this->db->update('customer', $data);

            if ($login) {
                $res['status'] = 'ok';
            } else {
                $res['status'] = 'Failed';
            }

            echo json_encode($res);
        }

    }


    //==================================== service rng. api ======================================

    /*function eng_login()
    {

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {

            $arr = array(
                'status' => 'required_field_missing',
                'msg'    => 'Required Field Missing'
            );
            echo json_encode($arr);

        } else {
            $arr = $this->Mod_api->validate_login_eng();

            if ($arr['valid_login_engineer'] == true) { // login OK, show the welcome page

                $arr = array(
                    'engineer_id'     => $arr['engineer_id'],
                    'engineer_name'   => $arr['engineer_name'],
                    'engineer_mobile' => $arr['engineer_mobile'],
                    'engineer_photo'  => $arr['engineer_photo'],
                    'status'          => 'ok',
                    'msg'             => 'Successful',
                    'user_type'       => 'eng',
                    'token_id'        => $arr['login_token_id'],
                );

                echo json_encode($arr);

            } else { // login  Failed
                $arr = array(
                    'tokenid' => '',
                    'status'  => 'Failed',
                    'msg'     => 'Invalid mobile or password'
                );
                echo json_encode($arr);
            }
        }
    }*/

    //===================== list of ticket ========================


    public function set_eng_player_id()
    {

        $response    = array('status' => false, 'msg' => null);
        $engineer_id = $this->input->post('engineer_id');
        $player_id   = $this->input->post('player_id');


        if (!empty($engineer_id && $player_id)) {

            $data['player_id'] = $player_id;

            $set_id = $this->Mod_api->set_eng_player_id($engineer_id, $data);

            if ($set_id == true) {

                $response['status'] = true;
                $response['msg']    = 'Player id set';

            } else {
                $response['status'] = false;
                $response['msg']    = 'Player id not set';
            }


        } else {
            $response['status'] = 'set player id';
        }


        echo json_encode($response);


    }




    //============================== Eng. and Supervisor login ==============================

    /**
     * @api supervisor login api
     */
    function eng_spv_login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {

            $arr = $this->Mod_api->validate_login_eng_spv();


            if ($arr['valid_login_engineer'] == true && $arr['user_type'] == 'eng') { // login OK, show the welcome page

                $arr = [
                    'engineer_id'     => $arr['engineer_id'],
                    'engineer_name'   => $arr['engineer_name'],
                    'engineer_mobile' => $arr['engineer_mobile'],
                    'engineer_photo'  => $arr['engineer_photo'],
                    'user_type'       => 'eng',
                    'token_id'        => $arr['login_token_id'],
                ];

                if (!empty($this->input->post('player_id'))) {
                    $this->Mod_api->set_eng_player_id($arr['engineer_id'], ['player_id' => $this->input->post('player_id')]);
                }

                $this->response['data']        = $arr;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } elseif ($arr['valid_login_engineer'] == true && $arr['user_type'] == 'sm') { // login OK, show the welcome page

                $arr = [
                    'spv_id'          => $arr['user_id'],
                    'engineer_name'   => $arr['name'],
                    'engineer_mobile' => $arr['mobile'],
                    'user_type'       => 'sm',
                    'token_id'        => $arr['login_token_id'],
                ];
                if (!empty($this->input->post('player_id'))) {
                    $this->Mod_api->set_spv_player_id($arr['spv_id'], ['player_id' => $this->input->post('player_id')]);
                }

                $this->response['data']        = $arr;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else { // login  Failed

                $this->response['msg']         = 'Invalid mobile or password';
                $this->response['status']      = false;
                $this->response['status_code'] = 500;
            }

        } else {

            $this->response['msg']         = 'Required Field Missing';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);
    }


    public function set_spv_player_id()
    {

        $spv_id    = $this->input->post('spv_id');
        $player_id = $this->input->post('player_id');


        if (!empty($spv_id && $player_id)) {

            $data['player_id'] = $player_id;
            $where             = ['id' => $spv_id];
            $set_id            = $this->Mod_api->update('sm_admin', $where, $data);


            if ($set_id == true) {

                $this->response['msg']         = 'Player id set';
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {

                $this->response['msg']         = 'Failed to set Player id';
                $this->response['status']      = false;
                $this->response['status_code'] = 500;
            }

        } else {

            $this->response['status']      = 'player id is required';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }


        echo json_encode($this->response);
    }


    /**
     * engineer show ticket list which is assigned sm
     */
    public function eng_ticket_list()
    {

        $ticket_status_array = ticket_status_array();
        $service_type_array  = get_service_type_array_dropdown();
        $priority_array      = get_priority_array_dropdown();
        $arr_json            = array();

        $engineer_id = $this->security->xss_clean($this->input->post('engineer_id'));

        if (!empty($engineer_id)) {

            $arr = $this->Mod_api->get_ticket_list($engineer_id);

            if (!empty($arr)) {

                foreach ($arr as $key => $value) {

                    $ticket_status_label = '';
                    $support_type_label  = '';
                    $priority            = '';
                    if (!empty($value['status'])) {
                        $ticket_status_label = $ticket_status_array[$value['status']];
                    }

                    if (!empty($value['support_type'])) {
                        $support_type_label = $service_type_array[$value['support_type']];
                    }

                    if (!empty($value['priority'])) {
                        $priority = $priority_array[$value['priority']];
                    }

                    $ticket_created    = $value['created_date_time'];
                    $customer_location = $value['DIVISION_NAME'];


                    $arr_json[] = array(
                        'srd_id'             => $value['srd_id'],
                        'kb_id'              => $value['ticket_ref_id'],
                        'engineer_id'        => $value['send_to'],
                        'ticket_no'          => $value['ticket_no'],
                        'machine_name'       => $value['mc_name'],
                        'machine_model'      => $value['mc_model'],
                        'machine_serial'     => $value['insb_serial'],
                        'department'         => get_department_name_by_id($value['dep_ref_id']),
                        'priority'           => $priority,
                        'support_type'       => $support_type_label,
                        'contact_person'     => $value['contact_person'],
                        'contact_person_phn' => $value['contact_person_phn'],
                        'status'             => $ticket_status_label,
                        'ticket_status'      => $value['status'],
                        'created_date_time'  => date_convert($value['created_date_time']),
                        'lead_time'          => working_lead_time($ticket_created, $customer_location),
                    );
                }


                $this->response['data']        = $arr_json;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {

                $this->response['msg']         = 'Data not found';
                $this->response['status']      = true;
                $this->response['status_code'] = 204;
            }

        } else {

            $this->response['msg']         = 'Engineer id is required';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }
        echo json_encode($this->response);
    }


    public function job_report()
    {
        $id = $this->security->xss_clean($this->input->post('srd_id'));
        if (!empty($id)) {

            $response = array('status' => false, 'msg' => null, 'file' => null);

            $data['comments'] = $this->Mod_api->get_comments($id);
            $data['machine']  = $this->Mod_api->get_equipment_data($id);

            $data['report'] = $this->Mod_api->get_job_report_data($id);
            $data['spare']  = $this->Mod_api->get_spare_parts_data($id);

            $report = $this->load->view('sm/serviceengineer/view_job_report', $data, true);

            $this->m_pdf->pdf->SetHTMLFooter('<div id="footer">
        
        <div class="row">
            <span class="footer-text" style="font-size: 9px"><b>CHITIAGONG OFFICE</b> : 125, K.B. Fozlul Koder Rood,3rd Floor Chowkbozor, Chifiogong, Phone: (031) 635883, Fox: {031} 635883 E\'moil : tvl\'etg@trodevision.com.bd</span>
        </div>
    </div>');

            $this->m_pdf->pdf->WriteHTML($report);

            $path = '/var/www/html/trvl/upload/report/' . $id . '/';

            $job_report = ROOT_IMG_URL . 'upload/report/' . $id . '/' . 'job_report.pdf';

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            if (is_dir($path)) {
                $this->m_pdf->pdf->Output($path . 'job_report.pdf', 'F');

                $response['status'] = true;
                $response['file']   = $job_report;

            } elseif (is_dir($path) && !empty($job_report)) {

                $response['status'] = true;
                $response['file']   = $job_report;

            } else {
                $response['status'] = false;
                $response['msg']    = 'Report Not generate';
            }

            $this->load->view('sm/serviceengineer/view_job_report', $data, true);


            echo json_encode($response);
        }

    }

    /**
     * engineer take an action against his ticket
     */
    public function action()
    {

        $auto_id     = $this->security->xss_clean($this->input->post('srd_id'));
        $engineer_id = $this->security->xss_clean($this->input->post('engineer_id'));

        $priority_array      = get_priority_array_dropdown();
        $service_type_array  = get_service_type_array_dropdown();
        $ticket_status_array = ticket_status_array();
        $action_arr          = array();
        $comment_arr         = array();


        if (!empty($auto_id && $engineer_id)) {

            $ticket_details = $this->Mod_api->get_details($auto_id, $engineer_id);

            $kb_id = $ticket_details->ticket_ref_id ? $ticket_details->ticket_ref_id : '';

            $absoulote = 'upload/job_report/' . $ticket_details->srd_id . '/' . $ticket_details->job_report;
            $path      = '/var/www/html/trvl/' . $absoulote;
            $base_path = ROOT_IMG_URL . $absoulote;

            if (file_exists($path)) {
                $file = $base_path;
            } else {
                $file = null;
            }

            $data['ticket_info'] = array(

                'srd_id'          => $ticket_details->srd_id,
                'customer_id'     => $ticket_details->send_from,
                'machine_id'      => $ticket_details->machine_ref_id,
                'ticket_no'       => $ticket_details->ticket_no,
                'kb_id'           => $kb_id,
                'customer'        => get_customer_name_by_id($ticket_details->send_from),
                'priority'        => $priority_array[$ticket_details->priority],
                'support_type'    => $service_type_array[$ticket_details->support_type],
                'request_details' => $ticket_details->request_details,
                'status'          => $ticket_details->status,
                'file'            => $file,
                'ticket_status'   => $ticket_status_array[$ticket_details->status]
            );


            $action = $this->Mod_api->get_ticket_trans_flow_tab($ticket_details->ticket_no);

            if (!empty($action)) {

                foreach ($action as $ac) {

                    $Name              = '';
                    $created_by_autoId = $ac->created_by;
                    $created_by_type   = $ac->created_by_type;
                    if ($created_by_type == 'admin') {
                        $Name = get_admin_name_by_id($created_by_autoId);
                    } elseif ($created_by_type == 'customer') {
                        $Name = get_customer_name_by_id($created_by_autoId);
                    } elseif ($created_by_type == 'engineer') {
                        $Name = get_engineer_name_by_id($created_by_autoId);
                    }

                    $action_arr[] = array(
                        'owner'           => $Name,
                        'created_by_type' => $created_by_type,
                        'ticket_status'   => $ticket_status_array[$ac->status]
                    );

                    $data['action_flow'] = $action_arr;
                }
            }

            $comment = $this->Mod_api->get_ticket_comment_list($ticket_details->ticket_no);

            if (!empty($comment)) {
                foreach ($comment as $ac) {

                    $comment_arr[]        = array(
                        'owner'         => get_commenter_name_by_id($ac->comment_from, $ac->comments_by),
                        'comment_from'  => $ac->comment_from,
                        'comments'      => $ac->comments,
                        'comments_date' => date_convert($ac->comments_date_time)
                    );
                    $data['comments_log'] = $comment_arr;
                }
            }


            $data['spare'] = $this->Mod_api->get_spare_parts();

            $this->response['data']        = $data;
            $this->response['status']      = true;
            $this->response['status_code'] = 200;

        } else {

            $this->response['msg']         = 'Engineer id and srd_id is required';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }


        echo json_encode($this->response);
    }

//=========== report upload ===============
    /*public function upload_report_img()
    {

        $response = array('status' => false, 'msg' => null);

        $ticket_id = $this->security->xss_clean($this->input->post('srd_id'));

        if (!empty($ticket_id)) {

            $upload = $this->Mod_api->report_upload($ticket_id);

            if ($upload['status'] == true) {

                $response ['status'] = true;
            } else {
                $response ['msg'] = $upload['msg'];
                $response ['status'] = 'Failed';
            }

        }
    }*/


    public function upload_report_pdf($ticket_id)
    {

        if (!empty($ticket_id)) {

            $upload = $this->Mod_api->report_upload_pdf($ticket_id);

            if ($upload['status'] == true) {

                $this->response ['msg']         = $upload['msg'];
                $this->response ['status']      = true;
                $this->response ['status_code'] = 200;

            } else {
                $this->response ['msg']         = $upload['msg'];
                $this->response ['status']      = false;
                $this->response ['status_code'] = 500;
            }

        }

        echo json_encode($this->response);
    }


    function update_ticket_status()
    {

        $this->form_validation->set_rules('status', 'Ticket Status', 'required');

        if ($this->form_validation->run() == true) {

            $res_flag = $this->Mod_api->update_ticket_status();

            if ($res_flag == true) {

                $srd_id      = $this->security->xss_clean($this->input->post('srd_id'));
                $engineer_id = $this->security->xss_clean($this->input->post('engineer_id'));
                $status      = $this->security->xss_clean($this->input->post('status'));

                if ($status == "A") {

                    $ticket     = $this->Mod_api->get_ticket_info($srd_id, $engineer_id);
                    $player_ids = $this->Mod_api->get_player_ids($srd_id, $engineer_id);

                    $title = "Ticket Completed";
                    $msg   = "মাননীয় স্যার/ম্যাডাম, TVL এর পক্ষ থেকে শুভেচ্ছা। টিকেট নং  $ticket->ticket_no এর বিপরীতে কাজটি সম্পূর্ণ হয়েছে বিস্তারিত জানতে, কল করুন 01755645555";

                    foreach ($ticket as $key => $no) {
                        if ($key != 'status' && $key != 'ticket_no') {
                            send_sms($no, $msg);
                        }
                    }

                    foreach ($player_ids as $key => $player_id) {

                        if ($key == 'customer') {
                            $app     = ['type' => 'mytvl'];
                            send_push_notification($player_id, $msg, $title, $app);
                        }

                        if ($key == 'manager_1' || $key == 'manager_2') {
                            $app     = ['type' => 'engineer'];
                            send_push_notification($player_id, $msg, $title, $app);
                        }
                    }

                }

                $this->response['msg']         = 'Successfully update';
                $this->response['status']      = true;
                $this->response['status_code'] = 200;
            }

        } else {
            $this->response['msg']         = 'Status Required';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);
    }


    //============ first save a knowledge base problem details ================
    public function knowledge_base()
    {
        $ticket_id = $this->security->xss_clean($this->input->post('srd_id'));

        if (!empty($ticket_id)) {

            $ticket = $this->Mod_api->get_ticket_data($ticket_id);

            $data['ticket_details'] = array(
                'ticket_id'   => $ticket->srd_id,
                'ticket_no'   => $ticket->ticket_no,
                'engineer_id' => $ticket->send_to
            );

            $this->response['data']        = $data;
            $this->response['status']      = true;
            $this->response['status_code'] = 200;

        } else {

            $this->response['msg']         = 'Data not found';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);
    }


    public function save_kb()
    {

        $this->form_validation->set_rules('comment', 'Type Your Comments', 'required');

        if ($this->form_validation->run() == true) {
            $res_flag = $this->Mod_api->save_kb_post();

            if ($res_flag) {

                $this->response['msg']         = 'Successfully data save';
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {
                $this->response ['msg']        = 'Failed To Post Comment. Try again later';
                $this->response['status']      = false;
                $this->response['status_code'] = 500;
            }

        } else {
            $this->response['msg']         = 'Comment Field Required';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);

    }

//=================== after kb post insert then comment all of eng. ========================
    public function kb_list()
    {
        $kb = $this->Mod_api->get_kb_list();

        if (!empty($kb)) {

            foreach ($kb as $k) {

                $res[] = array(
                    'kb_id'     => $k->id,
                    'ticket_id' => $k->ticket_ref_id,
                    'ticket_no' => $k->ticket_ref_no,
                    'engineer'  => $k->name,
                    'problems'  => $k->problem_details,
                    'post_date' => str_date($k->posted_date)
                );
            }
            $this->response['data']        = $res;
            $this->response['status']      = true;
            $this->response['status_code'] = 200;

        } else {

            $this->response['msg']         = 'Data not found';
            $this->response['status']      = true;
            $this->response['status_code'] = 204;
        }
        echo json_encode($this->response);
    }


    public function kb_post_detail()
    {
        $res = [];
        $id  = $this->security->xss_clean($this->input->post('kb_id'));

        if (!empty($id)) {

            $kb = $this->Mod_api->get_kb_data_id($id);

            $data['kb_data'] = array(
                'kb_id'       => $kb->id,
                'ticket_id'   => $kb->ticket_ref_id,
                'ticket_no'   => $kb->ticket_ref_no,
                'engineer'    => $kb->name,
                'problems'    => $kb->problem_details,
                'post_date'   => str_date($kb->posted_date),
                'engineer_id' => $kb->posted_by_eng_id
            );

            $kb_comments = $this->Mod_api->get_comment_data($id);

            if (!empty($kb_comments)) {
                foreach ($kb_comments as $comment) {

                    $res[] = array(
                        'id'           => $comment->id,
                        'eng_name'     => $comment->name,
                        'picture'      => $comment->picture ? ROOT_IMG_URL . 'upload/service_engineer/' . $comment->eng_id . '/' . $comment->picture : '',
                        'comments'     => $comment->comment,
                        'comment_date' => str_date($comment->comment_date),
                    );

                    $data['kb_comments'] = $res;
                }
            }

            $this->response['data']        = $data;
            $this->response['status']      = true;
            $this->response['status_code'] = 200;

        } else {

            $this->response['msg']         = 'Kb id required';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }
        echo json_encode($this->response);
    }


    // ============ after save comment give comment ==============

    public function comment_save()
    {
        $this->form_validation->set_rules('kb_id', 'ID', 'required|numeric');
        $this->form_validation->set_rules('engineer_id', 'Engineer ID', 'required|numeric');
        $this->form_validation->set_rules('kb_comment', 'Type Your Comments', 'required');

        if ($this->form_validation->run() == true) {
            $res_flag = $this->Mod_api->save_kb_comment();
            if ($res_flag) {
                $this->response['msg']         = 'Successfully comment save';
                $this->response['status']      = true;
                $this->response['status_code'] = 200;
            } else {
                $this->response ['msg']        = 'Failed To Post Comment. Try again later';
                $this->response['status']      = false;
                $this->response['status_code'] = 500;
            }
        } else {
            $this->response['msg']         = 'Missing Field Required';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }
        echo json_encode($this->response);
    }

//====================================== Supervisor panel ===========================


    public function ticket_list()
    {
        $customer_array      = get_customer_array_dropdown_admin();
        $service_type_array  = get_service_type_array_dropdown();
        $ticket_status_array = ticket_status_array();
        $service_eng_array   = get_service_engineer_array();

        $arr_json = [];

        $user_type = $this->security->xss_clean($this->input->post('user_type'));

        if (!empty($user_type) && $user_type == 'sm') {

            $arr = $this->Mod_api->list_ticket();

            if (!empty($arr)) {

                foreach ($arr as $key => $value) {

                    $ticket_status_label = '';
                    $support_type_label  = '';
                    $service_eng         = '';
                    $customer            = '';


                    if (!empty($value['status'])) {
                        $ticket_status_label = $ticket_status_array[$value['status']];
                    }

                    if (!empty($value['send_to'])) {
                        $service_eng = $service_eng_array[$value['send_to']];
                    }

                    if (!empty($value['send_from']) && array_key_exists($value['send_from'], $customer_array)) {
                        $customer = $customer_array[$value['send_from']];
                    }

                    if (!empty($value['support_type'])) {
                        $support_type_label = $service_type_array[$value['support_type']];
                    }

                    $ticket_created    = $value['created_date_time'];
                    $customer_location = $value['DIVISION_NAME'];


                    $timestamp           = strtotime($ticket_created);
                    $date_process_define = get_relative_time($timestamp);

                    $arr_json[] = array(

                        //ticket info
                        'srd_id'             => $value['srd_id'],
                        'ticket_no'          => $value['ticket_no'],
                        'customer'           => $customer,
                        'contact_person'     => $value['contact_person'],
                        'contact_person_phn' => $value['contact_person_phn'],
                        'request_details'    => $value['request_details'],
                        'department'         => $value['dep_ref_id'] ? get_department_name_by_id($value['dep_ref_id']) : 'N/A',
                        //'data convert'           => based on,
                        'support_type'       => $support_type_label,
                        'status'             => $ticket_status_label,
                        'engineer'           => $service_eng,
                        'eng_rating'         => $value['eng_rating'],
                        //machine info
                        'machine_id'         => $value['machine_ref_id'],
                        'machine_name'       => $value['mc_name'],
                        'machine_model'      => $value['mc_model'],
                        'machine_version'    => $value['insb_version'],
                        'machine_serial'     => $value['insb_serial'],
                        //Date
                        'relative_time'      => $date_process_define,
                        'created_date_time'  => date_convert($ticket_created),
                        'lead_time'          => working_lead_time($ticket_created, $customer_location),

                    );
                }

                $this->response['data']        = $arr_json;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {

                $this->response['msg']         = 'Data Not Found';
                $this->response['status']      = true;
                $this->response['status_code'] = 204;
            }

        } else {
            $this->response['mgs']         = 'user type not define !!';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);
    }


    public function ticket_details()
    {
        $ticket_status_array = ticket_status_array();
        $priority_array      = get_priority_array_dropdown();


        $user_type = $this->security->xss_clean($this->input->post('user_type'));
        $ticket_no = $this->security->xss_clean($this->input->post('ticket_no'));
        $arr       = [];

        if (!empty($user_type) && $user_type == 'sm') {

            if ($ticket_no) {

                $ticket = $this->Mod_api->get_ticket_details($ticket_no);

                $data['ticket_info'] = [

                    //general info
                    "srd_id"               => $ticket->srd_id,
                    "ticket_no"            => $ticket->ticket_no,
                    "support_type"         => $ticket->service_type_title,
                    //"support_type_title"   => $ticket->service_type_title,
                    "request_details"      => $ticket->request_details,
                    "created_date_time"    => date_convert($ticket->created_date_time),
                    "status"               => $ticket->status,
                    "ticket_status"        => $ticket_status_array[$ticket->status],
                    "priority"             => $ticket->priority ? $priority_array[$ticket->priority] : '',
                    "customer_id"          => $ticket->customer_id,
                    //machine info
                    "machine_id"           => $ticket->machine_ref_id,
                    "machine_name"         => $ticket->mc_name,
                    "machine_model"        => $ticket->mc_model,
                    "machine_serial"       => $ticket->insb_serial,
                    "machine_version"      => $ticket->insb_version,
                    //customer info
                    "customer"             => $ticket->name,
                    "contact_person"       => $ticket->contact_person_name,
                    "contact_person_deg"   => $ticket->contact_person_desig,
                    "contact_person_email" => $ticket->contact_person_email,
                    "contact_person_phn"   => $ticket->contact_person_phone,
                ];

                $trans = $this->Mod_api->get_ticket_trans_flow_tab($ticket->ticket_no);

                if (!empty($trans)) {

                    foreach ($trans as $tr) {

                        $Name              = '';
                        $created_by_autoId = $tr->created_by;
                        $created_by_type   = $tr->created_by_type;
                        if ($created_by_type == 'admin') {
                            $Name = get_admin_name_by_id($created_by_autoId);
                        } elseif ($created_by_type == 'customer') {
                            $Name = get_customer_name_by_id($created_by_autoId);
                        } elseif ($created_by_type == 'engineer') {
                            $Name = get_engineer_name_by_id($created_by_autoId);
                        }

                        $arr[] = [
                            'owner'           => $Name,
                            'created_by_type' => $created_by_type,
                            'ticket_status'   => $ticket_status_array[$tr->status]
                        ];

                        $data['action_flow'] = $arr;
                    }
                }

                $comment = $this->Mod_api->get_ticket_comment_list_tab($ticket->ticket_no);

                if (!empty($comment)) {
                    foreach ($comment as $ac) {

                        $comments[]           = array(
                            'owner'         => get_commenter_name_by_id($ac->comment_from, $ac->comments_by),
                            'comment_from'  => $ac->comment_from,
                            'comments'      => $ac->comments,
                            'comments_date' => date_convert($ac->comments_date_time)
                        );
                        $data['comments_log'] = $comments;
                    }
                }

                $data['engineer'] = $this->Mod_api->get_all_engineer();
                $data['priority'] = $this->Mod_api->get_all_priority();

                $this->response['data']        = $data;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {
                $this->response['msg']         = 'Data Not Found';
                $this->response['status']      = false;
                $this->response['status_code'] = 500;
            }


        } else {

            $this->response['mgs']         = 'user type not define !!';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);
    }


    public function search_parameter()
    {
        $data['customer']     = $this->Mod_api->get_all_customer();
        $data['support_type'] = $this->Mod_api->get_serivce_type();
        $data['engineer']     = $this->Mod_api->get_all_engineer();

        $this->response['data']   = $data;
        $this->response['status'] = true;

        echo json_encode($this->response);

    }


    public function ticket_search_details()
    {
        $customer_array      = get_customer_array_dropdown_admin();
        $service_type_array  = get_service_type_array_dropdown();
        $ticket_status_array = ticket_status_array();
        $service_eng_array   = get_service_engineer_array();

        $arr_json = [];

        $user_type = $this->security->xss_clean($this->input->post('user_type'));

        if (!empty($user_type) && ( $user_type == 'sm' or $user_type == 'eng')) {

            $arr = $this->Mod_api->search_list_ticket();

            if (!empty($arr)) {

                foreach ($arr as $key => $value) {

                    $ticket_status_label = '';
                    $support_type_label  = '';
                    $service_eng         = '';
                    $customer            = '';


                    if (!empty($value['status'])) {
                        $ticket_status_label = $ticket_status_array[$value['status']];
                    }

                    if (!empty($value['send_to'])) {
                        $service_eng = $service_eng_array[$value['send_to']];
                    }

                    if (!empty($value['send_from']) && array_key_exists($value['send_from'], $customer_array)) {
                        $customer = $customer_array[$value['send_from']];
                    }

                    if (!empty($value['support_type'])) {
                        $support_type_label = $service_type_array[$value['support_type']];
                    }

                    $ticket_created    = $value['created_date_time'];
                    $customer_location = $value['DIVISION_NAME'];


                    $timestamp           = strtotime($ticket_created);
                    $date_process_define = get_relative_time($timestamp);

                    $arr_json[] = array(

                        //ticket info
                        'srd_id'             => $value['srd_id'],
                        'ticket_no'          => $value['ticket_no'],
                        'customer'           => $customer,
                        'contact_person'     => $value['contact_person'],
                        'contact_person_phn' => $value['contact_person_phn'],
                        'request_details'    => $value['request_details'],
                        'department'         => get_department_name_by_id($value['dep_ref_id']),
                        //'data convert'           => based on,
                        'support_type'       => $support_type_label,
                        'status'             => $ticket_status_label,
                        'engineer'           => $service_eng,
                        'eng_rating'         => $value['eng_rating'],
                        //machine info
                        'machine_id'         => $value['machine_ref_id'],
                        'machine_name'       => $value['mc_name'],
                        'machine_model'      => $value['mc_model'],
                        'machine_version'    => $value['insb_version'],
                        'machine_serial'     => $value['insb_serial'],
                        //Date
                        'relative_time'      => $date_process_define,
                        'created_date_time'  => date_convert($ticket_created),
                        'lead_time'          => working_lead_time($ticket_created, $customer_location),

                    );
                }

                $this->response['data']        = $arr_json;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {
                $this->response['msg']         = 'Data Not Found';
                $this->response['status']      = false;
                $this->response['status_code'] = 500;
            }

        } else {
            $this->response['mgs']         = 'user type not define !!';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);

    }


    public function ticket_status_update()
    {
        $this->form_validation->set_rules('srd_id', 'Ticket', 'required');
        $this->form_validation->set_rules('ticket_no', 'Ticket No', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('engineer', 'Engineer', 'required');
        $this->form_validation->set_rules('priority', 'Priority', 'required');
        $this->form_validation->set_rules('comment', 'Comment', 'required');


        if ($this->form_validation->run()) {

            $update = $this->Mod_api->spv_update_ticket_status();

            if ($update) {
                $this->response['msg']         = 'Ticket Status Updated Successfully';
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {

                $this->response['msg']         = 'Data failed to Update';
                $this->response['status']      = false;
                $this->response['status_code'] = 500;
            }

        } else {
            $errors                        = $this->form_validation->error_array();
            $this->response['data']        = $errors;
            $this->response['msg']         = 'Required Field Missing';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);
    }


    public function get_model()
    {
        $equ = trim($this->input->post('machine_id'));
        if (!empty($equ)) {

            $data['model'] = $this->Mod_api->get_machine_model($equ);


            $this->response['data']        = $data;
            $this->response['status']      = true;
            $this->response['status_code'] = 200;

        } else {
            $this->response['msg']         = 'Data not found';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);
    }


    public function install_base_search()
    {
        $data['customer']     = $this->Mod_api->get_all_customer();
        $data['support_type'] = $this->Mod_api->get_serivce_type();
        $data['machine']      = $this->Mod_api->get_machine();
        $data['serial']       = $this->Mod_api->get_serial();

        $this->response['data']   = $data;
        $this->response['status'] = true;

        echo json_encode($this->response);

    }

    public function install_base_list()
    {

        $user_type = $this->security->xss_clean($this->input->post('user_type'));
        $data      = [];

        if ($user_type && $user_type == 'sm') {

            $list_data = $this->Mod_api->get_install_base_list();

            if (!empty($list_data)) {

                foreach ($list_data as $in) {

                    $data[] = [
                        'insb_id'         => $in->insb_id,
                        'customer'        => $in->customer,
                        'machine'         => $in->mc_name,
                        'mc_model'        => $in->mc_model,
                        'support_type'    => $in->service_type_title,
                        'support_start'   => $in->su_start_date,
                        'support_end'     => $in->su_end_date,
                        'department'      => $in->dep_ref_id ? get_department_name_by_id($in->dep_ref_id) : '',
                        'pmi_schedule'    => pmi_schedule_date($in->insb_id) ? pmi_schedule_date($in->insb_id) : '',
                        'work_order_date' => str_date($in->insb_work_order_date),
                        'install_date'    => str_date($in->insb_install_date),
                        'warranty'        => str_date($in->insb_warranty_date),
                    ];
                }

                $this->response['data']        = $data;
                $this->response['status_code'] = 200;
                $this->response['status']      = true;

            } else {
                $this->response['msg']    = 'Data Not Found';
                $this->response['status'] = true;
                $this->response['status_code'] = 204;
            }


        } else {
            $this->response['mgs']    = 'user type not define !!';
            $this->response['status'] = false;
        }

        echo json_encode($this->response);
    }


    public function install_base_details()
    {

        $user_type = $this->security->xss_clean($this->input->post('user_type'));
        $insb_id   = $this->security->xss_clean($this->input->post('insb_id'));
        $data      = [];


        if ($user_type && $user_type == 'sm') {

            if ($insb_id) {

                $install_base = $this->Mod_api->get_install_base($insb_id);

                if ($install_base) {

                    $start_date = $install_base->insb_install_date;
                    $end_date   = $install_base->insb_warranty_date;
                    $now        = date('Y-m-d');

                    $data['basic_info'] = [
                        'insb_id'         => $install_base->insb_id,
                        'business'        => $install_base->bu_name ? $install_base->bu_name : null,
                        'sector'          => $install_base->insb_sector && $install_base->insb_sector == 'govt' ? 'Govt.' : $install_base->insb_sector,
                        'install_by'      => $install_base->insb_install_by,
                        'note'            => $install_base->insb_special_note,
                        'department'      => get_department_name_by_id($install_base->dep_ref_id),
                        'contract_no'     => $install_base->insb_work_order_contact,
                        'work_order_date' => str_date($install_base->insb_work_order_date),
                        'install_date'    => $now >= $start_date && $now <= $end_date ? str_date($install_base->insb_install_date) : str_date($install_base->insb_install_date),
                        'warranty_date'   => $now >= $start_date && $now <= $end_date ? str_date($install_base->insb_warranty_date) : str_date($install_base->insb_warranty_date),
                    ];

                    $data['user_training'] = $this->Mod_api->get_user_training($insb_id);
                    $data['client_info']   = $this->Mod_api->get_customer_data($insb_id);
                    $data['item_info']     = $this->Mod_api->get_equipment($insb_id);

                    $support              = $this->Mod_api->get_support_type_data($insb_id);
                    $data['support_info'] = [
                        'su_type_id'         => $support->su_type_id,
                        'service_type_title' => $support->service_type_title,
                        'su_start_date'      => $support->su_start_date,
                        'su_end_date'        => $support->su_end_date,
                        'su_cycle'           => $support->su_cycle,
                        'support_start'      => str_date($support->su_start_date),
                        'support_end'        => str_date($support->su_end_date),
                    ];


                    $this->response['data']   = $data;
                    $this->response['status'] = true;

                } else {
                    $this->response['msg']    = "Data Not Found";
                    $this->response['status'] = false;
                }

            } else {

                $this->response['msg']    = 'Install base id required';
                $this->response['status'] = false;
            }

        } else {
            $this->response['mgs']    = 'user type not define !!';
            $this->response['status'] = false;
        }

        echo json_encode($this->response);

    }

    public function insb_renew_support_type()
    {
        $support_type = $this->Mod_api->renew_support_type();
        $data         = [];

        if (!empty($support_type)) {

            foreach ($support_type as $support) {
                $data['support_type'][] = [
                    'id'   => $support->service_type_id,
                    'name' => $support->service_type_title,
                ];
            }

            $this->response['data']   = $data;
            $this->response['status'] = true;

        } else {
            $this->response['mgs']    = 'Data Not Fount';
            $this->response['status'] = false;
        }

        echo json_encode($this->response);
    }


    public function insb_support_type_renew()
    {


        $this->form_validation->set_rules('spNote', 'Special Note', 'required');
        //$this->form_validation->set_rules('supp_type', 'Support Type', 'required');

        if ($this->form_validation->run()) {

            $install_id = $this->security->xss_clean($this->input->post('insb_id'));

            $datetime      = date('Y-m-d H:i:s');
            $support_start = $this->security->xss_clean($this->input->post('support_start'));

            $start_date  = date("Y-m-d", strtotime($support_start));
            $support_end = $this->security->xss_clean($this->input->post('support_end'));
            $end_date    = date("Y-m-d", strtotime($support_end));

            $support_type  = $this->security->xss_clean($this->input->post('supp_type'));
            $support_cycle = $this->security->xss_clean($this->input->post('supp_cycle'));
            $special_note  = $this->security->xss_clean($this->input->post('spNote'));

            if ($install_id && ($support_type == 1 || $support_type == 2)) {

                $data = array(
                    'su_type_id'    => $support_type,
                    'su_cycle'      => $support_cycle,
                    'su_start_date' => $support_start ? $start_date : null,
                    'su_end_date'   => $support_end ? $end_date : null,
                    'updated'       => $datetime
                );

            } elseif ($install_id && $support_type == 4) {

                $data = array(
                    'su_type_id' => $support_type,
                    'updated'    => $datetime
                );

            } else {
                $data = [];
            }

            //============= update note ================
            $sp_note = array(
                'insb_special_note' => $special_note,
                'support_type'      => $support_type ? $support_type : null,
            );
            if (!empty($sp_note) && $install_id) {

                $where = ['insb_id' => $install_id];
                $this->Mod_api->update('install_base', $where, $sp_note);
            }

            if (!empty($data) && $install_id) {

                $where = ['install_base_ref_id' => $install_id];
                $this->Mod_api->update('cust_support_type', $where, $data);

                $this->response['msg']    = 'Successfully renew';
                $this->response['status'] = true;

            } else {

                $this->response['msg']    = 'Data not submit';
                $this->response['status'] = false;
            }

        } else {

            $errors                   = $this->form_validation->error_array();
            $this->response['data']   = $errors;
            $this->response['msg']    = 'Required Field Missing';
            $this->response['status'] = false;
        }

        echo json_encode($this->response);
    }


    public function customer_feedback()
    {

        $user_type = $this->security->xss_clean($this->input->post('user_type'));

        $data = [];

        if ($user_type && $user_type == 'sm') {

            $feedback = $this->Mod_api->get_customer_feed_back();

            if (!empty($feedback)) {

                foreach ($feedback as $f) {

                    $data[] = [
                        'customer'   => $f->name,
                        'email'      => $f->email,
                        'mobile'     => $f->mobile,
                        'subject'    => $f->f_subject,
                        'feedback'   => $f->feedback,
                        'department' => get_department_name_by_id($f->dep_ref_id),
                        'date'       => date_convert($f->created)
                    ];

                }

                $this->response['data']        = $data;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {
                $this->response['mgs']         = 'Data Not Found';
                $this->response['status']      = true;
                $this->response['status_code'] = 204;
            }


        } else {
            $this->response['mgs']         = 'user type not define !!';
            $this->response['status']      = false;
            $this->response['status_code'] = 500;
        }

        echo json_encode($this->response);
    }


    public function pmi_list()
    {
        $user_type = $this->security->xss_clean($this->input->post('user_type'));
        $data      = [];

        if ($user_type && $user_type == 'sm') {

            $pmi = $this->Mod_api->get_pmi_list();


            if (!empty($pmi)) {

                foreach ($pmi as $in) {

                    $absoulote = 'upload/pmi/' . $in->pmi_id . '/' . $in->pmi_report;
                    $path      = '/var/www/html/trvl/' . $absoulote;
                    $base_path = ROOT_IMG_URL . $absoulote;

                    $data[] = [

                        'pmi_id'     => $in->pmi_id,
                        'pmi_report' => $in->pmi_report,
                        'customer'   => $in->customer,
                        'machine'    => $in->mc_name,
                        'model'      => $in->mc_model,
                        'serial'     => $in->insb_serial,
                        'department' => get_department_name_by_id($in->dep_ref_id),
                        'pmi_date'   => $in->created != '0000-00-00 00:00:00' ? date_convert($in->created) : '',
                        'engineer'   => $in->engineer,
                        'report'     => file_exists($path) ? $base_path : null,
                    ];
                }

                $this->response['data']        = $data;
                $this->response['status']      = true;
                $this->response['status_code'] = 200;

            } else {
                $this->response['msg']         = 'Data Not Found';
                $this->response['status_code'] = 204;
                $this->response['status']      = true;
            }


        } else {
            $this->response['mgs']    = 'user type not define !!';
            $this->response['status'] = false;
        }
        echo json_encode($this->response);
    }

    public function sms_send () {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'Phone', 'required|exact_length[11]|numeric|regex_match[/01[3-9]{1}[0-9]{8}/u]');
        $this->form_validation->set_rules('message', 'Message', 'required|min_length[6]|max_length[160]');

        if ($this->form_validation->run()) {
            $phone = $this->input->post('phone', true);
            $message = $this->input->post('message', true);
            $msg_res = send_sms($phone, $message);
            $this->response['status']      = true;
            $this->response['status_code'] = 200;
            $this->response['msg'] = ($msg_res) ? "Message Successfully Sent" : "Message Send Failed";
        } else {
            http_response_code(417);
            $this->response['msg']         = validation_errors('[', ']');
            $this->response['status_code'] = Required_Field_Missing;
            $this->response['status']      = false;
        }

        echo json_encode($this->response);

    }

    public function resend_otp () {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone', 'Customer Phone', 'required|exact_length[11]|numeric|regex_match[/01[3-9]{1}[0-9]{8}/u]');

        if ($this->form_validation->run()) {
            $sub_customer_data = $this->Mod_api->get_sub_customer_details($this->input->post('phone', true));
            if ($sub_customer_data) {
                $phone = $sub_customer_data->phone;
                $message = "Your OTP " . $sub_customer_data->otp_pass . " From " . COMPANY_NAME;

                $msg_res = send_sms($phone, $message);
                $this->response['status']      = true;
                $this->response['status_code'] = 200;
                $this->response['msg'] = ($msg_res) ? "OTP Successfully Sent" : "Message Send Failed";
            } else {
                http_response_code(DATA_NOT_FOUND);
                $this->response['msg']         = "Data not found!";
                $this->response['status_code'] = DATA_NOT_FOUND;
                $this->response['status']      = false;
            }
        } else {
            http_response_code(Required_Field_Missing);
            $this->response['msg']         = validation_errors('[', ']');
            $this->response['status_code'] = Required_Field_Missing;
            $this->response['status']      = false;
        }

        echo json_encode($this->response);

    }


    public function get_ticket_list_service_eng($eng_auto_id)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";


        $engineer_auto_id = $eng_auto_id;
        if($engineer_auto_id) $read_db->where("send_to", $engineer_auto_id);

        $read_db->select('sm_service_request_dtl.*,divisions.DIVISION_NAME,kb_post.ticket_ref_id, customer.name as send_from, customer_to.name as send_to, machine.mc_name as machine_name, "Pending" as status, machine.mc_model as machine_model, medical_department.name as department_name');

        $read_db->join('knowledge_base_main kb_post', 'sm_service_request_dtl.srd_id = kb_post.ticket_ref_id', 'left');
        $read_db->join('medical_department', 'sm_service_request_dtl.dep_ref_id = medical_department.id', 'left');
        $read_db->join('machine', 'sm_service_request_dtl.machine_ref_id = machine.mc_id', 'left');
        $read_db->join('customer', 'sm_service_request_dtl.send_from = customer.customer_id', 'left');
        $read_db->join('customer as customer_to', 'sm_service_request_dtl.send_to = customer.customer_id', 'left');
        $read_db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');
        $read_db->group_by('sm_service_request_dtl.srd_id');
        $read_db->order_by("sm_service_request_dtl.srd_id", 'DESC');
        $read_db->where("sm_service_request_dtl.st_flag", 0);
        $read_db->where("sm_service_request_dtl.status !=", "A");
        $query = $read_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            $this->response['status']      = true;
            $this->response['status_code'] = 200;
            $this->response['data']        = $result;
        } else {
            http_response_code(DATA_NOT_FOUND);
            $this->response['msg']         = "Data not found!";
            $this->response['status_code'] = DATA_NOT_FOUND;
            $this->response['status']      = false;
        }

        echo json_encode($this->response);
    }

    public function get_ticket_count_service_eng($eng_auto_id)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";


        $engineer_auto_id = $eng_auto_id;
        if($engineer_auto_id) $read_db->where("send_to", $engineer_auto_id);

        $read_db->select('sm_service_request_dtl.*,divisions.DIVISION_NAME,kb_post.ticket_ref_id');
        $read_db->join('knowledge_base_main kb_post', 'sm_service_request_dtl.srd_id = kb_post.ticket_ref_id', 'left');
        $read_db->join('customer', 'sm_service_request_dtl.send_from = customer.customer_id', 'left');
        $read_db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');
        $read_db->group_by('sm_service_request_dtl.srd_id');
        $read_db->order_by("sm_service_request_dtl.srd_id", 'DESC');
        $read_db->where("sm_service_request_dtl.st_flag", 0);
        $read_db->where("sm_service_request_dtl.status !=", "A");
        $query = $read_db->get('sm_service_request_dtl');

        $result = $query->result();
        $this->response['status']      = true;
        $this->response['status_code'] = 200;
        $this->response['data']        = $query->num_rows();

        echo json_encode($this->response);
    }

}