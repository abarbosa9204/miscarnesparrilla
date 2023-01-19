<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once dirname(__FILE__)."/../pluginConfig.php";
require_once(getPahtFile('wp-load.php') );

abstract class DBManager{
    public $conn;
    public $pluginPrefix;
    public $wpPrefix;
    public $pluginPath;
    public $currentUser;
    public $currentIntegrante;
    public $isRhAdmin;
    public $isSgAdmin; 
    protected $pluginURL;
    protected $query;
    protected $DBOper = array("table" => "", "data" => array(), "filter" => array());
    protected $totalRows;
    protected $queryType;
    protected $LastId;
    protected $result;
    protected $gbd;
    private $target_path;
    
    function __construct() {
            global $wpdb;
            global $pluginURL;
            global $pluginPath;
            global $prefixPlugin;
            global $current_user;
            $this->conn = $wpdb;
            $this->pluginURL = $pluginURL;
            $this->pluginPath = $pluginPath;
            $this->wpPrefix = $this->conn->prefix;
            $this->pluginPrefix = $this->wpPrefix;
            if(!empty($prefixPlugin)) $this->pluginPrefix .= $prefixPlugin;
            $this->target_path = $this->pluginPath."/files/";
            $this->currentUser = $current_user;            
            $query = "SELECT integranteId FROM ".$this->pluginPrefix."integrantesUsuarios i WHERE i.ID = ".$this->currentUser->ID;
            
            $result = $this->get($query,"var");
            $this->currentIntegrante = $result["data"];
            
            $this->isRhAdmin = ( in_array( "administrator", $this->currentUser->roles ) 
                                 || in_array( "admin_rh", $this->currentUser->roles ))? true : false;
            $this->isSgAdmin = ( in_array( "admin_sg", $this->currentUser->roles ))? true:false;
            $this->isGhAdmin = ( in_array( "admin_gh", $this->currentUser->roles ))? true:false; 
            
            $this->gbd = new PDO('mysql:host='.$this->conn->dbhost.';dbname='.$this->conn->dbname, $this->conn->dbuser, $this->conn->dbpassword);
    }
    

    function __destruct() {}

    public function getDataGrid($query = "SELECT 1 FROM dual", $start = null, $limit = null, $colSort = null, $sortDirection = null)
    {
            $this->queryType = (empty($this->queryType))? "rows" : $this->queryType;
            $queryBuild = $query;

            if($colSort != null)
                    $queryBuild .= " ORDER BY " . $colSort;

            if($sortDirection != null)
                    $queryBuild .= " " . $sortDirection;

            if($start != null && $limit != null)
                    $queryBuild .= " LIMIT " . $start . " , " . $limit;
//echo $queryBuild;
            return $this->get($queryBuild, $this->queryType);
    }

    protected function get($query, $type)
    {
            $this->query = $query;
            $this->queryType = $type;
            $this->execute();

            $array = array("totalRows" => $this->totalRows, "data" => $this->result);
            return $array;
    }   

    protected function getTotalRows() {
            $this->totalRows = $this->conn->get_var( "SELECT FOUND_ROWS() AS `found_rows`;" );
    }

    protected function standardQuery()
    {
            $q = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $this->query);
            $queryLen = strlen($q);
            if(substr($q, $queryLen - 1, 1) != ";")
                    $q = $q . ";";

            if(substr_count($q, "SELECT") > 0)
            {
                    $selectPos = stripos ( $q , "SELECT " ) + 6;
                    $q = "SELECT SQL_CALC_FOUND_ROWS " . substr ( $q , $selectPos, strlen($q));
            }

