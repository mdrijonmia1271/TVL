<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/22/18
 * Time: 11:35 AM
 */

class Mod_manufacture extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    //============== manufacture list ==============
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


    //=============== when search show this list ================
    public function get_search_data($name,$sta){

        $result = '';

        if (!empty($name)){
            $this->db->where('mf_name',$name);
        }

        $this->db->where('mf_status',$sta);
        $this->db->order_by("mf_id", "desc");
        $query = $this->db->get('manufacture');

        if ( $query->num_rows() > 0 ) {
            $result = $query->result();

            return $result;
        }


    }


    //================ save data ===========
    public function data_save($data){

        $this->db->insert('manufacture', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    //=============== edit and update ========
    public function get_by_id($id)
    {
        $this->db->from('manufacture');
        $this->db->where('mf_id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function data_update($where, $data){
        $this->db->update('manufacture', $data, $where);
        return $this->db->affected_rows();
    }






}