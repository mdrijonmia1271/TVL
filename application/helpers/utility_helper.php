<?php

if (!function_exists('global_image_url')) {

    function global_image_url()
    {
        $CI = &get_instance();
        return $CI->config->slash_item('global_image_url');
    }

}

function check_admin_login()
{
    $CI             = &get_instance();
    $is_admin_login = $CI->session->userdata('is_admin_login');

    if ($is_admin_login == false) {
        redirect(base_url() . 'sm/customer/login');
    } else {
        return true;
    }
}

function get_division_by_id($id)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('DIVISION_ID,DIVISION_CODE,DIVISION_NAME');
    $query     = $sm_db->where('DIVISION_CODE', $id);
    $query     = $sm_db->get('divisions');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->DIVISION_NAME;
    } else {
        return false;
    }
}

function get_district_by_id($id)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('DISTRICT_ID,DISTRICT_CODE,DISTRICT_NAME');
    $query     = $sm_db->where('DISTRICT_ID', $id);
    $query     = $sm_db->get('districts');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->DISTRICT_NAME;
    } else {
        return false;
    }
}

function get_customer_name_by_id($id)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('name');
    $query     = $sm_db->where('customer_id', $id);
    $query     = $sm_db->get('customer');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->name;
    } else {
        return false;
    }
}


function get_customer_mobile_by_id($id)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('mobile');
    $query     = $sm_db->where('customer_id', $id);
    $query     = $sm_db->get('customer');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->mobile;
    } else {
        return false;
    }
}

function get_customer_email_by_id($id)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('email');
    $query     = $sm_db->where('customer_id', $id);
    $query     = $sm_db->get('customer');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->email;
    } else {
        return false;
    }
}

function get_customer_pic_by_id($id)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('picture');
    $query     = $sm_db->where('customer_id', $id);
    $query     = $sm_db->get('customer');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->picture;
    } else {
        return false;
    }
}

function get_engineer_name_by_id($id)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('name');
    $query     = $sm_db->where('ser_eng_id', $id);
    $query     = $sm_db->get('sm_service_engineer');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->name;
    } else {
        return false;
    }
}


function get_department_name_by_id($id)
{
    $ci = &get_instance();
    $ci->db->where('id', $id);
    $query     = $ci->db->get('medical_department');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->name;
    } else {
        return false;
    }
}

function get_admin_name_by_id($id)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('id,username');
    $query     = $sm_db->where('id', $id);
    $query     = $sm_db->get('sm_admin');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->username;
    } else {
        return false;
    }
}

function getServiceEngName($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('ser_eng_id,name');
    $query     = $sm_db->where('ser_eng_id', $id);
    $query     = $sm_db->get('sm_service_engineer');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->name;
    } else {
        return false;
    }
}

function get_service_eng_email($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('ser_eng_id,email');
    $query     = $sm_db->where('ser_eng_id', $id);
    $query     = $sm_db->get('sm_service_engineer');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->email;
    } else {
        return false;
    }
}

function get_service_eng_mobile($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('ser_eng_id,mobile');
    $query     = $sm_db->where('ser_eng_id', $id);
    $query     = $sm_db->get('sm_service_engineer');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->mobile;
    } else {
        return false;
    }
}

if (!function_exists('get_serviceeng_array')) {

    function get_serviceeng_array($id)
    {
        $ci    = &get_instance();
        $sm_db = $ci->load->database('icel', true); // database conection for read operation

//    $query = $sm_db->select('ser_eng_id,name');
        $query     = $sm_db->where('ser_eng_id', $id);
        $query     = $sm_db->get('sm_service_engineer');
        $total_row = $query->num_rows();
        if ($total_row > 0) {
            $ressult = $query->row();
            return $ressult;
        } else {
            return false;
        }

    }
}


function get_commenter_name_by_id($comment_from, $comments_by)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation
    if ($comment_from == 'se') {

        $query     = $sm_db->select('ser_eng_id,name');
        $query     = $sm_db->where('ser_eng_id', $comments_by);
        $query     = $sm_db->get('sm_service_engineer');
        $total_row = $query->num_rows();
        if ($total_row > 0) {
            $ressult = $query->row();
            return $ressult->name;
        } else {
            return false;
        }
    } else {
        if ($comment_from == 'c') {
            $query     = $sm_db->select('customer_id,name');
            $query     = $sm_db->where('customer_id', $comments_by);
            $query     = $sm_db->get('customer');
            $total_row = $query->num_rows();
            if ($total_row > 0) {
                $ressult = $query->row();
                return $ressult->name;
            } else {
                return false;
            }
        } else {
            if ($comment_from == 'a') {
                $query     = $sm_db->select('id,username');
                $query     = $sm_db->where('id', $comments_by);
                $query     = $sm_db->get('sm_admin');
                $total_row = $query->num_rows();
                if ($total_row > 0) {
                    $ressult = $query->row();
                    return $ressult->username;
                } else {
                    return false;
                }
            }
        }
    }
}


