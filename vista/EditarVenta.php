<?php
error_reporting(0);
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';

$bienes = new Bienes();
$idventa = $_GET["idventa"];
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Activo Fijo</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/datepicker3.css" rel="stylesheet">
        <link href="../css/styles.css" rel="stylesheet">

        <!--Icons-->

    </head>

    <body class="layout-top-nav">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <ol class="breadcrumb">
                    <li><a ><i class="fa fa-dashboard"></i> Activo Fijo e Inventario</a></li>
                    <li><a>Editar Venta</a></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Registro</h3>
                    </div>
                    <div class="box-body">


                        <?php
                        $venta = $bienes->getVenta($idventa);
                        $bien = $bienes->getBien($venta['bien_idbien']);
                        ?>
                        <form role="form" name="form_1" id="form_1" class="form-horizontal" enctype="multipart/form-data" method="post" action="../controlador/Venta_controlador.php" <!-- form horizontal acts as a row -->
                              <br><br>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Descripci&oacute;n:</label>
                                <div class="col-md-7">
                                    <input id="descripcion" name="descripcion" class="form-control"  disabled="true" type="text" value="<?php echo $bien["descripcion"]; ?>">
                                    <input id="bien_idbien" name="bien_idbien" class="form-control" type="hidden" value="<?php echo $venta["bien_idbien"]; ?>">
                                    <input id="codigo" name="codigo" class="form-control" type="hidden" value="<?php echo $bien["codigo"]; ?>">
                                    <input id="idventa" name="idventa" class="form-control" type="hidden" value="<?php echo $venta["idventa"]; ?>">               
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-inline">
                                    <label class="col-md-3 control-label" id="vidautillabel" >Fecha:</label>                                    
                                    <div class="col-md-2">
                                        <input id="fecha" name="fecha" class="form-control" type="date" value="<?php echo $venta["fecha"]; ?>"> 
                                    </div> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Valor:</label>
                                <div class="col-md-2">
                                    <input id="precio" name="precio" class="form-control" type="number" step="any" min="0.01" placeholder="$0.00" style="width: 60%" value="<?php echo $venta["precio"]; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Documento:</label>
                                <div class="col-md-4">
                                    <input id="documento" name="documento" class="form-control" type="file">
                                    <?php
                                    $doc = $bienes->ComprobarDocVenta($venta["idventa"]);
                                    if (!empty($doc["documento"])) {
                                        ?>
                                        <label class="col-md-10" style="color: green;">Ya hay un documento guardada.</label>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Observaciones:</label>
                                <div class="col-md-7">
                                    <input id="observaciones" name="observaciones" class="form-control" type="text" value="<?php echo $venta["observaciones"]; ?>"> 
                                </div>
                            </div>
                            <br><br>
                            <div class="pull-right" style="margin-right: 15%">
                                <button class="btn btn-primary mr5" name="actualizarventa" id="saveForm1" type="submit">Actualizar</button>
                                <input class="btn btn-default" type="button" onclick=" location.href = '../vista/ListarVentas.php?tipo=1'" target="frameprincipal" value="Cancelar" />
                            </div>
                        </form>

                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>

        <!--/.main-->
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap-datepicker.js"></script>
        <script>
                                    $('#calendar').datepicker({});
                                    !function ($) {
                                        $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                                            $(this).find('em:first').toggleClass("glyphicon-minus");
                                        });
                                        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
                                    }(window.jQuery);

                                    $(window).on('resize', function () {
                                        if ($(window).width() > 768)
                                            $('#sidebar-collapse').collapse('show')
                                    })
                                    $(window).on('resize', function() {
                                    if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
                                    })
                                    }
                                    );
        </script>
    </body>

</html>