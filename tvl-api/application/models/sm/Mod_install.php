<?php
/**
 * Created by PhpStorm.
 * User: Manjurul
 * Date: 5/12/2018
 * Time: 12:35 AM
 */

class Mod_install extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


//===================== retrieved customer ==================
    public function get_customer()
    {

        $this->db->select('customer_id,name');
        $this->db->from('customer');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }

    //===================== retrieved customer ==================
    public function get_engineer()
    {

        $query = $this->db->get('sm_service_engineer');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }

//============== retrieved machine info ==================
    public function get_machine()
    {


        $query = $this->db->get('machine');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }

//============== get all support type =================
    public function get_support_type()
    {

        $query = $this->db->get('sm_service_type');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }

//============== renew support except 3 item ==================
    public function renew_support_type()
    {
        $this->db->where_not_in('service_type_id', 3);

        $query = $this->db->get('sm_service_type');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }

//============== get business area ======================
    public function get_business_area()
    {
        $query = $this->db->get('business_area');

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }

    }

    //================= customer info show in list =================
    public function get_customer_info($id)
    {

        $this->db->select('customer.*,cpt.*, thana.THANA_NAME,dist.DISTRICT_NAME');
        $this->db->from('customer');
        $this->db->join('customer_contact_person_dtl cpt', 'cpt.ref_customer_id = customer.customer_id', 'left');

        $this->db->join('thanas thana', 'thana.THANA_ID = customer.contact_add_upazila', 'left');

        $this->db->join('districts dist', 'dist.DISTRICT_ID = customer.contact_add_district', 'left');

        $this->db->where('customer_id', $id);

        $query = $this->db->get();

        return $query->row();

    }

    //sfsdfdsf
    public function get_machine_info($id)
    {

        $this->db->select('machine.*,mr.mf_id,mr.mf_name');
        $this->db->join('manufacture mr', 'machine.mc_manufacture=mr.mf_id', 'left');
        $this->db->where('machine.mc_id', $id);
        $query = $this->db->get('machine');
        return $query->row();

    }


    public function save_install_base($data)
    {
        $this->db->insert('install_base', $data);
        return $this->db->insert_id();
    }


    public function save_insb_support_type($data)
    {
        $this->db->insert('cust_support_type', $data);
        return $this->db->insert_id();
    }

    public function save_insb_user_training($data)
    {
        $this->db->insert('user_traning_info', $data);
        return $this->db->insert_id();
    }

    //================= install base edit and update ========
    public function get_install_by_id($id)
    {

        $this->db->where('install_base.insb_id', $id);

        $query = $this->db->get('install_base');
        return $query->row();

    }

    public function get_customer_by_id($insb_id){

        $this->db->select('customer.*,cpt.*,thana.THANA_NAME,dist.DISTRICT_NAME');
        $this->db->join('customer', 'install_base.insb_customer = customer.customer_id', 'left');
        $this->db->join('customer_contact_person_dtl cpt', 'install_base.insb_customer = cpt.ref_customer_id', 'left');
        $this->db->join('thanas thana', 'thana.THANA_ID = customer.contact_add_upazila', 'left');
        $this->db->join('districts dist', 'dist.DISTRICT_ID = customer.contact_add_district', 'left');

        $this->db->where('install_base.insb_id', $insb_id);

        $query = $this->db->get('install_base');
        return $query->row();

    }

    public function get_equipment_by_id($insb_id){

        $this->db->select('machine.*,manufacture.*');
        $this->db->join('machine', 'install_base.insb_machine = machine.mc_id', 'left');
        $this->db->join('manufacture', 'machine.mc_manufacture = manufacture.mf_id', 'left');
        $this->db->where('install_base.insb_id', $insb_id);

        $query = $this->db->get('install_base');
        return $query->row();
    }

    public function get_su_type_by_id($insb_id){
        $this->db->select('su_type.*,cust_su_type.*');
        $this->db->join('cust_support_type cust_su_type', 'install_base.insb_id = cust_su_type.install_base_ref_id', 'left');
        $this->db->join('sm_service_type su_type', 'su_type.service_type_id= cust_su_type.su_type_id', 'left');

        $this->db->where('install_base.insb_id', $insb_id);
        $query = $this->db->get('install_base');
        return $query->row();
    }

    public function get_user_tr_by_id($insb_id){

        $this->db->select('user_traning_info.*');
        $this->db->join('user_traning_info', 'install_base.insb_id = user_traning_info.install_base_ref_id', 'left');
        $this->db->where('install_base.insb_id', $insb_id);
        $query = $this->db->get('install_base');
        return $query->result();
    }


    //============= update ===============
    public function update_install_data($where, $data){
        $this->db->update('install_base', $data, $where);
        return $this->db->affected_rows();
    }


    public function update_insb_support_type($where, $data){
        $this->db->update('cust_support_type', $data, $where);
        return $this->db->affected_rows();
    }


    public function delete_user_info($hidden_id){
        $this->db->where('install_base_ref_id', $hidden_id);
        $this->db->delete('user_traning_info');
    }


