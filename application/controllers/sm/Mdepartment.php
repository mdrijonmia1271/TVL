<?php


/**
 * Class Mdepartment
 * @property MedicalDep $MedicalDep
 * @property Mod_install $Mod_install
 */

class Mdepartment extends My_Controller
{
    private $record_per_page = 10;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/MedicalDep');
        $this->load->model('sm/Mod_install');
        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */

        if ($this->session->userdata('is_login') != true && ($this->session->userdata('root_admin') == "no" && $this->session->userdata('admin_user_type') != 'sm')) { //only supper admin can access
            redirect('sm/home');
        }
    }


    public function index()
    {
        $data['customer'] = $this->MedicalDep->get_customer_info();

        $this->load->view('sm/mdepartment/index', $data);
    }


    public function create()
    {
        $data['customer']   = $this->Mod_install->get_customer();
        $data['department'] = $this->MedicalDep->get_all();
        $this->load->view('sm/mdepartment/add', $data);
    }


    public function store()
    {

        if ($_POST) {

            $this->form_validation->set_rules('customer', 'Customer', 'required');
            $this->form_validation->set_rules('department', 'Department', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');

            if ($this->form_validation->run()) {

                $res_flag = $this->MedicalDep->save_dep_head();

                if (!empty($res_flag)) {
                    redirect('sm/mdepartment');
                }

            } else {
                $this->session->set_flashdata('flashError', 'Failed to create Customer');
                redirect('sm/mdepartment/create');
            }

        }
    }

    function edit()
    {
        $id                 = $this->uri->segment(4);
        $this->data['customer']   = $this->Mod_install->get_customer();
        $this->data['department'] = $this->MedicalDep->get_all();
        $this->data['edit'] = $this->MedicalDep->get_dep_head_by_id($id);
        $this->load->view('sm/mdepartment/edit', $this->data);
    }



    function update()
    {
        if ($_POST) {

            $hid_id = $this->security->xss_clean($this->input->post('hidden_dep_id'));

            $this->form_validation->set_rules('customer', 'Customer', 'required');
            $this->form_validation->set_rules('department', 'Department', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');

            if ($this->form_validation->run()) {

                $res_flag = $this->MedicalDep->update_dep_head($hid_id);

                if (!empty($res_flag)) {
                    $this->session->set_flashdata('flashOK', 'Department Updated Successfully');
                } else {
                    $this->session->set_flashdata('flashError', 'Failed to update Department');
                }
                redirect('sm/mdepartment');
            } else {
                $this->load->view('sm/mdepartment/edit', $this->data);
            }
        }

    }

    public function delete($id)
    {
        $res_flag = $this->MedicalDep->delete_dep_head_by_id($id);
        if (!empty($res_flag)) {
            $this->session->set_flashdata('flashOK', 'Department Delete Successfully');
        } else {
            $this->session->set_flashdata('flashError', 'Failed to Delete Department');
        }
        redirect('sm/mdepartment');
    }


}