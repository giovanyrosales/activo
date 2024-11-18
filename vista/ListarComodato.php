    <?php error_reporting (0);?>
    <?php
require_once '../modelo/Bien_modelo.php';

$bienes = new Bienes();
$datos = $bienes->getComodatos();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Comodatos</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <!--<link href="../css/datepicker3.css" rel="stylesheet">-->
        <link href="../css/styles.css" rel="stylesheet">
        <link rel="stylesheet" href="../js/datatables/dataTables.bootstrap.css">
        <!--Icons-->
        <!--<script src="../js/lumino.glyphs.js"></script>-->
        <script src="../js/jQuery-2.2.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/datatables/jquery.dataTables.min.js"></script>
        <script src="../js/datatables/dataTables.bootstrap.min.js"></script>

        <script type="text/javascript">
        function edt_id(id) {
            $('#editSi').click(function(event) {
                window.location.href = 'EditarComodato.php?idcomodato=' + id;
            });
        }

        function delete_id(id) {
            $('#elimSi').click(function(event) {
                window.location.href = '../controlador/Bien_controlador.php?delcomodato=' + id;
            });
        }
        jQuery(document).ready(function($) {
            $('table').on('click', '#eliminar', function(event) {
                event.preventDefault();
                /* Act on the event */
                var e = $(this);
                $('#modalEliminar .modal-title').text(e.data('titulo'));
                $('#modalEliminar #cuerpo').text(e.data('detalle'));

                $('body', window.parent.document).animate({
                    scrollTop: 0
                }, 800);
            });

        });
        </script>
        <style>
        .my-custom-scrollbar {
            position: relative;
            height: 620px;
            overflow: auto;
            overflow-x: hidden;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        </style>
    </head>

    <body class="layout-top-nav">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i>Comodatos</a></li>
                    <li><a href="#">Comodatos Registrados</a></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php
        if (isset($_GET["del"]) AND $_GET["del"] == "2") {
        echo '<div class="alert alert-danger">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Error! </strong>   No se eliminar el registro del comodato.
              </div>';
        }else   if (isset($_GET["del"]) AND $_GET["del"] == "1") {
                echo '<div class="alert alert-success">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Correcto! </strong> Registro del comodato Eliminado, el documento se conservara.
              </div>';
        } if (isset($_GET["act"]) AND $_GET["act"] == "2") {
        echo '<div class="alert alert-danger">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Error! </strong> No se pudo actualizar el registro del comodato.
              </div>';
        }else   if (isset($_GET["act"]) AND $_GET["act"] == "1") {
                echo '<div class="alert alert-success">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Correcto! </strong> Registro de Comodato Modificado con exito.
              </div>';
        } ?>
                <!-- Default box -->
                <div class="box box-solid box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
                            <table id="example"
                                class="table table-bordered table-striped text-center table-hover table-condensed">
                                <thead>
                                    <tr class="center aligned">
                                        <th>
                                            <center>Instituci&oacute;n</center>
                                        </th>
                                        <th class="hidden-xs" style="width: 35%">
                                            <center>Bien</center>
                                        </th>
                                        <th class="hidden-xs" style="width: 20%">
                                            <center>Fecha</center>
                                        </th>
                                        <th style="width: 15%;">
                                            <center>Opciones</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div><input class="btn btn-warning btn-xs" type="button"
                                            onclick=" location.href='../vista/IngresarComodato.php' "
                                            target="frameprincipal" value="Agregar Comodato" /></div><br>
                                    <?php
            foreach($datos as $val) {
          ?>
                                    <tr class="center aligned">
                                        <td><?php echo $val["institucion"]; ?></td>
                                        <?php $datosbien = $bienes->getBien($val["bien"]); ?>
                                        <td><?php echo $datosbien["descripcion"]; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($val["fecha"])); ?></td>
                                        <td>
                                            <center>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            &nbsp; &nbsp;
                                                            <a onclick="edt_id(<?php echo $val['idcomodato']; ?>); window.parent.$('body').animate({scrollTop:0}, 'slow');"
                                                                class="btn btn-primary btn-xs" data-toggle="modal"
                                                                data-target="#modalEditar">
                                                                <i class="fa fa-edit" title="Editar"></i>&nbsp; Editar
                                                            </a></td>
                                                        <td>&nbsp; &nbsp;
                                                            <a onclick="delete_id(<?php echo $val['idcomodato']; ?>); window.parent.$('body').animate({scrollTop:0}, 'slow');"
                                                                class="btn btn-danger btn-xs" data-toggle="modal"
                                                                data-target="#modalEliminar" id="eliminar">
                                                                <i class="fa fa-trash-o" title="Eliminar"></i>&nbsp;
                                                                Borrar
                                                            </a></td>
                                                    </tr>
                                                </table>
                                            </center>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!--Modal Editar-->
        <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="basicModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span></button>
                        <h4 class="modal-title">Comodatos</h4>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p>¿Seguro que desea editar el registrod de Comodato?</p>
                        </b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="editSi">Si</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Modal Eliminar-->
        <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="basicModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span></button>
                        <h4 class="modal-title">Comodatos</h4>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p>¿Seguro que desea Eliminar el Registro de Comodato?</p>
                        </b>
                        <p id="cuerpo" class="text-justify"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="elimSi">Si</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </body>
    <script>
$(document).ready(function() {
    $('#example').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
        }
    });
});
//    Oculta la informacion bajo la datatable para que se muestre completa la tabla en el movil
$.extend(true, $.fn.dataTable.defaults, {
    "info": false
});
    </script>

    </html>