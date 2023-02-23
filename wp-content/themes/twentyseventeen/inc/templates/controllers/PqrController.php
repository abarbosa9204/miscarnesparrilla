<?php
require_once(get_template_directory() . '/inc/templates/libs/controller.php');
date_default_timezone_set("America/Bogota");
class PqrController extends Controller
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
    function list_pqr()
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
        *
        FROM vw_wpl_pqr where filter_field like '%" . $searchValue . "%' order by " . ((($columnName == 'pqr_row_id') ? 'pqr_row_id' : $columnName) . ' ' . $columnSortOrder) . " limit " . $rows . ',' . $rowperpage, OBJECT);

        $resulset2 = $wpdb->get_results("SELECT 
                                        *
        FROM vw_wpl_pqr where filter_field like '%" . $searchValue . "%'order by " . ((($columnName == 'pqr_row_id') ? 'pqr_row_id' : $columnName) . ' ' . $columnSortOrder), OBJECT);

        $data = array();
        $jstree = [];
        $action='';
        foreach ($resulset as $row) {
            $jstree = [];
            $action='';
            //principal
            if ($row->folder_row_id != null && $row->subfolder_n1_row_id != null) {
                $jstree[] = [
                    "id"        =>  $row->folder_row_id . '@' . $row->folder_name_in_server,
                    "parent"    =>  '#',
                    "text"      =>  $row->folder_name,
                    "icon"      => 'fa fa-folder',
                    "type"      => 'folder',
                    "a_attr"    => ["class" => 'not-icon'],
                    ["selected" =>  true, "opened" => true]
                ];
                if ($row->folder_row_id == null) {
                    $jstree[] = [
                        "id"        => $row->folder_row_id . '@@' . $row->folder_name_in_server,
                        "parent"    => $row->folder_row_id . '@' . $row->folder_name_in_server,
                        "text"      => $row->pqr_description,
                        "icon"      => $row->mime_icon,
                        "type"      => 'file',
                        "a_attr"    => ["class" => 'icon-' . str_replace('.', '', $row->mime_extension)],
                    ];
                }
            }else{            
                $jstree[] = [
                    "id"        =>  $row->folder_row_id . '@' . $row->folder_name_in_server,
                    "parent"    =>  '#',
                    "text"      =>  $row->ht_description,
                    "icon"      => $row->mime_icon,
                    "type"      => 'file',
                    "a_attr"    => ["class" => 'icon-' . str_replace('.', '', $row->mime_extension)],
                    ["selected" =>  true, "opened" => true]
                ];
            }    
            //nivel 1
            if ($row->subfolder_n1_row_id != null) {
                $jstree[] = [
                    "id" => $row->subfolder_n1_row_id . '@' . $row->subfolder_n1_name_in_server,
                    "parent"    => $row->folder_row_id . '@' . $row->folder_name_in_server,
                    "text"      => $row->subfolder_n1_name,
                    "icon"      => 'fa fa-folder',
                    "type"      => 'folder',
                    "a_attr"    => ["class" => 'not-icon'],
                ];
                if ($row->subfolder_n2_row_id == null) {
                    $jstree[] = [
                        "id"        => $row->subfolder_n1_row_id . '@@' . $row->subfolder_n1_name_in_server,
                        "parent"    => $row->subfolder_n1_row_id . '@' . $row->subfolder_n1_name_in_server,
                        "text"      => $row->pqr_description,
                        "icon"      => $row->mime_icon,
                        "type"      => 'file',
                        "a_attr"    => ["class" => 'icon-' . str_replace('.', '', $row->mime_extension)],
                    ];
                }
            }
            //nivel 2
            if ($row->subfolder_n2_row_id != null) {
                $jstree[] = [
                    "id" => $row->subfolder_n2_row_id . '@' . $row->subfolder_n2_name_in_server,
                    "parent" => $row->subfolder_n1_row_id . '@' . $row->subfolder_n1_name_in_server,
                    "text" => $row->subfolder_n2_name,
                    "icon"      => 'fa fa-folder',
                    "type"      => 'folder',
                    "a_attr"    => ["class" => 'not-icon'],

                ];
                if ($row->subfolder_n3_row_id == null) {
                    $jstree[] = [
                        "id"        => $row->subfolder_n2_row_id . '@@' . $row->subfolder_n2_name_in_server,
                        "parent"    => $row->subfolder_n2_row_id . '@' . $row->subfolder_n2_name_in_server,
                        "text"      => $row->pqr_description,
                        "icon"      => $row->mime_icon,
                        "type"      => 'file',
                        "a_attr"    => ["class" => 'icon-' . str_replace('.', '', $row->mime_extension)],
                    ];
                }
            }

            //nivel 3
            if ($row->subfolder_n3_row_id != null) {
                $jstree[] = [
                    "id" => $row->subfolder_n3_row_id . '@' . $row->subfolder_n3_name_in_server,
                    "parent" => $row->subfolder_n2_row_id . '@' . $row->subfolder_n2_name_in_server,
                    "text" => $row->subfolder_n3_name,
                    "icon"      => 'fa fa-folder',
                    "type"      => 'folder',
                    "a_attr"    => ["class" => 'not-icon'],

                ];
                if ($row->subfolder_n4_row_id == null) {
                    $jstree[] = [
                        "id"        => $row->subfolder_n3_row_id . '@@' . $row->subfolder_n3_name_in_server,
                        "parent"    => $row->subfolder_n3_row_id . '@' . $row->subfolder_n3_name_in_server,
                        "text"      => $row->pqr_description,
                        "icon"      => $row->mime_icon,
                        "type"      => 'file',
                        "a_attr"    => ["class" => 'icon-' . str_replace('.', '', $row->mime_extension)],
                    ];
                }
            }
            //nivel 4
            if ($row->subfolder_n4_row_id != null) {
                $jstree[] = [
                    "id"        => $row->subfolder_n4_row_id . '@' . $row->subfolder_n4_name_in_server,
                    "parent"    => $row->subfolder_n3_row_id . '@' . $row->subfolder_n3_name_in_server,
                    "text"      => $row->subfolder_n4_name,
                    "icon"      => 'fa fa-folder',
                    "type"      => 'folder',
                    "a_attr"    => ["class" => 'not-icon'],
                ];
                if ($row->subfolder_n5_row_id == null) {
                    $jstree[] = [
                        "id"        => $row->subfolder_n4_row_id . '@@' . $row->subfolder_n4_name_in_server,
                        "parent"    => $row->subfolder_n4_row_id . '@' . $row->subfolder_n4_name_in_server,
                        "text"      => $row->pqr_description,
                        "icon"      => $row->mime_icon,
                        "type"      => 'file',
                        "a_attr"    => ["class" => 'icon-' . str_replace('.', '', $row->mime_extension)],
                    ];
                }
            }
            //nivel 5
            if ($row->subfolder_n5_row_id != null) {
                $jstree[] = [
                    "id" => $row->subfolder_n5_row_id . '@' . $row->subfolder_n5_name_in_server,
                    "parent" => $row->subfolder_n4_row_id . '@' . $row->subfolder_n4_name_in_server,
                    "text" => $row->subfolder_n5_name,
                    "icon"      => $row->mime_icon,
                    "a_attr"    => ["class" => 'icon-' . str_replace('.', '', $row->mime_extension)],
                    "type" => 'file',
                ];
            }

            if (!in_array($row->mime_extension, ['.html', '.php'])) {
                $action = '<div class="col-md-12 d-flex justify-content-center" style="min-width: 100%;max-width: 100%;">
                <a class="me-2" href="' . $row->pqr_url . '" title="Descargar" download=""><i class="ti-cloud-down" style="color:#063970;font-size:22px;cursor:pointer"></i></a>
                <a class="ms-2" href="javascript:void(0);" onclick="showModalEditFile(' . "'" . $this->encryption($row->pqr_row_id) . "'" . ')" title="Editar"><i class="ti-pencil-alt" style="color:#B61020;font-size:22px;cursor:pointer"></i></a>
                </div>';
            }
            $data[] = array(
                'pqr_row_id' => $row->pqr_row_id,
                'folder_name' => $row->folder_name,
                'div_path_id' => '<div id="' . $row->pqr_row_id . '_' . $row->folder_name_in_server . '"></div>',
                'path_id' => $row->pqr_row_id . '_' . $row->folder_name_in_server,
                'path_json' =>  $jstree,
                'pqr_description' => $row->pqr_description,
                'pqr_text_information' => $row->pqr_text_information,
                'pqr_status' => ($row->pqr_status == 1 ? '<span class="badge bg-success twentyseventeen-font-size-theme-15-5">Activo</span>' : '<span class="badge bg-danger twentyseventeen-font-size-theme-15-5">Inactivo</span>'),
                'created_at' => date('Y-m-d h:i A', strtotime($row->created_at)),
                'updated_at' => ($row->updated_at == '' ? '-' : date('Y-m-d h:i A', strtotime($row->updated_at))),
                'user_login_id_create' => $row->user_login_id_create,
                'accion' => $action
            );
        }
        $response = array(
            'draw' => intval($draw),
            'recordsTotal' => count($resulset2),
            'recordsFiltered' => count($resulset2),
            'data' => $data,
            'jstree' => $jstree
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
                return $this->createHtmlSelect($htmlOptions, 'subfolder_n1_row_id-upload', 'subfolder_n2_row_id-upload', $this->request['params']['id'], false);
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
                return $this->createHtmlSelect($htmlOptions, 'subfolder_n2_row_id-upload', 'subfolder_n3_row_id-upload', $this->request['params']['id'], false);
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
                return $this->createHtmlSelect($htmlOptions, 'subfolder_n3_row_id-upload', 'subfolder_n4_row_id-upload', $this->request['params']['id'], false);
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
                return $this->createHtmlSelect($htmlOptions, 'subfolder_n4_row_id-upload', 'subfolder_n5_row_id-upload', $this->request['params']['id'], false);
                break;
            case 'subfolder_n5_row_id-upload':
                break;
        }
    }
    /**
     * Crear nodos hijos en select dependiente
     */
    function createHtmlSelect($query, $idParent, $idChild, $idOption, $selected = false)
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
                $html .= '<option value="' . $damenu->hijo_id . '"' . ($selected ? " selected" : '') . '>' . $damenu->hijo_name .  '</option>';
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
    function uploadFilesPqr()
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
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'video/mp4',
            'application/zip'
        ];
        if (in_array($type, $arr_img_ext)) {

            $row_id = $wpdb->get_row("SELECT max(pqr_row_id) as pqr_row_id FROM wpl_pqr", OBJECT);
            $row_type_id = $wpdb->get_row("SELECT mime_row_id FROM wpl_mime_type WHERE mime_type ='" . $type . "'", OBJECT);
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
                    $insert = $wpdb->insert('wpl_pqr', [
                        'pqr_row_id'                     =>  $row_id->pqr_row_id + 1,
                        'mime_row_id'                   =>  $row_type_id->mime_row_id,
                        'folder_row_id'                 =>  $folder_row_id,
                        'subfolder_n1_row_id'           => ($subfolder_n1_row_id != null ? $subfolder_n1_row_id : null),
                        'subfolder_n2_row_id'           => ($subfolder_n2_row_id != null ? $subfolder_n2_row_id : null),
                        'subfolder_n3_row_id'           => ($subfolder_n3_row_id != null ? $subfolder_n3_row_id : null),
                        'subfolder_n4_row_id'           => ($subfolder_n4_row_id != null ? $subfolder_n4_row_id : null),
                        'subfolder_n5_row_id'           => ($subfolder_n5_row_id != null ? $subfolder_n5_row_id : null),
                        'pqr_description'                =>  $name_file_upload,
                        'pqr_text_information'           =>  $text_file_description,
                        'pqr_name_file'                  =>  $path_save  . $fileName,
                        'pqr_url'                        =>  get_template_directory_uri() . $file_path_save . '/' . $path_save . $fileName,
                        'pqr_status'                     =>  1,
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
    /*  
    * @arguments Consultar datos de archivos cargados para precargar en el formulario de edición
    * @params $_POST, JSON
    * @return JSON
    */
    function preloadDataFilePqrEdit()
    {        
        global $wpdb;
        $dataFile = $wpdb->get_row("SELECT * FROM vw_wpl_pqr WHERE pqr_row_id ='" . $this->decryption($this->param) . "'", OBJECT);
        if (!$dataFile) {
            return [
                'status'    =>  'error',
                'msg'       =>  'El registro no exist en la base de datos'
            ];
        }
        $response = [
            'status'    =>  'success',
            'msg'       =>  'Procesado correctamente',
            'data'      =>  [],
            'id'        =>  $this->encryption($dataFile->pqr_row_id),
            'pqr_description'    =>  $dataFile->pqr_description,
            'pqr_text_information'    =>  $dataFile->pqr_text_information,
            'pqr_status'    =>  $dataFile->pqr_status

        ];

        if ($dataFile->subfolder_n1_row_id != null) {
            $htmlOptions = $wpdb->get_results(
                "SELECT DISTINCT
                vwf.subfolder_n1_row_id as padre_id
                ,vwf.subfolder_n1_name as padre_name
                ,vwf.subfolder_n2_row_id as hijo_id
                ,vwf.subfolder_n2_name as hijo_name
            FROM vw_wpl_folders vwf 
            WHERE 
                vwf.folder_row_id =" . $dataFile->folder_row_id . "
                and vwf.subfolder_n1_row_id =" . $dataFile->subfolder_n1_row_id,
                OBJECT
            );
            $response['data'][] = [
                'name'  =>  'html-options-subfolder_n1_row_id-upload-edit',
                'value' =>  $this->createHtmlSelectEdit($htmlOptions, 'subfolder_n1_row_id-upload-edit', 'subfolder_n2_row_id-upload-edit', $dataFile->subfolder_n1_row_id, true)
            ];
        }

        if ($dataFile->subfolder_n2_row_id != null) {
            $htmlOptions = $wpdb->get_results(
                "SELECT DISTINCT
                vwf.subfolder_n2_row_id as padre_id
                ,vwf.subfolder_n2_name as padre_name
                ,vwf.subfolder_n3_row_id as hijo_id
                ,vwf.subfolder_n3_name as hijo_name
            FROM vw_wpl_folders vwf 
            WHERE 
                vwf.folder_row_id =" . $dataFile->folder_row_id . "
                and vwf.subfolder_n1_row_id =" . $dataFile->subfolder_n1_row_id . " 
                and vwf.subfolder_n2_row_id =" . $dataFile->subfolder_n2_row_id,
                OBJECT
            );
            $response['data'][] = [
                'name'  => 'html-options-subfolder_n2_row_id-upload-edit',
                'value' => $this->createHtmlSelectEdit($htmlOptions, 'subfolder_n2_row_id-upload-edit', 'subfolder_n3_row_id-upload-edit', $dataFile->subfolder_n2_row_id, true)
            ];
        }
        if ($dataFile->subfolder_n3_row_id != null) {
            $htmlOptions = $wpdb->get_results(
                "SELECT DISTINCT
                vwf.subfolder_n3_row_id as padre_id
                ,vwf.subfolder_n3_name as padre_name
                ,vwf.subfolder_n4_row_id as hijo_id
                ,vwf.subfolder_n4_name as hijo_name
            FROM vw_wpl_folders vwf 
            WHERE 
                vwf.folder_row_id =" . $dataFile->folder_row_id . "
                and vwf.subfolder_n1_row_id =" . $dataFile->subfolder_n1_row_id . " 
                and vwf.subfolder_n2_row_id =" . $dataFile->subfolder_n2_row_id . " 
                and vwf.subfolder_n3_row_id =" . $dataFile->subfolder_n3_row_id,
                OBJECT
            );
            $response['data'][] = [
                'name'  =>  'html-options-subfolder_n3_row_id-upload-edit',
                'value' =>  $this->createHtmlSelectEdit($htmlOptions, 'subfolder_n3_row_id-upload-edit', 'subfolder_n4_row_id-upload-edit', $dataFile->subfolder_n3_row_id, true)
            ];
        }
        if ($dataFile->subfolder_n4_row_id != null) {
            $htmlOptions = $wpdb->get_results(
                "SELECT DISTINCT
                vwf.subfolder_n4_row_id as padre_id
                ,vwf.subfolder_n4_name as padre_name
                ,vwf.subfolder_n5_row_id as hijo_id
                ,vwf.subfolder_n5_name as hijo_name
            FROM vw_wpl_folders vwf 
            WHERE 
                vwf.folder_row_id =" . $dataFile->folder_row_id . "
                and vwf.subfolder_n1_row_id =" . $dataFile->subfolder_n1_row_id . " 
                and vwf.subfolder_n2_row_id =" . $dataFile->subfolder_n2_row_id . " 
                and vwf.subfolder_n3_row_id =" . $dataFile->subfolder_n3_row_id . " 
                and vwf.subfolder_n4_row_id =" . $dataFile->subfolder_n4_row_id,
                OBJECT
            );
            $response['data'][] = [
                'name'  =>  'html-options-subfolder_n4_row_id-upload-edit',
                'value' => $this->createHtmlSelectEdit($htmlOptions, 'subfolder_n4_row_id-upload-edit', 'subfolder_n5_row_id-upload-edit', $dataFile->subfolder_n4_row_id, true)
            ];
        }
        if ($dataFile->subfolder_n5_row_id != null) {
        }
        return $response;
    }

    /**
     * *Crear nodos hijos en select dependiente para edicion
     */
    function createHtmlSelectEdit($query, $idParent, $idChild, $idOption, $selected = false)
    {
        $html = '';
        $countOptions = 0;
        if (count($query) == 0) {
            return [
                'status'    =>  'warning',
                'msg'       =>  'No existen más nodos',
                'span_id'   =>  'html-options-' . $idParent,
                'selected'  => ($selected ? $idOption : 0),
                'html'      =>  ''
            ];
        }
        $html .= '<select id="' . $idChild . '" name="' . $idChild . '" onchange="onChangeSelectEdit(' . "'" . $idChild . "'" . ')" class="form-control form-control-sm input-xs text-center validateText" placeholder="Carpeta" style="max-width: inherit;">';
        foreach ($query as $damenu) {
            if ($damenu->hijo_id != null) {
                $html .= '<option value="' . $damenu->hijo_id . '"' . '>' . $damenu->hijo_name .  '</option>';
                $countOptions++;
            }
        }
        if ($countOptions == 0) {
            return [
                'status'    =>  'warning',
                'msg'       =>  'No existen más nodos',
                'span_id'   =>  'html-options-' . $idParent,
                'selected'  => ($selected ? $idOption : 0),
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
            'selected'  => ($selected ? $idOption : 0),
            'html'      =>  $fnHtml
        ];
    }

    /*
    * Redireccionar para crear nodos hijos en select dependiente
    */
    function selectDependentCreateFileEdit()
    {
        $data = $this->array_json_stringify($this->request['params']['formData']);
        foreach ($data as $key => $rs) {
            switch ($rs['name']) {
                case 'folder_row_id-upload-edit':
                    $folder_row_id                      =   $rs['value'];
                    break;
                case 'subfolder_n1_row_id-upload-edit':
                    $subfolder_n1_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n2_row_id-upload-edit':
                    $subfolder_n2_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n3_row_id-upload-edit':
                    $subfolder_n3_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n4_row_id-upload-edit':
                    $subfolder_n4_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n5_row_id-upload-edit':
                    $subfolder_n5_row_id                =   $rs['value'];
                    break;
                case 'name-file-upload-edit':
                    $name_file_upload                   =   $rs['value'];
                    break;
                case 'text-file-description-edit':
                    $text_file_description              =   $rs['value'];
                    break;
            }
        }

        global $wpdb;

        $html = '';
        switch ($this->request['params']['select']) {
            case 'subfolder_n1_row_id-upload-edit':
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
                return $this->createHtmlSelectEdit($htmlOptions, 'subfolder_n1_row_id-upload-edit', 'subfolder_n2_row_id-upload-edit', $this->request['params']['id'], false);
                break;
            case 'subfolder_n2_row_id-upload-edit':
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
                return $this->createHtmlSelectEdit($htmlOptions, 'subfolder_n2_row_id-upload-edit', 'subfolder_n3_row_id-upload-edit', $this->request['params']['id'], false);
                break;
            case 'subfolder_n3_row_id-upload-edit':
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
                return $this->createHtmlSelectEdit($htmlOptions, 'subfolder_n3_row_id-upload-edit', 'subfolder_n4_row_id-upload-edit', $this->request['params']['id'], false);
                break;
            case 'subfolder_n4_row_id-upload-edit':
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
                return $this->createHtmlSelectEdit($htmlOptions, 'subfolder_n4_row_id-upload-edit', 'subfolder_n5_row_id-upload-edit', $this->request['params']['id'], false);
                break;
            case 'subfolder_n5_row_id-upload-edit':
                break;
            default:
                return [
                    'status' => 'error',
                    'msg' => 'Error procesando la solicitud'
                ];
                break;
        }
    }
    /*  
    * @arguments Editar archivos para Calidad
    * @params $_POST, $_FILES, JSON
    * @return JSON
    */
    function uploadFilesPqrEdit()
    {     
        global $wpdb;
        $data = $this->array_json_stringify($this->request['params']);
        $folder_row_id = $subfolder_n1_row_id = $subfolder_n2_row_id = $subfolder_n3_row_id = $subfolder_n4_row_id = $subfolder_n5_row_id = $name_file_upload = $text_file_description = null;
        $id_file_edit = '';
        $file_upload_status = 0;

        foreach ($data as $key => $rs) {
            switch ($rs['name']) {
                case 'id-file-edit':
                    $id_file_edit                       =   $this->decryption($rs['value']);
                    break;
                case 'file-upload-status':
                    $file_upload_status                 =   $rs['value'];
                    break;
                case 'folder_row_id-upload-edit':
                    $folder_row_id                      =   $rs['value'];
                    break;
                case 'subfolder_n1_row_id-upload-edit':
                    $subfolder_n1_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n2_row_id-upload-edit':
                    $subfolder_n2_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n3_row_id-upload-edit':
                    $subfolder_n3_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n4_row_id-upload-edit':
                    $subfolder_n4_row_id                =   $rs['value'];
                    break;
                case 'subfolder_n5_row_id-upload-edit':
                    $subfolder_n5_row_id                =   $rs['value'];
                    break;
                case 'name-file-upload-edit':
                    $name_file_upload                   =   $rs['value'];
                    break;
                case 'text-file-description-edit':
                    $text_file_description              =   $rs['value'];
                    break;
            }
        }

        $dataFile = $wpdb->get_row("SELECT * FROM vw_wpl_pqr WHERE pqr_row_id='" . $id_file_edit . "'", OBJECT);

        if (!$dataFile) {
            return [
                'status'    =>  'warning',
                'msg'       =>  'El archivo no esxiste en la BD'
            ];
        }

        //Url Raíz        
        $path_origin = get_template_directory() . '/template-parts/uploads/files/';
        //Crear nuevo archivo para reemplazar anterior
        if ($this->files['file'] !== null) {

            $fileName = preg_replace('/\s+/', '-', $this->files["file"]["name"]);
            $fileName = preg_replace('/[^A-Za-z0-9.\-]/', '', $fileName);
            $fileName = time() . '-' . mb_strtolower($fileName);

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
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'video/mp4',
                'application/zip'
            ];
            if (in_array($type, $arr_img_ext)) {
                $old_url = $path_origin . $dataFile->folder_name_in_server . '/' . $dataFile->pqr_name_file;
                $row_type_id = $wpdb->get_row("SELECT mime_row_id FROM wpl_mime_type WHERE mime_type ='" . $type . "'", OBJECT);
                if (!$row_type_id) {
                    return [
                        'status'    =>    'warning',
                        'msg'       =>    'El mimetype no existe en la BD'
                    ];
                }
                //Validar si el archivo origen existe
                if (!file_exists($old_url)) {
                    return [
                        'status'    => 'error',
                        'msg'       =>  'Archivo no encontrado. No es posible actualizar el documento.'
                    ];
                }
                //Eliminar archivo origen
                chown($old_url, 666);
                if (unlink($old_url)) {
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

                    $path_save = '';
                    $path_save .= ($subfolder_n1_row_id != null ? $folders_upload->subfolder_n1_name_in_server . '_'  : '');
                    $path_save .= ($subfolder_n2_row_id != null ? $folders_upload->subfolder_n2_name_in_server . '_'  : '');
                    $path_save .= ($subfolder_n3_row_id != null ? $folders_upload->subfolder_n3_name_in_server . '_'  : '');
                    $path_save .= ($subfolder_n4_row_id != null ? $folders_upload->subfolder_n4_name_in_server . '_'  : '');
                    $path_save .= ($subfolder_n5_row_id != null ? $folders_upload->subfolder_n5_name_in_server . '_'  : '');

                    $filePath   =   $path_origin . $folders_upload->folder_name_in_server . '/' . $path_save . $fileName;

                    $file_path_save = '/template-parts/uploads/files/' . $folders_upload->folder_name_in_server;
                    //Crear nuevo archivo
                    move_uploaded_file($temp, $filePath);
                    if (file_exists($filePath)) {
                        $update = $wpdb->update(
                            'wpl_pqr',
                            [
                                'mime_row_id'                   =>  $row_type_id->mime_row_id,
                                'folder_row_id'                 =>  $folder_row_id,
                                'subfolder_n1_row_id'           => ($subfolder_n1_row_id != null ? $subfolder_n1_row_id : null),
                                'subfolder_n2_row_id'           => ($subfolder_n2_row_id != null ? $subfolder_n2_row_id : null),
                                'subfolder_n3_row_id'           => ($subfolder_n3_row_id != null ? $subfolder_n3_row_id : null),
                                'subfolder_n4_row_id'           => ($subfolder_n4_row_id != null ? $subfolder_n4_row_id : null),
                                'subfolder_n5_row_id'           => ($subfolder_n5_row_id != null ? $subfolder_n5_row_id : null),
                                'pqr_description'               =>  $name_file_upload,
                                'pqr_text_information'          =>  $text_file_description,
                                'pqr_name_file'                 =>  $path_save  . $fileName,
                                'pqr_url'                       =>  get_template_directory_uri() . $file_path_save . '/' . $path_save . $fileName,
                                'pqr_status'                    => ($file_upload_status != 1 ? false : true),
                                'updated_at'                    =>  date('Y-m-d H:i:s'),
                                'user_login_id_update'          =>  get_current_user_id()
                            ],
                            ['pqr_row_id' => $dataFile->pqr_row_id]
                        );
                        if ($update) {
                            return [
                                'status'    =>  'success',
                                'msg'       =>  'Procesado correctamente',
                            ];
                        } else {
                            return [
                                'status'    =>    'error',
                                'msg'       =>    'El archivo se almacenó, pero no se actualizó en la BD'
                            ];
                        }
                    } else {
                        return [
                            'status'    =>  'error',
                            'msg'       =>  'El archivo no fue creado.'
                        ];
                    }
                } else {
                    return [
                        'status'    =>  'error',
                        'msg'       =>  'Archivo no encontrado. No es posible actualizar el documento.'
                    ];
                }
            }
        }

        //Actualizar datos con el post
        $update = $wpdb->update(
            'wpl_pqr',
            [
                'subfolder_n1_row_id'           => ($subfolder_n1_row_id != null ? $subfolder_n1_row_id : null),
                'subfolder_n2_row_id'           => ($subfolder_n2_row_id != null ? $subfolder_n2_row_id : null),
                'subfolder_n3_row_id'           => ($subfolder_n3_row_id != null ? $subfolder_n3_row_id : null),
                'subfolder_n4_row_id'           => ($subfolder_n4_row_id != null ? $subfolder_n4_row_id : null),
                'subfolder_n5_row_id'           => ($subfolder_n5_row_id != null ? $subfolder_n5_row_id : null),
                'pqr_description'                =>  $name_file_upload,
                'pqr_text_information'           =>  $text_file_description,
                'pqr_status'                     => ($file_upload_status != 1 ? false : true),
                'updated_at'                    =>  date('Y-m-d H:i:s'),
                'user_login_id_update'          =>  get_current_user_id()
            ],
            ['pqr_row_id' => $dataFile->pqr_row_id]

        );
        $old_arrar = [
            $dataFile->subfolder_n1_row_id,
            $dataFile->subfolder_n2_row_id,
            $dataFile->subfolder_n3_row_id,
            $dataFile->subfolder_n4_row_id,
            $dataFile->subfolder_n5_row_id,
        ];
        $new_array = [
            ($subfolder_n1_row_id != null ? $subfolder_n1_row_id : null),
            ($subfolder_n2_row_id != null ? $subfolder_n2_row_id : null),
            ($subfolder_n3_row_id != null ? $subfolder_n3_row_id : null),
            ($subfolder_n4_row_id != null ? $subfolder_n4_row_id : null),
            ($subfolder_n5_row_id != null ? $subfolder_n5_row_id : null),
        ];
        if ($update) {
            if ($old_arrar != $new_array) {
                $file_path_exists = $path_origin . $dataFile->folder_name_in_server . '/' . $dataFile->pqr_name_file;
                if (file_exists($file_path_exists)) {
                    //Data actualizada
                    $dataRename = $wpdb->get_row("SELECT * FROM vw_wpl_pqr WHERE pqr_row_id='" . $dataFile->pqr_row_id . "'", OBJECT);

                    $old_path = '';
                    $old_path .= ($dataFile->subfolder_n1_name_in_server != null ? $dataFile->subfolder_n1_name_in_server . '_'  : '');
                    $old_path .= ($dataFile->subfolder_n2_name_in_server != null ? $dataFile->subfolder_n2_name_in_server . '_'  : '');
                    $old_path .= ($dataFile->subfolder_n3_name_in_server != null ? $dataFile->subfolder_n3_name_in_server . '_'  : '');
                    $old_path .= ($dataFile->subfolder_n4_name_in_server != null ? $dataFile->subfolder_n4_name_in_server . '_'  : '');
                    $old_path .= ($dataFile->subfolder_n5_name_in_server != null ? $dataFile->subfolder_n5_name_in_server . '_'  : '');

                    $new_path = '';
                    $new_path .= ($dataRename->subfolder_n1_name_in_server != null ? $dataRename->subfolder_n1_name_in_server . '_'  : '');
                    $new_path .= ($dataRename->subfolder_n2_name_in_server != null ? $dataRename->subfolder_n2_name_in_server . '_'  : '');
                    $new_path .= ($dataRename->subfolder_n3_name_in_server != null ? $dataRename->subfolder_n3_name_in_server . '_'  : '');
                    $new_path .= ($dataRename->subfolder_n4_name_in_server != null ? $dataRename->subfolder_n4_name_in_server . '_'  : '');
                    $new_path .= ($dataRename->subfolder_n5_name_in_server != null ? $dataRename->subfolder_n5_name_in_server . '_'  : '');

                    //Nuevo nombre
                    $new_name = str_replace($old_path, $new_path, $dataFile->pqr_name_file);

                    //Nueva URL
                    $new_url = $path_origin . $dataFile->folder_name_in_server . '/' . $new_name;

                    //Nueva Anterior
                    $old_url = $path_origin . $dataFile->folder_name_in_server . '/' . $dataFile->pqr_name_file;

                    //Renombrar archivo
                    if (rename($old_url, $new_url)) {
                        $updateUrlFiles = $wpdb->update(
                            'wpl_pqr',
                            [
                                'pqr_name_file'  =>  $new_name,
                                'pqr_url'        =>  get_template_directory_uri() . '/template-parts/uploads/files/' . $dataFile->folder_name_in_server . '/' . $new_name,
                            ],
                            ['pqr_row_id' => $dataFile->pqr_row_id]
                        );
                        if ($updateUrlFiles) {
                            return [
                                'status'    =>  'success',
                                'msg'       =>  'Procesado correctamente.'
                            ];
                        }
                    } else {
                        return [
                            'status'    =>  'error',
                            'msg'       =>  'Error renombrando el archivo.'
                        ];
                    }
                } else {
                    return [
                        'status'    =>  'error',
                        'msg'       =>  'El archivo que se quiere actualizar no existe.'
                    ];
                }
            } else {
                return [
                    'status'    =>  'success',
                    'msg'       =>  'Se realizó la actualización de datos satisfactoriamente.'
                ];
            }
        } else {
            return [
                'status'    =>  'warning',
                'msg'       =>  'No es posibe realizar actualizaciones.'
            ];
        }
    }
}
