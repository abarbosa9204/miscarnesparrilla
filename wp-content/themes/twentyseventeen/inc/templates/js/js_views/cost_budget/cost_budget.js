$(document).ready(function () {
    /**@augments 
     * Datatable paginación ajax, listado de archivos mercadeo
     */
    let table = $('#cost-budget-file-listing').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        serverMethod: 'post',
        pageLength: 10,
        lengthMenu: [10, 25, 50, 75, 100],
        sort: true,
        ajax: {
            url: '../wp-admin/admin-ajax.php',
            data: {
                controller: 'CostBudgetController',
                action: 'cost_budget',
                function: 'list_cost_budget',
            },
            // continue: 'post',
            // success: function(data) {
            //      console.log(data);
            // }
        },
        drawCallback: function (settings) {
            let api = this.api();
            api.rows({
                page: 'current'
            }).data().each(function (index, id, row) {
                $('#' + index.path_id).jstree({
                    'core': {
                        'themes': {
                            //'name': 'proton',
                            'responsive': true,
                        },
                        'data': index.path_json
                    },
                    'types': {
                        'default': {
                            'icon': 'fa fa-folder text-warning'
                        },
                        "file": {
                            "icon": "fa fa-file text-warning"
                        }

                    },
                    "plugins": ["types"]
                });
            });
        },
        columns: [
            { data: 'cb_row_id' },
            { data: 'div_path_id' },
            { data: 'cb_description' },
            { data: 'cb_text_information' },
            { data: 'cb_status' },
            { data: 'created_at' },
            { data: 'updated_at' },
            { data: 'user_login_id_create' },
            { data: 'accion' },

        ],
        columnDefs: [{
            targets: [4, 8],
            sortable: false,
        }, {
            "width": "20px",
            "targets": 1
        }],
        language: {
            emptyTable: 'No hay datos para mostrar',
            zeroRecords: 'No se encontraron resultados',
            thousands: ',',
            processing: 'Procesando...',
            loadingRecords: 'Cargando...',
            info: 'Mostrando de _START_ a _END_ de un total de _TOTAL_',
            infoEmpty: ' 0 registros',
            infoFiltered: '(filtrado de _MAX_ registros)',
            infoPostFix: '',
            lengthMenu: 'Registros _MENU_',
            search: 'Buscar:',
            paginate: {
                first: 'Primero',
                last: 'Último',
                next: ' Siguiente',
                previous: 'Anterior '
            },
            aria: {
                sortAscending: ' Activar para ordenar la columna de manera ascendente',
                sortDescending: ' Activar para ordenar la columna de manera descendente'
            },
            //scrollY: "200px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
        },
        responsive: {
            pagingType: "simple_numbers"
        }
    });
});

function showModalAddFile() {
    $('#addFileModal').modal('show');
    resetattachmentForm('reset');
    $('#subfolder_n1_row_id-upload').trigger('change');
    resetattachmentForm('reset');
}
function uploadFile() {
    let processModalSave = bootbox.dialog({
        title: '<h6 class="text-white twentyseventeen-font-size-theme-15-5">Se está procesando la solicitud.</h6>',
        message: '<p class="twentyseventeen-font-size-theme-15-5"><i class="fa fa-spin fa-spinner"></i> Procesando...</p>',
        centerVertical: true,
        closeButton: false
    });
    processModalSave.init(function () {
        processModalSave.attr("id", "processModalSave_select-edit");
        file_data = $('#file-upload')[0].files[0];
        form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('controller', 'CostBudgetController');
        form_data.append('action', 'cost_budget_upload_files');
        form_data.append('function', 'uploadFilesCostBudget');
        form_data.append('params', JSON.stringify($("#attachment-form").serializeArray()));
        $.ajax({
            url: '../wp-admin/admin-ajax.php',
            type: 'POST',
            cashe: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data) {
                setTimeout(function () {
                    if (data.status == 'success') {
                        $('#file-upload').val('');
                        $('#addFileModal').modal('hide').data('bs.modal', null);
                        $('#cost-budget-file-listing').DataTable().ajax.reload(null, false);
                        Command: toastr[data.status](data.msg);
                    } else {
                        $('#file-upload').val('');
                        Command: toastr[data.status](data.msg);
                    }
                    if ($("#processModalSave_select-edit")) {
                        processModalSave.modal('hide');
                    }
                }, 500);
            },
            error: function (msg) {
                setTimeout(function () {
                    Command: toastr['error']('No es posible procesar la solicitud, por favor comunicarse con el administrador');
                    processModalSave.modal('hide');
                }, 500);
            }
        });
    });
}

