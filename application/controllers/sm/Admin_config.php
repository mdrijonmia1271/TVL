<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin_config
 *
 * @author Mhabub
 * @property Mod_admin_config $Mod_admin_config
 * @property Mod_common $Mod_common
 * @property MedicalDep $MedicalDep
 */
class Admin_config extends CI_Controller
{

    private $record_per_page  = 20;
    private $record_num_links = 5;


    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_admin_config');
        $this->load->model('sm/Mod_common');
        $this->load->model('sm/MedicalDep');

        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */

        if ($this->session->userdata('is_login') != true || $this->session->userdata('root_admin') == "no") { //only supper admin can access
            redirect('sm/home');
        }

        $this->data['cust_name'] = $this->Mod_admin_config->get_customer_name();
    }

    /*  Start Service Priority */

    function index()
    {
        $this->data['record'] = $this->Mod_admin_config->get_priority_list();
        $this->load->view('sm/admin/config/view_add_service_priority', $this->data);
    }

    function save_priority()
    {

        $this->form_validation->set_rules('priority_name', 'Service Priority Name', 'required');
        $this->form_validation->set_rules('color_code', 'Color Code', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_admin_config->save_data_priority();


            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Service Priority addded successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to create Service Priority');
            }
            redirect('sm/admin_config/index');
        } else {
            $this->load->view('sm/admin/config/view_add_service_priority', $this->data);
        }
    }

    function edit_priority()
    {
        $this->data['record'] = $this->Mod_admin_config->get_priority_list();
        $id                   = $this->uri->segment(4);

        $this->data['edit'] = $this->Mod_admin_config->edit_priority($id);
        $this->load->view('sm/admin/config/view_edit_service_priority', $this->data);
    }

    function update_priority()
    {
        $hid_id = $this->security->xss_clean($this->input->post('hidden_priority_id'));

        $this->form_validation->set_rules('priority_name', 'Service Priority Name', 'required');
        $this->form_validation->set_rules('color_code', 'Color Code', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_admin_config->modify_data_priority();


            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Service Priority Edited successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to Edit Service Priority');
            }
            redirect('sm/admin_config/index');
        } else {
            $this->load->view('sm/admin/config/view_edit_service_priority', $this->data);
        }
    }

    /*  ============END Service Priority ======================== */


    /*  ============Start Service Task ======================== */

    function add_task()
    {
        $this->data['cust_name'] = $this->Mod_admin_config->get_customer_name();
        $this->data['record']    = $this->Mod_admin_config->get_task_list();
        $this->load->view('sm/admin/config/view_add_task', $this->data);
    }

    function save_task()
    {
        $this->data['cust_name'] = $this->Mod_admin_config->get_customer_name();

        $this->form_validation->set_rules('cust_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('task_name', 'Task Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_admin_config->save_data_task();


            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Task addded successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to create Task');
            }
            redirect('sm/admin_config/add_task');
        } else {
            $this->load->view('sm/admin/config/view_add_task', $this->data);
        }
    }

    function edit_task()
    {
        $this->data['cust_name'] = $this->Mod_admin_config->get_customer_name();
        $this->data['record']    = $this->Mod_admin_config->get_task_list();

        $id = $this->uri->segment(4);

        $this->data['edit'] = $this->Mod_admin_config->edit_task($id);
        $this->load->view('sm/admin/config/view_edit_task', $this->data);
    }

    function update_task()
    {
        $this->data['cust_name'] = $this->Mod_admin_config->get_customer_name();
        $hid_id                  = $this->security->xss_clean($this->input->post('hidden_task_id'));

        $this->form_validation->set_rules('cust_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('task_name', 'Task Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_admin_config->modify_data_task();


            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Task Edited Successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to Edit Task');
            }
            redirect('sm/admin_config/add_task');
        } else {
            $this->load->view('sm/admin/config/view_edit_task', $this->data);
        }
    }

    /*  ============+++++++++END Service Task ======================== */

    function service_type()
    {

        $this->data['record'] = $this->Mod_admin_config->get_service_type_list();

        $this->load->view('sm/admin/config/view_add_service_type', $this->data);
    }

    function save_service_type()
    {

        //$this->form_validation->set_rules('cust_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('service_type_name', 'Task Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_admin_config->save_data_service_type();


            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Service Type addded successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to create Service Type');
            }
            redirect('sm/admin_config/service_type');
        } else {
            $this->load->view('sm/admin_config/view_add_service_type', $this->data);
        }
    }

    function edit_service_type()
    {
        $this->data['record'] = $this->Mod_admin_config->get_service_type_list();
        $id                   = $this->uri->segment(4);
        $this->data['edit']   = $this->Mod_admin_config->edit_service_type($id);
        $this->load->view('sm/admin/config/view_edit_service_type', $this->data);
    }

    function update_service_type()
    {

        $hid_id = $this->security->xss_clean($this->input->post('hidden_service_type_name'));

        $this->form_validation->set_rules('cust_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('service_type_name', 'Task Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run()) {
            $res_flag = $this->Mod_admin_config->modify_data_service_type();


            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Service Type Edited successfully');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to Edit Service Type');
            }
            redirect('sm/admin_config/service_type');
        } else {
            $this->load->view('sm/admin_config/view_edit_service_type', $this->data);
        }
    }


    // -----------------------  normal department -------------------
    public function department()
    {
        $this->data['record'] = $this->Mod_admin_config->get_department_list();
        $this->load->view('sm/admin/config/view_add_department', $this->data);
    }


    public function create_department()
    {

        if ($_POST) {

            $this->form_validation->set_rules('dep_name', 'Department', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run()) {
                $res_flag = $this->Mod_admin_config->save_department();


                if (!empty($res_flag)) {
                    $this->session->set_flashdata('flashOK', 'Department added Successfully');
                } else {
                    $this->session->set_flashdata('flashError', 'Failed to create Department');
                }
                redirect('sm/admin_config/department');
            } else {
                $this->load->view('sm/admin/config/view_add_department', $this->data);
            }

        }

    }


    function edit_department()
    {

        $id                 = $this->uri->segment(4);
        $this->data['edit'] = $this->Mod_admin_config->edit_departments($id);
        $this->load->view('sm/admin/config/view_edit_department', $this->data);
    }


    function update_department()
    {
        if ($_POST) {

            $hid_id = $this->security->xss_clean($this->input->post('hidden_dep_id'));

            $this->form_validation->set_rules('dep_name', 'Department', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run()) {
                $res_flag = $this->Mod_admin_config->update_departments($hid_id);


                if (!empty($res_flag)) {
                    $this->session->set_flashdata('flashOK', 'Department Updated Successfully');
                } else {
                    $this->session->set_flashdata('flashError', 'Failed to update Department');
                }
                redirect('sm/admin_config/department');
            } else {
                $this->load->view('sm/admin/config/view_edit_department', $this->data);
            }
        }


    }
