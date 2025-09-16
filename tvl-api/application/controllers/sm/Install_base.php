<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/9/18
 * Time: 11:56 AM
 */

/**
 * Class Install_base
 * @property Mod_install $Mod_install
 */
class Install_base extends My_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_install');

        if ($this->session->userdata('is_login') != true || $this->session->userdata('root_admin') == "no") { //only supper admin can access
            redirect('sm/home');
        }
    }


    public function index()
    {
        $data['customer'] = $this->Mod_install->get_customer();
        $data['machine'] = $this->Mod_install->get_machine();
        $data['support'] = $this->Mod_install->get_support_type();
        $data['business'] = $this->Mod_install->get_business_area();

        $this->load->view('sm/install/view_add_ins_base', $data);
    }


    public function get_install_data()
    {

        if ($_POST) {

            $cutomer_id = $this->input->post('customer');
            $machine = $this->input->post('machine');

            if (!empty($cutomer_id)) {

                $customer_info = $this->Mod_install->get_customer_info($cutomer_id);

                echo json_encode($customer_info);
            }

            if (!empty($machine)) {
                $machine_info = $this->Mod_install->get_machine_info($machine);
                echo json_encode($machine_info);
            }


        }


    }


    //============ save data install base info ============

    public function save()
    {

        if ($_POST) {


            $this->db->trans_start();


            $eng_id = $this->session->userdata('engineer_auto_id');

            $datetime = date('Y-m-d H:i:s');

            $customer_id = $this->input->post('customer');
            $machine_id = $this->input->post('machine');

            $install = $this->input->post('insDate');
            $install_date = date("Y-m-d", strtotime($install));

            $exp = $this->input->post('wExpire');
            $expire_date = date("Y-m-d", strtotime($exp));

            $work_order = $this->input->post('woDate');
            $work_date = date("Y-m-d", strtotime($work_order));
            //============= basic info ==============

            $this->_validate();

            $data = array(
                'insb_customer' => $customer_id,
                'ser_eng_ref_id' => $eng_id,
                'insb_business_area' => $this->input->post('bArea'),
                'support_type' => $this->input->post('supp_type'),
                'insb_sector' => $this->input->post('sector'),
                'insb_machine' => $machine_id,
                'insb_serial' => $this->input->post('mcSrial'),
                'insb_version' => $this->input->post('version'),
                'insb_work_order_contact' => $this->input->post('workCn'),
                'insb_work_order_date' => $work_date,
                'insb_install_by' => $this->input->post('insBy'),
                'insb_special_note' => $this->input->post('spNote'),
                'insb_install_date' => $install_date,
                'insb_warranty_date' => $expire_date,
                'status' => '1',
                'created' => $datetime
            );


            $install_base_id = $this->Mod_install->save_install_base($data);


            if (!empty($_FILES['insReport']['name']) && !empty($_FILES['accepCer']['name'])) {

                $insReport = $this->_do_upload($install_base_id);


                $upload_images['insb_report'] = $insReport;
                $upload_images['insb_acceptence_report'] = $insReport;

                $this->db->update('install_base', $upload_images, array('insb_id' => $install_base_id));
            }


            //================= support type ===================

            $support = $this->input->post('supp_type');

            $start = $this->input->post('support_start');

            $start_date = date("Y-m-d", strtotime($start));

            $end = $this->input->post('support_end');
            $end_date = date("Y-m-d", strtotime($end));

            if ($support == 1 || $support == 2) {

                $support_type = array(
                    'su_type_id' => $support,
                    'su_cust_ref_id' => $customer_id,
                    'su_machine_id' => $machine_id,
                    'install_base_ref_id' => $install_base_id,
                    'su_start_date' => $start_date,
                    'su_end_date' => $end_date,
                    'su_cycle' => $this->input->post('supp_cycle'),
                    'status' => '1',
                    'created' => $datetime
                );


            } elseif ($support == 3) {


                $support_type = array(
                    'su_type_id' => $support,
                    'su_cust_ref_id' => $customer_id,
                    'su_machine_id' => $machine_id,
                    'install_base_ref_id' => $install_base_id,
                    'su_start_date' => $install_date,
                    'su_end_date' => $expire_date,
                    'su_cycle' => $this->input->post('supp_cycle'),
                    'status' => '1',
                    'created' => $datetime
                );

            } elseif ($support == 4) {

                $support_type = array(
                    'su_type_id' => $support,
                    'su_cust_ref_id' => $customer_id,
                    'su_machine_id' => $machine_id,
                    'install_base_ref_id' => $install_base_id,
                    'status' => '1',
                    'created' => $datetime
                );

            }

            $this->Mod_install->save_insb_support_type($support_type);

            //=============== user training ================
            $user_name = $this->input->post('uName');
            $user_des = $this->input->post('uDes');
            $user_cell = $this->input->post('uCell');

            $i = 0;

            if (!empty($user_name)) {

                foreach ($user_name as $user) {

                    if (!empty($user_name[$i])) {

                        $user_data = array(
                            'cust_ref_id' => $customer_id,
                            'mc_ref_id' => $machine_id,
                            'install_base_ref_id' => $install_base_id,
                            'user_name' => $user_name[$i],
                            'user_designation' => $user_des[$i],
                            'user_cell_number' => $user_cell[$i]
                        );

                        $this->Mod_install->save_insb_user_training($user_data);
                    }
                    $i++;
                }

            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                echo json_encode(array('status' => false));

            } else {
                $this->db->trans_commit();
                echo json_encode(array('status' => true));
            }


        }


    }