function resetattachmentForm(action) {
    switch (action) {
        case 'cancelModal':
            $('#text-file-description, #name-file-upload, #file-upload').val('');
            $('#html-options-subfolder_n1_row_id-upload, #html-options-subfolder_n2_row_id-upload, #html-options-subfolder_n3_row_id-upload, #html-options-subfolder_n4_row_id-upload, #html-options-subfolder_n5_row_id-upload').val('').html('').trigger('change');
            $('#addFileModal').modal('hide').data('bs.modal', null);
            Command: toastr['error']('Proceso cancelado');
            break;
        case 'reset':
            $('#text-file-description, #name-file-upload, #file-upload').val('');
            $('#html-options-subfolder_n1_row_id-upload, #html-options-subfolder_n2_row_id-upload, #html-options-subfolder_n3_row_id-upload, #html-options-subfolder_n4_row_id-upload, #html-options-subfolder_n5_row_id-upload').val('').html('').trigger('change');
            break;
    }
}

function onChangeSelect(id) {
    let processModal = bootbox.dialog({
        title: '<h6 class="text-white twentyseventeen-font-size-theme-15-5">Se está procesando la solicitud.</h6>',
        message: '<p class="twentyseventeen-font-size-theme-15-5"><i class="fa fa-spin fa-spinner"></i> Procesando...</p>',
        centerVertical: true,
        closeButton: false
    });
    processModal.init(function () {
        processModal.attr("id", "processModal_select");
        $.ajax({
            url: '../wp-admin/admin-ajax.php',
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: {
                controller: 'CostBudgetController',
                action: 'cost_budget',
                function: 'selectDependentCreateFile',
                params: {
                    select: id,
                    id: $('#' + id).val(),
                    formData: JSON.stringify($("#attachment-form").serializeArray())
                }
            },
            success: function (data) {
                setTimeout(function () {
                    switch (id) {
                        case 'subfolder_n1_row_id-upload':
                            $('#html-options-subfolder_n2_row_id-upload, #html-options-subfolder_n3_row_id-upload, #html-options-subfolder_n4_row_id-upload, #html-options-subfolder_n5_row_id-upload').val('').html('');
                            break;
                        case 'subfolder_n2_row_id-upload':
                            $('#html-options-subfolder_n3_row_id-upload, #html-options-subfolder_n4_row_id-upload, #html-options-subfolder_n5_row_id-upload').val('').html('');
                            break;
                        case 'subfolder_n3_row_id-upload':
                            $('#html-options-subfolder_n4_row_id-upload, #html-options-subfolder_n5_row_id-upload').val('').html('');
                            break;
                        case 'subfolder_n4_row_id-upload':
                            $('#html-options-subfolder_n5_row_id-upload').val('').html('');
                            break;
                        case 'subfolder_n5_row_id-upload':
                            break;
                    }
                    if (data.status == 'success') {
                        $("#" + data.span_id).html(data.html);
                        $("#" + data.child).trigger('change');
                    } else {
                        $("#" + data.span_id).html(data.html);
                    }
                    if ($("#processModal_select")) {
                        processModal.modal('hide');
                    }
                }, 100);
            },
            error: function (msg) {
                setTimeout(function () {
                    Command: toastr['error']('No es posible procesar la solicitud, por favor comunicarse con el administrador');
                    processModal.modal('hide');
                }, 500);
            }
        });
    });
}