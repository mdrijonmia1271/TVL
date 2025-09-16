<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/22/18
 * Time: 11:34 AM
 */


/**
 * Class Manufacture
 * @property Mod_manufacture $Mod_manufacture
 */

class Manufacture extends My_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_manufacture');
    }




    public function index(){

        $data['manufacture'] = $this->Mod_manufacture->get_manufacture();
        $this->load->view('sm/manufacture/view_list_manufacture',$data);
    }


    //================== manufacture list ===============

    public function manu_list(){
        if ($_POST){

            $name = $this->input->post('mfName');
            $sta = $this->input->post('mfStatus');

            $data['manufacture'] = $this->Mod_manufacture->get_search_data($name,$sta);

            $this->load->view('sm/manufacture/view_list_search',$data);
        }
    }

    //======================= manufacture add ================

    public function add_manufac(){

        $this->load->view('sm/manufacture/view_add_manufacture');
    }

    public function save_data(){

        if ($_POST){

            $datetime = date('Y-m-d H:i:s');

            $this->_validate();

            $data=array(
                'mf_name'  => $this->input->post('mrName'),
                'mf_status'=> $this->input->post('mrSt'),
                'created'  =>$datetime
            );


            $this->Mod_manufacture->data_save($data);

            echo json_encode(array("status" => TRUE));
        }

    }

    //====================== manufacture edit and update =======
    public function edit_data($id){

        $data['edit']= $this->Mod_manufacture->get_by_id($id);
        $this->load->view('sm/manufacture/view_edit_manufacture',$data);
    }


    public function update_data(){


        if ($_POST){

            $datetime = date('Y-m-d H:i:s');

            $id = $this->input->post('mf_id');

            $this->_validate();

            $data=array(
                'mf_name'  => $this->input->post('mrName'),
                'mf_status'=> $this->input->post('mrSt'),
                'created'  =>$datetime
            );


            $this->Mod_manufacture->data_update(array('mf_id'=>$id),$data);

            echo json_encode(array("status" => TRUE));
        }


    }



    //================= validation ============
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('mrName') == '')
        {
            $data['inputerror'][] = 'mrName';
            $data['error_string'][] = 'Manufacturer name is required';
            $data['status'] = FALSE;
        }


        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }



}