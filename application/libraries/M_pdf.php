<?php
/**
 * Created by PhpStorm.
 * User: manjurul
 * Date: 5/24/18
 * Time: 10:26 AM
 */


if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf {

    public $param;
    public $pdf;
    public function __construct($param = "'c', 'A4-L'")
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }
}