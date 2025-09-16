<?php

/**
 * Description of Mod_engineer
 *
 * @author iPLUS DATA
 */
class Mod_engineer extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }

    function save_data()
    {

        $icel = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $generate_random_password = $this->generate_random_password();

        $datetime = date('Y-m-d H:i:s');

        $name = $this->security->xss_clean($this->input->post('name'));
//        $lastname= $this->security->xss_clean($this->input->post('lastname'));
//        $name = $fastname .' '.$lastname;

        $login_admin_name = $this->session->userdata('login_admin_name');

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
            'experience' => $this->security->xss_clean($this->input->post('experience')),
            'training' => $this->security->xss_clean($this->input->post('training')),
            'status' => 'A',
            'created_date_time' => $datetime,
            'created_by' => $login_admin_name,

        );


        $icel->insert('sm_service_engineer', $data_arry);
        $icel_insert_id = $icel->insert_id();

        $this->send_mail($data_arry);

        //        2000 kilobyte =2MB ,20000 KB =20MB
        $structure = './upload/service_engineer/' . $icel_insert_id;
        if (!is_dir($structure)) {
            $mkdir = mkdir($structure, 0777, true);
        }

        /* Preview Image Upload Config */
        $temp_file_name = $_FILES['image']['name'];
        $temp = explode('.', $temp_file_name);
        $my_real_file_name = $temp[0];

        $config['upload_path'] = $structure;
        $config['allowed_types'] = 'jpg|jpeg|pjpeg|gif|png|x-png';
        $config['max_size'] = '2200'; //2 MB max size
        $config['file_name'] = $my_real_file_name;
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('image');
        $image_data = $this->upload->data();

        $image = $image_data['file_name'];

        $upload_images = array(
            'picture' => $image,
        );


        if (!empty($upload_images)) {
            $res_image = $icel->update('sm_service_engineer', $upload_images, array('ser_eng_id' => $icel_insert_id));
        }

        if (!empty($icel_insert_id)) {
            return $icel_insert_id;
        } else {
            return false;
        }
    }

    function generate_random_password($length = 6)
    {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }

    function send_mail($data_arr)
    {
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';

        $this->load->library('email', $config);
        $this->email->from('info@bigm.com', 'Engineer Signup');
        $this->email->to($data_arr['email']);
        $this->email->subject('Engineer Signup');

        $email_body = 'Dear ' . strtoupper($data_arr['name']) . ', <br/><br/>';
        $email_body .= 'Your password is ' . $data_arr['password'] . ' corresponding mobile nimeber ' . $data_arr['mobile'] . ' .Thank you for signup. ';
        $email_body .= "<br>";
        $email_body .= "<br>";
        $email_body .= "Thank You";
//            echo $email_body;
//            exit;
        $this->email->message($email_body);
//        $this->email->send();
    }


    function get_service_engineer_list($limit, $row)
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result = "";
        $sm_db->select('sm_service_engineer.*,department.name dep,designation.name deg');
        $query = $sm_db->order_by("ser_eng_id", 'DESC');
        $sm_db->join('department', 'sm_service_engineer.department = department.id');
        $sm_db->join('designation', 'sm_service_engineer.designation = designation.id');
        $query = $sm_db->get('sm_service_engineer', $limit, $row);

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    function service_engineer_total_rows()
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $query = $sm_db->get('sm_service_engineer');
        return $query->num_rows();
    }


    function update_data()
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for write operation */
        $hidden_ser_eng_id = $this->security->xss_clean($this->input->post('hidden_ser_eng_id'));

        $datetime = date('Y-m-d H:i:s');

        $name = $this->security->xss_clean($this->input->post('name'));
