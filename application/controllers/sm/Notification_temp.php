<?php
/**
 * Created by PhpStorm.
 * User: Farjan
 * Date: 15/09/2022
 * Time: 12:22 PM
 */


/**
 * Class Notification Template
 * @property Mod_Notificationtemp $Mod_Notificationtemp
 */

class Notification_temp extends My_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_Notificationtemp', 'Mod_temp');
        $this->load->library('pagination');

        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }
    }


    public function index(){

        $data['template'] = $this->Mod_temp->get_temp_list();
        $this->load->view('sm/notify_template/index',$data);

    }

    public function search_list(){
        if ($_POST){
            $data['template']= $this->Mod_temp->get_search_list();
            $this->load->view('sm/notify_template/view_temp_search_list',$data);
        }
    }

    //============ click add button show form =============
    public function template_add(){
        $this->load->view('sm/notify_template/view_template_add', []);
    }

    public function save (){

        if ($_POST){

            $type        = $this->input->post('type');
            $slap        = $this->input->post('slap');
            $message     = $this->input->post('message');
            $status      = $this->input->post('status');
            $datetime    = date('Y-m-d H:i:s');

            $this->_validate();

            $data = array(
                'type'          => $type,
                'slap'          => $slap,
                'message'       => $message,
                'status'        => $status,
                'created_at'    => $datetime
            );

            $dbInsert =  $this->Mod_temp->save_data($data);

            if ($dbInsert){
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    //========== data edit by id show view form =============
    public function template_edit($id){
        $this->session->set_userdata('temp_update_id', $id);
        $data['template']= $this->Mod_temp->get_temp_list_by_id($id);
        $this->load->view('sm/notify_template/view_edit_template',$data);
    }

    //========== update data ==================
    public function temp_update(){


        if ($_POST){

            $type        = $this->input->post('type');
            $slap        = $this->input->post('slap');
            $message     = $this->input->post('message');
            $status      = $this->input->post('status');
            //$datetime    = date('Y-m-d H:i:s');

            $this->_validate();

            $data = array(
                'type'          => $type,
                'slap'          => $slap,
                'message'       => $message,
                'status'        => $status,
            );
            if ($this->session->has_userdata('temp_update_id')) {
                $this->Mod_temp->update_by_id($data, $this->session->userdata('temp_update_id'));
                $this->session->unset_userdata('temp_update_id');
                echo json_encode(array("status" => TRUE));
            } else {
                echo json_encode(array("status" => FALSE));
            }
        }


    }

    // =============== delete data ================
    public function delete($id){
        $this->Mod_temp->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('type') == '')
        {
            $data['inputerror'][] = 'type';
            $data['error_string'][] = 'Type is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('slap') == '')
        {
            $data['inputerror'][] = 'slap';
            $data['error_string'][] = 'Slap is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('message') == '')
        {
            $data['inputerror'][] = 'message';
            $data['error_string'][] = 'Message is required';
            $data['status'] = FALSE;
        }


        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }


}