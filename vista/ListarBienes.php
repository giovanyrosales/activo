<?php
error_reporting(0);
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Sustitucion_modelo.php';

$bienes = new Bienes();
$sustituciones = new Sustitucion();
if (isset($_GET["tipo"])) {
  switch ($_GET["tipo"]) {
    case "1":
      $datosbienes = $bienes->getMuebles();
      $title = "Bienes Muebles Municipales";
      break;
    case "2":
      $datosbienes = $bienes->getInmuebles();
      $title = "Bienes Inmuebles Municipales";
      break;
    case "3":
      $datosbienes = $bienes->getVehiculos();
      $title = "Vehiculos y Equipos Municipales";
      break;
  }


  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienes Municipales</title>

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
    function edt_id(id, tipo2) {
        $('#editSi').click(function(event) {
            window.location.href = 'EditarBien.php?idbien=' + id + '&tipo=' + tipo2;
        });
    }

    function delete_id(id, tipo) {
        $('#elimSi').click(function(event) {
            window.location.href = '../controlador/Bien_controlador.php?delete_id=' + id + '&tipo=' + tipo;
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
                <li><a href=""><i class="fa fa-dashboard"></i> Lista de Bienes</a></li>
                <li><a href=""><?php echo $title; ?></a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <?php
            if (isset($_GET["del"]) and $_GET["del"] == "2") {
              echo '<div class="alert alert-danger">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Error! </strong>   No se eliminar el registro.
              </div>';
            } else   if (isset($_GET["del"]) and $_GET["del"] == "1") {
              echo '<div class="alert alert-success">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Correcto! </strong> Registro de Bien Eliminado.
              </div>';
            } else   if (isset($_GET["act"]) and $_GET["act"] == "2") {
              echo '<div class="alert alert-danger">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Error! </strong> No se pudo actualizar el Registro.
              </div>';
            } else   if (isset($_GET["act"]) and $_GET["act"] == "1") {
              echo '<div class="alert alert-success">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Correcto! </strong> Registro Actualizado.
              </div>';
            } else   if (isset($_GET["add"]) and $_GET["add"] == "3") {
              echo '<div class="alert alert-danger">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Correcto! </strong> Tamaño excedido para el archivo.
              </div>';
            } else   if (isset($_GET["add"]) and $_GET["add"] == "2") {
              echo '<div class="alert alert-danger">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Error! </strong> No se pudo agregar el Registro.
              </div>';
            } else   if (isset($_GET["add"]) and $_GET["add"] == "1") {
              echo '<div class="alert alert-success">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Correcto! </strong> Registro Completo.
              </div>';
            }
          ?>
            <?php
switch ($_GET["tipo"]) {
    case "1":
    ?>
            <!-- Default box -->
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="example"
                            class="table table-bordered table-striped text-center table-hover table-condensed  mb-0"
                            style=" ">
                            <thead>
                                <tr class="center aligned">
                                    <th class="hidden-xs">
                                        <center># / C&oacute;digo</center>
                                    </th>
                                    <th class="hidden-xs" style="width: 35%">
                                        <center>Descripci&oacute;n</center>
                                    </th>
                                    <th>
                                        <center>Fecha de compra</center>
                                    </th>
                                    <th>
                                        <center>Documentos</center>
                                    </th>
                                    <th class="hidden-xs">
                                        <center>Valor</center>
                                    </th>
                                    <th style="width: 15%;">
                                        <center>Opciones</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <div><input class="btn btn-warning btn-xs" type="button"
                                        onclick=" location.href='../vista/IngresarBien.php' " target="frameprincipal"
                                        value="Nuevo Registro" /></div><br>
                                <?php
                      foreach ($datosbienes as $datos) {
                        ?>
                                <tr class="center aligned">
                                    <td><?php echo $datos["codigo"]; ?></td>
                                    <td><?php echo  substr($datos["descripcion"], 0, 350); ?></td>
                                    <td><?php
                                if ($datos["fechacompra"] != "0000-00-00") {
                                  echo date('d/m/Y', strtotime($datos["fechacompra"]));
                                } ?></td>

                                    <td><?php
                                if (!empty($datos["factura"])) {
                                  echo "<a href='" . $datos["factura"] . "' download='Factura'>Factura</a>&nbsp;";
                                }
                                if (!empty($datos["documento"])) {
                                  echo "<a href='" . $datos["documento"] . "' download='Documento'>Documento</a>";
                                }
                                ?></td>
                                     <?php $susti = $sustituciones->getSustitucionById($datos["idbien"]);
                                      if(count($susti) >= 1){
                                            $valorsus = floatval($datos["valor"]);
                                            foreach($susti as $dat){
                                                $piezanueva = $dat["piezanueva"];
                                                $piezasus = $dat["piezasustituida"];
                                                $valorsus = floatval($valorsus) + floatval($piezanueva) - floatval($piezasus);
                                            } ?>
                                    <td class="hidden-xs"><?php echo "$" . $valorsus ?></td>
                                    <?php 
                                     }else{
                                    ?>
                                    <td class="hidden-xs"><?php echo "$" . $datos["valor"] ?></td>
                                     <?php }?>
                                    <td>
                                        <center>
                                            <table>
                                                <tr>
                                                    <td>
                                                        &nbsp; &nbsp;
                                                        <a onclick="edt_id(<?php echo $datos['idbien'] . "," . $datos["tipo"]; ?>); window.parent.$('body').animate({scrollTop:0}, 'slow');"
                                                            class="btn btn-primary btn-xs" data-toggle="modal"
                                                            data-target="#modalEditar">
                                                            <i class="fa fa-edit" title="Editar"></i>&nbsp; Editar
                                                        </a></td>
                                                    <td>&nbsp; &nbsp;
                                                        <a onclick="delete_id(<?php echo $datos['idbien'] . "," . $datos["tipo"]; ?>); window.parent.$('body').animate({scrollTop:0}, 'slow');"
                                                            class="btn btn-danger btn-xs" data-toggle="modal"
                                                            data-target="#modalEliminar" id="eliminar">
                                                            <i class="fa fa-trash-o" title="Eliminar"></i>&nbsp; Borrar
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
            <?php
      break;
    case "2":
    ?>
            <!-- Default box -->
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="example"
                            class="table table-bordered table-striped text-center table-hover table-condensed  mb-0"
                            style=" ">
                            <thead>
                                <tr class="center aligned">
                                    <th class="hidden-xs">
                                        <center># / C&oacute;digo</center>
                                    </th>
                                    <th class="hidden-xs" style="width: 35%">
                                        <center>Descripci&oacute;n</center>
                                    </th>
                                    <th class="hidden-xs">
                                        <center>$CNR</center>
                                    </th>
                                    <th class="hidden-xs">
                                        <center>Fecha de compra</center>
                                    </th>
                                    <th>
                                        <center>Documentos</center>
                                    </th>
                                    <th class="hidden-xs">
                                        <center>Valor</center>
                                    </th>
                                    <th style="width: 15%;">
                                        <center>Opciones</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <div><input class="btn btn-warning btn-xs" type="button"
                                        onclick=" location.href='../vista/IngresarBien.php' " target="frameprincipal"
                                        value="Nuevo Registro" /></div><br>
                                <?php
                      foreach ($datosbienes as $datos) {
                        ?>
                                <tr class="center aligned">
                                    <td><?php echo $datos["codigo"]; ?></td>
                                    
                                    <td><?php echo  substr($datos["descripcion"], 0, 350); ?></td>
                                    <td><?php echo $datos["inscrito"]; ?></td>
                                    <td><?php
                                if ($datos["fechacompra"] != "0000-00-00") {
                                  echo date('d/m/Y', strtotime($datos["fechacompra"]));
                                } ?></td>

                                    <td><?php
                                if (!empty($datos["factura"])) {
                                  echo "<a href='" . $datos["factura"] . "' download='Factura'>Factura</a>&nbsp;";
                                }
                                if (!empty($datos["documento"])) {
                                  echo "<a href='" . $datos["documento"] . "' download='Documento'>Documento</a>";
                                }
                                ?></td>
                                    <td class="hidden-xs"><?php echo "$" . $datos["valor"] ?></td>
                                    <td>
                                        <center>
                                            <table>
                                                <tr>
                                                    <td>
                                                        &nbsp; &nbsp;
                                                        <a onclick="edt_id(<?php echo $datos['idbien'] . "," . $datos["tipo"]; ?>); window.parent.$('body').animate({scrollTop:0}, 'slow');"
                                                            class="btn btn-primary btn-xs" data-toggle="modal"
                                                            data-target="#modalEditar">
                                                            <i class="fa fa-edit" title="Editar"></i>&nbsp; Editar
                                                        </a></td>
                                                    <td>&nbsp; &nbsp;
                                                        <a onclick="delete_id(<?php echo $datos['idbien'] . "," . $datos["tipo"]; ?>); window.parent.$('body').animate({scrollTop:0}, 'slow');"
                                                            class="btn btn-danger btn-xs" data-toggle="modal"
                                                            data-target="#modalEliminar" id="eliminar">
                                                            <i class="fa fa-trash-o" title="Eliminar"></i>&nbsp; Borrar
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
            <?php
      break;
    case "3":
    ?>
            <!-- Default box -->
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="example"
                            class="table table-bordered table-striped text-center table-hover table-condensed  " >
                            <thead>
                                <tr class="center aligned">
                                    <th style="width: 10%;">
                                    <center>C&oacute;d</center>
                                    </th>
                                    <th  style="width: 35%">
                                        <center>Descripci&oacute;n</center>
                                    </th>
                                    <th style="width: 15%;">
                                        <center>Fecha de compra</center>
                                    </th>
                                    <th style="width: 15%;">
                                        <center>Documentos</center>
                                    </th>
                                    <th style="width: 15%;">
                                        <center>Estado</center>
                                    </th>
                                    <th style="width: 15%;">
                                        <center>Foto</center>
                                    </th>
                                    <th class="hidden-xs">
                                        <center>Valor</center>
                                    </th>
                                    <th style="width: 10%;">
                                        <center>Opciones</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <div><input class="btn btn-warning btn-xs" type="button"
                                        onclick=" location.href='../vista/IngresarBien.php' " target="frameprincipal"
                                        value="Nuevo Registro" /></div><br>
                                <?php
                      foreach ($datosbienes as $datos) {
                        ?>
                                <tr class="center aligned">
                                    <td><?php echo $datos["codigo"]; ?></td>
                                    <td><?php echo  substr($datos["descripcion"], 0, 350); ?></td>
                                    <td><?php
                                if ($datos["fechacompra"] != "0000-00-00") {
                                  echo date('d/m/Y', strtotime($datos["fechacompra"]));
                                } ?></td>

                                    <td><?php
                                if (!empty($datos["factura"])) {
                                  echo "<a href='" . $datos["factura"] . "' download='Factura'>Factura</a>&nbsp;";
                                }
                                if (!empty($datos["documento"])) {
                                  echo "<a href='" . $datos["documento"] . "' download='Documento'>Documento</a>";
                                }
                                ?></td>
                                    <td><?php echo  $datos["estadoeq"]; ?></td>
                                    <td><?php
                                    if (!empty($datos["foto"])) {
                                    echo "<a href='" . $datos["foto"] . "' download><img src='" . $datos["foto"] . "' alt='Foto' style='width:100px;' /></a>";
                                    } ?></td>
                                    <?php 
                                        $susti = $sustituciones->getSustitucionById($datos["idbien"]);
                                      if(count($susti) >= 1){
                                            $valorsus = floatval($datos["valor"]);
                                            foreach($susti as $dat){
                                                $piezanueva = $dat["piezanueva"];
                                                $piezasus = $dat["piezasustituida"];
                                                $valorsus = floatval($valorsus) + floatval($piezanueva) - floatval($piezasus);
                                            }
                                    ?>
                                    <td class="hidden-xs"><?php echo "$" . number_format((float)$valorsus, 2, '.', '') ?></td>
                                    <?php 
                                     }else{
                                    ?>
                                    <td class="hidden-xs"><?php echo "$" . $datos["valor"] ?></td>
                                     <?php 
                                     }
                                    ?>
                                    <td>
                                        <center>
                                            <table>
                                                <tr>
                                                    <td>
                                                        &nbsp; &nbsp;
                                                        <a onclick="edt_id(<?php echo $datos['idbien'] . ',' . $datos['tipo']; ?>);" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalEditar">
                                                            <i class="fa fa-edit" title="Editar"></i>&nbsp; Editar
                                                        </a></td>
                                                    <td>&nbsp; &nbsp;
                                                        <a onclick="delete_id(<?php echo $datos['idbien'] . ',' . $datos['tipo']; ?>); " class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalEliminar" id="eliminar">
                                                            <i class="fa fa-trash-o" title="Eliminar"></i>&nbsp; Borrar
                                                        </a></td>
                                                </tr>
                                            </table>
                                        </center>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <br><br>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <?php
      break;
  }
  ?>

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
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Bienes Muebles</h4>
                </div>
                <div class="modal-body">
                    <b>
                        <p>¿Seguro que desea editar este bien?</p>
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
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Bienes Muebles</h4>
                </div>
                <div class="modal-body">
                    <b>
                        <p>¿Seguro que desea Eliminar este bien?</p>
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

<?php } else { ?>

echo 'error tipo no existe'
<?php } ?>