if (!function_exists('get_priority_array_dropdown')) {

    function get_priority_array_dropdown()
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_common');
        return $CI->Mod_common->get_priority_array_dropdown();
    }
}

if (!function_exists('get_priority_color_array')) {

    function get_priority_color_array()
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_common');
        return $CI->Mod_common->get_priority_color_array();
    }
}

if (!function_exists('get_service_type_array_dropdown')) {

    function get_service_type_array_dropdown($customer_auto_id = null)
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_common');
        return $CI->Mod_common->get_service_type_array_dropdown($customer_auto_id);
    }
}

if (!function_exists('get_service_task_name_array_dropdown')) {

    function get_service_task_name_array_dropdown($customer_id)
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_common');
        return $CI->Mod_common->get_service_task_name_array_dropdown($customer_id);
    }
}

if (!function_exists('get_customer_array_dropdown')) {

    function get_customer_array_dropdown()
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_common');
        return $CI->Mod_common->get_customer_array_dropdown();
    }
}

if (!function_exists('get_customer_array_dropdown_admin')) {

    function get_customer_array_dropdown_admin()
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_common');
        return $CI->Mod_common->get_customer_array_dropdown_admin();
    }
}

if (!function_exists('get_service_engineer_array')) {

    function get_service_engineer_array()
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_common');
        return $CI->Mod_common->get_service_engineer_array();
    }
}


if (!function_exists('support_cycle')) {

    function support_cycle()
    {

        $arr = array(
            ''   => 'Select',
            '1'  => '1 Month',
            '2'  => '2 Month',
            '3'  => '3 Month',
            '4'  => '4 Month',
            '5'  => '5 Month',
            '6'  => '6 Month',
            '7'  => '7 Month',
            '8'  => '8 Month',
            '9'  => '9 Month',
            '10' => '10 Month',
            '11' => '11 Month',
            '12' => '12 Month'
        );
        return $arr;
    }
}


if (!function_exists('ticket_status_array')) {

    function ticket_status_array()
    {
        $arr = array(
            ''  => 'Select',
            'P' => 'Pending',
            'W' => 'Working',
            'O' => 'On Progress',
            'A' => 'Complete',
            'C' => 'Cancel'
        );

        return $arr;
    }
}

/*
 * status array only for service enginner
 */
if (!function_exists('ticket_service_en_status_array')) {

    function ticket_service_en_status_array()
    {
        $arr = array(
            ''  => 'Select',
            'A' => 'Complete',
            'O' => 'On Progress'
        );

        return $arr;
    }
}


function get_relative_time($timestamp)
{
    $difference = time() - $timestamp;
    $periods    = array("sec", "min", "hour", "day", "week", "month", "years", "decade");
    $lengths    = array("60", "60", "24", "7", "4.35", "12", "10");

    if ($difference > 0) { // this was in the past
        $ending = "ago";
    } else { // this was in the future
        $difference = -$difference;
        $ending     = "to go";
    }
    for ($j = 0; $difference >= $lengths[$j]; $j++) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    if ($difference != 1) {
        $periods[$j] .= "s";
    }
    $text = "$difference $periods[$j] $ending";
    return $text;
}

function custom_pagination_param($param)
{

}


//SO============


function get_customer_status_approve($id, $sub_customer_id = null)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query = $sm_db->select('status');


    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    if ($sub_customer_id) $sm_db->where('is_sub_customer', $sub_customer_id);
    $sm_db->where('send_from', $id);
    $sm_db->where('status', 'A');
    $query     = $sm_db->get('sm_service_request_dtl');
    return $query->num_rows();
}

function get_customer_status_pending($id, $sub_customer_id = null)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));
    $sm_db->select('status');

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    if ($sub_customer_id) $sm_db->where('is_sub_customer', $sub_customer_id);
    $sm_db->where('send_from', $id);
    $sm_db->where('status', 'P');
    $query = $sm_db->get('sm_service_request_dtl');
    $query->num_rows();
    return $query->num_rows();
}

