<?php
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';
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
  <script src="../js/lumino.glyphs.js"></script>
  <script>
    function myFunction() {
      //Para Bienes mubles iguales, mayores o menores que $900.00, para activar codigo contable, de depreciacion, vida util y valor residual
      if (document.getElementById("valor").value >= 900) {
        document.getElementById("codcontable").disabled = false;
        document.getElementById("coddepreciacion").disabled = false;
        document.getElementById("vidautil").disabled = false;
        document.getElementById("valresidual").disabled = false;
        document.getElementById("tcompra").disabled = false;
        document.getElementById("saveForm1").name = "agregarbienmueble900";
      } else {
        document.getElementById("codcontable").disabled = true;
        document.getElementById("coddepreciacion").disabled = true;
        document.getElementById("vidautil").disabled = true;
        document.getElementById("valresidual").disabled = true;
        document.getElementById("tcompra").disabled = true;
        document.getElementById("saveForm1").name = "agregarbienmueble";
      }
    }
  </script>
</head>

<body class="layout-top-nav">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Activo Fijo e Inventario</a></li>
        <li><a href="#">Ingresar Nuevo Bien</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-solid box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Nuevo Registro</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label class="col-md-2 control-label" style="margin-top: 8px;">Tipo de Bien a Registrar:</label>
            <div class="col-md-3">
              <select class="form-control">
                <option value="" selected="selected">Seleccione una opcion..</option>
                <option value="form_1">Bienes Muebles</option>
                <option value="form_2">Bienes Inmuebles</option>
                <option value="form_3">Vehiculos y Maquinaria</option>
              </select>
            </div>
          </div>
          <br>
          <form role="form" name="form_1" id="form_1" style="display:none" enctype="multipart/form-data" class="form-horizontal"  method="post" action="../controlador/Bien_controlador.php" <!-- form horizontal acts as a row -->
            <br><br>
            
            <div class="form-group">
              <label class="col-md-3 control-label">Descripci&oacute;n:</label>
              <div class="col-md-7">
                <input id="descripcion" name="descripcion" class="form-control" type="text" value="" required>
                <input id="tipo" name="tipo" class="form-control" type="hidden" value="1">
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Valor:</label>
                <div class="col-md-2">
                  <input id="valor" name="valor" class="form-control" type="number" step="any" maxlength="350" min="0.00" placeholder="$0.00" style="width: 60%" oninput="myFunction();" required>
                </div>
                <label class="col-md-3 control-label">Fecha de Compra:</label>
                <div class="col-md-2">
                  <input id="fechacompra" name="fechacompra" class="form-control" type="date" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Departamento:</label>
                <div class="col-md-2">
                  <select name="departamento" id="departamento" required class="form-control" style="width: 95%;">
                  <option value="" disabled selected>Seleccione un departamento</option>
                    <?php
                    $misc = new Selects();
                    $departamentos = $misc->getDepartamento();
                    foreach ($departamentos as $valores) {
                      echo '<option value="' . $valores['iddepartamento'] . '">' . $valores['nombre'] . '</option>';
                    }
                    ?>
                  </select>
                </div><label class="col-md-3 control-label">Descriptor:</label>
                <div class="col-md-2">
                  <select name="descriptor" id="descriptor" required class="form-control" style="width: 95%;">
                  <option value="" disabled selected>Seleccione un escritor</option>
                    <?php
                    $desc = $misc->getDescriptor();
                    foreach ($desc as $valores) {
                      echo '<option value="' . $valores['iddescriptor'] . '">' . $valores['descripcion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label" id="codcontablelabel">C&oacute;digo Contable:</label>
                <div class="col-md-2">
                  <select name="codcontable" id="codcontable" disabled="true" required class="form-control" style="width: 95%;">
                  <option value="" disabled selected>Seleccione un C&oacute;digo Contable</option>
                    <?php
                    $codconta = $misc->getCodcontable();
                    foreach ($codconta as $valores) {
                      echo '<option value="' . $valores['idcodcontable'] . '">' . $valores['nombre'] . " " . $valores['codconta'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <label class="col-md-3 control-label" id="coddepreciacionlabel">C&oacute;digo de Depreciaci&oacute;n:</label>
                <div class="col-md-2">
                  <select name="coddepreciacion" id="coddepreciacion" disabled="true" required class="form-control" style="width: 95%;">
                  <option value="" disabled selected>Seleccione un C&oacute;digo Depreciacion</option>
                    <?php
                    $coddepre = $misc->getCoddepreciacion();
                    foreach ($coddepre as $valores) {
                      echo '<option value="' . $valores['idcoddepreciacion'] . '">' . $valores['nombre'] . " " . $valores['coddepre'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
              <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label" id="tcompralabel">Tipo de Compra:</label>
                <div class="col-md-2">
                 <select name="tcompra" id="tcompra" class="form-control" style="width: 95%;" disabled="true">
                        <option value="" selected>Seleccione una opci&oacute;n</option>
                        <option value="nuevo">Nuevo</option>
                        <option value="usado">Usado</option>
                 </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label" id="vidautillabel">Vida Util:</label>
                <div class="col-md-2">
                  <input id="vidautil" name="vidautil" class="form-control" type="text" disabled="true" value="" required>
                </div>
                <label class="col-md-3 control-label" id="valresiduallabel">Valor Residual:</label >
                <div class="col-md-2">
                  <input id="valresidual" name="valresidual" class="form-control" disabled="true" type="text" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Documento:</label>
              <div class="col-md-4">
                <input id="documento" name="documento" accept="application/pdf class=" form-control" type="file">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Factura:</label>
              <div class="col-md-4">
                <input id="factura" name="factura" accept="application/pdf class=" form-control" type="file">
              </div>
            </div>
            <br>
            <div class="pull-right" style="margin-right: 15%">
              <button class="btn btn-primary mr5" name="agregarbienmueble" id="saveForm1" type="submit">Guardar</button>
              <input class="btn btn-default" type="button" onclick=" location.href='../vista/IngresarBien.php'" target="frameprincipal" value="Cancelar" />
            </div>
          </form>
          <form role="form" name="form_2" id="form_2" style="display:none" enctype="multipart/form-data" class="form-horizontal" method="post" action="../controlador/Bien_controlador.php" <!-- form horizontal acts as a row -->
            <br><br>
            <div class="form-group">
              <label class="col-md-3 control-label">Descripci&oacute;n:</label>
              <div class="col-md-7">
                <input id="descripcion" name="descripcion" class="form-control" type="text" value="" required>
                <input id="codigo" name="codigo" class="form-control" type="hidden" value="">
                <input id="tipo" name="tipo" class="form-control" type="hidden" value="2">
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Valor:</label>
                <div class="col-md-2">
                  <input id="valor" name="valor" class="form-control" type="number" step="any" maxlength="350" min="0.00" placeholder="$0.00" style="width: 60%" required>
                </div>
                <label class="col-md-3 control-label">Fecha de Compra:</label>
                <div class="col-md-2">
                  <input id="fechacompra" name="fechacompra" class="form-control" type="date" >
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">ubicaci&oacute;n:</label>
                <div class="col-md-2">
                  <input id="ubicacion" name="ubicacion" class="form-control" type="text" value="" required>
                </div>
                <label class="col-md-3 control-label">Contiene:</label>
                <div class="col-md-3">
                  <input id="contiene" name="contiene" class="form-control" type="text" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Documento:</label>
                <div class="col-md-4">
                  <input id="documento" name="documento" class="form-control" type="file" >
                </div>
               
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
              <label class="col-md-3 control-label"># de Inscripci&oacute;n CNR:</label>
                <div class="col-md-2">
                  <input id="inscrito" name="inscrito" class="form-control" type="text" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Valor Registrado:</label>
                <div class="col-md-2">
                  <input id="valorregistrado" name="valorregistrado" class="form-control" value="" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Observaciones:</label>
              <div class="col-md-7">
                <input id="observaciones" name="observaciones" class="form-control" type="text" maxlength="350" value="">
              </div>
            </div>
            <br>
            <div class="pull-right" style="margin-right: 15%">
              <button class="btn btn-primary mr5" name="agregarbieninmueble" id="saveForm" type="submit">Guardar</button>
              <input class="btn btn-default" type="button" onclick=" location.href='../vista/IngresarBien.php'" target="frameprincipal" value="Cancelar" />
            </div>
          </form>
          <form role="form" name="form_3" id="form_3" style="display:none" enctype="multipart/form-data" class="form-horizontal" method="post" action="../controlador/Bien_controlador.php" <!-- form horizontal acts as a row -->
            <br><br>
            <!--<div class="form-group">
              <label class="col-md-3 control-label">C&oacute;digo:</label>
              <div class="col-md-4">
                <input id="codigo" name="codigo" class="form-control" type="text" value="" >
              </div>
            </div>-->
            <div class="form-group">
              <label class="col-md-3 control-label">Descripci&oacute;n:</label>
              <div class="col-md-7">
                <input id="descripcion" name="descripcion" class="form-control" type="text" value=""  required>
                <input id="tipo" name="tipo" class="form-control" type="hidden" value="3">
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Valor:</label>
                <div class="col-md-2">
                  <input id="valor" name="valor" class="form-control" type="number" step="any" maxlength="350" min="0.00" placeholder="$0.00" style="width: 60%"  required>
                </div>
                <label class="col-md-3 control-label">Fecha de Compra:</label>
                <div class="col-md-2">
                  <input id="fechacompra" name="fechacompra" class="form-control"  type="date"  required>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Departamento:</label>
                <div class="col-md-2">
                  <select name="departamento" id="departamento" class="form-control" style="width: 95%;"  required>
                    <option value="Seleccion un departamento" disabled="disabled" selected ></option>
                    <?php
                    $departamentos2 = $misc->getDepartamento();
                    foreach ($departamentos2 as $valores) {
                      echo '<option value="' . $valores['iddepartamento'] . '">' . $valores['nombre'] . '</option>';
                    }
                    ?>
                  </select>
                </div> <label class="col-md-3 control-label">A&ntilde;o:</label>
                <div class="col-md-2">
                  <input id="anio" name="anio" class="form-control" type="text" value=""  required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Placa:</label>
                <div class="col-md-2">
                  <input id="placa" name="placa" class="form-control" type="text" value="" required>
                </div> 
                <label class="col-md-3 control-label">Fecha de Vec. Tarjeta:</label>
                <div class="col-md-2">
                  <input id="fechavectar" name="fechavectar" class="form-control" type="date"  required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label">Motorista:</label>
                <div class="col-md-2">
                  <input id="motorista" name="motorista" class="form-control" type="text" value=""  >
                </div>
                <label class="col-md-3 control-label">Encargado:</label>
                <div class="col-md-2">
                  <input id="encargado" name="encargado" class="form-control" type="text" >
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label" id="codcontablelabel">C&oacute;digo Contable:</label>
                <div class="col-md-2">
                  <select name="codcontable" id="codcontable"  required class="form-control" style="width: 95%;">
                    <option  disabled="disabled" selected >-------------------</option>
                    <?php
                    $codconta2 = $misc->getCodcontable();
                    foreach ($codconta2 as $valores) {
                      echo '<option  value="' . $valores['idcodcontable'] . '">' . $valores['nombre'] . " " . $valores['codconta'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <label class="col-md-3 control-label" id="coddepreciacionlabel">C&oacute;digo de Depreciaci&oacute;n:</label>
                <div class="col-md-2">
                  <select name="coddepreciacion" id="coddepreciacion"  required class="form-control" style="width: 95%;">
                    <option  disabled="disabled" selected >-------------------</option>
                    <?php
                    $coddepre2 = $misc->getCoddepreciacion();
                    foreach ($coddepre2 as $valores) {
                      echo '<option   value="' . $valores['idcoddepreciacion'] . '">' . $valores['nombre'] . " " . $valores['coddepre'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label" id="vidautillabel">Vida Util:</label>
                <div class="col-md-2">
                  <input id="vidautil" name="vidautil" class="form-control" type="text" value="" style="width: 60%"  required>
                </div>
                <label class="col-md-3 control-label" id="valresiduallabel">Valor Residual:</label>
                <div class="col-md-2">
                  <input id="valresidual" name="valresidual" class="form-control" type="text" style="width: 60%"  required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Documento:</label>
              <div class="col-md-4">
                <input id="documento" name="documento" accept="application/pdf" class="form-control" type="file">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Factura:</label>
              <div class="col-md-4">
                <input id="factura" name="factura" accept="application/pdf" class="form-control" type="file">
              </div>
            </div>
             <div class="form-group">
              <div class="form-inline">
                   <label class="col-md-3 control-label">Observaciones:</label>
              <div class="col-md-2">
                <input id="observaciones" name="observaciones" class="form-control" type="text" maxlength="350" value="">
              </div>
                <label class="col-md-3 control-label" id="tcompralabel">Tipo de Compra:</label>
                <div class="col-md-2">
                 <select name="tcompra" id="tcompra" class="form-control" style="width: 95%;">
                        <option value="" selected>Seleccione una opci&oacute;n</option>
                        <option value="nuevo">Nuevo</option>
                        <option value="usado">Usado</option>
                 </select>
                </div>
              </div>
            </div>
           
            <br>
            <div class="pull-right" style="margin-right: 15%">
              <button class="btn btn-primary mr5" name="agregarvehymaq" id="saveForm1" type="submit">Guardar</button>
              <input class="btn btn-default" type="button" onclick=" location.href='../vista/IngresarBien.php'" target="frameprincipal" value="Cancelar" />
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

    ! function($) {
      $(document).on("click", "ul.nav li.parent > a > span.icon", function() {
        $(this).find('em:first').toggleClass("glyphicon-minus");
      });
      $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function() {
      if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function() {
      if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
  </script>
  <script>
    $("select").on("change", function() {
      $("#" + $(this).val()).show().siblings().hide();
    });
    ;
  </script>
</body>

</html>
