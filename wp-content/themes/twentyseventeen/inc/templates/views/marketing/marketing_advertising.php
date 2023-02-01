<!DOCTYPE html>
<html lang="en">

<head>
    <?php get_header_2() ?>
</head>

<body>
    <h4>Publicidad & Mercadeo</h4>    
    <div class="container-fluid">
        <div class="mb-2">
            <a href="javascript:void(0);" type="button" class="btn btn-sm btn-outline-danger twentyseventeen-font-size-theme-15-5" style="min-width: 112px;" onclick="showModalAddFile()"><i class="fa fa-plus"></i> Nuevo</button>
            </a>
        </div>
        <div class="table-responsive">
        <!-- wp-list-table widefat fixed -->
            <table class="table wp-list-table widefat table-striped table-bordered dt-responsive" id="marketing-file-listing" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="min-width: 5px">#</th>
                        <th style="width:140px; min-width: 140px">Carpeta</th>
                        <th style="width:140px; min-width: 140px">Subcarpeta</th>
                        <th style="width:100px; min-width: 140px">Nombre</th>
                        <th style="width:250px; min-width: 250px">Descripción</th>
                        <th style="width:50px; min-width: 50px">Estado</th>
                        <th style="width:135px; min-width: 135px">Fecha<br>creación</th>
                        <th style="width:135px; min-width: 135px">Fecha<br> actualización</th>
                        <th style="width:135px; min-width: 135px">Usuario<br> creador</th>
                        <th style="width:50px; min-width: 50px">Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addFileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addFileModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFileModalTitle">Cargar archivo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetattachmentForm('reset')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="attachment-form" name="attachment-form" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-xl-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border twentyseventeen-font-size-theme-16">Completar la información descriptiva del archivo</legend>
                                    <div class="control-group">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12">
                                                <div class="mb-2">
                                                    <label for="file-upload" class="col-form-label text-dark m-0">Cargar archivo</label>
                                                    <input type="file" class="form-control form-control-sm p-1 px-2" id="file-upload" name="file-upload" accept="*" capture="document" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12 col-md-12">
                                                <div class="mb-2">
                                                    <label for="name-folder-upload" class="col-form-label text-dark m-0" style="font-weight:bold;padding:0">Carpeta principal<span class="required">*</span></label>
                                                    <?php
                                                    global $wpdb;
                                                    $data = $wpdb->get_results("SELECT DISTINCT folder_row_id,folder_name FROM vw_wpl_folders WHERE folder_row_id=1");
                                                    echo '<select id="name-folder-upload" name="name-folder-upload" class="form-control form-control-sm input-xs text-center validateText" placeholder="Carpeta" style="max-width: inherit;">';
                                                    foreach ($data as $damenu) {
                                                        echo '<option value="' . $damenu->folder_row_id . '">' . $damenu->folder_name . '</option>';
                                                    }
                                                    echo "</select>";
                                                    ?>
                                                    <small id="name-folder-uploadError" class="form-text text-danger font-weight-bold"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12">
                                                <div class="mb-2">
                                                    <label for="name-subfolder-upload" class="col-form-label text-dark m-0" style="font-weight:bold;padding:0">Sub carpeta<span class="required">*</span></label>
                                                    <?php
                                                    global $wpdb;
                                                    $data = $wpdb->get_results("SELECT DISTINCT subfolder_row_id,subfolder_name FROM vw_wpl_folders WHERE folder_row_id=1");
                                                    echo '<select id="name-subfolder-upload" name="name-subfolder-upload" class="form-control form-control-sm input-xs text-center validateText" placeholder="Carpeta" style="max-width: inherit;">';
                                                    foreach ($data as $damenu) {
                                                        echo '<option value="' . $damenu->subfolder_row_id . '">' . $damenu->subfolder_name . '</option>';
                                                    }
                                                    echo "</select>";
                                                    ?>
                                                    <small id="name-subfolder-uploadError" class="form-text text-danger font-weight-bold"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12">
                                                <div class="mb-2">
                                                    <label for="name-file-upload" class="col-form-label text-dark m-0" style="font-weight:bold;padding:0">Nombre del archivo<span class="required">*</span></label>
                                                    <input type="text" id="name-file-upload" name="name-file-upload" class="form-control form-control-sm input-xs text-center validateText" placeholder="Nombre del archivo">
                                                    <small id="name-file-uploadError" class="form-text text-danger font-weight-bold"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12">
                                                <div class="mb-2">
                                                    <label for="text-file-description" class="col-form-label text-dark m-0" style="font-weight:bold;padding:0">Texto descriptivo<span class="required">*</span></label>
                                                    <textarea style="width:100%" class="form-control form-control-sm text-left validateText" aria-describedby="udmByHelp" rows="3" cols="50" placeholder="Texto descriptivo" id="text-file-description" name="text-file-description"></textarea>
                                                    <small id="text-file-descriptionError" class="form-text text-danger font-weight-bold"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <button type="submit" id="save-attachments" class="btn btn-lg btn-success btn-xs" style="display: none;"><i class="fa fa-upload"></i></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" style="min-width: 90px;" class="btn btn-secondary btn-sm twentyseventeen-font-size-theme-15-5" data-dismiss="modal" onclick="resetattachmentForm('reset')">Cancelar</button>
                    <button type="button" style="min-width: 90px;" class="btn btn-danger btn-sm twentyseventeen-font-size-theme-15-5" onclick="uploadFile()">Subir</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="<?php bloginfo('template_directory') ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php bloginfo('template_directory') ?>/assets/js/popper.min.js"></script>
    <script src="<?php bloginfo('template_directory') ?>/assets/js/bootstrap-5-2-3.min.js"></script>
    <script src="<?php bloginfo('template_directory') ?>/assets/js/custom-script.js"></script>
    <script src="<?php bloginfo('template_directory') ?>/inc/templates/js/js_views/marketing/marketing_advertising.js"></script>

</body>

</html>