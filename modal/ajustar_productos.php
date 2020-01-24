<?php
	if (isset($con))
	{
?>

<script>
	function apcalculariva(cos,iva){
		var txtcosto = cos.value;
		var masiva = ((parseFloat(txtcosto)*iva)/100)+(parseFloat(txtcosto));
            masiva=masiva.toFixed(2);
            if (!isNaN(masiva)) {
                document.getElementById('aju_costomasiva').value = masiva;}
	}

	function apnocalculariva(ivano){
		var txtcosto = ivano.value;
            if (!isNaN(txtcosto)) {
                document.getElementById('aju_costomasiva').value = txtcosto;}
	}

	function apcalcular(p,cmi){
		var txtt = p.value - cmi.value
		var txts = (parseFloat(p.value)-(parseFloat(p.value)*25)/100);
			txtt=txtt.toFixed(2);
			txts=txts.toFixed(2);
			if (!isNaN(txtt) && !isNaN(txts)) {
                document.getElementById('aju_ganancia').value = txtt;
                document.getElementById('aju_seguridad').value = txts;

            }
	}

</script>
	<!-- Modal -->
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-wrench'></i> Ajustar stock del Producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="ajustar_producto" name="ajustar_producto">
			<div id="resultados_ajax3"></div>


			  <div class="form-group">
				<label for="aju_nombre" class="col-sm-3 control-label">Artículo:</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="aju_nombre" name="aju_nombre" placeholder="Nombre del producto" readonly></textarea>
				  <input type="hidden" name="aju_id" id="aju_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="aju_codigobarra" class="col-sm-3 control-label">Código Barra:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="aju_codigobarra" name="aju_codigobarra" placeholder="Código de barra" readonly>
				</div>
			  </div>

			  <div class="form-group">
				<label for="aju_stock" class="col-sm-3 control-label">Stock Actual:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="aju_stock" name="aju_stock" readonly="">
				</div>
				<label for="aju_cant" class="col-sm-3 control-label">Cant.:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="aju_cant" name="aju_cant" placeholder="Cant." autocomplete="off" required maxlength="3" onkeypress="return soloNumeros(event,this);">
				</div>
			  </div>	


			  <div class="form-group">
				<label for="tipo" class="col-sm-3 control-label">Modo existencia:</label>
				<div class="col-sm-8">
				 	<span id="resultadoID"></span>	
				</div>
			  </div>

			<div class="form-group">
				<label for="aju_costo" class="col-sm-3 control-label">Costo:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="aju_costo" name="aju_costo" placeholder="Costo"  required autocomplete="off" maxlength="8"  onkeypress="return soloDecimales(event,this);">
				</div>
				<div class="col-sm-6">
				<label>Iva: </label>
				  <label class="radio-inline">
				    <input type="radio" name="survey" id="Radios1" value="Si" onclick="apcalculariva(aju_costo,'<?php echo IVA?>');">
				    Si
				  </label>
				  <label class="radio-inline">
				    <input type="radio" name="survey" id="Radios2" value="No" onclick="apnocalculariva(aju_costo);">
				    No
				  </label>
				</div>
			  </div>

			  <div class="form-group">
				<label for="aju_costomasiva" class="col-sm-3 control-label">Costo + IVA:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="aju_costomasiva" name="aju_costomasiva" placeholder="Costo + IVA" required readonly="">
				</div>
			  </div>

			  <div class="form-group">
				<label for="aju_pvp" class="col-sm-3 control-label">PVP:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="aju_pvp" name="aju_pvp" onkeyup="apcalcular(aju_pvp,aju_costomasiva);" placeholder="PVP" required autocomplete="off" maxlength="8" onkeypress="return soloDecimales(event,this);">
				</div>
			  </div>

			  <div class="form-group">
				<label for="aju_ganancia" class="col-sm-3 control-label">Ganancia:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="aju_ganancia" name="aju_ganancia" placeholder="Ganancia" required readonly="">
				</div>
			  </div>

			  <div class="form-group">
				<label for="aju_seguridad" class="col-sm-3 control-label">Seguridad:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="aju_seguridad" name="aju_seguridad" placeholder="Seguridad" required autocomplete="off" maxlength="8" onkeypress="return soloDecimales(event,this);">
				</div>
			  </div>
			  
			  <!--
			  <div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Precio</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_precio" name="mod_precio" placeholder="Precio de venta del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  </div>-->
			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
			<button type="submit" class="btn btn-success" id="actualizar_ajuste"><span class="glyphicon glyphicon-ok"></span> Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>


	<?php
		}
	?>