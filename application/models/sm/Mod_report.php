<?php
/**
 * Description of Mod_manage
 *
 * 
 */
class Mod_report extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    
    }
    
    
    

    
    function get_ticket_list($limit,$row) {

        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $result = "";

        $query = $read_db->order_by("srd_id", 'DESC');
        $query = $read_db->get('sm_service_request_dtl', $limit, $row);

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }
    
    function ticket_total_rows() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
        $query = $read_db->get('customer');
        return $query->num_rows();
    }
    
      function get_customer_list($limit,$row) {
            $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
            $result = "";
            
            $query = $read_db->order_by("customer_id", 'DESC');
            $query = $read_db->get('customer',$limit,$row);

            if ( $query->num_rows() > 0 ) {
                $result = $query->result();                
            } 
            
            return $result;         
    }

       function customer_total_rows() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
        $query = $read_db->get('customer');
        return $query->num_rows();
    }

    
    
    //customer
    function search_customer_list($limit = '', $row = '') {
        $dt_array = '';
        $icel_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name = $this->session->userdata('name');
        $code = $this->session->userdata('code');
        $dob_year = $this->session->userdata('dob_year');
        $dob_month = $this->session->userdata('dob_month');
        $date_from = $this->session->userdata('date_from');
        $date_to = $this->session->userdata('date_to');
        $status = $this->session->userdata('status');
        $department = $this->session->userdata('department');


        $icel_db->select('*');


        if (!empty($name)) {
            $icel_db->where('send_from', $name);//send_to
        }

        if (!empty($department)) {
            $icel_db->where('dep_ref_id', $department);//send_to
        }

        if (!empty($code)) {
            $icel_db->where('code', $code);
        }
        if (!empty($dob_year)) {
            $icel_db->where('YEAR(created_date_time)', $dob_year);
        }

        if (!empty($dob_month)) {
            $icel_db->where('MONTH(created_date_time)', $dob_month);
        }
        if (!empty($date_from)) {
            $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
            $icel_db->where('created_date_time >=', $star_date);
        }
        if (!empty($date_to)) {
            $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
            $icel_db->where('created_date_time <=', $end_date);
        }

        if (!empty($status)) {
            $icel_db->where('status', $status);
        }
        
        
        $icel_db->group_by('send_from');
           
        $query = $icel_db->get('sm_service_request_dtl');

        //print_r($icel_db->last_query()); exit();

        if ($query->num_rows() > 0) { 
            $dt_array = $query->result();                      /* Get the Result as Array */
           
            
        } else {
            $dt_array = '';
        }

        return $dt_array;
    }

    function count_search_customer_record() {
        $dt_array = '';
        $icel_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name = $this->session->userdata('name');
        $code = $this->session->userdata('code');
        $dob_year = $this->session->userdata('dob_year');
        $dob_month = $this->session->userdata('dob_month');
        $date_from = $this->session->userdata('date_from');
        $date_to = $this->session->userdata('date_to');
        $status = $this->session->userdata('status');

       // $icel_db->distinct();
        $icel_db->select('*');
        if (!empty($name)) {
            $icel_db->where('send_from', $name);//send_to
        }
        if (!empty($code)) {
            $icel_db->where('code', $code);
        }
        if (!empty($dob_year)) {
            $icel_db->where('YEAR(created_date_time)', $dob_year);
        }

        if (!empty($dob_month)) {
            $icel_db->where('MONTH(created_date_time)', $dob_month);
        }
        if (!empty($date_from)) {
            $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
            $icel_db->where('created_date_time >=', $star_date);
        }
        if (!empty($date_to)) {
            $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
            $icel_db->where('created_date_time <=', $end_date);
        }

        if (!empty($status)) {
            $icel_db->where('status', $status);
        }
        //$icel_db->group_by('send_from');
        $query = $icel_db->get('sm_service_request_dtl');
        return $query->num_rows();                        /* return table number of rows */
    }
	
    
    
    
    
    
     //service_eng
    function search_service_eng_list($limit = '', $row = '') {
        $dt_array = '';
        $icel_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name = $this->session->userdata('name');
        $code = $this->session->userdata('code');
        $dob_year = $this->session->userdata('dob_year');
        $dob_month = $this->session->userdata('dob_month');
        $date_from = $this->session->userdata('date_from');
        $date_to = $this->session->userdata('date_to');
        $status = $this->session->userdata('status');

        //$icel_db->distinct();
        //$icel_db->select('send_to');
        $icel_db->select('*');
        
        if (!empty($name)) {
            $icel_db->where('send_to', $name);//send_to
        }
        if (!empty($code)) {
           $icel_db->where('code', $code);
        }
        if (!empty($dob_year)) {
            $icel_db->where('YEAR(created_date_time)', $dob_year);
        }

        if (!empty($dob_month)) {
            $icel_db->where('MONTH(created_date_time)', $dob_month);
        }
        if (!empty($date_from)) {
            $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
            $icel_db->where('created_date_time >=', $star_date);
        }
        if (!empty($date_to)) {
            $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
            $icel_db->where('created_date_time <=', $end_date);
        }

        if (!empty($status)) {
            $icel_db->where('status', $status);
        }
        
        $icel_db->group_by('send_to');

        $query = $icel_db->get('sm_service_request_dtl');
       //print_r($icel_db->last_query()); exit();

        if ($query->num_rows() > 0) {
            $dt_array = $query->result();                      /* Get the Result as Array */
        } else {
            $dt_array = '';
        }

        return $dt_array;
    }

    function count_search_service_eng_record() {
        $icel_db = $this->load->database('icel', TRUE); /* database conection for read operation */

        $name = $this->session->userdata('name');
        $code = $this->session->userdata('code');
        $dob_year = $this->session->userdata('dob_year');
        $dob_month = $this->session->userdata('dob_month');
        $date_from = $this->session->userdata('date_from');
        $date_to = $this->session->userdata('date_to');
        $status = $this->session->userdata('status');

        //$icel_db->distinct();
        //$icel_db->select('send_to');
        $icel_db->select('*');

        if (!empty($name)) {
            $icel_db->where('send_to', $name);//send_to
        }
        if (!empty($code)) {
            $icel_db->where('code', $code);
        }
        if (!empty($dob_year)) {
            $icel_db->where('YEAR(created_date_time)', $dob_year);
        }

        if (!empty($dob_month)) {
            $icel_db->where('MONTH(created_date_time)', $dob_month);
        }
        if (!empty($date_from)) {
            $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
            $icel_db->where('created_date_time >=', $star_date);
        }
        if (!empty($date_to)) {
            $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
            $icel_db->where('created_date_time <=', $end_date);
        }

        if (!empty($status)) {
            $icel_db->where('status', $status);
        }

        //$icel_db->group_by('send_to');

        $query = $icel_db->get('sm_service_request_dtl');

        return $query->num_rows();                        /* return table number of rows */
    }
    
    
    
       function get_service_engineer_list($limit,$row) {
            $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
            $result = "";
            
            $query = $read_db->order_by("ser_eng_id", 'DESC');
            $query = $read_db->get('sm_service_engineer',$limit,$row);

            if ( $query->num_rows() > 0 ) {
                $result = $query->result();                
            } 
            
            return $result;         
    }
    
       function service_engineer_total_rows() {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
        $query = $read_db->get('sm_service_engineer');
        return $query->num_rows();
    }
    
    
     function get_support_type_list() {
            $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
            $result = "";
            
            //$query = $read_db->order_by("service_type_id", 'DESC');
            $query = $read_db->where('status', 'A');
            $read_db->order_by('service_type_title','asc');
            $query = $read_db->get('sm_service_type');

            if ( $query->num_rows() > 0 ) {
                $result = $query->result();                
            } 
            
            return $result;         
    }
    
    
     function get_priority_list() {
            $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
            $result = "";
            
            $query = $read_db->order_by("priority_id", 'DESC');
            $query = $read_db->where('status', 'A');
            $query = $read_db->get('sm_service_priority');

            if ( $query->num_rows() > 0 ) {
                $result = $query->result();                
            } 
            
            return $result;         
    }

 }