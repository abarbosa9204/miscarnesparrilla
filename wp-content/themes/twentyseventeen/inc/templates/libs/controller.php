<?php
class Controller
{
    function __construct()
    {
    }
    function uploadFile()
    {
        return 'saludando';
    }
    function getListDatatable($table, $data)
    {
        return [$table];
    }
    /**
     * * @arguments retornar arreglo de json json_stringify
     */
    function array_json_stringify($params)
    {        
        return json_decode(stripslashes($params), true);
    }
}
