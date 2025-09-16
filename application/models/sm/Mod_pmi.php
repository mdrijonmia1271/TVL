<?php
/**
 * Created by PhpStorm.
 * User: BIGM
 * Date: 9/30/2018
 * Time: 5:53 PM
 */

class Mod_pmi extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_customer()
    {

        $this->db->select('customer_id,name');
        $this->db->from('customer');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }
        return false;
    }


    public function get_customer_info($id)
    {

        $this->db->select('customer.*,cpt.*, thana.THANA_NAME,dist.DISTRICT_NAME');
        $this->db->join('customer_contact_person_dtl cpt', 'cpt.ref_customer_id = customer.customer_id', 'left');
        $this->db->join('thanas thana', 'thana.THANA_ID = customer.contact_add_upazila', 'left');
        $this->db->join('districts dist', 'dist.DISTRICT_ID = customer.contact_add_district', 'left');
        $this->db->where('customer_id', $id);
        $query = $this->db->get('customer');

        return $query->row();

    }


    public function get_machine_info($id)
    {
        $this->db->select('machine.*,insb.insb_id,insb.insb_serial,insb.dep_ref_id');
        $this->db->join('install_base insb', 'machine.mc_id = insb.insb_machine', 'left');
        $this->db->where('insb.insb_customer', $id);
        $query = $this->db->get('machine');

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }

    public function get_machine($id)
    {
        $this->db->select('machine.*,mr.mf_id,mr.mf_name,ins.dep_ref_id');
        $this->db->join('manufacture mr', 'machine.mc_manufacture = mr.mf_id', 'left');
        $this->db->join('install_base ins', 'ins.insb_machine = machine.mc_id', 'left');
        $this->db->where('machine.mc_id', $id);
        $query = $this->db->get('machine');
        return $query->row();

    }

    public function save($data)
    {
        $this->db->insert('pmi_report', $data);
        return $this->db->insert_id();
    }

    public function pmi_report_list($limit, $row)
    {


        $engineer = $this->session->userdata('engineer_auto_id');

        if (!empty($engineer)) {
            $this->db->where('pmi_report.eng_ref_id', $engineer);
        }

        $this->db->select('install_base.*,customer.name customer,machine.mc_name,machine.mc_model,
                           pmi_report.id,pmi_report.pmi_report,pmi_report.created,
                           sm_service_engineer.name engineer,dep.name department');

        $this->db->join('customer', 'pmi_report.cust_ref_id = customer.customer_id', 'left');
        $this->db->join('machine', 'pmi_report.mc_ref_id = machine.mc_id', 'left');
        $this->db->join('medical_department dep', 'pmi_report.dep_ref_id = dep.id', 'left');
        $this->db->join('sm_service_engineer', 'pmi_report.eng_ref_id = sm_service_engineer.ser_eng_id', 'left');
        $this->db->join('install_base', 'pmi_report.insb_ref_id = install_base.insb_id', 'left');


        $this->db->order_by('customer.name', 'asc');
        $query = $this->db->get('pmi_report', $limit, $row);

        //print_r($this->db->last_query()); exit();
        return $query->result();
    }


    public function ticket_total_rows()
    {

        $engineer = $this->session->userdata('engineer_auto_id');

        if (!empty($engineer)) {
            $this->db->where('pmi_report.eng_ref_id', $engineer);
        }

        $this->db->select('install_base.*,customer.name customer,machine.mc_name,machine.mc_model,
                           pmi_report.id,pmi_report.pmi_report,pmi_report.created,
                           sm_service_engineer.name engineer');

        $this->db->join('customer', 'pmi_report.cust_ref_id = customer.customer_id', 'left');
        $this->db->join('machine', 'pmi_report.mc_ref_id = machine.mc_id', 'left');
        $this->db->join('sm_service_engineer', 'pmi_report.eng_ref_id = sm_service_engineer.ser_eng_id', 'left');
        $this->db->join('install_base', 'pmi_report.insb_ref_id = install_base.insb_id', 'left');

        $this->db->order_by('customer.name', 'asc');
        $query = $this->db->get('pmi_report');

        //print_r($this->db->last_query()); exit();
        return $query->num_rows();
    }

}