<?php

/**
 * Description of Mod_Ticket
 *
 * @author iPLUS DATA
 */
class Mod_Ticket extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function get_customer_wise_machine($customer_id = null)
    {

        if ($this->input->post('machine')) {

            $machine_id = $this->input->post('machine');
            $this->db->where('machine.mc_id', $machine_id);
        }

        $result = "";
        $this->db->select('machine.*,ins.insb_id,ins.insb_serial,ins.insb_version,ins.picture');
        $this->db->join('install_base ins', 'ins.insb_machine=machine.mc_id', 'left');
        if ($customer_id) $this->db->where('ins.insb_customer', $customer_id);

        if ($this->session->has_userdata('sub_customer_id')) {
            $this->db->where('customer_id_sub', $this->session->userdata('sub_customer_id'));
        }

        $this->db->group_start()
            ->where_not_in('ins.support_type', [5,6])
            ->or_where('ins.support_type is null')
            ->group_end();
        $this->db->where('ins.status', 1);

        $query = $this->db->get('machine');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }


    function generate_random_password($length = 4)
    {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"), 0, $length);
    }

    /*
     * function to generate ticket
     * return : ticket number
     */

    function save_data()
    {

        $read_db                  = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $generate_randomticket_no = $this->generate_ticket_no();

        $datetime = date('Y-m-d H:i:s');
        $month    = date("m");
        $year     = date("Y");


//        $login_admin_phone = $this->session->userdata('login_admin_phone');

        if ($this->session->userdata('is_customer_login') == True) {
            $created_by_type = 'customer';
            $created_by      = $this->session->userdata('customer_auto_id');
        } else if ($this->session->userdata('is_engineer_login') == True) {
            $created_by_type = 'engineer';
            $created_by      = $this->session->userdata('engineer_auto_id');
        } else if ($this->session->userdata('is_admin_login') == True) {
            $created_by_type = 'admin';
            $created_by      = $this->session->userdata('admin_auto_id');
        }


        $data_arry = array(
            'ticket_no'            => $generate_randomticket_no,
            'send_from'            => $this->security->xss_clean($this->input->post('send_from')),
            'service_add_details'  => $this->security->xss_clean($this->input->post('contact_add_details')),
            'service_add_division' => $this->security->xss_clean($this->input->post('contact_add_division')),
            'service_add_district' => $this->security->xss_clean($this->input->post('contact_add_district')),
            'service_add_upazila'  => $this->security->xss_clean($this->input->post('contact_add_upazila')),
            'subject'              => $this->security->xss_clean($this->input->post('subject')),
            'request_details'      => $this->security->xss_clean($this->input->post('request_details')),
            'month'                => $month,
            'year'                 => $year,
            'request_date_time'    => $datetime,
            'created_date_time'    => $datetime,
            'created_by'           => $created_by,
            'created_by_type'      => $created_by_type,
            'status'               => 'A',
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
                'ticket_no'            => $generate_randomticket_no,
                'ref_srd_id'           => $master_insert_id,
                'service_add_details'  => $this->security->xss_clean($this->input->post('contact_add_details')),
                'service_add_division' => $this->security->xss_clean($this->input->post('contact_add_division')),
                'service_add_district' => $this->security->xss_clean($this->input->post('contact_add_district')),
                'service_add_upazila'  => $this->security->xss_clean($this->input->post('contact_add_upazila')),
                'subject'              => $this->security->xss_clean($this->input->post('subject')),
                'request_details'      => $this->security->xss_clean($this->input->post('request_details')),
                'month'                => $month,
                'year'                 => $year,
                'request_date_time'    => $datetime,
                'created_date_time'    => $datetime,
                'status'               => 'A',
                'created_by'           => $created_by,
                'created_by_type'      => $created_by_type,
            );

            $read_db->insert('sm_service_request_dtl_trans', $data_arry_trans);
        }

        if (!empty($master_insert_id)) {
            return true;
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
        //dd($this->db->last_query());
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

    /*
     * save new ticket for customer
     */
    function save_customer_ticket()
    {

        $read_db            = $this->load->database('icel', TRUE);                  /* database conection for write operation */
        $generate_ticket_no = $this->generate_ticket_no();

        $datetime        = date('Y-m-d H:i:s');
        $month           = date("m");
        $year            = date("Y");
        $status          = 'P'; //pending, initaly all tickets are in pending status
        $created_by_type = 'customer';
        $send_from       = $this->session->userdata('customer_auto_id'); //customer auto id

        $data_arry = array(
            'ticket_no'          => $generate_ticket_no,
            'send_from'          => $send_from,
            'support_type'       => $this->security->xss_clean($this->input->post('hidden_support_type_id')),
            'request_details'    => $this->security->xss_clean($this->input->post('request_details')),
            'machine_ref_id'     => $this->security->xss_clean($this->input->post('hidden_machine_id')),
            'ref_insb_id'        => $this->security->xss_clean($this->input->post('hidden_insb_id')),
            'machine_serial'     => $this->security->xss_clean($this->input->post('hidden_insb_serial')),
            'contact_person'     => $this->security->xss_clean($this->input->post('cp_name')),
            'contact_person_phn' => $this->security->xss_clean($this->input->post('cp_number')),
            'dep_ref_id'         => $this->security->xss_clean($this->input->post('department')),
            'st_flag'            => '0',
            'request_date_time'  => $datetime,
            'created_date_time'  => $datetime,
            'created_by'         => $send_from,
            'created_by_type'    => $created_by_type,
            'status'             => $status,
        );

        if ($this->session->has_userdata('sub_customer_id') && $this->session->userdata('sub_customer_id')) {
            $data_arry['is_sub_customer'] = $this->session->userdata('sub_customer_id');
        }

        $read_db->insert('sm_service_request_dtl', $data_arry);
        $master_insert_id = $read_db->insert_id();

        $data_arry_trans = array(
            'ref_srd_id'        => $master_insert_id,
            'ticket_no'         => $generate_ticket_no,
            'send_from'         => $send_from,
            'support_type'      => $this->security->xss_clean($this->input->post('hidden_support_type_id')),
            'request_details'   => $this->security->xss_clean($this->input->post('request_details')),
            'machine_ref_id'    => explode(',', $this->security->xss_clean($this->input->post('machine')))[0],
            'dep_ref_id'        => $this->security->xss_clean($this->input->post('department')),
            'month'             => $month,
            'year'              => $year,
            'request_date_time' => $datetime,
            'created_date_time' => $datetime,
            'status'            => $status,
            'created_by'        => $send_from,
            'created_by_type'   => $created_by_type,
        );

        $master_insert_id = $read_db->insert('sm_service_request_dtl_trans', $data_arry_trans);

        $sms_arr = array(
            'ticket_no' => $generate_ticket_no,
            'mobile_no' => ''
        );
        //send_new_ticket_sms($sms_arr);

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

    //insert data "sm_service_request_dtl_trans " 1st time
    function save_dtl_trans($last_insertId, $ticket_no)
    {
        $read_db  = $this->load->database('icel', TRUE);
        $datetime = date('Y-m-d H:i:s');
        $month    = date("m");
        $year     = date("Y");

        $read_db->where('ref_srd_id', $last_insertId);
        $read_db->where('ticket_no', $ticket_no);
        $query = $read_db->get('sm_service_request_dtl_trans');
        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';

            $data_arry_trans = array(
                'ticket_no'            => $ticket_no,
                'ref_srd_id'           => $last_insertId,
                'send_from'            => $this->security->xss_clean($this->input->post('send_from')),
                'contact_add_details'  => $this->security->xss_clean($this->input->post('contact_add_details')),
                'contact_add_division' => $this->security->xss_clean($this->input->post('contact_add_division')),
                'contact_add_district' => $this->security->xss_clean($this->input->post('contact_add_district')),
                'contact_add_upazila'  => $this->security->xss_clean($this->input->post('contact_add_upazila')),
                'subject'              => $this->security->xss_clean($this->input->post('subject')),
                'request_details'      => $this->security->xss_clean($this->input->post('request_details')),
                'month'                => $month,
                'year'                 => $year,
                'request_date_time'    => $datetime,
                //               'created_by' => $send_from,
                //               'created_by_type' => $created_by_type,
                'created_date_time'    => $datetime,
                'status'               => 'P',
            );

            $read_db->insert('sm_service_request_dtl_trans', $data_arry_trans);
        }
    }


    public function get_support_type()
    {

        $customer_id = $this->session->userdata('customer_auto_id');

        $this->db->select('su_type.*,service.service_type_title');
        $this->db->from('cust_support_type su_type');
        $this->db->join('sm_service_type service', 'service.service_type_id = su_type.su_type_id', 'left');
        $this->db->where('su_type.su_cust_ref_id', $customer_id);
        $this->db->where('su_type.status', 1);
        $this->db->group_by('su_type.su_type_id');
        $this->db->order_by('su_type.su_id', 'desc');
        $query = $this->db->get();

        return $query->result();


    }

    function get_ticket_list($limit, $row)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";

//        $login_customer_phone= 'cu_'.$this->session->userdata('login_customer_phone');
//        $login_engineer_phone= 'se_'.$this->session->userdata('login_engineer_phone');

        $engineer_auto_id = $this->session->userdata('engineer_auto_id');
        $customer_auto_id = $this->session->userdata('customer_auto_id');

        if ($this->session->userdata('is_customer_login') == True) {
            $query = $read_db->where("send_from", $customer_auto_id);
        } else if ($this->session->userdata('is_engineer_login') == True) {
            $query = $read_db->where("send_to", $engineer_auto_id);
        } else if ($this->session->userdata('is_admin_login') == True) {
//          $query = $read_db->where("created_by", 'admin');
        }
        $read_db->select('sm_service_request_dtl.*,divisions.DIVISION_NAME,kb_post.ticket_ref_id,
                          machine.*,install_base.insb_serial,install_base.insb_version,dep.name department');

        $read_db->join('knowledge_base_main kb_post', 'sm_service_request_dtl.srd_id = kb_post.ticket_ref_id', 'left');
        $read_db->join('customer', 'sm_service_request_dtl.send_from = customer.customer_id', 'left');
        $read_db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');
        $read_db->join('machine', 'sm_service_request_dtl.machine_ref_id=machine.mc_id', 'left');
        $read_db->join('medical_department dep', 'sm_service_request_dtl.dep_ref_id=dep.id', 'left');
        $read_db->join('install_base', 'sm_service_request_dtl.ref_insb_id=install_base.insb_id', 'left');

        $read_db->group_by('sm_service_request_dtl.srd_id');
        $read_db->order_by("srd_id", 'DESC');

        if ($this->session->has_userdata('sub_customer_id')) {
            $read_db->where('install_base.customer_id_sub', $this->session->userdata('sub_customer_id'));
        }

        $read_db->where("sm_service_request_dtl.st_flag", 0);
        $query = $read_db->get('sm_service_request_dtl', $limit, $row);

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    function ticket_total_rows()
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $engineer_auto_id = $this->session->userdata('engineer_auto_id');
        $customer_auto_id = $this->session->userdata('customer_auto_id');

        if ($this->session->userdata('is_customer_login') == True) {
            $query = $read_db->where("send_from", $customer_auto_id);
        } else if ($this->session->userdata('is_engineer_login') == True) {
            $query = $read_db->where("send_to", $engineer_auto_id);
        } else if ($this->session->userdata('is_admin_login') == True) {
//          $query = $read_db->where("created_by", 'admin');
        }


        $query = $read_db->get('sm_service_request_dtl');
        return $query->num_rows();
    }


    function get_details($auto_id)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $query = $read_db->where("srd_id", $auto_id);
        $query = $read_db->get('sm_service_request_dtl');

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


    function get_ticket_comment_list($limit, $row)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";


        $query = $read_db->order_by("src_id", 'DESC');
        $query = $read_db->get('sm_service_request_dtl_comments', $limit, $row);

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    function ticket_comment_total_rows()
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */


        $query = $read_db->get('sm_service_request_dtl_comments');
        return $query->num_rows();
    }

    function get_ticket_comment_list_tab($ticket_no)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";

        $query = $read_db->where('ticket_no', $ticket_no);
        $query = $read_db->order_by("src_id", 'ASC');
        $query = $read_db->get('sm_service_request_dtl_comments');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }


    function get_ticket_trans_flow_tab($ticket_no)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result  = "";

        $query = $read_db->where('ticket_no', $ticket_no);
        $query = $read_db->order_by("rsrd_id", 'ASC');
        $query = $read_db->get('sm_service_request_dtl_trans');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    function search_all_list($limit = '', $row = '')
    {
        $dt_array = '';
        $read_db  = $this->load->database('icel', TRUE); /* database conection for read operation */

        $ticket_no = $this->session->userdata('ticket_no');
//        $send_from = $this->session->userdata('send_from');
        $subject = $this->session->userdata('subject');
        $status  = $this->session->userdata('status');


        if (!empty($subject)) {
            $read_db->like('subject', $subject);
        }

        if (!empty($ticket_no)) {
            $read_db->where('ticket_no', $ticket_no);
        }

        if (!empty($status)) {
            $read_db->where('status', $status);
        }

        $sess_customer = $this->session->userdata('is_customer_login');
        $sess_engineer = $this->session->userdata('is_engineer_login');
        $sess_admin    = $this->session->userdata('is_admin_login');

        if (isset($sess_customer)) {
            $auto_id = $this->session->userdata('customer_auto_id');
            $read_db->where('send_from', $auto_id);
        }
        if ($sess_engineer) {
            $auto_id = $this->session->userdata('engineer_auto_id');
            $read_db->where('send_to', $auto_id);
        }
        if ($sess_admin) {
            $auto_id = $this->session->userdata('admin_auto_id');
            //$read_db->where('request_details', $email);
        }

        $query = $read_db->get('sm_service_request_dtl');
        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';
        }

        return $dt_array;
    }

    function count_search_record()
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $ticket_no = $this->session->userdata('ticket_no');
//        $send_from = $this->session->userdata('send_from');
        $subject = $this->session->userdata('subject');
        $status  = $this->session->userdata('status');


        if (!empty($subject)) {
            $read_db->like('subject', $subject);
        }

        if (!empty($ticket_no)) {
            $read_db->where('ticket_no', $ticket_no);
        }

        if (!empty($status)) {
            $read_db->where('status', $status);
        }

        $sess_customer = $this->session->userdata('is_customer_login');
        $sess_engineer = $this->session->userdata('is_engineer_login');
        $sess_admin    = $this->session->userdata('is_admin_login');

        if (isset($sess_customer)) {
            $auto_id = $this->session->userdata('customer_auto_id');
            $read_db->where('send_from', $auto_id);
        }
        if ($sess_engineer) {
            $auto_id = $this->session->userdata('engineer_auto_id');
            $read_db->where('send_to', $auto_id);
        }
        if ($sess_admin) {
            $auto_id = $this->session->userdata('admin_auto_id');
            //$read_db->where('request_details', $email);
        }

        $query = $read_db->get('sm_service_request_dtl');
        return $query->num_rows();                        /* return table number of rows */
    }

    /*
     * search ticket from customer panel
     * return : array
     */
    function customer_ticket_search($limit = '', $row = '')
    {

        $dt_array = '';
        $read_db  = $this->load->database('icel', TRUE); /* database conection for read operation */

        $ticket_no    = $this->security->xss_clean($this->input->post('ticket_no'));
        $priority     = $this->security->xss_clean($this->input->post('priority'));
        $ref_task_id  = $this->security->xss_clean($this->input->post('ref_task_id'));
        $support_type = $this->security->xss_clean($this->input->post('support_type'));
        $status       = $this->security->xss_clean($this->input->post('status'));

        $customer_auto_id = $this->session->userdata('customer_auto_id');
        $read_db->select('service.*');
        $read_db->where('service.send_from', $customer_auto_id);
        if (!empty($ticket_no)) {
            $read_db->where('service.ticket_no', $ticket_no);
        } else {
            if (!empty($status)) {
                $read_db->where('service.status', $status);
            }
            if (!empty($priority)) {
                $read_db->where('service.priority', $priority);
            }
            if (!empty($ref_task_id)) {
                $read_db->where('service.ref_task_id', $ref_task_id);
            }
            if (!empty($support_type)) {
                $read_db->where('service.support_type', $support_type);
            }
        }
        $read_db->join('install_base', 'install_base.insb_id = service.ref_insb_id', 'left');
        if ($this->session->has_userdata('sub_customer_id')) $read_db->where('install_base.customer_id_sub', $this->session->userdata('sub_customer_id'));
        $query = $read_db->get('sm_service_request_dtl service');

//        print_r('<pre>');
//        print_r($read_db->last_query());
//        die();

        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';
        }
        return $dt_array;
    }

    function customer_ticket_search_count()
    {

        $dt_array = '';
        $read_db  = $this->load->database('icel', TRUE); /* database conection for read operation */

        $ticket_no    = $this->security->xss_clean($this->input->post('ticket_no'));
        $priority     = $this->security->xss_clean($this->input->post('priority'));
        $ref_task_id  = $this->security->xss_clean($this->input->post('ref_task_id'));
        $support_type = $this->security->xss_clean($this->input->post('support_type'));
        $status       = $this->security->xss_clean($this->input->post('status'));


        $customer_auto_id = $this->session->userdata('customer_auto_id');
        $read_db->where('send_from', $customer_auto_id);

        if (!empty($ticket_no)) {
            $read_db->where('ticket_no', $ticket_no);
        } else {
            if (!empty($status)) {
                $read_db->where('status', $status);
            }
            if (!empty($priority)) {
                $read_db->where('priority', $priority);
            }
            if (!empty($ref_task_id)) {
                $read_db->where('ref_task_id', $ref_task_id);
            }
            if (!empty($support_type)) {
                $read_db->where('support_type', $support_type);
            }
        }

        $query = $read_db->get('sm_service_request_dtl');
        return $query->num_rows();

    }

    function get_ticket_details($ticket_no)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $read_db->select('ticket.*,customer.customer_id,customer.name,machine.*,install_base.insb_serial,
                          install_base.insb_version,cust_contact.contact_person_name,cust_contact.contact_person_desig,
                          cust_contact.contact_person_phone,cust_contact.contact_person_email');

        $read_db->join('customer', 'customer.customer_id=ticket.send_from', 'left');
        $read_db->join('customer_contact_person_dtl cust_contact', 'customer.customer_id=cust_contact.ref_customer_id', 'left');


        $read_db->join('machine', 'ticket.machine_ref_id=machine.mc_id', 'left');
        $read_db->join('install_base', 'ticket.ref_insb_id=install_base.insb_id', 'left');

        $read_db->where("ticket.ticket_no", $ticket_no);
        $query = $read_db->get('sm_service_request_dtl  ticket');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
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
            return $record;
        } else {
            return null;
        }
    }

    /*
     * cancle ticket from customer or admin or engineer
     * return : boolean
     */
    function cancel_ticket($arr)
    {
        $icel_db = $this->load->database('icel', TRUE);

        $ticket_no      = $arr['ticket_no'];
        $cancel_from    = $arr['cancel_from'];
        $last_action_by = $arr['action_by'];
        $datetime       = date('Y-m-d H:i:s');

        $status = 'C'; //cancel

        $data_arry = array(
            'status'                => $status,
            'last_action_by'        => $last_action_by,
            'last_action_date_time' => $datetime,
            'updated_by'            => $cancel_from,
            'updated_date_time'     => $datetime,
            'cancel_user_type'      => $cancel_from
        );

        $icel_db->where('ticket_no', $ticket_no);
        $res_flag = $icel_db->update('sm_service_request_dtl', $data_arry);

        $ticket_dtl_trans_arr = get_ticket_dtl_trans_arr($ticket_no);

        $ticket_request_dtl = array(
            'ref_srd_id'           => $ticket_dtl_trans_arr['ref_srd_id'],
            'ticket_no'            => $ticket_dtl_trans_arr['ticket_no'],
            'send_from'            => $ticket_dtl_trans_arr['send_from'],
            'send_to'              => $ticket_dtl_trans_arr['send_to'],
            'service_add_division' => $ticket_dtl_trans_arr['service_add_division'],
            'service_add_district' => $ticket_dtl_trans_arr['service_add_district'],
            'service_add_upazila'  => $ticket_dtl_trans_arr['service_add_upazila'],
            'service_add_details'  => $ticket_dtl_trans_arr['service_add_details'],
            'subject'              => $ticket_dtl_trans_arr['subject'],
            'request_details'      => $ticket_dtl_trans_arr['request_details'],
            'priority'             => $ticket_dtl_trans_arr['priority'],
            'support_type'         => $ticket_dtl_trans_arr['support_type'],
            'ref_task_id'          => $ticket_dtl_trans_arr['ref_task_id'],
            'month'                => $ticket_dtl_trans_arr['month'],
            'year'                 => $ticket_dtl_trans_arr['year'],
            'request_date_time'    => $ticket_dtl_trans_arr['request_date_time'],
            'created_by'           => $last_action_by,
            'created_by_type'      => $cancel_from,
            'created_date_time'    => date('Y-m-d H:i:s'),
            'status'               => $status
        );
        $icel_db->insert('sm_service_request_dtl_trans', $ticket_request_dtl);

        return true;
    }


    public function save_customer_comment($where, $data)
    {
        $this->db->update('sm_service_request_dtl', $data, $where);
        return $this->db->affected_rows();
    }


    public function get_supervisor(){
        $this->db->where('user_type', 'sm');
        $query = $this->db->get('sm_admin');

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }
}
