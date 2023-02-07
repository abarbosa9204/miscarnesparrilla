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
    /*  
    * @arguments Listar documentos de Mercadeo
    * @params JSON (parametros API datatable)
    * @return JSON
    */
    function list_quality()
    {
        global $wpdb;

        $draw = $this->request['draw'];
        $rows = $this->request['start'];
        $rowperpage = $this->request['length'];
        $columnIndex = $this->request['order'][0]['column'];
        $columnName = $this->request['columns'][$columnIndex]['data'];
        $columnSortOrder = $this->request['order'][0]['dir'];
        $searchValue = $this->request['search']['value'];

        $resulset = $wpdb->get_results("SELECT 
                                        qu_row_id
                                        ,qu_description
                                        ,qu_text_information
                                        ,qu_name_file 
                                        ,qu_url
                                        ,folder_row_id 
                                        ,folder_name 
                                        ,folder_name_in_server
                                        ,subfolder_n1_row_id
                                        ,subfolder_n1_name
                                        ,subfolder_n1_name_in_server
                                        ,subfolder_n2_row_id
                                        ,subfolder_n2_name
                                        ,subfolder_n2_name_in_server
                                        ,subfolder_n3_row_id
                                        ,subfolder_n3_name
                                        ,subfolder_n3_name_in_server
                                        ,subfolder_n4_row_id
                                        ,subfolder_n4_name
                                        ,subfolder_n4_name_in_server
                                        ,subfolder_n5_row_id
                                        ,subfolder_n5_name
                                        ,subfolder_n5_name_in_server
                                        ,qu_status
                                        ,user_login_id_create
                                        ,created_at 
	                                    ,COALESCE(updated_at,'') as updated_at
        FROM vw_wpl_quality where CONCAT(folder_name,subfolder_n1_name,subfolder_n2_name,subfolder_n3_name,IFNULL(subfolder_n4_name,''),IFNULL(subfolder_n5_name,''),IFNULL(qu_description,'')) like '%" . $searchValue . "%' order by " . ((($columnName == 'qu_row_id') ? 'qu_description' : $columnName) . ' ' . $columnSortOrder) . " limit " . $rows . ',' . $rowperpage, OBJECT);

        $resulset2 = $wpdb->get_results("SELECT 
                                        qu_row_id
                                        ,qu_description
                                        ,qu_text_information
                                        ,qu_name_file 
                                        ,qu_url
                                        ,folder_row_id 
                                        ,folder_name 
                                        ,folder_name_in_server
                                        ,subfolder_n1_row_id
                                        ,subfolder_n1_name
                                        ,subfolder_n1_name_in_server
                                        ,subfolder_n2_row_id
                                        ,subfolder_n2_name
                                        ,subfolder_n2_name_in_server
                                        ,subfolder_n3_row_id
                                        ,subfolder_n3_name
                                        ,subfolder_n3_name_in_server
                                        ,subfolder_n4_row_id
                                        ,subfolder_n4_name
                                        ,subfolder_n4_name_in_server
                                        ,subfolder_n5_row_id
                                        ,subfolder_n5_name
                                        ,subfolder_n5_name_in_server
                                        ,qu_status
                                        ,user_login_id_create
                                        ,created_at 
	                                    ,COALESCE(updated_at,'') as updated_at
        FROM vw_wpl_quality where CONCAT(folder_name,subfolder_n1_name,subfolder_n2_name,subfolder_n3_name,IFNULL(subfolder_n4_name,''),IFNULL(subfolder_n5_name,''),IFNULL(qu_description,'')) like '%" . $searchValue . "%'order by " . ((($columnName == 'qu_row_id') ? 'qu_description' : $columnName) . ' ' . $columnSortOrder), OBJECT);

        $data = array();
        foreach ($resulset as $row) {
            $folder_name    =   ($row->folder_name != null ? ['text' => $row->folder_name] : '');
            $subfolder_n1   =   ($row->subfolder_n1_row_id != null ? '' : '');
            $subfolder_n2   =   ($row->subfolder_n2_row_id != null ? '' : '');
            $subfolder_n3   =   ($row->subfolder_n3_row_id != null ? '' : '');
            $subfolder_n4   =   ($row->subfolder_n4_row_id != null ? '' : '');
            $subfolder_n5   =   ($row->subfolder_n5_row_id != null ? '' : '');

            $jstree = [
                $folder_name
                //  'text' => $row->folder_name,
                //  'children' => [
                //      [
                //          'text' => $row->subfolder_n1_name,
                //         'children' => [
                //             [
                //                 'text' => $row->qu_description,
                //                 'type' => 'file',
                //             ],
                //         ]
                //     ],
                // ]
            ];
            $data[] = array(
                'qu_row_id' => $row->qu_row_id,
                'folder_name' => $row->folder_name,
                'div_path_id' => '<div id="' . $row->qu_row_id . '_' . $row->folder_name_in_server . '"></div>',
                'path_id' => $row->qu_row_id . '_' . $row->folder_name_in_server,
                'path_json' =>  $jstree,
                'qu_description' => $row->qu_description,
                'qu_text_information' => $row->qu_text_information,
                'qu_status' => ($row->qu_status == 1 ? '<span class="badge bg-success twentyseventeen-font-size-theme-15-5">Activo</span>' : '<span class="badge bg-danger twentyseventeen-font-size-theme-15-5">Inactivo</span>'),
                'created_at' => date('Y-m-d h:i A', strtotime($row->created_at)),
                'updated_at' => ($row->updated_at == '' ? '-' : date('Y-m-d h:i A', strtotime($row->updated_at))),
                'user_login_id_create' => $row->user_login_id_create,
                'accion' => '<div class="col-md-12 d-flex justify-content-center" style="min-width: 100%;max-width: 100%;">
                    <a class="me-2" href="' . $row->qu_url . '" title="Descargar" download=""><i class="ti-cloud-down" style="color:#063970;font-size:22px;cursor:pointer"></i></a>
                    <a class="ms-2" href="javascript:void(0);" onclick="showModalEditFile(' . "'" . $this->encryption($row->qu_row_id) . "'" . ')" title="Editar"><i class="ti-pencil-alt" style="color:#B61020;font-size:22px;cursor:pointer"></i></a>
                    </div>'
            );
        }
        $response = array(
            'draw' => intval($draw),
            'recordsTotal' => count($resulset2),
            'recordsFiltered' => count($resulset2),
            'data' => $data
        );

        return $response;
    }

    /*
    * Redireccionar para crear nodos hijos en select dependiente
    */
    function selectDependentCreateFile()
    {
        $data = $this->array_json_stringify($this->request['params']['formData']);

        foreach ($data as $key => $rs) {
            switch ($rs['name']) {
                case 'folder_row_id-upload':
                    $folder_row_id                      =   $rs['value'];
                    break;
                case 'subfolder_n1_row_id-upload':
                    $subfolder_n1_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n2_row_id-upload':
                    $subfolder_n2_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n3_row_id-upload':
                    $subfolder_n3_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n4_row_id-upload':
                    $subfolder_n4_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n5_row_id-upload':
                    $subfolder_n5_row_id                =   $rs['value'];
                    break;
                case 'name-file-upload':
                    $name_file_upload                   =   $rs['value'];
                    break;
                case 'text-file-description':
                    $text_file_description              =   $rs['value'];
                    break;
            }
        }

        global $wpdb;

        $html = '';
        switch ($this->request['params']['select']) {
            case 'subfolder_n1_row_id-upload':
                $htmlOptions = $wpdb->get_results(
                    "SELECT DISTINCT
                    vwf.subfolder_n1_row_id as padre_id
	                ,vwf.subfolder_n1_name as padre_name
                	,vwf.subfolder_n2_row_id as hijo_id
	                ,vwf.subfolder_n2_name as hijo_name
                FROM vw_wpl_folders vwf 
                WHERE 
                    vwf.folder_row_id =" . $folder_row_id . "
		            and vwf.subfolder_n1_row_id =" . $this->request['params']['id'],
                    OBJECT
                );
                return $this->createHtmlSelect($htmlOptions, 'subfolder_n1_row_id-upload', 'subfolder_n2_row_id-upload', $this->request['params']['id']);
                break;
            case 'subfolder_n2_row_id-upload':
                $htmlOptions = $wpdb->get_results(
                    "SELECT DISTINCT
                    vwf.subfolder_n2_row_id as padre_id
	                ,vwf.subfolder_n2_name as padre_name
                	,vwf.subfolder_n3_row_id as hijo_id
	                ,vwf.subfolder_n3_name as hijo_name
                FROM vw_wpl_folders vwf 
                WHERE 
                    vwf.folder_row_id =" . $folder_row_id . "
		            and vwf.subfolder_n1_row_id =" . $subfolder_n1_row_id . " 
                    and vwf.subfolder_n2_row_id =" . $this->request['params']['id'],
                    OBJECT
                );
                return $this->createHtmlSelect($htmlOptions, 'subfolder_n2_row_id-upload', 'subfolder_n3_row_id-upload', $this->request['params']['id']);
                break;
            case 'subfolder_n3_row_id-upload':
                $htmlOptions = $wpdb->get_results(
                    "SELECT DISTINCT
                    vwf.subfolder_n3_row_id as padre_id
	                ,vwf.subfolder_n3_name as padre_name
                	,vwf.subfolder_n4_row_id as hijo_id
	                ,vwf.subfolder_n4_name as hijo_name
                FROM vw_wpl_folders vwf 
                WHERE 
                    vwf.folder_row_id =" . $folder_row_id . "
		            and vwf.subfolder_n1_row_id =" . $subfolder_n1_row_id . " 
                    and vwf.subfolder_n2_row_id =" . $subfolder_n2_row_id . " 
                    and vwf.subfolder_n3_row_id =" . $this->request['params']['id'],
                    OBJECT
                );
                return $this->createHtmlSelect($htmlOptions, 'subfolder_n3_row_id-upload', 'subfolder_n4_row_id-upload', $this->request['params']['id']);
                break;
            case 'subfolder_n4_row_id-upload':
                $htmlOptions = $wpdb->get_results(
                    "SELECT DISTINCT
                    vwf.subfolder_n4_row_id as padre_id
	                ,vwf.subfolder_n4_name as padre_name
                	,vwf.subfolder_n5_row_id as hijo_id
	                ,vwf.subfolder_n5_name as hijo_name
                FROM vw_wpl_folders vwf 
                WHERE 
                    vwf.folder_row_id =" . $folder_row_id . "
		            and vwf.subfolder_n1_row_id =" . $subfolder_n1_row_id . " 
                    and vwf.subfolder_n2_row_id =" . $subfolder_n2_row_id . " 
                    and vwf.subfolder_n3_row_id =" . $subfolder_n3_row_id . " 
                    and vwf.subfolder_n4_row_id =" . $this->request['params']['id'],
                    OBJECT
                );
                return $this->createHtmlSelect($htmlOptions, 'subfolder_n4_row_id-upload', 'subfolder_n5_row_id-upload', $this->request['params']['id']);
                break;
            case 'subfolder_n5_row_id-upload':
                break;
        }
    }
    /**
     * Crear nodos hijos en select dependiente
     */
    function createHtmlSelect($query, $idParent, $idChild, $idOption)
    {
        $html = '';
        $countOptions = 0;
        if (count($query) == 0) {
            return [
                'status'    =>  'warning',
                'msg'       =>  'No existen más nodos',
                'span_id'   =>  'html-options-' . $idParent,
                'html'      =>  ''
            ];
        }
        $html .= '<select id="' . $idChild . '" name="' . $idChild . '" onchange="onChangeSelect(' . "'" . $idChild . "'" . ')" class="form-control form-control-sm input-xs text-center validateText" placeholder="Carpeta" style="max-width: inherit;">';
        foreach ($query as $damenu) {
            if ($damenu->hijo_id != null) {
                $html .= '<option value="' . $damenu->hijo_id . '">' . $damenu->hijo_name .  '</option>';
                $countOptions++;
            }
        }
        if ($countOptions == 0) {
            return [
                'status'    =>  'warning',
                'msg'       =>  'No existen más nodos',
                'span_id'   =>  'html-options-' . $idParent,
                'html'      =>  ''
            ];
        }

        $html .= "</select>";
        $fnHtml = '<div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12">
                            <div class="mb-2">
                                <label for="' . $idChild . '" class="col-form-label text-dark m-0" style="font-weight:bold;padding:0">Sub carpeta<span class="required">*</span></label>
                                ' . $html . '
                                <small id="' . $idChild . 'Error" class="form-text text-danger font-weight-bold"></small>
                            </div>
                        </div>
                    </div>';

        return [
            'status'    =>  'success',
            'msg'       =>  'Procesado correctamente',
            'span_id'   =>  'html-options-' . $idParent,
            'child'     =>  $idChild,
            'html'      =>  $fnHtml
        ];
    }

    /*  
    * @arguments Cargar archivos para Mercadeo
    * @params $_POST, $_FILES, JSON
    * @return JSON
    */
    function uploadFilesQuality()
    {
        global $wpdb;
        $data = $this->array_json_stringify($this->request['params']);

        $fileName = preg_replace('/\s+/', '-', $this->files["file"]["name"]);
        $fileName = preg_replace('/[^A-Za-z0-9.\-]/', '', $fileName);
        $fileName = time() . '-' . mb_strtolower($fileName);

        $folder_row_id = $subfolder_n1_row_id = $subfolder_n2_row_id = $subfolder_n3_row_id = $subfolder_n4_row_id = $subfolder_n5_row_id = $name_file_upload = $text_file_description = null;
        foreach ($data as $key => $rs) {
            switch ($rs['name']) {
                case 'folder_row_id-upload':
                    $folder_row_id                      =   $rs['value'];
                    break;
                case 'subfolder_n1_row_id-upload':
                    $subfolder_n1_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n2_row_id-upload':
                    $subfolder_n2_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n3_row_id-upload':
                    $subfolder_n3_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n4_row_id-upload':
                    $subfolder_n4_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n5_row_id-upload':
                    $subfolder_n5_row_id                =   $rs['value'];
                    break;
                case 'name-file-upload':
                    $name_file_upload                   =   $rs['value'];
                    break;
                case 'text-file-description':
                    $text_file_description              =   $rs['value'];
                    break;
            }
        }

        $file    =   $this->files['file'];
        $type    =   $this->files['file']['type'];
        $size    =   $this->files['file']['size'];
        $temp    =   $this->files['file']['tmp_name'];

        $arr_img_ext = [
            'application/msword',
            'application/pdf',
            'application/vnd.ms-powerpoint',
            'application/vnd.ms-excel',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel.sheet.macroEnabled.12',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ];
        if (in_array($type, $arr_img_ext)) {

            $row_id = $wpdb->get_row("SELECT max(qu_row_id) as qu_row_id FROM wpl_quality", OBJECT);
            $row_type_id = $wpdb->get_row("SELECT mime_row_id FROM wpl_mime_type WHERE mime_type ='" . $type . "'", OBJECT);
            ($subfolder_n2_row_id != null ? " and subfolder_n2_row_id = " . $subfolder_n2_row_id : "");
            $folders_upload = $wpdb->get_row(
                "SELECT DISTINCT 
                    folder_name_in_server"
                    . ($subfolder_n1_row_id != null ? ",subfolder_n1_name_in_server" : "")
                    . ($subfolder_n2_row_id != null ? ",subfolder_n2_name_in_server" : "")
                    . ($subfolder_n3_row_id != null ? ",subfolder_n3_name_in_server" : "")
                    . ($subfolder_n4_row_id != null ? ",subfolder_n4_name_in_server" : "")
                    . ($subfolder_n5_row_id != null ? ",subfolder_n5_name_in_server" : "")
                    . "
                FROM 
                    vw_wpl_folders 
                WHERE 
                    folder_row_id ='" . $folder_row_id . "'"
                    . ($subfolder_n1_row_id != null ? " and subfolder_n1_row_id = " . $subfolder_n1_row_id : "")
                    . ($subfolder_n2_row_id != null ? " and subfolder_n2_row_id = " . $subfolder_n2_row_id : "")
                    . ($subfolder_n3_row_id != null ? " and subfolder_n3_row_id = " . $subfolder_n3_row_id : "")
                    . ($subfolder_n4_row_id != null ? " and subfolder_n4_row_id = " . $subfolder_n4_row_id : "")
                    . ($subfolder_n5_row_id != null ? " and subfolder_n5_row_id = " . $subfolder_n5_row_id : ""),
                OBJECT
            );

            $pathFolderParent = get_template_directory() . '/template-parts/uploads/files/' . $folders_upload->folder_name_in_server;

            if (!file_exists($pathFolderParent)) {
                mkdir($pathFolderParent, 0777, true);
            }
            $file_path_save = '/template-parts/uploads/files/' . $folders_upload->folder_name_in_server;

            $pathFolderEnd = get_template_directory() . $file_path_save;
            if (!file_exists($pathFolderEnd)) {
                return [
                    'status'    =>    'error',
                    'msg'       =>    'El directorio <b>' . $pathFolderEnd . '</b> no existe, por favor comunicarse con el administrador-'
                ];
            }
            if ($row_type_id) {
                $path_save = '';
                $path_save .= ($subfolder_n1_row_id != null ? $folders_upload->subfolder_n1_name_in_server . '_'  : '');
                $path_save .= ($subfolder_n2_row_id != null ? $folders_upload->subfolder_n2_name_in_server . '_'  : '');
                $path_save .= ($subfolder_n3_row_id != null ? $folders_upload->subfolder_n3_name_in_server . '_'  : '');
                $path_save .= ($subfolder_n4_row_id != null ? $folders_upload->subfolder_n4_name_in_server . '_'  : '');
                $path_save .= ($subfolder_n5_row_id != null ? $folders_upload->subfolder_n5_name_in_server . '_'  : '');

                $filePath   =   $pathFolderEnd . '/' . $path_save  . $fileName;
                move_uploaded_file($temp, $filePath);
                if (file_exists($filePath)) {
                    $insert = $wpdb->insert('wpl_quality', [
                        'qu_row_id'                     =>  $row_id->qu_row_id + 1,
                        'mime_row_id'                   =>  $row_type_id->mime_row_id,
                        'folder_row_id'                 =>  $folder_row_id,
                        'subfolder_n1_row_id'           => ($subfolder_n1_row_id != null ? $subfolder_n1_row_id : null),
                        'subfolder_n2_row_id'           => ($subfolder_n2_row_id != null ? $subfolder_n2_row_id : null),
                        'subfolder_n3_row_id'           => ($subfolder_n3_row_id != null ? $subfolder_n3_row_id : null),
                        'subfolder_n4_row_id'           => ($subfolder_n4_row_id != null ? $subfolder_n4_row_id : null),
                        'subfolder_n5_row_id'           => ($subfolder_n5_row_id != null ? $subfolder_n5_row_id : null),
                        'qu_description'                =>  $name_file_upload,
                        'qu_text_information'           =>  $text_file_description,
                        'qu_name_file'                  =>  $path_save  . $fileName,
                        'qu_url'                        =>  get_template_directory_uri() . $file_path_save . '/' . $path_save,
                        'qu_status'                     =>  1,
                        'created_at'                    =>  date('Y-m-d H:i:s'),
                        'user_login_id_create'          =>  get_current_user_id()
                    ]);
                    if ($insert) {
                        return [
                            'status'    =>    'success',
                            'msg'        =>    'Procesado correctamente',
                            'data'        => [
                                'name'    =>    $fileName,
                                'type'    =>    $type,
                                'size'    =>    $size
                            ]
                        ];
                    } else {
                        return [
                            'status'    =>    'error',
                            'msg'       =>    'El archivo se almacenó, pero no se registro en la BD'
                        ];
                    }
                } else {
                    return [
                        'status'    =>    'error',
                        'msg'       =>    'El archivo no se almacenó'
                    ];
                }
            } else {
                return [
                    'status'    =>    'warning',
                    'msg'       =>    'El mimetype no existe en la BD'
                ];
            }
        } else {
            return [
                'status'    =>  'warning',
                'msg'       =>  'El archivo con extención ' . $type . ' que se quiere cargar no está permitido'
            ];
        }
    }
}