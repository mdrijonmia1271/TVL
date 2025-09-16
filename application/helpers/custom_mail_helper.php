<?php
if (!function_exists('send_new_ticket_mail')) {
    function send_new_ticket_mail($arr) {
         $sender_email = get_mail_sender_email();
    }
}

if (!function_exists('send_new_ticket_sms')) {
    function send_new_ticket_sms($arr) {
        try {
        $text= urlencode("New Support Request Ticket has been submitted. Ticket NO. is ".$arr['ticket_no']);
        //$t = file_get_contents("http://api.kushtia.com/sendsms/plain?user=BMRL&password=62Slrfcq&sender=DPDC&SMSText=".$text."&GSM=008801811409732");                //008801734008903    
        } catch (Exception $exc) {
            
        }

    }
}
if (!function_exists('send_sms_to_service_eng')) {

    function send_sms_to_service_eng($arr) {
        
    }

}


if (!function_exists('is_send_email')) {

    function is_send_email() {
        $CI = & get_instance();
        return $CI->config->item('is_send_email');
    }

}

if (!function_exists('is_send_sms')) {

    function is_send_sms() {
        $CI = & get_instance();
        return $CI->config->item('is_send_sms');
    }

}


if (!function_exists('get_mail_sender_email')) {

    function get_mail_sender_email() {
        $CI = & get_instance();
        return $CI->config->item('mail_sender_email');
    }

}