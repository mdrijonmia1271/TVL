<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Serviceengineer
 *
 * @author aswadia
 * @property Mod_serviceengineer $Mod_serviceengineer
 * @property MedicalDep $MedicalDep
 *
 */
class Serviceengineer extends My_Controller
{

    private $record_per_page  = 50;
    private $record_num_links = 5;


    public function __construct()
    {
        parent::__construct();

        $this->load->model('sm/Mod_serviceengineer');
        $this->load->model('sm/Mod_common');
        $this->load->model('sm/MedicalDep');
        $this->load->library('form_validation'); /* load validation library */
        $this->load->library('pagination');      /*  load pagination library */
        $this->load->library('common_lib');      /*  load pagination library */
        $this->load->library('M_pdf');

        if ($this->session->userdata('is_login') != true) {
            redirect('sm/home');
        }


    }

    function index()
    {
        redirect('sm/serviceengineer/records');
    }

    function records()
    {
        $config = [];

        $this->data['division_list'] = $this->Mod_common->get_division_list();
        $this->data['department']    = $this->MedicalDep->get_all_status_wise();
        /*  for pagination */
        $row        = 0;
        $record_pos = $this->uri->segment(4);

        if (!empty($record_pos)) {
            $row = $record_pos;
        }

        $this->data['record'] = $this->Mod_serviceengineer->get_ticket_list($this->record_per_page, $row);
        // print_r('<pre>');print_r($this->data['record']);die();

        $config['per_page']    = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/serviceengineer/records/';
        $config['total_rows']  = $this->Mod_serviceengineer->ticket_total_rows();                  /*  for get table total rows number */

        $page_config = get_pagination_paramter();

        $config = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];