//============= list show =============
    public function install_base_list()
    {

        $engineer  = $this->input->post('engineer');
        $customer  = $this->input->post('customer');
        $equipment = $this->input->post('machine');
        $support   = $this->input->post('support_type');
        $start     = $this->input->post('stdate');
        $star_date = date('Y-m-d 00:00:00',strtotime($start));
        $end       = $this->input->post('endate');
        $end_date = date('Y-m-d 23:59:59',strtotime($end));



        if (!empty($engineer)){
            $this->db->where('install_base.ser_eng_ref_id', $engineer);

        }

        if (!empty($customer)){
            $this->db->where('install_base.insb_customer', $customer);
        }


        if (!empty($equipment)){
            $this->db->where('install_base.insb_machine', $equipment);

        }

        if (!empty($support)){
            $this->db->where('support.service_type_id', $support);
        }

        if (!empty($start)){
            $this->db->where('install_base.created', $star_date);
        }

        if (!empty($end)){
            $this->db->where('install_base.created', $end_date);
        }


        $this->db->select('install_base.*,customer.name customer,machine.mc_name,support.service_type_title,
                           su_type.su_start_date,su_type.su_end_date');

        $this->db->join('customer', 'install_base.insb_customer = customer.customer_id', 'left');
        $this->db->join('machine', 'install_base.insb_machine = machine.mc_id', 'left');
        $this->db->join('cust_support_type su_type', 'install_base.insb_id = su_type.install_base_ref_id', 'left');
        $this->db->join('sm_service_type support', 'support.service_type_id=su_type.su_type_id', 'left');

        //$this->db->where('install_base.ser_eng_ref_id', $eng_id);
        $this->db->order_by('install_base.insb_id', 'desc');
        $query = $this->db->get('install_base');
        return $query->result();

    }


//======================== for view ==================
    public function get_by_id($id)
    {

        $this->db->select('install_base.*,customer.name customer,machine.mc_name,support.service_type_title');

        $this->db->join('customer', 'customer.customer_id=install_base.insb_machine', 'left');
        $this->db->join('machine', 'machine.mc_id=install_base.insb_machine', 'left');
        $this->db->join('cust_support_type su_type', 'su_type.install_base_ref_id=install_base.insb_id', 'left');
        $this->db->join('sm_service_type support', 'support.service_type_id=su_type.su_type_id', 'left');

        $this->db->where('install_base.insb_id', $id);
        $this->db->order_by('install_base.insb_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('install_base');

        return $query->row();

    }

    //============ support type renew ==============
    public function update_data($where, $data)
    {
        $this->db->update('cust_support_type', $data, $where);
        return $this->db->affected_rows();
    }

    public function update_note($where, $data)
    {
        $this->db->update('install_base', $data, $where);
        return $this->db->affected_rows();
    }


    //============ Details of install base ==============

    public function get_install_base($id,$engneer_id){


        $this->db->select('install_base.*,business_area.bu_name');
        $this->db->join('business_area','install_base.insb_business_area = business_area.bu_id','left');
        $this->db->where('install_base.insb_id',$id);
        $this->db->where('install_base.ser_eng_ref_id',$engneer_id);
        $query = $this->db->get('install_base');

        return $query->row();
    }

    public function get_user_training($id){

        $this->db->where('install_base_ref_id',$id);
        $query = $this->db->get('user_traning_info');

        return $query->result();

    }

    public function get_customer_data($id,$engneer_id){

        $this->db->select('customer.*,ctd.*,districts.DISTRICT_NAME');
        $this->db->join('customer','install_base.insb_customer = customer.customer_id','left');
        $this->db->join('customer_contact_person_dtl ctd','customer.customer_id = ctd.ref_customer_id','left');
        $this->db->join('districts','customer.contact_add_district = districts.DISTRICT_ID','left');
        $this->db->where('install_base.insb_id',$id);
        $this->db->where('install_base.ser_eng_ref_id',$engneer_id);
        $query = $this->db->get('install_base');

        return $query->row();
    }


    public function get_equipment_data($id,$engneer_id){

        $this->db->select('machine.*,manufacture.mf_name,install_base.insb_serial');
        $this->db->join('machine','install_base.insb_machine = machine.mc_id','left');
        $this->db->join('manufacture','machine.mc_manufacture = manufacture.mf_id','left');
        $this->db->where('install_base.insb_id',$id);
        $this->db->where('install_base.ser_eng_ref_id',$engneer_id);
        $query = $this->db->get('install_base');

        return $query->row();
    }

    public function get_support_type_data($id,$engneer_id){

        $this->db->select('cust_support_type.*,sm_service_type.service_type_title');
        $this->db->join('cust_support_type','install_base.insb_id =  cust_support_type.install_base_ref_id	','left');
        $this->db->join('sm_service_type','cust_support_type.su_type_id = sm_service_type.service_type_id','left');
        $this->db->where('install_base.insb_id',$id);
        $this->db->where('install_base.ser_eng_ref_id',$engneer_id);
        $query = $this->db->get('install_base');

        return $query->row();
    }

}