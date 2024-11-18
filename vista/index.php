<?php
if (isset($_GET['error'])) {
	$msg = $_GET['error'];
} else if (session_start()) {
	if (isset($_SESSION['sesion4']['tipousuario'])) {
		switch ($_SESSION['sesion4']['tipousuario']) {
			case 1:
				header('Location: ../vista/indexAdmin.php');
				break;
		}
	}
}
require_once '../modelo/Usuarios_modelo.php';
$usuario = new Usuarios();
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Inventario y Activo Fijo | Log In</title>

		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/datepicker3.css" rel="stylesheet">
		<link href="../css/styles.css" rel="stylesheet">
		<link href="../images/archive.ico" rel="shortcut icon" type="image/x-icon" />
	</head>

	<body>

		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<center>
						<div style="background-color: #31b0d5; color: #ffffff; font-size: 1.5em; font-weight: bold; border: #269abc;" class="panel-heading">CONTROL DE INVENTARIO Y ACTIVO FIJO</div>
					</center>
					<div class="panel-body">
						<a href="#">
							<img src="../images/LOGO.png" alt="Logo Alcaldia Municipal de Metapan" width="160" class="center-block">
						</a>
						<br>
						<form name="form-login" id="loginform" method="post" action="../controlador/validateLogin.php">
							<?php
							if (isset($msg) and $msg == "1") {
								echo "<div class='alert alert-danger' >Clave incorrecta</div>";
							} else if (isset($msg) and $msg == "2") {
								echo "<div class='alert alert-danger' >Usuario no Registrado</div>";
							}
							?> <center>
								<fieldset>
									<div class="form-group">
										<input class="form-control" placeholder="Usuario" name="usuario" type="text" autofocus="" style="width: 70%;">
									</div>
									<div class="form-group">
										<input class="form-control" placeholder="Clave" name="clave" type="password" value="" style="width: 70%;">
									</div>
									<div class="checkbox">
										<label>
											<input name="recordar" type="checkbox" value="Recordarme">Recordarme
										</label>
									</div>
									<button type="submit" class="btn btn-twitter btn-block btn-flat" style="width: 50%">Iniciar</button>
								</fieldset>
							</center>
						</form>
					</div>
				</div>
			</div><!-- /.col-->

		</div><!-- /.row -->
		<!-- /.login-box -->
		<br>
		<center>
			<p style="color: whitesmoke">© 2024 Alcaldía Municipal de Santa Ana Norte. | Unidad de Tecnologías de Información</p>
		</center>
		<script src="../js/jquery-1.11.1.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/bootstrap-datepicker.js"></script>
		<script>
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
