<?php
/**
 * Description of Mod_admin_config
 *
 * @author iPLUS DATA
 */
class Mod_admin_config extends CI_Model {
 
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
    
    
     
  
    function save_data_priority() {
              
        $read_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */       
        $datetime= date('Y-m-d H:i:s');

        $data_arry = array(              
            'priority_title' => $this->security->xss_clean($this->input->post('priority_name')),
            'color_code' => $this->security->xss_clean($this->input->post('color_code')),                       
            'status' =>$this->security->xss_clean($this->input->post('status')),
            'created_date_time' =>$datetime,
        );
  
        $insert_db= $read_db->insert('sm_service_priority', $data_arry);
        
         if (!empty($insert_db)) {           
            return $insert_db;
            } else {
            return false;
            }
    }
    
        function get_priority_list() {
            $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
            $result = "";
            $query = $read_db->get('sm_service_priority');

            if ( $query->num_rows() > 0 ) {
                $result = $query->result();                
            } 
            
            return $result;         
    }
    
    
    function edit_priority($id) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
        $dt_array = '';
        $read_db->where('priority_id', $id);
        $getRow = $read_db->get('sm_service_priority');
        $dt_array = $getRow->row();

        return $dt_array;
    }

    
      function modify_data_priority() {
              
        $read_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */       
        $datetime= date('Y-m-d H:i:s');         
        $hid_id = $this->security->xss_clean($this->input->post('hidden_priority_id'));
        

        $update_arry = array(              
            'priority_title' => $this->security->xss_clean($this->input->post('priority_name')),
            'color_code' => $this->security->xss_clean($this->input->post('color_code')),                       
            'status' =>$this->security->xss_clean($this->input->post('status')),
            'created_date_time' =>$datetime,
        );
        
        $read_db->where('priority_id', $hid_id);
        $update= $read_db->update('sm_service_priority', $update_arry);
       return TRUE;

    }
    
    
//    =================================TASK====================================
    

    
    function save_data_task() {
              
        $read_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */       
        $datetime= date('Y-m-d H:i:s');

        $data_arry = array(              
            'ref_custmr_id' => $this->security->xss_clean($this->input->post('cust_name')),
            'task_title' => $this->security->xss_clean($this->input->post('task_name')),                       
            'status' =>$this->security->xss_clean($this->input->post('status')),
            'created_date_time' =>$datetime,
        );
  
        $insert_db= $read_db->insert('sm_service_task_name', $data_arry);
        
         if (!empty($insert_db)) {           
            return $insert_db;
            } else {
            return false;
            }
    }
    
      function get_task_list() {
            $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
            $result = "";
            $query = $read_db->get('sm_service_task_name');

            if ( $query->num_rows() > 0 ) {
                $result = $query->result();                
            } 
            
            return $result;         
    }
    
      function edit_task($id) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
        $dt_array = '';
        $read_db->where('task_name_id', $id);
        $getRow = $read_db->get('sm_service_task_name');
        $dt_array = $getRow->row();

        return $dt_array;
    }

    
     function modify_data_task() {
              
        $read_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */       
        $datetime= date('Y-m-d H:i:s');
        
        $hid_id = $this->security->xss_clean($this->input->post('hidden_task_id'));

        $update_arry = array(              
            'ref_custmr_id' => $this->security->xss_clean($this->input->post('cust_name')),
            'task_title' => $this->security->xss_clean($this->input->post('task_name')),                       
            'status' =>$this->security->xss_clean($this->input->post('status')),
       
        );

        $read_db->where('task_name_id', $hid_id);
        $update= $read_db->update('sm_service_task_name', $update_arry);
        
  
       return TRUE;

    }
    