//============== install base edit and update ====================================

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('customer') == '') {
            $data['inputerror'][] = 'customer';
            $data['error_string'][] = 'Client name is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('bArea') == '') {
            $data['inputerror'][] = 'bArea';
            $data['error_string'][] = 'Business area is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('sector') == '') {
            $data['inputerror'][] = 'sector';
            $data['error_string'][] = 'Sector is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('machine') == '') {
            $data['inputerror'][] = 'machine';
            $data['error_string'][] = 'Equipment/Item is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('mcSrial') == '') {
            $data['inputerror'][] = 'mcSrial';
            $data['error_string'][] = 'Serial Number is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('supp_type') == '') {
            $data['inputerror'][] = 'supp_type';
            $data['error_string'][] = 'Support type is required';
            $data['status'] = FALSE;
        }


        if ($this->input->post('workCn') == '') {
            $data['inputerror'][] = 'workCn';
            $data['error_string'][] = 'Please Type contract Number';
            $data['status'] = FALSE;
        }


        /*if ($this->input->post('woDate') == '') {
            $data['inputerror'][] = 'woDate';
            $data['error_string'][] = 'Work-order Date is required';
            $data['status'] = FALSE;
        }*/
        if ($this->input->post('insBy') == '') {
            $data['inputerror'][] = 'insBy';
            $data['error_string'][] = 'Install by is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('insDate') == '') {
            $data['inputerror'][] = 'insDate';
            $data['error_string'][] = 'Install Date is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('wExpire') == '') {
            $data['inputerror'][] = 'wExpire';
            $data['error_string'][] = 'Warranty Date is required';
            $data['status'] = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _do_upload($master_insert_id)
    {


        $structure = './upload/install_base/' . $master_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }


        $config['upload_path'] = $structure;
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
        $config['max_size'] = 2200;
        $config['encrypt_name'] = true;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);
        $this->load->initialize($config);

        if (!$this->upload->do_upload('insReport')) //upload and validate
        {
            $data['inputerror'][] = 'insReport';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }

        if (!$this->upload->do_upload('accepCer')) //upload and validate
        {
            $data['inputerror'][] = 'accepCer';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }


        return $this->upload->data('file_name');
    }

    public function get_by_id($id)
    {

        $data['customer'] = $this->Mod_install->get_customer();
        $data['machine'] = $this->Mod_install->get_machine();
        $data['support'] = $this->Mod_install->get_support_type();
        $data['business'] = $this->Mod_install->get_business_area();

        // edit data getting
        $data['install'] = $this->Mod_install->get_install_by_id($id);
        $data['cust'] = $this->Mod_install->get_customer_by_id($id);
        $data['equipment'] = $this->Mod_install->get_equipment_by_id($id);
        $data['su_type'] = $this->Mod_install->get_su_type_by_id($id);
        $data['user_tr'] = $this->Mod_install->get_user_tr_by_id($id);

        $this->load->view('sm/install/view_edit_ins_base', $data);
    }


    //================= install base list ==================

    public function update()
    {

        if ($_POST) {


            $this->db->trans_start();

            $hidden_id = $this->input->post('hidden_id');
            $eng_id = $this->session->userdata('engineer_auto_id');

            $datetime = date('Y-m-d H:i:s');

            $customer_id = $this->input->post('customer');
            $machine_id = $this->input->post('machine');

            $install = $this->input->post('insDate');
            $install_date = date("Y-m-d", strtotime($install));

            $exp = $this->input->post('wExpire');
            $expire_date = date("Y-m-d", strtotime($exp));

            $work_order = $this->input->post('woDate');
            $work_date = date("Y-m-d", strtotime($work_order));
            //============= basic info ==============

            $this->_validate();

            $data = array(
                'insb_customer' => $customer_id,
                'insb_business_area' => $this->input->post('bArea'),
                'support_type' => $this->input->post('supp_type'),
                'insb_sector' => $this->input->post('sector'),
                'insb_machine' => $machine_id,
                'insb_serial' => $this->input->post('mcSrial'),
                'insb_version' => $this->input->post('version'),
                'insb_work_order_contact' => $this->input->post('workCn'),
                'insb_work_order_date' => $work_date,
                'insb_install_by' => $this->input->post('insBy'),
                'insb_special_note' => $this->input->post('spNote'),
                'insb_install_date' => $install_date,
                'insb_warranty_date' => $expire_date,
                'status' => '1',
                'updated' => $datetime,
                'updated_by' => $eng_id
            );


            $this->Mod_install->update_install_data(array('insb_id' => $hidden_id), $data);


            if (!empty($_FILES['insReport']['name']) && !empty($_FILES['accepCer']['name'])) {

                $insReport = $this->_do_upload($hidden_id);

                $upload_images['insb_report'] = $insReport;
                $upload_images['insb_acceptence_report'] = $insReport;

                $this->db->update('install_base', $upload_images, array('insb_id' => $hidden_id));
            }


            //================= support type ===================

            $support = $this->input->post('supp_type');

            $start = $this->input->post('support_start');

            $start_date = date("Y-m-d", strtotime($start));

            $end = $this->input->post('support_end');
            $end_date = date("Y-m-d", strtotime($end));

            if ($support == 1 || $support == 2) {

                $support_type = array(
                    'su_type_id' => $support,
                    'su_cust_ref_id' => $customer_id,
                    'su_machine_id' => $machine_id,
                    'install_base_ref_id' => $hidden_id,
                    'su_start_date' => $start_date,
                    'su_end_date' => $end_date,
                    'su_cycle' => $this->input->post('supp_cycle'),
                    'status' => '1',
                    'created' => $datetime
                );


            } elseif ($support == 3) {


                $support_type = array(
                    'su_type_id' => $support,
                    'su_cust_ref_id' => $customer_id,
                    'su_machine_id' => $machine_id,
                    'install_base_ref_id' => $hidden_id,
                    'su_start_date' => $install_date,
                    'su_end_date' => $expire_date,
                    'su_cycle' => $this->input->post('supp_cycle'),
                    'status' => '1',
                    'created' => $datetime
                );

            } elseif ($support == 4) {

                $support_type = array(
                    'su_type_id' => $support,
                    'su_cust_ref_id' => $customer_id,
                    'su_machine_id' => $machine_id,
                    'install_base_ref_id' => $hidden_id,
                    'status' => '1',
                    'created' => $datetime
                );

            }

            $this->Mod_install->update_insb_support_type(array('install_base_ref_id' => $hidden_id), $support_type);

            //=============== user training ================

            $this->Mod_install->delete_user_info($hidden_id);

            $user_name = $this->input->post('uName');
            $user_des = $this->input->post('uDes');
            $user_cell = $this->input->post('uCell');

            $i = 0;

            if (!empty($user_name)) {

                foreach ($user_name as $user) {

                    if (!empty($user_name[$i])) {

                        $user_data = array(
                            'cust_ref_id' => $customer_id,
                            'mc_ref_id' => $machine_id,
                            'install_base_ref_id' => $hidden_id,
                            'user_name' => $user_name[$i],
                            'user_designation' => $user_des[$i],
                            'user_cell_number' => $user_cell[$i]
                        );

                        $this->Mod_install->save_insb_user_training($user_data);
                    }
                    $i++;
                }

            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                echo json_encode(array('status' => false));

            } else {
                $this->db->trans_commit();
                echo json_encode(array('status' => true));
            }

        }

    }


