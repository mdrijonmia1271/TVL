<?php

/**
 * Description of Mod_serviceengineer
 *
 * @author iPLUS DATA
 */
class Mod_serviceengineer extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_ticket_list($limit, $row)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result = "";

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


        $read_db->select('sm_service_request_dtl.*,divisions.DIVISION_NAME,kb_post.ticket_ref_id');
        $read_db->join('knowledge_base_main kb_post', 'sm_service_request_dtl.srd_id = kb_post.ticket_ref_id', 'left');
        $read_db->join('customer', 'sm_service_request_dtl.send_from = customer.customer_id', 'left');
        $read_db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');

        $query = $read_db->order_by("sm_service_request_dtl.srd_id", 'DESC');
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

        $engineer_auto_id = $this->session->userdata('engineer_auto_id');
        $query = $read_db->where("send_to", $engineer_auto_id);

        $query = $read_db->where("srd_id", $auto_id);
        $query = $read_db->get('sm_service_request_dtl');

        if ($query->num_rows() > 0) {
            $record = $query->row();
            return $record;
        } else {
            return null;
        }
    }

    function get_ticket_comment_list($limit, $row, $ticket_no)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result = "";


        $query = $read_db->where('ticket_no', $ticket_no);
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


    public function get_spare_parts()
    {

        $query = $this->db->get('spare_parts');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }


    function search_all_list($limit = '', $row = '')
    {
        $dt_array = '';
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $ticket_no = $this->session->userdata('ticket_no');
//        $send_from = $this->session->userdata('send_from');
        $status = $this->session->userdata('status');
        $support_type = $this->session->userdata('support_type');
        $priority = $this->session->userdata('priority');


        if (!empty($ticket_no)) {
            $read_db->where('ticket.ticket_no', $ticket_no);
        }

        if (!empty($status)) {
            $read_db->where('ticket.status', $status);
        }


        if (!empty($support_type)) {
            $read_db->where('ticket.support_type', $support_type);
        }

        if (!empty($priority)) {
            $read_db->where('ticket.priority', $priority);
        }


        $read_db->select('ticket.*,divisions.DIVISION_NAME');
        $read_db->join('customer', 'ticket.send_from = customer.customer_id', 'left');
        $read_db->join('divisions', 'customer.contact_add_division = divisions.DIVISION_ID', 'left');

        $auto_id = $this->session->userdata('engineer_auto_id');
        $read_db->where('ticket.send_to', $auto_id);


        $query = $read_db->get('sm_service_request_dtl ticket');
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
        $status = $this->session->userdata('status');


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
        $sess_admin = $this->session->userdata('is_admin_login');

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
     * update ticket status from engineer
     * return : boolean
     */
    function update_ticket_status()
    {

        $icel_db = $this->load->database('icel', TRUE);

        $customer_id = $this->security->xss_clean($this->input->post('customer'));
        $machine_id = $this->security->xss_clean($this->input->post('machine'));

        $srd_id = $this->security->xss_clean($this->input->post('srd_id')); //hidden ticket auto id
        $ticket_no = $this->security->xss_clean($this->input->post('ticket_no')); //hidden ticket no
        $ticketcomment = $this->security->xss_clean($this->input->post('ticketcomment'));
        $acomment = $this->security->xss_clean($this->input->post('action_comment'));

        $customer_comment = $this->security->xss_clean($this->input->post('customer_comment'));
        $eng_rating = $this->security->xss_clean($this->input->post('eng_rating'));

        $status = $this->security->xss_clean($this->input->post('status'));

        $datetime = date('Y-m-d H:i:s');
        $created_by = 'engineer';

        $engineer_auto_id = $this->session->userdata('engineer_auto_id');

        $data_arry = array(
            'status' => $status,
            'last_action_by' => $engineer_auto_id,
            'customer_comment' => $customer_comment,
            'eng_rating' => $eng_rating,
            'last_action_date_time' => $datetime,
            'updated_by' => $engineer_auto_id,
            'updated_date_time' => $datetime,
        );


        $icel_db->where('srd_id', $srd_id);
        $res_flag = $icel_db->update('sm_service_request_dtl', $data_arry);


        //=============== user training ================
        $spare_parts = $this->security->xss_clean($this->input->post('spare'));
        $parts_qty = $this->security->xss_clean($this->input->post('sp_qty'));
        $additional = $this->security->xss_clean($this->input->post('addi_spare'));

        $i = 0;

        if (!empty($spare_parts)) {

            foreach ($spare_parts as $sp) {

                if (!empty($spare_parts[$i])) {

                    $data = array(
                        'sm_eng_ref_id' => $engineer_auto_id,
                        'sr_ticket_id' => $srd_id,
                        'spare_parts' => $spare_parts[$i],
                        'cust_ref_id' => $customer_id,
                        'machine_ref_id' => $machine_id,
                        'sp_quantity' => $parts_qty[$i],
                    );

                    $this->db->insert('spare_parts_request_trns', $data);
                }
                $i++;
            }

        }


        //read and  insert into trans table

        if (!empty($status)) {
            $ticket_dtl_trans_arr = get_ticket_dtl_trans_arr($ticket_no);

            $ticket_request_dtl = array(
                'ref_srd_id' => $ticket_dtl_trans_arr['ref_srd_id'],
                'ticket_no' => $ticket_dtl_trans_arr['ticket_no'],
                'send_from' => $ticket_dtl_trans_arr['send_from'],
                'send_to' => $ticket_dtl_trans_arr['send_to'],
                'service_add_details' => $ticket_dtl_trans_arr['service_add_details'],
                'subject' => $ticket_dtl_trans_arr['subject'],
                'request_details' => $ticket_dtl_trans_arr['request_details'],
                'priority' => $ticket_dtl_trans_arr['priority'],
                'support_type' => $ticket_dtl_trans_arr['support_type'],
                'ref_task_id' => $ticket_dtl_trans_arr['ref_task_id'],
                'month' => $ticket_dtl_trans_arr['month'],
                'year' => $ticket_dtl_trans_arr['year'],
                'request_date_time' => $ticket_dtl_trans_arr['request_date_time'],
                'created_by' => $engineer_auto_id,
                'created_by_type' => $created_by,
                'created_date_time' => date('Y-m-d H:i:s'),
                'status' => $status
            );
            $icel_db->insert('sm_service_request_dtl_trans', $ticket_request_dtl);
        }

        //comment insert  

        if (!empty($ticketcomment)) {
            $datetime = date('Y-m-d H:i:s');
            $data_arry_comment = array(
                'ref_srd_id' => $srd_id,
                'ticket_no' => $this->security->xss_clean($this->input->post('ticket_no')),
                'comments' => $ticketcomment,
                'action_comment' => $acomment,
                'other_spare' => $additional,
                'comment_from' => 'se',
                'comments_by' => $engineer_auto_id,
                'comments_date_time' => $datetime,
            );
            $icel_db->insert('sm_service_request_dtl_comments', $data_arry_comment);
        }

        if (!empty($res_flag)) {
            return true;
        } else {
            return false;
        }
    }

    //================= get data for job report =========

    public function get_comments($ticket_id)
    {

        $this->db->select('request.request_details,sm_service_request_dtl_comments.comments eng_comment,sm_service_request_dtl_comments.action_comment');
        $this->db->join('sm_service_request_dtl_comments', 'request.srd_id = sm_service_request_dtl_comments.ref_srd_id');
        $this->db->where('request.srd_id', $ticket_id);
        $this->db->where('sm_service_request_dtl_comments.comment_from', 'se');
        $query = $this->db->get('sm_service_request_dtl request');
        return $query->row();
    }


    public function get_equipment_data($ticket_id)
    {

        $this->db->select('machine.*,manufacture.mf_name');
        $this->db->join('machine', 'request.machine_ref_id = machine.mc_id', 'left');
        $this->db->join('manufacture', 'machine.mc_manufacture = manufacture.mf_id', 'left');
        $this->db->where('request.srd_id', $ticket_id);
        $query = $this->db->get('sm_service_request_dtl request');
        return $query->row();

    }


    public function get_job_report_data($id)
    {

        $this->db->select('customer.name,ticket.*,install_base.*,engineer.name eng');

        $this->db->join('customer', 'ticket.send_from = customer.customer_id', 'left');
        $this->db->join('install_base', 'ticket.machine_ref_id = install_base.insb_machine', 'left');
        $this->db->join('sm_service_engineer engineer', 'ticket.send_to = engineer.ser_eng_id', 'left');

        $this->db->where('ticket.srd_id', $id);

        $query = $this->db->get('sm_service_request_dtl as ticket');

        return $query->row();
    }


    public function get_spare_parts_data($id)
    {

        $this->db->select('spare.sp_name,trans.sp_quantity');
        $this->db->from('spare_parts_request_trns trans');
        $this->db->join('spare_parts spare', 'trans.spare_parts = spare.sp_id');
        $this->db->where('trans.sr_ticket_id', $id);
        $query = $this->db->get();

        return $query->result();
    }


    public function get_ticket_data($id)
    {

        $this->db->where('sm_service_request_dtl.srd_id', $id);
        $query = $this->db->get('sm_service_request_dtl');
        return $query->row();
    }

    //============================== knowledge base ===========

    public function save_kb_post($data)
    {

        $this->db->insert('knowledge_base_main', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }


    public function get_kb_list()
    {

        $this->db->select('knowledge_base_main.*,sm_service_engineer.name');
        $this->db->join('sm_service_engineer', 'knowledge_base_main.posted_by_eng_id = sm_service_engineer.ser_eng_id','left');
        //$this->db->join('knowledge_base_comment comm', 'knowledge_base_main.id = comm.base_ref_id','left');
        $this->db->order_by("knowledge_base_main.id", "desc");
        $query = $this->db->get('knowledge_base_main');

        return $query->result();
    }



    public function get_kb_data($id){

        $this->db->where("id",$id);
        $query = $this->db->get('knowledge_base_main');
        return $query->row();
    }


    public function save_kb_comment($data)
    {

        $this->db->insert('knowledge_base_comment', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }



//================= details show comment ==============================================
    public function get_kb_data_id($id){
        $this->db->select('knowledge_base_main.*,sm_service_engineer.name');
        $this->db->join('sm_service_engineer', 'knowledge_base_main.posted_by_eng_id = sm_service_engineer.ser_eng_id','left');
        $this->db->where("knowledge_base_main.id",$id);
        $query = $this->db->get('knowledge_base_main');

        return $query->row();
    }

    public function get_comment_data($id){
        $this->db->select('knowledge_base_comment.*,sm_service_engineer.name');
        $this->db->join('sm_service_engineer', 'knowledge_base_comment.commented_by_eng_ref = sm_service_engineer.ser_eng_id','left');
        $this->db->where("knowledge_base_comment.base_ref_id",$id);
        $query = $this->db->get('knowledge_base_comment');
        return $query->result();
    }

}