//    ==================================SERVICE TYPE===============================
    
    function save_data_service_type() {
              
        $read_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */       
        $datetime= date('Y-m-d H:i:s');

        $data_arry = array(              
            //'ref_custmr_id' => $this->security->xss_clean($this->input->post('cust_name')),
            'service_type_title' => $this->security->xss_clean($this->input->post('service_type_name')),                     
            //'service_start_date' => $this->security->xss_clean($this->input->post('service_start_date')),
            //'service_end_date' => $this->security->xss_clean($this->input->post('service_end_date')),
            //'free_paid' => $this->security->xss_clean($this->input->post('free_paid')),
            'status' =>$this->security->xss_clean($this->input->post('status')),
            'created_date_time' =>$datetime,
        );
  
        $insert_db= $read_db->insert('sm_service_type', $data_arry);
        
         if (!empty($insert_db)) {           
            return $insert_db;
            } else {
            return false;
            }
    }
    
        function get_service_type_list() {
            $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
            $result = "";
            $query = $read_db->get('sm_service_type');

            if ( $query->num_rows() > 0 ) {
                $result = $query->result();                
            } 
            
            return $result;         
    }
    
     function edit_service_type($id) {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */           
        $dt_array = '';
        $read_db->where('service_type_id', $id);
        $getRow = $read_db->get('sm_service_type');
        $dt_array = $getRow->row();

        return $dt_array;
    }
    
    function modify_data_service_type() {
              
        $read_db = $this->load->database('icel', TRUE);                  /* database conection for write operation */       
        $datetime= date('Y-m-d H:i:s');
       
        $hid_id = $this->security->xss_clean($this->input->post('hidden_service_type_name'));

        if(!empty($hid_id)){
            $update_arry = array(       
                //'ref_custmr_id' => $this->security->xss_clean($this->input->post('cust_name')),
                'service_type_title' => $this->security->xss_clean($this->input->post('service_type_name')), 
                //'service_start_date' => $this->security->xss_clean($this->input->post('service_start_date')),
                //'service_end_date' => $this->security->xss_clean($this->input->post('service_end_date')),
                //'free_paid' => $this->security->xss_clean($this->input->post('free_paid')),
               'status' =>$this->security->xss_clean($this->input->post('status')),

           );

           $read_db->where('service_type_id', $hid_id);
           $update= $read_db->update('sm_service_type', $update_arry);
           }
  
       return TRUE;

    }


    //--------------------- department ---------------------
    function get_department_list()
    {

        $result = "";
        $this->db->limit(10);
        $this->db->order_by('id', 'Desc');
        $query = $this->db->get('department');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }



    public function save_department(){

        $created_by = $this->session->userdata('login_admin_name');
        $datetime = date('Y-m-d H:i:s');

        $data_arry = array(
            'name' => $this->security->xss_clean($this->input->post('dep_name')),
            'created_by' => $created_by,
            'status' => $this->security->xss_clean($this->input->post('status')),
            'created_date_time' => $datetime,
        );

        $insert_db = $this->db->insert('department', $data_arry);

        if (!empty($insert_db)) {
            return $insert_db;
        } else {
            return false;
        }

    }

    function edit_departments($id)
    {

        $dt_array = '';
        $this->db->where('id', $id);
        $getRow = $this->db->get('department');
        $dt_array = $getRow->row();

        return $dt_array;
    }

    function update_departments($id)
    {
        $updated_by = $this->session->userdata('login_admin_name');
        $datetime = date('Y-m-d H:i:s');

        $update_arry = array(
            'name' => $this->security->xss_clean($this->input->post('dep_name')),
            'updated_by' => $updated_by,
            'updated_date_time' => $datetime,
            'status' => $this->security->xss_clean($this->input->post('status')),

        );

        $this->db->where('id', $id);
        $update = $this->db->update('department', $update_arry);

        return TRUE;
    }

    //---------------- end department --------------------

    function get_designation_list()
    {

        $result = "";
        $this->db->limit(10);
        $this->db->order_by('id', 'Desc');
        $query = $this->db->get('designation');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }



    public function save_designation(){

        $created_by = $this->session->userdata('login_admin_name');
        $datetime = date('Y-m-d H:i:s');

        $data_arry = array(
            'name' => $this->security->xss_clean($this->input->post('deg_name')),
            'created_by' => $created_by,
            'status' => $this->security->xss_clean($this->input->post('status')),
            'created_date_time' => $datetime,
        );

        $insert_db = $this->db->insert('designation', $data_arry);

        if (!empty($insert_db)) {
            return $insert_db;
        } else {
            return false;
        }

    }

    function edit_designations($id)
    {

        $dt_array = '';
        $this->db->where('id', $id);
        $getRow = $this->db->get('designation');
        $dt_array = $getRow->row();

        return $dt_array;
    }

    function update_designations($id)
    {
        $updated_by = $this->session->userdata('login_admin_name');
        $datetime = date('Y-m-d H:i:s');

        $update_arry = array(
            'name' => $this->security->xss_clean($this->input->post('deg_name')),
            'updated_by' => $updated_by,
            'updated_date_time' => $datetime,
            'status' => $this->security->xss_clean($this->input->post('status')),

        );

        $this->db->where('id', $id);
        $update = $this->db->update('designation', $update_arry);

        return TRUE;
    }
    
    
 }