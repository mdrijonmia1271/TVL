<?php

/**
 * Description of Mod_admin
 *
 * @author iPLUS DATA
 */
class Mod_admin extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function generate_random_password($length = 6) {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }

    function save_data() {

        $sm_db = $this->load->database('icel', TRUE);                  
        $generate_random_password = $this->generate_random_password();

        $datetime = date('Y-m-d H:i:s');

        $fastname = $this->security->xss_clean($this->input->post('firstname'));
        $lastname = $this->security->xss_clean($this->input->post('lastname'));
        $name = $fastname . ' ' . $lastname;
        $data_arry = array(
            'name' => $name,
            'ser_eng_code' => $this->security->xss_clean($this->input->post('ser_eng_code')),
            'password' => $generate_random_password,
            'email' => $this->security->xss_clean($this->input->post('email')),
            'mobile' => $this->security->xss_clean($this->input->post('mobile')),
            'telephone_no' => $this->security->xss_clean($this->input->post('telephone_no')),
            'department' => $this->security->xss_clean($this->input->post('department')),
            'designation' => $this->security->xss_clean($this->input->post('designation')),
            'contact_add_details' => $this->security->xss_clean($this->input->post('contact_add_details')),
            'contact_add_division' => $this->security->xss_clean($this->input->post('contact_add_division')),
            'contact_add_district' => $this->security->xss_clean($this->input->post('contact_add_district')),
            'contact_add_upazila' => $this->security->xss_clean($this->input->post('contact_add_upazila')),
            'status' => 'A',
            'created_date_time' => $datetime,
            'created_by' => $name,
        );


        $this->db->insert('sm_service_engineer', $data_arry);

        $insert_id = $this->db->insert_id();

        if (!empty($insert_id)) {
            return $insert_id;
        } else {
            return false;
        }
    }

    function get_service_engineer_list($limit, $row) {
        $read_db = $this->load->database('icel', TRUE); 
        $result = "";

        $query = $read_db->order_by("ser_eng_id", 'DESC');
        $query = $read_db->get('sm_service_engineer', $limit, $row);

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    function service_engineer_total_rows() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $query = $read_db->get('sm_service_engineer');
        return $query->num_rows();
    }

    function get_details($auto_id) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $read_db->where("ser_eng_id", $auto_id);
        $query = $read_db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }

    function update_data() {
        $write_db = $this->load->database('icel', TRUE); /* database conection for write operation */

        $auto_id = $this->security->xss_clean($this->input->post('auto_id'));

        $dob_year = $this->security->xss_clean($this->input->post('dob_year'));
        $dob_month = $this->security->xss_clean($this->input->post('dob_month'));
        $dob_day = $this->security->xss_clean($this->input->post('dob_day'));

        if (!empty($dob_year) and ! empty($dob_month) and ! empty($dob_day)) {
            $date_of_birth = $dob_year . "-" . $dob_month . "-" . $dob_day;
        } else {
            $date_of_birth = "0000-00-00";
        }

        $cust_category = $this->security->xss_clean($this->input->post('cust_category'));
        $cust_name = $this->security->xss_clean($this->input->post('cust_name'));
        $cust_phone = $this->security->xss_clean($this->input->post('cust_phone'));
        $cust_phone2 = $this->security->xss_clean($this->input->post('cust_phone2'));
        $cust_phone3 = $this->security->xss_clean($this->input->post('cust_phone3'));
        $cust_phone4 = $this->security->xss_clean($this->input->post('cust_phone4'));
        $lan_phone = $this->security->xss_clean($this->input->post('lan_phone'));
        $cust_email = $this->security->xss_clean($this->input->post('cust_email'));
        $working_place = $this->security->xss_clean($this->input->post('working_place'));
        $cust_designation = $this->security->xss_clean($this->input->post('cust_designation'));
        $special_achivement = $this->security->xss_clean($this->input->post('special_achivement'));
        $present_address = $this->security->xss_clean($this->input->post('present_address'));
        $permanent_address = $this->security->xss_clean($this->input->post('permanent_address'));
        $cust_status = $this->security->xss_clean($this->input->post('cust_status'));

        $updated_by = $this->session->userdata('admin_login_email');

        $data_arry = array(
            'cust_category' => $cust_category,
            'cust_name' => $cust_name,
            'cust_phone' => $cust_phone,
            'cust_phone2' => $cust_phone2,
            'cust_phone3' => $cust_phone3,
            'cust_phone4' => $cust_phone4,
            'lan_phone' => $lan_phone,
            'cust_email' => $cust_email,
            'date_of_birth' => $date_of_birth,
            'working_place' => $working_place,
            'cust_designation' => $cust_designation,
            'special_achivement' => $special_achivement,
            'present_address' => $present_address,
            'permanent_address' => $permanent_address,
            'cust_status' => $cust_status,
        );


        $write_db->where('cust_id', $auto_id);
        $res_flag = $write_db->update('cust_info', $data_arry); /* call active record function to save information  */

        if (!empty($res_flag)) {
            return true;
        } else {
            return false;
        }
    }

    function search_all_list($limit = '', $row = '') {
        $dt_array = '';
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name = $this->session->userdata('name');
        $email = $this->session->userdata('email');
        $mobile = $this->session->userdata('mobile');
        $status = $this->session->userdata('status');


        if (!empty($name)) {
            $read_db->like('name', $name);
        }
        if (!empty($email)) {
            $read_db->where('email', $email);
        }
        if (!empty($mobile)) {
            $read_db->where('mobile', $mobile);
        }

        if (!empty($status)) {
            $read_db->where('status', $status);
        }

        $query = $read_db->get('sm_service_engineer');
        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';
        }

        return $dt_array;
    }

    function count_search_record() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name = $this->session->userdata('name');
        $email = $this->session->userdata('email');
        $mobile = $this->session->userdata('mobile');
        $status = $this->session->userdata('status');


        if (!empty($name)) {
            $read_db->like('name', $name);
        }
        if (!empty($email)) {
            $read_db->where('email', $email);
        }
        if (!empty($mobile)) {
            $read_db->where('mobile', $mobile);
        }

        if (!empty($status)) {
            $read_db->where('status', $status);
        }

        $query = $read_db->get('sm_service_engineer');
        return $query->num_rows();                        /* return table number of rows */
    }

    function validate_login() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $arr = '';
        $db_pass = '';

        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));


        $query = $read_db->select('id,username,password,status,root_admin,user_type');
        $query = $read_db->where('status', 'A');
        $query = $read_db->where('username', $username);
        $query = $read_db->get('sm_admin');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $db_pass = $row->password;
            $id = $row->id;
            $name = $row->username;
            $user_type = $row->user_type;
            $root_admin = $row->root_admin;
            
            if ($db_pass == $password) {  // pass match, login valid
                $arr['valid_login_admin'] = true;
                $arr['admin_id'] = $id;
                $arr['name'] = $name;
                $arr['root_admin'] = $root_admin;
                $arr['admin_user_type'] = $user_type;
                $arr['assinged_customer'] = null;
                
                if($root_admin == 'no'){ //logged in as customer manager, get assigned customer list
                    $assinged_customer = $this->get_admin_assigned_customer($id);
                     if(!empty($assinged_customer)){
                         $arr['assinged_customer'] = $assinged_customer;
                     }   
                }

                return $arr;
            } else {        // pass did not match, invalid login
                return false;
            }
        } else {           // record was not found, invalid login, return false
            return false;
        }
    }

    function get_admin_assigned_customer($admin_id) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
      
        $query = $read_db->select('ref_customer_id');
        $query = $read_db->where('ref_superadmin_id', $admin_id);
        $query = $read_db->get('sm_superadmin_customer');

        $arr = '';
        
        if ($query->num_rows() > 0) {
             $record = $query->result_array();
             foreach ($record as $key => $value) {
                 $arr[] = $value['ref_customer_id'];
             }
             return $arr;
        }else{
            return null;
        }        
    }    
    /*
     * check weahter desire Phone is quniue or not
     * return : boolean
     */

    function check_user_mobile_uniq($user) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $read_db->select('username');
        $query = $read_db->where("username", $user);
        $query = $read_db->get('sm_admin');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * for admin dashboard
     * return customer list, 
     * who have ticket
     * Author: Mamun
     */

    function get_customer_list_for_dashboard() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $read_db->select('customer.customer_id,customer.name,customer.status,sm_service_request_dtl.status');
        $read_db->from('customer');
        $read_db->join('sm_service_request_dtl', 'customer.customer_id = sm_service_request_dtl.send_from', 'inner');
        $read_db->group_by("customer.customer_id");
        $read_db->having("customer.status", 'A');
        //$read_db->having("sm_service_request_dtl.status",'P');

        $query = $read_db->get();
        //echo $read_db->last_query();exit();
        if ($query->num_rows() > 0) {
            $record = $query->result();
            return $record;
        } else {
            return null;
        }
    }

    /*
     * for Admin Dashboard
     * return : ticket list
     * Author: Mamun
     */

    function get_total_ticket_list_admin_dashboard_notice() {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $customer_auto_id = $this->session->userdata('customer_auto_id');
               
        $query = $read_db->select('`srd_id`, `ticket_no`, `send_from`,`created_date_time`');

        if($this->session->userdata('root_admin') == "no"){
            $arr = $this->session->userdata('assinged_customer');
            $query = $read_db->where_in('send_from',$arr);
        }        
        
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
     * for Admin Dashboard
     * return : status wise total ticket
     * Author: Mamun
     */

    function get_status_wise_total_ticket_list_for_admin($status) {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $read_db->select('`srd_id`');
        $query = $read_db->where('status', $status);
        $query = $read_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    /*
     * for Admin Dashboard
     * return : status wise daily total ticket
     * Author: Mamun
     */

    function get_status_wise_ticket_list_daily_for_admin($status) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $start_date_time = date('Y-m-d') . " 00:00:00";
        $end_date_time = date('Y-m-d') . " 23:59:59";
        $sql = "select `srd_id` from `sm_service_request_dtl` where `status` = '" . $status . "' and (`created_date_time` between '" . $start_date_time . "' and '" . $end_date_time . "')";

        $query = $read_db->query($sql);
        //echo $read_db->last_query();exit();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    /*
     * for Admin Dashboard
     * return : status wise current month total ticket
     * Author: Mamun
     */

    function get_status_wise_ticket_list_monthly_for_admin($status) {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $month = date('m');
        $query = $read_db->select('`srd_id`');
        $query = $read_db->where('month', $month);
        $query = $read_db->where('status', $status);
        $query = $read_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

}
