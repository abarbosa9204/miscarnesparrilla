<?php
require_once(get_template_directory() . '/inc/templates/libs/controller.php');
date_default_timezone_set("America/Bogota");
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
    /*  
    * @arguments Listar documentos de Mercadeo
    * @params JSON (parametros API datatable)
    * @return JSON
    */
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

        $resulset = $wpdb->get_results("SELECT 
                                        am_row_id
                                        ,am_description
                                        ,am_text_information
                                        ,am_name_file 
                                        ,am_url
                                        ,folder_row_id 
                                        ,folder_name 
                                        ,folder_name_in_server
                                        ,subfolder_n1_row_id
                                        ,subfolder_n1_name
                                        ,subfolder_n1_name_in_server
                                        ,am_status
                                        ,user_login_id_create
                                        ,created_at 
	                                    ,COALESCE(updated_at,'') as updated_at
        FROM vw_wpl_advertising_marketing where CONCAT(folder_name,subfolder_n1_name,am_description) like '%" . $searchValue . "%' order by " . ((($columnName == 'am_row_id') ? 'am_description' : $columnName) . ' ' . $columnSortOrder) . " limit " . $rows . ',' . $rowperpage, OBJECT);

        $resulset2 = $wpdb->get_results("SELECT 
                                        am_row_id
                                        ,am_description
                                        ,am_text_information
                                        ,am_name_file 
                                        ,am_url
                                        ,folder_row_id 
                                        ,folder_name 
                                        ,folder_name_in_server
                                        ,subfolder_n1_row_id
                                        ,subfolder_n1_name
                                        ,subfolder_n1_name_in_server
                                        ,user_login_id_create
                                        ,created_at
	                                    ,COALESCE(updated_at,'') as updated_at
        FROM vw_wpl_advertising_marketing where CONCAT(folder_name,subfolder_n1_name,am_description) like '%" . $searchValue . "%'order by " . ((($columnName == 'am_row_id') ? 'am_description' : $columnName) . ' ' . $columnSortOrder), OBJECT);

        $data = array();
        foreach ($resulset as $row) {
            $jstree = [
                'text' => $row->folder_name,
                'children' => [
                    [
                        'text' => $row->subfolder_n1_name,
                        'children' => [
                            [
                                'text' => $row->am_description,
                                'type' => 'file',
                            ],
                        ]
                    ],
                ]
            ];
            $data[] = array(
                'am_row_id' => $row->am_row_id,
                'folder_name' => $row->folder_name,
                'div_path_id' => '<div id="' . $row->am_row_id . '_' . $row->folder_name_in_server . '"></div>',
                'path_id' => $row->am_row_id . '_' . $row->folder_name_in_server,
                'path_json' =>  $jstree,
                'am_description' => $row->am_description,
                'am_text_information' => $row->am_text_information,
                'am_status' => ($row->am_status == 1 ? '<span class="badge bg-success twentyseventeen-font-size-theme-15-5">Activo</span>' : '<span class="badge bg-danger twentyseventeen-font-size-theme-15-5">Inactivo</span>'),
                'created_at' => date('Y-m-d h:i A', strtotime($row->created_at)),
                'updated_at' => ($row->updated_at == '' ? '-' : date('Y-m-d h:i A', strtotime($row->updated_at))),
                'user_login_id_create' => $row->user_login_id_create,
                'accion' => '<div class="col-md-12 d-flex justify-content-center" style="min-width: 100%;max-width: 100%;">
                    <a class="me-2" href="' . $row->am_url . '" title="Descargar" download=""><i class="ti-cloud-down" style="color:#063970;font-size:22px;cursor:pointer"></i></a>
                    <a class="ms-2" href="javascript:void(0);" onclick="showModalEditFile(' . "'" . $this->encryption($row->am_row_id) . "'" . ')" title="Editar"><i class="ti-pencil-alt" style="color:#B61020;font-size:22px;cursor:pointer"></i></a>
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
    * @arguments Cargar archivos para Mercadeo
    * @params $_POST, $_FILES, JSON
    * @return JSON
    */
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
            $folders_upload = $wpdb->get_row("SELECT DISTINCT folder_name_in_server,subfolder_n1_name_in_server FROM vw_wpl_folders WHERE folder_row_id ='" . $data['name-folder-upload'] . "' and subfolder_n1_row_id='" . $data['name-subfolder-upload'] . "'", OBJECT);

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
                $filePath   =   $pathFolderEnd . '/' . $folders_upload->subfolder_n1_name_in_server . '_' . $fileName;
                move_uploaded_file($temp, $filePath);
                if (file_exists($filePath)) {
                    $insert = $wpdb->insert('wpl_advertising_marketing', [
                        'am_row_id'                     =>  $row_id->am_row_id + 1,
                        'mime_row_id'                   =>  $row_type_id->mime_row_id,
                        'folder_row_id'                 =>  $data['name-folder-upload'],
                        'subfolder_n1_row_id'           =>  $data['name-subfolder-upload'],
                        'am_description'                =>  $data['name-file-upload'],
                        'am_text_information'           =>  $data['text-file-description'],
                        'am_name_file'                  =>  $folders_upload->subfolder_n1_name_in_server . '_' . $fileName,
                        'am_url'                        =>  get_template_directory_uri() . $file_path_save . '/' . $folders_upload->subfolder_n1_name_in_server . '_' . $fileName,
                        'am_status'                     =>  1,
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
    function preloadDataFileMarketingEdit()
    {
        global $wpdb;
        $dataFile = $wpdb->get_row("SELECT * FROM vw_wpl_advertising_marketing WHERE am_row_id ='" . $this->decryption($this->param) . "'", OBJECT);

        if ($dataFile) {
            return [
                'status'    =>  'success',
                'msg'       =>  'Procesado correctamente.',
                'data'      =>  [
                    'id'                    =>  $this->param,
                    'folder_row_id'         =>  $dataFile->folder_row_id,
                    'subfolder_n1_row_id'   =>  $dataFile->subfolder_n1_row_id,
                    'am_description'        =>  $dataFile->am_description,
                    'am_text_information'   =>  $dataFile->am_text_information,
                    'am_status'             =>  $dataFile->am_status
                ]
            ];
        } else {
            return [
                'status'    =>  'error',
                'msg'       =>  'El archivo que se quiere editar no existe.',
            ];
        }
    }

    /*  
    * @arguments Editar archivos para Mercadeo
    * @params $_POST, $_FILES, JSON
    * @return JSON
    */
    function uploadFilesMarketingEdit()
    {
        global $wpdb;
        $data = $this->array_json_stringify($this->request['params'])[0];
        $dataFile = $wpdb->get_row("SELECT * FROM vw_wpl_advertising_marketing WHERE am_row_id='" . $this->decryption($data['id-file-edit']) . "'", OBJECT);

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
                'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ];
            if (in_array($type, $arr_img_ext)) {
                $old_url = $path_origin . $dataFile->folder_name_in_server . '/' . $dataFile->am_name_file;
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
                    $row_type_id = $wpdb->get_row("SELECT mime_row_id FROM wpl_mime_type WHERE mime_type ='" . $type . "'", OBJECT);
                    $folders_upload = $wpdb->get_row("SELECT DISTINCT folder_name_in_server, subfolder_n1_name_in_server FROM vw_wpl_folders WHERE folder_row_id ='" . $data['name-folder-upload'] . "' and subfolder_n1_row_id='" . $data['name-subfolder-upload'] . "'", OBJECT);
                    $filePath   =   $path_origin . '/' . $folders_upload->folder_name_in_server . '/' . $folders_upload->subfolder_n1_name_in_server . '_' . $fileName;
                    //Crear nuevo archivo
                    move_uploaded_file($temp, $filePath);
                    if (file_exists($filePath)) {
                        $update = $wpdb->update(
                            'wpl_advertising_marketing',
                            [
                                'am_text_information'   =>  $data['text-file-description'],
                                'am_name_file'          =>  $folders_upload->subfolder_n1_name_in_server . '_' . $fileName,
                                'am_url'                =>  get_template_directory_uri() . '/template-parts/uploads/files/' . $folders_upload->folder_name_in_server . '/' . $folders_upload->subfolder_n1_name_in_server . '_' . $fileName,
                                'subfolder_n1_row_id'   =>  $data['name-subfolder-upload'],
                                'am_status'             => ($data['file-upload-status'] != 1 ? false : true),
                                'updated_at'            =>  date('Y-m-d H:i:s'),
                                'user_login_id_update'  =>  get_current_user_id()
                            ],
                            ['am_row_id' => $dataFile->am_row_id]
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
            'wpl_advertising_marketing',
            [
                'am_text_information'   =>  $data['text-file-description'],
                'am_description'        =>  $data['name-file-upload'],
                'subfolder_n1_row_id'   =>  $data['name-subfolder-upload'],
                'am_status'             => ($data['file-upload-status'] != 1 ? false : true),
                'updated_at'            =>  date('Y-m-d H:i:s'),
                'user_login_id_update'  =>  get_current_user_id()
            ],
            ['am_row_id' => $dataFile->am_row_id]
        );

        if ($update) {
            if ($data['name-subfolder-upload'] != $dataFile->subfolder_n1_row_id) {
                $file_path_exists = $path_origin . $dataFile->folder_name_in_server . '/' . $dataFile->am_name_file;
                if (file_exists($file_path_exists)) {

                    //Data actualizada
                    $dataRename = $wpdb->get_row("SELECT * FROM vw_wpl_advertising_marketing WHERE am_row_id='" . $this->decryption($data['id-file-edit']) . "'", OBJECT);

                    //Nuevo nombre
                    $new_name = str_replace($dataFile->subfolder_n1_name_in_server, $dataRename->subfolder_n1_name_in_server, $dataFile->am_name_file);

                    //Nueva URL
                    $new_url = $path_origin . $dataFile->folder_name_in_server . '/' . $new_name;

                    //Nueva Anterior
                    $old_url = $path_origin . $dataFile->folder_name_in_server . '/' . $dataFile->am_name_file;

                    //Renombrar archivo
                    if (rename($old_url, $new_url)) {
                        $updateUrlFiles = $wpdb->update(
                            'wpl_advertising_marketing',
                            [
                                'am_name_file'  =>  $new_name,
                                'am_url'        =>  get_template_directory_uri() . '/template-parts/uploads/files/' . $dataFile->folder_name_in_server . '/' . $new_name,
                            ],
                            ['am_row_id' => $dataFile->am_row_id]
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
