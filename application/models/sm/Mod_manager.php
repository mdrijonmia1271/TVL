<?php

/**
 * Description of Mod_manage
 *
 *
 */
class Mod_manager extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }

    function generate_random_password($length = 6)
    {

        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);

    }

    public function get_machine_supporttype_info($machine_id, $customer_id)
    {

        $this->db->select('su_type.*,service.service_type_title,install_base.insb_install_date,
                           install_base.insb_warranty_date,install_base.dep_ref_id');
        $this->db->from('cust_support_type su_type');
        $this->db->join('sm_service_type service', 'service.service_type_id = su_type.su_type_id', 'left');
        $this->db->join('install_base', 'install_base.insb_id = su_type.install_base_ref_id', 'left');

        $this->db->where('su_type.su_machine_id', $machine_id);
        $this->db->where('su_type.su_cust_ref_id', $customer_id);
        $this->db->where('su_type.status', 1);
        $this->db->order_by('su_type.su_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function support_type_validation($customer_id, $machine_id)
    {
        $date_now = date('Y-m-d');

        $this->db->where('su_start_date <=', $date_now);
        $this->db->where('su_end_date >=', $date_now);
        $this->db->where('su_cust_ref_id', $customer_id);
        $this->db->where('su_machine_id', $machine_id);
        $this->db->order_by('cust_support_type.su_id', 'desc');
        $this->db->limit(1);

        $query = $this->db->get('cust_support_type');

        return $query->num_rows();

    }

    function savedata()
    {

        $read_db                  = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $generate_randomticket_no = $this->generate_ticket_no();

        $datetime = date('Y-m-d H:i:s');


        $login_customer_phone = $this->session->userdata('login_customer_phone');
        $login_engineer_phone = $this->session->userdata('login_engineer_phone');


        if ($this->session->userdata('is_admin_login') == True) {
            $created_by_type = 'admin';
            $created_by      = $this->session->userdata('admin_auto_id');
        } else {
            redirect('sm/home/logout');
        }

        $customer_id = $this->security->xss_clean($this->input->post('send_from'));

        $data_arry = array(

            'ticket_no'          => $generate_randomticket_no,
            'send_from'          => $this->security->xss_clean($this->input->post('send_from')),
            'send_to'            => '',
            'support_type'       => $this->security->xss_clean($this->input->post('hidden_support_type_id')),
            'request_details'    => $this->security->xss_clean($this->input->post('request_details')),
            'machine_ref_id'     => $this->security->xss_clean($this->input->post('hidden_machine_id')),
            'ref_insb_id'        => $this->security->xss_clean($this->input->post('hidden_insb_id')),
            'dep_ref_id'         => $this->security->xss_clean($this->input->post('department')),
            'machine_serial'     => $this->security->xss_clean($this->input->post('hidden_insb_serial')),
            'contact_person'     => $this->security->xss_clean($this->input->post('cp_name')),
            'complain_date'      => $this->security->xss_clean($this->input->post('complain_date')),
            'contact_person_phn' => $this->security->xss_clean($this->input->post('cp_number')),
            'request_date_time'  => $datetime,
            'created_date_time'  => $datetime,
            'created_by'         => $created_by,
            'created_by_type'    => $created_by_type,
            'status'             => 'P',

        );

        if ($this->session->has_userdata('sub_customer_id') && $this->session->userdata('sub_customer_id')) {
            $data_arry['is_sub_customer'] = $this->session->userdata('sub_customer_id');
        }

        $read_db->insert('sm_service_request_dtl', $data_arry);
        $master_insert_id = $read_db->insert_id();


        //insert data on Table: sm_service_request_dtl_trans
        //$this->save_dtl_trans($master_insert_id,$generate_random_password);------------

        $read_db->where('ref_srd_id', $master_insert_id);
        $read_db->where('ticket_no', $generate_randomticket_no);
        $query = $read_db->get('sm_service_request_dtl_trans');
        if ($query->num_rows() > 0) {
//            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';

            $data_arry_trans = array(
                'ticket_no'         => $generate_randomticket_no,
                'ref_srd_id'        => $master_insert_id,
                'send_from'         => $this->security->xss_clean($this->input->post('send_from')),
                'subject'           => 'insertion',
                'request_details'   => $this->security->xss_clean($this->input->post('request_details')),
                'priority'          => $this->security->xss_clean($this->input->post('priority')),
                'support_type'      => $this->security->xss_clean($this->input->post('support_type')),
                'request_date_time' => $datetime,
                'created_date_time' => $datetime,
                'created_by'        => $created_by,
                'created_by_type'   => $created_by_type,
                'status'            => 'P',
            );
            if (!empty($this->input->post('ref_task_id'))) {
                $data_arry_trans['ref_task_id'] = $this->security->xss_clean($this->input->post('ref_task_id'));
            }

            $read_db->insert('sm_service_request_dtl_trans', $data_arry_trans);
        }

        if (!empty($master_insert_id)) {

            $read_db->select('mobile customer');
            $read_db->where('customer_id', $customer_id);
            $query  = $read_db->get('customer');
            $result = $query->row();

            $ticket = array('0' => $generate_randomticket_no, '1' => $result);

            return $ticket;

        } else {
            return false;
        }
    }

    function generate_ticket_no()
    {
        $icel_db       = $this->load->database('icel', TRUE);
        $ticket_number = '';
        $intticket     = '';
        $s1            = 'T';
        $sql           = "select max( substring( ticket_no, 4, 8 ) ) as maxno from sm_service_request_dtl";
//                $read_db->load->database();
        $query = $icel_db->query($sql);
        $R     = $query->row();
        if (!empty($R)) {
            $nextNo = $R->maxno + 1;
        } else {
            $nextNo = 1;
        }
        $intticket     = sprintf("%08d", $nextNo);
        $ticket_number = "$s1" . $intticket;

        return $ticket_number;
    }

    function get_ticket_list($limit, $row)
    {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";

        /*if ($this->session->userdata('root_admin') == "no") {
            $arr = $this->session->userdata('assinged_customer');
            if (empty($arr)) {
                return false;
            }
            $query = $read_db->where_in('send_from', $arr);
        }*/

        $read_db->select('sm_service_request_dtl.*,divisions.DIVISION_NAME,machine.*,install_base.insb_serial,
                          install_base.insb_version');
        $read_db->join('customer', 'customer.customer_id = sm_service_request_dtl.send_from', 'left');
        $read_db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');

        $read_db->join('machine', 'sm_service_request_dtl.machine_ref_id=machine.mc_id', 'left');
        $read_db->join('install_base', 'sm_service_request_dtl.ref_insb_id=install_base.insb_id', 'left');

        //$read_db->where("install_base.insb_customer = sm_service_request_dtl.send_from");

        $read_db->where("sm_service_request_dtl.st_flag", 0);
        $read_db->group_by('sm_service_request_dtl.srd_id');
        //$read_db->where("install_base.insb_machine = sm_service_request_dtl.machine_ref_id");

        $read_db->order_by("sm_service_request_dtl.srd_id", 'DESC');

        $query = $read_db->get('sm_service_request_dtl', $limit, $row);

//        echo $query->num_rows(); die();

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }


    function get_serivce_type()
    {

        $this->db->select('service.service_type_id,service.service_type_title');
        $this->db->where('service.status', 'A');
        $this->db->order_by('service.service_type_id', 'asc');
        $query = $this->db->get('sm_service_type service');
        return $query->result();
    }


    function ticket_total_rows()
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        if ($this->session->userdata('root_admin') == "no") {
            $arr = $this->session->userdata('assinged_customer');
            if (empty($arr)) {
                return false;
            }
            $query = $read_db->where_in('send_from', $arr);
        }

        $query = $read_db->get('sm_service_request_dtl');
        return $query->num_rows();
    }


    function search_all_list($limit = '', $row = '')
    {
        $dt_array = '';
        $read_db  = $this->load->database('icel', TRUE); /* database conection for read operation */

        $ticket_no = $this->session->userdata('ticket_no');
        $send_from = $this->session->userdata('send_from');
        $subject   = $this->session->userdata('subject');
        $status    = $this->session->userdata('status');


        if (!empty($name)) {
            $read_db->like('subject', $name);
        }
        if (!empty($email)) {
            $read_db->where('request_details', $email);
        }
        if (!empty($mobile)) {
            $read_db->where('ticket_no', $mobile);
        }

        if (!empty($status)) {
            $read_db->where('status', $status);
        }

        $query = $read_db->get('sm_service_request_dtl');
        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';
        }

        return $dt_array;
    }

    /*
     * search ticket from admin panel
     * return : array
     */
    function search_admin_ticket($limit = '', $row = '')
    {
        $dt_array = '';
        $read_db  = $this->load->database('icel', TRUE); /* database conection for read operation */

        $ticket_no     = $this->session->userdata('ticket_no');
        $customer_list = $this->session->userdata('customer_list');
        $engineer_list = $this->session->userdata('engineer_list');
        $priority      = $this->session->userdata('priority');
        $support_type  = $this->session->userdata('support_type');
        $status        = $this->session->userdata('status');
        $start_date    = $this->session->userdata('start_date');
        $end_date      = $this->session->userdata('end_date');

        if ($this->session->userdata('root_admin') == "no") {
            $arr = $this->session->userdata('assinged_customer');
            if (empty($arr)) {
                return false;
            }
        }

        if (!empty($ticket_no)) {

            $read_db->where('ticket.ticket_no', $ticket_no);

        } else {
            if (!empty($customer_list)) {
                $read_db->where('ticket.send_from', $customer_list);
            }

            if (empty($customer_list) && $this->session->userdata('root_admin') == "no" && !empty($arr)) {
                $query = $read_db->where_in('ticket.send_from', $arr);
            }

            if (!empty($engineer_list)) {
                $read_db->where('ticket.send_to', $engineer_list);
            }
            if (!empty($priority)) {
                $read_db->where('ticket.priority', $priority);
            }

            if (!empty($support_type)) {
                $read_db->where('ticket.support_type', $support_type);
            }
            if (!empty($status)) {
                $read_db->where('ticket.status', $status);
            }
        }

        if (!empty($start_date)) {

            $date_from = date('Y-m-d 00:00:00', strtotime($start_date));
            $read_db->where('ticket.created_date_time >=', $date_from);
        }

        if (!empty($end_date)) {
            $date_to = date('Y-m-d 23:59:59', strtotime($end_date));
            $read_db->where('ticket.created_date_time <=', $date_to);
        }

        $read_db->select('ticket.*,divisions.DIVISION_NAME,machine.*,install_base.insb_serial,
                          install_base.insb_version');
        $read_db->join('customer', 'customer.customer_id = ticket.send_from', 'left');
        $read_db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');

        $read_db->join('machine', 'ticket.machine_ref_id=machine.mc_id', 'left');
        $read_db->join('install_base', 'ticket.ref_insb_id=install_base.insb_id', 'left');


        $read_db->where("ticket.st_flag", 0);
        $read_db->group_by('ticket.srd_id');

        $read_db->order_by("ticket.srd_id", 'DESC');

        $query = $read_db->get('sm_service_request_dtl ticket');

        //$query = $read_db->get('sm_service_request_dtl', $limit, $row);

        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';
        }

        return $dt_array;
    }

    /*
  * search ticket from admin panel
  * return : array
  */
    function search_admin_ticket_count()
    {
        $dt_array = '';
        $read_db  = $this->load->database('icel', TRUE); /* database conection for read operation */

        $ticket_no     = $this->session->userdata('ticket_no');
        $customer_list = $this->session->userdata('customer_list');
        $engineer_list = $this->session->userdata('engineer_list');
        $priority      = $this->session->userdata('priority');
        $support_type  = $this->session->userdata('support_type');
        $status        = $this->session->userdata('status');

        if (!empty($ticket_no)) {

            $read_db->where('ticket_no', $ticket_no);

        } else {
            if (!empty($customer_list)) {
                $read_db->where('send_from', $customer_list);
            }
            if (!empty($engineer_list)) {
                $read_db->where('send_to', $engineer_list);
            }
            if (!empty($priority)) {
                $read_db->where('priority', $priority);
            }

            if (!empty($support_type)) {
                $read_db->where('support_type', $support_type);
            }
            if (!empty($status)) {
                $read_db->where('status', $status);
            }
        }
        $query = $read_db->get('sm_service_request_dtl');
        return $query->num_rows();
    }

    function count_search_record()
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name   = $this->session->userdata('name');
        $email  = $this->session->userdata('email');
        $mobile = $this->session->userdata('mobile');
        $status = $this->session->userdata('status');


        if (!empty($name)) {
            $read_db->like('subject', $name);
        }
        if (!empty($email)) {
            $read_db->where('request_details', $email);
        }
        if (!empty($mobile)) {
            $read_db->where('ticket_no', $mobile);
        }

        if (!empty($status)) {
            $read_db->where('status', $status);
        }

        $query = $read_db->get('sm_service_request_dtl');
        return $query->num_rows();                        /* return table number of rows */
    }

    function get_ticket_info()
    {
        $ticketId = $this->input->post('ticketId');
        $ticketNo = $this->input->post('ticketNo');
        $icel_db  = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $icel_db->where("srd_id", $ticketId);
        $query = $icel_db->where("ticket_no", $ticketNo);
        $query = $icel_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }

    function get_details($ticketId)
    {
        $icel_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $icel_db->where("srd_id", $ticketId);
        $query = $icel_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }

    function update_data()
    {
        $write_db = $this->load->database('icel', TRUE); /* database conection for write operation */

        $auto_id = $this->security->xss_clean($this->input->post('auto_id'));

        $dob_year  = $this->security->xss_clean($this->input->post('dob_year'));
        $dob_month = $this->security->xss_clean($this->input->post('dob_month'));
        $dob_day   = $this->security->xss_clean($this->input->post('dob_day'));

        if (!empty($dob_year) and !empty($dob_month) and !empty($dob_day)) {
            $date_of_birth = $dob_year . "-" . $dob_month . "-" . $dob_day;
        } else {
            $date_of_birth = "0000-00-00";
        }

        $cust_category      = $this->security->xss_clean($this->input->post('cust_category'));
        $cust_name          = $this->security->xss_clean($this->input->post('cust_name'));
        $cust_phone         = $this->security->xss_clean($this->input->post('cust_phone'));
        $cust_phone2        = $this->security->xss_clean($this->input->post('cust_phone2'));
        $cust_phone3        = $this->security->xss_clean($this->input->post('cust_phone3'));
        $cust_phone4        = $this->security->xss_clean($this->input->post('cust_phone4'));
        $lan_phone          = $this->security->xss_clean($this->input->post('lan_phone'));
        $cust_email         = $this->security->xss_clean($this->input->post('cust_email'));
        $working_place      = $this->security->xss_clean($this->input->post('working_place'));
        $cust_designation   = $this->security->xss_clean($this->input->post('cust_designation'));
        $special_achivement = $this->security->xss_clean($this->input->post('special_achivement'));
        $present_address    = $this->security->xss_clean($this->input->post('present_address'));
        $permanent_address  = $this->security->xss_clean($this->input->post('permanent_address'));
        $cust_status        = $this->security->xss_clean($this->input->post('cust_status'));

        $updated_by = $this->session->userdata('admin_login_email');

        $data_arry = array(
            'cust_category'      => $cust_category,
            'cust_name'          => $cust_name,
            'cust_phone'         => $cust_phone,
            'cust_phone2'        => $cust_phone2,
            'cust_phone3'        => $cust_phone3,
            'cust_phone4'        => $cust_phone4,
            'lan_phone'          => $lan_phone,
            'cust_email'         => $cust_email,
            'date_of_birth'      => $date_of_birth,
            'working_place'      => $working_place,
            'cust_designation'   => $cust_designation,
            'special_achivement' => $special_achivement,
            'present_address'    => $present_address,
            'permanent_address'  => $permanent_address,
            'cust_status'        => $cust_status,
        );


        $write_db->where('cust_id', $auto_id);
        $res_flag = $write_db->update('cust_info', $data_arry); /* call active record function to save information  */

        if (!empty($res_flag)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * update ticket status or assign to eng
     */
    function update_admin_ticket_status()
    {
        $icel_db = $this->load->database('icel', TRUE);

        $hidden_ticket_no     = $this->security->xss_clean($this->input->post('hidden_ticket_no'));
        $hidden_ticket_autoid = $this->security->xss_clean($this->input->post('hidden_ticket_autoid'));

        $status        = $this->security->xss_clean($this->input->post('status'));
        $engineer_list = $this->security->xss_clean($this->input->post('engineer_list'));
        $ticketcomment = $this->security->xss_clean($this->input->post('ticketcomment'));
        $priority      = $this->security->xss_clean($this->input->post('priority'));

        $datetime = date('Y-m-d H:i:s');

        $updated_by     = 'admin';
        $last_action_by = $this->session->userdata('admin_auto_id');

        $ticket_arr = $this->get_ticket_dtl_trans_arr($hidden_ticket_no);

        $ticket_request_dtl = array(
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
            'created_by'           => $last_action_by,
            'created_by_type'      => 'admin',
            'created_date_time'    => date('Y-m-d H:i:s'),
            'status'               => $ticket_arr['status'],
        );

        if (!empty($status) && !empty($engineer_list)) {

            $data_arry = array(
                'send_to'               => $engineer_list,
                'priority'              => $priority,
                'status'                => $status,
                'lead_date_time'        => $datetime,
                'last_action_by'        => $last_action_by,
                'last_action_date_time' => $datetime,
                'updated_by'            => $updated_by,
                'updated_date_time'     => $datetime,
            );

            $icel_db->where('srd_id', $hidden_ticket_autoid);
            $icel_db->where('ticket_no', $hidden_ticket_no);
            $res_flag = $icel_db->update('sm_service_request_dtl', $data_arry);

            //insert into trans table
            $ticket_request_dtl['send_to'] = $engineer_list;
            $ticket_request_dtl['status']  = $status;

            $icel_db->insert('sm_service_request_dtl_trans', $ticket_request_dtl);


        } else if (empty($status) && !empty($engineer_list)) {
            $data_arry = array(
                'send_to'               => $engineer_list,
                'priority'              => $priority,
                'lead_date_time'        => $datetime,
                'last_action_by'        => $last_action_by,
                'last_action_date_time' => $datetime,
                'updated_by'            => $updated_by,
                'updated_date_time'     => $datetime,
            );

            $icel_db->where('srd_id', $hidden_ticket_autoid);
            $icel_db->where('ticket_no', $hidden_ticket_no);
            $res_flag = $icel_db->update('sm_service_request_dtl', $data_arry);

            //insert into trans table
            $ticket_request_dtl['send_to'] = $engineer_list;
            $icel_db->insert('sm_service_request_dtl_trans', $ticket_request_dtl);


        } else if (!empty($status) && empty($engineer_list)) {
            $data_arry = array(
                'status'                => $status,
                'priority'              => $priority,
                'lead_date_time'        => $datetime,
                'last_action_by'        => $last_action_by,
                'last_action_date_time' => $datetime,
                'updated_by'            => $updated_by,
                'updated_date_time'     => $datetime,
            );
            $icel_db->where('srd_id', $hidden_ticket_autoid);
            $icel_db->where('ticket_no', $hidden_ticket_no);
            $res_flag = $icel_db->update('sm_service_request_dtl', $data_arry);

            //insert into trans table
            $ticket_request_dtl['status'] = $status;
            $icel_db->insert('sm_service_request_dtl_trans', $ticket_request_dtl);

        }

        if (!empty($ticketcomment)) {
            $comment_arry = array(
                'ref_srd_id'         => $hidden_ticket_autoid,
                'ticket_no'          => $hidden_ticket_no,
                'comments'           => $ticketcomment,
                'comment_from'       => $updated_by,
                'comments_by'        => $last_action_by,
                'comments_date_time' => date('Y-m-d H:i:s'),
            );

            $icel_db->insert('sm_service_request_dtl_comments', $comment_arry);
        }


        if (!empty($engineer_list)) {

            $icel_db->select('mobile');
            $icel_db->where('ser_eng_id', $engineer_list);
            $query  = $icel_db->get('sm_service_engineer');
            $result = $query->row();

            $mobile = $result->mobile;
            $message_details = get_temp_details('CREATE_TICKET_ENGINEER');
            if ($message_details) {
                $msg = message_format($message_details->message, [
                    'ticket_no' => $hidden_ticket_no,
                ]);
                send_sms($mobile, $msg);
            }

        }

        $this->db->where('ticket_no', $hidden_ticket_no);
        $query = $this->db->get('sm_service_request_dtl');
        if ($query->num_rows()) {
            $ticket_details = (array) $query->row();
            $message_details = get_temp_details('ALLOCATION_TICKET_ENGINEER_CUSTOMER');
            if ($message_details) {
                $msg = message_format($message_details->message, $ticket_details);
                send_sms($ticket_details['contact_person_phn'], $msg);
            }
        }

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


    function assignSETicket()
    {

        $icel_db  = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $srd_id   = $this->input->post('srd_id');//hidden ticket Id
        $datetime = date('Y-m-d H:i:s');


        if ($this->session->userdata('is_admin_login') == true) {
            $created_by_type = 'admin';
            $created_by      = $this->session->userdata('admin_auto_id');
        }

        $data_arry = array(
            'priority'     => $this->security->xss_clean($this->input->post('priority')),
            'support_type' => $this->security->xss_clean($this->input->post('support_type')),
            'send_to'      => $this->security->xss_clean($this->input->post('select_servie_eng')),

            'lead_date_time'        => $datetime,
            'last_action_by'        => $created_by,
            'last_action_date_time' => $datetime,
            'updated_by'            => $created_by,
            'updated_date_time'     => $datetime,
        );

        $icel_db->where('srd_id', $srd_id);
        $res_flag = $icel_db->update('sm_service_request_dtl', $data_arry);


        if (!empty($res_flag)) {
            return true;
        } else {
            return false;
        }
    }


    public function get_machine_list($id = null)
    {
        $result = "";
        $this->db->select('machine.*,ins.insb_id,ins.insb_serial,ins.insb_version');
        $this->db->join('install_base ins', 'ins.insb_machine=machine.mc_id', 'left');
        if ($id) $this->db->where('ins.insb_customer', $id);

        $this->db->where('ins.support_type !=', 5);
        $this->db->where('ins.support_type !=', 6);
        //$this->db->group_by('machine.mc_id');
        $query = $this->db->get('machine');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }


    public function get_support_list()
    {
        $result = "";
        $this->db->select('service_type_id,service_type_title');
        $this->db->where('status', 'A');
        $this->db->order_by("service_type_id", "asc");
        $query = $this->db->get('sm_service_type');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    public function delete_by_id($id)
    {

        $cancel_by = $this->session->userdata('admin_auto_id');
        $data      = array(
            'st_flag'          => 1,
            'cancel_user_type' => $cancel_by
        );

        $this->db->update('sm_service_request_dtl', $data, array('srd_id' => $id));
        //print_r($this->db->last_query()); exit();
        return $this->db->affected_rows();
    }

}