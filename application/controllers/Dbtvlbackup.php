<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Dbtvlbackup extends CI_Controller
{
    
    protected $data;
    
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        parent::__construct();
    }
    
    public function index()
    {		
		$db_load = $this->load->database('icel',TRUE);
        //  echo '<pre>';print_r($db_load); die();
		$db_name = "trvl";
        $year = date('Y');
		$month = date('M');
        $folder_name = "tvl_live/$year/$month";
		$datetime = date("Y-m-d-H-i-s");
        $fileName = "$datetime-$db_name.zip";
        $this->load->dbutil();
        $prefs = array(
            'tables'      => array(),           			// Array of tables to backup.
            'ignore'      => array(),           			// List of tables to omit from the backup
            'format'      => 'zip',             			// gzip, zip, txt
            'filename'    => "$datetime-$db_name.sql",    	// File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'    => TRUE,              			// Whether to add DROP TABLE statements to backup file
            'add_insert'  => TRUE,              			// Whether to add INSERT data to backup file
            'newline'     => "\n"               			// Newline character used in backup file
        );
        $ftpLocalpath = 'uploads/backup/';
		if ( ! file_exists($ftpLocalpath) )
		{
			$create = mkdir($ftpLocalpath, 0777);
			if ( ! $create)
				return false;
		}
			
        $backup = $this->dbutil->backup($prefs);	
		$dbs = $this->dbutil->list_databases();
		
        $save = $ftpLocalpath.$fileName;
        $this->load->helper('file');
		write_file($save, $backup);
		
		
	/******************** CONNECT TO SPACES API ****************************/
		$this->key = "DO007T9KJV9EZZ9T8KT7";
		$this->secret = "SiNKb1OSWuzgVoSxRdkPHx9Z8OXjNZQ8cPdMnyJsoj8";
		$this->space_name = "bigmspace";
		$this->region = "sgp1";
        
        require_once("spaces-api/spaces.php");
		$space = new SpacesConnect($this->key, $this->secret, $this->space_name, $this->region);

        $path_on_space_db = "customer_backup/$folder_name/$fileName";

        if($space->uploadFile($save, "private", $path_on_space_db )){
            unlink($save);
        }
    }
    
    
}
