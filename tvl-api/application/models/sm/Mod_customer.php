<?php
/**
 * Description of Mod_dc
 *
 * @author iPLUS DATA
 */
class Mod_customer extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    
    }
    
       function generate_customer_code($length = 6) {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }
    
    
       function generate_random_password($length = 6) {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }


    public function check_mobile($cMobile){


        $this->db->where('mobile',$cMobile);
        $query = $this->db->get('customer');

        if ($query->num_rows() > 0){

            return true;
        }
        else{
            return false;
        }

    }


    function save_data($data) {

        $this->db->insert('customer', $data);
        return $this->db->insert_id();

    }

    public function save_contact_person($data){
        $this->db->insert('customer_contact_person_dtl', $data);
        return $this->db->insert_id();
    }
    
    function send_mail($data_arr) {     
        $sender_email = get_mail_sender_email();
        $this->load->library('email');
        $this->email->from($sender_email, 'Customer Signup');
        $this->email->to($data_arr['email']);
        $this->email->subject('Customer Signup');

        $email_body = 'Dear '.strtoupper($data_arr['name']).', <br/><br/>';
        $email_body .= 'Your password is '.$data_arr['password'].' corresponding mobile number '.$data_arr['mobile'].' .<br>Thank you. ';
        $email_body .= "<br>";
        $email_body .= "<br>";
        $email_body .= "Thank You";
             
        $this->email->message($email_body);
        $this->email->send();
    }

    function get_customer_list($limit,$row) {
            $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
            $result = "";
            
            $query = $sm_db->order_by("customer_id", 'DESC');
            $query = $sm_db->get('customer',$limit,$row);

            if ( $query->num_rows() > 0 ) {
                $result = $query->result();                
            } 
            
            return $result;         
    }
    
    function customer_total_rows() {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
        $query = $sm_db->get('customer');
        return $query->num_rows();
    }

    
    function search_all_list($limit = '', $row = '') {
       $dt_array = '';
       $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */    
        
        $name = $this->session->userdata('name');
        $email = $this->session->userdata('email');
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
    
    function count_search_record() {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */    
        
        $name = $this->session->userdata('name');
        $email = $this->session->userdata('email');
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
	


    function get_details($id) {

        $this->db->select('customer.*,cust.contact_person_name,cust.contact_person_email,cust.contact_person_desig,cust.contact_person_phone');
        $this->db->from('customer');
        $this->db->join('customer_contact_person_dtl cust','cust.ref_customer_id=customer.customer_id','left');
        $this->db->where('customer_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_view($login_id) {
       $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $sm_db->where("mobile",$login_id);
        $query = $sm_db->get('customer');

        if ($query->num_rows() > 0) {
           $record = $query->row();           
           return $record;
        }else{
            return null;
        }   
    }

    function update_data() {

        $sm_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */       
        $hidden_customer_id= $this->security->xss_clean($this->input->post('hidden_customer_id'));
        $datetime= date('Y-m-d H:i:s');
        
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
            'telephone_no'               => $this->security->xss_clean($this->input->post('cTel')),
            'contact_add_division' => $this->security->xss_clean($cDiv),
            'contact_add_district' => $this->security->xss_clean($cDist),
            'contact_add_upazila'  => $this->security->xss_clean($cThana),
            'cust_flat'            => $cFlat,
            'cust_road'            => $cRoad,
            'cust_post'            => $cPost,
            'cust_post_code'       => $cPCode,
            'status'               =>'A',
            'updated_date_time'    =>$datetime,
            'created_by'           =>$login_admin_name,

        );


        $sm_db->where('customer_id', $hidden_customer_id);
        $res_flag = $sm_db->update('customer', $data_arry); /* call active record function to save information  */


        //======== contact person info ========
        $pName   = $this->security->xss_clean($this->input->post('pName'));
        $pDes    = $this->security->xss_clean($this->input->post('pDes'));
        $pEmail  = $this->security->xss_clean($this->input->post('pEmail'));
        $pMobile = $this->security->xss_clean($this->input->post('pMobile'));

        $contact_person = array(
            'contact_person_name' => $pName,
            'contact_person_desig' => $pDes,
            'contact_person_email' => $pEmail,
            'contact_person_phone' => $pMobile
        );

        $sm_db->where('ref_customer_id', $hidden_customer_id);
        $res_flag = $sm_db->update('customer_contact_person_dtl', $contact_person);

        $structure = './upload/customer_image/' . $hidden_customer_id;
        if (!is_dir($structure)) {
            $mkdir = mkdir($structure, 0777,true);
        }
        
        /* Profile Image Upload Config */
        $temp_file_name = $_FILES['image']['name'];
        if(!empty($temp_file_name)){
        $temp = explode('.', $temp_file_name);
        $my_real_file_name = $temp[0];

       
        $config['upload_path'] = './upload/customer_image/' . $hidden_customer_id;
        $config['allowed_types'] = 'jpg|jpeg|pjpeg|gif|png|x-png';
        $config['max_size'] = '2100'; //2 MB max size
        $config['file_name'] = 'cust' . $my_real_file_name;
        $config['overwrite'] = FALSE;
  
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('image');
        $image_data = $this->upload->data();
        $orginal_image_name = $image_data['file_name'];         
        
               
        if (!empty($orginal_image_name)) {
            $img = array(
                'picture' => $orginal_image_name, 
            );

            $sm_db->where('customer_id', $hidden_customer_id);
            $update = $sm_db->update('customer', $img);

            $file_path = $image_data['file_path'];
            $file = $image_data['full_path'];
            $file_ext = $image_data['file_ext'];
            //$final_file_name = "prv1_" . $image_data['file_name'];
            $final_file_name =  $image_data['file_name'];
            rename($file, $file_path . $final_file_name);
        }  
        }
        
        if(!empty($res_flag)){
            return true;
        }else{
            return false;
        }
    }
    
    
     function validate_login() {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $arr  = '';
        $db_pass = '';

        $mobile = $this->security->xss_clean($this->input->post('mobile'));
        $password = $this->security->xss_clean($this->input->post('password'));

     
        $query = $sm_db->select('customer_id,name,password,mobile,status');
        $query = $sm_db->where('status','A');
        $query = $sm_db->where('mobile',$mobile);
        $query = $sm_db->get('customer');

        if($query->num_rows() > 0){
            $row = $query->row();
            $db_pass = $row->password;
            $id = $row->customer_id;
            $name = $row->name;
            $mobile_db = $row->mobile;
            if($db_pass == $password){  // pass match, login valid
                $arr['valid_login_customer'] =  true;
                $arr['customer_id'] =  $id;
                $arr['name'] =  $name;
                $arr['mobile'] =  $mobile_db;
                return $arr;
            }else{        // pass did not match, invalid login
                return false;
            }
        }else{           // record was not found, invalid login, return false
            return false;
        }
    }
    
    
/*
 * check weahter desire Phone is quniue or not
 * return : boolean
 */
function check_user_mobile_uniq($user_mobile){
       $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
 
        $query = $sm_db->select('mobile');
        $query = $sm_db->where("mobile",$user_mobile);
        $query = $sm_db->get('customer');

        if ($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
}


function check_user_mobile_uniq_edit($user_mobile,$hidden_customer_id){
       $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
       
        $query = $sm_db->select('mobile');
        $query = $sm_db->where("mobile",$user_mobile);
        $query = $sm_db->where('customer_id!=', $hidden_customer_id);
        $query = $sm_db->get('customer');

        if ($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
}

    /*
     * for Customer Dashboard
     * return : ticket list
     * Author: Mamun
     */
    function get_total_ticket_list_cus_dashboard_notice() {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
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
    function get_status_wise_total_ticket_list_for_cus($status) {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
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
    function get_status_wise_ticket_list_daily_for_cus($status) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $customer_auto_id = $this->session->userdata('customer_auto_id');
        
        $start_date_time = date('Y-m-d') . " 00:00:00";
        $end_date_time = date('Y-m-d') . " 23:59:59";
        $sql = "select `srd_id` from `sm_service_request_dtl` where `send_from` = '$customer_auto_id' and `status` = '" . $status . "' and (`created_date_time` between '" . $start_date_time . "' and '" . $end_date_time . "')";

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
    function get_status_wise_ticket_list_monthly_for_cus($status) {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
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


 }