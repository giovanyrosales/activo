<?php //error_reporting (0);?>
<?php
if (session_start()) {
    require_once '../modelo/Usuarios_modelo.php'; 
    $idusuario = $_SESSION['sesion4']["idusuario"];
    $user = new Usuarios();
    $datos = $user->getDatosUsuarioID($idusuario);
  
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
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Activo Fijo e Inventario Municipal</title>

<link href="../css/bootstrap.min.css" rel="stylesheet">
<!--<link href="../css/datepicker3.css" rel="stylesheet">-->
<link href="../css/styles.css" rel="stylesheet">

<!--Icons-->
<script src="../js/lumino.glyphs.js"></script>
 <script language="javascript">
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode !== 46 && charCode !== 45 && charCode > 31
    && (charCode < 48 || charCode > 57))
     return false;

  return true;
}
</script> 
<script language="javascript"> 
function comprobarClave(){ 
   clave1 = document.form1.clave.value;
   	clave2 = document.form1.repass.value;

        if (clave1.length < 6 ){
                alert("Error: la clave debe contener por lo menos 6 caracteres!");
        document.form1.clave.focus();    
        return false;
        }
        re = /[0-9]/;
      if(!re.test(clave1)) {
        alert("Error: la clave debe contener por lo menos un numero (0-9)!");
        document.form1.clave.focus();
        return false;
        
        }
        if (clave1 !== clave2) {
        alert(':( Las claves no coinciden por favor vuelva a ingresarlos')
      	return false;
    }
    else {
        
        return true;
    }

} 
</script> 
<style>
 /* width */
::-webkit-scrollbar {
    width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555; 
}
</style>
  </head>
  <body class="layout-top-nav">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Usuario</a></li>
          <li><a href="#">Editar Información</a></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
            <?php 
        if (isset($_GET["usact"]) AND $_GET["usact"] == "1") {
            echo '<div class="alert alert-success">
                  <span class="close" data-dismiss="alert">&times;</span>
                  <strong>Actualizados!</strong> Se actualizaron datos de cuenta.
                  </div>';
        } else if (isset($_GET["usact"]) AND $_GET["usact"] == "2") {
                 echo '<div class="alert alert-warning">
                  <span class="close" data-dismiss="alert">&times;</span>
                  <strong>Error!</strong> Hubo un problema al actualizar los datos de su Cuenta.
                  </div>';
        } 
        else if (isset($_GET["usact"]) AND $_GET["usact"] == "3") {
                echo '<div class="alert alert-warning">
                          <span class="close" data-dismiss="alert">&times;</span>
                          <strong>Error!</strong> El archivo de respaldo excede los 300Kb.
                          </div>';
        } 
        else if (isset($_GET["usact"]) AND $_GET["usact"] == "4") {
                echo '<div class="alert alert-warning">
                          <span class="close" data-dismiss="alert">&times;</span>
                          <strong>Error!</strong> Tu archivo tiene que ser en formato JPG. Otros formatos no son permitidos..
                          </div>';
        } 
       ?>
        <!-- Default box -->
        <div class="box box-solid box-danger">
            <div class="box-header with-border">
                    <h3 class="box-title">Editar Información</h3>
                </div>
          <div class="box-body">
            <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="post" action="../controlador/Usuarios_controlador.php" onsubmit="return comprobarClave();"> <!-- form horizontal acts as a row -->  
                      <div class="form-group">
                          <label class="col-md-2 control-label" style="margin-top: 10px">Nombre:</label>
                             <div class="col-md-5">
                                  <input id="nombre" name="nombre" class="form-control" type="text" value="<?php echo $datos["nombre"]; ?>" onkeypress="" onpaste="return false"> 
                             </div>
                      </div> 
                      <div class="form-group">
                            <label class="col-md-2 control-label" style="margin-top: 10px">Apellido:</label>
                            <div class="col-md-5">
                                 <input id="apellidos" name="apellido" class="form-control" type="text" value="<?php echo $datos["apellido"]; ?>" onkeypress="" onpaste="return false"> 
                            </div>
                      </div> 
                      <div class="form-group">
                            <label class="col-md-2 control-label" style="margin-top: 10px">Usuario:</label>
                            <div class="col-md-4">
                                 <input id="usuario" name="usuario" class="form-control" type="text" value="<?php echo $datos["usuario"]; ?>"> 
                            </div>
                      </div> 
                      <div class="form-group">
                           <label class="col-md-2 control-label" >Seleccione solo si desea Actualizar su clave:</label>
                    <div class="col-md-9">
                        <input style="margin-top: 10px;" type="checkbox" id="actpass" value="1" name="actpass">
                    </div>
                  </div>
                <div class="form-group">
                      <div class="form-inline">
                              <label class="col-md-2 control-label" >Clave:</label>
                              <div class="col-md-2">
                                  <input id="pass" name="clave" class="form-control" type="password" value="<?php echo $datos["clave"]; ?>" disabled> 
                              </div>
                              <label class="col-md-2 control-label">Repetir clave:</label>
                            <div class="col-md-2">
                         <input id="repass" name="repass" class="form-control" type="password" value="<?php echo $datos["clave"]; ?>" disabled> 
                           </div></div>
                </div>
                  <div class="form-group">
                              <label class="col-md-2 control-label"style="margin-top: 10px"  >Celular:</label>
                              <div class="col-md-4">
                                  <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
                                  <input id="telefono" name="tel" class="form-control" type="tel" maxlength="8" value="<?php echo $datos["tel"]; ?>" onkeypress="return isNumberKey(event);" onpaste="return false"> 
                              </div>
                  </div>
                  <div class="form-group">           
                    <br>

                        <div class="pull-right" style="margin-right: 35%;">
                          <button class="btn btn-primary mr5" name="actualizar" id="saveForm" type="submit">Actualizar</button>
                          <input class="btn btn-default" type="button" onclick=" location.href='../vista/inicio.php'" target="frameprincipal" value="Cancelar"/> 
                        </div>
                    </div>
             </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
      </section>
      <!-- /.content -->
    </div>
<script src="../js/jquery-1.11.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/bootstrap-datepicker.js"></script>
 <script>
document.getElementById('actpass').onchange = function() {
    document.getElementById('pass').disabled = !this.checked;
    document.getElementById('pass').value = '';
    document.getElementById('repass').disabled = !this.checked;
    document.getElementById('repass').value = '';
};
</script>
  </body>
</html>