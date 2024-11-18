<?php
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';
require_once '../modelo/Config_modelo.php';
$config = new Config();
$departamentos = $config->getAllDepto();
$descriptores = $config->getAllDescriptor();
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
    <script>
        function mostrarOcultar(select) {
            var valor = select;

            if (valor == "4") {
                document.getElementById('muebles').style.display = 'none';
                document.getElementById('mayores').required = false;
                document.getElementById('menores').required = false;
                document.getElementById('todos').required = false;


                document.getElementById('bien').style.display = 'block';
                document.getElementById('formInv').setAttribute("action", "../reportes/bien.php");


            } else if (valor == "1") {
                document.getElementById('bien').style.display = 'none';
                document.getElementById('muebles').style.display = 'block';
                document.getElementById('mayores').required = true;
                document.getElementById('menores').required = true;
                document.getElementById('todos').required = true;
                document.getElementById('formInv').setAttribute("action", "../reportes/Inventario.php");

            } else {
                document.getElementById('bien').style.display = 'none';
                document.getElementById('formInv').setAttribute("action", "../reportes/Inventario.php");
                document.getElementById('muebles').style.display = 'none';
                document.getElementById('mayores').required = false;
                document.getElementById('menores').required = false;
                document.getElementById('todos').required = false;



            }
        }

        function ocultar() {
            document.getElementById('bien').style.display = 'none';
            document.getElementById('muebles').style.display = 'none';
            document.getElementById('mayores').required = false;
            document.getElementById('menores').required = false;
            document.getElementById('todos').required = false;
        }
    </script>
</head>

