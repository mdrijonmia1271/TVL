<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Customer
 * @author iplustraining
 * Date : 30-10-16
 * @property Mod_customer $Mod_customer
 * @property Mod_common $Mod_common
 * @property Mod_ticket $Mod_ticket
 * @property MedicalDep $MedicalDep
 */
class Customer extends My_Controller
{

    private $record_per_page  = 20;
    private $record_num_links = 5;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */

        $this->load->model('sm/Mod_customer');
        $this->load->model('sm/Mod_common');
        $this->load->model('sm/Mod_ticket');
        $this->load->model('sm/MedicalDep');
        $this->load->model('sm/Mod_install');

        /*if ($this->session->userdata('is_login') != true || $this->session->userdata('root_admin') == "no" && $this->session->userdata('admin_user_type') != 'sm') { //only supper admin can access
            redirect('sm/home');
        }*/
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

                $data['inputerror'][]   = 'cMobile';
                $data['error_string'][] = 'Mobile Number Already Exist';
                $data['status']         = FALSE;
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
            );

            $insert_id = $this->Mod_customer->save_data($data);

            if ($insert_id) {

                $msg = "প্রিয় গ্রাহক, টিভিএলের পক্ষ থেকে শুভেচ্ছা।আপনার লগইন আইডি হল $cMobile এবং পাসওয়ার্ড হল $generate_random_password৷ অনুমোদন এবং আরও বিশদ বিবরণের জন্য, 01755645555 এ কল করুন৷ অনুমোদন পেতে প্রায় 48 ঘণ্টা সময় লাগে৷";

                send_sms($cMobile, $msg);

                $contact_person = array(
                    'ref_customer_id'      => $insert_id,
                    'contact_person_name'  => $pName,
                    'contact_person_desig' => $pDes,
                    'contact_person_email' => $pEmail,
                    'contact_person_phone' => $pMobile,
                    'status'               => 'A'
                );

                $this->Mod_customer->save_contact_person($contact_person);
            }

            if ($insert_id) {

                if (!empty($_FILES['cPhoto']['name'])) {

                    $temp_file_name    = $_FILES['cPhoto']['name'];
                    $temp              = explode('.', $temp_file_name);
                    $my_real_file_name = $temp[0];


                    $upload                   = $this->_do_upload($insert_id, $my_real_file_name);
                    $upload_images['picture'] = $upload;

                    $this->db->update('customer', $upload_images, array('customer_id' => $insert_id));
                }
            }
            echo json_encode(array("status" => TRUE));
        }
    }

    private function _validate()
    {
        $data                 = array();
        $data['error_string'] = array();
        $data['inputerror']   = array();
        $data['status']       = TRUE;

        if ($this->input->post('cName') == '') {
            $data['inputerror'][]   = 'cName';
            $data['error_string'][] = 'Client name is required';
            $data['status']         = FALSE;
        }

        if ($this->input->post('cEmail') == '') {
            $data['inputerror'][]   = 'cEmail';
            $data['error_string'][] = 'Client email is required';
            $data['status']         = FALSE;
        }

        if ($this->input->post('cMobile') == '') {
            $data['inputerror'][]   = 'cMobile';
            $data['error_string'][] = 'Client mobile number is required';
            $data['status']         = FALSE;
        }
        $int = $this->input->post('cMobile');
        if (filter_var($int, FILTER_VALIDATE_INT)) {
            $data['inputerror'][]   = 'cMobile';
            $data['error_string'][] = 'Client mobile number only number';
            $data['status']         = FALSE;
        }

        if ($this->input->post('cFlat') == '') {
            $data['inputerror'][]   = 'cFlat';
            $data['error_string'][] = 'Please type your address info';
            $data['status']         = FALSE;
        }

        if ($this->input->post('cRoad') == '') {
            $data['inputerror'][]   = 'cRoad';
            $data['error_string'][] = 'Please type road or sector no';
            $data['status']         = FALSE;
        }


        if ($this->input->post('cPost') == '') {
            $data['inputerror'][]   = 'cPost';
            $data['error_string'][] = 'Please type post office info';
            $data['status']         = FALSE;
        }

        if ($this->input->post('cPCode') == '') {
            $data['inputerror'][]   = 'cPCode';
            $data['error_string'][] = 'cPCode is required';
            $data['status']         = FALSE;
        }
        if ($this->input->post('contact_add_division') == '') {
            $data['inputerror'][]   = 'contact_add_division';
            $data['error_string'][] = 'Please select division';
            $data['status']         = FALSE;
        }
        if ($this->input->post('pName') == '') {
            $data['inputerror'][]   = 'pName';
            $data['error_string'][] = 'Name is required';
            $data['status']         = FALSE;
        }
        if ($this->input->post('pDes') == '') {
            $data['inputerror'][]   = 'pDes';
            $data['error_string'][] = 'Designation is required';
            $data['status']         = FALSE;
        }
        if ($this->input->post('pEmail') == '') {
            $data['inputerror'][]   = 'pEmail';
            $data['error_string'][] = 'Email is required';
            $data['status']         = FALSE;
        }
        if ($this->input->post('pMobile') == '') {
            $data['inputerror'][]   = 'pMobile';
            $data['error_string'][] = 'Mobile Number is required';
            $data['status']         = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _do_upload($master_insert_id, $my_real_file_name)
    {


        $structure = './upload/customer_image/' . $master_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }


        $config['upload_path']   = $structure;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 2200;
        $config['file_name']     = $my_real_file_name;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('cPhoto')) //upload and validate
        {
            $data['inputerror'][]   = 'cPhoto';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status']         = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    function ajax_get_district()
    {
        $division_id = $this->security->xss_clean($this->input->post('division_id'));

        $url     = base_url() . 'sm/customer/';
        $options = $this->Mod_common->get_disrict_list_by_div($division_id, $url);
        echo $options;
    }

    function ajax_get_upazila()
    {
        $district_id = $this->security->xss_clean($this->input->post('district_id'));
        $options     = $this->Mod_common->get_upazila_list_by_dis($district_id);
        echo $options;
    }

    function records()
    {

        $config = [];

        $this->data['division_list'] = $this->Mod_common->get_division_list();

        /*  for pagination */
        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $this->data['record'] = $this->Mod_customer->get_customer_list(8, $row);

        $config['per_page']    = '8';
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/customer/records/';
        $config['total_rows']  = $this->Mod_customer->customer_total_rows();                  /*  for get table total rows number */

        $page_config = get_pagination_paramter();

        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];

        $this->load->view('sm/customer/view_customer_list', $this->data);
    }

    public function pendinglist() {
        $config = [];
        /*  for pagination */
        $row = isset($_GET['page']) ? $this->input->get('page') : 0;
        $per_page = 20;
        $this->data['record']  = $this->Mod_customer->get_sub_customer_list($per_page, $row);
        $config['per_page']    = $per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/customer/pendinglist';
        $config['total_rows']  = $this->Mod_customer->get_sub_customer_list(0, 0, true);                  /*  for get table total rows number */

        $page_config = get_pagination_paramter();

        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];
        $this->data['row']        = $this->uri->segment(4);
        $this->load->view('sm/customer/view_sub_customer_pending_list', $this->data);
    }

    public function all_sub_user_list() {
        $config = [];

        /*  for pagination */
        $row = isset($_GET['page']) ? $this->input->get('page') : 0;

        $this->data['record'] = $this->Mod_customer->all_sub_user_list($id, 8, $row);
        // dd($this->data['record']);
        $config['per_page']    = '8';
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/customer/sub_user_list/' . $id;
        $config['total_rows']  = count($this->data['record']); /*  for get table total rows number */

        $page_config = get_pagination_paramter();

        $config = array_merge($config, $page_config);
        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];
        $this->data['customer_id']= $id;
        $this->load->view('sm/customer/view_all_sub_user_list', $this->data);
    }

    public function edit_sub_user() {
        $this->data['division_list'] = $this->Mod_common->get_division_list();
        $auto_id                     = $this->uri->segment(4);
        $get_details                 = $this->Mod_customer->get_view_sub_customer($auto_id);
        $get_machine_details                 = $this->Mod_customer->sub_customer_wise_machine($auto_id);

        // dd($get_machine_details);

        $this->data['machine']    = $this->Mod_install->get_machine_data();
        $this->data['support']    = $this->Mod_install->get_support_type();
        $this->data['business']   = $this->Mod_install->get_business_area();
        $this->data['department'] = $this->MedicalDep->get_all_status_wise();

        $this->data['edit'] = $get_details;
        $this->data['item'] = $get_machine_details;
        // dd($this->data['item']);
        $this->load->view('sm/customer/view_edit_sub_user', $this->data);
    }

    public function update_sub_user($id)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cMobile', 'Mobile Number', 'required|is_unique[customer.mobile]|is_unique[sm_admin.mobile]|is_unique[sm_service_engineer.mobile]|integer|max_length[11]');
        $this->form_validation->set_rules('cEmail', 'Email', 'required|valid_email|is_unique[customer.email]');
        $this->form_validation->set_rules('machine', 'Machine', 'required|integer');
        $this->form_validation->set_rules('dep_ref_id', 'Department', 'required|integer');
        $this->form_validation->set_rules('bArea', 'Area', 'required|integer');
        $this->form_validation->set_rules('mcSrial', 'Serial', 'required|integer');

        // $this->_validate();

        if ($_POST && $this->form_validation->run()) {
            $datetime = date('Y-m-d H:i:s');

            //======= customer basic info ========
            $cMobile  = $this->input->post('cMobile');
            $cEmail   = $this->input->post('cEmail');
            $customer_id   = $this->input->post('hidden_customer_id');

            //======== Machine Details ========
            $machine   = $this->input->post('machine');
            $dep_ref_id = $this->input->post('dep_ref_id');
            $bArea  = $this->input->post('bArea');
            $sector = $this->input->post('sector');
            $mcSrial = $this->input->post('mcSrial');
            
            $data = array(
                'email'                => $cEmail,
                'phone'                => $cMobile,
                'password'             => md5($this->input->post('password'))
            );


            $this->db->where('id', $id);
            $this->db->update('customer_sub_login', $data);

            $machine_details = [
                'dep_ref_id'            => $dep_ref_id,
                'insb_business_area'    => $bArea,
                'insb_sector'           => $sector,
                'insb_machine'          => $machine,
                'insb_serial'           => $mcSrial
            ];

            $this->db->where('customer_id_sub', $id);
            $query = $this->db->get('install_base');

            if($query->num_rows() > 0){
                $install_base_id = $query->row()->insb_id;

                $this->db->where('customer_id_sub', $id);
                $res = $this->db->update('install_base', $machine_details);
            }else{
                $machine_details = [
                        'insb_customer'         => $customer_id,
                        'dep_ref_id'            => $dep_ref_id,
                        'insb_business_area'    => $bArea,
                        'insb_sector'           => $sector,
                        'insb_machine'          => $machine,
                        'insb_serial'           => $mcSrial,
                        'status'                => '1',
                        'support_type'          => '4',
                        'customer_id_sub'       => $id
                    ];

                    $install_base_id = $this->Mod_install->save_install_base($machine_details);
            }

            if (!empty($_FILES['picture']['name'])) {
                $picture                  = $this->_do_upload_machine($install_base_id);
                $upload_images['picture'] = $picture;
                $this->db->update('install_base', $upload_images, array('insb_id' => $install_base_id));
            }

            
            $this->session->set_flashdata('flashOK', 'Sub user information updated successfully.');
            redirect('sm/customer/edit_sub_user/' . $id);
        } else {
            foreach ($this->form_validation->error_array() as $field => $message) {
                $this->session->set_flashdata('flashError', $message);
            }
            redirect('sm/customer/edit_sub_user/' . $id);
        }

    }

    private function _do_upload_machine($master_insert_id)
    {
        $structure = './upload/install_base/' . $master_insert_id;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }


        $config['upload_path']   = $structure;
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
        $config['max_size']      = 2200;
        $config['encrypt_name']  = true;
        $config['overwrite']     = false;

        $this->load->library('upload', $config);
        $this->load->initialize($config);

        if (!$this->upload->do_upload('picture')) //upload and validate
        {
            $data['inputerror'][]   = 'insReport';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status']         = FALSE;
            echo json_encode($data);
            exit();
        }

        return $this->upload->data('file_name');
    }

    public function approved_sub_customer() {
        $response = ['status' => false, 'data' => null, 'message' => ''];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'Customer Id', 'required');
        if ($this->form_validation->run()) {
            if (isset($_POST['status']) && !empty($this->input->post('status')) && $_POST['status'] == 'reject') {
                $res = $this->Mod_customer->reject_sub_customer($this->input->post('id', true));

                $contact_person = $this->db->where('id', $this->input->post('id', true))->get('customer_sub_login')->row()->phone;
                $message_details = get_temp_details('USER_APPROVAL_REJECTED');
                if ($message_details) {
                    $msg = message_format($message_details->message, []);
                    send_sms($contact_person, $msg);
                }
            } else {
                $res = $this->Mod_customer->approved_sub_customer($this->input->post('id', true));

                $contact_person = $this->db->where('id', $this->input->post('id', true))->get('customer_sub_login')->row()->phone;
                $message_details = get_temp_details('USER_APPROVAL');
                if ($message_details) {
                    $msg = message_format($message_details->message, []);
                    send_sms($contact_person, $msg);
                }

            }
            if ($res) {
                $response['status'] = true;
                $response['message'] = 'sub customer approved updated';
                $response['data'] = $res;
            }
        } else {
            $response['message'] = 'Customer id must be require';
        }
        echo json_encode($response);
    }

    public function sub_user_list ($id) {
        $config = [];

        /*  for pagination */
        $row = isset($_GET['page']) ? $this->input->get('page') : 0;

        $this->data['record'] = $this->Mod_customer->get_sub_customer_list_2($id, 8, $row);
        $config['per_page']    = '8';
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/customer/sub_user_list/' . $id;
        $config['total_rows']  = count($this->data['record']); /*  for get table total rows number */

        $page_config = get_pagination_paramter();

        $config = array_merge($config, $page_config);
        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];
        $this->data['customer_id']= $id;
        $this->load->view('sm/customer/view_sub_customer_list', $this->data);
    }

    function search()
    {

        $search    = '';
        $searchUrl = '';
        $config    = [];

        /* Start search page pagination */
        $row            = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }
        $name   = trim($this->security->xss_clean($this->input->post('name')));  /* get search field name */
        $email  = trim($this->security->xss_clean($this->input->post('email')));
        $mobile = trim($this->security->xss_clean($this->input->post('mobile')));
        $status = trim($this->security->xss_clean($this->input->post('status')));

        $sess_and_arry = array(
            'name'   => $name,
            'email'  => $email,
            'mobile' => $mobile,
            'status' => $status,
            'search' => TRUE
        );

        $this->session->set_userdata($sess_and_arry);

        $results = $this->Mod_customer->search_all_list($this->record_per_page, $row);

        $config['per_page']    = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/customer/records/';
        $config['total_rows']  = $this->Mod_customer->count_search_record();                  /*  for get table total rows number */

        $config['first_link']      = '&lsaquo; First';
        $config['last_link']       = 'Last &rsaquo;';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link']       = '&lsaquo;';
        $config['prev_tag_open']   = '<li class="prev">';
        $config['prev_tag_close']  = '</li>';
        $config['next_link']       = '&rsaquo;';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="paginate_button active"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';

        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];

        $this->data['search'] = $results;
        $this->load->view('sm/customer/view_customer_list_search', $this->data);
    }

    function edit()
    {
        $this->data['division_list'] = $this->Mod_common->get_division_list();
        $auto_id                     = $this->uri->segment(4);
        $get_details                 = $this->Mod_customer->get_details($auto_id);

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
            $get_details        = $this->Mod_customer->get_details($hidden_customer_id);
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


    //===============================

    function view()
    {
        $login_customer_phone = $this->session->userdata('login_customer_phone');

        $get_details        = $this->Mod_customer->get_view($login_customer_phone);
        $this->data['view'] = $get_details;

        if (isset($_SESSION['sub_customer_id']) && !empty($_SESSION['sub_customer_id'])) {
            $sub_customer_id = $this->session->userdata('sub_customer_id');
            $this->data['sub_customer'] = $this->Mod_customer->get_view_sub_customer($sub_customer_id);
        }
        $this->load->view('sm/customer/view_profile_customer', $this->data);
    }

    function edit_profile()
    {
        $this->data['division_list'] = $this->Mod_common->get_division_list();
        $auto_id                     = $this->uri->segment(4);
        $get_details                 = $this->Mod_customer->get_details($auto_id);

        $this->data['edit'] = $get_details;
        $this->load->view('sm/customer/view_edit_profile', $this->data);
    }

    function update_profile()
    {

        $hidden_customer_id = $this->security->xss_clean($this->input->post('hidden_customer_id'));


        $this->data['division_list'] = $this->Mod_common->get_division_list();

        $this->form_validation->set_rules('name', 'Customer Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|callback_validate_uniqe_mobile_edit|integer|max_length[16]');

        if ($this->form_validation->run() == FALSE) {
            $get_details        = $this->Mod_customer->get_details($hidden_customer_id);
            $this->data['edit'] = $get_details;
            $this->load->view('sm/customer/view_edit_profile', $this->data);
        } else {
            $res_flag = $this->Mod_customer->update_data();

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Customer Information updated successfully.');
            } else {
                $this->session->set_flashdata('flashError', 'Failed to update information.');
            }
            redirect('sm/customer/view');
        }
    }

    public function reset()
    {

        $this->load->view('sm/customer/view_reset_pass');
    }

    public function update_password()
    {

        if ($_POST) {

            $response     = array();
            $login_id     = $this->session->userdata('customer_auto_id');
            $new_pass     = $this->input->post('cuPass');
            $confirm_pass = $this->input->post('conPass');

            if ($new_pass == $confirm_pass) {

                $data['password'] = $new_pass;
                $this->Mod_customer->update_password(array('customer_id' => $login_id), $data);

                $response['status'] = true;

            } else {

                $response['status'] = false;
            }

            echo json_encode($response);
        }

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
        $flag               = $this->Mod_customer->check_user_mobile_uniq_edit($user_mobile, $hidden_customer_id);

        if ($flag == true) {
            $this->form_validation->set_message('validate_uniqe_mobile_edit', '<span style="color:red;" >Mobile: <i>' . $user_mobile . '</i> has already been taken.</span>');
            return false;
        } else {
            return true;
        }
    }

    function approved($id)
    {


        $this->db->set('status', 'A'); //value that used to update column
        $this->db->where('customer_id', $id); //which row want to upgrade
        $result = $this->db->update('customer');  //table name

        if ($result) {

            $mobile = $this->Mod_customer->get_customer_info($id);

            $msg = trim('ট্রেডভিশন লিমিটেডের - এ আপনার অ্যাকাউন্ট অনুমোদিত। এখন আপনি লগইন করতে পারেন।');

            send_sms($mobile, $msg);

            redirect('sm/customer/records');
        } else {
            $this->session->set_flashdata('flashError', 'Failed to update information.');
            redirect('sm/customer/records');
        }

    }

    function approved_sub_user($id)
    {
        $this->db->set('status', '1'); // value that used to update column
        $this->db->where('id', $id); // which row want to upgrade
        $result = $this->db->update('customer_sub_login');  // table name

        if ($result) {
            $sub_user_list = $this->Mod_customer->get_customer_sub_user_info($id);
            $msg = trim('ট্রেডভিশন লিমিটেডের - এ আপনার অ্যাকাউন্ট অনুমোদিত। এখন আপনি লগইন করতে পারেন।');
            send_sms($sub_user_list->phone, $msg);
            redirect('sm/customer/sub_user_list/' . $sub_user_list->customer_id);
        } else {
            $this->session->set_flashdata('flashError', 'Failed to update information.');
            redirect('sm/customer/records');
        }

    }


    //========================= customer feedback ============================================

    public function feedback()
    {
        $data['department'] = $this->MedicalDep->get_all_status_wise();
        $this->load->view('sm/customer/view_cust_feedback', $data);
    }


    public function save_feedback()
    {

        if ($_POST) {

            $customer_id = $this->session->userdata('customer_auto_id');
            $datetime    = date('Y-m-d H:i:s');

            $this->_feedback_validate();

            $data = array(

                'cust_ref_id' => $customer_id,
                'dep_ref_id'  => $this->input->post('dep_ref_id'),
                'f_subject'   => $this->input->post('sub'),
                'feedback'    => $this->input->post('desc'),
                'created'     => $datetime
            );


            $insert = $this->Mod_customer->feedback_save($data);

            if ($insert) {
                echo json_encode(array("status" => TRUE));
            }
        }

    }


    private function _feedback_validate()
    {
        $data                 = array();
        $data['error_string'] = array();
        $data['inputerror']   = array();
        $data['status']       = TRUE;

        if ($this->input->post('sub') == '') {
            $data['inputerror'][]   = 'sub';
            $data['error_string'][] = 'Subject is required';
            $data['status']         = FALSE;
        }

        if ($this->input->post('desc') == '') {
            $data['inputerror'][]   = 'desc';
            $data['error_string'][] = 'Feedback is required';
            $data['status']         = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }


    public function feedback_list()
    {
        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $data['customer'] = $this->Mod_customer->get_customer();
        $data['feedback'] = $this->Mod_customer->feedback_list_data($this->record_per_page, $row);

        $config['per_page']    = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/customer/feedback_list/';
        $config['total_rows']  = $this->Mod_customer->ticket_total_rows();
        $page_config           = get_pagination_paramter();

        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);

        $data['links']      = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['per_page']   = $config['per_page'];

        $this->load->view('sm/customer/view_feedback_list', $data);
    }

