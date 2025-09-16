<?php


class MedicalDep extends CI_Model
{

    protected $table = 'medical_department';

    public function get_all()
    {
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }


    public function get_all_status_wise()
    {
        $this->db->where('status',1);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }


    public function save()
    {
        $name     = $this->security->xss_clean($this->input->post('dep_name'));
        $status   = $this->security->xss_clean($this->input->post('status'));
        $datetime = date('Y-m-d H:i:s');

        $data_arry = array(
            'name'       => $name,
            'status'     => $status,
            'created_at' => $datetime,
        );

        $insert_db = $this->db->insert($this->table, $data_arry);

        if (!empty($insert_db)) {
            return $insert_db;
        } else {
            return false;
        }
    }


    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }


    function update($id)
    {
        $name     = $this->security->xss_clean($this->input->post('dep_name'));
        $status   = $this->security->xss_clean($this->input->post('status'));
        $datetime = date('Y-m-d H:i:s');

        $update_arry = array(
            'name'       => $name,
            'updated_at' => $datetime,
            'status'     => $status,
        );
        $this->db->where('id', $id);
        $this->db->update($this->table, $update_arry);

        return TRUE;
    }

    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }


    //======================= Department head added ========================


    public function get_customer_info()
    {

        $this->db->select('cus.name customer, dep.name department,head.id,head.name,head.email,head.phone');
        $this->db->join('customer cus', 'head.customer_id = cus.customer_id', 'left');
        $this->db->join('medical_department dep', 'head.department_id = dep.id', 'left');
        $this->db->order_by('head.id', 'desc');
        $query = $this->db->get('department_head head');

        return $query->result();

    }

    public function save_dep_head()
    {
        $customer   = $this->security->xss_clean($this->input->post('customer'));
        $department = $this->security->xss_clean($this->input->post('department'));
        $name       = $this->security->xss_clean($this->input->post('name'));
        $email      = $this->security->xss_clean($this->input->post('email'));
        $phone      = $this->security->xss_clean($this->input->post('phone'));
        $status     = $this->security->xss_clean($this->input->post('status'));

        $data_arry = array(
            'customer_id'   => $customer,
            'department_id' => $department,
            'name'          => $name,
            'email'         => $email,
            'phone'         => $phone,
            'status'        => $status,
        );

        $insert_db = $this->db->insert('department_head', $data_arry);

        if (!empty($insert_db)) {
            return $insert_db;
        } else {
            return false;
        }
    }


    public function get_dep_head_by_id($id)
    {
        $this->db->from('department_head');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }


    function update_dep_head($id)
    {
        $customer   = $this->security->xss_clean($this->input->post('customer'));
        $department = $this->security->xss_clean($this->input->post('department'));
        $name       = $this->security->xss_clean($this->input->post('name'));
        $email      = $this->security->xss_clean($this->input->post('email'));
        $phone      = $this->security->xss_clean($this->input->post('phone'));
        $status     = $this->security->xss_clean($this->input->post('status'));

        $data_arry = array(
            'customer_id'   => $customer,
            'department_id' => $department,
            'name'          => $name,
            'email'         => $email,
            'phone'         => $phone,
            'status'        => $status,
        );
        $this->db->where('id', $id);
        $this->db->update('department_head', $data_arry);

        return TRUE;
    }

    public function delete_dep_head_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('department_head');
    }

}