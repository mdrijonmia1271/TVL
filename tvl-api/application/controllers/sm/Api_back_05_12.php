<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api
 *
 * @author Mhabub
 * @property Mod_api $Mod_api
 * @property Mod_ticket $Mod_ticket
 */
class Api extends CI_Controller
{

    private $customer_token_id = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('M_pdf');
        $this->load->library('form_validation');
        $this->load->model('sm/Mod_api');
        $this->load->model('sm/Mod_ticket');
        $this->customer_token_id = $this->security->xss_clean($this->input->post('customer_tokenid'));
    }


    /*
     api function to validate customer login request
     return: json
    */


    public function customer_login()
    {
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $arr = array(
                'status' => 'required_field_missing',
                'msg' => 'Required Field Missing'
            );
            echo json_encode($arr);
        } else {
            $mobile = $this->security->xss_clean($this->input->post('mobile')); //'01717036048';
            $password = $this->security->xss_clean($this->input->post('password')); //'X8NYIA'

            $arr = $this->Mod_api->validate_customer_login($mobile, $password);

            if ($arr['customer_valid_login'] == true && $arr['customer_acc_status'] == "active") { // login OK, show the welcome page

                $arr = array(
                    'customer_id' => $arr['customer_id'],
                    'customer_name' => $arr['customer_name'],
                    'customer_mobile' => $arr['customer_mobile'],
                    'cPhoto' => $arr['cPhoto'],
                    'status' => 'ok',
                    'msg' => 'Successful',
                    'token_id' => $arr['login_token_id'],
                );
                echo json_encode($arr);

            } elseif ($arr['customer_valid_login'] == true && $arr['customer_acc_status'] == "inactive") { // login OK, show the welcome page

                $arr = array(
                    'status' => 'Failed',
                    'msg' => 'Account is inactive'
                );

                echo json_encode($arr);

            } else { // login  Failed
                $arr = array(
                    'status' => 'Failed',
                    'msg' => 'Invalid mobile or password'
                );
                echo json_encode($arr);
            }
        }

    }


    //=========================== get player id ==============

    public function set_customer_player_id()
    {

        $response = array('status' => false, 'msg' => null);
        $customer_id = $this->input->post('customer_id');
        $player_id = $this->input->post('player_id');


        if (!empty($customer_id && $player_id)) {

            $data['player_id'] = $player_id;

            $set_id = $this->Mod_api->set_player_id($customer_id, $data);

            if ($set_id == true) {

                $response['status'] = true;
                $response['msg'] = 'Player id set';

            } else {
                $response['status'] = false;
                $response['msg'] = 'Player id not set';
            }


        } else {
            $response['status'] = 'set player id';
        }


        echo json_encode($response);


    }


