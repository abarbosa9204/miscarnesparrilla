<?php
/*
Plugin Name: MCP
Description: Este es un plugin de Para MIS CARNES PARILLA
Author: Nuestra Espresa
Version: 1.0
*/

//requires
//require_once dirname(__FILE__) . '/clases/codigocorto.class.php';


function Activar(){
        
}

function Desactivar(){
    flush_rewrite_rules();
}

register_activation_hook(__FILE__,'Activar');
register_deactivation_hook(__FILE__,'Desactivar');
add_action('admin_menu','CrearMenu');

function CrearMenu(){
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM wp_menus WHERE MenuStatus = 1", OBJECT );
    foreach($results as $menus){
        if($menus->MenuType == 1)
        add_menu_page(
            $menus->PageTitle,//Titulo de la pagina
            $menus->MenuTitle,// Titulo del menu
            $menus->Capability, // Capability
            $menus->MenuSlug, //slug
            $menus->FunctionMenu, //function del contenido
            plugin_dir_url(__FILE__).$menus->IconUrl,//icono,
            null
        );
        }
    /*add_menu_page(
        'Super Encuentas titulo',//Titulo de la pagina
        'Super Encuentas Menu',// Titulo del menu
        'manage_options', // Capability
        plugin_dir_path(__FILE__).'admin/lista_encuestas.php', //slug
        null, //function del contenido
         plugin_dir_url(__FILE__).'admin/img/icon.png',//icono
         '1' //priority
    );*/
    /*$object = $this->model->getDataGrid("SELECT * FROM wp_menus WHERE MenuStatus = 1",0, 200); 
    $menus = $object["data"];
    $countMenus = count($menus);
    for ( $i = 0; $i <  $countMenus; $i++)
    {
        //echo $menus[$i]->MenuTitle."<br>";
            if($menus[$i]->MenuType == 1)
            add_menu_page(
                $menus[$i]->PageTitle,//Titulo de la pagina
                $menus[$i]->MenuTitle,// Titulo del menu
                $menus[$i]->Capability, // Capability
                $menus[$i]->MenuSlug, //slug
                $menus[$i]->FunctionMenu, //function del contenido
                $menus[$i]->IconUrl,//icono
            );
            else
                    add_submenu_page( $menus[$i]->parentSlug, $this->resource->getWord($menus[$i]->PageTitle),$this->resource->getWord($menus[$i]->MenuTitle), $menus[$i]->Capability, $menus[$i]->MenuSlug, $menus[$i]->FunctionMenu );
    }*/

}

function mcp(){
    require_once('views/mcp/mainView.php');
}


//encolar bootstrap

