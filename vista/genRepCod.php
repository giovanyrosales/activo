<?php
require_once '../modelo/Muebles_modelo.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Venta</title>
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
      list-style: none;
    }
    .input_container ul li {
      padding: 2px;
    }
    .input_container ul li:hover {
      background: #eaeaea;
      cursor: pointer;
    }
  </style>
 
</head>

<body class="layout-top-nav">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Reportes</a></li>
        <li><a href="#">Reporte de saldo de Cuentas</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-solid box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Datos del Reporte</h3>
        </div>
        <div class="box-body">
            <form role="form" name="form_1" id="form_1" class="form-horizontal" target="_blank" method="post" action="../reportes/porCodigos.php" <!-- form horizontal acts as a row -->
            <br><br>
            <div class="form-group">
              <div class="form-inline">
               <label class="col-md-2 control-label">Fecha 1:</label>
                <div class="col-md-2">
                  <input id="fechaini" name="fechaini" class="form-control" type="date" required>
                </div>
                <label class="col-md-2 control-label">Fecha 2:</label>
                <div class="col-md-2">
                  <input id="fechafin" name="fechafin" class="form-control" type="date" required>
                </div>
              </div>
            </div>

            <br>
            <div class="pull-right" style="margin-right: 15%">
              <button class="btn btn-primary mr5" name="genrepo" id="saveForm1" type="submit">Imprimir</button>
              <input class="btn btn-default" type="button" onclick=" location.href='../vista/inicio.php'" target="frameprincipal" value="Cancelar" />
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
</body>

</html>