//        $lastname= $this->security->xss_clean($this->input->post('lastname'));
//        $name = $fastname .' '.$lastname;

        $login_admin_name = $this->session->userdata('login_admin_name');

        $data_arry = array(
            'name' => $name,
            'email' => $this->security->xss_clean($this->input->post('email')),
            'mobile' => $this->security->xss_clean($this->input->post('mobile')),
            'telephone_no' => $this->security->xss_clean($this->input->post('telephone_no')),
            'ser_eng_code' => $this->security->xss_clean($this->input->post('ser_eng_code')),
            'department' => $this->security->xss_clean($this->input->post('department')),
            'designation' => $this->security->xss_clean($this->input->post('designation')),
            'experience' => $this->security->xss_clean($this->input->post('experience')),
            'training' => $this->security->xss_clean($this->input->post('training')),
            'contact_add_details' => $this->security->xss_clean($this->input->post('contact_add_details')),
            'status' => 'A',
            'updated_date_time' => $datetime,
            'created_by' => $login_admin_name,
        );
        if (isset($_POST['reset_pass']) && !empty($_POST['reset_pass'])) {
            $data_arry['password'] = $this->security->xss_clean($this->input->post('reset_pass'));
        }

        $sm_db->where('ser_eng_id', $hidden_ser_eng_id);
        $res_flag = $sm_db->update('sm_service_engineer', $data_arry); /* call active record function to save information  */


        $structure = './upload/service_engineer/' . $hidden_ser_eng_id;
        if (!is_dir($structure)) {
            $mkdir = mkdir($structure, 0777, true);
        }

        /* Profile Image Upload Config */
        $temp_file_name = $_FILES['image']['name'];
        if (!empty($temp_file_name)) {
            $temp = explode('.', $temp_file_name);
            $my_real_file_name = $temp[0];


            $config['upload_path'] = './upload/service_engineer/' . $hidden_ser_eng_id;
            $config['allowed_types'] = 'jpg|jpeg|pjpeg|gif|png|x-png';
            $config['max_size'] = '2100'; //2 MB max size
            $config['file_name'] = 'eng' . $my_real_file_name;
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

                $sm_db->where('ser_eng_id', $hidden_ser_eng_id);
                $update = $sm_db->update('sm_service_engineer', $img);

                $file_path = $image_data['file_path'];
                $file = $image_data['full_path'];
                $file_ext = $image_data['file_ext'];
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


    function search_all_list($limit = '', $row = '')
    {
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

        $query = $sm_db->get('sm_service_engineer');
        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';
        }

        return $dt_array;
    }

    function count_search_record()
    {
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

        $query = $sm_db->get('sm_service_engineer');
        return $query->num_rows();                        /* return table number of rows */
    }


    function validate_login()
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $arr = '';
        $db_pass = '';

        $mobile = $this->security->xss_clean($this->input->post('mobile'));
        $password = $this->security->xss_clean($this->input->post('password'));


        $query = $sm_db->select('ser_eng_id,password,status');
        $query = $sm_db->where('status', 'A');
        $query = $sm_db->where('mobile', $mobile);
        $query = $sm_db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $db_pass = $row->password;
            $id = $row->ser_eng_id;
            if ($db_pass == $password) {  // pass match, login valid
                $arr['valid_login_engineer'] = true;
                $arr['engineer_id'] = $id;
                return $arr;
            } else {        // pass did not match, invalid login
                return false;
            }
        } else {           // record was not found, invalid login, return false
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
        $query = $sm_db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    function check_user_mobile_uniq_edit($user_mobile, $hidden_ser_eng_id)
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $sm_db->select('mobile');
        $query = $sm_db->where("mobile", $user_mobile);
        $query = $sm_db->where('ser_eng_id!=', $hidden_ser_eng_id);
        $query = $sm_db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return null;
        }
    }

    /*
     * for Service Engineer Dashboard
     * return : ticket list
     * Author: Mamun
     */
    function get_total_ticket_list_ser_eng_dashboard_notice()
    {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $engineer_auto_id = $this->session->userdata('engineer_auto_id');

        $query = $read_db->select('`srd_id`, `ticket_no`, `send_from`,`created_date_time`');
        $query = $read_db->where('send_to', $engineer_auto_id);
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
     * for Service Engineer Dashboard
     * return : status wise total ticket
     * Author: Mamun
     */
    function get_status_wise_total_ticket_list_for_ser_eng($status)
    {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $engineer_auto_id = $this->session->userdata('engineer_auto_id');

        $query = $read_db->select('`srd_id`');
        $query = $read_db->where('send_to', $engineer_auto_id);
        $query = $read_db->where('status', $status);
        $query = $read_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    /*
     * for Service Engineer Dashboard
     * return : status wise daily total ticket
     * Author: Mamun
     */
    function get_status_wise_ticket_list_daily_for_ser_eng($status)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $engineer_auto_id = $this->session->userdata('engineer_auto_id');

        $start_date_time = date('Y-m-d') . " 00:00:00";
        $end_date_time = date('Y-m-d') . " 23:59:59";
        $sql = "select `srd_id` from `sm_service_request_dtl` where `send_to` = '$engineer_auto_id' and `status` = '" . $status . "' and (`created_date_time` between '" . $start_date_time . "' and '" . $end_date_time . "')";

        $query = $read_db->query($sql);
        //echo $read_db->last_query();exit();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    /*
     * for Service Engineer Dashboard
     * return : status wise current month total ticket
     * Author: Mamun
     */
    function get_status_wise_ticket_list_monthly_for_ser_eng($status)
    {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $engineer_auto_id = $this->session->userdata('engineer_auto_id');

        $month = date('m');
        $query = $read_db->select('`srd_id`');
        $query = $read_db->where('send_to', $engineer_auto_id);
        $query = $read_db->where('month', $month);
        $query = $read_db->where('status', $status);
        $query = $read_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }


    function edit_details($id)
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $query = $sm_db->where("ser_eng_id", $id);
        $query = $sm_db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }


    function get_details($login_id)
    {
        $sm_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $query = $sm_db->where("mobile", $login_id);
        $query = $sm_db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }
}