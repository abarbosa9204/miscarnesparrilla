<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');
*/
require_once $pluginPath . "/helpers/DBManager.php";
abstract class DBManagerModel extends DBManager{
        public $mail;
        
        function __construct() {
            parent::__construct();
            
        }
        
        public function sendAssignedMail($user, $id, $type){
           
        }
        
        public function formatDate($date){
            $dateParts = array();
            $dateFormated = $date;
            if(substr_count($date, '/') > 0){
                $dateParts = explode("/",$date);
                $dateFormated = $dateParts[2]."-".$dateParts[0]."-".$dateParts[1];
            }
            return $dateFormated;
        }
        
        function __destruct() {}
        
	abstract protected function getList($params = array());
	abstract protected function add();
	abstract protected function edit();
	abstract protected function del();
        abstract protected function detail();
}
?>
