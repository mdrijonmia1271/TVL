<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/13/18
 * Time: 4:35 PM
 */

class Mod_api extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }




    function validate_customer_login( $mobile, $password) {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $arr  = '';
        $db_pass = '';



        $query = $sm_db->select('customer_id,name,password,mobile,status,picture');
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

                if($row->status  =="A"){
                    $token_id =  $this->generate_random_token(10);

                    $arr['customer_photo'] = base_url() . 'upload/customer_image/' . $row->customer_id . '/' . $row->picture;

                    $arr['customer_acc_status'] =  'active';
                    $arr['customer_valid_login'] =  true;
                    $arr['customer_id'] =  $id;
                    $arr['customer_name'] =  $name;
                    $arr['customer_mobile'] =  $mobile_db;
                    $arr['customer_login_token'] =  $token_id;
                }else{
                    $arr['customer_valid_login'] =  true;
                    $arr['customer_acc_status'] =  'inactive';
                }

                return $arr;
            }else{        // pass did not match, invalid login
                return false;
            }
        }else{           // record was not found, invalid login, return false
            return false;
        }
    }


    function generate_random_token($length = 10) {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }

}