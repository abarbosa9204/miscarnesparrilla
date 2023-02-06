<?php
require_once(get_template_directory() . '/inc/templates/libs/controller.php');
date_default_timezone_set("America/Bogota");
class QualityController extends Controller
{
    private $controller;
    private $action;
    private $param;
    private $params;
    private $request;
    private $files;

    function __construct($request, $files)
    {
        parent::__construct();
        $this->controller   = $request['controller'];
        $this->action       = $request['action'];
        $this->param        = $request['param'];
        $this->params       = $request['params'];
        $this->request      = $request;
        $this->files        = $files;
    }
}