<body class="layout-top-nav" onload="ocultar();">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a><i class="fa fa-dashboard"></i> Activo Fijo e Inventario</a></li>
                <li><a>Reportes</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Generar Reportes</h3>
                </div>
                <div class="box-body">
                    <form role="form" name="form_1" id="formDep" class="form-horizontal" method="post" action="../reportes/Departamento.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Departamento:</label>
                            <div class="col-md-4">
                                <select id="departamento" name="departamento" required="true" class="form-control" onchange="mostrarOcultar(this.value)">
                                    <option selected disabled value="">Seleccione una Opcion...</option>
                                    <?php
                                    foreach ($departamentos as $valores) {
                                        echo '<option value="' . $valores['iddepartamento'] . '">' . $valores['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="pull-right" style="margin-right: 25%">
                            <button class="btn btn-primary mr5" name="agregarcomodato" id="saveForm1" type="submit">Imprimir</button>
                        </div>

                    </form>
                    <form role="form" name="form_2" id="formInv" class="form-horizontal" method="post" action="../reportes/Inventario.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Filtro Bienes:</label>
                            <div class="col-md-4">
                                <select id="tipoBien" name="tipoBien" required="true" class="form-control" onchange="mostrarOcultar(this.value)">
                                    <option selected disabled value="">Seleccione una Opcion...</option>
                                    <option value="1">Muebles</option>
                                    <option value="2">Inmuebles</option>
                                    <option value="3">Vehiculos y Maq.</option>
                                    <option value="4">Por Bien</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group" id="bien">
                            <label class="col-md-3 control-label" id="codigolabel">C&oacute;digo de Bien:</label>
                            <div class="col-md-3">
                                <input id="codigo" name="codigo" class="form-control" type="text" value="">
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipoBienReporte" id="exampleRadios1" value="1">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Bienes Muebles
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipoBienReporte" id="exampleRadios2" value="2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Bienes Inmuebles
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipoBienReporte" id="exampleRadios3" value="3">
                                    <label class="form-check-label" for="exampleRadios3">
                                        Maquinaria y equipo
                                    </label>
                                </div>
                            </div>



                        </div>

                        <div class="form-group" id="muebles">
                            <label class="col-md-3 control-label" id="codigolabel">Filtros:</label>

                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mueblesfiltro" id="mayores" value="1">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Mayores a 900
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mueblesfiltro" id="menores" value="2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Menores a 900
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mueblesfiltro" id="todos" value="3">
                                    <label class="form-check-label" for="exampleRadios3">
                                        Ver todos
                                    </label>
                                </div>
                            </div>



                        </div>

                        <br>
                        <div class="pull-right" style="margin-right: 25%">
                            <button class="btn btn-primary mr5" name="ReporteInventario" id="saveForm1" type="submit">Imprimir Reporte Inventario</button>
                        </div>
                    </form>
                    <form role="form" name="form_3" id="formComodatos" class="form-horizontal" method="post" action="../reportes/Comodatos.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <div class="form-inline">
                                <label class="col-md-3 control-label">Fecha inicial</label>
                                <div class="col-md-2">
                                    <input id="fechainicial" name="fechainicial" class="form-control" type="date" required>
                                </div>
                                <label class="col-md-3 control-label">Fecha final</label>
                                <div class="col-md-2">
                                    <input id="fechafinal" name="fechafinal" class="form-control" type="date" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Filtro Bienes:</label>
                            <div class="col-md-4">
                                <select id="tipoBien" name="tipoBien" required class="form-control">
                                    <option selected disabled value="">Seleccione una Opcion...</option>
                                    <option value="1">Muebles</option>
                                    <option value="2">Inmuebles</option>
                                    <option value="3">Vehiculos y Maq.</option>
                                </select>
                            </div>
                        </div>

                        <div class="pull-right" style="margin-right: 25%">
                            <button class="btn btn-primary mr5" name="reporteComodatos" id="saveFormComodatos" type="submit">Imprimir Reportes Comodatos</button>
                        </div>
                    </form>
                    <form role="form" name="form_4" id="formDescargos" class="form-horizontal" method="post" action="../reportes/Descargos.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <div class="form-inline">
                                <label class="col-md-3 control-label">Fecha inicial</label>
                                <div class="col-md-2">
                                    <input id="fechainicial" name="fechainicial" class="form-control" type="date" required>
                                </div>
                                <label class="col-md-3 control-label">Fecha final</label>
                                <div class="col-md-2">
                                    <input id="fechafinal" name="fechafinal" class="form-control" type="date" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Filtro Bienes:</label>
                            <div class="col-md-4">
                                <select id="tipoBien" name="tipoBien" required class="form-control">
                                    <option selected disabled value="">Seleccione una Opcion...</option>
                                    <option value="1">Muebles</option>
                                    <option value="2">Inmuebles</option>
                                    <option value="3">Vehiculos y Maq.</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="pull-right" style="margin-right: 25%">
                            <button class="btn btn-primary mr5" name="reporteDescargos" id="saveFormDescargos" type="submit">Imprimir Reporte Descargos</button>
                        </div>
                    </form>
                    <form role="form" name="form_5" id="formVentas" class="form-horizontal" method="post" action="../reportes/Ventas.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <div class="form-inline">
                                <label class="col-md-3 control-label">Fecha inicial</label>
                                <div class="col-md-2">
                                    <input id="fechainicial" name="fechainicial" class="form-control" type="date" required>
                                </div>
                                <label class="col-md-3 control-label">Fecha final</label>
                                <div class="col-md-2">
                                    <input id="fechafinal" name="fechafinal" class="form-control" type="date" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Filtro Bienes:</label>
                            <div class="col-md-4">
                                <select id="tipoBien" name="tipoBien" required="true" class="form-control">
                                    <option selected disabled value="">Seleccione una Opcion...</option>
                                    <option value="1">Muebles</option>
                                    <option value="2">Inmuebles</option>
                                    <option value="3">Vehiculos y Maq.</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="pull-right" style="margin-right: 25%">
                            <button class="btn btn-primary mr5" name="reporteVentas" id="saveFormVentas" type="submit">Imprimir Reporte Ventas</button>
                        </div>
                    </form>
                    <form role="form" name="form_6" id="formDonaciones" class="form-horizontal" method="post" action="../reportes/Donaciones.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <div class="form-inline">
                                <label class="col-md-3 control-label">Fecha inicial</label>
                                <div class="col-md-2">
                                    <input id="fechainicial" name="fechainicial" class="form-control" type="date" required>
                                </div>
                                <label class="col-md-3 control-label">Fecha final</label>
                                <div class="col-md-2">
                                    <input id="fechafinal" name="fechafinal" class="form-control" type="date" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Filtro Bienes:</label>
                            <div class="col-md-4">
                                <select id="tipoBien" name="tipoBien" required="true" class="form-control">
                                    <option selected disabled value="">Seleccione una Opcion...</option>
                                    <option value="1">Muebles</option>
                                    <option value="2">Inmuebles</option>
                                    <option value="3">Vehiculos y Maq.</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="pull-right" style="margin-right: 25%">
                            <button class="btn btn-primary mr5" name="reporteDonaciones" id="saveFormDonaciones" type="submit">Imprimir Reporte Donaciones</button>
                        </div>
                    </form>
                    <form role="form" name="form_7" id="formReevaluos" class="form-horizontal" method="post" action="../reportes/reevaluos.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <div class="form-inline">
                                <label class="col-md-3 control-label">Fecha inicial</label>
                                <div class="col-md-2">
                                    <input id="fechainicial" name="fechainicial" class="form-control" type="date" required>
                                </div>
                                <label class="col-md-3 control-label">Fecha final</label>
                                <div class="col-md-2">
                                    <input id="fechafinal" name="fechafinal" class="form-control" type="date" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Filtro Bienes:</label>
                            <div class="col-md-4">
                                <select id="tipoBien" name="tipoBien" required="true" class="form-control">
                                    <option selected disabled value="">Seleccione una Opcion...</option>
                                    <option value="1">Muebles</option>
                                    <option value="2">Inmuebles</option>
                                    <option value="3">Vehiculos y Maq.</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="pull-right" style="margin-right: 25%">
                            <button class="btn btn-primary mr5" name="reporteReevaluos" id="saveFormReevaluos" type="submit">Imprimir Reporte Reevaluos</button>
                        </div>
                    </form>
                    <form role="form" name="form_8" id="formDescr" class="form-horizontal" method="post" action="../reportes/Descriptor.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Descriptor:</label>
                            <div class="col-md-4">
                                <select id="departamento" name="descriptor" required="true" class="form-control" onchange="mostrarOcultar(this.value)">
                                    <option selected disabled value="">Seleccione una Opcion...</option>
                                    <?php
                                    foreach ($descriptores as $valores) {
                                        echo '<option value="' . $valores['iddescriptor'] . '">' . $valores['descripcion'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="pull-right" style="margin-right: 25%">
                            <button class="btn btn-primary mr5" name="generaraDescriptor" id="saveForm1" type="submit">Imprimir</button>
                        </div>

                    </form>
                    <form role="form" name="form_9" id="formRepVit" class="form-horizontal" method="post" action="../reportes/Sustituciones.php" target="_blank">
                        <!-- form horizontal acts as a row -->
                        <br><br>
                        <div class="form-group">
                            <div class="form-inline">
                                <label class="col-md-3 control-label">Fecha inicial</label>
                                <div class="col-md-2">
                                    <input id="fechainicial" name="fechainicial" class="form-control" type="date" required>
                                </div>
                                <label class="col-md-3 control-label">Fecha final</label>
                                <div class="col-md-2">
                                    <input id="fechafinal" name="fechafinal" class="form-control" type="date" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="pull-right" style="margin-right: 18%">
                            <button class="btn btn-primary mr5" name="reporteSustituciones" id="saveFormRepVit" type="submit">Imprimir Reporte Reposiciones</button>
                        </div>
                    </form>

                </div>

                <?php
                if (isset($_GET["filter"])) {
                    switch ($_GET["filter"]) {
                        case "1":
                            echo "<style>
               #formDep{

                 display:block;
               }
               #formInv{
                 
                display:none;
              }
              #formComodatos{
                 
                display:none;
              }
               #formDescargos{
                 
                display:none;
              }
              #formVentas{
                 
                display:none;
              }
               #formDonaciones{
                 
                display:none;
              }
              #formReevaluos{
                 
                display:none;
              }
              #formDescr{
                 
                display:none;
              }
             #formRepVit{
                 
                display:none;
              }
              </style>";
                            break;
                        case "2":
                            echo "<style>
              #formDep{
  
                display:none;
              }
              #formInv{
                
               display:block;
             }
             #formComodatos{
                 
                display:none;
              }
               #formDescargos{
                 
                display:none;
              }
              #formVentas{
                 
                display:none;
              }
               #formDonaciones{
                 
                display:none;
              }
              #formReevaluos{
                 
                display:none;
              }
              #formDescr{
                 
                display:none;
              }
              #formRepVit{
                 
                display:none;
              }
             </style>";

                            break;
                        case "3":
                            echo "<style>
              #formDep{
  
                display:none;
              }
              #formInv{
                
               display:none;
             }
            #formComodatos{
                 
                display:block;
              }
               #formDescargos{
                 
                display:none;
              }
              #formVentas{
                 
                display:none;
              }
               #formDonaciones{
                 
                display:none;
              }
              #formReevaluos{
                 
                display:none;
              }
              #formDescr{
                 
                display:none;
              }
              #formRepVit{
                 
                display:none;
              }
             </style>";

                            break;
                        case "4":
                            echo "<style>
              #formDep{
  
                display:none;
              }
              #formInv{
                
               display:none;
             }
            #formComodatos{
                 
                display:none;
              }
               #formDescargos{
                 
                display:block;
              }
              #formVentas{
                 
                display:none;
              }
               #formDonaciones{
                 
                display:none;
              }
              #formReevaluos{
                 
                display:none;
              }
              #formDescr{
                 
                display:none;
              }
              #formRepVit{
                 
                display:none;
              }
             </style>";

                            break;
                        case "5":
                            echo "<style>
              #formDep{
  
                display:none;
              }
              #formInv{
                
               display:none;
             }
            #formComodatos{
                 
                display:none;
              }
               #formDescargos{
                 
                display:none;
              }
              #formVentas{
                 
                display:block;
              }
               #formDonaciones{
                 
                display:none;
              }
              #formReevaluos{
                 
                display:none;
              }
              #formDescr{
                 
                display:none;
              }
              #formRepVit{
                 
                display:none;
              }
             </style>";

                            break;
                        case "6":
                            echo "<style>
              #formDep{
  
                display:none;
              }
              #formInv{
                
               display:none;
             }
            #formComodatos{
                 
                display:none;
              }
               #formDescargos{
                 
                display:none;
              }
              #formVentas{
                 
                display:none;
              }
               #formDonaciones{
                 
                display:block;
              }
              #formReevaluos{
                 
                display:none;
              }
              #formDescr{
                 
                display:none;
              }
              #formRepVit{
                 
                display:none;
              }
             </style>";

                            break;
                        case "7":
                            echo "<style>
              #formDep{
  
                display:none;
              }
              #formInv{
                
               display:none;
             }
            #formComodatos{
                 
                display:none;
              }
               #formDescargos{
                 
                display:none;
              }
              #formVentas{
                 
                display:none;
              }
               #formDonaciones{
                 
                display:none;
              }
              #formReevaluos{
                 
                display:block;
              }
              #formDescr{
                 
                display:none;
              }
              #formRepVit{
                 
                display:none;
              }
             </style>";

                            break;
                            case "8":
                            echo "<style>
              #formDep{
  
                display:none;
              }
              #formInv{
                
               display:none;
             }
            #formComodatos{
                 
                display:none;
              }
               #formDescargos{
                 
                display:none;
              }
              #formVentas{
                 
                display:none;
              }
               #formDonaciones{
                 
                display:none;
              }
              #formReevaluos{
                 
                display:none;
              }
              #formDescr{
                 
                display:block;
              }
              #formRepVit{
                 
                display:none;
              }
             </style>";

                          break;
                            case "9":
                            echo "<style>
              #formDep{
  
                display:none;
              }
              #formInv{
                
               display:none;
             }
            #formComodatos{
                 
                display:none;
              }
               #formDescargos{
                 
                display:none;
              }
              #formVentas{
                 
                display:none;
              }
               #formDonaciones{
                 
                display:none;
              }
              #formReevaluos{
                 
                display:none;
              }
              #formDescr{
                 
                display:none;
              }
              #formRepVit{
                 
                display:block;
              }
             </style>";

                            break;
                    }
                }
                ?>
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
            if ($(window).width() > 768)
                $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function() {
            if ($(window).width() <= 767)
                $('#sidebar-collapse').collapse('hide')
        })
    </script>

</body>

</html>