function get_customer_status_cancel($id, $sub_customer_id = null)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query = $sm_db->select('status');

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    if ($sub_customer_id) $sm_db->where('is_sub_customer', $id);
    $sm_db->where('send_from', $id);
    $sm_db->where('status', 'C');
    $query     = $sm_db->get('sm_service_request_dtl');

    return $query->num_rows();

}

function get_customer_status_working($id, $sub_customer_id = null)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    $query = $sm_db->select('status');

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    if ($sub_customer_id) $sm_db->where('is_sub_customer', $sub_customer_id);
    $sm_db->where('send_from', $id);
    $sm_db->where('status', 'W');
    $query     = $sm_db->get('sm_service_request_dtl');
    return $query->num_rows();

}


function get_customer_status_progress($id, $sub_customer_id = null)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    $sm_db->select('status');

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    if ($sub_customer_id) $sm_db->where('is_sub_customer', $sub_customer_id);
    $sm_db->where('send_from', $id);
    $sm_db->where('status', 'O');
    $query = $sm_db->get('sm_service_request_dtl');

    return $query->num_rows();

}


function get_engineer_status_working($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    $query = $sm_db->select('status');

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('status', 'W');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();

}


function get_engineer_status_progress($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    $query = $sm_db->select('status');

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }


    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('status', 'O');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();

}

function get_engineer_status_approve($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    $query = $sm_db->select('status');

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('status', 'A');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();

}

function get_engineer_status_pending($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    $query = $sm_db->select('status');

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('status', 'P');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();

}

function get_engineer_status_cancel($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('status');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('status', 'C');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();

}

//by mamun
function get_cus_total_ticket_status_wise($customer_id, $status)
{

    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('srd_id');
    $query     = $sm_db->where('send_from', $customer_id);
    $query     = $sm_db->where('status', $status);
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        return $total_row;
    } else {
        return 0;
    }
    return $query->num_rows();
}

//by mamun
function get_customer_details_customer_id($customer_id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation
    $res   = '';
    $query = $sm_db->where('customer_id', $customer_id);
    $query = $sm_db->get('customer');

    if ($query->num_rows() > 0) {
        $res = $query->row();
        return $res;
    } else {
        return $res;
    }
}

//=========JES

//====================Request Count======================================
function total_request_enginner($id)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}


function total_request_customer($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function sum_request_enginner()
{

    $ci     = &get_instance();
    $sm_db  = $ci->load->database('icel', true); // database conection for read operation
    $result = $sm_db->query("SELECT COUNT( * ) AS total,  `send_to` FROM  `sm_service_request_dtl`");

    return $result->result();
}

//====================Support TYPE ENGINEER======================================

function total_support_type_enginner_free($id)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('support_type');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('support_type', 'free');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_support_type_enginner_amc($id)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('support_type');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('support_type', 'amc');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_support_type_enginner_preventive($id)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('support_type');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('support_type', 'preventive');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_support_type_enginner_on_call($id)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('support_type');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('support_type', 'on_call');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

//====================Support TYPE CUSTOMER======================================

function total_support_type_customer_free($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('support_type');
    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('support_type', 'free');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_support_type_customer_amc($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('support_type');
    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('support_type', 'amc');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_support_type_customer_preventive($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('support_type');
    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('support_type', 'preventive');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_support_type_customer_on_call($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('support_type');
    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('support_type', 'on_call');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

//====================Priority Enginer======================================

function total_priority_enginner_normal($id)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('priority');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('priority', 'normal');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_priority_enginner_critical($id)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('priority');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('priority', 'critical');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_priority_enginner_nice($id)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('priority');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('priority', 'nice');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}


//====================Priority CUSTOMER======================================

function total_priority_customer_normal($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('priority');
    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('priority', 'normal');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_priority_customer_critical($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('priority');
    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('priority', 'critical');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}

function total_priority_customer_nice($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('priority');
    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('priority', 'nice');
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
}


//engineer

//====================Service Eng Total priority======================================
function get_total_priority_engineer($id, $priority)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('priority');
    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('priority', $priority);
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
//      return '2';
}


//==================== Service Eng Total Support TYPE======================================
function get_total_support_type_engineer($id, $support_type)
{//get_total_support_type
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation
    $query = $sm_db->select('send_to,support_type');


    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }

    $query     = $sm_db->where('send_to', $id);
    $query     = $sm_db->where('support_type', $support_type);
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
//      return '2';
}

//customer
//====================customer Total priority======================================
function get_total_priority_customer($id, $priority)
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('send_from,priority');
    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('priority', $priority);
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
//      return '2';
}


//==================== customer Total Support TYPE======================================
function get_total_support_type_customer($id, $support_type)
{//get_total_support_type
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $dob_year  = trim($ci->security->xss_clean($ci->input->post('dob_year')));
    $dob_month = trim($ci->security->xss_clean($ci->input->post('dob_month')));
    $date_from = trim($ci->security->xss_clean($ci->input->post('date_from')));
    $date_to   = trim($ci->security->xss_clean($ci->input->post('date_to')));

    $query = $sm_db->select('send_from,support_type');

    if (!empty($dob_year)) {
        $sm_db->where('YEAR(created_date_time)', $dob_year);
    }

    if (!empty($dob_month)) {
        $sm_db->where('MONTH(created_date_time)', $dob_month);
    }
    if (!empty($date_from)) {
        $star_date = date('Y-m-d 00:00:00', strtotime($date_from));
        $sm_db->where('created_date_time >=', $star_date);
    }
    if (!empty($date_to)) {
        $end_date = date('Y-m-d 23:59:59', strtotime($date_to));
        $sm_db->where('created_date_time <=', $end_date);
    }


    $query     = $sm_db->where('send_from', $id);
    $query     = $sm_db->where('support_type', $support_type);
    $query     = $sm_db->get('sm_service_request_dtl');
    $total_row = $query->num_rows();

    return $query->num_rows();
//      return '2';
}


//SO======================================================
function num_of_rows_support_type()
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('service_type_id,service_type_title');
    $query     = $sm_db->where('status', 'A');
    $query     = $sm_db->get('sm_service_type');
    $total_row = $query->num_rows();

    return $query->num_rows();
}


function get_support_type_name_by_id($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('service_type_title');
    $query     = $sm_db->where('service_type_id', $id);
    $query     = $sm_db->where('status', 'A');
    $query     = $sm_db->get('sm_service_type');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->service_type_title;
    } else {
        return false;
    }
}