//============================== forgot password =============================
    public function ForgotPassword()
    {
        $response = array();

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');

        if ($this->form_validation->run() == true) {

            $mobile = $this->input->post('mobile');
            $valid = $this->Mod_api->check_valid_mobile($mobile);

            if ($valid == true) {
                $random = $this->rand6();
                //$response ['otp_pass'] = $random;
                $response ['mobile'] = $mobile;
                $response ['status'] = true;
                $response['send_me'] = 'Your OTP ' . $random . ' for change password.';

                send_sms($mobile, $response['send_me']);

                $this->Mod_api->store_one_time_pass($mobile, $random);

            } else {
                $response ['status'] = false;
                $response['msg'] = "This Mobile Number Not Exist";
            }

        } else {
            $arr = $this->form_validation->error_array();
            $response['msg'] = implode(', ', array_values($arr));
            $response ['status'] = 'Failed';
        }

        echo json_encode($response);

    }

    function rand6()
    {
        $digits = 3;
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;
        return mt_rand($min, $max);
    }

    public function valid_otp_pass()
    {

        $response = array();
        $mobile = $this->input->post('mobile');
        $pass = $this->input->post('otp_pass');

        $valid = $this->Mod_api->check_valid_otp($mobile, $pass);

        if ($valid == true) {

            $password = $this->input->post('password');
            $confirm = $this->input->post('confirm');

            if ($password == $confirm) {
                $update = $this->Mod_api->update_pass($mobile, $password);
                $this->Mod_api->blank_one_time_pass($mobile);
                if ($update == true) {
                    $response ['status'] = true;
                    $response['msg'] = 'Your password has been changed successfully';
                } else {
                    $response ['status'] = false;
                    $response['msg'] = 'Your one time password already Expire';
                }

            } else {
                $response ['status'] = 'Failed';
                $response['msg'] = 'Your confirm password not match';
            }

            //$response['status'] = true;
        } else {
            $response['status'] = false;
            $response['msg'] = 'Your OTP invalid';
        }

        echo json_encode($response);
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

        $response = array();

        $this->form_validation->set_rules('cName', 'Name', 'required');
        $this->form_validation->set_rules('cEmail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('cMobile', 'Mobile Number', 'required|is_unique[customer.mobile]  |integer|max_length[11]');
        $this->form_validation->set_rules('cPass', 'Password', 'required');
        $this->form_validation->set_rules('confirm', 'confirm password', 'required|matches[cPass]');
        $this->form_validation->set_rules('cPost', 'Post', 'required');
        $this->form_validation->set_rules('cPCode', 'Post Code', 'required');
        $this->form_validation->set_rules('contact_add_division', 'Division', 'required');

        $this->form_validation->set_rules('pName', 'Name', 'required');
        $this->form_validation->set_rules('pDes', 'Designation', 'required');
        $this->form_validation->set_rules('pEmail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pMobile', 'Mobile', 'required|integer|max_length[11]');


        if ($this->form_validation->run() == true) {

            $mobile = $this->input->post('cMobile');
            $confirm = $this->input->post('confirm');

            $insert = $this->Mod_api->save_customer_signup_info();

            if ($insert['status'] == true) {

                $response ['msg'] = 'You are registered.';
                $response ['status'] = 'ok';

                $msg = 'Dear Subscriber, Greetings from Tradevision Ltd. Your login ID is ' . $mobile . ' and Password is ' . $confirm . ' For approval and further details, call 01755645555';
                $response['send_me'] = send_sms($mobile, $msg);

            } else {
                $response ['msg'] = $insert['msg'];
                $response ['status'] = 'Failed';
            }

        } else {
            $arr = $this->form_validation->error_array();
            $response['msg'] = implode(', ', array_values($arr));
            $response ['status'] = 'Failed';
        }

        echo json_encode($response);

    }


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

                'customer_id' => $array['c_id'],
                'customer_name' => $array['c_name'],
                'customer_email' => $array['c_email'],
                'customer_mobile' => $array['c_mobile'],
                'customer_telephone' => $array['c_telephone_no'],
                'c_division' => $array['c_division'],
                'c_district' => $array['c_district'],
                'c_thana' => $array['c_thana'],
                'cPhoto' => $array['picture'],

                'customer_flat' => $array['customer_flat'],
                'customer_road' => $array['customer_road'],
                'customer_post' => $array['customer_post'],
                'cust_post_code' => $array['cust_post_code'],

                'contact_person' => $array['contact_person'],
                'contact_person_email' => $array['contact_person_email'],
                'contact_person_designation' => $array['contact_person_des'],
                'contact_person_phone' => $array['contact_person_phone'],


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

            $data = array(
                'customer_id' => $array['c_id'],
                'cName' => $array['c_name'],
                'cEmail' => $array['c_email'],
                'cMobile' => $array['c_mobile'],
                'cTel' => $array['c_telephone_no'],
                'password' => $array['password'],
                'cPhoto' => $array['cPhoto'],

                'cFlat' => $array['cFlat'],
                'cRoad' => $array['cRoad'],
                'cPost' => $array['cPost'],
                'cPCode' => $array['cPCode'],

                'pName' => $array['contact_person'],
                'pDes' => $array['contact_person_des'],
                'pEmail' => $array['contact_person_email'],
                'pMobile' => $array['contact_person_phone'],
            );

            echo json_encode($data);
        }

    }


    function update_profile()
    {

        $response = array();

        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        if (!empty($customer_id)) {
            $this->form_validation->set_rules('cName', 'Name', 'required');
            $this->form_validation->set_rules('cEmail', 'Email', 'required|valid_email');
            //$this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('cMobile', 'Mobile Number', 'required|callback_validate_uniqe_mobile_edit|integer|max_length[11]');
            $this->form_validation->set_rules('cPost', 'Post', 'required');
            $this->form_validation->set_rules('cPCode', 'Post Code', 'required');


            $this->form_validation->set_rules('pName', 'Name', 'required');
            $this->form_validation->set_rules('pDes', 'Designation', 'required');
            $this->form_validation->set_rules('pEmail', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('pMobile', 'Mobile', 'required|integer|max_length[11]');

            if ($this->form_validation->run() == true) {

                $update = $this->Mod_api->update_profile($customer_id);

                if ($update['status'] == true) {

                    $response ['status'] = 'success';
                    $array = $this->Mod_api->get_last_update_data($customer_id);

                    $response['data'] = array(
                        'customer_id' => $array['c_id'],
                        'customer_name' => $array['c_name'],
                        'cEmail' => $array['c_email'],
                        'cMobile' => $array['c_mobile'],
                        'cTel' => $array['c_telephone_no'],
                        'password' => $array['password'],
                        'cPhoto' => $array['cPhoto'],

                        'cFlat' => $array['cFlat'],
                        'cRoad' => $array['cRoad'],
                        'cPost' => $array['cPost'],
                        'cPCode' => $array['cPCode'],

                        'pName' => $array['contact_person'],
                        'pDes' => $array['contact_person_des'],
                        'pEmail' => $array['contact_person_email'],
                        'pMobile' => $array['contact_person_phone'],
                    );

                } else {
                    $response ['msg'] = $update['msg'];
                    $response ['status'] = 'Failed';
                }

            } else {
                $arr = $this->form_validation->error_array();
                $response['msg'] = implode(', ', array_values($arr));

                $response ['status'] = 'Failed';
            }

            echo json_encode($response);
        }

    }


    function validate_uniqe_mobile_edit($user_mobile)
    {
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $flag = $this->Mod_api->check_user_mobile_uniq_edit($user_mobile, $customer_id);

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
        $arr = array();
        $customer_id = $this->security->xss_clean($this->input->post('customer_id')); //1;

        if (!empty($customer_id)) {
            $machine_arr = $this->Mod_api->get_customer_wise_machine($customer_id);
            if (!empty($machine_arr)) {
                foreach ($machine_arr as $key => $value) {

                    $arr[] = array(
                        "machine_id" => $value->mc_id,
                        "insb_id" => $value->insb_id,
                        "machine_serial" => $value->insb_serial,
                        "machine_name" => $value->mc_name . " (" . $value->mc_model . "," . $value->insb_serial . ")",
                        "machine_manufacture" => $value->mc_manufacture
                    );
                }
            }
            echo json_encode($arr);
        }


    }

    public function customer_get_support_type()
    {
        $response = array();
        $customer_id = $this->security->xss_clean($this->input->post('customer_id')); //1; //
        $machine_id = $this->security->xss_clean($this->input->post('machine_id'));//1; //

        if (!empty($customer_id && $machine_id)) {

            $support_type_data = $this->Mod_api->get_machine_supporttype_info($machine_id, $customer_id);

            if (!empty($support_type_data)) {


                $start_date = $support_type_data->su_start_date;
                $startDate = date("d M Y", strtotime($start_date));

                $end_date = $support_type_data->su_end_date;
                $endtDate = date("d M Y", strtotime($end_date));


                $now = date('Y-m-d');


                $response = array(
                    'support_type_id' => $support_type_data->su_type_id,
                    'support_type_name' => $support_type_data->service_type_title,
                );

                if ($support_type_data->su_type_id == 1 || $support_type_data->su_type_id == 2) {
                    if (!empty($start_date && $end_date)) {
                        if ($now >= $start_date && $now <= $end_date) {

                            $response['support_type_start_date'] = $startDate;
                            $response['support_type_end_date'] = $endtDate;

                            $response['status'] = 'ok';
                        } else {

                            $response['support_type_start_date'] = $startDate;
                            $response['support_type_end_date'] = $endtDate;

                            $response['status'] = 'Failed';
                            $response['msg'] = 'Your Support Time Already Expire';
                        }
                    }
                } elseif ($support_type_data->su_type_id == 3) {
                    $response['status'] = 'ok';
                    $response['msg'] = 'Warranty Service';
                } elseif ($support_type_data->su_type_id == 4) {
                    $response['status'] = 'ok';
                    $response['msg'] = 'On Call Service';
                }

            }

            echo json_encode($response);
        }

    }


    public function customer_save_ticket()
    {
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $machine_id = $this->security->xss_clean($this->input->post('machine_id'));
        $support_type_id = $this->security->xss_clean($this->input->post('support_type_id'));
        $arr = array();

        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('machine_id', 'Machine', 'required');
        $this->form_validation->set_rules('request_details', 'Problem Details', 'required');

        $this->form_validation->set_rules('contact_person_name', 'Contact Person Name', 'required');
        $this->form_validation->set_rules('contact_person_mobile', 'Contact Person Mobile', 'required');

        if ($this->form_validation->run()) {

            $contact = $this->security->xss_clean($this->input->post('contact_person_mobile'));

            if ($support_type_id == 1 || $support_type_id == 2) {

                $valid_support = $this->Mod_api->support_type_validation($customer_id, $machine_id);

                if ($valid_support == 1) {

                    $generate_ticket_no = $this->Mod_api->save_customer_ticket();

                    if (!empty($generate_ticket_no)) {

                        $arr['status'] = 'ok';
                        $arr['ticket_no'] = $generate_ticket_no[0];
                        $arr['msg'] = 'Your ticket has been submitted. Ticket No. :' . $generate_ticket_no[0];

                        $customer = $generate_ticket_no[1]->customer;
                        $arr['text'] = "Dear Sir/ Madam, Greetings from TVL. Your Ticket no. is $generate_ticket_no[0]. And our service Eng. will contact you immediately. For details, call 01755645555";

                        $ticket = array($contact, $customer);

                        foreach ($ticket as $mobile) {

                            send_sms($mobile, $arr['text']);
                        }


                    } else { //error, show the ticket generating page again
                        $arr['status'] = 'Failed';
                        $arr['msg'] = 'Something went wrong, please try again.';
                    }
                } else {
                    $arr['status'] = 'Failed';
                    $arr['msg'] = 'Your Support Time Already Over';
                }
            } elseif ($support_type_id == 3 || $support_type_id == 4) {
                $generate_ticket_no = $this->Mod_api->save_customer_ticket();

                if (!empty($generate_ticket_no)) {

                    $arr['status'] = 'ok';
                    $arr['ticket_no'] = $generate_ticket_no[0];
                    $arr['msg'] = 'Your ticket has been submitted. Ticket No. :' . $generate_ticket_no[0];

                    $customer = $generate_ticket_no[1]->customer;
                    $arr['text'] = "Dear Sir/ Madam, Greetings from TVL. Your Ticket no. is $generate_ticket_no[0]. And our service Eng. will contact you immediately. For details, call 01755645555";

                    $ticket = array($contact, $customer);

                    foreach ($ticket as $mobile) {

                       send_sms($mobile, $arr['text']);
                    }

                } else { //error, show the ticket generating page again
                    $arr['status'] = 'Failed';
                    $arr['msg'] = 'Something went wrong, please try again.';
                }
            }

        } else {
            $arr['status'] = 'required_field_missing';
            $arr['msg'] = 'Please fill the required fields and try again.';
        }

        echo json_encode($arr);
    }

//======================== ticket list ===========================

    public function customer_get_ticket_list()
    {
        $ticket_status_array = ticket_status_array();
        $service_type_array = get_service_type_array_dropdown();

        $arr_json = array();

        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {

            $arr = $this->Mod_api->get_customer_ticket_list($customer_id);
            if (!empty($arr)) {
                foreach ($arr as $key => $value) {

                    $ticket_status_label = '';
                    $support_type_label = '';

                    if (!empty($value['status'])) {
                        $ticket_status_label = $ticket_status_array[$value['status']];
                    }

                    if (!empty($value['support_type'])) {
                        $support_type_label = $service_type_array[$value['support_type']];
                    }


                    //$machine = $value['mc_name'] . ',' . $value['mc_model'] . ',' . $value['insb_serial'] . ',' . $value['insb_version'];

                    $arr_json[] = array(
                        'id' => $value['srd_id'],
                        'ticket_no' => $value['ticket_no'],
                        'customer_id' => $value['send_from'],
                        'support_type' => $support_type_label,
                        'request_date_time' => date_convert($value['request_date_time']),
                        'created_date_time' => date_convert($value['created_date_time']),
                        'status' => $ticket_status_label,
                        'request_details' => $value['request_details'],
                        'send_to' => $value['send_to'],
                        'machine_ref_id' => $value['machine_ref_id'],
                        'machine_name' => $value['mc_name'],
                        'machine_serial' => $value['insb_serial'],
                        'machine_model' => $value['mc_model'],
                        'last_action_by' => $value['last_action_by'],
                        'last_action_date_time' => $value['last_action_date_time'],
                        'status_for_comment' => $value['status'],
                        'comment_status' => $value['comment_status'],
                    );
                }
            }
            echo json_encode($arr_json);
        }

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


            $data['ticket_details_data'] = array(

                "srd_id" => $ticket->srd_id,
                "machine_ref_id" => $ticket->machine_ref_id,
                "machine_name" => $ticket->mc_name,
                "machine_serial" => $ticket->insb_serial,
                "machine_version" => $ticket->insb_version,
                "ticket_no" => $ticket->ticket_no,
                "contact_person" => $ticket->contact_person,
                "contact_person_phn" => $ticket->contact_person_phn,
                "request_details" => $ticket->request_details,
                "support_type" => $ticket->support_type,
                "created_date_time" => date_convert($ticket->created_date_time),
                "status" => $ticket->status,
                "customer_id" => $ticket->customer_id,
                "name" => $ticket->name,
                "service_type_title" => $ticket->service_type_title,
            );


            $data['ticket_comment_list'] = $this->Mod_api->get_ticket_comment_list_tab($ticket_no);
            $trans = $this->Mod_api->get_ticket_trans_flow_tab($ticket_no);

            if (!empty($trans)) {

                foreach ($trans as $tr) {

                    $Name = '';
                    $created_by_autoId = $tr->created_by;
                    $created_by_type = $tr->created_by_type;
                    /*if ($created_by_type == 'admin') {
                        $Name = get_admin_name_by_id($created_by_autoId);
                    }*/
                    if ($created_by_type == 'customer') {
                        $Name = get_customer_name_by_id($created_by_autoId);
                    } elseif ($created_by_type == 'engineer') {
                        $Name = get_engineer_name_by_id($created_by_autoId);
                    }

                    $arr[] = array(

                        'owner_name' => $Name,
                        'Date' => date_convert($tr->created_date_time),
                        'status' => $tr->status
                    );

                    $data['ticket_trans_flow'] = $arr;
                }
            }

            $eng = $this->Mod_api->get_service_eng_details($ticket_no);

            if (!empty($eng)) {

                $data['service_engineer'] = array(

                    'ser_eng_id' => $eng->ser_eng_id,
                    'ser_eng_code' => $eng->ser_eng_code,
                    'name' => $eng->name,
                    'email' => $eng->email,
                    'mobile' => $eng->mobile,
                    'eng_depart' => $eng->eng_depart,
                    'login_token_id' => $eng->login_token_id,
                    'experience' => $eng->experience,
                    'eng_desig' => $eng->eng_desig,
                    'picture' => ROOT_IMG_URL . 'upload/service_engineer/' . $eng->ser_eng_id . '/' . $eng->picture

                );
            }

            echo json_encode($data);
        }
    }


    public function customer_comment()
    {

        $response = array();

        $this->form_validation->set_rules('comment', 'Customer comment', 'required');

        if ($this->form_validation->run() == true) {

            $comment = $this->Mod_api->save_customer_comment();

            if ($comment == true) {
                $response['status'] = true;
                $response['msg'] = "We get comments successfully";
            } else {
                $response['status'] = false;
                $response['msg'] = "Your comments not submit";
            }

        } else {
            $response['status'] = false;
            $response['msg'] = 'Type your comment';
        }

        echo json_encode($response);
    }


    //============== ticket search ==============================
    public function search()
    {
        $status_arr = array();
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {

            $data['support_type'] = $this->Mod_api->get_support_type($customer_id);
            $arr = ticket_status();
            //$status_arr[]  = array('state' => "",'msg' => "Select");
            foreach ($arr as $key => $value) {
                $status_arr[] = array('state' => $key, 'msg' => $value);
            }
            $data['status'] = $status_arr;
            echo json_encode($data);
        }
    }


    public function get_search_ticket_list()
    {
        $ticket_status_array = ticket_status_array();
        $service_type_array = get_service_type_array_dropdown();
        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));

        if (!empty($customer_id)) {

            $arr_json = array();

            $arr = $this->Mod_api->get_customer_search_ticket_list($customer_id);

            if (!empty($arr)) {
                foreach ($arr as $key => $value) {

                    $ticket_status_label = '';
                    $support_type_label = '';

                    if (!empty($value['status'])) {
                        $ticket_status_label = $ticket_status_array[$value['status']];
                    }

                    if (!empty($value['support_type'])) {
                        $support_type_label = $service_type_array[$value['support_type']];
                    }


                    $machine = $value['mc_name'] . ',' . $value['mc_model'] . ',' . $value['insb_serial'] . ',' . $value['insb_version'];


                    $arr_json[] = array(
                        'id' => $value['srd_id'],
                        'ticket_no' => $value['ticket_no'],
                        'customer_id' => $value['send_from'],
                        'support_type' => $support_type_label,
                        'request_date_time' => date_convert($value['request_date_time']),
                        'created_date_time' => date_convert($value['created_date_time']),
                        'status' => $ticket_status_label,
                        'request_details' => $value['request_details'],
                        'send_to' => $value['send_to'],
                        'machine_ref_id' => $value['machine_ref_id'],
                        'machine_deails' => $machine,
                        'last_action_by' => $value['last_action_by'],
                        'last_action_date_time' => $value['last_action_date_time']
                    );

                }

                $data['data'] = $arr_json;
                $data['status'] = "ok";

            } else {
                $data['status'] = "Data Not Found";
                $data['data'] = array();
            }
            echo json_encode($data);
        }

    }