//============================= install base renew ===========================

    public function ins_list()
    {

        $data['customer'] = $this->Mod_install->get_customer();
        $data['engineer'] = $this->Mod_install->get_engineer();
        $data['machine'] = $this->Mod_install->get_machine();
        $data['support'] = $this->Mod_install->get_support_type();
        $data['install'] = $this->Mod_install->install_base_list();

        $this->load->view('sm/install/view_ins_base_list', $data);

    }

    public function renew_install($id)
    {

        $data['support'] = $this->Mod_install->renew_support_type();
        $data['install'] = $this->Mod_install->get_by_id($id);

        $this->load->view('sm/install/view_ins_base_renew', $data);
    }

    //============== install base details ===============

    public function renew()
    {

        if ($_POST) {

            $this->db->trans_start();

            $this->renew_validate();

            $datetime = date('Y-m-d H:i:s');
            $start = $this->input->post('support_start');
            $start_date = date("Y-m-d", strtotime($start));
            $end = $this->input->post('support_end');
            $end_date = date("Y-m-d", strtotime($end));

            $install_id = $this->input->post('ins_id');
            $support_type = $this->input->post('supp_type');
            $support_cycle = $this->input->post('supp_cycle');


            if ($support_type == 1 || $support_type == 2) {

                $data = array(
                    'su_type_id' => $support_type,
                    'su_cycle' => $support_cycle,
                    'su_start_date' => $start_date,
                    'su_end_date' => $end_date,
                    'updated' => $datetime
                );

            } elseif ($support_type == 4) {

                $data = array(
                    'su_type_id' => $support_type,
                    'updated' => $datetime
                );
            }


            $this->Mod_install->update_data(array('install_base_ref_id' => $install_id), $data);

            //============= update note ================
            $install = array(
                'insb_special_note' => $this->input->post('spNote'),
                'support_type' => $support_type,
            );

            $this->Mod_install->update_note(array('insb_id' => $install_id), $install);


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                echo json_encode(array('status' => false));

            } else {
                $this->db->trans_commit();
                echo json_encode(array('status' => true));
            }

        }
    }

    private function renew_validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;


        if ($this->input->post('supp_type') == '') {
            $data['inputerror'][] = 'supp_type';
            $data['error_string'][] = 'Support type is required';
            $data['status'] = FALSE;
        }


        if ($this->input->post('spNote') == '') {
            $data['inputerror'][] = 'spNote';
            $data['error_string'][] = 'Please Type a Note';
            $data['status'] = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    //============== list of install base =================

    public function details($id)
    {

        $engneer_id = $this->session->userdata('engineer_auto_id');

        $data['install'] = $this->Mod_install->get_install_base($id, $engneer_id);
        $data['user_training'] = $this->Mod_install->get_user_training($id);
        $data['customer'] = $this->Mod_install->get_customer_data($id, $engneer_id);
        $data['equipment'] = $this->Mod_install->get_equipment_data($id, $engneer_id);
        $data['support'] = $this->Mod_install->get_support_type_data($id, $engneer_id);

        $this->load->view('sm/install/view_ins_base_details', $data);
    }

//======================= renew validate ==============

    function download($filename = NULL)
    {
        // load download helder
        $this->load->helper('download');
        // read file contents
        $data = file_get_contents(base_url('/uploads/' . $filename));
        force_download($filename, $data);
    }


}