function num_of_rows_priority()
{
    $ci        = &get_instance();
    $sm_db     = $ci->load->database('icel', true); // database conection for read operation
    $query     = $sm_db->select('priority_id');
    $query     = $sm_db->where('status', 'A');
    $query     = $sm_db->get('sm_service_priority');
    $total_row = $query->num_rows();

    return $query->num_rows();
}


function get_priority_name_by_id($id)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query     = $sm_db->select('priority_title');
    $query     = $sm_db->where('priority_id', $id);
    $query     = $sm_db->where('status', 'A');
    $query     = $sm_db->get('sm_service_priority');
    $total_row = $query->num_rows();
    if ($total_row > 0) {
        $ressult = $query->row();
        return $ressult->priority_title;
    } else {
        return false;
    }
}


function get_year_status_wise_total_ticket_for_admin($year, $status)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $query = $sm_db->select('`srd_id`');
    $query = $sm_db->where('YEAR(created_date_time)', $year);
    $query = $sm_db->where('status', $status);
    $query = $sm_db->get('sm_service_request_dtl');

    if ($query->num_rows() > 0) {
        return $query->num_rows();
    } else {
        return 0;
    }
}

function get_year_status_wise_total_ticket_for_cus($year, $status)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $customer_auto_id = $ci->session->userdata('customer_auto_id');

    $query = $sm_db->select('`srd_id`');
    $query = $sm_db->where('send_from', $customer_auto_id);
    $query = $sm_db->where('year', $year);
    $query = $sm_db->where('status', $status);
    $query = $sm_db->get('sm_service_request_dtl');

    if ($query->num_rows() > 0) {
        return $query->num_rows();
    } else {
        return 0;
    }
}

function get_year_status_wise_total_ticket_for_eng($year, $status)
{
    $ci    = &get_instance();
    $sm_db = $ci->load->database('icel', true); // database conection for read operation

    $engineer_auto_id = $ci->session->userdata('engineer_auto_id');

    $query = $sm_db->select('`srd_id`');
    $query = $sm_db->where('send_to', $engineer_auto_id);
    $query = $sm_db->where('year', $year);
    $query = $sm_db->where('status', $status);
    $query = $sm_db->get('sm_service_request_dtl');
    //echo $sm_db->last_db_query();
    //echo $sm_db->last_query();
    if ($query->num_rows() > 0) {
        return $query->num_rows();
    } else {
        return 0;
    }
}

