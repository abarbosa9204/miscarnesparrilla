<?php

class App
{
    function __construct($request, $files)
    {
        if (file_exists(get_template_directory() . '/inc/templates/controllers/' . $request['controller'] . '.php')) {
            require_once(get_template_directory() . '/inc/templates/controllers/' . $request['controller'] . '.php');
            $controller = new $request['controller']($request, $files);
            $function = $request['function'];
            echo json_encode($controller->$function());
        } else {
            echo json_encode(['El controlador no existe']);
        }
        die;
    }
}