            $this->query = $q;
    }

    protected function executeQuery() {
            $this->standardQuery();
//echo $this->query;
            switch($this->queryType)
            {
                    case "var": $this->result = $this->conn->get_var( $this->query ); break;
                    case "row": $this->result = $this->conn->get_row($this->query, OBJECT); break;
                    case "rows":$this->result = $this->conn->get_results($this->query, OBJECT); break;
            }

            $this->getTotalRows();
    }

    protected function execute() {
        

        try {
               //   echo $this->query;
                switch($this->queryType)
                {
                    case "add": $this->result = $this->conn->insert( $this->DBOper["table"], $this->DBOper["data"]); $this->LastId = $this->conn->insert_id;$this->auditoria($this->LastId,$this->DBOper["table"], $this->DBOper["data"]);break;
                    case "edit": $this->result = $this->conn->update( $this->DBOper["table"], $this->DBOper["data"], $this->DBOper["filter"]); break;
                    case "del": $this->result = $this->conn->delete( $this->DBOper["table"], $this->DBOper["filter"]); break;
                    default: $this->executeQuery();
                }
                
                $queryFail = $this->conn->print_error();
                if(!empty($queryFail))
                    echo $queryFail . " - SQL:[".$this->conn->last_query."]";

                //echo $this->conn->last_query;
                $this->queryType = "";
            }
            catch (Exception $e)
            {
                $this->result = "Error: ".$e->getMessage();
            }
    }

    private function setFilter($field, $opString, $data){
        $op = "";
        switch($opString){
            case 'eq':  $op = " = '{data}'"; break;
            case 'ne':  $op = " <> '{data}'"; break;
            case 'lt':  $op = " < '{data}'"; break;
            case 'le':  $op = " <= '{data}'"; break;
            case 'gt':  $op = " > '{data}'"; break;
            case 'ge':  $op = " >= '{data}'"; break;
            case 'bw':  $op = " LIKE '%{data}'"; break;
            case 'bn':  $op = " NOT LIKE '%{data}'"; break;
            case 'in':  $op = " LIKE '%{data}%'"; break;
            case 'ni':  $op = " NOT LIKE '%{data}%'"; break;
            case 'ew':  $op = " LIKE '{data}%'"; break;
            case 'en':  $op = " NOT LIKE '{data}%'"; break;
            case 'cn':  $op = " LIKE '%{data}%'"; break;
            case 'nc':  $op = " NOT LIKE '%{data}%'"; break;
            case 'nu':  $op = " IS NULL"; break;
            case 'nn':  $op = " IS NOT NULL"; break;
            default: $op = "="; break;
        }
        return $field. (str_replace("{data}", $data, $op));
    }

    protected function buildWhere($data){
        $where = array();
         
        $LogicalOperator = $data->groupOp;
        $filters = $data->rules;

        if (is_array( $filters )){
            $countFilters = count($filters);
            for($i = 0; $i < $countFilters; $i++){
                $where[] = " ". $this->setFilter($filters[$i]->field, $filters[$i]->op, $filters[$i]->data);
            }
        }

        return implode($LogicalOperator, $where);
    }

    protected function addRecord($entity, $newRecord, $auditData){       
                
        if ( ! is_array( $newRecord ) || ! is_array( $auditData ))
            return false;

        $insert = false;
        
        $addData = $auditData;
        //echo $entity["tableName"]."<br>";
        foreach($entity["atributes"] as $key => $value){
            if((!array_key_exists("autoIncrement", $value) || !$value["autoIncrement"])
                && !array_key_exists($key, $addData)
                && (!array_key_exists("isTableCol", $value) || $value["isTableCol"])){
                $addData[$key] = empty($newRecord[$key])? null:$newRecord[$key];
                $insert = true;
            }
        }
        /*
         * Se realiza esta consulta por que si llega 0 envia un null y no se puede hacer la insercion
         */
        if(array_key_exists("documentoId",$addData)){
            if($addData["documentoId"]==null)
               $addData["documentoId"]="0"; 
        }
        if($insert){
            $this->queryType = "add";
            $this->DBOper["table"] = $entity["tableName"];
            $this->DBOper["data"]  = $addData;

            $this->execute();
        }
    }

    private function getCurrentRecord($entity, $filters){
        $cols = array();
        $where = array();
        $ws = array();
        $PK = array();
        
        $query = "SELECT {COLS} from ".$entity["tableName"]." WHERE {WHERE}";

        foreach($entity["atributes"] as $key => $value){

            if((!array_key_exists("isTableCol", $value) || $value["isTableCol"])
               && (!array_key_exists("autoIncrement", $value) || !$value["autoIncrement"]))
            $cols[] = $key;

            if(array_key_exists($key, $filters))
                $where[$key] = $filters[$key];
        }

        foreach($where as $key => $value){
            $ws[] = $key ." = ". $value;
        }

        $query = str_replace("{COLS}", (implode(",", $cols)), $query);
        $query = str_replace("{WHERE}", (implode(" AND ", $ws)), $query);
        
        $this->queryType = "row";
        $currentRecord = $this->getDataGrid($query);

        return array("currentRecord" => $currentRecord, "where" => $where);
    }

    protected function eliminateRecord($entity, $filters, $validate = null){
        $edit = true;
        $PK = array();
        $currentRecord = $this->getCurrentRecord($entity, $filters);

        if(is_array( $validate ) && array_key_exists("columnValidateEdit", $validate))
        {
            if($currentRecord["currentRecord"]["data"]->$validate["columnValidateEdit"] == $this->currentUser->ID){
                $edit = true;
            }
            else{
                $edit = false;
            }
        }

        if($edit){
            foreach($entity["atributes"] as $key => $value){

                if(array_key_exists("PK", $value))
                    $PK[] = $filters[$key];
            }
            $pkId = implode(",", $PK);

            foreach($currentRecord["currentRecord"]["data"] as $key => $value){
                $this->queryType = "add";
                $this->DBOper["table"] = $this->pluginPrefix."audit";
                $this->DBOper["data"] = array( 
                                            "table" => $entity["tableName"]
                                            ,"column" => $key
                                            ,"data" => stripslashes($value)
                                            ,"action" => "eliminate "
                                            ,"date" => date("Y-m-d H:i:s",time())
                                            ,"user" => $this->currentUser->user_login
                                            ,"PK" => $pkId
                                         );
                $this->execute();
            }

            $this->queryType = "del";
            $this->DBOper = array();
            $this->DBOper["table"] = $entity["tableName"];
            $this->DBOper["filter"] = $filters;
            $this->execute();
        }
    } 
    
    protected function delRecord($entity, $filters, $validate = null){
        $edit = true;
        $PK = array();
        $currentRecord = $this->getCurrentRecord($entity, $filters);

        if(is_array( $validate ) && array_key_exists("columnValidateEdit", $validate))
        {
            if($currentRecord["currentRecord"]["data"]->$validate["columnValidateEdit"] == $this->currentUser->ID){
                $edit = true;
            }
            else{
                $edit = false;
            }
        }

        if($edit){
            foreach($entity["atributes"] as $key => $value){

                if(array_key_exists("PK", $value))
                    $PK[] = $filters[$key];
            }
            $pkId = implode(",", $PK);

            foreach($currentRecord["currentRecord"]["data"] as $key => $value){
                $this->queryType = "add";
                $this->DBOper["table"] = $this->pluginPrefix."audit";
                $this->DBOper["data"] = array( 
                                            "table" => $entity["tableName"]
                                            ,"column" => $key
                                            ,"data" => stripslashes($value)
                                            ,"action" => "del"
                                            ,"date" => date("Y-m-d H:i:s",time())
                                            ,"user" => $this->currentUser->user_login
                                            ,"PK" => $pkId
                                         );

                $this->execute();
            }

            $this->queryType = "edit";
            $this->DBOper["data"]  = array("deleted" => 1);
            $this->DBOper["table"] = $entity["tableName"];
            $this->DBOper["filter"] = $filters;
            $this->execute();
        }
    }

    protected function updateRecord($entity, $newRecord, $filters, $validate = null){
       
        if ( ! is_array( $newRecord ) || ! is_array( $filters ))
            return false;
        $edit = true;
        $updateData = array();
        $auditData = array();
        $PK = array();

        $currentRecord = $this->getCurrentRecord($entity, $filters);

        if(is_array( $validate ) && array_key_exists("columnValidateEdit", $validate))
        {
            if($currentRecord["currentRecord"]["data"]->$validate["columnValidateEdit"] == $this->currentUser->ID){
                $edit = true;
            }
            else{
                $edit = false;
            }
        }
        
        if($edit){
            foreach($entity["atributes"] as $key => $value){

                if(array_key_exists("PK", $value))
                    $PK[] = $newRecord[$key];

                if(stripslashes($newRecord[$key]) != $currentRecord["currentRecord"]["data"]->$key
                   && (!array_key_exists("isTableCol", $value) || $value["isTableCol"])
                   && (!array_key_exists("autoIncrement", $value) || !$value["autoIncrement"])
                   && (!array_key_exists("update", $value) || $value["update"]) ){
                    $updateData[$key] = stripslashes($newRecord[$key]);
                    $auditData[] = array( 
                                       "table" => $entity["tableName"]
                                       ,"column" => $key
                                       ,"data" => stripslashes($currentRecord["currentRecord"]["data"]->$key)
                                       ,"action" => "edit"
                                       ,"date" => date("Y-m-d H:i:s",time())
                                       ,"user" => $this->currentUser->user_login
                                    );
                }
            }
            if(count($updateData) > 0)
            {
                $pkId = implode(",", $PK);
                foreach($auditData as $key => $value){
                    $this->queryType = "add";
                    $this->DBOper["table"] = $this->pluginPrefix."audit";
                    $this->DBOper["data"] = $value;
                    $this->DBOper["data"]["PK"] = $pkId;

                    $this->execute();
                }
                               
                $this->queryType = "edit";
                $this->DBOper["table"] = $entity["tableName"];
                $this->DBOper["filter"] = $currentRecord["where"];
                $this->DBOper["data"]  = $updateData;
                
                $this->execute();
                return $updateData;
            }
        }
    }

    protected function uploadFile($fileName,$ext,$file,$sg=null){
        if(file_exists($file)){
            if($sg==null){
                if (!copy($file, $this->target_path.$fileName.".".$ext)) {
                    echo "Error al copiar $archivo...\n";
                }
            }
            if($sg==1){
                if (!copy($file, $this->pluginPath."/filesSG/".$fileName.".".$ext)) {
                    echo "Error al copiar $archivo...\n";
                }
            }
            if($sg==2){
                if (!copy($file, $this->pluginPath."/filesDI/".$fileName.".".$ext)) {
                    echo "Error al copiar $archivo...\n";
                }
            }
            if($sg==3){
                if (!copy($file, $this->pluginPath."/filesHV/".$fileName.".".$ext)) {
                    echo "Error al copiar $archivo...\n";
                }
            }
            if($sg==4){
                if (!copy($file, $this->pluginPath."/filesTP/".$fileName.".".$ext)) {
                    echo "Error al copiar $archivo...\n";
                }
            }
            unlink($file);
        }
    }
        
    public function rendererFile($fileId, $return = false){
        ini_set("memory_limit","200M");
        if($fileId=="Reporte1" || $fileId=="Reporte2" || $fileId=="Reporte3" || $fileId=="Reporte4" || $fileId=="Reporte5" || $fileId=="Reporte6" || $fileId=="Reporte7" || $fileId=="Reporte8" || $fileId=="Reporte9" || $fileId=="Reporte10" || $fileId=="Reporte11" || $fileId=="Reporte12" || $fileId=="Reporte13" || $fileId=="Reporte14"){
            $this->descargarReporte($fileId);
        }
        else{
        try {          
                $arreglo = explode("-",$fileId);             
                if($arreglo[1]=="sg"){
                    $fileId=$arreglo[0];
                    $sg=1;
                    
                }
                
                
               $sql = "SELECT  IF(name='','archivo',name) name , ext, mime, size,fileName 
                             FROM ".$this->pluginPrefix."files f 
                            WHERE f.fileId = ".$fileId;
            
            
            
            $q = $this->gbd->prepare($sql);
            $q->execute();

            $q->bindColumn(1, $name);
            $q->bindColumn(2, $ext);
            $q->bindColumn(3, $mime);
            $q->bindColumn(4, $size);
            $q->bindColumn(5, $fileName);
            if($sg==1){              
                $arregloArchivo=explode(".",$fileName);                
            }
            while($q->fetch())
            {   if($sg==1){
                   /* cambiar ruta donde esta la carpeta*/
                   $fileDownload = $this->pluginPath."/filesSG/".$fileId.".".$ext;
                  
                   
                   $arregloArchivo=explode(".",$fileName);
                   $archivo="";
                   for($i=0;$i<count($arregloArchivo)-1;$i++){
                       $archivo.=$arregloArchivo[$i].".";
                       
                   }
                   $name = trim($archivo, '.');
                   $name=str_replace(" ", "", $name);
                }
                else
                   $fileDownload = $this->target_path.$fileId.".".$ext;
                
                
                if(file_exists($fileDownload)){
                    $fdata = file_get_contents($fileDownload);
                    if($return)
                        return array("mime" => $mime, "data" => $fdata);
                    else {
                       $archivo=$name.".".$ext; 
                       $user_agent = $_SERVER['HTTP_USER_AGENT']; 
                       header("Content-type: ". $mime);
                       header("Content-length: ". $size);
                       header("Content-Disposition: attachment; filename=\"$archivo\"");
                       ob_clean();
                       flush();
                       echo $fdata;
                       exit();
                         
                       
                       
                    }
                }
                else
                    echo "File not found";
            }
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        }
    }
    public function rendererFileAumento($fileId, $return = false){
         $name=  explode("Aumento_",$fileId);        
         $query = "SELECT identificacion
                 FROM ".$this->pluginPrefix."integrantes 
                 WHERE integranteId =".$name[1];
         global $wpdb;           
         $resultado = $wpdb->get_results($query);         
         $fileDownload = $this->pluginPath."/aumento/".$resultado[0]->identificacion.".pdf";
         $queryDescarga="UPDATE ".$this->pluginPrefix."aumento SET descargas=descargas+1 WHERE identificacion=".$resultado[0]->identificacion;
         $resultadoDescarga = $wpdb->get_results($queryDescarga);        
         $mime="application/pdf";
         if(file_exists($fileDownload)){
                    $size=filesize($fileDownload);
                     ini_set('memory_limit','32M');
                    $fdata = file_get_contents($fileDownload);
                    if($return)
                        return array("mime" => $mime, "data" => $fdata);
                    else {
                       header("Content-Type: ". $mime);
                       header("Content-Length: ". $size);                       
                       header("Content-Disposition: inline; filename=". $name[1]);
                       echo $fdata; 
                    }
                }
                else
                    echo "File not found";
     }
     public function rendererFile2($fileId, $return = false){
         $name=  explode("Seguridad",$fileId);
         $fileDownload = $this->pluginPath."/filesSeguridad/".$name[1];       
         $mime="application/pdf";
         if(file_exists($fileDownload)){
                    $size=filesize($fileDownload);
                     ini_set('memory_limit','32M');
                    $fdata = file_get_contents($fileDownload);
                    if($return)
                        return array("mime" => $mime, "data" => $fdata);
                    else {
			ob_clean();
                       header("Content-Type: ". $mime);
                       header("Content-Length: ". $size);                       
                       header("Content-Disposition: inline; filename=". $name[1]);
                       echo $fdata;
			flush(); 
                    }
                }
                else
                    echo "File not found";
     }
     public function rendererFile3($fileId, $return = false){
         $name=  explode("Nomina",$fileId);
         $fileDownload = $this->pluginPath."/nomina/".$name[1];       
         $mime="application/pdf";
         if(file_exists($fileDownload)){
                    $size=filesize($fileDownload);
                     ini_set('memory_limit','32M');
                    $fdata = file_get_contents($fileDownload);
                    if($return)
                        return array("mime" => $mime, "data" => $fdata);
                    else {
                       header("Content-Type: ". $mime);
                       header("Content-Length: ". $size);                       
                       header("Content-Disposition: inline; filename=". $name[1]);
                       echo $fdata; 
                    }
                }
                else
                    echo "File not found";
     }
     public function rendererFile4($nameaux, $return = false){ 
        $name=explode("_",$nameaux);  
        $fileDownload = $this->pluginPath."/certificacion/".$name[1]."_".$name[2]."_".$name[3]."_.pdf";       
        $mime="application/pdf";
        if(file_exists($fileDownload)){
            $size=filesize($fileDownload);
            ini_set('memory_limit','32M');
            $fdata = file_get_contents($fileDownload);
            if($return)
                return array("mime" => $mime, "data" => $fdata);
            else {
                header("Content-Type: ". $mime);
                header("Content-Length: ". $size);                       
                header("Content-Disposition: inline; filename=".$name[1]."_".$name[2]."_.pdf");
                echo $fdata; 
                    }
                }
                else
                    echo "File not found";
        
     }
     public function rendererFile5($nameaux, $return = false){ 
        $fileId=explode("-fc",$nameaux);
        $sql = "SELECT  IF(name='','archivo',name) name , ext, mime, size,fileName 
                             FROM ".$this->pluginPrefix."files f 
                            WHERE f.fileId = ".$fileId[0]; 
        
        $q = $this->gbd->prepare($sql);        
        $q->execute();      
        $q->bindColumn(1, $name);
        $q->bindColumn(2, $ext);
        $q->bindColumn(3, $mime);
        $q->bindColumn(4, $size);
        $q->bindColumn(5, $fileName);
         while($q->fetch()){            
             $fileDownload = $this->pluginPath."/filesDI/".$fileId[0].".".$ext; 
            if(file_exists($fileDownload)){
            $size=filesize($fileDownload);
            ini_set('memory_limit','32M');
            $fdata = file_get_contents($fileDownload);
            if($return)
                return array("mime" => $mime, "data" => $fdata);
            else {
                header("Content-Type: ". $mime);
                header("Content-Length: ". $size);                       
                header("Content-Disposition: inline; filename=".$fileId[0].".".$ext);
                echo $fdata; 
                    }
                }
                else
                    echo "File not found";
             
        }
        
        
     }
     public function rendererFile6($nameaux, $return = false){ 
        $fileId=explode("-fs",$nameaux);
        $sql = "SELECT  IF(name='','archivo',name) name , ext, mime, size,fileName 
                             FROM ".$this->pluginPrefix."files f 
                            WHERE f.fileId = ".$fileId[0]; 
        
        $q = $this->gbd->prepare($sql);        
        $q->execute();      
        $q->bindColumn(1, $name);
        $q->bindColumn(2, $ext);
        $q->bindColumn(3, $mime);
        $q->bindColumn(4, $size);
        $q->bindColumn(5, $fileName);
         while($q->fetch()){            
             $fileDownload = $this->pluginPath."/filesDI/".$fileId[0].".".$ext; 
            if(file_exists($fileDownload)){
            $size=filesize($fileDownload);
            ini_set('memory_limit','32M');
            $fdata = file_get_contents($fileDownload);
            if($return)
                return array("mime" => $mime, "data" => $fdata);
            else {
                header("Content-Type: ". $mime);
                header("Content-Length: ". $size);                       
                header("Content-Disposition: inline; filename=".$fileId[0].".".$ext);
                echo $fdata; 
                    }
                }
                else
                    echo "File not found";
             
        }
        
        
     }
    public function rendererFile7($nameaux, $return = false){ 
        $fileId=explode("-fo",$nameaux);
        $sql = "SELECT  IF(name='','archivo',name) name , ext, mime, size,fileName 
                             FROM ".$this->pluginPrefix."files f 
                            WHERE f.fileId = ".$fileId[0]; 
        
        $q = $this->gbd->prepare($sql);        
        $q->execute();      
        $q->bindColumn(1, $name);
        $q->bindColumn(2, $ext);
        $q->bindColumn(3, $mime);
        $q->bindColumn(4, $size);
        $q->bindColumn(5, $fileName);
         while($q->fetch()){            
             $fileDownload = $this->pluginPath."/filesDI/".$fileId[0].".".$ext; 
            if(file_exists($fileDownload)){
            $size=filesize($fileDownload);
            ini_set('memory_limit','32M');
            $fdata = file_get_contents($fileDownload);
            if($return)
                return array("mime" => $mime, "data" => $fdata);
            else {
                header("Content-Type: ". $mime);
                header("Content-Length: ". $size);                       
                header("Content-Disposition: inline; filename=".$fileId[0].".".$ext);
                echo $fdata; 
                    }
                }
                else
                    echo "File not found";
             
        }
        
        
     }
    public function rendererFile8($nameaux, $return = false){ 
        $fileId=explode("-fm",$nameaux);
        $sql = "SELECT  IF(name='','archivo',name) name , ext, mime, size,fileName 
                             FROM ".$this->pluginPrefix."files f 
                            WHERE f.fileId = ".$fileId[0]; 
        
        $q = $this->gbd->prepare($sql);        
        $q->execute();      
        $q->bindColumn(1, $name);
        $q->bindColumn(2, $ext);
        $q->bindColumn(3, $mime);
        $q->bindColumn(4, $size);
        $q->bindColumn(5, $fileName);
         while($q->fetch()){            
             $fileDownload = $this->pluginPath."/filesDI/".$fileId[0].".".$ext; 
            if(file_exists($fileDownload)){
            $size=filesize($fileDownload);
            ini_set('memory_limit','32M');
            $fdata = file_get_contents($fileDownload);
            if($return)
                return array("mime" => $mime, "data" => $fdata);
            else {
                header("Content-Type: ". $mime);
                header("Content-Length: ". $size);                       
                header("Content-Disposition: inline; filename=".$fileId[0].".".$ext);
                echo $fdata; 
                    }
                }
                else
                    echo "File not found";
             
        }
        
        
     }
     public function rendererFile9($nameaux, $return = false){ 
        $fileId=explode("-fa",$nameaux);
        $sql = "SELECT  IF(name='','archivo',name) name , ext, mime, size,fileName 
                             FROM ".$this->pluginPrefix."files f 
                            WHERE f.fileId = ".$fileId[0]; 
        
        $q = $this->gbd->prepare($sql);        
        $q->execute();      
        $q->bindColumn(1, $name);
        $q->bindColumn(2, $ext);
        $q->bindColumn(3, $mime);
        $q->bindColumn(4, $size);
        $q->bindColumn(5, $fileName);
         while($q->fetch()){            
             $fileDownload = $this->pluginPath."/filesDI/".$fileId[0].".".$ext; 
            if(file_exists($fileDownload)){
            $size=filesize($fileDownload);
            ini_set('memory_limit','32M');
            $fdata = file_get_contents($fileDownload);
            if($return)
                return array("mime" => $mime, "data" => $fdata);
            else {
                header("Content-Type: ". $mime);
                header("Content-Length: ". $size);                       
                header("Content-Disposition: inline; filename=".$fileId[0].".".$ext);
                echo $fdata; 
                    }
                }
                else
                    echo "File not found";
             
        }
        
        
     }
     public function rendererFile10($nameaux, $return = false){         
        $name=explode("perfil-",$nameaux);        
        $fileDownload = $this->pluginPath."/perfil/".$name[1];       
        $mime="application/pdf";
        if(file_exists($fileDownload)){
            $size=filesize($fileDownload);
            ini_set('memory_limit','32M');
            $fdata = file_get_contents($fileDownload);
            if($return)
                return array("mime" => $mime, "data" => $fdata);
            else {
                header("Content-Type: ". $mime);
                header("Content-Length: ". $size);                       
                header("Content-Disposition: inline; filename=".$name[1].".pdf");
                echo $fdata; 
                    }
                }
                else
                    echo "File not found";
        
     }
     public function rendererFile11($fileId, $return = false){
        $name= explode("-hv",$fileId);        
        $query = "SELECT *
                FROM wp_rh_files f 
                WHERE f.fileId =".$name[0];
        global $wpdb;           
        $resultado = $wpdb->get_results($query); 
        $ext = $resultado[0]->ext;        
        $fileDownload = $this->pluginPath."/filesHV/".$resultado[0]->fileId.".".$resultado[0]->ext;       
        $mime=$resultado[0]->mime;
        if(file_exists($fileDownload)){
                   $size=filesize($fileDownload);
                    ini_set('memory_limit','32M');
                   $fdata = file_get_contents($fileDownload);
                   if($return)
                       return array("mime" => $mime, "data" => $fdata);
                   else {
                    ob_clean();
                    header("Content-Type: ". $mime);
                    // header("Content-Type: application/vnd.ms-excel"); 
                    header("Content-Length: ". $size);                       
                     header("Content-Disposition: attachment; filename=".$fileId[0].".".$ext);
                     echo $fdata; 
                     flush();
                   }
               }
               else
                   echo "File not found";
    }


    public function rendererFile12($fileId, $return = false){
        $name= explode("-tp",$fileId);        
        $query = "SELECT *
                FROM wp_rh_files f 
                WHERE f.fileId =".$name[0];
        global $wpdb;           
        $resultado = $wpdb->get_results($query); 
        $ext = $resultado[0]->ext;        
        $fileDownload = $this->pluginPath."/filesTP/".$resultado[0]->fileId.".".$resultado[0]->ext;       
        $mime=$resultado[0]->mime;
        if(file_exists($fileDownload)){
                   $size=filesize($fileDownload);
                    ini_set('memory_limit','32M');
                   $fdata = file_get_contents($fileDownload);
                   if($return)
                       return array("mime" => $mime, "data" => $fdata);
                   else {
                    ob_clean();
                     header("Content-Type: ". $mime);
                     // header("Content-Type: application/vnd.ms-excel"); 
                     header("Content-Length: ". $size);                       
                      header("Content-Disposition: attachment; filename=".$fileId[0].".".$ext);
                      echo $fdata; 
                      flush();
                   }
               }
               else
                   echo "File not found";
    }
    public function descargarReporte($id){       
        $ext="xls";
        $mime="application/vnd.ms-excel";       
        if(file_exists($this->target_path.$id.".".$ext)){
            unlink($this->target_path.$id.".".$ext);
        }
        echo "Hola";
        switch($id){
            CASE "Reporte1":$query="SELECT (i.identificacion+0) identificacion,activo,i.nombre,i.apellido,genero,rh,fechaNacimiento,
            telefono 'celularPersonal',celular,email,emailPersonal,c1.ciudad 'ciudadResidencia',
            localidad,barrio,direccion,estrato,alergia,alergias,tallaCamisa,
            tallaPantalon,tallaZapatos,empresa,unidad,cargo,
            c2.ciudad ciudadSede,reintegrado,cuantasVecesReintegrado,tipoContratacion,
            fondoCesantias,eps,afp,cajaCompensacion,riesgoLaboral,factorRiesgo,
            t1.talento talento1,t2.talento talento2,t3.talento talento3,t4.talento talento4,t5.talento talento5,
            tipoVivienda,poseeVehiculo,tipoVehiculo,
            claseVehiculo,medioTransporte,tiempoTrayecto,perfil.total,telefono_ext
            FROM wp_rh_integrantes i
            INNER JOIN wp_rh_ciudades c1              ON c1.ciudadId=i.ciudadRecidenciaId
            INNER JOIN wp_rh_rh rh                    ON rh.rhId=i.rhId
            LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId
            LEFT JOIN wp_rh_fondoCesantias fc         ON fc.fondoCesantiasId=id.fondoCesantiasId
            LEFT JOIN wp_rh_epss ep                   ON ep.epsId=id.epsId
            LEFT JOIN wp_rh_afps afp                  ON afp.afpId=id.afpId
            LEFT JOIN wp_rh_cajaCompensacion caja     ON caja.cajaCompensacionId=id.cajaCompensacionId
            LEFT JOIN wp_rh_riesgoLaboral rl          ON rl.riesgoLaboralId=id.riesgoLaboralId
            LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
            LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
            LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
            LEFT JOIN wp_rh_integrantesTalentos it    ON it.integranteId=i.integranteId
            LEFT JOIN wp_rh_talentos t1               ON t1.talentoId=it.talento1
            LEFT JOIN wp_rh_talentos t2               ON t2.talentoId=it.talento2
            LEFT JOIN wp_rh_talentos t3               ON t3.talentoId=it.talento3
            LEFT JOIN wp_rh_talentos t4               ON t4.talentoId=it.talento4
            LEFT JOIN wp_rh_talentos t5               ON t5.talentoId=it.talento5
            INNER JOIN (
                        SELECT it.integranteId
, ((CASE WHEN it.fechaNacimiento IS NULL OR it.fechaNacimiento = '1990-01-01' OR it.fechaNacimiento = '' THEN 0 ELSE 5 END 
+ CASE WHEN it.celular IS NULL OR it.celular = 'NA' OR it.celular = ''  THEN 0 ELSE 5 END 
+ CASE WHEN it.emailPersonal IS NULL OR it.emailPersonal = 'NA' OR it.emailPersonal='' THEN 0 ELSE 5 END 
+ CASE WHEN it.barrio IS NULL OR it.barrio = 'NA' OR it.barrio = '' THEN 0 ELSE 5 END 
+ CASE WHEN it.direccion IS NULL OR it.direccion = 'NA' OR it.direccion = '' THEN 0 ELSE 10 END 
+ CASE WHEN a.T < 1 OR a.T IS NULL OR a.T='' THEN 0 ELSE 15 END                   
+ CASE WHEN l.T < 1 OR l.T IS NULL OR l.T='' THEN 0 ELSE 15 END 
+ CASE WHEN f.T < 1 OR f.T IS NULL OR f.T='' THEN 0 ELSE 10 END 
+ CASE WHEN h.T < 1 OR h.T IS NULL OR h.T='' THEN 0 ELSE 5 END 
+ CASE WHEN c.T < 1 OR c.T IS NULL OR c.T='' THEN 0 ELSE 5 END
+ CASE WHEN fa.T < 1 OR fa.T IS NULL THEN 0 ELSE 10 END                     
+ CASE WHEN hv.T < 1 OR hv.T IS NULL THEN 0 ELSE 10 END 
))  total
FROM 
wp_rh_integrantes it
        LEFT JOIN (
                    SELECT integranteId, COUNT(1) T FROM wp_rh_infoAcademica
                    GROUP BY integranteId
                        ) a ON a.integranteId = it.integranteId
        LEFT JOIN (
                    SELECT integranteId, COUNT(1) T FROM wp_rh_infoLaboral
                    GROUP BY integranteId
                            ) l ON l.integranteId = it.integranteId
         LEFT JOIN (
                  SELECT integranteId, COUNT(1) T FROM wp_rh_familiares
                  GROUP BY integranteId
                           ) f ON f.integranteId = it.integranteId
        LEFT JOIN (
                 SELECT integranteId, COUNT(1) T FROM wp_rh_integrantesHobies
                 GROUP BY integranteId
                        ) h ON h.integranteId = it.integranteId
        LEFT JOIN (
                   SELECT integranteId, COUNT(1) T FROM wp_rh_integrantescontacto
                   
                   GROUP BY integranteId
                        ) c ON c.integranteId = it.integranteId
        LEFT JOIN (
                    SELECT integranteId, COUNT(1) T 
                  FROM wp_rh_filesInfoAcademica fia
               JOIN wp_rh_infoAcademica ia ON ia.infoAcademicaId = fia.infoAcademicaId
                    GROUP BY integranteId
                        ) fa ON fa.integranteId = it.integranteId                  
        LEFT JOIN (
                   SELECT integranteId, COUNT(1) T 
                   FROM wp_rh_filesinfohojadevida fih
               JOIN wp_rh_infohojadevida ih ON ih.infoHojadevidaId = fih.infoHojadevidaId
                    GROUP BY integranteId
                            ) hv ON hv.integranteId = it.integranteId
            LEFT JOIN (
               SELECT integranteId, COUNT(1) T FROM wp_rh_directorio
               GROUP BY integranteId
                   ) d ON d.integranteId = it.integranteId
     ) perfil ON perfil.integranteId=i.integranteId
     
                LEFT JOIN(SELECT integranteId,GROUP_CONCAT(telefono_ext SEPARATOR', ') telefono_ext
               FROM wp_rh_directorio                   	
      WHERE deleted=0  GROUP BY integranteId)
       directorio ON directorio.integranteId=i.integranteId	
      WHERE i.deleted=0  ORDER BY identificacion";          
                                                           
                           
                            global $wpdb;           
                            $resultado = $wpdb->get_results( $query );
                            $shtml="<table>
                                    <tr> 
                                        <td>IDENTIFICACION</td>
                                        <td>ACTIVO</td>
                                        <td>NOMBRE</td>
                                        <td>APELLIDO</td>                                        
                                        <td>GENERO</td>
                                        <td>RH</td>
                                        <td>FECHA NACIMIENTO</td>
                                        <td>CELULAR PERSONAL</td>
                                        <td>CELULAR</td>
                                        <td>EMAIL</td>
                                        <td>EMAIL PERSONAL</td>
                                        <td>CIUDAD RESIDENCIA</td>
                                        <td>LOCALIDAD</td>
                                        <td>BARRIO</td>
                                        <td>DIRECCION</td>
                                        <td>ESTRATO</td>
                                        <td>ALERGIA</td>
                                        <td>ALERGIAS</td>                                   
                                        <td>TALLA CAMISA</td>
                                        <td>TALLA PANTALON</td>
                                        <td>TALLA ZAPATOS</td>
                                        <td>EMPRESA</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO</td>
                                        <td>CIUDAD SEDE</td>
                                        <td>REINTEGRADO</td>
                                        <td>CUANTAS VECES REINTEGRADO</td>
                                        <td>TIPO CONTRATACION</td>
                                        <td>CESANTIAS</td>
                                        <td>EPS</td>
                                        <td>AFP</td>
                                        <td>CAJA COMPENSACION</td>
                                        <td>RIESGO LABORAL</td>
                                        <td>FACTOR RIESGO</td>
                                        <td>TALENTO 1</td>
                                        <td>TALENTO 2</td>
                                        <td>TALENTO 3</td>
                                        <td>TALENTO 4</td>
                                        <td>TALENTO 5</td>
                                        <td>TIPO VIVIENDA</td>
                                        <td>POSEE VEHICULO</td>
                                        <td>TIPO VEHICULO</td>
                                        <td>CLASE VEHICULO</td>
                                        <td>MEDIO TRANPORTE</td>
                                        <td>TIEMPO TRAYECTO</td>
                                        <td>PERFIL %</td>
                                        <td>EXTENSION</td>
                                  </tr>"; // Cabecera con nombres de campo                        
                            foreach ( $resultado as $fila ):
                                $nombre=utf8_decode($fila->nombre);
                                $apellido=utf8_decode($fila->apellido);
                                $ciudadResidencia=utf8_decode($fila->ciudadResidencia);
                                $localidad=utf8_decode($fila->localidad);
                                $barrio=utf8_decode($fila->barrio);
                                $direccion=utf8_decode($fila->direccion);
                                $alergias=utf8_decode($fila->alergias);
                                $empresa=utf8_decode($fila->empresa);
                                $unidad=utf8_decode($fila->unidad);
                                $cargo=utf8_decode($fila->cargo);
                                $ciudadSede=utf8_decode($fila->ciudadSede);
                                $fondoCesantias=utf8_decode($fila->fondoCesantias);
                                $eps=utf8_decode($fila->eps);
                                $afp=utf8_decode($fila->afp);
                                $cajaCompensacion=utf8_decode($fila->cajaCompensacion);
                                $talento1=utf8_decode($fila->talento1);
                                $talento2=utf8_decode($fila->talento2);
                                $talento3=utf8_decode($fila->talento3);
                                $talento4=utf8_decode($fila->talento4);
                                $talento5=utf8_decode($fila->talento5);                                
                                $shtml.="<tr>
                                            <td>$fila->identificacion</td>
                                            <td>$fila->activo</td>
                                            <td>$nombre</td>
                                            <td>$apellido</td>
                                            <td>$fila->genero</td>
                                            <td>$fila->rh</td>
                                            <td>$fila->fechaNacimiento</td>
                                            <td>$fila->telefono</td>
                                            <td>$fila->celular</td>
                                            <td>$fila->email</td>
                                            <td>$fila->emailPersonal</td>
                                            <td>$ciudadResidencia</td>
                                            <td>$localidad</td>
                                            <td>$barrio</td>
                                            <td>$direccion</td>
                                            <td>$fila->estrato</td>
                                            <td>$fila->alergia</td>
                                            <td>$alergias</td>
                                            <td>$fila->tallaCamisa</td>
                                            <td>$fila->tallaPantalon</td>
                                            <td>$fila->tallaZapatos</td>
                                            <td>$empresa</td>
                                            <td>$unidad</td>
                                            <td>$cargo</td>
                                            <td>$ciudadSede</td>
                                            <td>$fila->reintegrado</td>
                                            <td>$fila->cuantasVecesReintegrado</td>
                                            <td>$fila->tipoContratacion</td>
                                            <td>$fondoCesantias</td>
                                            <td>$eps</td>
                                            <td>$afp</td>
                                            <td>$cajaCompensacion</td>
                                            <td>$fila->riesgoLaboral</td>
                                            <td>$fila->factorRiesgo</td>
                                            <td>$talento1</td>
                                            <td>$talento2</td>
                                            <td>$talento3</td>
                                            <td>$talento4</td>                                           
                                            <td>$talento5</td>
                                            <td>$fila->tipoVivienda</td>
                                            <td>$fila->poseeVehiculo</td>
                                            <td>$fila->tipoVehiculo</td>                                       
                                            <td>$fila->claseVehiculo</td>
                                            <td>$fila->medioTransporte</td>
                                            <td>$fila->tiempoTrayecto</td>
                                            <td>$fila->total</td>
                                            <td>$fila->telefono_ext</td>
                                        
                                       </tr>";
                            endforeach;
                            break;
            CASE "Reporte2":$query="SELECT  (identificacion+0) identificacion
            ,i.nombre nombrei,i.apellido apellidoi
            ,c2.ciudad ciudadSede,empresa,unidad
            ,cargo,f.nombre,f.apellido
            ,f.genero,f.tipo ,f.fechaNacimiento
            ,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), f.fechaNacimiento)), '%Y')+0 edad
            ,ocupacion,escolaridadDescripcion
            ,CASE WHEN gradoEscolaridadId>11 THEN NULL ELSE gradoDescripcion END gradoDescripcion
            
    FROM wp_rh_integrantes i
    LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId                                    
    LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
    LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
    LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
    LEFT JOIN wp_rh_familiares f ON f.integranteId=i.integranteId AND f.deleted=0 AND i.deleted=0
    LEFT JOIN wp_rh_epss e ON e.epsId=f.epsId
    LEFT JOIN wp_rh_escolaridad es ON f.escolaridad=es.escolaridadId
    LEFT JOIN wp_rh_gradoEscolaridad g ON f.grado=g.gradoEscolaridadId
    WHERE i.activo='Si'
                                    ORDER BY identificacion";
                            global $wpdb;           
                            $resultado = $wpdb->get_results( $query );
                            $shtml="<table>
                                    <tr>
                                        <td>IDENTIFICACION INTEGRANTE</td>
                                        <td>NOMBRE INTEGRANTE</td>
                                        <td>APELLIDO INTEGRANTE</td>
                                        <td>CIUDAD SEDE</td>
                                        <td>EMPRESA</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO</td>
                                        <td>NOMBRE FAMILIAR</td>
                                        <td>APELLIDO FAMILIAR</td>
                                        <td>GENERO</td>
                                        <td>PARENTESCO</td>
                                        <td>FECHA NACIMIENTO</td>
                                        <td>EDAD</td>                                        
                                        <td>OCUPACION</td>
                                        <td>ESCOLARIDAD</td>
                                        <td>GRADO</td>
                                    </tr>";
                            foreach ( $resultado as $fila ):
                                $nombre=utf8_decode($fila->nombre);
                                $apellido=utf8_decode($fila->apellido);
                                $nombrei=utf8_decode($fila->nombrei);
                                $ciudadSede=utf8_decode($fila->ciudadSede);
                                $apellidoi=utf8_decode($fila->apellidoi);
                                $empresa=utf8_decode($fila->empresa);
                                $unidad=utf8_decode($fila->unidad);
                                $cargo=utf8_decode($fila->cargo);                                
                                $parentesco=utf8_decode($fila->tipo);
                                $escolaridad=utf8_decode($fila->escolaridadDescripcion);;
                                $grado=utf8_decode($fila->gradoDescripcion);
                                $ocupacion=utf8_decode($fila->ocupacion);
                                $shtml.="<tr>
                                            <td>$fila->identificacion</td>
                                            <td>$nombrei</td>
                                            <td>$apellidoi</td>
                                            <td>$ciudadSede</td>
                                            <td>$empresa</td>
                                            <td>$unidad</td>
                                            <td>$cargo</td>                                            
                                            <td>$nombre</td>                                            
                                            <td>$apellido</td>
                                            <td>$fila->genero</td>
                                            <td>$parentesco</td>
                                            <td>$fila->fechaNacimiento</td>
                                            <td>$fila->edad</td>                                         
                                            <td>$ocupacion</td>
                                            <td>$escolaridad</td> 
                                            <td>$grado</td>     
                                            <td>$fila->archivo</td>
                                       </tr>";
                            endforeach;
                            break;
            CASE "Reporte3":$query="SELECT (identificacion+0) identificacion,nombre,apellido,c2.ciudad ciudadSede,empresa,unidad,cargo,hobie,actividad FROM 
                                    wp_rh_integrantes i
                                    LEFT JOIN wp_rh_integrantesHobies ih ON ih.integranteId=i.integranteId AND ih.deleted=0 AND i.deleted=0
                                    LEFT JOIN wp_rh_tipoHobies th        ON th.tipoHobieId= ih.hobieId
                                    LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId                                    
                                    LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
                                    LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
                                    LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
                                    ORDER BY identificacion";
                            global $wpdb;           
                            $resultado = $wpdb->get_results( $query );
                            $shtml="<table>
                                    <tr>
                                        <td>IDENTIFICACION INTEGRANTE</td>
                                        <td>NOMBRE</td>
                                        <td>APELLIDO</td>
                                        <td>CIUDAD SEDE</td>
                                        <td>EMPRESA</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO</td>
                                        <td>HOBBIE</td>
                                        <td>ACTIVIDAD</td>                                        
                                    </tr>";
                            foreach ( $resultado as $fila ):                            
                                $hobbie=utf8_decode($fila->hobie);
                                $actividad=utf8_decode($fila->actividad);
                                $nombre=utf8_decode($fila->nombre);
                                $apellido=utf8_decode($fila->apellido);                                
                                $ciudadSede=utf8_decode($fila->ciudadSede);                               
                                $empresa=utf8_decode($fila->empresa);
                                $unidad=utf8_decode($fila->unidad);
                                $cargo=utf8_decode($fila->cargo); 
                                $shtml.="<tr>
                                            <td>$fila->identificacion</td>
                                            <td>$nombre</td>
                                            <td>$apellido</td>
                                            <td>$ciudadSede</td>
                                            <td>$empresa</td>
                                            <td>$unidad</td>
                                            <td>$cargo</td>
                                            <td>$hobbie</td>
                                            <td>$actividad</td>                                                                                      
                                       </tr>";
                            endforeach;
                            break;
            CASE "Reporte4":$query="SELECT (identificacion+0) identificacion,nombre,apellido,c2.ciudad ciudadSede,
            id.empresa empresaA,unidad,cargo.cargo cargo1,info.empresa empresaB,
            fechaIngreso,info.cargo cargo2,areaDesarrollo,fechaRetiro,
            CASE WHEN fileId is null THEN 'NO HAY ARCHIVO' ELSE 'EXISTE ARCHIVO' END archivo
            FROM wp_rh_integrantes i
            LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId                                    
            LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
            LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
            LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
            LEFT JOIN wp_rh_infoLaboral info ON info.integranteId=i.integranteId AND info.deleted=0   AND i.deleted=0                                 
            LEFT JOIN (SELECT infoLaboralId,MAX(fileId) fileId FROM wp_rh_filesInfoLaboral GROUP BY infoLaboralId) il ON il.infoLaboralId=info.infoLaboralId
            ORDER BY identificacion";
                            global $wpdb;           
                            $resultado = $wpdb->get_results( $query );
                            $shtml="<table>
                                    <tr>
                                        <td>IDENTIFICACION INTEGRANTE</td>                                        
                                        <td>NOMBRE</td>
                                        <td>APELLIDO</td>
                                        <td>CIUDAD SEDE</td>
                                        <td>EMPRESA ORGANIZACION</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO ORGANIZACION</td>
                                        <td>EMPRESA</td>
                                        <td>FECHA INGRESO</td>
                                        <td>CARGO</td>
                                        <td>AREA DESARROLLO</td>
                                        <td>FECHA RETIRO</td>
                                        <td>ARCHIVO</td>
                                    </tr>";
                            
                            foreach ( $resultado as $fila ):
                                $nombre=utf8_decode($fila->nombre);
                                $apellido=utf8_decode($fila->apellido);                                
                                $ciudadSede=utf8_decode($fila->ciudadSede);
                                $empresa1=utf8_decode($fila->empresaA);
                                $empresa2=utf8_decode($fila->empresaB);
                                $cargo1=utf8_decode($fila->cargo1);
                                $cargo2=utf8_decode($fila->cargo2);
                                $desarrollo=utf8_decode($fila->areaDesarrollo);
                                $unidad=utf8_decode($fila->unidad);
                                $shtml.="<tr>
                                            <td>$fila->identificacion</td>
                                            <td>$nombre</td>
                                            <td>$apellido</td>
                                            <td>$ciudadSede</td>
                                            <td>$empresa1</td>
                                            <td>$unidad</td>
                                            <td>$cargo1</td>
                                            <td>$empresa2</td>
                                            <td>$fila->fechaIngreso</td> 
                                            <td>$cargo2</td> 
                                            <td>$desarrollo</td>
                                            <td>$fila->fechaRetiro</td>
                                            <td>$fila->archivo</td>
                                       </tr>";
                            endforeach;
                            break;
            CASE "Reporte5":$query="SELECT (identificacion+0) identificacion,nombre,apellido,c2.ciudad ciudadSede,empresa,unidad,cargo,
                                    titulo,institucion,fechaTerminacion,nivelAcademico,
                                    CASE WHEN fileId is null THEN 'NO HAY ARCHIVO' ELSE 'EXISTE ARCHIVO' END archivo
                                    FROM wp_rh_integrantes i
                                    LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId                                    
                                    LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
                                    LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
                                    LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
                                    LEFT JOIN wp_rh_infoAcademica ia ON ia.integranteId=i.integranteId AND i.deleted=0 AND ia.deleted=0
                                    LEFT JOIN (SELECT infoAcademicaId,MAX(fileId) fileId FROM wp_rh_filesInfoAcademica GROUP BY infoAcademicaId) fia 
                                    ON fia.infoAcademicaId=ia.infoAcademicaId ORDER BY identificacion";
                            global $wpdb;           
                            $resultado = $wpdb->get_results( $query );
                            $shtml="<table>
                                    <tr>
                                        <td>IDENTIFICACION INTEGRANTE</td>
                                        <td>NOMBRE</td>
                                        <td>APELLIDO</td>
                                        <td>CIUDAD SEDE</td>
                                        <td>EMPRESA</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO</td>
                                        <td>TITULO</td>
                                        <td>INSTITUCION</td>
                                        <td>FECHA TERMINACION</td>
                                        <td>NIVEL ACADEMICO</td>
                                        <td>ARCHIVO</td>                                                                            
                                    </tr>";
                            foreach ( $resultado as $fila ):
                                $nombre=utf8_decode($fila->nombre);
                                $apellido=utf8_decode($fila->apellido);                                
                                $ciudadSede=utf8_decode($fila->ciudadSede);                               
                                $empresa=utf8_decode($fila->empresa);
                                $unidad=utf8_decode($fila->unidad);
                                $cargo=utf8_decode($fila->cargo); 
                                $titulo=utf8_decode($fila->titulo);                                
                                $institucion=utf8_decode($fila->institucion);
                                $nivelAcademico=utf8_decode($fila->nivelAcademico);
                                $shtml.="<tr>
                                            <td>$fila->identificacion</td>
                                            <td>$nombre</td>
                                            <td>$apellido</td>
                                            <td>$ciudadSede</td>
                                            <td>$empresa</td>
                                            <td>$unidad</td>
                                            <td>$cargo</td>
                                            <td>$titulo</td>
                                            <td>$institucion</td> 
                                            <td>$fila->fechaTerminacion</td> 
                                            <td>$nivelAcademico</td>                                             
                                            <td>$fila->archivo</td>
                                       </tr>";
                            endforeach;
                            break;
            CASE "Reporte6":$query="SELECT (identificacion+0) identificacion,nombre,apellido,c2.ciudad ciudadSede,empresa,unidad,cargo,
                                    idiomaDes,idiomaAux,hablado,escrito,escucha,
                                    CASE WHEN fileId is null THEN 'NO HAY ARCHIVO' ELSE 'EXISTE ARCHIVO' END archivo
                                    FROM wp_rh_integrantes i
                                    LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId                                    
                                    LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
                                    LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
                                    LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
                                    LEFT JOIN wp_rh_infoIdiomas ii ON ii.integranteId=i.integranteId AND i.deleted=0 AND ii.deleted=0
                                    LEFT JOIN wp_rh_idiomas idi ON idi.idiomaId=ii.idioma
                                    LEFT JOIN (SELECT infoIdiomaId,MAX(fileId) fileId FROM wp_rh_filesInfoIdiomas GROUP BY infoIdiomaId) fi ON fi.infoIdiomaId=ii.infoIdiomaId
                                    ORDER BY identificacion";
                            global $wpdb;           
                            $resultado = $wpdb->get_results( $query );
                            $shtml="<table>
                                    <tr>
                                        <td>IDENTIFICACION INTEGRANTE</td>
                                        <td>NOMBRE</td>
                                        <td>APELLIDO</td>
                                        <td>CIUDAD SEDE</td>
                                        <td>EMPRESA</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO</td>
                                        <td>IDIOMA</td>
                                        <td>IDIOMA OTRO</td>
                                        <td>HABLADO</td>
                                        <td>ESCRITO</td>
                                        <td>ESCUCHA</td>
                                        <td>ARCHVIO</td>
                                    </tr>";
                            foreach ( $resultado as $fila ):                            
                                $idioma=utf8_decode($fila->idiomaDes);                                
                                $idiomaAux=utf8_decode($fila->idiomaAux);
                                $nombre=utf8_decode($fila->nombre);
                                $apellido=utf8_decode($fila->apellido);                                
                                $ciudadSede=utf8_decode($fila->ciudadSede);                               
                                $empresa=utf8_decode($fila->empresa);
                                $unidad=utf8_decode($fila->unidad);
                                $cargo=utf8_decode($fila->cargo);
                               
                                $shtml.="<tr>
                                            <td>$fila->identificacion</td>
                                            <td>$nombre</td>
                                            <td>$apellido</td>
                                            <td>$ciudadSede</td>
                                            <td>$empresa</td>
                                            <td>$unidad</td>
                                            <td>$cargo</td>
                                            <td>$idioma</td>
                                            <td>$idiomaAux</td> 
                                            <td>$fila->hablado</td> 
                                            <td>$fila->escrito</td>
                                            <td>$fila->escucha</td>
                                            <td>$fila->archivo</td>
                                       </tr>";
                            endforeach;
                            break;
            /*CASE "Reporte7":$query="SELECT (identificacion+0) identificacion,nombre,apellido,c2.ciudad ciudadSede,empresa,unidad,cargo,
                                    redSocial,nick 
                                    FROM wp_rh_integrantes i
                                    LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId                                    
                                    LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
                                    LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
                                    LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
                                    LEFT JOIN wp_rh_IntegrantesRedesSociales irs ON irs.integranteId=i.integranteId AND i.deleted=0 AND irs.deleted=0
                                    LEFT JOIN wp_rh_redesSociales rs ON rs.redSocialId=irs.redSocialId 
                                    ORDER BY identificacion";
                            global $wpdb;           
                            $resultado = $wpdb->get_results( $query );
                            $shtml="<table>
                                    <tr>
                                        <td>IDENTIFICACION INTEGRANTE</td>
                                        <td>NOMBRE</td>
                                        <td>APELLIDO</td>
                                        <td>CIUDAD SEDE</td>
                                        <td>EMPRESA</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO</td>
                                        <td>RED SOCIAL</td>
                                        <td>NICK</td>                                        
                                    </tr>";
                            foreach ( $resultado as $fila ):                            
                                $idioma=utf8_decode($fila->idiomaDes);                                
                                $idiomaAux=utf8_decode($fila->idiomaAux);
                                $nombre=utf8_decode($fila->nombre);
                                $apellido=utf8_decode($fila->apellido);                                
                                $ciudadSede=utf8_decode($fila->ciudadSede);                               
                                $empresa=utf8_decode($fila->empresa);
                                $unidad=utf8_decode($fila->unidad);
                                $cargo=utf8_decode($fila->cargo);
                               
                                $shtml.="<tr>
                                            <td>$fila->identificacion</td>
                                            <td>$nombre</td>
                                            <td>$apellido</td>
                                            <td>$ciudadSede</td>
                                            <td>$empresa</td>
                                            <td>$unidad</td>
                                            <td>$cargo</td>
                                            <td>$fila->redSocial</td>
                                            <td>$fila->nick</td>                                             
                                       </tr>";
                            endforeach;
                            break;*/
            CASE "Reporte8":$query='SELECT identificacion,integranteId,nombre,apellido
                                    FROM wp_rh_integrantes i                    
                                    WHERE i.activo="Si" AND i.deleted=0 ';
                            global $wpdb;        
                            $resultado = $wpdb->get_results( $query );
                            
                            $integrante="";
                            $nombres="";
                            $identificacion="";
                            $shtml="<table border='1'>
                                    <tr> 
                                        <td rowspan='2'>Identificacion</td>
                                        <td rowspan='2'>Nombre</td>
                                        <td rowspan='2'>Apellido</td>                                        
                                        <td colspan='8'>Info Laboral</td>
                                        <td colspan='4'>Info Academica</td>
                                        <td colspan='6'>Info Idiomas</td>
                                    </tr>
                                    <tr>
                                        <td>Empresa</td>
                                        <td>Cargo</td>
                                        <td>Trabajo Actual</td>
                                        <td>Fecha de Ingreso</td>
                                        <td>Fecha de Retiro</td>
                                        <td>Tipo de Actividad</td>                                        
                                        <td>Area de Desarrollo</td>
                                        <td>Archivo Laboral</td>
                                        <td>Titulo</td>
                                        <td>Estado del Curso</td>
                                        <td>Fecha de Terminacion</td>
                                        <td>Archivo Academico</td>
                                        <td>Idioma</td>
                                        <td>Idioma Aux</td>
                                        <td>Hablado</td>
                                        <td>Escrito</td>
                                        <td>escucha</td>
                                        <td>Archivo de Idiomas</td>                              
                                     </tr>";
                            foreach ($resultado as $fila ){
                                $integrante=utf8_decode($fila->integranteId);                                
                                $identificacion=utf8_decode($fila->identificacion);
                                $nombre=utf8_decode($fila->nombre);
                                $apellido=utf8_decode($fila->apellido);
                                $queryLaboral=' SELECT (SELECT count(*) FROM wp_rh_infoLaboral WHERE integranteId='.$integrante.' AND deleted=0) total,il.integranteId,
                                                il.infolaboralId,empresa,cargo,fechaIngreso,fechaRetiro,tipoActividad,areaDesarrollo,actual,fl.fileId archivo
                                                FROM wp_rh_infoLaboral il
                                                LEFT JOIN wp_rh_filesInfoLaboral fl ON fl.infoLaboralId=il.infoLaboralId
                                                WHERE il.deleted=0  AND il.integranteId='.$integrante;
                                $resultadoLaboral = $wpdb->get_results($queryLaboral);
                                $tamanoLaboral=count($resultadoLaboral);
                                $queryAcademica='SELECT (SELECT count(*) FROM wp_rh_infoAcademica WHERE integranteId='.$integrante.' AND deleted=0) total,
                                                 ia.infoacademicaId,titulo,estadoCurso,fechaTerminacion,fa.fileId archivo
                                                 FROM wp_rh_infoAcademica ia
                                                 LEFT JOIN wp_rh_filesInfoAcademica fa ON fa.infoAcademicaId=ia.infoAcademicaId
                                                 WHERE ia.deleted=0  AND ia.integranteId='.$integrante;
                                
                                $resultadoAcademica = $wpdb->get_results($queryAcademica);         
                                
                                $tamanoAcademica=count($resultadoAcademica);
                                
                                $queryIdiomas='SELECT (SELECT count(*) FROM wp_rh_infoIdiomas WHERE integranteId='.$integrante.' AND deleted=0) total,ii.integranteId,
                                                 ii.infoIdiomaId,idiomaDes,idiomaAux,hablado,escrito,escucha,fi.fileId archivo
                                                 FROM wp_rh_infoIdiomas ii
                                                 INNER JOIN wp_rh_idiomas i ON i.idiomaId=ii.idioma
                                                 LEFT JOIN wp_rh_filesInfoIdiomas fi ON fi.infoIdiomaId=ii.infoIdiomaId
                                                 WHERE ii.deleted=0  AND ii.integranteId='.$integrante;
                                $resultadoIdioma=$wpdb->get_results($queryIdiomas);
                                $tamanoIdiomas=count($resultadoIdioma);
                                $tamanoGeneral=array($tamanoAcademica,$tamanoLaboral,$tamanoIdiomas);
                                for($i=0;$i<$tamanoGeneral[0];$i++){
                                    $shtml.='<tr><td>'.$identificacion.'</td><td>'.$nombre.'</td><td>'.$apellido.'</td>';
                                   if($resultadoLaboral[$i]){
                                       if(is_null($resultadoLaboral[$i]->archivo))
                                        $archivoLaboral="NO";
                                        else
                                        $archivoLaboral="SI";
                                         $shtml.='<td>'.utf8_decode($resultadoLaboral[$i]->empresa).'</td>'
                                               . '<td>'.utf8_decode($resultadoLaboral[$i]->cargo).'</td>'
                                               . '<td>'.utf8_decode($resultadoLaboral[$i]->actual).'</td>'
                                               . '<td>'.utf8_decode($resultadoLaboral[$i]->fechaIngreso).'</td>'
                                               . '<td>'.utf8_decode($resultadoLaboral[$i]->fechaRetiro).'</td>'
                                               . '<td>'.utf8_decode($resultadoLaboral[$i]->tipoActividad).'</td>'
                                               . '<td>'.utf8_decode($resultadoLaboral[$i]->areaDesarrollo).'</td>'                                            
                                               . '<td>'.$archivoLaboral.'</td>';
                                              
                                        
                                   }
                                   else{
                                        $shtml.='<td>NA</td>'
                                               . '<td>NA</td>'
                                               . '<td>NA</td>'
                                               . '<td>NA</td>'
                                               . '<td>NA</td>'
                                               . '<td>NA</td>'
                                               . '<td>NA</td>'                                            
                                               . '<td>Na</td>';
                                       
                                   }
                                   if($resultadoAcademica[$i]){
                                       if(is_null($resultadoAcademica[$i]->archivo))
                                        $archivoAcademica="NO";
                                        else
                                        $archivoAcademica="SI";
                                         $shtml.='<td>'.utf8_decode($resultadoAcademica[$i]->titulo).'</td>'
                                               . '<td>'.$resultadoAcademica[$i]->estadoCurso.'</td>'
                                               . '<td>'.$resultadoAcademica[$i]->fechaTerminacion.'</td>'                                                                                         
                                               . '<td>'.$archivoAcademica.'</td>';
                                   }
                                   else{
                                       $shtml.='<td></td>'
                                               . '<td></td>'
                                               . '<td></td>'                                                                                         
                                               . '<td></td>';
                                   }
                                    if($resultadoIdioma[$i]){                                        
                                       if(is_null($resultadoIdioma[$i]->archivo))
                                        $archivoIdioma="NO";
                                        else
                                        $archivoIdioma="SI";
                                         $shtml.='<td>'.utf8_decode($resultadoIdioma[$i]->idiomaDes).'</td>'
                                               . '<td>'.utf8_decode($resultadoIdioma[$i]->idiomaAux).'</td>'
                                               . '<td>'.utf8_decode($resultadoIdioma[$i]->hablado).'%</td>'
                                               . '<td>'.utf8_decode($resultadoIdioma[$i]->escrito).'%</td>'
                                               . '<td>'.utf8_decode($resultadoIdioma[$i]->escucha).'%</td>'  
                                               . '<td>'.$archivoIdioma.'</td>';
                                   }
                                   else{
                                       $shtml.='<td>NA</td>'
                                               . '<td>NA</td>'
                                               . '<td>NA</td>'
                                               . '<td>NA</td>'
                                               . '<td>NA</td>' 
                                               . '<td>NA</td>';
                                   }
                                    $shtml.='</tr>';
                                } 
                                
                            } 
                            
                            break;
            CASE "Reporte9":$directorio=  $this->pluginPath."/filesSeguridad/";
                             $ficheros  = scandir($directorio);
                             $shtml='<table border="1">
                                    <tr> 
                                       <td>CEDULA</td>
                                       <td>ARCHIVO</td>
                                       <td>CREADO EN LA INTRANET</td>
                                    </tr>';
                            foreach($ficheros as $indice){
                                $cadena_buscada   = '_';
                                $posicion_coincidencia = strpos($indice, $cadena_buscada);                 
                                if ($posicion_coincidencia !== false) {
                                $cedula=  explode("_", $indice);
                                $query="SELECT identificacion,count(identificacion) total FROM wp_rh_integrantes WHERE identificacion=".$cedula[0];
                                $resultado = $this->get($query, "row");
                                if($resultado["data"]->total==1)
                                    $existe="SI";
                                if($resultado["data"]->total==0)
                                    $existe="NO";
                                $shtml.='<tr><td>'.$cedula[0].'</td><td>'.$indice.'</td><td>'.$existe.'</td></tr>';
                                }
                            }                            
                            break;
            CASE "Reporte10":$query="SELECT  em.empresa,
                                             u.unidad,
                                             c.cargo,
                                             identificacion,
                                             nombre,
                                             apellido,
                                             pu.fecha_publicacion,
                                             ap.fecha_publicacion fa
                                             FROM wp_rh_aceptaPerfil ap
                                             INNER JOIN wp_rh_integrantes i ON i.integranteId=ap.integranteId
                                             INNER JOIN wp_rh_integrantesDetails id ON i.integranteId=id.integranteId
                                             INNER JOIN wp_rh_perfilCargo pc ON pc.perfilCargoId=ap.perfilCargoId
                                             INNER JOIN wp_rh_unidades u ON pc.unidad=u.unidadId
                                             INNER JOIN wp_rh_empresas em ON em.empresaId=pc.empresa
                                             INNER JOIN wp_rh_cargo c ON c.cargoId=pc.cargo
                                             INNER JOIN wp_rh_publicacion pu ON pu.perfilCargoId=pc.perfilCargoId";
                            global $wpdb;           
                            $resultado = $wpdb->get_results( $query );
                            $shtml="<table>
                                    <tr>
                                        <td>EMPRESA</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO</td>
                                        <td>IDENTIFICACION</td>
                                        <td>NOMBRE</td>                                        
                                        <td>APELLIDO</td>
                                        <td>FECHA PUBLICACION</td>
                                        <td>FECHA ACEPTACION</td>                                                                             
                                    </tr>";
                            foreach ( $resultado as $fila ):                            
                                $empresa=utf8_decode($fila->empresa);                                
                                $unidad=utf8_decode($fila->unidad);
                                $cargo=utf8_decode($fila->cargo);
                                $nombre=utf8_decode($fila->nombre);                                
                                $apellido=utf8_decode($fila->apellido); 
                                $identificacion=$fila->identificacion;
                                $fp=$fila->fecha_publicacion;
                                $fa=$fila->fa;
                                
                               
                                $shtml.="<tr>
                                            <td>$empresa</td>
                                            <td>$unidad</td>
                                            <td>$cargo</td>
                                            <td>$identificacion</td>    
                                            <td>$nombre</td>
                                            <td>$apellido</td>                                           
                                            <td>$fp</td>
                                            <td>$fa</td>
                                                                                        
                                       </tr>";
                            endforeach;
                            break;

            CASE "Reporte11":
            
            $query='SELECT perfilCargoId,
            e.empresa,
            u.unidad,
            c.cargo,
            integrantesCargo,
            misionCargo,
            pf.perfilFormacionDesc,
            f.area,
            requerimientosAdicionales,
            perfilExperienciaDesc,
            detalleExperiencia,
            habilidades,
            estado,
            sedeJefe,
            pSST.perfilSST,
            detallePerfil,
            pAC.perfilAC,
            detallePerfilAC,
            categoria,
            criteriosDeseables,
            observacionCriterios,
            equivalencia,
            observacionEquivalencia,
            pfc.perfilConocimientoDesc,
            activo 
            FROM wp_rh_perfilCargo pc
            LEFT JOIN wp_rh_empresas e ON e.empresaId=pc.empresa
            LEFT JOIN wp_rh_unidades u ON u.unidadId=pc.unidad
            LEFT JOIN wp_rh_cargo c ON c.cargoId=pc.cargo
            LEFT JOIN wp_rh_formacion f ON f.perfil=pc.perfilCargoId
            LEFT JOIN wp_rh_perfilFormacion pf ON pf.perfilFormacionId=f.perfilFormacionId
            LEFT JOIN wp_rh_perfilExperiencia pe ON pe.perfilExperienciaId=pc.experiencia
            LEFT JOIN (SELECT perfil perfilJefe,TRIM(BOTH "," FROM GROUP_CONCAT(IF(ji.deleted=0,CONCAT(c2.cargo,"(",sede,")"),"") )) sedeJefe FROM wp_rh_jefeInmediato ji
            LEFT JOIN wp_rh_cargo c2 ON c2.cargoId=ji.cargo
            GROUP BY perfil) jefeDes ON perfilJefe=pc.perfilCargoId                                    
            LEFT JOIN wp_rh_responsabilidadSST rSST ON rSST.perfil=pc.perfilCargoId
            LEFT JOIN wp_rh_perfilSST pSST ON rSST.perfilSST=pSST.perfilSSTId
            LEFT JOIN wp_rh_responsabilidadAC rAC ON rAC.perfil=pc.perfilCargoId
            LEFT JOIN wp_rh_perfilAC pAC ON rAC.perfilAC=pAC.perfilACId
            LEFT JOIN wp_rh_conocimientosa ca ON ca.perfil = pc.perfilCargoId
            LEFT JOIN wp_rh_perfilconocimientos pfc ON pfc.perfilConocimientoId=ca.perfilConocimientoId
            WHERE pc.deleted=0
            ORDER BY pc.perfilCargoId';
                
                          global $wpdb;           
                            $resultado = $wpdb->get_results( $query );

                        
                            $shtml="<table>
                                    <tr>
                                        <td>EMPRESA</td>
                                        <td>UNIDAD</td>
                                        <td>CARGO</td>                                       
                                        <td>MISION DEL CARGO</td>
                                        <td>HABILIDADES</td>
                                        <td>EDUCACION</td>
                                        <td>DETALLE EDUCACION</td>
                                        <td>REQUERIMIENTOS ADICIONALES</td>
                                        <td>INTEGRANTES A CARGO</td>
                                        <td>EXPERIENCIA</td>
                                        <td>DETALLE EXPERIENCIA</td>
                                        <td>ESTADO</td>
                                        <td>LIDER INMEDIATO</td>
                                        <td>RESPONSABILIDAD DEL CARGO</td>
                                        <td>PERFIL SST</td>
                                        <td>RESPONSABILIDAD SST</td>
                                        <td>PERFIL AC</td>
                                        <td>RESPONSABILIDAD AC</td>
                                        <td>CATEGORIA</td>
                                        <td>CRITERIOS DESEABLES</td>
                                        <td>OBSERVACION CRITERIOS</td>
                                        <td>EQUIVALENCIA</td>
                                        <td>OBSERVACION EQUIVALENCIA</td>
                                        <td>CONOCIMIENTOS ADICIONALES</td>
                                        <td>ESTADO CARGO</td>

                                                                                                                    
                                    </tr>";
                            foreach ( $resultado as $fila ):
                                $perfilId=$fila->perfilCargoId;
                                $empresa=htmlentities($fila->empresa);                                
                                $unidad=htmlentities($fila->unidad);
                                $cargo = htmlentities($fila->cargo);                                
                                $misionCargo=htmlentities($fila->misionCargo);
                                $habilidades=htmlentities($fila->habilidades);
                                $perfilFormacionDesc=htmlentities($fila->perfilFormacionDesc);
                                $detalleFormacion=htmlentities($fila->detalleFormacion);
                                $requerimientosAdicionales=htmlentities($fila->requerimientosAdicionales);
                                $perfilExperienciaDesc=htmlentities($fila->perfilExperienciaDesc);
                                $detalleExperiencia=htmlentities($fila->detalleExperiencia);
                                $estado=htmlentities($fila->estado);
                                $sedeJefe=htmlentities($fila->sedeJefe);
                                $queryResponsabilidades="SELECT * FROM wp_rh_responsabilidad WHERE deleted=0 AND perfil=".$perfilId;
                                $resultadoResponsabilidades = $wpdb->get_results( $queryResponsabilidades ); 
                                $responsabilidad="";                                
                                $perfilSST=htmlentities($fila->perfilSST);
                                $perfilAC=htmlentities($fila->perfilAC);
                                foreach ( $resultadoResponsabilidades as $filaResponsabilidad ):
                                    $responsabilidad.=htmlentities($filaResponsabilidad->responsabilidad." (Reporta a: ".$filaResponsabilidad->reportaId.") ,");
                                endforeach;
                                $responsabilidad=substr($responsabilidad,0,-1).".";
                                $responsabilidadSST=htmlentities($fila->detallePerfil);
                                $responsabilidadAC=htmlentities($fila->detallePerfilAC);
                                $categoria=htmlentities($fila->categoria);
                                $criteriosDeseables=htmlentities($fila->criteriosDeseables);
                                $observacionCriterios=htmlentities($fila->observacionCriterios);
                                $equivalencia=htmlentities($fila->equivalencia);
                                $observacionEquivalencia=htmlentities($fila->observacionEquivalencia);
                                $conocimientos=htmlentities($fila->conocimientos);
                                $activo=htmlentities($fila->activo);
                                //$responsabilidadSST=str_replace("<br>","\\n", $responsabilidadSST);                          
                                $shtml.="<tr>
                                            <td>$empresa</td>
                                            <td>$unidad</td>
                                            <td>$cargo</td>                                            
                                            <td>$misionCargo</td>
                                            <td>$habilidades</td>
                                            <td>$perfilFormacionDesc</td>
                                            <td>$detalleFormacion</td>
                                            <td>$requerimientosAdicionales</td>
                                            <td>$fila->integrantesCargo</td>
                                            <td>$perfilExperienciaDesc</td>
                                            <td>$detalleExperiencia</td>
                                            <td>$estado</td>
                                            <td>$sedeJefe</td>
                                            <td>$responsabilidad</td>
                                            <td>$perfilSST</td>
                                            <td>$responsabilidadSST</td>
                                            <td>$perfilAC</td>
                                            <td>$responsabilidadAC</td>
                                            <td>$categoria</td>
                                            <td>$criteriosDeseables</td>
                                            <td>$observacionCriterios</td>
                                            <td>$equivalencia</td>
                                            <td>$observacionEquivalencia</td>
                                            <td>$conocimientos</td>
                                            <td>$activo</td>
                                       </tr>";
                            endforeach;
                            break;
        CASE "Reporte12":$query='SELECT 
                                    i.integranteId,
                                    identificacion,
                                    activo,
                                    nombre,
                                    apellido ,
                                    valor as puntos,
                                    Q,
                                    periodo
                                FROM wp_rh_integrantes i
                                INNER JOIN wp_rh_cvc c ON c.integranteId=i.integranteId
                                ORDER BY CAST(identificacion AS unsigned)';
                                global $wpdb;           
                        $resultado = $wpdb->get_results( $query );
                        $shtml="<table>
                                    <tr>
                                        <td>IDENTIFICACION</td>
                                        <td>ACTIVO</td>
                                        <td>NOMBRE</td>                                       
                                        <td>APELLIDO</td>
                                        <td>PUNTOS</td>
                                        <td>Q</td>
                                        <td>PERIODO</td>
                                    </tr>";
                            foreach ( $resultado as $fila ):                            
                                $identificacion=$fila->identificacion;                                
                                $activo=$fila->activo;
                                $nombre = $fila->nombre;                                
                                $apellido=$fila->apellido;
                                $puntos=$fila->puntos;
                                $q=$fila->Q;
                                $periodo=$fila->periodo;                                                       
                                $shtml.="<tr>
                                            <td>$identificacion</td>
                                            <td>$activo</td>
                                            <td>$nombre</td>                                            
                                            <td>$apellido</td>
                                            <td>$puntos</td>
                                            <td>$q</td>
                                            <td>$periodo</td>                                            
                                       </tr>";
                            endforeach;
                            break;                     
                                                    
     CASE "Reporte13":$query="SELECT (identificacion+0) identificacion,nombre nombrei,apellido apellidoi,c2.ciudad ciudadSede,empresa,unidad,cargo,nombreContacto,apellidoContacto,
                            p.parentesco,celularContacto 
                            FROM 
                             wp_rh_integrantes i
                             LEFT JOIN wp_rh_integrantescontacto ic ON ic.integranteId=i.integranteId AND ic.deleted=0 
                             LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId
                             LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
                             LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
                             LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
                             LEFT JOIN wp_rh_parentesco p              ON p.parentescoId=ic.parentesco                                                                                           
                            ORDER BY identificacion";
                    global $wpdb;           
                    $resultado = $wpdb->get_results( $query );
                    $shtml="<table>
                            <tr>
                                <td>IDENTIFICACION INTEGRANTE</td>
                                <td>NOMBRE</td>
                                <td>APELLIDO</td>
                                <td>CIUDAD SEDE</td>
                                <td>EMPRESA</td>
                                <td>UNIDAD</td>
                                <td>CARGO</td>
                                <td>NOMBRE CONTACTO</td>
                                <td>APELLIDO CONTACTO</td>  
                                <td>PARENTESCO</td>
                                <td>CELULAR CONTACTO</td>                                      
                            </tr>";
                    foreach ( $resultado as $fila ):                            
                        $nombreContacto=utf8_decode($fila->nombreContacto);
                        $apellidoContacto=utf8_decode($fila->apellidoContacto);
                        $parentesco=utf8_decode($fila->parentesco);
                        $celularContacto=utf8_decode($fila->celularContacto);
                        $nombre=utf8_decode($fila->nombre);
                        $apellido=utf8_decode($fila->apellido);                                
                        $ciudadSede=utf8_decode($fila->ciudadSede);                               
                        $empresa=utf8_decode($fila->empresa);
                        $unidad=utf8_decode($fila->unidad);
                        $cargo=utf8_decode($fila->cargo); 
                        $shtml.="<tr>
                                    <td>$fila->identificacion</td>
                                    <td>$nombre</td>
                                    <td>$apellido</td>
                                    <td>$ciudadSede</td>
                                    <td>$empresa</td>
                                    <td>$unidad</td>
                                    <td>$cargo</td>
                                    <td>$nombreContacto</td>
                                    <td>$apellidoContacto</td>
                                    <td>$parentesco</td> 
                                    <td>$celularContacto</td>                                                                                       
                               </tr>";
                    endforeach;
                    break; 

                    CASE "Reporte14":$query="SELECT (identificacion+0) identificacion,nombre,apellido,c2.ciudad ciudadSede,
                    id.empresa empresaA,unidad,tarjetaProfesional,numeroTarjeta,e.entidad,fechaActualizacion,
                    
                    CASE WHEN fileId is null THEN 'NO HAY ARCHIVO' ELSE 'EXISTE ARCHIVO' END archivo,
                    CASE WHEN fileId1 is null THEN 'NO HAY ARCHIVO' ELSE 'EXISTE ARCHIVO' END archivoTarjeta
                    FROM wp_rh_integrantes i
                    LEFT JOIN wp_rh_integrantesDetails id     ON id.integranteId=i.integranteId                                    
                    LEFT JOIN wp_rh_ciudades c2               ON c2.ciudadId=id.ciudadSedeId
                    LEFT JOIN wp_rh_unidades u                ON u.unidadId=id.unidadId
                    LEFT JOIN wp_rh_cargo cargo               ON cargo.cargoId=id.cargoId
                    LEFT JOIN wp_rh_infohojadevida info ON info.integranteId=i.integranteId AND info.deleted=0   AND i.deleted=0                                 
                    LEFT JOIN wp_rh_entidad e						ON e.entidadId=info.entidad
                                LEFT JOIN (SELECT infoHojadevidaId,MAX(fileId) fileId 
                                FROM wp_rh_filesinfohojadevida 
                                GROUP BY infoHojadevidaId) ih ON ih.infoHojadevidaId=info.infoHojadevidaId
                                LEFT JOIN (SELECT infoHojadevidaId,MAX(fileId) fileId1
                                FROM wp_rh_filestarjeta
                                GROUP BY infoHojadevidaId) it ON it.infoHojadevidaId=info.infoHojadevidaId
                    ORDER BY identificacion";
                                    global $wpdb;           
                                    $resultado = $wpdb->get_results( $query );
                                    $shtml="<table>
                                            <tr>
                                                <td>IDENTIFICACION INTEGRANTE</td>                                        
                                                <td>NOMBRE</td>
                                                <td>APELLIDO</td>
                                                <td>CIUDAD SEDE</td>
                                                <td>EMPRESA ORGANIZACION</td>
                                                <td>UNIDAD</td>
                                                <td>TARJETA PROFESIONAL</td>
                                                <td>NUMERO TARJETA</td>
                                                <td>ENTIDAD</td>
                                                <td>FECHA ACTUALIZACION</td>
                                                <td>ADJUNTO HOJA DE VIDA</td>
                                                <td>ADJUNTO TARJETA</td>
                                            </tr>";
                                    
                                    foreach ( $resultado as $fila ):
                                        $nombre=utf8_decode($fila->nombre);
                                        $apellido=utf8_decode($fila->apellido);                                
                                        $ciudadSede=utf8_decode($fila->ciudadSede);
                                        $empresa=utf8_decode($fila->empresaA);
                                        $tarjetaProfesional=utf8_decode($fila->tarjetaProfesional);
                                        $numeroTarjeta=utf8_decode($fila->numeroTarjeta);
                                        $entidad=utf8_decode($fila->entidad);
                                        $unidad=utf8_decode($fila->unidad);
                                        $shtml.="<tr>
                                                    <td>$fila->identificacion</td>
                                                    <td>$nombre</td>
                                                    <td>$apellido</td>
                                                    <td>$ciudadSede</td>
                                                    <td>$empresa</td>
                                                    <td>$unidad</td>
                                                    <td>$tarjetaProfesional</td>
                                                    <td>$numeroTarjeta</td>
                                                    <td>$entidad</td> 
                                                    <td>$fila->fechaActualizacion</td> 
                                                    <td>$fila->archivo</td>
                                                    <td>$fila->archivoTarjeta</td>
                                               </tr>";
                                    endforeach;
                                    break;
            
        }
        
        $shtml.="</table>";
       // echo $shtml;
        $sfile=$this->target_path.$id.".".$ext; // Ruta del archivo a generar 
        $fp=fopen($sfile,"w"); 
        fwrite($fp,$shtml); 
        fclose($fp);                
        try{
            $fileDownload = $this->target_path.$id.".".$ext;             
            if(file_exists($fileDownload)){
                $fdata = file_get_contents($fileDownload);
                $size=filesize($fileDownload);                    
                header("Content-Type: ". $mime);               
                header("Content-Length: ". $size);                       
                header("Content-Disposition: attachment; filename=$id.$ext");
                ob_clean();
                echo $fdata;                    
            }
            else
                echo "File not found";
        }
        catch (PDOException $e){
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    protected function auditoria($id,$tabla,$data){
        $arreglo=array();
        $usuario=$data["created_by"];
        $date=$data["date_entered"];
        $login="";
        $query="SELECT user_login FROM wp_users WHERE ID=".$usuario;
        global $wpdb;
        $resultado = $wpdb->get_results( $query );
        foreach ( $resultado as $fila ):
            $login=$fila->user_login;
        endforeach;        
        if (array_key_exists('date_entered', $data)&& array_key_exists('created_by', $data)) {
            foreach ($data as $key => $value) {
                if($key!='date_entered' && $key!='created_by'){
                    $wpdb->insert('wp_rh_audit',array('table' =>$tabla,'PK' => $id,'column'=>$key,'data'=>$value,'action'=>'add','date'=>$date,'user'=>$login),array('%s','%d','%s','%s','%s','%s','%s'));
                    
                }
                
            }
            
        }
        
    }




}
?>
