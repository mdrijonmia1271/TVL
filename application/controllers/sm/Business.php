<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/19/18
 * Time: 10:23 AM
 */


/**
 * Class Business
 * @property Mod_business $Mod_business
 */

class Business extends My_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_business');

        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }

    }

    public function index(){
        $data['business'] = $this->Mod_business->get_spare_parts_list();
        $this->load->view('sm/business/view_business_list',$data);
    }


    public function search_list(){
        if ($_POST){

            $name = $this->input->post('bu_area');
            $code = $this->input->post('bu_st');
            $data['business'] = $this->Mod_business->get_search_list($name,$code);

            $this->load->view('sm/business/view_business_search_list',$data);
        }
    }


    //============= button click show form ===============
    public function business_add(){
        $this->load->view('sm/business/view_add_business');
    }

    //================== save data =============

    public function save (){

        if ($_POST){

            $buName = $this->input->post('buArea');
            $buStatus = $this->input->post('bust');
            $datetime = date('Y-m-d H:i:s');

            $this->_validate();

            $data = array(
                'bu_name'   =>$buName,
                'bu_status' =>$buStatus,
                'created'   => $datetime
            );

            $dbInsert =  $this->Mod_business->save_data($data);

            if ($dbInsert){
                echo json_encode(array("status" => TRUE));
            }
        }
    }


//================= business edit =================
    public function business_edit($id){

        $data['business']= $this->Mod_business->get_by_id($id);
        $this->load->view('sm/business/view_edit_business',$data);
    }




    public function business_update (){

        if ($_POST){

            $id = $this->input->post('update_id');
            $buName = $this->input->post('buArea');
            $buStatus = $this->input->post('bust');
            $datetime = date('Y-m-d H:i:s');

            $this->_validate();

            $data = array(
                'bu_name'   =>$buName,
                'bu_status' =>$buStatus,
                'created'   => $datetime
            );

            $this->Mod_business->update_data(array('bu_id'=>$id),$data);
            echo json_encode(array("status" => TRUE));
        }
    }




    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('buArea') == '')
        {
            $data['inputerror'][] = 'buArea';
            $data['error_string'][] = 'Business Area is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('bust') == '')
        {
            $data['inputerror'][] = 'bust';
            $data['error_string'][] = 'Business Status is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}