        $this->load->view('sm/serviceengineer/view_list_ticket', $this->data);
    }


    function action()
    {
        $row = 0;
        $this->load->model('sm/Mod_ticket');
        $auto_id = $this->security->xss_clean($this->uri->segment(4)); //ticketId

        $ticket_details = $this->Mod_serviceengineer->get_details($auto_id);

        if (empty($auto_id) || empty($ticket_details)) {
            redirect('sm/serviceengineer/records');
        }

        $this->data['view'] = $ticket_details;

        $this->data['record']            = $this->Mod_serviceengineer->get_ticket_comment_list($this->record_per_page, $row, $ticket_details->ticket_no);
        $this->data['ticket_trans_flow'] = $this->Mod_ticket->get_ticket_trans_flow_tab($ticket_details->ticket_no);

        $this->data['ticket_status_array']             = ticket_service_en_status_array();// ticket_status_array();
        $this->data['get_priority_array_dropdown']     = get_priority_array_dropdown();
        $this->data['get_service_type_array_dropdown'] = get_service_type_array_dropdown();

        $this->data['spare'] = $this->Mod_serviceengineer->get_spare_parts();

        $this->load->view('sm/serviceengineer/view_ticket_action', $this->data);
    }

    function ticketsearch()
    {
        $config = [];

        /* Start search page pagination */
        $row            = 0;
        $recordPosition = $this->uri->segment(4);
        if (!empty($recordPosition)) {
            $row = $recordPosition;
        }

        if ($_POST) {

            $ticket_no    = trim($this->security->xss_clean($this->input->post('ticket_no')));  /* get search field name */
            $priority     = trim($this->security->xss_clean($this->input->post('priority')));
            $status       = trim($this->security->xss_clean($this->input->post('status')));
            $support_type = trim($this->security->xss_clean($this->input->post('support_type')));
            $department   = trim($this->security->xss_clean($this->input->post('dep_ref_id')));
            $dateFrom     = trim($this->security->xss_clean($this->input->post('dateFrom')));
            $dateTo       = trim($this->security->xss_clean($this->input->post('dateTo')));

            $sess_and_arry = array(
                'ticket_no'    => $ticket_no,
                'priority'     => $priority,
                'dep_ref_id'   => $department,
                'status'       => $status,
                'support_type' => $support_type,
                'start_date'   => $dateFrom,
                'end_date'     => $dateTo,
                'search'       => TRUE
            );

            $this->session->set_userdata($sess_and_arry);
        }


        $results = $this->Mod_serviceengineer->search_all_list($this->record_per_page, $row);

        $config['per_page']    = $this->record_per_page;
        $config['uri_segment'] = '4';
        $config['base_url']    = base_url() . 'sm/serviceengineer/records/';
        $config['total_rows']  = $this->Mod_serviceengineer->count_search_record();                  /*  for get table total rows number */

        $page_config = get_pagination_paramter();
        $config      = array_merge($config, $page_config);

        $this->pagination->initialize($config);
        $this->data['links']      = $this->pagination->create_links();
        $this->data['total_rows'] = $config['total_rows'];
        $this->data['per_page']   = $config['per_page'];

        $this->data['record'] = $results;
        $this->load->view('sm/serviceengineer/view_list_ticket', $this->data);
    }

    function update_ticket_status()
    {

        $this->form_validation->set_rules('status', 'Ticket Status', 'required');

        if ($this->form_validation->run()) {

            $srd_id           = $this->security->xss_clean($this->input->post('srd_id'));
            $engineer_auto_id = $this->session->userdata('engineer_auto_id');
            $status           = $this->security->xss_clean($this->input->post('status'));

            $res_flag = $this->Mod_serviceengineer->update_ticket_status();

            if ($status == 'A') {

                $ticket = $this->Mod_serviceengineer->get_ticket_info($srd_id, $engineer_auto_id);

                $message_details_customer = get_temp_details('TICKET_DONE_CUSTOMER');
                $msg = message_format($message_details_customer->message, [
                    'ticket_no' => $ticket->ticket_no
                ]);

                foreach ($ticket as $key => $no) {
                    if ($key != 'status' && $key != 'ticket_no') {
                        send_sms($no, $msg);
                    }
                }

                // SUPER VISOR MESSAGE
                $q = $this->db->select('superadmin_name as name, mobile')->where([
                    'user_type' => 'sm',
                    'status' => 'A'
                ])->get('sm_admin');
                $message_details_manager = get_temp_details('TICKET_DONE_MANAGER');
                if ($message_details_manager && $q->num_rows() > 0) {
                    foreach ($q->result() as $sm) {
                        $msg = message_format($message_details_manager->message, [
                            'ticket_no' => $ticket->ticket_no,
                            'name' => $sm->name,
                        ]);
                        send_sms($sm->mobile, $msg);
                    }
                }

            }

            if (!empty($res_flag)) {
                $this->session->set_flashdata('flashOK', 'Ticket has been updated successfully');
                redirect('sm/serviceengineer/records');
            } else {
                $this->session->set_flashdata('flashError', 'Ticket update Failed');
                $srd_id = $this->input->post('srd_id');
                redirect('sm/serviceengineer/action/' . $srd_id);
            }
        } else {
            $this->session->set_flashdata('flashError', 'Ticket update Failed');
            $srd_id = $this->input->post('srd_id');
            redirect('sm/serviceengineer/action/' . $srd_id);
        }
    }

