<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Customer
 * @author iplustraining
 * Date : 30-10-16
 * @property Mod_customer $Mod_customer
 * @property Mod_common $Mod_common
 */
class Customer extends My_Controller
{

    private $record_per_page = 20;
    private $record_num_links = 5;
    private $data = '';

    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */

        $this->load->model('sm/Mod_customer');
        $this->load->model('sm/Mod_common');

        if ($this->session->userdata('is_login') != true || $this->session->userdata('root_admin') == "no") { //only supper admin can access
            redirect('sm/home');
        }
    }

    function index()
    {

        $this->data['division_list'] = $this->Mod_common->get_division_list();

        $this->load->view('sm/customer/view_create_customer', $this->data);
    }

    function save()
    {

        if ($_POST) {

            $generate_random_password = $this->Mod_customer->generate_random_password();

            $datetime = date('Y-m-d H:i:s');

            $name = $this->session->userdata('login_admin_name');

            $this->_validate();
            
            //======= customer basic info ========
            $cName   = $this->input->post('cName');
            $cEmail  = $this->input->post('cEmail');
            $cMobile = $this->input->post('cMobile');
            $cTel    = $this->input->post('cTel');

            $mobile_exist = $this->Mod_customer->check_mobile($cMobile);


            if ($mobile_exist == 1) {

                $data['inputerror'][] = 'cMobile';
                $data['error_string'][] = 'Mobile Number Already Exist';
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            }

            //======== customer address info ======
            $cFlat  = $this->input->post('cFlat');
            $cRoad  = $this->input->post('cRoad');
            $cPost  = $this->input->post('cPost');
            $cPCode = $this->input->post('cPCode');
            $cDiv   = $this->input->post('contact_add_division');
            $cDist  = $this->input->post('contact_add_district');
            $cThana = $this->input->post('contact_add_upazila');


            //======== contact person info ========
            $pName   = $this->input->post('pName');
            $pDes    = $this->input->post('pDes');
            $pEmail  = $this->input->post('pEmail');
            $pMobile = $this->input->post('pMobile');


            $data = array(
                'name'                 => $cName,
                'password'             => $generate_random_password,
                'email'                => $cEmail,
                'mobile'               => $cMobile,
                'telephone_no'         => $cTel,
                'contact_add_division' => $cDiv,
                'contact_add_district' => $cDist,
                'contact_add_upazila'  => $cThana,
                'cust_flat'            => $cFlat,
                'cust_road'            => $cRoad,
                'cust_post'            => $cPost,
                'cust_post_code'       => $cPCode,
                'status'               => 'A',
                'created_date_time'    => $datetime,
                'created_by'           => $name,
                'login_token_id'       => $this->generateRandomString(10)
            );

            $insert_id = $this->Mod_customer->save_data($data);

            if ($insert_id){

                $contact_person = array(
                    'ref_customer_id'=> $insert_id,
                    'contact_person_name'  => $pName,
                    'contact_person_desig' => $pDes,
                    'contact_person_email' => $pEmail,
                    'contact_person_phone' => $pMobile,
                    'status' =>'A'
                );

               $this->Mod_customer->save_contact_person($contact_person);
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
            echo json_encode(array("status" => TRUE));
        }
    }



    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
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

    function ajax_get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url = base_url() . 'sm/customer/';
        $options = $this->Mod_common->get_disrict_list_by_div($division_id, $url);
        echo $options;
    }

    function ajax_get_upazila()
    {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));
        $options = $this->Mod_common->get_upazila_list_by_dis($district_id);
        echo $options;
    }

    function records()
    {

        $config = [];

        $this->data['division_list'] = $this->Mod_common->get_division_list();

        /*  for pagination */
        $row = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $this->data['record'] = $this->Mod_customer->get_customer_list(20, $row);

        $config['per_page'] = '20';
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/customer/records/';
        $config['total_rows'] = $this->Mod_customer->customer_total_rows();                  /*  for get table total rows number */

        $config['first_link'] = '&lsaquo; First';
        $config['last_link'] = 'Last &rsaquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&lsaquo;';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&rsaquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="paginate_button active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page'] = $config['per_page'];

        $this->load->view('sm/customer/view_customer_list', $this->data);
    }

    function search()
    {

        $search = '';
        $searchUrl = '';
        $config = [];

        /* Start search page pagination */
        $row = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }
        $name = trim($this->security->xss_clean($this->input->post('name')));  /* get search field name */
        $email = trim($this->security->xss_clean($this->input->post('email')));
        $mobile = trim($this->security->xss_clean($this->input->post('mobile')));
        $status = trim($this->security->xss_clean($this->input->post('status')));

        $sess_and_arry = array(
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'status' => $status,
            'search' => TRUE
        );

        $this->session->set_userdata($sess_and_arry);

        $results = $this->Mod_customer->search_all_list($this->record_per_page, $row);

        $config['per_page'] = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url'] = base_url() . 'sm/customer/records/';
        $config['total_rows'] = $this->Mod_customer->count_search_record();                  /*  for get table total rows number */

        $config['first_link'] = '&lsaquo; First';
        $config['last_link'] = 'Last &rsaquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&lsaquo;';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&rsaquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="paginate_button active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page'] = $config['per_page'];

        $this->data['search'] = $results;
        $this->load->view('sm/customer/view_customer_list_search', $this->data);
    }

    function edit()
    {
        $this->data['division_list'] = $this->Mod_common->get_division_list();
        $auto_id = $this->uri->segment(4);
        $get_details = $this->Mod_customer->get_details($auto_id);

        $this->data['edit'] = $get_details;
        $this->load->view('sm/customer/view_edit_customer', $this->data);
    }

    function update()
    {

        $hidden_customer_id = $this->security->xss_clean($this->input->post('hidden_customer_id'));


        $this->data['division_list'] = $this->Mod_common->get_division_list();

        $this->form_validation->set_rules('name', 'Customer Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|callback_validate_uniqe_mobile_edit|integer|max_length[16]');

        if ($this->form_validation->run() == FALSE) {
            $get_details = $this->Mod_customer->get_details($hidden_customer_id);
            $this->data['edit'] = $get_details;
            $this->load->view('sm/customer/view_edit_customer', $this->data);
        } else {
            $res_flag = $this->Mod_customer->update_data();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Customer Information updated successfully.');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to update information.');
            }
            redirect('sm/customer/records');
        }
    }

    function details()
    {

        $auto_id = $this->uri->segment(4);

        $this->data['view'] = $this->Mod_customer->get_details($auto_id);
        $this->load->view('sm/customer/view_profile_customer', $this->data);
    }

    function view()
    {

        $login_customer_phone = $this->session->userdata('login_customer_phone');
        $get_details = $this->Mod_customer->get_view($login_customer_phone);
        $this->data['view'] = $get_details;

        $this->load->view('sm/customer/view_profile_customer', $this->data);
    }

    function validate_uniqe_mobile($user_mobile)
    {
        $flag = $this->Mod_customer->check_user_mobile_uniq($user_mobile);

        if ($flag == true) {
            $this->form_validation->set_message('validate_uniqe_mobile', '<span style="color:red;" >Mobile: <i>' . $user_mobile . '</i> has already been taken.</span>');
            return false;
        } else {
            return true;
        }
    }

    function validate_uniqe_mobile_edit($user_mobile)
    {
        $hidden_customer_id = $this->security->xss_clean($this->input->post('hidden_customer_id'));
        $flag = $this->Mod_customer->check_user_mobile_uniq_edit($user_mobile, $hidden_customer_id);

        if ($flag == true) {
            $this->form_validation->set_message('validate_uniqe_mobile_edit', '<span style="color:red;" >Mobile: <i>' . $user_mobile . '</i> has already been taken.</span>');
            return false;
        } else {
            return true;
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('cName') == '') {
            $data['inputerror'][] = 'cName';
            $data['error_string'][] = 'Client name is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('cEmail') == '') {
            $data['inputerror'][] = 'cEmail';
            $data['error_string'][] = 'Client email is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('cMobile') == '') {
            $data['inputerror'][] = 'cMobile';
            $data['error_string'][] = 'Client mobile number is required';
            $data['status'] = FALSE;
        }
        $int = $this->input->post('cMobile');
        if (filter_var($int, FILTER_VALIDATE_INT)) {
            $data['inputerror'][] = 'cMobile';
            $data['error_string'][] = 'Client mobile number only number';
            $data['status'] = FALSE;
        }

        if ($this->input->post('cFlat') == '') {
            $data['inputerror'][] = 'cFlat';
            $data['error_string'][] = 'Please type your address info';
            $data['status'] = FALSE;
        }

        if ($this->input->post('cRoad') == '') {
            $data['inputerror'][] = 'cRoad';
            $data['error_string'][] = 'Please type road or sector no';
            $data['status'] = FALSE;
        }


        if ($this->input->post('cPost') == '') {
            $data['inputerror'][] = 'cPost';
            $data['error_string'][] = 'Please type post office info';
            $data['status'] = FALSE;
        }

        if ($this->input->post('cPCode') == '') {
            $data['inputerror'][] = 'cPCode';
            $data['error_string'][] = 'cPCode is required';
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
        if ($this->input->post('pEmail') == '') {
            $data['inputerror'][] = 'pEmail';
            $data['error_string'][] = 'Email is required';
            $data['status'] = FALSE;
        }
        if ($this->input->post('pMobile') == '') {
            $data['inputerror'][] = 'pMobile';
            $data['error_string'][] = 'Mobile Number is required';
            $data['status'] = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }


    function approved($id)
    {


        $this->db->set('status', 'A'); //value that used to update column
        $this->db->where('customer_id', $id); //which row want to upgrade
        $result =  $this->db->update('customer');  //table name

        if ($result){
            redirect('sm/customer/records');
        }else{
            $this->session->set_flashdata('flashError', 'Failed to update information.');
            redirect('sm/customer/records');
        }

    }



//    function sendMail() {
//        
//        $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'ssl://smtp.googlemail.com',
//            'smtp_port' => 465,
//            'smtp_user' => 'xxx@gmail.com',
//            'smtp_pass' => 'xxx',
//            'mailtype' => 'html',
//            'charset' => 'iso-8859-1',
//            'wordwrap' => TRUE
//        );
//
//        $message = 'test';
//        $this->load->library('email', $config);
//        $this->email->set_newline("\r\n");
//        $this->email->from('xxx@gmail.com');
//        $this->email->to('xyz@gmail.com');
//        $this->email->subject('testing');
//        $this->email->message($message);
//        if ($this->email->send()) {
//            echo 'Email sent.';
//        } else {
//            show_error($this->email->print_debugger());
//        }
//    }
}
