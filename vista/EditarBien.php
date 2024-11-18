<?php //error_reporting(0);
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';
$misc = new Selects();
$bienes = new Bienes();
if(isset($_GET["idbien"]) ){
$idbien = $_GET["idbien"];
}else {
$idbien = "";    
}
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
</head>

<body class="layout-top-nav">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Activo Fijo e Inventario</a></li>
        <li><a href="#">Editar Bien</a></li>
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


          <?php if (isset($_GET["tipo"]) and $_GET["tipo"] == 1) {
            $datos1 = $bienes->getBien($idbien);
            ?>
            <form role="form" name="form_1" id="form_1" class="form-horizontal" enctype="multipart/form-data" method="post" action="../controlador/Bien_controlador.php" <!-- form horizontal acts as a row -->
              <br><br>
              <div class="form-group">
                <label class="col-md-3 control-label">Descripci&oacute;n:</label>
                <div class="col-md-7">
                  <input id="descripcion" name="descripcion" class="form-control" type="text" value="<?php echo $datos1["descripcion"]; ?>">
                  <input id="idbien" name="idbien" class="form-control" type="hidden" value="<?php echo $datos1["idbien"]; ?>">
                  <input id="codigo" name="codigo" class="form-control" type="hidden" value="<?php echo $datos1["codigo"]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Valor:</label>
                <div class="col-md-2">
                  <input id="valor" name="valor" class="form-control" type="number" step="any" min="0.01" placeholder="$0.00" style="width: 60%" value="<?php echo $datos1["valor"]; ?>">
                </div>
              </div>
                
              <div class="form-group">
                <label class="col-md-3 control-label">Fecha de Compra:</label>
                <div class="col-md-2">
                  <input id="fechacompra" name="fechacompra" class="form-control" type="date" value="<?php echo $datos1["fechacompra"]; ?>">
                </div>
                <label class="col-md-3 control-label">A&ntilde;o:</label>
                <div class="col-md-2">
                  <input id="anio" name="anio" class="form-control" type="text" value="<?php echo $datos1["anio"]; ?>" >
                </div>
              </div>
                <?php if($datos1["valor"] >= 600){ ?>
                <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label" id="codcontablelabel">C&oacute;digo Contable:</label>
                <div class="col-md-2">
                  <select name="codcontable" id="codcontable"  class="form-control" style="width: 95%;">
                  <option value="" >Seleccione un C&oacute;digo Contable</option>
                    <?php
                    $codconta = $misc->getCodcontable();
                    foreach ($codconta as $valores) {
                        if($datos1["codcontable"] == $valores["idcodcontable"]){
                      echo '<option selected value="' . $valores['idcodcontable'] . '">' . $valores['nombre'] . " " . $valores['codconta'] . '</option>';
                        }else {
                            echo '<option value="' . $valores['idcodcontable'] . '">' . $valores['nombre'] . " " . $valores['codconta'] . '</option>'; 
                        }
                    }
                    ?>
                  </select>
                </div>
                <label class="col-md-3 control-label" id="coddepreciacionlabel">C&oacute;digo de Depreciaci&oacute;n:</label>
                <div class="col-md-2">
                  <select name="coddepreciacion" id="coddepreciacion" class="form-control" style="width: 95%;">
                  <option value="" selected>Seleccione un C&oacute;digo Depreciacion</option>
                    <?php
                    $coddepre = $misc->getCoddepreciacion();
                    foreach ($coddepre as $valores) {
                         if($datos1["coddepreciacion"] == $valores["idcoddepreciacion"]){
                      echo '<option selected value="' . $valores['idcoddepreciacion'] . '">' . $valores['nombre'] . " " . $valores['coddepre'] . '</option>';
                         }else {
                             echo '<option value="' . $valores['idcoddepreciacion'] . '">' . $valores['nombre'] . " " . $valores['coddepre'] . '</option>';
                         }
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
                  <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label" id="vidautillabel">Vida Util (años):</label>
                <div class="col-md-2">
                  <input id="vidautil" name="vidautil" class=" form-control" type="text" value="<?php echo $datos1["vidautil"]; ?>">
                </div>
                <label class="col-md-3 control-label" id="valresiduallabel">Valor Residual (%):</label>
                <div class="col-md-2">
                 <input id="valresidual" name="valresidual" class=" form-control" type="text" value="<?php echo $datos1["valresidual"]; ?>">
                </div>
              </div>
            </div>
                <div class="form-group">
              <div class="form-inline">
                <label class="col-md-3 control-label" id="tcompralabel">Tipo de Compra:</label>
                <div class="col-md-2">
                 <select name="tcompra" id="tcompra" class="form-control" style="width: 95%;">
                     <?php $tcompra = $misc->getTcompra($datos1["idbien"]); 
                     if($tcompra["tcompra"] == "nuevo"){
                         ?>
                        <option value="" >Seleccione una opci&oacute;n</option>
                        <option value="nuevo"selected>Nuevo</option>
                        <option value="usado">Usado</option>
                         <?php
                     }elseif($tcompra["tcompra"] == "usado"){
                         ?>
                        <option value="" >Seleccione una opci&oacute;n</option>
                        <option value="nuevo">Nuevo</option>
                        <option value="usado" selected>Usado</option>
                      <?php
                     }else{
                         ?>
                        <option value="" selected >Seleccione una opci&oacute;n</option>
                        <option value="nuevo">Nuevo</option>
                        <option value="usado" >Usado</option>
                     <?php
                     } 
                     ?> 
                 </select>
                </div>
                <label class="col-md-3 control-label" id="origenlabel">Origen:</label>
                <div class="col-md-2">
                 <select name="origen" id="origen" class="form-control" style="width: 95%;">
                     <?php $origen = $misc->getOrigen($datos1["idbien"]); 
                     if($origen["origen"] == "propio"){
                         ?>
                        <option value="" >Seleccione una opci&oacute;n</option>
                        <option value="propio"selected>Propio</option>
                        <option value="proyecto">Proyecto</option>
                         <?php
                     }elseif($origen["origen"] == "proyecto"){
                         ?>
                        <option value="" >Seleccione una opci&oacute;n</option>
                        <option value="propio">Propio</option>
                        <option value="proyecto" selected>Proyecto</option>
                      <?php
                     }else{
                         ?>
                        <option value="" selected >Seleccione una opci&oacute;n</option>
                        <option value="propio">Propio</option>
                        <option value="proyecto" >Proyecto</option>
                     <?php
                     } 
                     ?> 
                 </select>
                </div>
              </div>
            </div>
          <?php } ?>
              <div class="form-group">
                <label class="col-md-3 control-label">Orden de Compra:</label>
                <div class="col-md-4">
                  <input id="orden" name="orden" class="form-control" type="file">
                  <?php $doc = $bienes->ComprobarDoc($datos1["idbien"]);
                    if (!empty($doc["documento"])) { ?>
                    <label class="col-md-10" style="color: green;">Ya hay una orden guardada.</label>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Factura:</label>
                <div class="col-md-4">
                  <input id="factura" name="factura" class="form-control" type="file">
                  <?php $fac = $bienes->ComprobarFac($datos1["idbien"]);
                    if (!empty($fac["factura"])) { ?>
                    <label class="col-md-10" style="color: green;">Ya hay una factura guardada.</label>
                  <?php } ?>
                </div>
              </div>
              <br>
              <br>
              <div class="pull-right" style="margin-right: 15%">
                <button class="btn btn-primary mr5" name="actualizarmueble" id="saveForm1" type="submit">Actualizar</button>
                <input class="btn btn-default" type="button" onclick=" location.href='../vista/ListarBienes.php?tipo=1'" target="frameprincipal" value="Cancelar" />
              </div>
            </form>
          <?php }

          if (isset($_GET["tipo"]) and $_GET["tipo"] == 2) {
            $datos2 = $bienes->getBien($idbien);
            ?>
            <form role="form" name="form_2" id="form_2" class="form-horizontal" enctype="multipart/form-data" method="post" action="../controlador/Bien_controlador.php" <!-- form horizontal acts as a row -->
              <br><br>
              <div class="form-group">
                <label class="col-md-3 control-label">Descripci&oacute;n:</label>
                <div class="col-md-7">
                  <input id="descripcion" name="descripcion" class="form-control" type="text" value="<?php echo $datos2["descripcion"]; ?>">
                  <input id="idbien" name="idbien" class="form-control" type="hidden" value="<?php echo $datos2["idbien"]; ?>">
                  <input id="codigo" name="codigo" class="form-control" type="hidden" value="<?php echo $datos2["codigo"]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Valor:</label>
                <div class="col-md-2">
                  <input id="valor" name="valor" class="form-control" type="number" step="any" min="0.01" placeholder="$0.00" style="width: 60%" value="<?php echo $datos2["valor"]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Fecha de Compra:</label>
                <div class="col-md-2">
                  <input id="fechacompra" name="fechacompra" class="form-control" type="date" value="<?php echo $datos2["fechacompra"]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Documento:</label>
                <div class="col-md-4">
                  <input id="documento" name="documento" accept="application/pdf" class=" form-control" type="file">
                  <?php $doct = $bienes->ComprobarDoc($datos2["idbien"]);
                    if (!empty($doct["documento"])) { ?>
                    <label class="col-md-10" style="color: green;">Ya hay un documento guardada.</label>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Observaciones:</label>
                <div class="col-md-7">
                  <input id="observaciones" name="observaciones" class="form-control" type="text" maxlength="350" value="<?php echo $datos2["observaciones"]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Edificaciones</label>
                <div class="col-md-7">
                  <input id="edificaciones" name="edificaciones" class="form-control" type="text" maxlength="40" value="<?php echo $datos2["edificaciones"]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">#CNR</label>
                <div class="col-md-7">
                  <input id="edificaciones" name="inscrito" class="form-control" type="text" maxlength="40" value="<?php echo $datos2["inscrito"]; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Fecha Permuta</label>
                <div class="col-md-7">
                  <input id="permuta" name="permuta" class="form-control" type="date" value="<?php echo $datos2["permuta"]; ?>">
                </div>
              </div>
              <br>
              <div class="pull-right" style="margin-right: 15%">
                <button class="btn btn-primary mr5" name="actualizarinmueble" id="saveForm" type="submit">Actualizar</button>
                <input class="btn btn-default" type="button" onclick=" location.href='../vista/ListarBienes.php?tipo=2'" target="frameprincipal" value="Cancelar" />
              </div>
              <?php
                ?>
            </form>
          <?php }

          if (isset($_GET["tipo"]) and $_GET["tipo"] == 3) {
            $datos3 = $bienes->getBien($idbien);
            ?>
            <form role="form" name="form_3" id="form_3" class="form-horizontal" enctype="multipart/form-data" method="post" action="../controlador/Bien_controlador.php" <!-- form horizontal acts as a row -->
              <br>
              <div class="container">
              <div class="form-group row">
                  <div class="col-md-8">
                  <label for="descripcion" class="col-form-label col-sm-2">Descripci&oacute;n:</label>
                    <div class="col-sm-10">
                      <input id="descripcion" name="descripcion" class="form-control" type="text" value="<?php echo $datos3["descripcion"]; ?>">
                      <input id="idbien" name="idbien" class="form-control" type="hidden" value="<?php echo $datos3["idbien"]; ?>">
                      <input id="codigo" name="codigo" class="form-control" type="hidden" value="<?php echo $datos3["codigo"]; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="origen" class="col-form-label col-sm-4">Origen:</label>
                    <div class="col-sm-8">
                      <select name="origen" id="origen" class="form-control" >
                        <?php $origen = $misc->getOrigen($datos1["idbien"]); 
                        if($origen["origen"] == "propio"){
                            ?>
                            <option value="" >Seleccione una opci&oacute;n</option>
                            <option value="propio"selected>Propio</option>
                            <option value="proyecto">Proyecto</option>
                            <?php
                        }elseif($origen["origen"] == "proyecto"){
                            ?>
                            <option value="" >Seleccione una opci&oacute;n</option>
                            <option value="propio">Propio</option>
                            <option value="proyecto" selected>Proyecto</option>
                          <?php
                        }else{
                            ?>
                            <option value="" selected >Seleccione una opci&oacute;n</option>
                            <option value="propio">Propio</option>
                            <option value="proyecto" >Proyecto</option>
                        <?php
                        } 
                        ?> 
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-4">
                    <label for="fechacompra" class="col-form-label col-sm-6">Fecha de Compra:</label>
                    <div class="col-sm-6">
                      <input id="fechacompra" name="fechacompra" class="form-control" type="date" value="<?php echo $datos3["fechacompra"]; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                  <label for="tcompra" class="col-form-label col-sm-4">Tipo de Compra:</label>
                    <div class="col-sm-8">
                      <select name="tcompra" id="tcompra" class="form-control" style="width: 95%;">
                        <?php $tcompra = $misc->getTcompra($datos3["idbien"]); 
                          if($tcompra["tcompra"] == "nuevo"){
                              ?>
                              <option value="" >Seleccione una opci&oacute;n</option>
                              <option value="nuevo"selected>Nuevo</option>
                              <option value="usado">Usado</option>
                              <?php
                          }elseif($tcompra["tcompra"] == "usado"){
                              ?>
                              <option value="" >Seleccione una opci&oacute;n</option>
                              <option value="nuevo">Nuevo</option>
                              <option value="usado" selected>Usado</option>
                            <?php
                          }else{
                              ?>
                              <option value="" selected >Seleccione una opci&oacute;n</option>
                              <option value="nuevo">Nuevo</option>
                              <option value="usado" >Usado</option>
                          <?php
                          } 
                          ?> 
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="vidautil" class="col-form-label col-sm-6">Vida Util(Años):</label>
                    <div class="col-sm-6">
                        <input id="vidautil" name="vidautil" class=" form-control" type="text" value="<?php echo $datos3["vidautil"]; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-4">
                    <label for="valor" class="col-form-label col-sm-6">Valor de compra:</label>
                    <div class="col-sm-6">
                    <input id="valor" name="valor" class="form-control" type="text" value="<?php echo $datos3["valor"]; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                  <label for="placa" class="col-form-label col-sm-4">Placa:</label>
                    <div class="col-sm-8">
                      <input id="placa" name="placa" class="form-control" type="text" value="<?php echo $datos3["placa"]; ?>" >
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="anio" class="col-form-label col-sm-4">A&ntilde;o:</label>
                    <div class="col-sm-8">
                      <input id="anio" name="anio" class="form-control" type="text" value="<?php echo $datos3["anio"]; ?>" >
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-4">
                    <label for="codcontable" class="col-form-label col-sm-3">Código Contable:</label>
                    <div class="col-sm-9">
                      <select name="codcontable" id="codcontable"  class="form-control" style="width: 95%;">
                        <option value="" >Seleccione un C&oacute;digo Contable</option>
                          <?php
                          $codconta = $misc->getCodcontable();
                          foreach ($codconta as $valores) {
                              if($datos3["codcontable"] == $valores["idcodcontable"]){
                            echo '<option selected value="' . $valores['idcodcontable'] . '">' . $valores['nombre'] . " " . $valores['codconta'] . '</option>';
                              }else {
                                  echo '<option value="' . $valores['idcodcontable'] . '">' . $valores['nombre'] . " " . $valores['codconta'] . '</option>'; 
                              }
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                  <label for="coddepreciacion" class="col-form-label col-sm-3">Código de Depreación:</label>
                    <div class="col-sm-9">
                        <select name="coddepreciacion" id="coddepreciacion" class="form-control" style="width: 95%;">
                          <option value="" selected>Seleccione un C&oacute;digo Depreciacion</option>
                            <?php
                            $coddepre = $misc->getCoddepreciacion();
                            foreach ($coddepre as $valores) {
                                if($datos3["coddepreciacion"] == $valores["idcoddepreciacion"]){
                              echo '<option selected value="' . $valores['idcoddepreciacion'] . '">' . $valores['nombre'] . " " . $valores['coddepre'] . '</option>';
                                }else {
                                    echo '<option value="' . $valores['idcoddepreciacion'] . '">' . $valores['nombre'] . " " . $valores['coddepre'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="valresidual" class="col-form-label col-sm-6">Valor Residual(%):</label>
                    <div class="col-sm-6">
                      <input id="valresidual" name="valresidual" class=" form-control" type="text" value="<?php echo $datos3["valresidual"]; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                  <label for="motorista" class="col-form-label col-sm-4">Motorista:</label>
                  <div class="col-sm-8">
                      <input id="motorista" name="motorista" class="form-control" type="text" value="<?php echo $datos3["motorista"]; ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="encargado" class="col-form-label col-sm-4">Encargado:</label>
                    <div class="col-sm-8">
                      <input id="encargado" name="encargado" class="form-control" type="text" value="<?php echo $datos3["encargado"]; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                  <label for="estadoeq" class="col-form-label col-sm-2">Estado del Bien:</label>
                    <div class="col-sm-10">
                      <input id="estadoeq" name="estadoeq" class=" form-control" type="text" value="<?php echo $datos3["estadoeq"]; ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="foto" class="col-form-label col-sm-4">Fotografía:</label>
                    <div class="col-sm-8">
                      <input id="foto" name="foto" accept="image/jpeg, image/jpg" class=" form-control" type="file">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                  <label for="orden" class="col-form-label col-sm-4">Orden Compra:</label>
                    <div class="col-sm-8">
                      <input id="orden" name="orden" accept="application/pdf" class=" form-control" type="file">
                      <?php $doct = $bienes->ComprobarDoc($datos3["idbien"]);
                        if (!empty($doct["documento"])) { ?>
                        <label class="col-form-label col-sm-10" style="color: green;">Ya hay un documento guardada.</label>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="factura" class="col-form-label col-sm-4">Factura:</label>
                    <div class="col-sm-8">
                      <input id="factura" name="factura" accept="application/pdf" class=" form-control" type="file">
                      <?php $fact = $bienes->ComprobarFac($datos3["idbien"]);
                        if (!empty($fact["factura"])) { ?>
                        <label class="col-form-label col-sm-10" style="color: green;">Ya hay una factura guardada.</label>
                      <?php } ?>
                    </div>
                  </div>
                </div>  
              </div>
              
              <br>
              <div class="pull-right" style="margin-right: 15%">
                <button class="btn btn-primary mr5" name="actualizarvehimaq" id="saveForm1" type="submit">Actualizar</button>
                <input class="btn btn-default" type="button" onclick=" location.href='../vista/ListarBienes.php?tipo=3'" target="frameprincipal" value="Cancelar" />
              </div>
            </form>
          <?php } ?>

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
</body>

</html>