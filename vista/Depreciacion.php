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
</head>
  <body class="layout-top-nav">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Activo Fijo e Inventario</a></li>
            <li><a href="#">Formulario de Depreciaci&oacute;n</a></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
           <!-- Default box -->
        <div class="box box-solid box-danger">
          <div class="box-header with-border">
              <h3 class="box-title">Depreciaci&oacute;n Anual</h3>
          </div>
          <div class="box-body">              
                  <div class="form-group">
                      <label class="col-md-2 control-label" style="margin-top: 8px;">Seleccione una opci&oacute;n:</label>
                             <div class="col-md-3">
                                <select class="form-control" >
                                <option value="" selected="selected">Seleccione una opcion..</option>
                                <option value="form_1">Anual general</option>
                                <option value="form_2">Anual por bien</option>
                                </select>
                             </div>
                      </div>
              <br>
              <form role="form" name="form_1" id="form_1" style="display:none" target=_blank class="form-horizontal" method="post" action="imprimirDepreGeneral.php" <!-- form horizontal acts as a row -->  
                  <br><br>
                      <div class="form-group">
                          <label class="col-md-3 control-label" >Año:</label>
                             <div class="col-md-2">
                                 <input id="anio" name="anio" class="form-control" type="text" value=""> 
                             </div>
                      </div>                    
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 30%">
                            <button class="btn btn-primary mr5" name="imprimir" id="saveForm1" type="submit" >Generar</button>
                            <input class="btn btn-default" type="button" onclick=" location.href='../vista/Depreciacion.php'" target="frameprincipal" value="Cancelar"/> 
                     </div>
                </form>
              <form role="form" name="form_2" id="form_2" style="display:none" target="_blank" class="form-horizontal" method="post" action="imprimirDepre.php" <!-- form horizontal acts as a row -->  
                  <br><br>
                      <div class="form-group">
                          <label class="col-md-3 control-label" >C&oacute;digo del bien:</label>
                             <div class="col-md-7">
                                 <input id="bien" name="bien" class="form-control" type="text" value=""> 
                             </div>
                      </div>                    
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 15%">
                            <button class="btn btn-primary mr5" name="imprimir" id="saveForm2" type="submit" >Generar</button>
                            <input class="btn btn-default" type="button" onclick=" location.href='../vista/Depreciacion.php'" target="frameprincipal" value="Cancelar"/> 
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
            <script>
                   $("select").on("change", function() {    
                    $("#" + $(this).val()).show().siblings().hide();
                });
            </script>
</body>

</html>