//=================== block job report =============================================
    public function job_report($id)
    {


        $data['comments'] = $this->Mod_serviceengineer->get_comments($id);
        $data['machine']  = $this->Mod_serviceengineer->get_equipment_data($id);

        $data['report'] = $this->Mod_serviceengineer->get_job_report_data($id);
        $data['spare']  = $this->Mod_serviceengineer->get_spare_parts_data($id);


        $report = $this->load->view('sm/serviceengineer/view_job_report', $data, true);


        $this->m_pdf->pdf->SetHTMLFooter('<div id="footer">
        
        <div class="row">
            <span class="footer-text"><b>CHITIAGONG OFFICE</b> : 125, K.B. Fozlul Koder Rood,3rd Floor Chowkbozor, Chifiogong, Phone: (031) 635883, Fox: {031} 635883 E\'moil : tvl\'etg@trodevision.com.bd</span>
        </div>
    </div>');

        $this->m_pdf->pdf->WriteHTML($report);


        $this->m_pdf->pdf->Output('job_report.pdf', "D");

        $this->load->view('sm/serviceengineer/view_job_report', $data);

    }


    public function upload_job_report($id)
    {

        $data['ticket_id'] = $id;
        $this->load->view('sm/serviceengineer/view_job_report_upload', $data);
    }

    public function save_job_report()
    {

        if ($_POST) {

            $ticket = $this->input->post('ticket_id');

            if (!empty($_FILES['report']['name'])) {
                $upload             = $this->_do_upload($ticket);
                $data['job_report'] = $upload;
            }

            $this->db->update('sm_service_request_dtl', $data, array('srd_id' => $ticket));

            echo json_encode(array("status" => TRUE));
        }

    }


    private function _do_upload($ticket)
    {

        $structure = './upload/job_report/' . $ticket;
        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }

        $config['upload_path']   = $structure;
        $config['allowed_types'] = '*';
        $config['max_size']      = 1024; //set max size allowed in Kilobyte
        $config['max_width']     = 2000; // set max width image allowed
        $config['file_name']     = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('report')) //upload and validate
        {
            $data['inputerror'][]   = 'report';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status']         = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

//===================================================================================================

    public function knowledge_base($id)
    {
        $data['ticket'] = $this->Mod_serviceengineer->get_ticket_data($id);
        $this->load->view('sm/serviceengineer/view_kb_post', $data);
    }

    public function save_kb()
    {
        if ($_POST) {

            $status   = array();
            $eng_id   = $this->session->userdata('engineer_auto_id');
            $datetime = date('Y-m-d');

            $this->_validate();

            $data = array(
                'ticket_ref_id'    => $this->input->post('ticket_id'),
                'ticket_ref_no'    => $this->input->post('ticket_no'),
                'problem_details'  => $this->input->post('comment'),
                'posted_by_eng_id' => $eng_id,
                'posted_date'      => $datetime
            );

            $insert = $this->Mod_serviceengineer->save_kb_post($data);

            if ($insert) {

                $status['status'] = TRUE;
            } else {

                $status['status'] = FALSE;
            }
            echo json_encode($status);
        }
    }


    private function _validate()
    {
        $data                 = array();
        $data['error_string'] = array();
        $data['inputerror']   = array();
        $data['status']       = TRUE;


        if ($this->input->post('comment') == '') {
            $data['inputerror'][]   = 'comment';
            $data['error_string'][] = 'Described Your Problem';
            $data['status']         = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }

    }

//============ knowledge base ==================================
    public function kb_list()
    {
        $data['knowledge'] = $this->Mod_serviceengineer->get_kb_list();
        $this->load->view('sm/serviceengineer/view_kb_list', $data);

    }

    //================== comments ====================
    public function comments($id)
    {

        $data['kb_post']     = $this->Mod_serviceengineer->get_kb_data_id($id);
        $data['kb_comments'] = $this->Mod_serviceengineer->get_comment_data($id);

        $data['knowledge'] = $this->Mod_serviceengineer->get_kb_data($id);
        $this->load->view('sm/serviceengineer/view_kb_comment', $data);
    }


    public function comment_save()
    {
        if ($_POST) {

            $status   = array();
            $eng_id   = $this->session->userdata('engineer_auto_id');
            $datetime = date('Y-m-d');

            $this->c_validate();

            $data = array(
                'base_ref_id'          => $this->input->post('kb_id'),
                'comment'              => $this->input->post('kb_comment'),
                'commented_by_eng_ref' => $eng_id,
                'comment_date'         => $datetime
            );

            $insert = $this->Mod_serviceengineer->save_kb_comment($data);

            if ($insert) {

                $status['status'] = TRUE;
            } else {

                $status['status'] = FALSE;
            }
            echo json_encode($status);
        }
    }


    private function c_validate()
    {
        $data                 = array();
        $data['error_string'] = array();
        $data['inputerror']   = array();
        $data['status']       = TRUE;


        if ($this->input->post('kb_comment') == '') {
            $data['inputerror'][]   = 'kb_comment';
            $data['error_string'][] = 'Comment is required';
            $data['status']         = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }

    }
}