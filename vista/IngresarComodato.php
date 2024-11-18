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
<style>
    .input_container {
	height: 36px;
	float: left;
        width: 100%;
}
.input_container ul {
	width: 96%;
	position: absolute;
	z-index: 9;
	background: white; 
        -webkit-padding-start: 10px;
         list-style:none;
}
.input_container ul li {
	padding: 2px;
}
.input_container ul li:hover {
	background: #eaeaea;
        cursor: pointer;
        
}
</style>
<script>
// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#descripcion').val();
        var ajax_data = {
         
          "keyword"   : keyword
        };
	if (keyword.length > min_length) {
		$.ajax({
			url: '../modelo/ListarM_modelo.php?comodato=1',
			type: 'POST',
			data: ajax_data,
			success:function(data){
				$('#lista').show();
				$('#lista').html(data);
			}
		});
	} else {
		$('#lista').hide();
	}
}
 
function hideUl() {
	$('#lista').hide();
}
// esta funcion se ejecuta cuando seleccionamos un item
function set_item(id,item) {
	// change input value
	$('#descripcion').val(item);
        $('#bien').val(id);
	// hide proposition list
	$('#lista').hide();
}
</script>
</head>
  <body class="layout-top-nav">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Activo Fijo e Inventario</a></li>
          <li><a href="#">Comodatos</a></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
           <!-- Default box -->
        <div class="box box-solid box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Registro de Comodato</h3>
          </div>
          <div class="box-body">              
              <form role="form" name="form_1" id="form_1" class="form-horizontal" enctype="multipart/form-data"  method="post" action="../controlador/Bien_controlador.php" <!-- form horizontal acts as a row -->  
                  <br><br>
                      <div class="form-group">
                          <label class="col-md-3 control-label" >Instituci&oacute;n / Entidad:</label>
                             <div class="col-md-7">
                                 <input id="institucion" name="institucion" class="form-control" type="text" value=""> 
                             </div>
                      </div>
                       <div class="form-group">
                          <label class="col-md-3 control-label" >Nombre y/o Descripci&oacute;n del Bien:</label>
                             <div class="col-md-7">
                                 <div class="input_container">
                                 <input type="text" class="form-control" autocomplete="off" id="descripcion" onkeyup=" autocomplet();" onkeydown="hideUl();" name="descripcion" required>
                                 <ul id="lista" ></ul>
                                    <input id="bien" name="bien" class="form-control" type="hidden" value=""> 
                                 </div>
                             </div>
                        </div>
                  <div class="form-group">
                        <div class="form-inline">
                          <label class="col-md-3 control-label" id="" >Fecha:</label>
                            <div class="col-md-2">
                                <input id="fecha" name="fecha" class="form-control" type="date" value=""> 
                            </div> 
                          <label class="col-md-2 control-label" id="" >Documentaci&oacute;n:</label>
                            <div class="col-md-2">
                                <input id="documento" name="documento" class="form-control" type="file"  > 
                            </div>
                        </div> </div>
                  <div class="form-group">
                          <label class="col-md-3 control-label" >Observaciones:</label>
                             <div class="col-md-7">
                                 <input id="observaciones" name="observaciones" class="form-control" type="text" value=""> 
                             </div>
                      </div>
                     <br>                                                                                
                     <div class="pull-right" style="margin-right: 15%">
                            <button class="btn btn-primary mr5" name="agregarcomodato" id="saveForm1" type="submit" >Guardar</button>
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