//================== customer logout =============================

    public function customer_logout()
    {
        $res = array();
        $token_id = $this->security->xss_clean($this->input->post('token_id'));

        if (!empty($token_id)) {

            $data = array(
                'login_token_id' => '',
                'player_id' => ''
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

    function eng_login()
    {

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {

            $arr = array(
                'status' => 'required_field_missing',
                'msg' => 'Required Field Missing'
            );
            echo json_encode($arr);

        } else {
            $arr = $this->Mod_api->validate_login_eng();

            if ($arr['valid_login_engineer'] == true) { // login OK, show the welcome page

                $arr = array(
                    'engineer_id' => $arr['engineer_id'],
                    'engineer_name' => $arr['engineer_name'],
                    'engineer_mobile' => $arr['engineer_mobile'],
                    'engineer_photo' => $arr['engineer_photo'],
                    'status' => 'ok',
                    'msg' => 'Successful',
                    'token_id' => $arr['login_token_id'],
                );

                echo json_encode($arr);

            } else { // login  Failed
                $arr = array(
                    'tokenid' => '',
                    'status' => 'Failed',
                    'msg' => 'Invalid mobile or password'
                );
                echo json_encode($arr);
            }
        }
    }

    //===================== list of ticket ========================


    public function set_eng_player_id()
    {

        $response = array('status' => false, 'msg' => null);
        $engineer_id = $this->input->post('engineer_id');
        $player_id = $this->input->post('player_id');


        if (!empty($engineer_id && $player_id)) {

            $data['player_id'] = $player_id;

            $set_id = $this->Mod_api->set_eng_player_id($engineer_id, $data);

            if ($set_id == true) {

                $response['status'] = true;
                $response['msg'] = 'Player id set';

            } else {
                $response['status'] = false;
                $response['msg'] = 'Player id not set';
            }


        } else {
            $response['status'] = 'set player id';
        }


        echo json_encode($response);


    }


    public function eng_ticket_list()
    {

        $ticket_status_array = ticket_status_array();
        $service_type_array = get_service_type_array_dropdown();
        $priority_array = get_priority_array_dropdown();
        $arr_json = array();

        $engineer_id = $this->security->xss_clean($this->input->post('engineer_id'));

        if (!empty($engineer_id)) {

            $arr = $this->Mod_api->get_ticket_list($engineer_id);

            if (!empty($arr)) {
                foreach ($arr as $key => $value) {

                    $ticket_status_label = '';
                    $support_type_label = '';
                    $priority = '';
                    if (!empty($value['status'])) {
                        $ticket_status_label = $ticket_status_array[$value['status']];
                    }

                    if (!empty($value['support_type'])) {
                        $support_type_label = $service_type_array[$value['support_type']];
                    }

                    if (!empty($value['priority'])) {
                        $priority = $priority_array[$value['priority']];
                    }

                    $ticket_created = $value['created_date_time'];
                    $customer_location = $value['DIVISION_NAME'];


                    $arr_json[] = array(
                        'srd_id' => $value['srd_id'],
                        'kb_id' => $value['ticket_ref_id'],
                        'engineer_id' => $value['send_to'],
                        'ticket_no' => $value['ticket_no'],
                        'machine_name' => $value['mc_name'],
                        'machine_model' => $value['mc_model'],
                        'machine_serial' => $value['insb_serial'],
                        'priority' => $priority,
                        'support_type' => $support_type_label,
                        'contact_person' => $value['contact_person'],
                        'contact_person_phn' => $value['contact_person_phn'],
                        'status' => $ticket_status_label,
                        'ticket_status' => $value['status'],
                        'created_date_time' => date_convert($value['created_date_time']),
                        'lead_time' => working_lead_time($ticket_created, $customer_location),
                    );
                }
            }
            echo json_encode($arr_json);
        }

    }


    public function job_report()
    {

        $id = $this->security->xss_clean($this->input->post('srd_id'));

        if (!empty($id)) {

            $response = array('status' => false, 'msg' => null, 'file' => null);

            $data['comments'] = $this->Mod_api->get_comments($id);
            $data['machine'] = $this->Mod_api->get_equipment_data($id);

            $data['report'] = $this->Mod_api->get_job_report_data($id);
            $data['spare'] = $this->Mod_api->get_spare_parts_data($id);

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
                $response['file'] = $job_report;

            } elseif (is_dir($path) && !empty($job_report)) {

                $response['status'] = true;
                $response['file'] = $job_report;

            } else {
                $response['status'] = false;
                $response['msg'] = 'Report Not generate';
            }

            $this->load->view('sm/serviceengineer/view_job_report', $data, true);


            echo json_encode($response);
        }

    }

    public function action()
    {

        $auto_id = $this->security->xss_clean($this->input->post('srd_id'));
        $engineer_id = $this->security->xss_clean($this->input->post('engineer_id'));

        $priority_array = get_priority_array_dropdown();
        $service_type_array = get_service_type_array_dropdown();
        $ticket_status_array = ticket_status_array();
        $action_arr = array();
        $comment_arr = array();


        if (!empty($auto_id && $engineer_id)) {

            $ticket_details = $this->Mod_api->get_details($auto_id, $engineer_id);

            $kb_id = $ticket_details->ticket_ref_id ? $ticket_details->ticket_ref_id : '';

            $absoulote = 'upload/job_report/' . $ticket_details->srd_id . '/' . $ticket_details->job_report;
            $path = '/var/www/html/trvl/' . $absoulote;
            $base_path = ROOT_IMG_URL . $absoulote;

            if (file_exists($path)) {
                $file = $base_path;
            } else {
                $file = null;
            }

            $data['ticket_info'] = array(

                'srd_id' => $ticket_details->srd_id,
                'customer_id' => $ticket_details->send_from,
                'machine_id' => $ticket_details->machine_ref_id,
                'ticket_no' => $ticket_details->ticket_no,
                'kb_id' => $kb_id,
                'customer' => get_customer_name_by_id($ticket_details->send_from),
                'priority' => $priority_array[$ticket_details->priority],
                'support_type' => $service_type_array[$ticket_details->support_type],
                'request_details' => $ticket_details->request_details,
                'status' => $ticket_details->status,
                'file' => $file,
                'ticket_status' => $ticket_status_array[$ticket_details->status]
            );


            $action = $this->Mod_api->get_ticket_trans_flow_tab($ticket_details->ticket_no);

            if (!empty($action)) {
                foreach ($action as $ac) {
                    $Name = '';
                    $created_by_autoId = $ac->created_by;
                    $created_by_type = $ac->created_by_type;
                    if ($created_by_type == 'admin') {
                        $Name = get_admin_name_by_id($created_by_autoId);
                    } elseif ($created_by_type == 'customer') {
                        $Name = get_customer_name_by_id($created_by_autoId);
                    } elseif ($created_by_type == 'engineer') {
                        $Name = get_engineer_name_by_id($created_by_autoId);
                    }

                    $action_arr[] = array(
                        'owner' => $Name,
                        'created_by_type' => $created_by_type,
                        'ticket_status' => $ticket_status_array[$ac->status]
                    );

                    $data['action_flow'] = $action_arr;
                }
            }

            $comment = $this->Mod_api->get_ticket_comment_list($ticket_details->ticket_no);

            if (!empty($comment)) {
                foreach ($comment as $ac) {

                    $comment_arr[] = array(
                        'owner' => get_commenter_name_by_id($ac->comment_from, $ac->comments_by),
                        'comment_from' => $ac->comment_from,
                        'comments' => $ac->comments,
                        'comments_date' => date_convert($ac->comments_date_time)
                    );
                    $data['comments_log'] = $comment_arr;
                }
            }

        }
        $data['spare'] = $this->Mod_api->get_spare_parts();

        echo json_encode($data);
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
        $response = array('status' => false, 'msg' => null);

        if (!empty($ticket_id)) {

            $upload = $this->Mod_api->report_upload_pdf($ticket_id);

            if ($upload['status'] == true) {

                $response ['status'] = true;
                $response ['msg'] = $upload['msg'];
            } else {
                $response ['msg'] = $upload['msg'];
                $response ['status'] = 'Failed';
            }

        }

        echo json_encode($response);
    }


    function update_ticket_status()
    {

        $response = array();

        $this->form_validation->set_rules('status', 'Ticket Status', 'required');

        if ($this->form_validation->run() == true) {
            $res_flag = $this->Mod_api->update_ticket_status();

            if ($res_flag == true) {
                $response['msg'] = 'Success';
            } else {
                $response ['msg'] = 'Failed To Update. Try again later';
                $response ['status'] = 'Failed';
            }

        } else {
            $response['msg'] = 'Status Required';
            $response['status'] = 'Failed';
        }

        echo json_encode($response);
    }


    //============ first save a knowledge base problem details ================
    public function knowledge_base()
    {
        $ticket_id = $this->security->xss_clean($this->input->post('srd_id'));

        if (!empty($ticket_id)) {

            $ticket = $this->Mod_api->get_ticket_data($ticket_id);

            $data['ticket_details'] = array(
                'ticket_id' => $ticket->srd_id,
                'ticket_no' => $ticket->ticket_no,
                'engineer_id' => $ticket->send_to
            );
            echo json_encode($data);
        }
    }


    public function save_kb()
    {
        $response = array();

        $this->form_validation->set_rules('comment', 'Type Your Comments', 'required');

        if ($this->form_validation->run() == true) {
            $res_flag = $this->Mod_api->save_kb_post();

            if ($res_flag) {
                $response['msg'] = 'Success';
            } else {
                $response ['msg'] = 'Failed To Post Comment. Try again later';
                $response ['status'] = 'Failed';
            }

        } else {
            $response['msg'] = 'Missing Field Required';
            $response['status'] = 'Failed';
        }


        echo json_encode($response);

    }

//=================== after kb post insert then comment all of eng. ========================
    public function kb_list()
    {
        $res = array();
        $data = array();
        $kb = $this->Mod_api->get_kb_list();

        if (!empty($kb)) {
            foreach ($kb as $k) {
                $res[] = array(
                    'kb_id' => $k->id,
                    'ticket_id' => $k->ticket_ref_id,
                    'ticket_no' => $k->ticket_ref_no,
                    'engineer' => $k->name,
                    'problems' => $k->problem_details,
                    'post_date' => str_date($k->posted_date)
                );
                $data['kb_data'] = $res;
            }
        }
        echo json_encode($data);
    }


    public function kb_post_detail()
    {
        $res = array();
        $id = $this->security->xss_clean($this->input->post('kb_id'));

        if (!empty($id)) {

            $kb = $this->Mod_api->get_kb_data_id($id);

            $data['kb_data'] = array(
                'kb_id' => $kb->id,
                'ticket_id' => $kb->ticket_ref_id,
                'ticket_no' => $kb->ticket_ref_no,
                'engineer' => $kb->name,
                'problems' => $kb->problem_details,
                'post_date' => str_date($kb->posted_date),
                'engineer_id' => $kb->posted_by_eng_id
            );

            $kb_comments = $this->Mod_api->get_comment_data($id);

            if (!empty($kb_comments)) {
                foreach ($kb_comments as $comment) {

                    $res[] = array(
                        'id' => $comment->id,
                        'eng_name' => $comment->name,
                        'comments' => $comment->comment,
                        'comment_date' => str_date($comment->comment_date),
                    );

                    $data['kb_comments'] = $res;
                }
            }
            echo json_encode($data);
        }

    }


    // ============ after save comment give comment ==============
    public function comment_save()
    {
        $response = array();

        $this->form_validation->set_rules('kb_comment', 'Type Your Comments', 'required');

        if ($this->form_validation->run() == true) {
            $res_flag = $this->Mod_api->save_kb_comment();

            if ($res_flag) {
                $response['msg'] = 'Success';
            } else {
                $response ['msg'] = 'Failed To Post Comment. Try again later';
                $response ['status'] = 'Failed';
            }

        } else {
            $response['msg'] = 'Missing Field Required';
            $response['status'] = 'Failed';
        }

        echo json_encode($response);


    }


}