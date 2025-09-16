<?php

/**
 * Description of Mod_dc
 *
 * @author iPLUS DATA
 */
class Mod_customer extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function generate_customer_code($length = 6)
    {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }


    function generate_random_password($length = 6)
    {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }


    public function check_mobile($cMobile)
    {


        $this->db->where('mobile', $cMobile);
        $query = $this->db->get('customer');

        if ($query->num_rows() > 0) {

            return true;
        } else {
            return false;
        }
    }


    function save_data($data)
    {

        $this->db->insert('customer', $data);
        return $this->db->insert_id();
    }

    public function save_contact_person($data)
    {
        $this->db->insert('customer_contact_person_dtl', $data);
        return $this->db->insert_id();
    }

    function send_mail($data_arr)
    {
        $sender_email = get_mail_sender_email();
        $this->load->library('email');
        $this->email->from($sender_email, 'Customer Signup');
        $this->email->to($data_arr['email']);
        $this->email->subject('Customer Signup');

        $email_body = 'Dear ' . strtoupper($data_arr['name']) . ', <br/><br/>';
        $email_body .= 'Your password is ' . $data_arr['password'] . ' corresponding mobile number ' . $data_arr['mobile'] . ' .<br>Thank you. ';
        $email_body .= "<br>";
        $email_body .= "<br>";
        $email_body .= "Thank You";

        $this->email->message($email_body);
        $this->email->send();
    }

    function get_customer_list($limit, $row)
    {
        $sm_db  = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result = "";
        $sm_db->select('customer.*,customer_contact_person_dtl.contact_person_name,
            customer_contact_person_dtl.contact_person_desig,customer_contact_person_dtl.contact_person_phone,
            customer_contact_person_dtl.contact_person_email,thanas.THANA_NAME');
        $sm_db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
        $sm_db->join('thanas', 'customer.contact_add_upazila = thanas.THANA_ID', 'left');
        $query = $sm_db->order_by("customer_id", 'DESC');
        $query = $sm_db->get('customer', $limit, $row);

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }
    // function get_sub_customer_list_backup($limit, $row, $count = false)
    // {
    //     $result = [];
    //     $sm_db  = $this->load->database('icel', TRUE);
    //     $sm_db->select('customer.*, customer_sub_login.id as sub_user_id, customer_sub_login.username, customer_sub_login.password, customer_sub_login.email sub_user_email, customer_sub_login.phone, customer_sub_login.status sub_user_status, customer_sub_login.created_at as sub_user_created, customer_contact_person_dtl.contact_person_name,
    //         customer_contact_person_dtl.contact_person_desig, customer_contact_person_dtl.contact_person_phone,
    //         customer_contact_person_dtl.contact_person_email, thanas.THANA_NAME');
    //     $sm_db->join('customer', 'customer.customer_id=customer_sub_login.customer_id');
    //     $sm_db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
    //     $sm_db->join('thanas', 'customer.contact_add_upazila = thanas.THANA_ID', 'left');
    //     $sm_db->where('customer_sub_login.status is null');

    //     $name   = $this->input->post('name');
    //     $email  = $this->input->post('email');
    //     $mobile = $this->input->post('mobile');
    //     $status = $this->input->post('status');

    //     if (!empty($name)) $sm_db->like('customer_sub_login.username', $name);
    //     if (!empty($email)) $sm_db->like('customer_sub_login.email', $email);
    //     if (!empty($mobile)) $sm_db->like('customer_sub_login.phone', $mobile);
    //     if (!empty($status)) $sm_db->where('customer_sub_login.status', $status);

    //     if ($limit && $row) {
    //         $sm_db->order_by("customer_sub_login.customer_id", 'DESC');
    //     }
    //     $query = $sm_db->get('customer_sub_login', $limit, $row);
    //     if ($count) {
    //         return $query->num_rows();
    //     }
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result();
    //     }
    //     return $result;
    // }

    function get_sub_customer_list($limit, $row, $count = false)
    {

  $result = [];
        $sm_db  = $this->load->database('icel', TRUE);
        $sm_db->select('customer.*, customer_sub_login.id as sub_user_id, customer_sub_login.username, customer_sub_login.password, customer_sub_login.email sub_user_email, customer_sub_login.phone, customer_sub_login.status sub_user_status, customer_sub_login.created_at as sub_user_created, customer_contact_person_dtl.contact_person_name,
        customer_contact_person_dtl.contact_person_desig, customer_contact_person_dtl.contact_person_phone,
        customer_contact_person_dtl.contact_person_email, thanas.THANA_NAME');
        $sm_db->join('customer', 'customer.customer_id=customer_sub_login.customer_id');
        $sm_db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
        $sm_db->join('thanas', 'customer.contact_add_upazila = thanas.THANA_ID', 'left');
        $sm_db->where('customer_sub_login.status is null');

        $name   = $this->input->post('name');
        $email  = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $status = $this->input->post('status');

        if (!empty($name)) $sm_db->like('customer_sub_login.username', $name);
        if (!empty($email)) $sm_db->like('customer_sub_login.email', $email);
        if (!empty($mobile)) $sm_db->like('customer_sub_login.phone', $mobile);
        if (!empty($status)) $sm_db->where('customer_sub_login.status', $status);

        if ($limit && $row) {
            $sm_db->order_by("customer_sub_login.customer_id", 'DESC');
        }
        $query = $sm_db->get('customer_sub_login', $limit, $row);
        if ($count) {
            return $query->num_rows();
        }
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }
        return $result;

        $result = [];
        $sm_db  = $this->load->database('icel', TRUE);
        $sm_db->select('customer.*, customer_sub_login.id as sub_user_id, 
        customer_sub_login.username, customer_sub_login.password,
         customer_sub_login.email sub_user_email, customer_sub_login.phone,
          customer_sub_login.status sub_user_status,
         customer_sub_login.created_at as sub_user_created
         ');

        $sm_db->join('customer', 'customer.customer_id=customer_sub_login.customer_id');
     //   $sm_db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
      //  $sm_db->join('thanas', 'customer.contact_add_upazila = thanas.THANA_ID', 'left');
        //   $sm_db->where('customer_sub_login.status is null');

        // $name   = $this->input->post('name');
        // $email  = $this->input->post('email');
        // $mobile = $this->input->post('mobile');
        // $status = $this->input->post('status');

        // if (!empty($name)) $sm_db->like('customer_sub_login.username', $name);
        // if (!empty($email)) $sm_db->like('customer_sub_login.email', $email);
        // if (!empty($mobile)) $sm_db->like('customer_sub_login.phone', $mobile);
        // if (!empty($status)) $sm_db->where('customer_sub_login.status', $status);

        // if ($limit && $row) {
        //     $sm_db->order_by("customer_sub_login.customer_id", 'DESC');
        // }
        $sm_db->where('customer_sub_login.customer_id',$limit);
        $query = $sm_db->get('customer_sub_login');
     //  $query = $sm_db->get('customer_sub_login');
        if ($count) {
            return $query->num_rows();
        }
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    public function pending_sub_customer_list() {}

    function customer_total_rows()
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $query = $sm_db->get('customer');
        return $query->num_rows();
    }


    function search_all_list($limit = '', $row = '')
    {
        $dt_array = '';
        $sm_db    = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name   = $this->session->userdata('name');
        $email  = $this->session->userdata('email');
        $mobile = $this->session->userdata('mobile');
        $status = $this->session->userdata('status');


        if (!empty($name)) {
            $sm_db->like('name', $name);
        }
        if (!empty($email)) {
            $sm_db->where('email', $email);
        }
        if (!empty($mobile)) {
            $sm_db->where('mobile', $mobile);
        }

        if (!empty($status)) {
            $sm_db->where('status', $status);
        }

        $query = $sm_db->get('customer');
        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';
        }

        return $dt_array;
    }

 function get_sub_customer_list_2($limit, $row, $count = false)
    {
            $result = [];
            $sm_db  = $this->load->database('icel', TRUE);
            $sm_db->select('customer.*, customer_sub_login.id as sub_user_id, 
            customer_sub_login.username, customer_sub_login.password,
             customer_sub_login.email sub_user_email, customer_sub_login.phone,
              customer_sub_login.status sub_user_status,
             customer_sub_login.created_at as sub_user_created
             ');

            $sm_db->join('customer', 'customer.customer_id=customer_sub_login.customer_id');
         //   $sm_db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
          //  $sm_db->join('thanas', 'customer.contact_add_upazila = thanas.THANA_ID', 'left');
            //   $sm_db->where('customer_sub_login.status is null');

            $name   = $this->input->post('name');
            $email  = $this->input->post('email');
            $mobile = $this->input->post('mobile');
            $status = $this->input->post('status');

            if (!empty($name)) $sm_db->like('customer_sub_login.username', $name);
            if (!empty($email)) $sm_db->like('customer_sub_login.email', $email);
            if (!empty($mobile)) $sm_db->like('customer_sub_login.phone', $mobile);
            if (!empty($status)) $sm_db->where('customer_sub_login.status', $status);

            // if ($limit && $row) {
            //     $sm_db->order_by("customer_sub_login.customer_id", 'DESC');
            // }
            $sm_db->where('customer_sub_login.customer_id',$limit);
            $query = $sm_db->get('customer_sub_login');
         //  $query = $sm_db->get('customer_sub_login');
            if ($count) {
                return $query->num_rows();
            }
            if ($query->num_rows() > 0) {
                $result = $query->result();
            }

            return $result;
     
    }

    function all_sub_user_list($limit, $row, $count = false)
    {
            $result = [];
            $sm_db  = $this->load->database('icel', TRUE);
            $sm_db->select('customer.*, customer_sub_login.id as sub_user_id, 
            customer_sub_login.username, customer_sub_login.password,
            customer_sub_login.email sub_user_email, customer_sub_login.phone,
                customer_sub_login.status sub_user_status,
            customer_sub_login.created_at as sub_user_created
            ');

            $sm_db->join('customer', 'customer.customer_id=customer_sub_login.customer_id');
            
            $name   = $this->input->get('name');
            $email  = $this->input->get('email');
            $mobile = $this->input->get('mobile');
            $status = $this->input->get('status');

            if (!empty($name)) $sm_db->like('customer_sub_login.username', $name);
            if (!empty($email)) $sm_db->like('customer_sub_login.email', $email);
            if (!empty($mobile)) $sm_db->like('customer_sub_login.phone', $mobile);
            if (!empty($status)) $sm_db->where('customer_sub_login.status', $status);

        //    $sm_db->where('customer_sub_login.customer_id',$limit);
            $query = $sm_db->get('customer_sub_login');
            if ($count) {
                return $query->num_rows();
            }
            if ($query->num_rows() > 0) {
                $result = $query->result();
            }

            return $result;
    
    }


    function count_search_record()
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name   = $this->session->userdata('name');
        $email  = $this->session->userdata('email');
        $mobile = $this->session->userdata('mobile');
        $status = $this->session->userdata('status');


        if (!empty($name)) {
            $sm_db->like('name', $name);
        }
        if (!empty($email)) {
            $sm_db->where('email', $email);
        }
        if (!empty($mobile)) {
            $sm_db->where('mobile', $mobile);
        }

        if (!empty($status)) {
            $sm_db->where('status', $status);
        }

        $query = $sm_db->get('customer');
        return $query->num_rows();                        /* return table number of rows */
    }


    function get_details($id)
    {

        $this->db->select('customer.*,cust.contact_person_name,cust.contact_person_email,cust.contact_person_desig,cust.contact_person_phone');
        $this->db->from('customer');
        $this->db->join('customer_contact_person_dtl cust', 'cust.ref_customer_id=customer.customer_id', 'left');
        $this->db->where('customer_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_view($login_id)
    {

        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $sm_db->select('customer.*,customer_contact_person_dtl.*,thanas.THANA_NAME');
        $sm_db->join('customer_contact_person_dtl', 'customer.customer_id = customer_contact_person_dtl.ref_customer_id', 'left');
        $sm_db->join('thanas', 'customer.contact_add_upazila = thanas.THANA_ID', 'left');
        $sm_db->where("customer.mobile", $login_id);

        $query = $sm_db->get('customer');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }

    function get_view_sub_customer($sub_customer_id)
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $sm_db->select("customer_id,username,email,phone,created_at");
        $sm_db->where("id", $sub_customer_id);
        $sm_db->where("status", "1");
        $query = $sm_db->get("customer_sub_login");
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

    function update_data()
    {

        $sm_db              = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $hidden_customer_id = $this->security->xss_clean($this->input->post('hidden_customer_id'));
        $datetime           = date('Y-m-d H:i:s');

        $login_admin_name = $this->session->userdata('login_admin_name');

        //=========== client address ============
        $cFlat  = $this->security->xss_clean($this->input->post('cFlat'));
        $cRoad  = $this->security->xss_clean($this->input->post('cRoad'));
        $cPost  = $this->security->xss_clean($this->input->post('cPost'));
        $cPCode = $this->security->xss_clean($this->input->post('cPCode'));
        $cDiv   = $this->security->xss_clean($this->input->post('contact_add_division'));
        $cDist  = $this->security->xss_clean($this->input->post('contact_add_district'));
        $cThana = $this->security->xss_clean($this->input->post('contact_add_upazila'));


        $data_arry = array(
            'name'                 => $this->security->xss_clean($this->input->post('name')),
            'email'                => $this->security->xss_clean($this->input->post('email')),
            'mobile'               => $this->security->xss_clean($this->input->post('mobile')),
            'telephone_no'         => $this->security->xss_clean($this->input->post('cTel')),
            'password'             => $this->security->xss_clean($this->input->post('password')),
            'contact_add_division' => $this->security->xss_clean($cDiv),
            'contact_add_district' => $this->security->xss_clean($cDist),
            'contact_add_upazila'  => $this->security->xss_clean($cThana),
            'cust_flat'            => $cFlat,
            'cust_road'            => $cRoad,
            'cust_post'            => $cPost,
            'cust_post_code'       => $cPCode,
            'status'               => 'A',
            'updated_date_time'    => $datetime,
            'created_by'           => $login_admin_name,

        );


        $sm_db->where('customer_id', $hidden_customer_id);
        $res_flag = $sm_db->update('customer', $data_arry); /* call active record function to save information  */


        //======== contact person info ========
        $pName   = $this->security->xss_clean($this->input->post('pName'));
        $pDes    = $this->security->xss_clean($this->input->post('pDes'));
        $pEmail  = $this->security->xss_clean($this->input->post('pEmail'));
        $pMobile = $this->security->xss_clean($this->input->post('pMobile'));

        $contact_person = array(
            'contact_person_name'  => $pName,
            'contact_person_desig' => $pDes,
            'contact_person_email' => $pEmail,
            'contact_person_phone' => $pMobile
        );

        $sm_db->where('ref_customer_id', $hidden_customer_id);
        $res_flag = $sm_db->update('customer_contact_person_dtl', $contact_person);

        $structure = './upload/customer_image/' . $hidden_customer_id;
        if (!is_dir($structure)) {
            $mkdir = mkdir($structure, 0777, true);
        }

        /* Profile Image Upload Config */
        $temp_file_name = $_FILES['image']['name'];
        if (!empty($temp_file_name)) {
            $temp              = explode('.', $temp_file_name);
            $my_real_file_name = $temp[0];


            $config['upload_path']   = './upload/customer_image/' . $hidden_customer_id;
            $config['allowed_types'] = 'jpg|jpeg|pjpeg|gif|png|x-png';
            $config['max_size']      = '2100'; //2 MB max size
            $config['file_name']     = 'cust' . $my_real_file_name;
            $config['overwrite']     = FALSE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('image');
            $image_data         = $this->upload->data();
            $orginal_image_name = $image_data['file_name'];


            if (!empty($orginal_image_name)) {
                $img = array(
                    'picture' => $orginal_image_name,
                );

                $sm_db->where('customer_id', $hidden_customer_id);
                $update = $sm_db->update('customer', $img);

                $file_path = $image_data['file_path'];
                $file      = $image_data['full_path'];
                $file_ext  = $image_data['file_ext'];
                //$final_file_name = "prv1_" . $image_data['file_name'];
                $final_file_name = $image_data['file_name'];
                rename($file, $file_path . $final_file_name);
            }
        }

        if (!empty($res_flag)) {
            return true;
        } else {
            return false;
        }
    }


    function validate_login()
    {
        $sm_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $arr     = [];

        $mobile   = $this->security->xss_clean($this->input->post('mobile'));
        $password = $this->security->xss_clean($this->input->post('password'));


        $sm_db->select('customer_id,name,password,mobile,status');
        $sm_db->where('status', 'A');
        $sm_db->where('mobile', $mobile);
        $query = $sm_db->get('customer');
        if ($query->num_rows() > 0) {
            $row       = $query->row();
            $db_pass   = $row->password;
            $id        = $row->customer_id;
            $name      = $row->name;
            $mobile_db = $row->mobile;
            if ($db_pass == $password) {  // pass match, login valid
                $arr['valid_login_customer'] = true;
                $arr['customer_id']          = $id;
                $arr['name']                 = $name;
                $arr['mobile']               = $mobile_db;
                return $arr;
            } else {        // pass did not match, invalid login
                return false;
            }
        } else {
            $sm_db->select('csl.id, c.customer_id,c.name,csl.password,c.mobile,c.status');
            $sm_db->where('csl.status', '1');
            $sm_db->group_start()
                ->where('csl.username', $mobile)
                ->or_where('csl.phone', $mobile)
                ->group_end();
            $sm_db->join('customer c', 'c.customer_id=csl.customer_id', 'left');
            $query = $sm_db->get('customer_sub_login csl');

            if ($query->num_rows()) {
                $password = md5($password);
                $row                = $query->row();
                $db_pass            = $row->password;
                $id                 = $row->customer_id;
                $name               = $row->name;
                $mobile_db          = $row->mobile;
                $sub_customer_id    = $row->id;
                if ($db_pass == $password) {  // pass match, login valid
                    $arr['valid_login_customer'] = true;
                    $arr['customer_id']          = $id;
                    $arr['name']                 = $name;
                    $arr['mobile']               = $mobile_db;
                    $arr['sub_customer_id']      = $sub_customer_id;
                    return $arr;
                } else {        // pass did not match, invalid login
                    return false;
                }
            }
            return false;
        }
    }


    /*
     * check weahter desire Phone is quniue or not
     * return : boolean
     */
    function check_user_mobile_uniq($user_mobile)
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $sm_db->select('mobile');
        $query = $sm_db->where("mobile", $user_mobile);
        $query = $sm_db->get('customer');

        if ($query->num_rows() > 0) {
            return true;
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

    /*
     * for Customer Dashboard
     * return : ticket list
     * Author: Mamun
     */
    function get_total_ticket_list_cus_dashboard_notice()
    {

        $read_db          = $this->load->database('icel', TRUE); /* database conection for read operation */
        $customer_auto_id = $this->session->userdata('customer_auto_id');

        $query = $read_db->select('`srd_id`, `ticket_no`, `send_from`,`created_date_time`');
        $query = $read_db->where('send_from', $customer_auto_id);
        $query = $read_db->order_by('created_date_time', 'DESC');
        $query = $read_db->get('sm_service_request_dtl', 0, 25);

        if ($query->num_rows() > 0) {
            $records = $query->result();
            return $records;
        } else {
            return false;
        }
    }

    /*
     * for Customer Dashboard
     * return : status wise total ticket
     * Author: Mamun
     */
    function get_status_wise_total_ticket_list_for_cus($status)
    {

        $read_db          = $this->load->database('icel', TRUE); /* database conection for read operation */
        $customer_auto_id = $this->session->userdata('customer_auto_id');

        $query = $read_db->select('`srd_id`');
        $query = $read_db->where('send_from', $customer_auto_id);
        $query = $read_db->where('status', $status);
        $query = $read_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    /*
     * for Customer Dashboard
     * return : status wise daily total ticket
     * Author: Mamun
     */
    function get_status_wise_ticket_list_daily_for_cus($status)
    {
        $read_db          = $this->load->database('icel', TRUE); /* database conection for read operation */
        $customer_auto_id = $this->session->userdata('customer_auto_id');

        $start_date_time = date('Y-m-d') . " 00:00:00";
        $end_date_time   = date('Y-m-d') . " 23:59:59";
        $sql             = "select `srd_id` from `sm_service_request_dtl` where `send_from` = '$customer_auto_id' and `status` = '" . $status . "' and (`created_date_time` between '" . $start_date_time . "' and '" . $end_date_time . "')";

        $query = $read_db->query($sql);
        //echo $read_db->last_query();exit();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    /*
     * for Customer Dashboard
     * return : status wise current month total ticket
     * Author: Mamun
     */
    function get_status_wise_ticket_list_monthly_for_cus($status)
    {

        $read_db          = $this->load->database('icel', TRUE); /* database conection for read operation */
        $customer_auto_id = $this->session->userdata('customer_auto_id');

        $month = date('m');
        $query = $read_db->select('`srd_id`');
        $query = $read_db->where('send_from', $customer_auto_id);
        $query = $read_db->where('month', $month);
        $query = $read_db->where('status', $status);
        $query = $read_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }


    public function update_password($where, $data)
    {
        $this->db->update('customer', $data, $where);
        return $this->db->affected_rows();
    }


    public function feedback_save($data)
    {
        $this->db->insert('customer_feed_back', $data);
        return $this->db->insert_id();
    }


    public function feedback_list_data($limit, $row)
    {

        $customer = $this->input->post('customer');
        $subject  = $this->input->post('sub');
        $std      = $this->input->post('stDate');
        $end      = $this->input->post('endDate');


        if (!empty($customer)) {

            $this->db->where('customer_feed_back.cust_ref_id', $customer);
        }

        if (!empty($subject)) {

            $this->db->where('customer_feed_back.f_subject', $subject);
        }

        if (!empty($std)) {

            $star_date = date('Y-m-d 00:00:00', strtotime($std));

            //echo $star_date .'<br>';

            $this->db->where('customer_feed_back.created >=', $star_date);
        }

        if (!empty($end)) {
            $end_date = date("Y-m-d 23:59:00", strtotime($end));

            //echo $end_date;

            $this->db->where('customer_feed_back.created <=', $end_date);
        }


        $this->db->select('c.customer_id,c.name,c.email,c.mobile,customer_feed_back.*,dep.name department');
        $this->db->join('customer c', 'customer_feed_back.cust_ref_id = c.customer_id', 'left');
        $this->db->join('medical_department dep', 'customer_feed_back.dep_ref_id = dep.id', 'left');
        $result = $this->db->get('customer_feed_back', $limit, $row);

        return $result->result();
    }


    public function ticket_total_rows()
    {

        $customer = $this->input->post('customer');
        $subject  = $this->input->post('sub');
        $std      = $this->input->post('stDate');
        $end      = $this->input->post('endDate');


        if (!empty($customer)) {

            $this->db->where('customer_feed_back.cust_ref_id', $customer);
        }

        if (!empty($subject)) {

            $this->db->where('customer_feed_back.f_subject', $subject);
        }

        if (!empty($std)) {

            $star_date = date('Y-m-d 00:00:00', strtotime($std));

            //echo $star_date .'<br>';

            $this->db->where('customer_feed_back.created >=', $star_date);
        }

        if (!empty($end)) {
            $end_date = date("Y-m-d 23:59:00", strtotime($end));

            //echo $end_date;

            $this->db->where('customer_feed_back.created <=', $end_date);
        }


        $this->db->select('c.customer_id,c.name,c.email,c.mobile,customer_feed_back.*');
        $this->db->join('customer c', 'customer_feed_back.cust_ref_id = c.customer_id', 'left');
        $result = $this->db->get('customer_feed_back');

        return $result->num_rows();
    }

    //============================= notification to customer ===========================
    public function notification_list($limit, $row)
    {

        $title = $this->input->post('title');
        $std   = $this->input->post('stDate');
        $end   = $this->input->post('endDate');


        if (!empty($title)) {

            $this->db->like('title', $title);
        }

        if (!empty($std)) {

            $star_date = date('Y-m-d 00:00:00', strtotime($std));

            //echo $star_date .'<br>';

            $this->db->where('created_at >=', $star_date);
        }

        if (!empty($end)) {
            $end_date = date("Y-m-d 23:59:00", strtotime($end));

            //echo $end_date;

            $this->db->where('created_at <=', $end_date);
        }

        $result = $this->db->get('notifications', $limit, $row);

        return $result->result();
    }


    public function customer_otp_list($limit, $row)
    {

        $customer = $this->input->post('customer');
        $std      = $this->input->post('stDate');
        $end      = $this->input->post('endDate');


        if (!empty($customer)) {

            $this->db->like('name', $customer);
        }


        if (!empty($std)) {

            $star_date = date('Y-m-d 00:00:00', strtotime($std));

            //echo $star_date .'<br>';

            $this->db->where('created_at >=', $star_date);
        }

        if (!empty($end)) {
            $end_date = date("Y-m-d 23:59:00", strtotime($end));

            //echo $end_date;

            $this->db->where('created_at <=', $end_date);
        }

        $this->db->where('verify_otp IS NOT NULL');
        $result = $this->db->get('customer', $limit, $row);

        return $result->result();
    }

    public function notification_total_rows()
    {

        $notification = $this->input->post('notification');
        $std          = $this->input->post('stDate');
        $end          = $this->input->post('endDate');


        if (!empty($notification)) {

            $this->db->like('message', $notification);
        }


        if (!empty($std)) {

            $star_date = date('Y-m-d 00:00:00', strtotime($std));

            //echo $star_date .'<br>';

            $this->db->where('created_at >=', $star_date);
        }

        if (!empty($end)) {
            $end_date = date("Y-m-d 23:59:00", strtotime($end));

            //echo $end_date;

            $this->db->where('created_at <=', $end_date);
        }

        $result = $this->db->get('notifications');

        return $result->num_rows();
    }


    public function notification_save($title, $type, $message)
    {
        $login_id = $this->session->userdata('admin_auto_id');

        $data = [
            'title'       => $title,
            'type'        => $type,
            'description' => $message,
            'status'      => 1,
            'created_at'  => date('Y-m-d H:i:s'),
            'created_by'  => $login_id,
        ];

        $this->db->insert('notifications', $data);
        return $this->db->insert_id();
    }

    //============================ end notification ====================================

    public function get_customer()
    {

        $this->db->select('c.customer_id,c.name');
        $this->db->join('customer c', 'f.cust_ref_id = c.customer_id', 'left');
        $result = $this->db->get('customer_feed_back f');

        return $result->result();
    }

    public function get_customer_dropdwon()
    {
        $this->db->where('status', 'A');
        $result = $this->db->get('customer');
        return $result->result();
    }

    public function get_customer_machine()
    {
        $result = $this->db->get('machine');
        return $result->result();
    }

    public function get_machine_wise_customer($machine_id)
    {

        $this->db->select('c.customer_id,c.name,dep.name department,insb.dep_ref_id');
        $this->db->join('customer c', 'insb.insb_customer = c.customer_id', 'left');
        $this->db->join('medical_department dep', 'insb.dep_ref_id = dep.id', 'left');
        $this->db->where('insb.insb_machine', $machine_id);
        $result = $this->db->get('install_base insb');

        if ($result->num_rows() > 0) {

            return $result->result();
        }
        return false;
    }


    public function get_customer_info($id)
    {

        $this->db->select('mobile');
        $this->db->where('customer_id', $id);
        $query = $this->db->get('customer');

        return $query->row()->mobile;
    }

    public function get_customer_sub_user_info($id)
    {

        $this->db->where('id', $id);
        $query = $this->db->get('customer_sub_login');
        return $query->row();
    }

    public function get_department_head($customer_id, $department_id = null)
    {
        $this->db->select('phone');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('department_id', $department_id);
        $query = $this->db->get('department_head');

        if ($query->num_rows() > 0) {
            return $query->row()->phone;
        }

        return false;
    }


    //===============================================================
    public function customer_wise_machine($customer_id = null)
    {
        $result = "";
        $this->db->select('machine.*,ins.insb_id,ins.insb_serial,ins.insb_version,ins.picture');
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

    //===============================================================
    public function sub_customer_wise_machine($customer_id = null)
    {
        $result = "";
        $this->db->where('customer_id_sub', $customer_id);
        $query = $this->db->get('install_base');

        if ($query->num_rows() > 0) {
            $result = $query->row();
        }

        return $result;
    }

    //=============================== customer wise notification =======================

    public function customer_wise_notification($customer_id = null)
    {
        $result = "";
        $this->db->select('notifications.*');
        $this->db->join('notifications', 'notifications.id = ntc.ntf_ref_id', 'left');
        if ($customer_id) $this->db->where('ntc.customer_id', $customer_id);

        $query = $this->db->get('notification_to_customer ntc');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    public function approved_sub_customer($sub_customer_id)
    {
        $this->db->update('customer_sub_login', ['status' => '1'], ['id' => $sub_customer_id]);
        return $this->db->affected_rows();
    }

    public function reject_sub_customer($sub_customer_id)
    {
        $this->db->delete('customer_sub_login', ['id' => $sub_customer_id]);
        return $this->db->affected_rows();
    }
}
