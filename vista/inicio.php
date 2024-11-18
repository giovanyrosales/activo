<?php ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inventario y Activo Fijo</title>

	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/fontawesome 5.3.1/css/all.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	<style>
		.alert {
			margin-right: 15px;
			margin-left: 15px;
		}
	</style>
</head>

<body>

	<div col-lg-10 col-lg-offset-2 col-sm-9 col-sm-offset-3 class="main">
		<div class="row">
			<?php
			if (isset($_GET["des"]) and $_GET["des"] == "1") {
				echo '<div class="alert alert-success">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Correcto! </strong>Descargo Registrado.
              </div>';
			} else   if (isset($_GET["add"]) and $_GET["add"] == "1") {
				echo '<div class="alert alert-success">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Correcto! </strong>Traslado Registrado.
              </div>';
			}else   if (isset($_GET["add"]) and $_GET["add"] == "2") {
                                echo '<div class="alert alert-warning">
              <span class="close" data-dismiss="alert">&times;</span>
              <strong>Error! </strong>Error en Traslado.
              </div>';
                        }

			?>
		</div>
		<!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 style="font-size: 1.8em;" class="page-header">Nuevo registro</h1>
			</div>
		</div>
		<!--/.row-->
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<a style="color: #666666;" href="IngresarBien.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-plus"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">NUEVO BIEN</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/.row-->
		<div class="row">
			<div class="col-lg-8">
				<h1 style="font-size: 1.8em;" class="page-header">Bienes Muebles / Vehiculos y Maquinaria</h1>
			</div>
		</div>
		<!--/.row-->
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<a style="color: #666666;" href="Traslados.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-retweet"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">TRASLADO</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<a style="color: #666666;" href="Descargos.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-thumbs-down"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">DESCARGOS</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<a style="color: #FFFFFF;" href="ListarVentas.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-tag"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">VENTA</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
                                                    <a style="color: #FFFFFF;" href="Sustitucion.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-life-ring"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">REPOSICI&Oacute;N VITAL</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/.row-->
		<div class="row">
			<div class="col-lg-8">
				<h1 style="font-size: 1.8em;" class="page-header">Bienes Inmuebles</h1>
			</div>
		</div>
		<!--/.row-->
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<a style="color: #666666;" href="ListarDonacion.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-gift"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">DONACIONES</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<a style="color: #666666;" href="ListarComodato.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-handshake"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">COMODATOS</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<a style="color: #666666;" href="ListarVentasME.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-tag"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">VENTA VEHICULOS Y MAQUINARIA</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<a style="color: #666666;" href="IngresarReevaluo.php" target="frameprincipal"><span style="font-size: 3.5em;" class="fa fa-money-bill"></span></a>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="text-info">REEVALUO</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/.row-->
		<!--                    <div class="row">
                    <div class=" col-md-4" style="float: right; margin-top: 3.2%;">
                            <div class="panel panel-red">
                                    <div class="panel-heading dark-overlay"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg>Calendario</div>
                                    <div class="panel-body">
                                            <div id="calendar"></div>
                                    </div>
                            </div>
                    </div>
                    </div>-->
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
