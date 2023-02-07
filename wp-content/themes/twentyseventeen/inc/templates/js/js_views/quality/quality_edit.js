function showModalEditFile(id) {
    $.ajax({
        url: '../wp-admin/admin-ajax.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: {
            controller: 'QualityController',
            action: 'quality',
            function: 'preloadDataFileQualityEdit',
            param: id
        },
        success: function (data) {            
            console.log(data);return false;
            $('#editFileModal').modal('show');return false;
            if (data.status == 'success') {
                
                // $('#id-file-edit').val(data.data.id);                
                // $('#file-upload-status').val(data.data.am_status);
                // $('#name-folder-upload-edit').val(data.data.folder_row_id);
                // $('#name-subfolder-upload-edit').val(data.data.subfolder_n1_row_id);
                // $('#name-file-upload-edit').val(data.data.am_description);
                // $('#text-file-description-edit').val(data.data.am_text_information);
            }
        },
        error: function (msg) {
            //setTimeout(function () {
                Command: toastr['error']('No es posible procesar la solicitud, por favor comunicarse con el administrador');
            //}, 500);
        }
    });
}

function uploadFileEdit() {
    file_data = $('#file-upload-edit')[0].files[0];
    form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('controller', 'MarketingController');
    form_data.append('action', 'marketing_upload_files');
    form_data.append('function', 'uploadFilesMarketingEdit');
    form_data.append('params',
        JSON.stringify(
            [{
                'text-file-description': $('#text-file-description-edit').val(),
                'name-file-upload': $('#name-file-upload-edit').val(),
                'name-folder-upload': $('#name-folder-upload-edit').val(),
                'name-subfolder-upload': $('#name-subfolder-upload-edit').val(),
                'file-upload-status': $("#file-upload-status").val(),
                'id-file-edit': $('#id-file-edit').val()
            }])
    );
    $.ajax({
        url: '../wp-admin/admin-ajax.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        contentType: false,
        processData: false,
        data: form_data,
        success: function (data) {   
            // console.log(data);//return false;
            setTimeout(function () {
                if (data.status == 'success') {
                    $('#file-upload-edit').val('');
                    $("#file-upload-status option:selected").prop("selected", false);
                    $('#editFileModal').modal('hide').data('bs.modal', null);
                    $('#marketing-file-listing').DataTable().ajax.reload(null, false);
                    Command: toastr[data.status](data.msg);
                } else {
                    $('#file-upload-edit').val('');
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