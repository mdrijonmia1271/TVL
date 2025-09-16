<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/5/18
 * Time: 1:16 PM
 */


/**
 * Class Machine
 * @property Mod_machine $Mod_machine
 */

class Machine extends My_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_machine');
        $this->load->library('pagination');

        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }
    }


    public function index(){

        $data['machine'] = $this->Mod_machine->get_machine_list();
        $this->load->view('sm/machine/machine',$data);

    }

    public function search_list(){
        if ($_POST){

            $name   = $this->input->post('mcName');
            $model  = $this->input->post('model');

            $data['machine']= $this->Mod_machine->get_search_list($name,$model);

            $this->load->view('sm/machine/view_machine_search_list',$data);
        }
    }

    //============ click add button show form =============
    public function machine_add(){

        $data['manufacture'] = $this->Mod_machine->get_manufacture();
        $this->load->view('sm/machine/view_add_machine',$data);
    }

    //============== save form data into database ===========
    public function save (){

        if ($_POST){

            $mName       = $this->input->post('mName');
            $model       = $this->input->post('model');
            $manufacture = $this->input->post('mnf');
            $particular  = $this->input->post('mPart');
            $version     = $this->input->post('mVer');
            $st_con      = $this->input->post('stCon');
            $datetime    = date('Y-m-d H:i:s');

            $this->_validate();

            $data = array(
                'mc_name'       => $mName,
                'mc_model'      => $model,
                'mc_manufacture'=> $manufacture,
                'mc_particular' => $particular,
                'mc_version'    => $version,
                'mc_conf'       => $st_con,
                'mc_status'     => 1,
                'created'       => $datetime
            );

            $dbInsert =  $this->Mod_machine->save_data($data);

            if ($dbInsert){
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    //========== data edit by id show view form =============
    public function machine_edit($id){

        $data['manufacture'] = $this->Mod_machine->get_manufacture();
        $data['machine']= $this->Mod_machine->get_by_id($id);
        $this->load->view('sm/machine/view_edit_machine',$data);
    }

    //========== update data ==================
    public function machine_update(){


        if ($_POST){

            $id         = $this->input->post('id');
            $mName       = $this->input->post('mName');
            $model       = $this->input->post('model');
            $manufacture = $this->input->post('mnf');
            $particular  = $this->input->post('mPart');
            $version     = $this->input->post('mVer');
            $st_con      = $this->input->post('stCon');
            $datetime    = date('Y-m-d H:i:s');

            $this->_validate();

            $data = array(
                'mc_name'       => $mName,
                'mc_model'      => $model,
                'mc_manufacture'=> $manufacture,
                'mc_particular' => $particular,
                'mc_version'    => $version,
                'mc_conf'       => $st_con,
                'mc_status'     => 1,
                'created'       => $datetime
            );

            $this->Mod_machine->update_data(array('mc_id'=>$id),$data);
             echo json_encode(array("status" => TRUE));
        }


    }


    // =============== delete data ================
    public function machine_delete($id){

        $data['mc_status']= 0;
        $this->Mod_machine->delete_by_id(array('mc_id'=>$id),$data);
        echo json_encode(array("status" => TRUE));
    }



    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('mName') == '')
        {
            $data['inputerror'][] = 'mName';
            $data['error_string'][] = 'Equipment name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('model') == '')
        {
            $data['inputerror'][] = 'model';
            $data['error_string'][] = 'Equipment model is required';
            $data['status'] = FALSE;
        }

        /*if($this->input->post('mPart') == '')
        {
            $data['inputerror'][] = 'mPart';
            $data['error_string'][] = 'Equipment particular is required';
            $data['status'] = FALSE;
        }*/

        /*if($this->input->post('mVer') == '')
        {
            $data['inputerror'][] = 'mVer';
            $data['error_string'][] = 'Equipment Version is required';
            $data['status'] = FALSE;
        }*/

        if($this->input->post('mnf') == '')
        {
            $data['inputerror'][] = 'mnf';
            $data['error_string'][] = 'Equipment Manufacture is required';
            $data['status'] = FALSE;
        }


        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }







}