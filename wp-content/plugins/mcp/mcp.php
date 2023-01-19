<?php
/*
Plugin Name: Intranet Miscarnes Parrilla
Plugin URI: http://solodata.es
Description: Este es un plugin para la administración de módulos de Mis Carnes Parrilla
Author: Nuestra Empresa
Version: 1.0.1
*/

//requires
//require_once dirname(__FILE__) . '/clases/codigocorto.class.php';
include_once(ABSPATH.'wp-admin/includes/plugin.php');
if(!function_exists('wp_get_current_user'))
    require_once(ABSPATH . "wp-includes/pluggable.php"); 
wp_cookie_constants();
$current_user = wp_get_current_user();
require_once "pluginConfig.php";
require_once "views/mainView.php";
require_once 'controllers/mainController.php';
if(!empty($_POST["id"])){
    $controlerId = $_POST["id"];
}elseif(!empty($_GET["controller"])){
    $controlerId = $_GET["controller"];
}elseif(!empty($_REQUEST["page"])){
    $controlerId = $_REQUEST["page"];
}
if(is_plugin_active($pluginName."/".$pluginName.".php")){
    if(!isset($controller))
        $controller = new mainController($controlerId);
}


function Activar()
{
}

function Desactivar()
{
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'Activar');
register_deactivation_hook(__FILE__, 'Desactivar');
add_action('admin_menu', 'CrearMenu');

function CrearMenu()
{
    global $wpdb;
    $tabla = "{$wpdb->prefix}menus";
    $query = "SELECT * FROM $tabla WHERE MenuStatus = 1";
    $datos = $wpdb->get_results($query, ARRAY_A);
    foreach($datos as $menu){
        if($menu["MenuType"]=="1"){
        add_menu_page(
            $menu["PageTitle"],//Titulo de la pagina
            $menu["MenuTitle"],// Titulo del menu
            $menu["Capability"], // Capability
            $menu["MenuSlug"],
            $menu["FunctionMenu"],
            plugin_dir_url(__FILE__).$menu["IconUrl"]     
        );
    }
    else{

    }
    }
    
  
}


