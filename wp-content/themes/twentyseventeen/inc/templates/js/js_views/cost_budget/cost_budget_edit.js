/**
 * *Setear modúlo para la edición de documentos
 * @param {*} id 
 */
function showModalEditFile(id) {
    $.ajax({
        url: '../wp-admin/admin-ajax.php',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: {
            controller: 'CostBudgetController',
            action: 'cost_budget',
            function: 'preloadDataFileCostBudgetEdit',
            param: id
        },
        success: function (data) {
            if (data.status == 'success') {
                $('#editFileModal').modal('show');
                resetattachmentFormEdit('reset');
                $.each(data.data, function (index, value) {
                    switch (value.name) {
                        case 'html-options-subfolder_n1_row_id-upload-edit':
                            if (typeof value.value.selected !== 'undefined') {
                                $("#subfolder_n1_row_id-upload-edit").val(value.value.selected);
                            }
                            $("#html-options-" + value.value.child).html(value.value.html);
                            break;
                        case 'html-options-subfolder_n2_row_id-upload-edit':
                            if (typeof value.value.selected !== 'undefined') {
                                $("#subfolder_n2_row_id-upload-edit").val(value.value.selected);
                            }
                            $("#html-options-" + value.value.child).html(value.value.html);
                            break;
                        case 'html-options-subfolder_n3_row_id-upload-edit':
                            if (typeof value.value.selected !== 'undefined') {
                                $("#subfolder_n3_row_id-upload-edit").val(value.value.selected);
                            }
                            $("#html-options-" + value.value.child).html(value.value.html);
                            break;
                        case 'html-options-subfolder_n4_row_id-upload-edit':
                            if (typeof value.value.selected !== 'undefined') {
                                $("#subfolder_n5_row_id-upload-edit").val(value.value.selected);
                            }
                            $("#html-options-" + value.value.child).html(value.value.html);
                            break;
                        case 'html-options-subfolder_n5_row_id-upload-edit':
                            break;
                    }
                });
                $('#id-file-edit').val(data.id);
                $('#name-file-upload-edit').val(data.cb_description);
                $('#text-file-description-edit').val(data.cb_text_information);
                $('#file-upload-status').val(data.cb_status);
            }
        },
        error: function (msg) {
            setTimeout(function () {
                Command: toastr['error']('No es posible procesar la solicitud, por favor comunicarse con el administrador');
            }, 500);
        }
    });
}

function onChangeSelectEdit(id) {
    let processModal = bootbox.dialog({
        title: '<h6 class="text-white twentyseventeen-font-size-theme-15-5">Se está procesando la solicitud.</h6>',
        message: '<p class="twentyseventeen-font-size-theme-15-5"><i class="fa fa-spin fa-spinner"></i> Procesando...</p>',
        centerVertical: true,
        closeButton: false
    });
    processModal.init(function () {
        processModal.attr("id", "processModal_select-edit");
        $.ajax({
            url: '../wp-admin/admin-ajax.php',
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: {
                controller: 'CostBudgetController',
                action: 'cost_budget',
                function: 'selectDependentCreateFileEdit',
                params: {
                    select: id,
                    id: $('#' + id).val(),
                    formData: JSON.stringify($("#attachment-form-edit").serializeArray())
                }
            },
            success: function (data) {
                setTimeout(function () {
                    switch (id) {
                        case 'subfolder_n1_row_id-upload-edit':
                            $('#html-options-subfolder_n2_row_id-upload-edit, #html-options-subfolder_n3_row_id-upload-edit, #html-options-subfolder_n4_row_id-upload-edit, #html-options-subfolder_n5_row_id-upload-edit').val('').html('');
                            break;
                        case 'subfolder_n2_row_id-upload-edit':
                            $('#html-options-subfolder_n3_row_id-upload-edit, #html-options-subfolder_n4_row_id-upload-edit, #html-options-subfolder_n5_row_id-upload-edit').val('').html('');
                            break;
                        case 'subfolder_n3_row_id-upload-edit':
                            $('#html-options-subfolder_n4_row_id-upload-edit, #html-options-subfolder_n5_row_id-upload-edit').val('').html('');
                            break;
                        case 'subfolder_n4_row_id-upload-edit':
                            $('#html-options-subfolder_n5_row_id-upload-edit').val('').html('');
                            break;
                        case 'subfolder_n5_row_id-upload-edit':
                            break;
                    }
                    if (data.status == 'success') {
                        $("#" + data.span_id).html(data.html);
                        $("#" + data.child).trigger('change');
                    } else {
                        $("#" + data.span_id).html(data.html);
                    }
                    if ($("#processModal_select-edit")) {
                        processModal.modal('hide');
                    }
                }, 500);
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

function uploadFileEdit() {

    let processModalSaveEdit = bootbox.dialog({
        title: '<h6 class="text-white twentyseventeen-font-size-theme-15-5">Se está procesando la solicitud.</h6>',
        message: '<p class="twentyseventeen-font-size-theme-15-5"><i class="fa fa-spin fa-spinner"></i> Procesando...</p>',
        centerVertical: true,
        closeButton: false
    });
    processModalSaveEdit.init(function () {
        processModalSaveEdit.attr("id", "processModalSaveEdit_select-edit");
        file_data = $('#file-upload-edit')[0].files[0];
        form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('controller', 'CostBudgetController');
        form_data.append('action', 'cost_budget_upload_files');
        form_data.append('function', 'uploadFilesCostBudgetEdit');
        form_data.append('params', JSON.stringify($("#attachment-form-edit").serializeArray()));
        $.ajax({
            url: '../wp-admin/admin-ajax.php',
            type: 'POST',
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data) {                
                setTimeout(function () {
                    if (data.status == 'success') {
                        $('#file-upload-edit').val('');
                        $("#file-upload-status option:selected").prop("selected", false);
                        $('#editFileModal').modal('hide').data('bs.modal', null);
                        $('#cost-budget-file-listing').DataTable().ajax.reload(null, false);
                        Command: toastr[data.status](data.msg);
                    } else {
                        $('#file-upload-edit').val('');
                        Command: toastr[data.status](data.msg);
                    }
                    if ($("#processModalSaveEdit_select-edit")) {
                        processModalSaveEdit.modal('hide');
                    }
                }, 500);
            },
            error: function (msg) {
                setTimeout(function () {
                    Command: toastr['error']('No es posible procesar la solicitud, por favor comunicarse con el administrador');
                    processModalSaveEdit.modal('hide');
                }, 500);
            }
        });
    });
}
function resetattachmentFormEdit(action) {
    switch (action) {
        case 'cancelModal':
            $('#text-file-description-edit, #name-file-upload-edit, #file-upload-edit').val('');
            $('#html-options-subfolder_n1_row_id-upload-edit, #html-options-subfolder_n2_row_id-upload-edit, #html-options-subfolder_n3_row_id-upload-edit, #html-options-subfolder_n4_row_id-upload-edit, #html-options-subfolder_n5_row_id-upload-edit').html('');
            $('#editFileModal').modal('hide').data('bs.modal', null);
            Command: toastr['error']('Proceso cancelado');
            break;
        case 'reset':
            $('#text-file-description-edit, #name-file-upload-edit, #file-upload-edit').val('');
            $('#html-options-subfolder_n1_row_id-upload-edit, #html-options-subfolder_n2_row_id-upload-edit, #html-options-subfolder_n3_row_id-upload-edit, #html-options-subfolder_n4_row_id-upload-edit, #html-options-subfolder_n5_row_id-upload-edit').html('');
            break;
    }
}