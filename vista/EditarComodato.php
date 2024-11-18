<?php //error_reporting (0);
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';

$bienes = new Bienes();
$idcomodato = $_GET["idcomodato"];
$datos =  $bienes->getComodato($idcomodato);
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
          <li><a href="#">Modificar Comodato</a></li>
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
              <form role="form" name="form_1" id="form_1" enctype="multipart/form-data" class="form-horizontal" method="post" action="../controlador/Bien_controlador.php" <!-- form horizontal acts as a row -->  
                  <br><br>
                      <div class="form-group">
                          <label class="col-md-3 control-label" >Instituci&oacute;n / Entidad:</label>
                             <div class="col-md-7">
                                 <input id="institucion" name="institucion" class="form-control" type="text" value="<?php echo $datos["institucion"]; ?>"> 
                             </div>
                      </div>
                       <div class="form-group">
                          <label class="col-md-3 control-label" >Nombre y/o Descripci&oacute;n del Bien:</label>
                             <div class="col-md-7">
                                 <div class="input_container">
                                     <?php $datosbien = $bienes->getBien($datos["bien"]); ?>
                                     <input type="text" class="form-control"  id="descripcion" name="descripcion" value="<?php echo $datosbien["descripcion"]; ?>" disabled="true">
                                    <input id="bien" name="bien" class="form-control" type="hidden" value="<?php echo $datos["bien"]; ?>"> 
                                    <input id="idcomodato" name="idcomodato" class="form-control" type="hidden" value="<?php echo $datos["idcomodato"]; ?>"> 
                                 </div>
                             </div>
                        </div>
                  <div class="form-group">
                        <div class="form-inline">
                          <label class="col-md-3 control-label" id="vidautillabel" >Fecha:</label>
                            <div class="col-md-2">
                                <input id="fecha" name="fecha" class="form-control" type="date" value="<?php echo $datos["fecha"]; ?>"> 
                            </div> 
                        </div> </div>
                  <div class="form-group">
                          <label class="col-md-3 control-label" >Observaciones:</label>
                             <div class="col-md-7">
                                 <input id="observaciones" name="observaciones" class="form-control" type="text" value="<?php echo $datos["observaciones"]; ?>"> 
                             </div>
                      </div>
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 15%">
                            <button class="btn btn-primary mr5" name="actualizarcomodato" id="saveForm1" type="submit" >Guardar</button>
                            <input class="btn btn-default" type="button" onclick=" location.href='../vista/ListarComodato.php'" target="frameprincipal" value="Cancelar"/> 
                     </div>
            </form>
          </div>
        </div>
          </section>
      <!-- /.content -->
      </div><!--/.main-->
      <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-datepicker.js"></script>
    <script>
        $('#calendar').datepicker({
        });
        !function ($) {
            $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
                $(this).find('em:first').toggleClass("glyphicon-minus");      
            }); 
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
        }(window.jQuery);

        $(window).on('resize', function () {
          if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function () {
          if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
        })
    </script>
</body>

</html>