//========================== admin send notification to customer =================================
    public function notification()
    {

        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $data['notification'] = $this->Mod_customer->notification_list($this->record_per_page, $row);

        $config['per_page']    = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/customer/notification/';
        $config['total_rows']  = $this->Mod_customer->notification_total_rows();
        $page_config           = get_pagination_paramter();

        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);

        $data['links']      = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['per_page']   = $config['per_page'];


        $this->load->view('sm/customer/view_notification_list', $data);

    }

    public function add_notf()
    {
        $data['customer'] = $this->Mod_customer->get_customer_dropdwon();
        $data['machine']  = $this->Mod_customer->get_customer_machine();
        $this->load->view('sm/customer/view_add_notification', $data);
    }


    public function machine_wise_customer($machine_id)
    {

        $data['customer'] = $this->Mod_customer->get_machine_wise_customer($machine_id);

        echo json_encode($data);

    }


    public function send_sms_notification()
    {

        if ($_POST) {


            $this->form_validation->set_rules('machine', 'Machine', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');

            if ($this->form_validation->run()) {


                $customer_all   = $this->input->post('from');
                $customer_fixed = $this->input->post('to');
                $anotherPhone   = $this->input->post('anphone');
                $title          = $this->input->post('title');
                $machine_id     = $this->input->post('machine');
                $ntf_type       = $this->input->post('ntype');
                $message        = $this->input->post('message');
                $datetime       = date('Y-m-d H:i:s');
                $login_id       = $this->session->userdata('admin_auto_id');

                $message_id = $this->Mod_customer->notification_save($title, $ntf_type, $message);


                if ($ntf_type != 1) {

                    // ========================== if select machine and customer ===========================
                    if (!empty($customer_fixed) && $message_id && $machine_id) {


                        $searchForValue = ',';
                        $stringValue    = $customer_fixed[0];
                        $mobile         = [];


                        //================= another mobile number ===============
                        if (!empty($anotherPhone)) {

                            $array_data = explode(',', $anotherPhone);

                            foreach ($array_data as $d) {
                                $mobile[] = $d;

                                $data[] = [
                                    'ntf_ref_id' => $message_id,
                                    'phone'      => $d
                                ];

                            }
                        }


                        foreach ($customer_fixed as $customer_id) {

                            $selected_customer = [];
                            $selected_customer = explode(',', $customer_id);

                            $customer        = $this->Mod_customer->get_customer_info($selected_customer[0]);
                            $customer_mobile = preg_replace("/[^a-zA-Z0-9]+/", "", $customer);

                            //======== department head mobile number =================
                            if (isset($selected_customer[1])) {

                                $department_head = $this->Mod_customer->get_department_head($selected_customer[0], $selected_customer[1]);

                                if (!in_array($department_head, $mobile)) {
                                    $mobile [] = $department_head;
                                }
                            }
                            //========== customer mobile number =========================
                            if (!in_array($customer_mobile, $mobile)) {

                                $mobile [] = $customer_mobile;
                            }


                            $data2[] = [
                                'ntf_ref_id'      => $message_id,
                                'dep_ref_id'      => !empty($selected_customer[1]) ? $selected_customer[1] : '',
                                'customer_id'     => $selected_customer[0],
                                'machine_id'      => $machine_id,
                                'cust_mobile'     => $customer_mobile,
                                'dep_head_mobile' => !empty($department_head) ? $department_head : '',
                                'send_date'       => $datetime,
                                'created_by'      => $login_id,
                            ];


                        }

                        $this->db->insert_batch('notification_to_customer', $data2);
                        $this->db->insert_batch('ntf_to_another', $data);

                        //=============== Now send sms ============
                        if (!empty($mobile)) {

                            foreach ($mobile as $m) {
                                //$mobile = '01680117577';
                                $sms = send_sms($m, $message);

                                if ($sms == true) {
                                    sms_log_write($m, $datetime);
                                }
                            }
                        }
                    }

                } else {

                    if (!empty($customer_fixed) && $message_id && $machine_id) {


                        foreach ($customer_fixed as $customer_id) {

                            $selected_customer = explode(',', $customer_id);

                            $data2[] = [

                                'ntf_ref_id'  => $message_id,
                                'dep_ref_id'  => !empty($selected_customer[1]) ? $selected_customer[1] : '',
                                'customer_id' => $selected_customer[0],
                                'machine_id'  => $machine_id,
                                'send_date'   => $datetime,
                                'created_by'  => $login_id,
                            ];

                        }

                        $this->db->insert_batch('notification_to_customer', $data2);
                    }
                }

                redirect('sm/customer/notification');

            } else {

                $data['customer'] = $this->Mod_customer->get_customer_dropdwon();
                $data['machine']  = $this->Mod_customer->get_customer_machine();
                $this->load->view('sm/customer/view_add_notification', $data);

                $this->session->set_flashdata('flashError', 'Failed to Send Notification.');

            }

        }

    }

//=============================== customer notification ==============================
    public function admin_ntf()
    {

        if ($this->session->userdata('is_customer_login') == true) {

            $customer_id              = $this->session->userdata('customer_auto_id');
            $this->data['ntfication'] = $this->Mod_customer->customer_wise_notification($customer_id);
        }

        $this->load->view('sm/customer/view_customer_notification', $this->data);


    }

//====================================================================================================
    public function machine()
    {

        if ($this->session->userdata('is_customer_login') == true) {

            $customer_id                    = $this->session->userdata('customer_auto_id');
            $this->data['customer_machine'] = $this->Mod_customer->customer_wise_machine($customer_id);
            $this->data['machine']          = $this->Mod_ticket->get_customer_wise_machine($customer_id);
        }
        
        $this->load->view('sm/customer/view_machine_list', $this->data);


    }


    //========================== Otp page =======================
    public function customer_otp()
    {

        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $data['customer'] = $this->Mod_customer->customer_otp_list($this->record_per_page, $row);

        $config['per_page']    = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/customer/notification/';
        $config['total_rows']  = $this->Mod_customer->notification_total_rows();
        $page_config           = get_pagination_paramter();

        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);

        $data['links']      = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['per_page']   = $config['per_page'];


        $this->load->view('sm/customer/view_otp_list', $data);

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
