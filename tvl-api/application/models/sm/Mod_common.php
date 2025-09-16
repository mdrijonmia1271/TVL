<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_common
 *
 * @author bigm
 */
class Mod_common extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }


    function get_customer_array()
    {
        $read_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry = [];
        //$query = $read_db->select('cust_id,cust_email,cust_name');
        //$query = $read_db->where('cust_status',1);
        //$query = $read_db->order_by('cust_name','ASC');
        //$query = $read_db->get('cust_info');
        $sql   = "select cust_id,cust_email,cust_name from cust_info where cust_status = 1 and cust_email != '' order by cust_name ASC";
        $query = $read_db->query($sql);
        //$data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->cust_email] = $item->cust_name . " ( " . $item->cust_email . " )";
            }
        }

        return $data_arry;
    }

    function get_category_array()
    {
        $read_db       = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry     = '';
        $query         = $read_db->select('id,name');
        $query         = $read_db->where('status', 1);
        $query         = $read_db->order_by('name', 'ASC');
        $query         = $read_db->get('category');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->id] = $item->name;
            }
        }

        return $data_arry;
    }


    function get_designation_array()
    {
        $read_db       = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry     = '';
        $query         = $read_db->select('id,name');
        $query         = $read_db->where('status', 1);
        $query         = $read_db->order_by('name', 'ASC');
        $query         = $read_db->get('designation');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->id] = $item->name;
            }
        }

        return $data_arry;
    }

    function get_department_array()
    {
        $read_db       = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry     = '';
        $query         = $read_db->select('id,name');
        $query         = $read_db->where('status', 1);
        $query         = $read_db->order_by('name', 'ASC');
        $query         = $read_db->get('department');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->id] = $item->name;
            }
        }

        return $data_arry;
    }


    function get_customer_array_sms()
    {
        $read_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry = [];
        //$query = $read_db->select('cust_id,cust_phone,cust_name');
        //$query = $read_db->where('cust_status',1);
        //$query = $read_db->order_by('cust_phone','ASC');
        //$query = $read_db->get('cust_info');
        $sql   = "select cust_id,cust_phone,cust_name from cust_info where cust_status = 1 and cust_phone != '' order by cust_name ASC";
        $query = $read_db->query($sql);
        //$data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->cust_phone] = $item->cust_name . " ( " . $item->cust_phone . " )";;
            }
        }

        return $data_arry;
    }

    function get_category_array_sms()
    {
        $read_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry = [];
        $query     = $read_db->select('id,name');
        $query     = $read_db->where('status', 1);
        $query     = $read_db->order_by('name', 'ASC');
        $query     = $read_db->get('category');
        //$data_arry[''] = '';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->id] = $item->name;
            }
        }

        return $data_arry;
    }


    function get_designation_array_sms()
    {
        $read_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry = [];
        $query     = $read_db->select('id,name');
        $query     = $read_db->where('status', 1);
        $query     = $read_db->order_by('name', 'ASC');
        $query     = $read_db->get('designation');
        // $data_arry[''] = '';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->id] = $item->name;
            }
        }

        return $data_arry;
    }

    function get_customer_list_by_category_id($category_type)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $res     = '';
        $query   = $read_db->select('cust_id,cust_name,cust_phone');
        $query   = $read_db->where('cust_category', $category_type);
        $query   = $read_db->where('cust_status', 1);
        $query   = $read_db->order_by('cust_name', 'ASC');
        $query   = $read_db->get('cust_info');
        if ($query->num_rows() > 0) {
            $res = $query->result();
        }

        return $res;

    }

    function get_customer_list_by_category_id_mail($category_type)
    {
        $read_db = $this->load->database('icel', TRUE); /* database conection for read operation */
        $res     = '';
        $query   = $read_db->select('cust_id,cust_name,cust_email');
        $query   = $read_db->where('cust_category', $category_type);
        //$query = $read_db->where('cust_email !=','');
        $query = $read_db->where('cust_status', 1);
        $query = $read_db->order_by('cust_name', 'ASC');
        $query = $read_db->get('cust_info');
        if ($query->num_rows() > 0) {
            $res = $query->result();
        }

        return $res;

    }


    function get_division_list()
    {
        $data_arry = [];
        $query     = $this->db->select('DIVISION_ID,DIVISION_NAME');
        $query     = $this->db->order_by('DIVISION_NAME', 'ASC');
        $query     = $this->db->get('divisions');
        if ($query->num_rows() > 0) {
            $res           = $query->result();
            $data_arry[''] = 'Select';
            foreach ($res as $item) {
                $data_arry[$item->DIVISION_ID] = $item->DIVISION_NAME;
            }
        }

        return $data_arry;
    }


    function get_district_list($exclude = '')
    {
        $data_arry = [];
        $query     = $this->db->select('DISTRICT_ID,DISTRICT_NAME');
        if (!empty($exclude)) {
            $query = $this->db->where_not_in('DISTRICT_ID', $exclude);
        }

        $query = $this->db->order_by('DISTRICT_NAME', 'ASC');
        $query = $this->db->get('districts');
        if ($query->num_rows() > 0) {
            $res           = $query->result();
            $data_arry[''] = 'Select';
            foreach ($res as $item) {
                $data_arry[$item->DISTRICT_ID] = $item->DISTRICT_NAME;
            }
        }

        return $data_arry;
    }

    function get_disrict_list_by_div($divs_id, $url, $exclude = '')
    {

        $query = $this->db->select('DISTRICT_ID,DISTRICT_NAME');
        $query = $this->db->order_by('DISTRICT_NAME', 'ASC');

        if (!empty($exclude)) {
            $query = $this->db->where_not_in('DISTRICT_ID', $exclude);
        }

        $query  = $this->db->where('DIVISION_ID', $divs_id);
        $query  = $this->db->get('districts');
        $result = $query->result();
        //echo $this->db->last_query();
        //$url = base_url().'collegeregistration/';
        $options = '';
        $options .= '<select class="form-control" name="contact_add_district" id="district" onchange=getUpazallaByAjax("' . $url . '");>';
        $options .= '<option  value="">Select</option>';
        foreach ($result as $item) {
            $options .= '<option value="' . $item->DISTRICT_ID . '">' . $item->DISTRICT_NAME . '</option>';
        }
        $options .= '</select>';
        return $options;

    }

    function get_district_list_by_div_edit($division_id)
    {
        $arr    = '';
        $arr[0] = 'Select District';
        $query  = $this->db->select('DISTRICT_ID,DISTRICT_NAME');
        $query  = $this->db->order_by('DISTRICT_NAME', 'ASC');

        $query  = $this->db->where('DIVISION_ID', $division_id);
        $query  = $this->db->get('districts');
        $result = $query->result();
        //echo $this->db->last_query();
        //$url = base_url().'collegeregistration/';
        $options = '';
        $options .= '<select class="form-control" name="contact_add_district" id="district" onchange=getUpazallaByAjax();>';
        $options .= '<option  value="">Select</option>';
        foreach ($result as $item) {
            $arr[$item->DISTRICT_ID] = $item->DISTRICT_NAME;
            //$options .= '<option value="'.$item->DISTRICT_ID.'">'.$item->DISTRICT_NAME.'</option>';
        }
        $options .= '</select>';
        return $arr;


    }

    function get_upazila_list_by_dis($dis_id)
    {

        $query  = $this->db->select('THANA_ID,THANA_NAME');
        $query  = $this->db->order_by('THANA_NAME', 'ASC');
        $query  = $this->db->where('DISTRICT_ID', $dis_id);
        $query  = $this->db->get('thanas');
        $result = $query->result();
        //echo $this->db->last_query();

        $options = '';
        $options .= '<select class="form-control" name="contact_add_upazila" id="upazila">';
        $options .= '<option  value="">Select</option>';
        foreach ($result as $item) {
            $options .= '<option value="' . $item->THANA_ID . '">' . $item->THANA_NAME . '</option>';
        }
        $options .= '</select>';
        return $options;

    }

    function get_upazila_list_by_div_edit($district_id)
    {
        $arr    = '';
        $arr[0] = 'Select Thana';
        $query  = $this->db->select('THANA_ID,THANA_NAME');
        $query  = $this->db->order_by('THANA_NAME', 'ASC');
        $query  = $this->db->where('DISTRICT_ID', $district_id);
        $query  = $this->db->get('thanas');
        $result = $query->result();
        //echo $this->db->last_query();

        $options = '';
        $options .= '<select class="form-control" name="contact_add_upazila" id="upazila">';
        $options .= '<option  value="">Select</option>';
        foreach ($result as $item) {
            $arr[$item->THANA_ID] = $item->THANA_NAME;
            //$options .= '<option value="'.$item->THANA_ID.'">'.$item->THANA_NAME.'</option>';
        }
        $options .= '</select>';
        return $arr;


    }

    function get_service_engineer_array()
    {
        $read_db       = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry     = '';
        $query         = $read_db->select('ser_eng_id,name,status');
        $query         = $read_db->where('status', 'A');
        $query         = $read_db->order_by('name', 'ASC');
        $query         = $read_db->get('sm_service_engineer');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->ser_eng_id] = $item->name;
            }
        }

        return $data_arry;
    }

    function get_customer_array_dropdown()
    {
        $read_db       = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry     = '';
        $query         = $read_db->select('customer_id,name,status');
        $query         = $read_db->where('status', 'A');
        $query         = $read_db->order_by('name', 'ASC');
        $query         = $read_db->get('customer');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->customer_id] = $item->name;
            }
        }

        return $data_arry;
    }

    function get_customer_array_dropdown_admin()
    {
        $read_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry = [];
        $query     = $read_db->select('customer_id,name,status');

        if ($this->session->userdata('root_admin') == "no") {
            $arr = $this->session->userdata('assinged_customer');
            if (empty($arr)) {
                return false;
            }
            $query = $read_db->where_in('customer_id', $arr);
        }

        $query         = $read_db->where('status', 'A');
        $query         = $read_db->order_by('name', 'ASC');
        $query         = $read_db->get('customer');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->customer_id] = $item->name;
            }
        }

        return $data_arry;
    }

    function get_priority_array_dropdown()
    {
        $read_db       = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry     = '';
        $query         = $read_db->where('status', 'A');
        $query         = $read_db->order_by('priority_title', 'ASC');
        $query         = $read_db->get('sm_service_priority');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->priority_id] = $item->priority_title;
            }
        }
        return $data_arry;
    }

    function get_priority_color_array()
    {
        $read_db       = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry     = '';
        $query         = $read_db->where('status', 'A');
        $query         = $read_db->get('sm_service_priority');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->priority_id] = $item->color_code;
            }
        }
        return $data_arry;
    }

    function get_service_type_array_dropdown($customer_auto_id = null)
    {

        $read_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry = [];
        if (!empty($customer_auto_id)) {
            $query = $read_db->where('ref_custmr_id', $customer_auto_id);
        }
        $query         = $read_db->where('status', 'A');
        $query         = $read_db->order_by('service_type_title', 'ASC');
        $query         = $read_db->get('sm_service_type');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->service_type_id] = $item->service_type_title;
            }
        }
        return $data_arry;
    }


    function get_service_task_name_array_dropdown($customer_id)
    {
        $read_db       = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry     = '';
        $query         = $read_db->where('ref_custmr_id', $customer_id);
        $query         = $read_db->where('status', 'A');
        $query         = $read_db->order_by('task_title', 'ASC');
        $query         = $read_db->get('sm_service_task_name');
        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            foreach ($res as $item) {
                $data_arry[$item->task_name_id] = $item->task_title;
            }
        }
        return $data_arry;
    }


    function get_task_list_by_customer($customer_id)
    {

        $query  = $this->db->select('task_name_id,task_title');
        $query  = $this->db->order_by('task_name_id', 'ASC');
        $query  = $this->db->where('ref_custmr_id', $customer_id);
        $query  = $this->db->get('sm_service_task_name');
        $result = $query->result();
        //echo $this->db->last_query();

        $options = '';
        $options .= '<select class="form-control" name="ref_task_id" id="upazila">';
        $options .= '<option  value="">Select</option>';
        foreach ($result as $item) {
            $options .= '<option value="' . $item->task_name_id . '">' . $item->task_title . '</option>';
        }
        $options .= '</select>';
        return $options;

    }


    function get_supporttype_by_customer($customer_id)
    {
        $query  = $this->db->order_by('service_type_title', 'ASC');
        $query  = $this->db->where('ref_custmr_id', $customer_id);
        $query  = $this->db->get('sm_service_type');
        $result = $query->result();

        $options = '';
        $options .= '<select class="form-control" name="support_type" id="support_type">';
        $options .= '<option  value="">Select</option>';
        foreach ($result as $item) {
            $options .= '<option value="' . $item->service_type_id . '">' . $item->service_type_title . '</option>';
        }
        $options .= '</select>';
        return $options;
    }


    function get_admin_active_customer_id_array($adminid)
    {
        $read_db   = $this->load->database('icel', TRUE); /* database conection for read operation */
        $data_arry = array();
        $query     = $read_db->select('superadmin_customer_id,ref_superadmin_id,ref_customer_id,status');
        $query     = $read_db->where('ref_superadmin_id', $adminid);
        $query     = $read_db->where('status', 'A');
        $query     = $read_db->order_by('superadmin_customer_id', 'ASC');
        $query     = $read_db->get('sm_superadmin_customer');
//        $data_arry[''] = 'Select';
        if ($query->num_rows() > 0) {
            $res = $query->result();
            $i   = 0;
            foreach ($res as $item) {
                $data_arry[$i] = $item->ref_customer_id;
                $i++;
            }

        }

        return $data_arry;
    }

}//end class