<?php
    require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
?>
<div class="table-responsive">
    <table class="table">
        <?php   
            $resultado = $_POST['codigoItem']; 
            $nom = $_POST['nomItem']; 
            echo $nom;
        ?>
        <thead>
            <tr class="well">
                <th>Cant.</th>
                <th>Costo</th>
                <th>Costo+IVA</th>
                <th>PVP</th>
                <th>Ganancia</th>
                <th>Seguridad</th>
                <th>Obs.</th>
                <th>  </th>
            </tr>
        </thead>
        <?php
        	$sql="select PRE_CODIGO,PRE_CANT,PRE_COSTO,PRE_COSTOMASIVA,PRE_PVP,PRE_GANANCIA,PRE_SEGURIDAD,PRE_OBSERVACION from vis_itemsconprecios where IT_CODIGO='$resultado'";
            //$sql="select * from vis_itemsconprecios where IT_CODIGO='$resultado'";
        	$query = mysqli_query($con,$sql); 
            while ($fila = mysqli_fetch_row($query)){
                $pre_codigo=$fila[0];
                $pre_cant=$fila[1];
                $pre_seg=$fila[6];
        ?>
            <input type="hidden" value="<?php echo $pre_cant;?>" id="existen<?php echo $pre_codigo;?>">
            <input type="hidden" value="<?php echo $pre_seg;?>" id="seguridad<?php echo $pre_codigo;?>">
        <tbody>
            <tr>
                <td><?php echo $fila[1]; ?></td>
                <td><?php echo $fila[2]; ?></td>
                <td><?php echo $fila[3]; ?></td>
                <td><?php echo $fila[4]; ?></td>
                <td><?php echo $fila[5]; ?></td>
                <td><?php echo $fila[6]; ?></td>
                <td><?php echo $fila[7]; ?></td>
                <td>
                    <a href="#" role="button" title="Editar existencia del Items" onclick="obtener_datos('<?php echo $fila[0]; ?>')" data-toggle="modal" data-target="#modaledit"><i class="glyphicon glyphicon-edit"></i></a>
                </td>
            </tr>
        </tbody>
        <?php } ?>
    </table>

<div id="modaledit" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Existencia del Items</h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="editar_existencia" name="editar_existencia">
                <div id="resultados_ajax_existencia"></div>
              <div class="form-group">
                <div class="col-sm-8">
                  <input type="hidden" id="mod_cod" name="mod_cod"/>
                </div>
              </div>
              <div class="form-group">
                <label for="mod_existen" class="col-sm-3 control-label">Existen:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="mod_existen" name="mod_existen" autocomplete="off" required onKeyPress="return soloNumeros(event)" maxlength="3"/>
                </div>
              </div>
              <div class="form-group">
                <label for="mod_seguridad" class="col-sm-3 control-label">Seguridad:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="mod_seguridad" name="mod_seguridad" autocomplete="off" required onKeyPress="return soloDecimales(event,this);" maxlength="8"/>
                </div>
              </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="guardar_datos"><span class="glyphicon glyphicon-ok"></span> Guardar Datos</button>
                </div>
          </form>      
          </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $( "#editar_existencia" ).submit(function( event ) {
    $('#guardar_datos').attr("disabled", true);
     var parametros = $(this).serialize();
         $.ajax({
                type: "POST",
                url: "ajax/items/editar_existencia.php",
                data: parametros,
                 beforeSend: function(objeto){
                    $("#resultados_ajax_existencia").html("Mensaje: Cargando...");
                  },
                success: function(datos){
                $("#resultados_ajax_existencia").html(datos);
                $('#guardar_datos').attr("disabled", false);
              }
        });
      event.preventDefault();
    })


    function obtener_datos(id){
        var existen = $("#existen"+id).val();
        var seguridad = $("#seguridad"+id).val();
        $("#mod_cod").val(id);
        $("#mod_existen").val(existen);
        $("#mod_seguridad").val(seguridad);
    }
</script>


</div>