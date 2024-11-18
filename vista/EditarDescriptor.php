<?php //error_reporting (0);
require_once '../modelo/Config_modelo.php';
require_once '../modelo/Select_modelo.php';

$config = new Config();
if(isset($_GET["iddescriptor"]) ){
$iddescriptor = $_GET["iddescriptor"];
} else {
$iddescriptor = "";
}

$datos =  $config->getDescriptor($iddescriptor);
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
            <li><a href="#">Modificar Descriptor</a></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
           <!-- Default box -->
        <div class="box box-solid box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Editar Descriptor</h3>
          </div>
          <div class="box-body">   
              <form role="form" name="form_1" id="form_1" enctype="multipart/form-data" class="form-horizontal" method="post" action="../controlador/Config_controlador.php" <!-- form horizontal acts as a row -->  
                  <br><br>
                      <div class="form-group">
                          <label class="col-md-3 control-label" >C&oacute;digo de descriptor:</label>
                             <div class="col-md-7">
                                 <input id="codigodes" name="codigodes" class="form-control" type="text" value="<?php echo $datos["codigodes"]; ?>"> 
                                 <input id="iddescriptor" name="iddescriptor"  type="hidden" value="<?php echo $datos["iddescriptor"]; ?>"> 
                             </div>
                      </div>
                  <div class="form-group">
                          <label class="col-md-3 control-label" >Nombre del Descriptor:</label>
                             <div class="col-md-7">
                                 <input id="descripcion" name="descripcion" class="form-control" type="text" value="<?php echo $datos["descripcion"]; ?>"> 
                             </div>
                      </div>
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 15%">
                            <button class="btn btn-primary mr5" name="actualizardescriptor" id="saveForm1" type="submit" >Guardar</button>
                            <input class="btn btn-default" type="button" onclick=" location.href='../vista/ListarDescriptor.php'" target="frameprincipal" value="Cancelar"/> 
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