//---------------------------- end department ------------------------------


// --------------------------------- normal designation ---------------------------
    public function designation()
    {
        $this->data['record'] = $this->Mod_admin_config->get_designation_list();
        $this->load->view('sm/admin/config/view_add_designation', $this->data);

    }


    public function create_designation()
    {

        if ($_POST) {

            $this->form_validation->set_rules('deg_name', 'Designation', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run()) {
                $res_flag = $this->Mod_admin_config->save_designation();


                if (!empty($res_flag)) {
                    $this->session->set_flashdata('flashOK', 'Designation added Successfully');
                } else {
                    $this->session->set_flashdata('flashError', 'Failed to create Designation');
                }
                redirect('sm/admin_config/designation');
            } else {
                $this->load->view('sm/admin/config/view_add_designation', $this->data);
            }

        }

    }


    function edit_designation()
    {

        $id                 = $this->uri->segment(4);
        $this->data['edit'] = $this->Mod_admin_config->edit_designations($id);
        $this->load->view('sm/admin/config/view_edit_designation', $this->data);
    }


    function update_designation()
    {
        if ($_POST) {

            $hid_id = $this->security->xss_clean($this->input->post('hidden_dep_id'));

            $this->form_validation->set_rules('deg_name', 'Designation', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run()) {
                $res_flag = $this->Mod_admin_config->update_designations($hid_id);


                if (!empty($res_flag)) {
                    $this->session->set_flashdata('flashOK', 'Designation Updated Successfully');
                } else {
                    $this->session->set_flashdata('flashError', 'Failed to update Designation');
                }
                redirect('sm/admin_config/designation');
            } else {
                $this->load->view('sm/admin/config/view_edit_designation', $this->data);
            }
        }


    }


    //========================================= Medical Department =====================================

    public function medical_dep()
    {
        $this->data['department'] = $this->MedicalDep->get_all();
        $this->load->view('sm/admin/config/medical_dep/index', $this->data);
    }


    public function store()
    {

        if ($_POST) {

            $this->form_validation->set_rules('dep_name', 'Department', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run()) {

                $res_flag = $this->MedicalDep->save();

                if (!empty($res_flag)) {
                    $this->session->set_flashdata('flashOK', 'Department added Successfully');
                } else {
                    $this->session->set_flashdata('flashError', 'Failed to create Department');
                }
                redirect('sm/admin_config/medical_dep');
            } else {
                redirect('sm/admin_config/medical_dep');
            }

        }
    }

    function edit()
    {
        $id                 = $this->uri->segment(4);
        $this->data['edit'] = $this->MedicalDep->get_by_id($id);
        $this->load->view('sm/admin/config/medical_dep/edit', $this->data);
    }


    function update()
    {
        if ($_POST) {

            $hid_id = $this->security->xss_clean($this->input->post('hidden_dep_id'));

            $this->form_validation->set_rules('dep_name', 'Department', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run()) {

                $res_flag = $this->MedicalDep->update($hid_id);

                if (!empty($res_flag)) {
                    $this->session->set_flashdata('flashOK', 'Department Updated Successfully');
                } else {
                    $this->session->set_flashdata('flashError', 'Failed to update Department');
                }
                redirect('sm/admin_config/medical_dep');
            } else {
                $this->load->view('sm/admin/config/medical_dep/edit', $this->data);
            }
        }

    }

    public function delete($id)
    {
        $res_flag = $this->MedicalDep->delete_by_id($id);
        if (!empty($res_flag)) {
            $this->session->set_flashdata('flashOK', 'Department Delete Successfully');
        } else {
            $this->session->set_flashdata('flashError', 'Failed to Delete Department');
        }
        redirect('sm/admin_config/medical_dep');
    }



}
