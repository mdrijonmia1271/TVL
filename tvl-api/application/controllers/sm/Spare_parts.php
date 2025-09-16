<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/5/18
 * Time: 1:15 PM
 */


/**
 * Class Spare_parts
 * @property Mod_spare $Mod_spare
 */

class Spare_parts extends My_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_spare');

        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }
    }



    public function index(){
        $data['parts'] = $this->Mod_spare->get_spare_parts_list();
        $this->load->view('sm/spare/view_equ',$data);
    }


    public function search_list(){
        if ($_POST){

            $name = $this->input->post('spName');
            $code = $this->input->post('spCode');
            $data['parts'] = $this->Mod_spare->get_serach_list($name,$code);

            $this->load->view('sm/spare/view_equ_search_list',$data);
        }
    }


    public function spare_parts_add(){

        $data['manufacture'] = $this->Mod_spare->get_manufacture();

        $this->load->view('sm/spare/view_equ_add',$data);
    }


    public function save (){

        if ($_POST){

               $eqName = $this->input->post('eqName');
               $code = $this->input->post('Pcode');
               $manufacture = $this->input->post('mnf');
               $datetime = date('Y-m-d H:i:s');

               $this->_validate();

               $data = array(
                   'sp_name'   =>$eqName,
                   'sp_code'   =>$code,
                   'sp_mnf'    =>$manufacture,
                   'sp_status' => 1,
                   'created'   => $datetime
               );

               $dbInsert =  $this->Mod_spare->save_data($data);

            if ($dbInsert){
                echo json_encode(array("status" => TRUE));
            }
        }
    }


    public function sp_edit($id){

        $data['parts']= $this->Mod_spare->get_by_id($id);
        $data['manufacture'] = $this->Mod_spare->get_manufacture();
        $this->load->view('sm/spare/view_equ_edit',$data);
    }



    public function sp_update(){
        if ($_POST){

            $id = $this->input->post('update_id');
            $eqName = $this->input->post('eqName');
            $code = $this->input->post('Pcode');
            $manufacture = $this->input->post('mnf');
            $datetime = date('Y-m-d H:i:s');

            $this->_validate();

            $data = array(
                'sp_name'   =>$eqName,
                'sp_code'   =>$code,
                'sp_mnf'    =>$manufacture,
                'sp_status' => 1,
                'created'   => $datetime
            );

            $this->Mod_spare->update_data(array('sp_id'=>$id),$data);

            echo json_encode(array("status" => TRUE));
        }
    }


    public function sp_delete($id){

        $data['sp_status']= 0;
        $this->Mod_spare->delete_by_id(array('sp_id'=>$id),$data);
        echo json_encode(array("status" => TRUE));
    }



    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('eqName') == '')
        {
            $data['inputerror'][] = 'eqName';
            $data['error_string'][] = 'Spare parts name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('mnf') == '')
        {
            $data['inputerror'][] = 'mnf';
            $data['error_string'][] = 'Manufactured is required';
            $data['status'] = FALSE;
        }


        if($this->input->post('Pcode') == '')
        {
            $data['inputerror'][] = 'Pcode';
            $data['error_string'][] = 'Parts number is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }




}