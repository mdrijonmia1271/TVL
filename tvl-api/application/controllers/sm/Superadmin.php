<?php

/**
 * Description of superadmin
 *
 * @author Mhabub
 * @property Mod_superadmin $Mod_superadmin
 */
class Superadmin extends CI_Controller {

    private $record_per_page = 20;
    private $record_num_links = 5;
    private $data = '';

    public function __construct() {
        parent::__construct();

        $this->load->model('sm/Mod_superadmin');
        $this->load->model('sm/Mod_common');

        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */

        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }
    }

    /*  Start Superadmin */

    function superadmininsert() {

        $this->data['record'] = $this->Mod_superadmin->get_superadmin_list();

        $this->load->view('sm/superadmin/view_add_superadmin', $this->data);
    }

    function index() {

        $this->data['record'] = $this->Mod_superadmin->get_superadmin_list();

        $this->load->view('sm/superadmin/view_add_superadmin', $this->data);
    }

    function save_superadmin() {

        $this->form_validation->set_rules('superadmin_name', 'User Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_superadmin->save_data_superadmin();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'User added successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to create user');
            }
            redirect('sm/superadmin/superadmininsert');
        } else {
            $this->load->view('sm/superadmin/view_add_superadmin', $this->data);
        }
    }

    function edit_superadmin() {
        $this->data['record'] = $this->Mod_superadmin->get_superadmin_list();
        $id = $this->uri->segment(4);
        $this->data['edit'] = $this->Mod_superadmin->edit_superadmin($id);
        if (!empty($this->data['edit'])) {
            $this->load->view('sm/superadmin/view_edit_superadmin', $this->data);
        } else {
            redirect('sm/superadmin');
        }
    }

    function update_superadmin() {

        $hid_id = $this->security->xss_clean($this->input->post('hidden_superadmin_id'));

        $this->form_validation->set_rules('superadmin_name', 'Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_superadmin->modify_data_superadmin();


            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'User Edited successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to Edit User');
            }
            redirect('sm/superadmin/superadmininsert');
        } else {
            $this->load->view('sm/superadmin/view_edit_superadmin', $this->data);
        }
    }

    /*  Start Assign Superadmin */

    function edit_superadmin_customer() {
        $this->data['record'] = $this->Mod_superadmin->get_superadmin_customer_list();
        $id = $this->uri->segment(4);
        $this->data['edit'] = $this->Mod_superadmin->edit_superadmin($id);
        $this->load->view('sm/superadmin/view_edit_superadmin_customer', $this->data);
    }


}
