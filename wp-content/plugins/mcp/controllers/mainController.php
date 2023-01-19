<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
class mainController //extends resources
{
    private $pluginPath = "";
    private $pluginURL = "";
    public $model;
    private $viewObject;
    private $prefix;
    private $PrefixPlugin;
    private $controllerName;
    private $headScripts = array();
    private $resource;
    function __construct($controller = "basic", $showView = true) {

        global $prefixPlugin;
        global $pluginURL;
        global $pluginPath;
        global $resource;
        $this->prefix = $prefixPlugin;
        $this->pluginURL = $pluginURL;
        $this->pluginPath = $pluginPath;
        $this->resource = $resource;
        
        $controllerFile = $this->pluginPath."/models/".$controller."Model.php";

        if(file_exists($controllerFile)){ 
                require_once($controllerFile);
        }
        else
        {
            $controller = "basic"; //echo "ok2";
            require_once($this->pluginPath. "/models/basicModel.php");
        }

        $this->model = new $controller();
        $this->controllerName = $controller;

        $this->PrefixPlugin = $this->model->pluginPrefix;

        if(substr_count($_SERVER["SCRIPT_NAME"], "admin-ajax") == 0)
        {
            if($showView){
                //add_action('admin_head', array($this, 'setHeadScripts'));
                //add_action('admin_head', array($this, 'viewJSScripts'));
            }
        }

        if($showView){
            $this->view = $controller."View";
            add_action( 'admin_menu', array($this, 'Plugin_menu') );
            add_action( 'wp_ajax_action', array($this, 'action_callback'));
        }
        
    }

    function __destruct() {
    }

    function Plugin_menu() {
        $object = $this->model->getDataGrid("SELECT * FROM ".$this->PrefixPlugin."menus WHERE MenuStatus = 0",0, 200); 
        $menus = $object["data"];
        $countMenus = count($menus);
        for ( $i = 0; $i <  $countMenus; $i++)
        {
            //echo $menus[$i]->MenuTitle."<br>";
                if($menus[$i]->MenuType == 1)
                        add_menu_page($this->resource->getWord($menus[$i]->PageTitle),$this->resource->getWord($menus[$i]->MenuTitle), $menus[$i]->Capability, $menus[$i]->MenuSlug, $menus[$i]->FunctionMenu);
                else
                        add_submenu_page( $menus[$i]->parentSlug, $this->resource->getWord($menus[$i]->PageTitle),$this->resource->getWord($menus[$i]->MenuTitle), $menus[$i]->Capability, $menus[$i]->MenuSlug, $menus[$i]->FunctionMenu );
        }
    }

    

    function editOper($oper){
        $this->model->$oper();
    }
    

    function downloadFile($fileId){
        ini_set('memory_limit','16M');
        $this->model->rendererFile($fileId);
    }
}
?>
