$(document).ready(function () {
    /**@augments 
     * Datatable paginación ajax, listado de archivos mercadeo
     */
    let table = $('#quality-file-listing').DataTable({        
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
                controller: 'QualityController',
                action: 'quality',
                function: 'list_quality',
            },
            //continue: 'post',
            // success: function(data) {
            //     console.log(data);
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
                        'default' : {
                            'icon' : 'fa fa-folder text-warning'
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
            { data: 'am_row_id' },
            { data: 'div_path_id' },
            { data: 'am_description' },
            { data: 'am_text_information' },
            { data: 'am_status' },
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
}
function uploadFile() {
    file_data = $('#file-upload')[0].files[0];
    form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('controller', 'MarketingController');
    form_data.append('action', 'marketing_upload_files');
    form_data.append('function', 'uploadFilesMarketing');
    form_data.append('params',
        JSON.stringify(
            [{
                'text-file-description': $('#text-file-description').val(),
                'name-file-upload': $('#name-file-upload').val(),
                'name-folder-upload': $('#name-folder-upload').val(),
                'name-subfolder-upload': $('#name-subfolder-upload').val()
            }])
    );
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
                    $('#marketing-file-listing').DataTable().ajax.reload(null, false);
                    Command: toastr[data.status](data.msg);
                } else {
                    $('#file-upload').val('');
                    Command: toastr[data.status](data.msg);
                }
            }, 500);
        },
        error: function (msg) {
            setTimeout(function () {
                Command: toastr['error']('No es posible procesar la solicitud, por favor comunicarse con el administrador');
            }, 500);
        }
    });
}

function resetattachmentForm(action) {
    switch (action) {
        case 'cancelModal':
            $('#text-file-description, #name-file-upload, #file-upload').val('');
            $('#addFileModal').modal('hide').data('bs.modal', null);
            Command: toastr['error']('Proceso cancelado');
            break;
        case 'reset':
            $('#text-file-description, #name-file-upload, #file-upload').val('');
            break;
    }
}