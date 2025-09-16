<?php
/**
 * Created by PhpStorm.
 * User: Manjurul
 * Date: 5/13/2018
 * Time: 12:15 AM
 */


/**
 * Class Cust_sign
 * @property Mod_sign_up $Mod_sign_up
 */
class Cust_sign extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('sm/Mod_sign_up');
        $this->load->model('sm/Mod_common');
    }


    public function index()
    {

        $data['division_list'] = $this->Mod_common->get_division_list();
        $this->load->view('sm/sign_up/view_sign_up', $data);
    }


    public function save()
    {

        if ($_POST) {

            $this->_validate();

            $datetime = date('Y-m-d H:i:s');

            //======= customer basic info ========
            $cName = $this->input->post('cName');
            $cEmail = $this->input->post('cEmail');
            $cMobile = $this->input->post('cMobile');
            $tel = $this->input->post('cTel');
            $password = $this->input->post('cPass');
            $confirm = $this->input->post('confirm');

            //======== customer address info ======
            $cFlat = $this->input->post('cFlat');
            $cRoad = $this->input->post('cRoad');
            $cPost = $this->input->post('cPost');
            $cPCode = $this->input->post('cPCode');
            $cDiv = $this->input->post('contact_add_division');
            $cDist = $this->input->post('contact_add_district');
            $cThana = $this->input->post('contact_add_upazila');

            //======== contact person info ========
            $pName = $this->input->post('pName');
            $pDes = $this->input->post('pDes');
            $pEmail = $this->input->post('pEmail');
            $pMobile = $this->input->post('pMobile');


            $mobile_exist = $this->Mod_sign_up->check_mobile($cMobile);


            if ($mobile_exist == 1) {

                $data['inputerror'][] = 'cMobile';
                $data['error_string'][] = 'Mobile Number Already Exist';
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            }

            elseif ($password != $confirm){
                $data['inputerror'][] = 'confirm';
                $data['error_string'][] = 'Password Do Not Match';
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            }

            else {

                $data = array(
                    'name'                  => $cName,
                    'password'              => $confirm,
                    'email'                 => $cEmail,
                    'mobile'                => $cMobile,
                    'telephone_no'          => $tel,
                    'contact_add_division'  => $cDiv,
                    'contact_add_district'  => $cDist,
                    'contact_add_upazila'   => $cThana,
                    'cust_flat'             => $cFlat,
                    'cust_road'             => $cRoad,
                    'cust_post'             => $cPost,
                    'cust_post_code'        => $cPCode,
                    'status'                => 'I',
                    'created_date_time'     => $datetime,
                    'login_token_id'        => rend_string(10)
                );




                $insert_id = $this->Mod_sign_up->save_data($data);

                if ($insert_id) {

                    $contact_person = array(
                        'ref_customer_id' => $insert_id,
                        'contact_person_name' => $pName,
                        'contact_person_desig' => $pDes,
                        'contact_person_email' => $pEmail,
                        'contact_person_phone' => $pMobile,
                        'status' => 'A'
                    );

                    $this->Mod_sign_up->save_contact_person($contact_person);
                }


                if ($insert_id) {

                    if (!empty($_FILES['cPhoto']['name'])) {

                        $temp_file_name = $_FILES['cPhoto']['name'];
                        $temp = explode('.', $temp_file_name);
                        $my_real_file_name = $temp[0];


                        $upload = $this->_do_upload($insert_id, $my_real_file_name);
                        $upload_images['picture'] = $upload;

                        $this->db->update('customer', $upload_images, array('customer_id' => $insert_id));
                    }
                }


            }

            echo json_encode(array("status" => TRUE));
        }

    }



    function ajax_get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url = base_url() . 'sm/cust_sign/';
        $options = $this->Mod_common->get_disrict_list_by_div($division_id, $url);
        echo $options;
    }

    function ajax_get_upazila()
    {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));
        $options = $this->Mod_common->get_upazila_list_by_dis($district_id);
        echo $options;
    }



    private function _do_upload($master_insert_id, $my_real_file_name)
    {


        $structure = './upload/customer_image/' . $master_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }


        $config['upload_path'] = $structure;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2200;
        $config['file_name'] = $my_real_file_name;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('cPhoto')) //upload and validate
        {
            $data['inputerror'][] = 'cPhoto';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }



    //===================== validation ==========================

    private function _validate()
    {
        //die(json_encode($this->input->post()));
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('cName') == '') {
            $data['inputerror'][] = 'cName';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }

        $email = $this->input->post('cEmail');
        if ($email == '') {
            $data['inputerror'][] = 'cEmail';
            $data['error_string'][] = 'Email is required';
            $data['status'] = FALSE;
        }

        elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){

            $data['inputerror'][] = 'cEmail';
            $data['error_string'][] = 'Type valid email address';
            $data['status'] = FALSE;

        }

        $int = $this->input->post('cMobile');

        if ($this->input->post('cMobile') == '') {
            $data['inputerror'][] = 'cMobile';
            $data['error_string'][] = 'Type a valid mobile number';
            $data['status'] = FALSE;
        }

        elseif( !empty($int) && ! ctype_digit(strval($int))) {
            $data['inputerror'][] = 'cMobile';
            $data['error_string'][] = 'Mobile Number Only Integer';
            $data['status'] = FALSE;
        }


        //========================================


        $password = $this->input->post('cPass');
        $confirm = $this->input->post('confirm');

        if ($password == '') {
            $data['inputerror'][] = 'cPass';
            $data['error_string'][] = 'Password is required';
            $data['status'] = FALSE;
        }

        if ($confirm == '') {
            $data['inputerror'][] = 'confirm';
            $data['error_string'][] = 'Confirm your password';
            $data['status'] = FALSE;
        }

        //======================================

        /*if ($this->input->post('cFlat') == '') {
            $data['inputerror'][] = 'cFlat';
            $data['error_string'][] = 'Please type your address info';
            $data['status'] = FALSE;
        }

        if ($this->input->post('cRoad') == '') {
            $data['inputerror'][] = 'cRoad';
            $data['error_string'][] = 'Please type road or sector no';
            $data['status'] = FALSE;
        }*/


        if ($this->input->post('cPost') == '') {
            $data['inputerror'][] = 'cPost';
            $data['error_string'][] = 'Please type post office info';
            $data['status'] = FALSE;
        }

        if ($this->input->post('cPCode') == '') {
            $data['inputerror'][] = 'cPCode';
            $data['error_string'][] = 'Post Code is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('contact_add_division') == '') {
            $data['inputerror'][] = 'contact_add_division';
            $data['error_string'][] = 'Please select division';
            $data['status'] = FALSE;
        }
        if ($this->input->post('pName') == '') {
            $data['inputerror'][] = 'pName';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('pDes') == '') {
            $data['inputerror'][] = 'pDes';
            $data['error_string'][] = 'Designation is required';
            $data['status'] = FALSE;
        }

        $pemail = $this->input->post('pEmail');

        if ($pemail == '') {
            $data['inputerror'][] = 'pEmail';
            $data['error_string'][] = 'Email is required';
            $data['status'] = FALSE;
        }

        elseif (!empty($pemail) && !filter_var($pemail, FILTER_VALIDATE_EMAIL)){

            $data['inputerror'][] = 'pEmail';
            $data['error_string'][] = 'Type valid email address';
            $data['status'] = FALSE;

        }

        //============================================
        $pint = $this->input->post('pMobile');

        if ($pint == '') {
            $data['inputerror'][] = 'pMobile';
            $data['error_string'][] = 'Mobile Number is required';
            $data['status'] = FALSE;
        }
        elseif( !empty($pint) && ! ctype_digit(strval($pint))) {
            $data['inputerror'][] = 'pMobile';
            $data['error_string'][] = 'Mobile Number Only Integer';
            $data['status'] = FALSE;
        }
        //=============================================

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }




}