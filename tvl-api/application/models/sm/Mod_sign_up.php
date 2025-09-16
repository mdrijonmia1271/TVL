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

//=================== data save =================
    public function save_data($data) {

        $this->db->insert('customer', $data);
        return $this->db->insert_id();

    }

    public function save_contact_person($data){
        $this->db->insert('customer_contact_person_dtl', $data);
        return $this->db->insert_id();
    }

//==================================================

}