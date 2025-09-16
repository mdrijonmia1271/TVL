<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/6/18
 * Time: 5:30 PM
 */

class Mod_machine extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }



    public function get_machine_list(){

        $result = "";
        $this->db->select('machine.*,mr.mf_id,mr.mf_name');
        $this->db->join('manufacture mr','machine.mc_manufacture=mr.mf_id','left');
        $this->db->where('machine.mc_status',1);
        $this->db->order_by("machine.mc_id", "desc");
        $query = $this->db->get('machine');

        if ( $query->num_rows() > 0 ) {
            $result = $query->result();
        }

        return $result;
    }

    public function get_search_list($name,$model){

        $result = "";

        if (!empty($name)){
            $this->db->where('mc_name',$name);
        }

        if (!empty($model)){
            $this->db->where('mc_model',$model);
        }

        $this->db->select('machine.*,mr.mf_id,mr.mf_name');
        $this->db->join('manufacture mr','machine.mc_manufacture=mr.mf_id','left');

        $this->db->where('machine.mc_status',1);
        $this->db->order_by("machine.mc_id", "desc");
        $query = $this->db->get('machine');

        if ( $query->num_rows() > 0 ) {
            $result = $query->result();
        }

        return $result;

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


    public function save_data($data){

        $this->db->insert('machine', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }


    public function get_by_id($id)
    {
        $this->db->from('machine');
        $this->db->where('mc_id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function update_data($where, $data){
        $this->db->update('machine', $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($where, $data){
        $this->db->update('machine', $data, $where);
        return $this->db->affected_rows();
    }


}