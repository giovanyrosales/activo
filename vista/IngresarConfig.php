<?php
require_once '../modelo/Config_modelo.php';

if(isset($_GET["tipo"])){
    switch ($_GET["tipo"]) {
    case "depto":
        $title = "Nuevo Departamento";
        break;
    case "descriptor":
         $title = "Nuevo Descriptor";
        break;
    case "codconta":
         $title = "Nuevo Código Contable";
        break;
    case "coddepre":
         $title = "Nuevo Código Depreciación";
        break;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Configuraciones</title>
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
            <li><a href="#"><i class="fa fa-dashboard"></i>Configuraciones</a></li>
            <li><a href="#">Ingresar Configuraci&oacute;n</a></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
           <!-- Default box -->
        <div class="box box-solid box-danger">
          <div class="box-header with-border">
            <h3 class="box-title"><?PHP echo $title; ?></h3>
          </div>
          <div class="box-body">              
              <form role="form" name="form_1" id="form_1" class="form-horizontal" method="post" action="../controlador/Config_controlador.php" <!-- form horizontal acts as a row -->  
                  <br><br>
                  <?php if(isset($_GET["tipo"]) && $_GET["tipo"] == "depto"){ ?>
                      <div class="form-group">
                        <div class="form-inline">
                          <label class="col-md-3 control-label" >Nombre:</label>
                            <div class="col-md-2">
                                <input id="nombre" name="nombre" class="form-control" type="text" value=""> 
                            </div> 
                          <label class="col-md-3 control-label" >C&oacute;digo:</label>
                            <div class="col-md-2">
                                <input id="codigo" name="codigo" class="form-control" type="text"  > 
                            </div>
                        </div> </div>
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 15%">
                            <button class="btn btn-primary mr5" name="agregardepartamento" id="saveForm1" type="submit" >Guardar</button>
                            <input class="btn btn-default" type="button" onclick=" location.href='../vista/Inicio.php'" target="frameprincipal" value="Cancelar"/> 
                     </div>
                  <?php } else if(isset($_GET["tipo"]) && $_GET["tipo"] == "descriptor"){?>
                      <div class="form-group">
                        <div class="form-inline">
                            <label class="col-md-3 control-label" >Descripci&oacute;n:</label>
                            <div class="col-md-2">
                                <input id="descripcion" name="descripcion" class="form-control" type="text" value=""> 
                            </div> 
                            <label class="col-md-3 control-label" >C&oacute;digo:</label>
                            <div class="col-md-2">
                                <input id="codigodes" name="codigodes" class="form-control" type="text"  > 
                            </div>
                        </div> </div>
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 15%">
                            <button class="btn btn-primary mr5" name="agregardescriptor" id="saveForm1" type="submit" >Guardar</button>
                            <input class="btn btn-default" type="button" onclick=" location.href='../vista/Inicio.php'" target="frameprincipal" value="Cancelar"/> 
                     </div>
                     <?php } else if(isset($_GET["tipo"]) && $_GET["tipo"] == "codconta"){?>
                      <div class="form-group">
                        <div class="form-inline">
                            <label class="col-md-3 control-label" >Nombre:</label>
                            <div class="col-md-2">
                                <input id="nombre" name="nombre" class="form-control" type="text" value=""> 
                            </div> 
                            <label class="col-md-3 control-label" >C&oacute;digo:</label>
                            <div class="col-md-2">
                                <input id="codconta" name="codconta" class="form-control" type="text"  > 
                            </div>
                        </div> </div>
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 15%">
                            <button class="btn btn-primary mr5" name="agregarcodconta" id="saveForm1" type="submit" >Guardar</button>
                            <input class="btn btn-default" type="button" onclick=" location.href='../vista/Inicio.php'" target="frameprincipal" value="Cancelar"/> 
                     </div>
                     <?php } else if(isset($_GET["tipo"]) && $_GET["tipo"] == "coddepre"){?>
                      <div class="form-group">
                        <div class="form-inline">
                            <label class="col-md-3 control-label" >Nombre:</label>
                            <div class="col-md-2">
                                <input id="nombre" name="nombre" class="form-control" type="text" value=""> 
                            </div> 
                            <label class="col-md-3 control-label" >C&oacute;digo:</label>
                            <div class="col-md-2">
                                <input id="coddepre" name="coddepre" class="form-control" type="text"  > 
                            </div>
                        </div> </div>
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 15%">
                            <button class="btn btn-primary mr5" name="agregarcoddepre" id="saveForm1" type="submit" >Guardar</button>
                            <input class="btn btn-default" type="button" onclick=" location.href='../vista/Inicio.php'" target="frameprincipal" value="Cancelar"/> 
                     </div>
                     <?php }     }   ?>
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
