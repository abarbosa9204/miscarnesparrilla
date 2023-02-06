<!DOCTYPE html>
<html lang="en">

<head>
    <?php get_header_admin() ?>
</head>

<body>
    <h4>Calidad & Gastronomia</h4>
    <div class="container-fluid">
        <div class="mb-2">
            <a href="javascript:void(0);" type="button" class="btn btn-sm btn-outline-danger twentyseventeen-font-size-theme-15-5" style="min-width: 112px;" onclick="showModalAddFile()"><i class="fa fa-plus"></i> Nuevo</button>
            </a>
        </div>
        <div class="table-responsive">
            <!-- wp-list-table widefat fixed -->
            <table class="table wp-list-table widefat table-striped table-bordered dt-responsive" id="quality-file-listing" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="min-width: 5px">#</th>
                        <th style="width:140px; min-width: 140px">Ruta del<br>archivo</th>
                        <th style="width:100px; min-width: 140px">Nombre</th>
                        <th style="width:250px; min-width: 250px">Descripción</th>
                        <th style="width:50px; min-width: 50px">Estado</th>
                        <th style="width:135px; min-width: 135px">Fecha<br>creación</th>
                        <th style="width:135px; min-width: 135px">Fecha<br> actualización</th>
                        <th style="width:135px; min-width: 135px">Usuario<br> creador</th>
                        <th style="width:150px; min-width: 150px">Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <?php get_footer_admin() ?>
</body>

</html>