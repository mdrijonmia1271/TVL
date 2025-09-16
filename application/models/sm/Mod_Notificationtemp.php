<?php
/**
 * Created by PhpStorm.
 * User: Farjan
 * Date: 15/09/2022
 * Time: 12:22 PM
 */

class Mod_Notificationtemp extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_temp_list(){
        $this->db->select("*");
        //$this->db->where("status", "1");
        $this->db->order_by("id", "asc");
        $query = $this->db->get("message_template");

        if ( $query->num_rows()) {
            return $query->result();
        }

        return false;
    }

    public function get_search_list(){
        $this->db->select("*");
        $this->db->order_by("id", "asc");
        if (!empty($this->input->post('type'))) {
            $this->db->where('type', $this->input->post('type'));
        }
        if (!empty($this->input->post('slap'))) {
            $this->db->like('slap', $this->input->post('slap'));
        }
        $query = $this->db->get("message_template");

        if ( $query->num_rows()) {
            return $query->result();
        }

        return false;
    }

    public function get_temp_list_by_id($id){
        $this->db->select("*");
        $this->db->where("id", $id);
        return $this->db->get("message_template")->row();
    }

    public function update_by_id($data, $id){
        return $this->db->update("message_template", $data, ['id' => $id]);
    }

    public function update($data, $wh){
        return $this->db->update("message_template", $data, $wh);
    }

    public function save_data($data){
        $this->db->insert("message_template", $data);
        return $this->db->insert_id();
    }

    public function delete_by_id($id){
        return $this->db->delete("message_template", ['id' => $id]);
    }

}