if (!function_exists('get_ticket_dtl_trans_arr')) {

    function get_ticket_dtl_trans_arr($hidden_ticket_no)
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_manager');
        return $CI->Mod_manager->get_ticket_dtl_trans_arr($hidden_ticket_no);
    }
}


function get_pagination_paramter()
{
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

    return $config;
}

if (!function_exists('get_admin_active_customer_id_array')) {

    function get_admin_active_customer_id_array($adminid)
    {
        $CI =& get_instance();
        $CI->load->model('sm/Mod_common');
        return $CI->Mod_common->get_admin_active_customer_id_array($adminid);
    }
}


function rend_string($length = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        ceil($length / strlen($x)))), 1, $length);
}


function date_convert($date)
{

    $newDate = date("d M Y - h:i a", strtotime($date));

    return $newDate;
}


function format_change($date)
{
    $newDate = date("d M Y", strtotime($date));

    return $newDate;
}

//============ working lead time calculate ================

function working_lead_time($created, $location)
{

    $ci = &get_instance();

    $var1 = date("Y-m-d H:i:s", strtotime("{$created} +8 hours"));
    $var2 = date("Y-m-d 23:59:59");

    if ($location == "DHAKA") {

        if ($var1 > $var2) {
            $time          = 8 + 6;
            $new_date_time = date("Y-m-d h:i a", strtotime("{$created} +{$time} hours"));
            $lead_time     = date('d-m-Y h:i a', strtotime($new_date_time));
        } else {
            $time          = 8;
            $new_date_time = date("Y-m-d h:i a", strtotime("{$created} +{$time} hours"));
            $lead_time     = date('d-m-Y h:i a', strtotime($new_date_time));
        }
        return $lead_time;
    } elseif ($location != "DHAKA") {


        if ($var1 > $var2) {
            $time          = 72 + 18;
            $new_date_time = date("Y-m-d h:i a", strtotime("{$created} +{$time} hours"));
            $lead_time     = date('d-m-Y h:i a', strtotime($new_date_time));

        } else {
            $time          = 8;
            $new_date_time = date("Y-m-d h:i a", strtotime("{$created} +{$time} hours"));
            $lead_time     = date('d-m-Y h:i a', strtotime($new_date_time));
        }
        return $lead_time;
    }

}


function string_date($date)
{
    $val = date('d M Y', strtotime($date));
    return $val;
}


function get_service_manager()
{

    $ci = &get_instance();

    $ci->db->select('mobile manager');
    $ci->db->where('user_type', 'sm');
    $query = $ci->db->get('sm_admin');

    if ($query->num_rows() > 0) {
        return array_column($query->result_array(), 'manager');
    } else {
        return false;
    }
}

if (!function_exists('pmi_schedule_date')) {

    function pmi_schedule_date($id = null)
    {
        if ($id) {

            $ci = &get_instance();
            $ci->db->select('pmi_id,pmi_date');
            $ci->db->where('insb_ref_id', $id);
            $ci->db->where('pmi_date >=', date('Y-m-d'));
            $ci->db->where('pmi_date <=', date('Y-m-d', strtotime("+5 days")));
            $ci->db->order_by('pmi_date');
            $query = $ci->db->get('insb_pmi_trans', 1);
            if ($query->num_rows() == 1) {
                $pmi_date = $query->row()->pmi_date;

                return string_date($pmi_date);
            }
        }
        return false;
    }

}

if (!function_exists('random_num')) {

    function random_num()
    {
        $digits = 4;
        $min    = pow(10, $digits - 1);
        $max    = pow(10, $digits) - 1;
        return mt_rand($min, $max);
    }
}


