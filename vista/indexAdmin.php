<?php //error_reporting (0);
?>
<?php
if (session_start()) {
    if ($_SESSION['sesion4']["tipousuario"] != "1") {
        echo "<header>";
        echo "<script language='javascript'>";
        echo "alert('No tienes los privilegios suficientes para cargar la pagina solicitada.')";
        echo "</script>";
        echo "</header>";
        echo "<body>";
        echo "<table ><tr><td>";
        // If not, show a link to your homepage instead
        echo "<a style='font-size: 2em' href=index.php>Volver</a>";
        echo "</td></tr><tr><td align=center style='padding-right: 100px;'>";
        echo "<label style='font-size: 1.2em'>No tiene los privilegios suficientes para cargar la pagina solicitada.</label></td></tr></table>";
        echo "</a>";
        echo "</body> ";
        exit();
    }
} else {
    echo "<header>";
    echo "<script language='javascript'>";
    echo "alert('No has iniciado sesion')";
    echo "</script>";
    echo "<script language='javascript'>window.location='index.php'</script>;";
    echo "</header>";
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Control de Inventario y Activo Fijo</title>

        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <!--<link href="../css/datepicker3.css" rel="stylesheet">-->
        <link href="../css/styles.css" rel="stylesheet">
        <link href="../images/archive.ico" rel="shortcut icon" type="image/x-icon" />
        <!--Icons-->
        <link href="../css/fontawesome 5.3.1/css/all.min.css" rel="stylesheet">
    </head>

    <body style="font-size: 15px;">

        <!-- Barra superior-->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span>Control de Inventario y Activo Fijo</span>&nbsp; Alcald&iacute;a Municipal de Santa Ana Norte</a>
                    <ul class="user-menu">
                        <li class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user-circle"> </span> <?php echo "   " . $_SESSION['sesion4']["nombre"] . " " . $_SESSION['sesion4']["apellido"] . " "; ?><span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="EditarUsuario.php" target="frameprincipal"><span class="fa fa-user-edit"></span> Editar Perfil</a></li>
                                <li><a href="../controlador/logout.php"><span class="fa fa-sign-out"></span> Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- /.container-fluid -->
        </nav>

        <!-- barra lateral izquierda-->
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <form role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Buscar">
                </div>
            </form>
            <ul class="nav menu">

                <li class="active"><a href="indexAdmin.php"><span class="fa fa-home"></span> Principal</a></li>
                <li class="parent ">
                    <a href="#">
                        <span data-toggle="collapse" href="#sub-item-1"><span class="fa fa-book"></span> Bienes</span>
                    </a>
                    <ul class="children collapse" id="sub-item-1">
                        <li><a class="" href="ListarBienes.php?tipo=1" target="frameprincipal">
                                <span class="fa fa-briefcase"></span> Bienes Muebles
                            </a></li>
                        <li><a class="" href="ListarBienes.php?tipo=2" target="frameprincipal">
                                <span class="fa fa-archive"></span> Inmuebles
                            </a></li>
                        <li><a class="" href="ListarBienes.php?tipo=3" target="frameprincipal">
                                <span class="fa fa-car"></span> Vehiculos y Maquinaria
                            </a></li>
                        <!--<li><a class="" href="ListarBienes.php?tipo=1" target="frameprincipal">
                                <span class="fa fa-building"></span> Edificaciones
                            </a></li>-->
                    </ul>
                </li>
                <li class="parent ">
                    <a href="#">
                        <span data-toggle="collapse" href="#sub-item-2"><span class="fa fa-calculator"></span> Calculos</span>
                    </a>
                    <ul class="children collapse" id="sub-item-2">
                        <li>
                            <a class="" href="Depreciacion.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-angle-double-down"></span> Depreciaci&oacute;n
                            </a>
                        </li>
                       <!-- <li><a class="" href="ListarEntregas.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-table"></span> Amortizaci&oacute;n
                            </a>
                        </li>
                        <li><a class="" href="ListarExistencias.php" target="frameprincipal">
                            <svg class="glyph stroked chevron-right"><span class="fa  fa-dollar-sign"></span> Valor Residual
                                </a>
                        </li>-->
                    </ul>
                </li>
                <li class="parent ">
                    <a href="#">
                        <span data-toggle="collapse" href="#sub-item-3"><span class="fa fa-print"></span> Reportes</span>
                    </a>
                    <ul class="children collapse" id="sub-item-3">
                        <li><a class="" href="GenReporte.php?filter=1" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte  por departamento
                            </a>
                        </li>
                        <li><a class="" href="GenReporte.php?filter=2" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte de Inv.
                            </a>
                        </li>
                        <li><a class="" href="GenReporte.php?filter=3" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte de Comodato
                            </a>
                        </li>
                        <li><a class="" href="GenReporte.php?filter=4" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte de Descargos
                            </a>
                        </li>
                        <li><a class="" href="GenReporte.php?filter=5" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte de Ventas
                            </a>
                        </li>
                        <li><a class="" href="GenReporte.php?filter=6" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte de Donaciones
                            </a>
                        </li>
                        <li><a class="" href="GenReporte.php?filter=7" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte de Reevaluos
                            </a>
                        </li>
                        <li><a class="" href="GenReporte.php?filter=8" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte por descriptor
                            </a>
                        </li>
                        <li><a class="" href="genRepCod.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte de C&oacute;digos
                            </a>
                        </li>
                        <li><a class="" href="GenReporte.php?filter=9" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-file-alt"></span> Reporte de Rep. Vital
                            </a>
                        </li>
                    </ul>
                </li>
                <!--<li class="parent ">
                    <a href="#">
                        <span data-toggle="collapse" href="#sub-item-4"><span class="fa fa-users"></span> Usuarios</span>
                    </a>
                    <ul class="children collapse" id="sub-item-4">
                        <li><a class="" href="IngresarUsuario.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-user-alt"></span> Nuevo Usuario
                            </a></li>
                        <li><a class="" href="ListarUsuarios.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-list-alt"></span> Listar Usuarios
                            </a></li>
                    </ul>
                </li>-->
                <li class="parent ">
                    <a href="#">
                        <span data-toggle="collapse" href="#sub-item-5"><span class="fa fa-cogs"></span> Configuraci&oacute;n</span>
                    </a>
                    <ul class="children collapse" id="sub-item-5">
                        <li><a class="" href="ListarDepto.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-list-alt"></span> Departamentos
                            </a></li>
                        <li><a class="" href="ListarDescriptor.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-list-alt"></span> Descriptor
                            </a></li>
                        <li><a class="" href="ListarCodigoContable.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-list-alt"></span> C&oacute;digo Contable
                            </a></li>
                        <li><a class="" href="ListarCodigoDepre.php" target="frameprincipal">
                                <svg class="glyph stroked chevron-right"><span class="fa fa-list-alt"></span> C&oacute;digo Depreciaci&oacute;n
                            </a></li>
                    </ul>
                </li>
            </ul>

            <div class="attribution"><img src="../images/LOGO.png" width="25%"><b><br />ALCALD&Iacute;A MUNICIPAL<br />DE SANTA ANA NORTE</b></div>
        </div>
        <!--contenido principal-->
        <!--/.sidebar-->
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <iframe style="width: 100%; resize: initial; overflow: hidden; min-height:100vh" frameborder="0" scrolling="no" id="frameprincipal" src="inicio.php" name="frameprincipal">
            </iframe>
        </div>
        <!--/.main-->

        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap-datepicker.js"></script>

        <script>
            $('#calendar').datepicker({});

            !function ($) {
                $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                    $(this).find('em:first').toggleClass("glyphicon-minus");
                });
                $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            }(window.jQuery);

            $(window).on('resize', function () {
                if ($(window).width() > 768)
                    $('#sidebar-collapse').collapse('show')
            })
            $(window).on('resize', function () {
                if ($(window).width() <= 767)
                    $('#sidebar-collapse').collapse('hide')
            })
            //Para ocultar el collapse de los menus y hacerlo tipo acordeon!!!! Funciona!
            $('[data-toggle="collapse"]').click(function () {
                $('.collapse.in').collapse('hide')
            });
        </script>
    </body>

</html>