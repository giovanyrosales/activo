<?php
require_once '../modelo/Config_modelo.php';

$config = new Config();
$datos = $config->getAllCodDepre();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>C&oacute;digo Depreciaci&oacute;n</title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!--<link href="../css/datepicker3.css" rel="stylesheet">-->
<link href="../css/styles.css" rel="stylesheet">
<link rel="stylesheet" href="../js/datatables/dataTables.bootstrap.css">
<!--Icons-->
<!--<script src="../js/lumino.glyphs.js"></script>-->
<script src="../js/jQuery-2.2.0.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/datatables/jquery.dataTables.min.js"></script>
<script src="../js/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
  function edt_id(id)
  {
  $('#editSi').click(function(event) {
  window.location.href='EditarBien.php?idcoddepre='+id;
  });
  }
  function delete_id(id)
  {
  $('#elimSi').click(function(event) {
  window.location.href='../controlador/Config_controlador.php?delcoddepre='+id;
  });
  }
   jQuery(document).ready(function($) {
    $('table').on('click', '#eliminar', function(event) {
      event.preventDefault();
      /* Act on the event */      
      var e = $(this);
      $('#modalEliminar .modal-title').text(e.data('titulo'));
      $('#modalEliminar #cuerpo').text(e.data('detalle'));

   $('body', window.parent.document).animate({
            scrollTop: 0
        }, 800);
    });
    
  });
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
  <body class="layout-top-nav" >
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>C&oacute;digo Depreciaci&oacute;n</a></li>
          <li><a href="#"><?php ?></a></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
            <!-- Default box -->
        <div class="box box-solid box-danger">
          <div class="box-header with-border">
            <h3 class="box-title"><?php ?></h3>
          </div>
          <div class="box-body">
              <div class="table-responsive">
             <table id="example" class="table table-bordered table-striped text-center table-hover table-condensed" >
        <thead>
            <tr class="center aligned">
                <th><center>C&oacute;digo</center></th>
                <th class="hidden-xs" style="width: 35%"><center>Nombre</center></th>
                <th style="width: 15%;"><center>Opciones</center></th>
            </tr>
        </thead>        
        <tbody>
            <div><input class="btn btn-warning btn-xs" type="button" onclick=" location.href='../vista/IngresarConfig.php?tipo=coddepre' " target="frameprincipal" value="Nuevo Código Depreciación"/></div><br>
          <?php
            foreach($datos as $val) {
          ?>
          <tr class="center aligned">
              <td><?php echo $val["coddepre"]; ?></td> 
            <td><?php echo $val["nombre"]; ?></td> 
            <td><center>
                <table>
                <tr><td>
                &nbsp; &nbsp;
                <a onclick="edt_id(<?php echo $val['idcoddepreciacion']; ?>); window.parent.$('body').animate({scrollTop:0}, 'slow');" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalEditar">
                <i class="fa fa-edit" title="Editar"></i>&nbsp; Editar
                </a></td><td>&nbsp; &nbsp;
                <a onclick="delete_id(<?php echo $val['idcoddepreciacion']; ?>); window.parent.$('body').animate({scrollTop:0}, 'slow');" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalEliminar" id="eliminar">
                <i class="fa fa-trash-o" title="Eliminar"></i>&nbsp; Borrar
                </a></td>
                </tr></table></center>
            </td>
          </tr>
        <?php } ?>
        </tbody>
             </table></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
          <!--Modal Editar-->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">C&oacute;digo depreciaci&oacute;n</h4>
          </div>
          <div class="modal-body">
            <b><p>¿Seguro que desea editar el codigo depreciacion?</p></b>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editSi">Si</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Modal Eliminar-->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">C&oacute;digo Depreciaci&oacute;n</h4>
          </div>
          <div class="modal-body">
            <b><p>¿Seguro que desea Eliminar el codigo depreciacion?</p></b>
            <p id="cuerpo" class="text-justify"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="elimSi">Si</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </body>
   <script>
  $(document).ready(function() {
    $('#example').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
        }
    } );
} );
//    Oculta la informacion bajo la datatable para que se muestre completa la tabla en el movil
      $.extend( true, $.fn.dataTable.defaults, {
      "info": false
} );
</script>
</html>
  
 