if (!function_exists('send_sms')) {

    function send_sms($phone_number = null, $sms_body = null)
    {
        try {
            if (strlen($phone_number) == 11) {
                $MOBNUMBER = "88".$phone_number;
            }elseif (strlen($phone_number) == 10) {
                $MOBNUMBER = "880".$phone_number;
            }

            $sms_text = urlencode($sms_body);
            $sms_response =     file_get_contents('http://217.172.190.215/sendtext?apikey=0181285f46e846e9&secretkey=1f5e4eca&callerID=01969910557&toUser='.$MOBNUMBER.'&messageContent=' . $sms_text);

            $ci = &get_instance();
            $ci->db->insert('sm_sms_log', [
                'phone' => $phone_number,
                'message' => $sms_body
            ]);

            if (empty($sms_response)) {
                return "Nothing returned from url";
            } else {
                return true;
            }
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    // function send_sms($phone_number = null, $sms_body = null) {
    //     echo 'http://217.172.190.215/sendtext?apikey=0181285f46e846e9&secretkey=1f5e4eca&callerID=01969910557&toUser='.$phone_number.'&messageContent=' . $sms_body;
    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //       CURLOPT_URL => 'http://217.172.190.215/sendtext?apikey=0181285f46e846e9&secretkey=1f5e4eca&callerID=01969910557&toUser='.$phone_number.'&messageContent=' . $sms_body,
    //       CURLOPT_RETURNTRANSFER => true,
    //       CURLOPT_ENCODING => '',
    //       CURLOPT_MAXREDIRS => 10,
    //       CURLOPT_TIMEOUT => 0,
    //       CURLOPT_FOLLOWLOCATION => true,
    //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //       CURLOPT_CUSTOMREQUEST => 'GET',
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     return true;
    // }
}

function sms_log_write($mobile, $date)
{

    $myfile = fopen("sms_logs.txt", "a") or die("Unable to open file!");
    $txt = "Mobile No :" . $mobile . " " . "Date : " . $date . "\n";
    fwrite($myfile, $txt);
    fclose($myfile);
}


if (!function_exists('machine_support_info')) {

    function machine_support_info($customer_id, $machine_id)
    {
        $ci = &get_instance();

        $ci->db->select('su_type.*,service.service_type_title,install_base.insb_install_date,
                           install_base.insb_warranty_date');
        $ci->db->from('cust_support_type su_type');
        $ci->db->join('sm_service_type service', 'service.service_type_id = su_type.su_type_id', 'left');
        $ci->db->join('install_base', 'install_base.insb_id = su_type.install_base_ref_id', 'left');

        $ci->db->where('su_type.su_machine_id', $machine_id);
        $ci->db->where('su_type.su_cust_ref_id', $customer_id);
        $ci->db->where('su_type.status', 1);
        $ci->db->order_by('su_type.su_id', 'desc');
        $ci->db->limit(1);
        $query = $ci->db->get();
        return $query->row();
    }
}

if (!function_exists('num_total_pending_tickets')) {
    function num_total_pending_tickets($status = 'P')
    {
        $ci = &get_instance();
        $ci->db->select('count(*) as total');
        $ci->db->from('sm_service_request_dtl');
        $ci->db->where('status', $status);
        return $ci->db->get()->row()->total;
    }
}

if (!function_exists('num_total_pending_customer')) {
    function num_total_pending_customer($status = 'P')
    {
        $ci = &get_instance();
        $ci->db->select('count(*) as total');
        $ci->db->from('customer_sub_login');
        $ci->db->where('status is null');
        return $ci->db->get()->row()->total;
    }
}

function get_service_manager_player_id()
{

    $ci = &get_instance();

    $ci->db->select('player_id manager');
    $ci->db->where('user_type', 'sm');
    $query = $ci->db->get('sm_admin');

    if ($query->num_rows() > 0) {
        return array_column($query->result_array(), 'manager');
    } else {
        return false;
    }
}

function dd(...$data)
{
    foreach ($data as $val) {
        print_r('<pre>');
        print_r($val);
        print_r('</pre>');
    }
    die();
}


function send_push_notification($player_id = null, $message = null, $title = null, $app = null)
{

    $api_url       = "https://onesignal.com/api/v1/notifications";
    $mytvl_app_id  = "636c4f54-3116-4e1f-a83e-1ff52572af7e";
    $engtvl_app_id = "7228cf0c-dd13-4475-a461-fee857c529c9";

    $content = ["en" => $message];
    $heading = ["en" => $title];

    $fields = [
        'app_id'             => $app == 'eng' ? $engtvl_app_id : $mytvl_app_id,
        'include_player_ids' => [$player_id],
        'contents'           => $content,
        'headings'           => $heading
    ];

    $fields = json_encode($fields);
    //print("\nJSON sent:\n");
    //print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    //return $response;
}

if (!function_exists('get_temp_details')) {

    function get_temp_details($slap)
    {
        $ci = &get_instance();

        $ci->db->select('type, slap, message');
        $ci->db->from('message_template');

        $ci->db->where('slap', $slap);
        $ci->db->where('status', 1);
        $ci->db->limit(1);
        $query = $ci->db->get();
        return $query->row();
    }
}

if (!function_exists('message_format')) {

    function message_format($str, $data = [])
    {
        $final_message = $str;
        foreach ($data as $k => $v) {
            $final_message = str_replace('[$'.$k.']', $v, $final_message);
        }
        return $final_message;
    }
}
