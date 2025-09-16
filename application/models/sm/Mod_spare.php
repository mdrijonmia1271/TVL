<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/6/18
 * Time: 1:14 PM
 */

class Mod_spare extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }

//==================== first load a list of parts ====================
    public function get_spare_parts_list(){

        $result = "";

        $this->db->select('spare_parts.*,mr.mf_id,mr.mf_name');
        $this->db->join('manufacture mr','spare_parts.sp_mnf=mr.mf_id','left');
        $this->db->where('spare_parts.sp_status',1);
        $this->db->order_by("spare_parts.sp_id", "desc");

        $query = $this->db->get('spare_parts');

        if ( $query->num_rows() > 0 ) {
            $result = $query->result();
        }

        return $result;
    }

    //=============== when search show this list ================
    public function get_serach_list($name,$code){


        $result = '';

        if (!empty($name)){
            $this->db->where('spare_parts.sp_name',$name);
        }
        if (!empty($code)){
            $this->db->where('spare_parts.sp_code',$code);
        }

        $this->db->select('spare_parts.*,mr.mf_id,mr.mf_name');
        $this->db->join('manufacture mr','spare_parts.sp_mnf=mr.mf_id','left');
        $this->db->where('spare_parts.sp_status',1);
        $this->db->order_by("spare_parts.sp_id", "desc");
        $query = $this->db->get('spare_parts');

        if ( $query->num_rows() > 0 ) {
            $result = $query->result();

            return $result;
        }


    }


    public function get_manufacture(){
        $result = "";
        $this->db->where('mf_status',1);
        $this->db->order_by("mf_id", "desc");
        $query = $this->db->get('manufacture');

        if ( $query->num_rows() > 0 ) {
            $result = $query->result();
        }

        return $result;
    }

    //============== parts info save ===============
    public function save_data($data){

        $this->db->insert('spare_parts', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    //================== get data for edit and update purpose ==============
    public function get_by_id($id)
    {
        $this->db->from('spare_parts');
        $this->db->where('sp_id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function update_data($where, $data){
        $this->db->update('spare_parts', $data, $where);
        return $this->db->affected_rows();
    }

    //============ delete data but not remove database just update status ==========
    public function delete_by_id($where, $data){
        $this->db->update('spare_parts', $data, $where);
        return $this->db->affected_rows();
    }


}