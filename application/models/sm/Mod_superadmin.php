<?php

/**
 * Description of Mod_admin_config
 *
 * @author iPLUS DATA
 */
class Mod_superadmin extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_customer_name() {
        $read_db = $this->load->database('icel', TRUE);
        $arr = '';
        $read_db->select('customer_id,name,status');
        $read_db->where('status', 'A');

        $query = $read_db->get('customer');
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $arr[''] = 'Please Select Customer';
            foreach ($result as $value) {
                $arr[$value->customer_id] = $value->name;
            }
        }

        return $arr;
    }

//    ==================================Superadmin===============================
    function generate_random_password($length = 6) {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }

    function save_data_superadmin() {

        $read_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $datetime = date('Y-m-d H:i:s');
        //$generate_random_password = $this->generate_random_password();

        $data_arry = array(
            'superadmin_name' => $this->security->xss_clean($this->input->post('superadmin_name')),
            'username' => $this->security->xss_clean($this->input->post('username')),
            'password' => $this->security->xss_clean($this->input->post('superadmin_pass')),
            'email' => $this->security->xss_clean($this->input->post('email')),
            'mobile' => $this->security->xss_clean($this->input->post('mobile')),
            'user_type' => $this->security->xss_clean($this->input->post('uType')),
            'status' => $this->security->xss_clean($this->input->post('status')),
            'created_date_time' => $datetime,
        );



        $insert_db = $read_db->insert('sm_admin', $data_arry);
        $last_insert_id = $read_db->insert_id();


        $structure = './upload/admin/' . $last_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777,true);
        }

        /* Profile Image Upload Config */
        $temp_file_name = $_FILES['photo']['name'];
        if(!empty($temp_file_name)){
            $temp = explode('.', $temp_file_name);
            $my_real_file_name = $temp[0];


            $config['upload_path'] = './upload/admin/' . $last_insert_id;
            $config['allowed_types'] = 'jpg|jpeg|pjpeg|gif|png|x-png';
            $config['max_size'] = '300';
            $config['file_name'] = 'admin' . $my_real_file_name;
            $config['overwrite'] = FALSE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('photo');
            $image_data = $this->upload->data();
            $orginal_image_name = $image_data['file_name'];


            if (!empty($orginal_image_name)) {
                $img = array(
                    'picture' => $orginal_image_name,
                );

                $read_db->where('id', $last_insert_id);
                $read_db->update('sm_admin', $img);

            }
        }



            //---------Start Insert Customer-----------------------------
        $txt_customerarray = $this->security->xss_clean($this->input->post('customerarray'));

        if (!empty($last_insert_id) && !empty($txt_customerarray)) {
            foreach ($txt_customerarray as $customerid) {

                $customer_array = array(
                    'ref_superadmin_id' => $last_insert_id,
                    'ref_customer_id' => $customerid,
                    'status' => 'A',
                    'created_date_time' => $datetime,
                );

                $insert_customer_db = $read_db->insert('sm_superadmin_customer', $customer_array);
            }
        }
        //----------End Insert Customer------------------------------



        if (!empty($insert_db)) {
            return $insert_db;
        } else {
            return false;
        }
    }

    function get_superadmin_list() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result = "";
        $query = $read_db->get('sm_admin');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    function edit_superadmin($id) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $dt_array = '';
        $read_db->where('id', $id);
        $getRow = $read_db->get('sm_admin');
        $dt_array = $getRow->row();

        return $dt_array;
    }

    function modify_data_superadmin() {

        $read_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $datetime = date('Y-m-d H:i:s');

        $hid_id = $this->security->xss_clean($this->input->post('hidden_superadmin_id'));

        $superadmin_pass = $this->security->xss_clean($this->input->post('superadmin_pass'));
        
        if(!empty($superadmin_pass)){
            $update_arry = array(
                'superadmin_name' => $this->security->xss_clean($this->input->post('superadmin_name')),
                'username' => $this->security->xss_clean($this->input->post('username')),
                'password' => $superadmin_pass,
                'email' => $this->security->xss_clean($this->input->post('email')),
                'mobile' => $this->security->xss_clean($this->input->post('mobile')),
                'user_type' => $this->security->xss_clean($this->input->post('uType')),
                'status' => $this->security->xss_clean($this->input->post('status')),
                'updated_date_time' => $datetime,
            );            
        }else{
        $update_arry = array(
            'superadmin_name' => $this->security->xss_clean($this->input->post('superadmin_name')),
            'username' => $this->security->xss_clean($this->input->post('username')),
            'email' => $this->security->xss_clean($this->input->post('email')),
            'mobile' => $this->security->xss_clean($this->input->post('mobile')),
            'status' => $this->security->xss_clean($this->input->post('status')),
            'updated_date_time' => $datetime,
        );
            
        }

        $read_db->where('id', $hid_id);
        $update = $read_db->update('sm_admin', $update_arry);

        $structure = './upload/admin/' . $hid_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777,true);
        }

        /* Profile Image Upload Config */
        $temp_file_name = $_FILES['photo']['name'];
        if(!empty($temp_file_name)){
            $temp = explode('.', $temp_file_name);
            $my_real_file_name = $temp[0];


            $config['upload_path'] = './upload/admin/' . $hid_id;
            $config['allowed_types'] = 'jpg|jpeg|pjpeg|gif|png|x-png';
            $config['max_size'] = '300'; //2 MB max size
            $config['file_name'] = $my_real_file_name;
            $config['overwrite'] = FALSE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('photo');
            $image_data = $this->upload->data();
            $orginal_image_name = $image_data['file_name'];


            if (!empty($orginal_image_name)) {
                $img = array(
                    'picture' => $orginal_image_name,
                );

                $read_db->where('id', $hid_id);
                $read_db->update('sm_admin', $img);

                $file_path = $image_data['file_path'];
                $file = $image_data['full_path'];
                $file_ext = $image_data['file_ext'];
                $final_file_name =  $image_data['file_name'];
                rename($file, $file_path . $final_file_name);
            }
        }



        //---------Start Insert Customer-----------------------------
        $txt_customerarray = $this->security->xss_clean($this->input->post('customerarray'));

        if (!empty($hid_id) && !empty($txt_customerarray)) {


            //delete previous customer id Db rows

            $delete_customer_db = $read_db->where('ref_superadmin_id', $hid_id);
            $delete_customer_db = $read_db->delete('sm_superadmin_customer');



            //insert
            foreach ($txt_customerarray as $customerid) {

                $customer_array = array(
                    'ref_superadmin_id' => $hid_id,
                    'ref_customer_id' => $customerid,
                    'status' => 'A',
                    'created_date_time' => $datetime,
                );

                $insert_customer_db = $read_db->insert('sm_superadmin_customer', $customer_array);
            }
        }
        //----------End Insert Customer------------------------------

        return TRUE;
    }

//    superadmin_customer_list


    function get_superadmin_customer_list() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result = "";
        $query = $read_db->get('sm_superadmin_customer');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    function get_customer_list() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result = "";
        $query = $read_db->get('customer');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

}
