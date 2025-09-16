<?php
/**
 * Created by PhpStorm.
 * User: BIGM
 * Date: 9/30/2018
 * Time: 5:17 PM
 * @property Mod_pmi $Mod_pmi
 * @property MedicalDep $MedicalDep
 */


class Pmi extends My_Controller
{
    private $record_per_page = 10;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_pmi');
        $this->load->model('sm/MedicalDep');
        $this->load->library('pagination');      /*  load pagination library */

        if ($this->session->userdata('is_login') != true && ($this->session->userdata('root_admin') == "no" && $this->session->userdata('admin_user_type') != 'sm')) { //only supper admin can access
            redirect('sm/home');
        }
    }


    public function index()
    {

        $data['customer']   = $this->Mod_pmi->get_customer();
        $data['department'] = $this->MedicalDep->get_all_status_wise();
        $this->load->view('sm/pmi/view_add_pmi', $data);
    }


    public function get_customer_info()
    {

        $cutomer_id = $this->input->post('customer');


        $arr = array('customer', 'machine');


        if (!empty($cutomer_id)) {

            $arr['customer'] = $this->Mod_pmi->get_customer_info($cutomer_id);
            $arr['machine']  = $this->Mod_pmi->get_machine_info($cutomer_id);

        }

        echo json_encode($arr);

    }

    public function get_machine_data()
    {
        $machine = $this->input->post('machine');

        if (!empty($machine)) {

            $result_explode = explode(',', $machine);

            $data['machine']    = $this->Mod_pmi->get_machine($result_explode[1]);
            $data['department'] = get_department_name_by_id($data['machine']->dep_ref_id);

            echo json_encode($data);
        }


    }

    public function pmi_save()
    {
        if ($_POST) {

            $this->_validate();
            $datetime   = date('Y-m-d H:i:s');
            $engineer   = $this->session->userdata('engineer_auto_id');
            $customer   = $this->security->xss_clean($this->input->post('customer'));
            $machine    = $this->security->xss_clean($this->input->post('machine'));
            $department = $this->security->xss_clean($this->input->post('dep_ref_id'));

            $result_explode = explode(',', $machine);

            $data = array(
                'insb_ref_id'    => $result_explode[0],
                'cust_ref_id'    => $customer,
                'dep_ref_id	' => $department,
                'eng_ref_id	' => $engineer,
                'mc_ref_id'      => $result_explode[1],
                'created'        => $datetime,
            );


            $insert = $this->Mod_pmi->save($data);

            if (!empty($_FILES['pmiReport']['name'])) {
                $upload = $this->_do_upload($insert);

                $data['pmi_report'] = $upload;
                $this->db->update('pmi_report', $data, array('id' => $insert));
            }

            echo json_encode(array("status" => TRUE));
        }
    }


    private function _do_upload($master_insert_id)
    {
        $structure = './upload/pmi/' . $master_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }

        $config['upload_path']   = $structure;
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
        $config['max_size']      = 2200;
        $config['file_name']     = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('pmiReport')) //upload and validate
        {
            $data['inputerror'][]   = 'pmiReport';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status']         = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }


    private function _validate()
    {
        $data                 = array();
        $data['error_string'] = array();
        $data['inputerror']   = array();
        $data['status']       = TRUE;

        if ($this->input->post('customer') == '') {
            $data['inputerror'][]   = 'customer';
            $data['error_string'][] = 'Please Select Customer';
            $data['status']         = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }


    //==============================================================

    public function pmi_list()
    {

        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }
        $data['pmi'] = $this->Mod_pmi->pmi_report_list($this->record_per_page, $row);

        $config['per_page']    = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/pmi/pmi_list/';
        $config['total_rows']  = $this->Mod_pmi->ticket_total_rows();
        $page_config           = get_pagination_paramter();

        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);

        $data['links']      = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['per_page']   = $config['per_page'];

        $this->load->view('sm/pmi/view_pmi_list', $data);

    }


}