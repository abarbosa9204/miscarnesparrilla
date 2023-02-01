<?php
require_once(get_template_directory() . '/inc/templates/libs/controller.php');
class MarketingController extends Controller
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
    function list_marketing_advertising()
    {
        global $wpdb;

        $draw = $this->request['draw'];
        $rows = $this->request['start'];
        $rowperpage = $this->request['length'];
        $columnIndex = $this->request['order'][0]['column'];
        $columnName = $this->request['columns'][$columnIndex]['data'];
        $columnSortOrder = $this->request['order'][0]['dir'];
        $searchValue = $this->request['search']['value'];

        $resulset = $wpdb->get_results("SELECT * FROM vw_wpl_advertising_marketing where CONCAT(folder_name,subfolder_name,am_description) like '%" . $searchValue . "%' order by " . ((($columnName == 'am_row_id') ? 'am_description' : $columnName) . ' ' . $columnSortOrder) . " limit " . $rows . ',' . $rowperpage, OBJECT);
        $resulset2 = $wpdb->get_results("SELECT * FROM vw_wpl_advertising_marketing where CONCAT(folder_name,subfolder_name,am_description) like '%" . $searchValue . "%'order by " . ((($columnName == 'am_row_id') ? 'am_description' : $columnName) . ' ' . $columnSortOrder), OBJECT);

        $data = array();
        foreach ($resulset as $row) {
            $data[] = array(
                'am_row_id' => $row->am_row_id,
                'folder_name' => $row->folder_name,
                'subfolder_name' => $row->subfolder_name,
                'am_description' => $row->am_description,
                'am_text_information' => $row->am_text_information,
                'am_status' => ($row->am_status == 1 ? '<span class="badge bg-success twentyseventeen-font-size-theme-15-5">Activo</span>' : '<span class="badge bg-danger twentyseventeen-font-size-theme-15-5">Inactivo</span>'),
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
                'user_login' => $row->user_login,
                'accion' => '<a href="' . $row->am_url . '" title="Descargar" download=""><i class="ti-cloud-down" style="color:#B61020;font-size:22px;cursor:pointer"></i></a>'


            );
        }
        $response = array(
            'draw' => intval($draw),
            'recordsTotal' => count($resulset2),
            'recordsFiltered' => count($resulset2),
            'data' => $data
        );

        return $response; ///$this->request; //$this->getListDatatable($this->controller, $this->action);
    }
    function uploadFilesMarketing()
    {
        global $wpdb;
        $data = $this->array_json_stringify($this->request['params'])[0];

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
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ];
        if (in_array($type, $arr_img_ext)) {

            $row_id = $wpdb->get_row("SELECT max(am_row_id) as am_row_id FROM wpl_advertising_marketing", OBJECT);
            $row_type_id = $wpdb->get_row("SELECT mime_row_id FROM wpl_mime_type WHERE mime_type ='" . $type . "'", OBJECT);
            $folders_upload = $wpdb->get_row("SELECT folder_name_in_server,subfolder_name_in_server FROM vw_wpl_folders WHERE folder_row_id ='" . $data['name-folder-upload'] . "' and subfolder_row_id='" . $data['name-subfolder-upload'] . "'", OBJECT);

            $pathFolderParent = get_template_directory() . '/template-parts/uploads/marketing_advertising/' . $folders_upload->folder_name_in_server;

            if (!file_exists($pathFolderParent)) {
                mkdir($pathFolderParent, 0777, true);
            }

            $file_path_save = '/template-parts/uploads/marketing_advertising/' . $folders_upload->folder_name_in_server . '/' . $folders_upload->subfolder_name_in_server;
            $pathFolderChild = get_template_directory() . $file_path_save;
            if (!file_exists($pathFolderChild)) {
                mkdir($pathFolderChild, 0777, true);
            }

            $pathFolderEnd = get_template_directory() . $file_path_save;
            if (!file_exists($pathFolderEnd)) {
                return [
                    'status'    =>    'error',
                    'msg'       =>    'El directorio <b>' . $pathFolderEnd . '</b> no existe, por favor comunicarse con el administrador-'
                ];
            }

            if ($row_type_id) {
                $filePath   =   $pathFolderEnd . '/' . $fileName;
                move_uploaded_file($temp, $filePath);
                if (file_exists($filePath)) {
                    $insert = $wpdb->insert('wpl_advertising_marketing', [
                        'am_row_id'             =>  $row_id->am_row_id + 1,
                        'mime_row_id'           =>  $row_type_id->mime_row_id,
                        'folder_row_id'         =>  $data['name-folder-upload'],
                        'subfolder_row_id'      =>  $data['name-subfolder-upload'],
                        'am_description'        =>  $data['name-file-upload'],
                        'am_text_information'   =>  $data['text-file-description'],
                        'am_url'                =>  get_template_directory_uri() . $file_path_save . '/' . $fileName,
                        'am_status'             =>  1,
                        'created_at'            =>  date('Y-m-d H:i:s'),
                        'user_login_id'         =>  get_current_user_id()
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
