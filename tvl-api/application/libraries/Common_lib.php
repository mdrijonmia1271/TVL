<?php
//if (!defined('BASEPATH'))    exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_lib {

    function __construct() {
        $this->obj = & get_instance();
    }

    function generate_image_upload_loc($image_id) {
        $loc = '';
        $img_id = $image_id;
        $formated_num = sprintf('%09d', $img_id);
        $loc_temp = str_split($formated_num, 3);
        $loc = implode('/', $loc_temp);
        return $loc;
    }

    function admin_user_pass_info() {
        $admin_info_array = array(
            'admin@bigm-bd.com'=> '123456',
        );
        return $admin_info_array;
    }

     function category_type_array(){
        $category_type_array = array(
            '' => 'Select',
            '1' => 'Yes',
            '0' => 'No',
            
        );
        return $category_type_array;
    }

    function designation_type_array(){
        $designation_type_array = array(
            '' => 'Select',
            '1' => 'Yes',
            '0' => 'No',
            
        );
        return $designation_type_array;
    }

     function cust_status_type_array(){
        $cust_status_type_array = array(
            '' => 'Select',
            '1' => 'Yes',
            '0' => 'No',
            
        );
        return $cust_status_type_array;
    }
    
    function get_user_age($birth_date) {
        return floor((time() - strtotime($birth_date)) / 31556926);
    }

    function generate_user_permalink($str) {
        setlocale(LC_ALL, 'en_US.UTF8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_| -]+/", '-', $clean);

        return $clean;
    }
    
    function get_year_array(){
        $year_array[''] = 'Year';
        for($i=2018;$i<=date("Y");$i++){
            $year_array[$i] = $i;
        }
        return $year_array;
    }
    
    function get_month_array(){
        $month_array = array(
            '' => 'Month',
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );
        return $month_array;
    }

    function get_day_array(){
        $day_array = array(
            '' => 'Day',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
            '24' => '24',
            '25' => '25',
            '26' => '26',
            '27' => '27',
            '28' => '28',
            '29' => '29',
            '30' => '30',
            '30' => '31',
        );
        return $day_array;
    }
    
    function get_medicine_type_array(){
        $array = array(
            '' => 'Select',
            '1' => 'Cap.',
            '2' => 'Tab.',
            '3' => 'Syp.',
            '4' => 'Inj.',
            '5' => 'Creme',
            '6' => 'Solution',
            '7' => 'Mixture',
			'10' => 'Ointment', 
			'11' => 'Drop',
        );
        return $array;
    }

	function get_age_cate_array(){
        $array = array(
            '' => 'Select',
            'Y' => 'Years',
            'M' => 'Months',
            'D' => 'Days',
        );
        return $array;
    }
	
    function get_status_array(){
        $array = array(
            '' => 'Select',
            '1' => 'Yes',
            '0' => 'No',
        );
        return $array;
    }
    
    function cust_has_email_phone_array(){
        $cust_has_email_phone_array = array(
            '' => 'Select',
            'E' => 'Has Email',
            'P' => 'Has Phone',
        );
        return $cust_has_email_phone_array;
    }
}