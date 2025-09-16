<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/13/18
 * Time: 4:35 PM
 */
date_default_timezone_set('Asia/Dhaka');

class Mod_api extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

//======================== portion for forgot pass ========================
    public function store_one_time_pass($mobile, $random, $user = null)
    {
        if ($user) {
            if (!property_exists($user, 'mobile')) {
                $this->db->where('phone', $mobile);
                $this->db->update('customer_sub_login', array('password' => md5($random)));
                return true;
            }
        }

        $this->db->where('mobile', $mobile);
        $this->db->update('customer', array('otp_pass' => $random));
        return true;
    }

    public function check_valid_mobile($mobile)
    {

        $this->db->where('phone', $mobile);
        $query = $this->db->get('customer_sub_login');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            $this->db->where('mobile', $mobile);
            $query = $this->db->get('customer');
            if ($query->num_rows() > 0) {
                return $query->row();
            }
            return false;
        }

    }

    public function blank_one_time_pass($mobile)
    {

        $this->db->where('mobile', $mobile);
        $this->db->update('customer', array('otp_pass' => ''));
        return true;
    }

    public function check_valid_otp($mobile, $pass)
    {
        $this->db->where('mobile', $mobile);
        $this->db->where('otp_pass', $pass);
        $query = $this->db->get('customer');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function check_exist()
    {

        $cMobile = $this->input->post('phone');
        $otp     = $this->input->post('otp');

        $this->db->where(['phone' => $cMobile, 'otp_pass' => $otp]);
        $query = $this->db->get('customer_sub_login');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function update_pass($mobile, $password)
    {

        $this->db->where('mobile', $mobile);
        $this->db->update('customer', array('password' => $password));
        return true;
    }

//=========================================================================
    //=============global function ===================

    function validate_customer_login($mobile, $password)
    {
        $sm_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $config    = [];
        $db_pass = '';


        $query = $sm_db->select('customer_id,name,password,mobile,status,picture,verify_otp');
        //$query = $sm_db->where('status', 'A');
        $query = $sm_db->where('mobile', $mobile);

        $query = $sm_db->get('customer');
        //print_r($sm_db->last_query()); exit();

        if ($query->num_rows() > 0) {
            $row       = $query->row();
            $db_pass   = $row->password;
            $id        = $row->customer_id;
            $name      = $row->name;
            $mobile_db = $row->mobile;
            if ($db_pass == $password) {  // pass match, login valid
                //print_r($password); exit();
                if ($row->status == "A") {

                    $arr['cPhoto']               = $row->picture != null ? ROOT_IMG_URL . 'upload/customer_image/' . $row->customer_id . '/' . $row->picture : '';
                    $arr['customer_acc_status']  = 'active';
                    $arr['customer_valid_login'] = true;
                    $arr['customer_id']          = $id;
                    $arr['customer_name']        = $name;
                    $arr['customer_mobile']      = $mobile_db;
                    $arr['is_phone_number_verified'] = true;
                    $arr['is_sub_customer']      = false;
                    $arr['sub_customer']         = null;

                    // if successfully update return updated token
                    $token_id['login_token_id'] = $this->generate_random_token(10);
                    $this->db->where('customer_id', $id);
                    $this->db->update('customer', $token_id);

                    $arr['login_token_id'] = $token_id['login_token_id'];

                } elseif ($row->verify_otp != null) {

                    $arr['customer_valid_login'] = true;
                    $arr['customer_acc_status']  = 'unverified';

                } else {
                    $arr['customer_valid_login'] = true;
                    $arr['customer_acc_status']  = 'inactive';
                }

                return $arr;
            } else {        // pass did not match, invalid login
                return false;
            }
        } else {           // record was not found, invalid login, return false
            $sm_db->select('csl.id, csl.username sub_name, csl.email sub_email, csl.phone sub_phone, csl.otp_pass sms_otp, csl.status sub_status, c.customer_id,c.name, c.picture, csl.password,c.mobile,c.status');
            //$sm_db->where('csl.status', '1');
            $sm_db->group_start()
                ->where('csl.username', $mobile)
                ->or_where('csl.phone', $mobile)
                ->group_end();
            $sm_db->join('customer c', 'c.customer_id=csl.customer_id', 'left');
            $query = $sm_db->get('customer_sub_login csl');

            if ($query->num_rows()) {
                $row                = $query->row();
                $db_pass            = $row->password;
                $id                 = $row->customer_id;
                $name               = $row->name;
                $mobile_db          = $row->mobile;
                $sub_customer_id    = $row->id;

                if ($db_pass == md5($password)) {  // pass match, login valid
                    $arr['customer_valid_login'] = true;
                    $arr['cPhoto']               = $row->picture != null ? ROOT_IMG_URL . 'upload/customer_image/' . $row->customer_id . '/' . $row->picture : '';
                    $arr['customer_acc_status']  = $row->sub_status == 1 && $row->status == 'A' ? 'active' : 'inactive';
                    $arr['customer_id']          = $id;
                    $arr['customer_name']        = $name;
                    $arr['customer_mobile']      = $mobile_db;
                    $arr['is_phone_number_verified'] = ($row->sms_otp == 'verified');
                    $arr['is_sub_customer_id']   = true;
                    $arr['sub_customer']         = [
                        'id' => $sub_customer_id,
                        'name' => $row->sub_name,
                        'email' => $row->sub_email,
                        'phone' => $row->sub_phone,
                        'otp' => $row->sms_otp
                    ];

                    // if successfully update return updated token
                    $token_id['login_token_id'] = $this->generate_random_token(10);
                    $this->db->where('customer_id', $id);
                    $this->db->update('customer', $token_id);
                    $arr['login_token_id'] = $token_id['login_token_id'];

                    return $arr;
                } else {        // pass did not match, invalid login
                    return false;
                }
            }
            return false;
        }
    }

    public function validate_customer_login_otp ($phone, $otp) {
        $sm_db   = $this->load->database('icel', TRUE); /* database conection for read operation */

        $sm_db->select('csl.id,csl.username sub_name,csl.email sub_email,csl.phone sub_phone, csl.otp_pass sms_otp, c.customer_id,c.name, c.picture, csl.password,c.mobile,c.status');
        //$sm_db->where('csl.status', '1');
        $sm_db->where('csl.otp_pass', $otp);
        $sm_db->group_start()
            ->where('csl.username', $phone)
            ->or_where('csl.phone', $phone)
            ->group_end();
        $sm_db->join('customer c', 'c.customer_id=csl.customer_id', 'left');
        $query = $sm_db->get('customer_sub_login csl');

        if ($query->num_rows()) {
            $row                = $query->row();
            $db_pass            = $row->password;
            $id                 = $row->customer_id;
            $name               = $row->name;
            $mobile_db          = $row->mobile;
            $sub_customer_id    = $row->id;

            $arr['customer_valid_login'] = true;
            $arr['cPhoto']               = $row->picture != null ? ROOT_IMG_URL . 'upload/customer_image/' . $row->customer_id . '/' . $row->picture : '';
            $arr['customer_acc_status']  = $row->status == 1 ? 'active' : 'inactive';
            $arr['customer_id']          = $id;
            $arr['customer_name']        = $name;
            $arr['customer_mobile']      = $mobile_db;
            $arr['is_phone_number_verified'] = ($row->sms_otp == 'verified');
            $arr['is_sub_customer_id']   = true;
            $arr['sub_customer']         = [
                'id' => $sub_customer_id,
                'name' => $row->sub_name,
                'email' => $row->sub_email,
                'phone' => $row->sub_phone,
                'otp' => $row->sms_otp
            ];

            // if successfully update return updated token
            $token_id['login_token_id'] = $this->generate_random_token(10);
            $this->db->where('customer_id', $id);
            $this->db->update('customer', $token_id);
            $arr['login_token_id'] = $token_id['login_token_id'];

            return $arr;
        }
        return false;
    }

    function generate_random_token($length = 10)
    {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }

    public function get_customer_wise_machine($customer_id = null, $sub_customer_id = null)
    {

        $result = "";
        $this->db->select('machine.*,ins.insb_id,ins.insb_serial,ins.insb_version,ins.picture,ins.dep_ref_id');
        $this->db->join('install_base ins', 'ins.insb_machine=machine.mc_id', 'left');
        if ($customer_id) $this->db->where('ins.insb_customer', $customer_id);
        if ($sub_customer_id) $this->db->where('ins.customer_id_sub', $sub_customer_id);

        $this->db->where('ins.insb_machine = machine.mc_id');
        if ($this->input->post('is_sub_cust')) {
            $this->db->where('ins.customer_id_sub', $this->input->post('is_sub_cust'));
        }

        $this->db->where('ins.support_type !=', 5);
        $this->db->where('ins.support_type !=', 6);
        //$this->db->group_by('machine.mc_id');
        $query = $this->db->get('machine');
        //print_r($this->db->last_query());die();
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }


    //================= set player id ===================================

    public function set_player_id($customer_id, $data)
    {

        $this->db->where('customer_id', $customer_id);
        $update = $this->db->update('customer', $data);

        if ($update > 0) {

            return true;
        } else {
            return false;
        }


    }


    public function set_eng_player_id($engineer_id, $data)
    {

        $this->db->where('ser_eng_id', $engineer_id);
        $update = $this->db->update('sm_service_engineer', $data);

        if ($update > 0) {

            return true;
        } else {
            return false;
        }


    }

    public function set_spv_player_id($spv_id, $data)
    {

        $this->db->where('id', $spv_id);
        $update = $this->db->update('sm_admin', $data);
        if ($update > 0) {

            return true;
        } else {
            return false;
        }


    }


    public function save_customer_comment()
    {
        $ticket_no = $this->input->post('ticket_id');
        if (!empty($ticket_no)) {
            $comment = $this->input->post('comment');
            $rating  = $this->input->post('rating');
            $data = array(
                'cm_on_eng'      => $comment,
                'rating_on_eng'  => $rating,
                'comment_status' => 'c'
            );
            return $this->db->update('sm_service_request_dtl', $data, ['ticket_no' => $ticket_no]);
        }
        return false;
    }

    /*
     * save new ticket for customer
     */

    public function get_machine_supporttype_info($machine_id, $customer_id)
    {

        $this->db->select('su_type.*,service.service_type_title,install_base.insb_install_date,
                           install_base.insb_warranty_date,install_base.dep_ref_id');
        $this->db->join('sm_service_type service', 'service.service_type_id = su_type.su_type_id', 'left');
        $this->db->join('install_base', 'install_base.insb_id = su_type.install_base_ref_id', 'left');

        $this->db->where('su_type.su_machine_id', $machine_id);
        $this->db->where('su_type.su_cust_ref_id', $customer_id);
        $this->db->where('su_type.status', 1);
        $this->db->order_by('su_type.su_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('cust_support_type su_type');
        return $query->row();
    }

    public function support_type_validation($customer_id, $machine_id)
    {
        $date_now = date('Y-m-d');

        $this->db->where('su_start_date <=', $date_now);
        $this->db->where('su_end_date >=', $date_now);
        $this->db->where('su_cust_ref_id', $customer_id);
        $this->db->where('su_machine_id', $machine_id);
        $this->db->order_by('su_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('cust_support_type');

        return $query->num_rows();

    }

    //=============================================================================

    public function save_customer_signup_info()
    {
        $response = array('status' => false, 'msg' => null, 'data' => null);
        $datetime = date('Y-m-d H:i:s');

        //======= customer basic info ========
        $cust_id    = $this->input->post('cust_id');
        $username   = $this->input->post('username');
        $email      = $this->input->post('email');
        $phone      = $this->input->post('phone');
        $password   = $this->input->post('password');
        $confirm    = $this->input->post('confirm');
        $otp        = random_num();

        //======== Machine Details ========
        $machine_id     = $this->input->post('machine_id');
        $department_id  = $this->input->post('department_id');
        $business_id    = $this->input->post('business_id');
        $sector         = $this->input->post('sector');
        $serial         = $this->input->post('serial');

        $data = array(
            'customer_id'          => $cust_id,
            'username'             => $username,
            'password'             => md5($password),
            'email'                => $email,
            'phone'                => $phone,
            'otp_pass'             => $otp,
            'created_at'           => $datetime,
            'login_token_id'       => md5(random_num())
        );

        $this->db->trans_begin();

        $this->db->insert('customer_sub_login', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $machine_details = [
                'insb_customer'         => $cust_id,
                'dep_ref_id'            => $department_id,
                'insb_business_area'    => $business_id,
                'insb_sector'           => $sector,
                'insb_machine'          => $machine_id,
                'insb_serial'           => $serial,
                'status'                => '1',
                'support_type'          => '4',
                'customer_id_sub'       => $insert_id
            ];
            $this->db->insert('install_base', $machine_details);
            $install_base_id = $this->db->insert_id();
            if (!empty($_FILES['picture']['name'])) {
                $picture = $this->_do_upload_machine($install_base_id);
                $this->db->update('install_base', ['picture' => $picture], array('insb_id' => $install_base_id));
            }

            $support_type = array(
                'su_type_id'          => '4',
                'su_cust_ref_id'      => $cust_id,
                'su_machine_id'       => $machine_id,
                'install_base_ref_id' => $install_base_id,
                'status'              => '1',
                'created'             => $datetime
            );
            $this->db->insert('cust_support_type', $support_type);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $response['msg'] = 'Success';
                $response['status'] = true;
                $response['data'] = [
                    'sub_customer' => $data,
                    'machine' => $machine_details,
                    'support_type' => $support_type,
                    'sub_cust_id' => $insert_id
                ];
            }
        } else {
            $response['msg'] = 'Insertion error!';
        }

        return $response;

    }

    private function _do_upload_machine($master_insert_id)
    {
        $structure = './upload/install_base/' . $master_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }

        $config['upload_path']   = $structure;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx';
        $config['max_size']      = 2200;
        $config['encrypt_name']  = true;
        $config['overwrite']     = false;

        $this->load->library('upload', $config);
        $this->load->initialize($config);
        if (!$this->upload->do_upload('picture'))
        {
            $data['inputerror'][]   = 'insReport';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status']         = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }


//========================== customer sign-up ==========================================


    public function get_division_list()
    {
        $this->db->select('DIVISION_ID,DIVISION_NAME');
        $this->db->order_by('DIVISION_NAME', 'ASC');
        $query = $this->db->get('divisions');

        return $query->result();
    }

    function get_district_list($divs_id)
    {

        $this->db->select('DISTRICT_ID,DISTRICT_NAME');

        $this->db->where('DIVISION_ID', $divs_id);
        $this->db->order_by('DISTRICT_NAME', 'ASC');
        $query = $this->db->get('districts');
        return $query->result();
    }


    function get_thana_list($dis_id)
    {
        $query = $this->db->select('THANA_ID,THANA_NAME');
        $query = $this->db->order_by('THANA_NAME', 'ASC');
        $this->db->where('DISTRICT_ID', $dis_id);
        $query = $this->db->get('thanas');

        //print_r($this->db->last_query()); exit;
        return $query->result();
    }


    //=================== view customer profile and update ===========================

    function get_view($customer_id)
    {
        $this->db->select('customer.*,customer_contact_person_dtl.*,thanas.THANA_NAME');
        $this->db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
        $this->db->join('thanas', 'customer.contact_add_upazila = thanas.THANA_ID', 'left');
        $this->db->where("customer.customer_id", $customer_id);
        $query = $this->db->get('customer');

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $cust_id              = $row->customer_id;
            $customer_name        = $row->name;
            $customer_email       = $row->email;
            $mobile               = $row->mobile;
            $telephone            = $row->telephone_no;
            $customer_pic         = $row->picture;
            $division             = get_division_by_id($row->contact_add_division);
            $district             = get_district_by_id($row->contact_add_district);
            $thana                = $row->THANA_NAME;
            $customer_flat        = $row->cust_flat;
            $customer_road        = $row->cust_road;
            $customer_post        = $row->cust_post;
            $cust_post_code       = $row->cust_post_code;
            $contact_person       = $row->contact_person_name;
            $contact_person_email = $row->contact_person_email;
            $contact_person_des   = $row->contact_person_desig;
            $contact_person_phone = $row->contact_person_phone;


            $data['c_id']           = $cust_id;
            $data['c_name']         = $customer_name;
            $data['c_email']        = $customer_email;
            $data['c_mobile']       = $mobile;
            $data['c_telephone_no'] = $telephone;
            $data['picture']        = $customer_pic ? ROOT_IMG_URL . 'upload/customer_image/' . $cust_id . '/' . $customer_pic : '';
            $data['c_division']     = $division;
            $data['c_district']     = $district;
            $data['c_thana']        = $thana;

            $data['customer_flat']  = $customer_flat;
            $data['customer_road']  = $customer_road;
            $data['customer_post']  = $customer_post;
            $data['cust_post_code'] = $cust_post_code;

            $data['contact_person']       = $contact_person;
            $data['contact_person_email'] = $contact_person_email;
            $data['contact_person_des']   = $contact_person_des;
            $data['contact_person_phone'] = $contact_person_phone;

            return $data;

        } else {
            return null;
        }
    }

//=============== profile edit ====================================================

    function get_profile($customer_id)
    {
        $this->db->select('customer.*,customer_contact_person_dtl.*');
        $this->db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
        $this->db->where("customer.customer_id", $customer_id);
        $query = $this->db->get('customer');

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $cust_id        = $row->customer_id;
            $customer_name  = $row->name;
            $customer_email = $row->email;
            $mobile         = $row->mobile;
            $telephone      = $row->telephone_no;
            $customer_pic   = $row->picture;
            $customer_pass  = $row->password;
            $division       = $row->contact_add_division;
            $district       = $row->contact_add_district;
            $thana          = $row->contact_add_upazila;
            $customer_flat  = $row->cust_flat;
            $customer_road  = $row->cust_road;
            $cust_post_code = $row->cust_post_code;
            $customer_post  = $row->cust_post;

            $contact_person       = $row->contact_person_name;
            $contact_person_email = $row->contact_person_email;
            $contact_person_des   = $row->contact_person_desig;
            $contact_person_phone = $row->contact_person_phone;


            $data['c_id']           = $cust_id;
            $data['c_name']         = $customer_name;
            $data['c_email']        = $customer_email;
            $data['c_mobile']       = $mobile;
            $data['c_telephone_no'] = $telephone;
            //base64_image_convert('D:/xampp/htdocs/bigm/tvl-api/upload/customer_image/' . $cust_id . '/' . $customer_pic);
            //base64_image_convert('/var/www/html/trvl/upload/customer_image/' . $cust_id . '/' . $customer_pic);
            $data['cPhoto'] = $customer_pic ?  ROOT_IMG_URL . 'upload/customer_image/' . $cust_id . '/' . $customer_pic : '';

            $data['password'] = $customer_pass;

            $data['cFlat']  = $customer_flat;
            $data['cRoad']  = $customer_road;
            $data['cPost']  = $customer_post;
            $data['cPCode'] = $cust_post_code;

            $data['contact_person']       = $contact_person;
            $data['contact_person_email'] = $contact_person_email;
            $data['contact_person_des']   = $contact_person_des;
            $data['contact_person_phone'] = $contact_person_phone;

            return $data;

        } else {
            return null;
        }
    }


    public function update_profile($customer_id)
    {

        $response = array('status' => false, 'msg' => null);

        $datetime = date('Y-m-d H:i:s');

        //======= customer basic info ========
        $cName   = $this->input->post('cName');
        $cEmail  = $this->input->post('cEmail');
        $cMobile = $this->input->post('cMobile');
        $tel     = $this->input->post('cTel');
        //$password = $this->input->post('password');


        //======== customer address info ======
        $cFlat  = $this->input->post('cFlat');
        $cRoad  = $this->input->post('cRoad');
        $cPost  = $this->input->post('cPost');
        $cPCode = $this->input->post('cPCode');


        //======== contact person info ========
        $pName   = $this->input->post('pName');
        $pDes    = $this->input->post('pDes');
        $pEmail  = $this->input->post('pEmail');
        $pMobile = $this->input->post('pMobile');

        //========== customer basic info ===========f

        $data = array(
            'name'              => $cName,
            'email'             => $cEmail,
            'mobile'            => $cMobile,
            'telephone_no'      => $tel,
            'cust_flat'         => $cFlat,
            'cust_road'         => $cRoad,
            'cust_post'         => $cPost,
            'cust_post_code'    => $cPCode,
            'updated_date_time' => $datetime,
        );

        /*if ($password) {
            $data['password'] = $password;
        }*/

        $this->db->where('customer_id', $customer_id);
        $update = $this->db->update('customer', $data);

        // =========== customer contact person info ===========
        if ($update == 1) {

            $contact_person = array(
                'ref_customer_id'      => $customer_id,
                'contact_person_name'  => $pName,
                'contact_person_desig' => $pDes,
                'contact_person_email' => $pEmail,
                'contact_person_phone' => $pMobile,
            );

            $this->db->where('ref_customer_id', $customer_id);
            $update2 = $this->db->update('customer_contact_person_dtl', $contact_person);


            if (!empty($_POST['cPhoto'])) {


                $path = '/var/www/html/service_demo/upload/customer_image/' . trim($customer_id);
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $image_name = $cMobile;


                $upload = base64_image_upload($_POST['cPhoto'], $path, $image_name);

                if ($upload['status'] == true) {
                    $response['data'] = ['picture' => $upload['file_name']];
                    $upload_images['picture'] = $upload['file_name'];

                    $this->db->update('customer', $upload_images, array('customer_id' => $customer_id));
                } else {
                    $response['msg'] = $upload['msg'];
                }

            }
            $response['status'] = true;
        } else {
            $response['msg'] = 'Insertion error!';
        }


        return $response;

    }


    public function get_last_update_data($customer_id)
    {

        $this->db->select('customer.*,customer_contact_person_dtl.*');
        $this->db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
        $this->db->where("customer.customer_id", $customer_id);
        $query = $this->db->get('customer');

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $cust_id        = $row->customer_id;
            $customer_name  = $row->name;
            $customer_email = $row->email;
            $mobile         = $row->mobile;
            $telephone      = $row->telephone_no;
            $customer_pic   = $row->picture;
            $customer_pass  = $row->password;
            $division       = $row->contact_add_division;
            $district       = $row->contact_add_district;
            $thana          = $row->contact_add_upazila;
            $customer_flat  = $row->cust_flat;
            $customer_road  = $row->cust_road;
            $cust_post_code = $row->cust_post_code;
            $customer_post  = $row->cust_post;

            $contact_person       = $row->contact_person_name;
            $contact_person_email = $row->contact_person_email;
            $contact_person_des   = $row->contact_person_desig;
            $contact_person_phone = $row->contact_person_phone;


            $data['c_id']           = $cust_id;
            $data['c_name']         = $customer_name;
            $data['c_email']        = $customer_email;
            $data['c_mobile']       = $mobile;
            $data['c_telephone_no'] = $telephone;
            //base64_image_convert('D:/xampp/htdocs/bigm/tvl-api/upload/customer_image/' . $cust_id . '/' . $customer_pic);
            //base64_image_convert('/var/www/html/trvl/upload/customer_image/' . $cust_id . '/' . $customer_pic);
            $data['cPhoto'] = $customer_pic ?  base64_image_convert('/var/www/html/trvl/upload/customer_image/' . $cust_id . '/' . $customer_pic) : '';

            $data['password'] = $customer_pass;

            $data['cFlat']  = $customer_flat;
            $data['cRoad']  = $customer_road;
            $data['cPost']  = $customer_post;
            $data['cPCode'] = $cust_post_code;

            $data['contact_person']       = $contact_person;
            $data['contact_person_email'] = $contact_person_email;
            $data['contact_person_des']   = $contact_person_des;
            $data['contact_person_phone'] = $contact_person_phone;

            return $data;
        } else {
            return false;
        }

    }


    function check_user_mobile_uniq_edit($user_mobile, $hidden_customer_id)
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $sm_db->select('mobile');
        $query = $sm_db->where("mobile", $user_mobile);
        $query = $sm_db->where('customer_id!=', $hidden_customer_id);
        $query = $sm_db->get('customer');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

// ================ config for image upload ===================

    function save_customer_ticket()
    {

        $read_db            = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $generate_ticket_no = $this->generate_ticket_no();

        $datetime        = date('Y-m-d H:i:s');
        $month           = date("m");
        $year            = date("Y");
        $status          = 'P'; //pending, initaly all tickets are in pending status
        $created_by_type = 'customer';

        $send_from = $this->security->xss_clean($this->input->post('customer_id'));

        $contact_persone = $this->security->xss_clean($this->input->post('contact_person_mobile'));

        $data_arry = array(
            'ticket_no'          => $generate_ticket_no,
            'send_from'          => $send_from,
            'support_type'       => $this->security->xss_clean($this->input->post('support_type_id')),
            'request_details'    => $this->security->xss_clean($this->input->post('request_details')),
            'machine_ref_id'     => $this->security->xss_clean($this->input->post('machine_id')),
            'machine_serial'     => $this->security->xss_clean($this->input->post('machine_serial')),
            'ref_insb_id'        => $this->security->xss_clean($this->input->post('insb_id')),
            'contact_person'     => $this->security->xss_clean($this->input->post('contact_person_name')),
            'contact_person_phn' => $this->security->xss_clean($this->input->post('contact_person_mobile')),
            'dep_ref_id'         => $this->security->xss_clean($this->input->post('department')),
            'request_date_time'  => $datetime,
            'created_date_time'  => $datetime,
            'created_by'         => $send_from,
            'created_by_type'    => $created_by_type,
            'st_flag'    		 => '0',
            'status'             => $status,
        );

        if (isset($_POST['sub_customer_id']) && !empty($this->input->post('sub_customer_id'))) {
            $data_arry['is_sub_customer'] = $this->security->xss_clean($this->input->post('sub_customer_id'));
        }

        $read_db->insert('sm_service_request_dtl', $data_arry);
        $master_insert_id = $read_db->insert_id();

        $data_arry_trans = array(
            'ref_srd_id'        => $master_insert_id,
            'ticket_no'         => $generate_ticket_no,
            'send_from'         => $send_from,
            'support_type'      => $this->security->xss_clean($this->input->post('support_type_id')),
            'request_details'   => $this->security->xss_clean($this->input->post('request_details')),
            'machine_ref_id'    => $this->security->xss_clean($this->input->post('machine_id')),
            'dep_ref_id'        => $this->security->xss_clean($this->input->post('department')),
            'month'             => $month,
            'year'              => $year,
            'request_date_time' => $datetime,
            'created_date_time' => $datetime,
            'status'            => $status,
            'created_by'        => $send_from,
            'created_by_type'   => $created_by_type,
        );

        $read_db->insert('sm_service_request_dtl_trans', $data_arry_trans);
        /*$sms_arr = array(
            'ticket_no' => $generate_ticket_no,
            'mobile_no' => ''
        );
        send_new_ticket_sms($sms_arr);*/

        if (!empty($master_insert_id)) {

            $read_db->select('mobile customer');
            $read_db->where('customer_id', $send_from);
            $query  = $read_db->get('customer');
            $result = $query->row();

            $ticket = array('0' => $generate_ticket_no, '1' => $result);
            return $ticket;
        } else {
            return false;
        }
    }


//============================ save customer ticket ======================================

    function generate_ticket_no()
    {
        $icel_db       = $this->load->database('icel', TRUE);
        $ticket_number = '';
        $intticket     = '';
        $s1            = 'T';
        $sql           = "select max( substring( ticket_no, 4, 8 ) ) as maxno from sm_service_request_dtl";
        $query         = $icel_db->query($sql);
        $R             = $query->row();
        if (!empty($R)) {
            $nextNo = $R->maxno + 1;
        } else {
            $nextNo = 1;
        }
        $intticket     = sprintf("%08d", $nextNo);
        $ticket_number = "$s1" . $intticket;

        return $ticket_number;
    }


//================================================================================

    function get_customer_ticket_list($customer_auto_id, $sub_cust_id = null)
    {

        $this->db->select('service.*,machine.*,install_base.insb_serial,install_base.insb_version, dep.name department');
        $this->db->join('machine', 'service.machine_ref_id = machine.mc_id', 'left');
        $this->db->join('install_base', 'install_base.insb_id = service.ref_insb_id', 'left');
        $this->db->join('medical_department dep', 'service.dep_ref_id = dep.id', 'left');

        if (isset($_POST['is_sub_cust']) && !empty($this->input->post('is_sub_cust'))) {
            $this->db->where('service.is_sub_customer', $this->input->post('is_sub_cust'));
        }

        $this->db->where("service.send_from", $customer_auto_id);
        $this->db->where("service.st_flag", 0);
        if ($sub_cust_id) $this->db->where("service.is_sub_customer", $sub_cust_id);

        $this->db->group_by('service.srd_id');
        $this->db->order_by("service.srd_id", 'DESC');

        $query = $this->db->get('sm_service_request_dtl service');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }


//=============== customer ticket details ==================================

    function get_ticket_details($ticket_no)
    {
        $this->db->select('ticket.*,machine.*,customer.customer_id,customer.name,sm_service_type.service_type_title,
                          cust_contact.contact_person_name,cust_contact.contact_person_desig,
                          cust_contact.contact_person_phone,cust_contact.contact_person_email,
                          install_base.insb_serial,install_base.insb_version');

        $this->db->join('sm_service_type', 'ticket.support_type = sm_service_type.service_type_id', 'left');
        $this->db->join('customer', 'customer.customer_id=ticket.send_from', 'left');
        $this->db->join('customer_contact_person_dtl cust_contact', 'customer.customer_id=cust_contact.ref_customer_id', 'left');
        $this->db->join('machine', 'ticket.machine_ref_id=machine.mc_id', 'left');
        $this->db->join('install_base', 'ticket.ref_insb_id=install_base.insb_id', 'left');

        $this->db->where("ticket.ticket_no", $ticket_no);

        $query = $this->db->get('sm_service_request_dtl ticket');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }


    function get_ticket_comment_list_tab($ticket_no)
    {
        $result = "";

        $this->db->where('ticket_no', $ticket_no);
        $this->db->order_by("src_id", 'ASC');
        $query = $this->db->get('sm_service_request_dtl_comments');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }


    function get_service_eng_details($ticket_no)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $read_db->select('eng.*,department.name eng_depart,designation.name eng_desig');

        $read_db->join('sm_service_engineer eng', 'ticket.send_to=eng.ser_eng_id', 'right');
        $read_db->join('department', 'eng.department=department.id', 'left');
        $read_db->join('designation', 'eng.designation=designation.id', 'left');

        $query = $read_db->where("ticket.ticket_no", $ticket_no);
        $query = $read_db->get('sm_service_request_dtl  ticket');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            //$data=  $record->picture;

            //$arr = ROOT_IMG_URL . 'upload/service_engineer/'. $record->picture;

            return $record;
        } else {
            return null;
        }
    }


// ============================ ticket search ===========================
    public function get_support_type($customer_id, $sub_customer_id = 'null')
    {
        $this->db->select('su_type.*,service.service_type_title');
        $this->db->from('cust_support_type su_type');
        $this->db->join('sm_service_type service', 'service.service_type_id = su_type.su_type_id', 'left');
        $this->db->join('install_base', 'install_base.insb_id = su_type.install_base_ref_id', 'left');
        $this->db->where('su_type.su_cust_ref_id', $customer_id);
        $this->db->where('su_type.status', 1);
        if (!empty($sub_customer_id)) $this->db->where('install_base.customer_id_sub', $sub_customer_id);
        $this->db->group_by('su_type.su_type_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_customer_search_ticket_list($customer_id)
    {
        $result        = "";
        $support_type  = $this->security->xss_clean($this->input->post('support_type'));
        $department_id = $this->security->xss_clean($this->input->post('dept_id'));
        $status        = $this->security->xss_clean($this->input->post('status'));
        $ticket_no     = $this->security->xss_clean($this->input->post('ticket_no'));
        $dateFrom      = trim($this->security->xss_clean($this->input->post('dateFrom')));
        $dateTo        = trim($this->security->xss_clean($this->input->post('dateTo')));
        $sub_customer_id = $this->security->xss_clean($this->input->post('sub_customer_id'));

        if (!empty($support_type)) $this->db->where("service.support_type", $support_type);
        if (!empty($status)) $this->db->where("service.status", $status);
        if (!empty($ticket_no)) $this->db->where("service.ticket_no", $ticket_no);
        if (!empty($department_id)) $this->db->where("install_base.dep_ref_id", $department_id);
        if (!empty($sub_customer_id)) $this->db->where("service.is_sub_customer", $sub_customer_id);

        if (!empty($dateFrom)) {
            $date_from = date('Y-m-d 00:00:00', strtotime($dateFrom));
            $this->db->where('service.created_date_time >=', $date_from);
        }

        if (!empty($dateTo)) {
            $date_to = date('Y-m-d 23:59:59', strtotime($dateTo));
            $this->db->where('service.created_date_time <=', $date_to);
        }

        $this->db->select('service.*,machine.*,install_base.insb_serial,install_base.insb_version,install_base.dep_ref_id, dep.name department');
        $this->db->join('machine', 'service.machine_ref_id = machine.mc_id', 'left');
        $this->db->join('install_base', 'install_base.insb_machine = machine.mc_id', 'left');
        $this->db->join('medical_department dep', 'service.dep_ref_id = dep.id', 'left');
        $this->db->where("service.send_from", $customer_id);
        $this->db->where('service.send_from = install_base.insb_customer');
        $this->db->order_by("service.srd_id", 'DESC');
        $this->db->group_by("service.srd_id");
        $query = $this->db->get('sm_service_request_dtl service');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
    }


//================== service eng. =====================================================

    function validate_login_eng()
    {

        $db_pass = '';

        $mobile   = $this->security->xss_clean($this->input->post('mobile'));
        $password = $this->security->xss_clean($this->input->post('password'));

        $this->db->select('ser_eng_id,name,mobile,password,status,picture');
        $this->db->where('status', 'A');
        $this->db->where('mobile', $mobile);
        $query = $this->db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $db_pass   = $row->password;
            $id        = $row->ser_eng_id;
            $name      = $row->name;
            $mobile_db = $row->mobile;

            if ($db_pass == $password) {  // pass match, login valid
                $arr['engineer_photo']       = ROOT_IMG_URL . 'upload/service_engineer/' . $id . '/' . $row->picture;
                $arr['engineer_valid_login'] = true;
                $arr['engineer_id']          = $id;
                $arr['engineer_name']        = $name;
                $arr['engineer_mobile']      = $mobile_db;
                $arr['valid_login_engineer'] = true;

                // if successfully update return updated token
                $token_id['login_token_id'] = $this->generate_random_token(10);
                $this->db->where('ser_eng_id', $id);
                $this->db->update('sm_service_engineer', $token_id);
                $arr['login_token_id'] = $token_id['login_token_id'];

                return $arr;
            } else {        // pass did not match, invalid login
                return false;
            }
        } else {           // record was not found, invalid login, return false
            return false;
        }
    }


    //=============================================================================

    function get_ticket_list($engineer_id)
    {
        $this->db->select('sm_service_request_dtl.*,divisions.DIVISION_NAME,kb_post.ticket_ref_id,
                          machine.*,install_base.insb_serial,install_base.insb_version,install_base.dep_ref_id');
        $this->db->join('knowledge_base_main kb_post', 'sm_service_request_dtl.srd_id = kb_post.ticket_ref_id', 'left');
        $this->db->join('customer', 'sm_service_request_dtl.send_from = customer.customer_id', 'left');
        $this->db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');
        $this->db->join('machine', 'sm_service_request_dtl.machine_ref_id=machine.mc_id', 'left');
        $this->db->join('install_base', 'sm_service_request_dtl.ref_insb_id=install_base.insb_id', 'left');

        $this->db->where("sm_service_request_dtl.send_to", $engineer_id);
        $this->db->where("sm_service_request_dtl.st_flag", 0);

        //$this->db->group_by('sm_service_request_dtl.srd_id');
        $this->db->order_by("sm_service_request_dtl.srd_id", 'DESC');

        $query = $this->db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    //======================= click action get details ========================

    function get_details($auto_id, $engineer_auto_id)
    {
        $read_db = $this->load->database('icel', TRUE);

        $read_db->select('sm_service_request_dtl.*,kb_post.ticket_ref_id');
        $read_db->join('knowledge_base_main kb_post', 'sm_service_request_dtl.srd_id = kb_post.ticket_ref_id', 'left');

        $read_db->where("sm_service_request_dtl.send_to", $engineer_auto_id);
        $read_db->where("sm_service_request_dtl.srd_id", $auto_id);
        $query = $read_db->get('sm_service_request_dtl');

        //return $read_db->last_query();

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }


    function get_ticket_comment_list($ticket_no)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";

        $read_db->where('ticket_no', $ticket_no);
        $read_db->order_by("src_id", 'DESC');
        $query = $read_db->get('sm_service_request_dtl_comments');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    function get_ticket_trans_flow_tab($ticket_no)
    {
        $result = "";
        $this->db->where('ticket_no', $ticket_no);
        $this->db->order_by("rsrd_id", 'ASC');
        $query = $this->db->get('sm_service_request_dtl_trans');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    public function get_spare_parts()
    {
        $result = '';
        $query  = $this->db->get('spare_parts');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

//==============================================
    function update_ticket_status()
    {

        $icel_db = $this->load->database('icel', TRUE);

        $customer_id = $this->security->xss_clean($this->input->post('customer_id'));
        $machine_id  = $this->security->xss_clean($this->input->post('machine_id'));
        $srd_id      = $this->security->xss_clean($this->input->post('srd_id'));
        $ticket_no   = $this->security->xss_clean($this->input->post('ticket_no'));


        $ticketcomment = $this->security->xss_clean($this->input->post('problem_details'));
        $acomment      = $this->security->xss_clean($this->input->post('action_details'));

        $customer_comment = $this->security->xss_clean($this->input->post('comment_on_customer'));
        $eng_rating       = $this->security->xss_clean($this->input->post('customer_rating'));


        //======== update status ================================
        $status = $this->security->xss_clean($this->input->post('status'));

        $datetime   = date('Y-m-d H:i:s');
        $created_by = 'engineer';

        $engineer_auto_id = $this->security->xss_clean($this->input->post('engineer_id'));

        $data_arry = array(
            'status'                => $status,
            'last_action_by'        => $engineer_auto_id,
            'customer_comment'      => $customer_comment,
            'eng_rating'            => $eng_rating,
            'last_action_date_time' => $datetime,
            'updated_by'            => $engineer_auto_id,
            'updated_date_time'     => $datetime,
        );


        $icel_db->where('srd_id', $srd_id);
        $res_flag = $icel_db->update('sm_service_request_dtl', $data_arry);


        //=============== user training ================
        //$spare_parts = $this->security->xss_clean($this->input->post('spare'));
        //$parts_qty = $this->security->xss_clean($this->input->post('sp_qty'));

        $spare = $this->security->xss_clean($this->input->post('spareArr'));

        $additional = $this->security->xss_clean($this->input->post('other_spare'));

//        $i = 0;

        if (!empty($spare)) {

            foreach ($spare as $key => $sp) {

                if (count($sp)) {

                    $data = array(
                        'sm_eng_ref_id'  => $engineer_auto_id,
                        'sr_ticket_id'   => $srd_id,
                        'spare_parts'    => $sp['spare'],
                        'cust_ref_id'    => $customer_id,
                        'machine_ref_id' => $machine_id,
                        'sp_quantity'    => $sp['sp_qty'],
                    );

                    $this->db->insert('spare_parts_request_trns', $data);
                }
//                $i++;
            }

        }


        //read and  insert into trans table

        if (!empty($status)) {
            $ticket_dtl_trans_arr = get_ticket_dtl_trans_arr($ticket_no);

            $ticket_request_dtl = array(
                'ref_srd_id'          => $ticket_dtl_trans_arr['ref_srd_id'],
                'ticket_no'           => $ticket_dtl_trans_arr['ticket_no'],
                'send_from'           => $ticket_dtl_trans_arr['send_from'],
                'send_to'             => $ticket_dtl_trans_arr['send_to'],
                'service_add_details' => $ticket_dtl_trans_arr['service_add_details'],
                'subject'             => $ticket_dtl_trans_arr['subject'],
                'request_details'     => $ticket_dtl_trans_arr['request_details'],
                'priority'            => $ticket_dtl_trans_arr['priority'],
                'support_type'        => $ticket_dtl_trans_arr['support_type'],
                'ref_task_id'         => $ticket_dtl_trans_arr['ref_task_id'],
                'month'               => $ticket_dtl_trans_arr['month'],
                'year'                => $ticket_dtl_trans_arr['year'],
                'request_date_time'   => $ticket_dtl_trans_arr['request_date_time'],
                'created_by'          => $engineer_auto_id,
                'created_by_type'     => $created_by,
                'created_date_time'   => date('Y-m-d H:i:s'),
                'status'              => $status
            );
            $icel_db->insert('sm_service_request_dtl_trans', $ticket_request_dtl);
        }

        //comment insert

        if (!empty($ticketcomment)) {
            $datetime          = date('Y-m-d H:i:s');
            $data_arry_comment = array(
                'ref_srd_id'         => $srd_id,
                'ticket_no'          => $ticket_no,
                'comments'           => $ticketcomment,
                'action_comment'     => $acomment,
                'other_spare'        => $additional,
                'comment_from'       => 'se',
                'comments_by'        => $engineer_auto_id,
                'comments_date_time' => $datetime,
            );
            $icel_db->insert('sm_service_request_dtl_comments', $data_arry_comment);
        }

        if (!empty($res_flag)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_ticket_info($srd_id, $engineer_id)
    {

        $this->db->select('ticket.status,ticket.ticket_no,ticket.contact_person_phn contact_person,eng.mobile engineer');
        $this->db->select('ticket.status,ticket.ticket_no,customer.mobile customer,ticket.contact_person_phn contact_person,eng.mobile engineer');
        $this->db->join('customer', 'customer.customer_id = ticket.send_from', 'left');
        $this->db->join('sm_service_engineer eng', 'eng.ser_eng_id = ticket.send_to', 'left');

        $this->db->where('srd_id', $srd_id);
        $this->db->where('send_to', $engineer_id);

        $query = $this->db->get('sm_service_request_dtl ticket');

        if ($query->num_rows() > 0) {
            $result = $query->row();

            $sm_managers = get_service_manager();

            foreach ($sm_managers as $i => $manager) {
                $manager_no          = "manager_" . (++$i);
                $result->$manager_no = $manager;
            }

            return $result;

        } else {
            return false;
        }


    }


    public function get_player_ids($srd_id, $engineer_id)
    {

        $this->db->select('customer.player_id customer,eng.player_id engineer');
        $this->db->join('customer', 'customer.customer_id = ticket.send_from', 'left');
        $this->db->join('sm_service_engineer eng', 'eng.ser_eng_id = ticket.send_to', 'left');

        $this->db->where('srd_id', $srd_id);
        $this->db->where('send_to', $engineer_id);

        $query = $this->db->get('sm_service_request_dtl ticket');

        if ($query->num_rows() > 0) {
            $result = $query->row();

            $sm_managers = get_service_manager_player_id();

            foreach ($sm_managers as $i => $manager) {
                $manager_no          = "manager_" . (++$i);
                $result->$manager_no = $manager;
            }

            return $result;

        } else {
            return false;
        }


    }

//================== knowledge base =======================================

    public function get_ticket_data($id)
    {

        $this->db->where('sm_service_request_dtl.srd_id', $id);
        $query = $this->db->get('sm_service_request_dtl');
        return $query->row();
    }


    public function save_kb_post()
    {

        $eng_id   = $this->input->post('engineer_id');
        $datetime = date('Y-m-d');

        $data = array(
            'ticket_ref_id'    => $this->input->post('ticket_id'),
            'ticket_ref_no'    => $this->input->post('ticket_no'),
            'problem_details'  => $this->input->post('comment'),
            'posted_by_eng_id' => $eng_id,
            'posted_date'      => $datetime
        );

        $this->db->insert('knowledge_base_main', $data);
        return $this->db->insert_id();

    }


    public function get_kb_post($id)
    {
        $this->db->where("ticket_ref_id", $id);
        $query = $this->db->get('knowledge_base_main');
        return $query->row();
    }


    //=================== after kb post ==============================
    public function get_kb_list()
    {

        $this->db->select('knowledge_base_main.*,sm_service_engineer.name');
        $this->db->join('sm_service_engineer', 'knowledge_base_main.posted_by_eng_id = sm_service_engineer.ser_eng_id', 'left');
        //$this->db->join('knowledge_base_comment comm', 'knowledge_base_main.id = comm.base_ref_id','left');
        $this->db->order_by("knowledge_base_main.id", "desc");
        $query = $this->db->get('knowledge_base_main');

        return $query->result();
    }


    //============ see details ============================
    public function get_kb_data_id($id)
    {
        $this->db->select('knowledge_base_main.*,se.name,se.ser_eng_id eng_id,se.picture');
        $this->db->join('sm_service_engineer se', 'knowledge_base_main.posted_by_eng_id = se.ser_eng_id', 'left');
        $this->db->where("knowledge_base_main.id", $id);
        $query = $this->db->get('knowledge_base_main');

        return $query->row();
    }

    public function get_comment_data($id)
    {
        $this->db->select('knowledge_base_comment.*,se.name,se.ser_eng_id eng_id,se.picture');
        $this->db->join('sm_service_engineer se', 'knowledge_base_comment.commented_by_eng_ref = se.ser_eng_id', 'left');
        $this->db->where("knowledge_base_comment.base_ref_id", $id);
        $query = $this->db->get('knowledge_base_comment');
        return $query->result();
    }


    public function get_kb_data($id)
    {

        $this->db->where("id", $id);
        $query = $this->db->get('knowledge_base_main');
        return $query->row();
    }


    public function save_kb_comment()
    {
        $eng_id   = $this->input->post('engineer_id');
        $data = array(
            'base_ref_id'          => $this->input->post('kb_id'),
            'comment'              => $this->input->post('kb_comment'),
            'commented_by_eng_ref' => $eng_id,
            'comment_date'         => date('Y-m-d')
        );
        $this->db->insert('knowledge_base_comment', $data);
        return $this->db->insert_id();
    }


    public function report_upload($ticket_id)
    {
        $response = array('status' => false, 'msg' => null);


        if (!empty($_POST['report'])) {


            $path = '/var/www/html/trvl/upload/job_report/' . $ticket_id;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $report_name = $_POST['report'];


            $upload = base64_image_upload($_POST['report'], $path, $report_name);


            if ($upload['status'] == true) {

                $upload_images['job_report'] = $upload['file_name'];

                $this->db->update('sm_service_request_dtl', $upload_images, array('srd_id' => $ticket_id));
            } else {
                $response['msg'] = $upload['msg'];
            }

        } else {
            $response['msg'] = 'Insertion error!';
        }


        return $response;

    }


    public function report_upload_pdf($ticket_id)
    {
        $response = array('status' => false, 'msg' => null);

        if (!empty($_FILES['report'])) {

            $path = '/var/www/html/trvl/upload/job_report/' . $ticket_id;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $config['upload_path']   = $path;
            $config['allowed_types'] = '*';
            $config['file_name']     = $_FILES['report']['name'];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('report')) {
                $res['msg'] = $this->upload->display_errors();
            } else {
                $imageDetailArray = $this->upload->data();
                $image            = $imageDetailArray['file_name'];

                if (!empty($image)) {

                    $upload_report['job_report'] = $image;

                    $this->db->update('sm_service_request_dtl', $upload_report, array('srd_id' => $ticket_id));

                    $response['status'] = true;
                    $response['msg']    = 'File Uploaded';

                } else {
                    $response['msg'] = 'Insertion error!';
                }
            }

        } else {
            $response['msg'] = 'File Not Set';
        }


        return $response;

    }

//================ mdf job report ===============================
//================= get data for job report =========

    public function get_comments($ticket_id)
    {

        $this->db->select('request.request_details,sm_service_request_dtl_comments.comments eng_comment,sm_service_request_dtl_comments.action_comment');
        $this->db->join('sm_service_request_dtl_comments', 'request.srd_id = sm_service_request_dtl_comments.ref_srd_id');
        $this->db->where('request.srd_id', $ticket_id);
        $this->db->where('sm_service_request_dtl_comments.comment_from', 'se');
        $query = $this->db->get('sm_service_request_dtl request');
        return $query->row();
    }

    public function get_equipment_data($ticket_id)
    {

        $this->db->select('machine.*,manufacture.mf_name');
        $this->db->join('machine', 'request.machine_ref_id = machine.mc_id', 'left');
        $this->db->join('manufacture', 'machine.mc_manufacture = manufacture.mf_id', 'left');
        $this->db->where('request.srd_id', $ticket_id);
        $query = $this->db->get('sm_service_request_dtl request');
        return $query->row();

    }


    public function get_job_report_data($id)
    {

        $this->db->select('customer.name,ticket.*,install_base.*,engineer.name eng');

        $this->db->join('customer', 'ticket.send_from = customer.customer_id', 'left');
        $this->db->join('install_base', 'ticket.machine_ref_id = install_base.insb_machine', 'left');
        $this->db->join('sm_service_engineer engineer', 'ticket.send_to = engineer.ser_eng_id', 'left');

        $this->db->where('ticket.srd_id', $id);
        $this->db->where('ticket.send_from = install_base.insb_customer');
        $query = $this->db->get('sm_service_request_dtl ticket');

        //print_r($this->db->last_query()); exit;

        return $query->row();
    }


    public function get_spare_parts_data($id)
    {

        $this->db->select('spare.sp_name,trans.sp_quantity');
        $this->db->from('spare_parts_request_trns trans');
        $this->db->join('spare_parts spare', 'trans.spare_parts = spare.sp_id');
        $this->db->where('trans.sr_ticket_id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    //================================== Supervisor ==================================

    function validate_login_supervisor()
    {

        $db_pass = '';

        $mobile   = $this->security->xss_clean($this->input->post('mobile'));
        $password = $this->security->xss_clean($this->input->post('password'));

        $this->db->select('id,superadmin_name,mobile,password,status,picture');
        $this->db->where(['status' => 'A', 'user_type' => 'sm']);
        $this->db->where('mobile', $mobile);
        $query = $this->db->get('sm_admin');

        if ($query->num_rows() > 0) {

            $row = $query->row();

            $db_pass   = $row->password;
            $id        = $row->id;
            $name      = $row->superadmin_name;
            $mobile_db = $row->mobile;

            if ($db_pass == $password) {  // pass match, login valid
                if ($row->picture) {
                    $arr['engineer_photo'] = ROOT_IMG_URL . 'upload/service_engineer/' . $id . '/' . $row->picture;
                }
                $arr['engineer_valid_login'] = true;
                $arr['engineer_id']          = $id;
                $arr['engineer_name']        = $name;
                $arr['engineer_mobile']      = $mobile_db;
                $arr['valid_login_engineer'] = true;

                // if successfully update return updated token
                $token_id['login_token_id'] = $this->generate_random_token(10);
                $this->db->where('ser_eng_id', $id);
                $this->db->update('sm_service_engineer', $token_id);
                $arr['login_token_id'] = $token_id['login_token_id'];

                return $arr;
            } else {        // pass did not match, invalid login
                return false;
            }
        } else {           // record was not found, invalid login, return false
            return false;
        }
    }

    // get row data
    public function get_by_id($arr, $table)
    {

        $this->db->from($table);
        $this->db->where($arr);
        $query = $this->db->get();
        return $query->row();
    }

    public function update($table, $where, $data)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($table, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

    //======================== Notification =========================
    public function customer_wise_notification($customer_id = null, $sub_customer_id = null)
    {
        $this->db->select('notifications.*');
        $this->db->join('notifications', 'notifications.id = ntc.ntf_ref_id', 'left');
        $this->db->join('install_base', 'install_base.insb_machine = ntc.machine_id', 'left');
        if($customer_id) $this->db->where('ntc.customer_id', $customer_id);
        if($$sub_customer_id) $this->db->where('install_base.customer_id_sub', $sub_customer_id);

        $query = $this->db->get('notification_to_customer ntc');

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

    //================================

    public function customer_wise_machine($customer_id = null)
    {
        $result = "";
        $this->db->select('machine.*,ins.insb_id,ins.insb_serial,ins.insb_version');
        $this->db->join('install_base ins', 'ins.insb_machine=machine.mc_id', 'left');
        if ($customer_id) $this->db->where('ins.insb_customer', $customer_id);

        $this->db->where('ins.support_type !=', 5);
        $this->db->where('ins.support_type !=', 6);
        $query = $this->db->get('machine');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }


    //===================================== Supervisor =============================

    public function validate_login_eng_spv()
    {
        $db_pass = '';

        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));


        if ($username) {

            $this->db->select('ser_eng_id,name,mobile,password,status,picture');
            $this->db->where('status', 'A');
            $this->db->where('mobile', $username);
            $query = $this->db->get('sm_service_engineer');

            if ($query->num_rows() > 0) {

                $row = $query->row();

                $db_pass   = $row->password;
                $id        = $row->ser_eng_id;
                $name      = $row->name;
                $mobile_db = $row->mobile;

                if ($db_pass == $password) {  // pass match, login valid
                    $arr['engineer_photo']       = ROOT_IMG_URL . 'upload/service_engineer/' . $id . '/' . $row->picture;
                    $arr['engineer_valid_login'] = true;
                    $arr['engineer_id']          = $id;
                    $arr['engineer_name']        = $name;
                    $arr['engineer_mobile']      = $mobile_db;
                    $arr['valid_login_engineer'] = true;
                    $arr['user_type']            = 'eng';

                    // if successfully update return updated token
                    $token_id['login_token_id'] = $this->generate_random_token(10);
                    $this->db->where('ser_eng_id', $id);
                    $this->db->update('sm_service_engineer', $token_id);
                    $arr['login_token_id'] = $token_id['login_token_id'];

                    return $arr;

                } else {           // record was not found, invalid login, return false
                    return false;
                }

            } elseif ($query->num_rows() == 0) {

                $this->db->select('id,superadmin_name name,username,mobile,password,status,picture');
                $this->db->where('status', 'A');
                $this->db->where('username', $username);
                $this->db->where('password', $password);
                $query = $this->db->get('sm_admin');

                if ($query->num_rows() > 0) {

                    $row = $query->row();

                    $id        = $row->id;
                    $db_pass   = $row->password;
                    $name      = $row->name;
                    $username  = $row->username;
                    $mobile_db = $row->mobile;

                    if ($db_pass == $password) {  // pass match, login valid

                        //$arr['engineer_photo']       = ROOT_IMG_URL . 'upload/service_engineer/' . $id . '/' . $row->picture;
                        $arr['engineer_valid_login'] = true;
                        $arr['user_id']              = $id;
                        $arr['name']                 = $name;
                        $arr['mobile']               = $mobile_db;
                        $arr['valid_login_engineer'] = true;
                        $arr['user_type']            = 'sm';
                        // if successfully update return updated token
                        $token_id['login_token_id'] = $this->generate_random_token(10);
                        $this->db->where('id', $id);
                        $this->db->update('sm_admin', $token_id);
                        $arr['login_token_id'] = $token_id['login_token_id'];

                        return $arr;
                    } else {        // pass did not match, invalid login
                        return false;
                    }
                }
            } else {           // record was not found, invalid login, return false
                return false;
            }
        }
    }


    public function list_ticket()
    {

        $this->db->select('sm_service_request_dtl.*,divisions.DIVISION_NAME,machine.*,install_base.insb_serial,
                          install_base.insb_version,install_base.dep_ref_id');
        $this->db->join('customer', 'customer.customer_id = sm_service_request_dtl.send_from', 'left');
        $this->db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');
        $this->db->join('machine', 'sm_service_request_dtl.machine_ref_id=machine.mc_id', 'left');
        $this->db->join('install_base', 'sm_service_request_dtl.ref_insb_id=install_base.insb_id', 'left');
        $this->db->where("sm_service_request_dtl.st_flag", 0);
        $this->db->where("sm_service_request_dtl.status", 'P');
        $this->db->group_by('sm_service_request_dtl.srd_id');
        $this->db->order_by("sm_service_request_dtl.srd_id", 'DESC');
        $query = $this->db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result;
        }

        return false;
    }


    public function search_list_ticket()
    {

        $result       = "";
        $customer     = $this->security->xss_clean($this->input->post('customer_id'));
        $engineer     = $this->security->xss_clean($this->input->post('engineer_id'));
        $support_type = $this->security->xss_clean($this->input->post('support_type'));
        $status       = $this->security->xss_clean($this->input->post('status'));
        $ticket_no    = $this->security->xss_clean($this->input->post('ticket_no'));
        $dateFrom     = trim($this->security->xss_clean($this->input->post('dateFrom')));
        $dateTo       = trim($this->security->xss_clean($this->input->post('dateTo')));


        if (!empty($customer)) {

            $this->db->where("service.send_from", $customer);
        }
        if (!empty($engineer)) {

            $this->db->where("service.send_to", $engineer);
        }


        if (!empty($support_type)) {

            $this->db->where("service.support_type", $support_type);
        }

        if (!empty($status)) {

            $this->db->where("service.status", $status);
        }

        if (!empty($ticket_no)) {

            $this->db->where("service.ticket_no", $ticket_no);
        }

        if (!empty($dateFrom)) {
            $date_from = date('Y-m-d 00:00:00', strtotime($dateFrom));
            $this->db->where('service.created_date_time >=', $date_from);
        }

        if (!empty($dateTo)) {
            $date_to = date('Y-m-d 23:59:59', strtotime($dateTo));
            $this->db->where('service.created_date_time <=', $date_to);
        }

        $this->db->select('service.*,divisions.DIVISION_NAME,machine.*,install_base.insb_serial,
                          install_base.insb_version,install_base.dep_ref_id');
        $this->db->join('customer', 'customer.customer_id = service.send_from', 'left');
        $this->db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');
        $this->db->join('machine', 'service.machine_ref_id=machine.mc_id', 'left');
        $this->db->join('install_base', 'service.ref_insb_id=install_base.insb_id', 'left');
        $this->db->where("service.st_flag", 0);
        $this->db->group_by('service.srd_id');
        $this->db->order_by("service.srd_id", 'DESC');
        $query = $this->db->get('sm_service_request_dtl service');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result;
        }

        return false;
    }

    function get_serivce_type()
    {

        $this->db->select('service.service_type_id,service.service_type_title');
        $this->db->where('service.status', 'A');
        $this->db->order_by('service.service_type_id', 'asc');
        $query = $this->db->get('sm_service_type service');
        return $query->result();
    }

    function get_all_customer()
    {

        $this->db->select('customer_id,name');
        $this->db->where('status', 'A');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('customer');
        return $query->result();
    }


    function get_ticket_dtl_trans_arr($ticket_no)
    {

        $icel_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";
        $query   = $icel_db->where("ticket_no", $ticket_no);
        $query   = $icel_db->get('sm_service_request_dtl_trans');

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
        }

        return $result;

    }


    public function spv_update_ticket_status()
    {

        $admin     = $this->security->xss_clean($this->input->post('user_id'));
        $ticket_id = $this->security->xss_clean($this->input->post('srd_id'));
        $ticket_no = $this->security->xss_clean($this->input->post('ticket_no'));
        $status    = $this->security->xss_clean($this->input->post('status'));
        $engineer  = $this->security->xss_clean($this->input->post('engineer'));
        $priority  = $this->security->xss_clean($this->input->post('priority'));
        $comment   = $this->security->xss_clean($this->input->post('comment'));
        $datetime  = date('Y-m-d H:i:s');

        $ticket_arr = $this->get_ticket_dtl_trans_arr($ticket_no);

        $ticket_request_trans = [
            'ref_srd_id'           => $ticket_arr['ref_srd_id'],
            'ticket_no'            => $ticket_arr['ticket_no'],
            'send_from'            => $ticket_arr['send_from'],
            'send_to'              => $ticket_arr['send_to'],
            'service_add_division' => $ticket_arr['service_add_division'],
            'service_add_district' => $ticket_arr['service_add_district'],
            'service_add_upazila'  => $ticket_arr['service_add_upazila'],
            'service_add_details'  => $ticket_arr['service_add_details'],
            'subject'              => $ticket_arr['subject'],
            'request_details'      => $ticket_arr['request_details'],
            'priority'             => $ticket_arr['priority'],
            'support_type'         => $ticket_arr['support_type'],
            'ref_task_id'          => $ticket_arr['ref_task_id'],
            'month'                => $ticket_arr['month'],
            'year'                 => $ticket_arr['year'],
            'request_date_time'    => $ticket_arr['request_date_time'],
            'created_by'           => $admin,
            'created_by_type'      => 'admin',
            'created_date_time'    => $datetime,
            'status'               => $ticket_arr['status'],
        ];


        // ============ update request data table sm_service_request_dtl
        $service_request = [
            'send_to'               => $engineer ? $engineer : null,
            'priority'              => $priority,
            'status'                => $status ? $status : null,
            'lead_date_time'        => $datetime,
            'last_action_by'        => $admin,
            'last_action_date_time' => $datetime,
            //'updated_by'            => 'admin',
            'updated_date_time'     => $datetime,
        ];

        $where  = ['srd_id' => $ticket_id, 'ticket_no' => $ticket_no];
        $update = $this->db->update('sm_service_request_dtl', $service_request, $where);

        //============= insert transaction data table sm_service_request_dtl_trans
        $ticket_request_trans ['send_to'] = $engineer ? $engineer : null;
        $ticket_request_trans ['status']  = $status ? $status : null;
        $data_insert                      = $this->db->insert('sm_service_request_dtl_trans', $ticket_request_trans);

        if (!empty($comment)) {

            $data = [
                'ref_srd_id'         => $ticket_id,
                'ticket_no'          => $ticket_no,
                'comments'           => $comment,
                'comment_from'       => 'admin',
                'comments_by'        => $admin,
                'comments_date_time' => $datetime,
            ];

            $insert = $this->db->insert('sm_service_request_dtl_comments', $data);
        }


        if (!empty($engineer)) {

            $this->db->select('mobile,player_id');
            $this->db->where('ser_eng_id', $engineer);
            $query  = $this->db->get('sm_service_engineer');
            $result = $query->row();

            $mobile = $result->mobile;
            $msg    = trim("Dear Engineer, Greetings from Tradevision Ltd. You are assigned  to ticket number  {$ticket_no} For details, check your Engineer TVL apps.");
            send_sms($mobile, $msg);

            $title   = 'New Ticket Assign';
            $app = ['type' => 'engineer'];
            send_push_notification($result->player_id, $msg, $title, $app);
        }


        if ($update) {

            return true;

        } else {

            return false;
        }
    }


    public function get_install_base_list()
    {

        $customer = trim($this->input->post('customer_name'));
        $machine  = trim($this->input->post('machine_name'));
        $model    = trim($this->input->post('model_name'));
        $serial   = trim($this->input->post('serial_id'));
        $support  = trim($this->input->post('support_type'));


        if (!empty($customer)) {
            $this->db->where('install_base.insb_customer', $customer);
        }

        if (!empty($machine)) {
            $this->db->where('machine.mc_name', $machine);
        }

        if (!empty($model)) {
            $this->db->where('machine.mc_model', $model);
        }

        if (!empty($serial)) {
            $this->db->where('install_base.insb_serial', $serial);
        }

        if (!empty($support)) {
            $this->db->where('support.service_type_id', $support);
        }


        $this->db->select('install_base.*,customer.name customer,machine.mc_name,machine.mc_model,support.service_type_title,
                           su_type.su_start_date,su_type.su_end_date');
        $this->db->join('customer', 'install_base.insb_customer = customer.customer_id', 'left');
        $this->db->join('machine', 'install_base.insb_machine = machine.mc_id', 'left');
        $this->db->join('cust_support_type su_type', 'install_base.insb_id = su_type.install_base_ref_id', 'left');
        $this->db->join('sm_service_type support', 'support.service_type_id=su_type.su_type_id', 'left');

        $this->db->order_by('customer.name', 'asc');

        $this->db->group_by('machine.mc_id,install_base.insb_serial');
        $query = $this->db->get('install_base');

        if ($query->num_rows() > 0) {

            return $query->result();
        }
        return false;
    }

    //============ Details of install base ==============

    public function get_install_base($id)
    {


        $this->db->select('install_base.*,business_area.bu_name');
        $this->db->join('business_area', 'install_base.insb_business_area = business_area.bu_id', 'left');
        $this->db->where('install_base.insb_id', $id);
        //$this->db->where('install_base.ser_eng_ref_id',$engneer_id);
        $query = $this->db->get('install_base');

        return $query->row();
    }

    public function get_user_training($id)
    {

        $this->db->where('install_base_ref_id', $id);
        $query = $this->db->get('user_traning_info');
        return $query->result();
    }

    public function get_customer_data($id)
    {

        $this->db->select('customer.*,ctd.*,districts.DISTRICT_NAME');
        $this->db->join('customer', 'install_base.insb_customer = customer.customer_id', 'left');
        $this->db->join('customer_contact_person_dtl ctd', 'customer.customer_id = ctd.ref_customer_id', 'left');
        $this->db->join('districts', 'customer.contact_add_district = districts.DISTRICT_ID', 'left');
        $this->db->where('install_base.insb_id', $id);
        //$this->db->where('install_base.ser_eng_ref_id',$engneer_id);
        $query = $this->db->get('install_base');

        return $query->row();
    }


    public function get_equipment($id)
    {

        $this->db->select('machine.*,manufacture.mf_name,install_base.insb_serial,install_base.insb_version');
        $this->db->join('machine', 'install_base.insb_machine = machine.mc_id', 'left');
        $this->db->join('manufacture', 'machine.mc_manufacture = manufacture.mf_id', 'left');
        $this->db->where('install_base.insb_id', $id);
        //$this->db->where('install_base.ser_eng_ref_id',$engneer_id);
        $query = $this->db->get('install_base');

        return $query->row();
    }

    public function get_support_type_data($id)
    {

        $this->db->select('cust_support_type.*,sm_service_type.service_type_title');
        $this->db->join('cust_support_type', 'install_base.insb_id =  cust_support_type.install_base_ref_id	', 'left');
        $this->db->join('sm_service_type', 'cust_support_type.su_type_id = sm_service_type.service_type_id', 'left');
        $this->db->where('install_base.insb_id', $id);
        //$this->db->where('install_base.ser_eng_ref_id',$engneer_id);
        $query = $this->db->get('install_base');

        return $query->row();
    }

    //=============== install base renew ====================
    public function renew_support_type()
    {
        $this->db->where_not_in('service_type_id', 3);

        $query = $this->db->get('sm_service_type');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }

    public function get_customer_feed_back()
    {

        $this->db->select('c.customer_id,c.name,c.email,c.mobile,customer_feed_back.*');
        $this->db->join('customer c', 'customer_feed_back.cust_ref_id = c.customer_id', 'left');
        $result = $this->db->get('customer_feed_back');

        if ($result->num_rows() > 0) {
            return $result->result();
        }
        return false;
    }


    public function get_pmi_list()
    {
        $this->db->select('install_base.*,customer.name customer,machine.mc_name,machine.mc_model,
                           pmi_report.id pmi_id,pmi_report.pmi_report,pmi_report.created,
                           sm_service_engineer.name engineer,pmi_report.dep_ref_id');

        $this->db->join('customer', 'pmi_report.cust_ref_id = customer.customer_id', 'left');
        $this->db->join('machine', 'pmi_report.mc_ref_id = machine.mc_id', 'left');
        $this->db->join('sm_service_engineer', 'pmi_report.eng_ref_id = sm_service_engineer.ser_eng_id', 'left');
        $this->db->join('install_base', 'pmi_report.insb_ref_id = install_base.insb_id', 'left');


        $this->db->order_by('customer.name', 'asc');
        $query = $this->db->get('pmi_report');

        if ($query->num_rows() > 0) {

            return $query->result();
        }
        return false;
    }

    function get_all_engineer()
    {

        $this->db->select('ser_eng_id,name,status');
        $this->db->where('status', 'A');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

    function get_all_priority()
    {
        $this->db->where('status', 'A');
        $this->db->order_by('priority_title', 'ASC');
        $query = $this->db->get('sm_service_priority');

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //==================================================================
    public function get_machine()
    {

        $this->db->order_by('mc_name', 'asc');
        $this->db->group_by('mc_name');
        $query = $this->db->get('machine');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }


    public function get_machine_model($machine)
    {


        $this->db->select('mc_model');
        $this->db->where('mc_name', $machine);
        $this->db->group_by('mc_name,mc_model');
        $query = $this->db->get('machine');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }
    }


    public function get_serial()
    {
        $this->db->select('insb_serial');
        $this->db->where('insb_serial is NOT NULL', NULL, FALSE);
        $query = $this->db->get('install_base');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }

    //=================== Department =======================
    public function get_department()
    {
        $this->db->where('status', 1);
        $query = $this->db->get('medical_department');

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }


    public function get_department_by_machine()
    {
        $this->db->where('status', 1);
        $query = $this->db->get('medical_department');

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

    public function get_supervisor(){
        $this->db->where([
            'user_type' => 'sm',
            'status' => 'A'
        ]);
        $query = $this->db->get('sm_admin');

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

    /**
     * @param $customer_type example 'customer' | 'sub_customer'
     * @param $customer_id
     * @param $sub_customer_id
     * @return array
     */
    public function get_customer_list($customer_type, $customer_id, $sub_customer_id) {
        $res = null;
        if ($customer_type == 'sub_customer') {
            if ($sub_customer_id) $this->db->where('id', $sub_customer_id);
            $res = $this->db
                ->select('*')
                ->order_by('customer_id, username', 'asc')
                ->get('customer_sub_login')->result();
        } else {
            if ($customer_id) $this->db->where('id', $customer_id);
            $res = $this->db
                ->select('*')
                ->order_by('name', 'asc')
                ->get('customer')->result();
        }
        return $res;
    }

    public function get_machine_list() {
        return $this->db->select('*')
            ->where('mc_status', 1)
            ->order_by('mc_name', 'asc')
            ->get('machine')
            ->result();
    }

    public function get_business_area_list() {
        return $this->db->select('*')
            ->order_by('bu_name', 'asc')
            ->get('business_area')
            ->result();
    }

    public function get_sub_customer_details($phone) {
        $query = $this->db->select('phone, otp_pass')
            ->where(['phone' => $phone, 'otp_pass !=' => 'verified'])
            ->get('customer_sub_login');
        if ($query->num_rows()){
            return $query->row();
        } else {
            $query = $this->db->select('mobile as phone, otp_pass')
                ->where('mobile', $phone)
                ->get('customer');
            if ($query->num_rows()) return $query->row();
            return false;
        }
    }

}