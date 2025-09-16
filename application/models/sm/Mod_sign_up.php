<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/15/18
 * Time: 11:13 AM
 */

class Mod_sign_up extends CI_Model
{



    public function __construct()
    {
        parent::__construct();
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

    public function check_username($cUsername){


        $this->db->where('username',$cUsername);
        $query = $this->db->get('customer_sub_login');

        if ($query->num_rows() > 0){

            return true;
        }
        else{
            return false;
        }

    }

    public function check_exist($cMobile,$otp, $status = 'checking'){
        $this->db->where(['phone'=>$cMobile, 'otp_pass'=>$otp]);
        $query = $this->db->get('customer_sub_login');

        if ($query->num_rows() > 0){
            if ($status == 'checking') {
                return $query->row();
            } elseif ($status == 'verified') {
                return $this->db->update('customer_sub_login',['otp_pass' => 'verified'], ['phone'=>$cMobile, 'otp_pass'=>$otp]);
            }
        }
        else{
            return false;
        }

    }

//=================== data save =================
    public function save_data($data, $table = 'customer') {

        $this->db->insert($table, $data);
        return $this->db->insert_id();

    }

    public function get_customer_list() {
        $query = $this->db->select(["customer_id as id", "concat(name, ' (', cust_post, ')') as name"])
            ->where('status', 'A')
            ->get('customer');
        if ($query->num_rows()) {
            return array_column($query->result_array(), 'name', 'id');
        }
        return false;
    }

    public function save_contact_person($data){
        $this->db->insert('customer_contact_person_dtl', $data);
        return $this->db->insert_id();
    }

//==================================================

//============= forgot password ================
    public function mobile_exists($key)
    {
        $this->db->where('mobile',$key);
        $query = $this->db->get('customer');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }


    public function update_password($where, $data)
    {
        $this->db->update('customer', $data, $where);
        return $this->db->affected_rows();
    }


}