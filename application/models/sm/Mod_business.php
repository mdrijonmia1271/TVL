<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/19/18
 * Time: 10:27 AM
 */

class Mod_business extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

//==================== first load a list of parts ====================
    public function get_spare_parts_list(){

        $result = "";
        $this->db->where('bu_status',0);
        $this->db->order_by("bu_id", "desc");
        $query = $this->db->get('business_area');
        if ( $query->num_rows() > 0 ) {
            $result = $query->result();
        }

        return $result;
    }

    //=============== when search show this list ================
    public function get_search_list($name,$status){


        $result = '';

        if (!empty($name)){
            $this->db->where('bu_name',$name);
        }
        if (!empty($status)){
            $this->db->where('bu_status',$status);
        }

        $this->db->where('bu_status',0);
        $this->db->order_by("bu_id", "desc");
        $query = $this->db->get('business_area');

        if ( $query->num_rows() > 0 ) {
            $result = $query->result();

            return $result;
        }


    }

    //============== parts info save ===============
    public function save_data($data){

        $this->db->insert('business_area', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    //================== get data for edit and update purpose ==============
    public function get_by_id($id)
    {
        $this->db->from('business_area');
        $this->db->where('bu_id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function update_data($where, $data){
        $this->db->update('business_area', $data, $where);
        return $this->db->affected_rows();
    }

    //============ delete data but not remove database just update status ==========
    public function delete_by_id($where, $data){
        $this->db->update('business_area', $data, $where);
        return $this->db->affected_rows();
    }


}