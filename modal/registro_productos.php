<?php
	if (isset($con))
	{
?>


<script>
	function rpcalculariva(cos,iva){
		var txtcosto = cos.value;
		var masiva = ((parseFloat(txtcosto)*iva)/100)+(parseFloat(txtcosto));
            masiva=masiva.toFixed(2);
            if (!isNaN(masiva)) {
                document.getElementById('costomasiva').value = masiva;}
	}

	function rpnocalculariva(ivano){
		var txtcosto = ivano.value;
            if (!isNaN(txtcosto)) {
                document.getElementById('costomasiva').value = txtcosto;}
	}

	function rpcalcular(p,cmi){
		var txtt = p.value - cmi.value
		var txts = (parseFloat(p.value)-(parseFloat(p.value)*25)/100);
			txtt=txtt.toFixed(2);
			txts=txts.toFixed(2);
			if (!isNaN(txtt) && !isNaN(txts)) {
                document.getElementById('ganancia').value = txtt;
                document.getElementById('seguridad').value = txts;

            }
	}

</script>

	<!-- Modal -->
	<div id="nuevoProducto" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Nuevo Producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_productos"></div>

			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Producto:</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="nombre" name="nombre" placeholder="Nombre del Producto" required maxlength="255" ></textarea>
				  
				</div>
			  </div>

			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Código Barra:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="codigobarra" name="codigobarra" placeholder="Código de barra" required autocomplete="off">
				</div>
			  </div>

			  <div class="form-group">
				<label for="stock" class="col-sm-3 control-label">Stock:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="stock" name="stock" placeholder="Stock" required autocomplete="off" onKeyPress="return soloNumeros(event)"  maxlength="3">
				</div>
			  </div>

			  <div class="form-group">
				<label for="costo" class="col-sm-3 control-label">Costo:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="costo" name="costo" placeholder="Costo" required autocomplete="off" maxlength="8"  onkeypress="return soloDecimales(event,this);">
				</div>
				<div class="col-sm-6">
				<label>Iva: </label>

				  <label class="radio-inline">
				    <input type="radio" name="survey" id="Radios1" value="Si" onclick="rpcalculariva(costo,'<?php echo IVA?>');">
				    Si
				  </label>
				  <label class="radio-inline">
				    <input type="radio" name="survey" id="Radios2" value="No" onclick="rpnocalculariva(costo);">
				    No
				  </label>
				</div>
			  </div>

			  <div class="form-group">
				<label for="costomasiva" class="col-sm-3 control-label">Costo + IVA:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="costomasiva" name="costomasiva" placeholder="Costo + IVA" required readonly="">
				</div>
			  </div>

			  <div class="form-group">
				<label for="pvp" class="col-sm-3 control-label">PVP:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="pvp" name="pvp" onkeyup="rpcalcular(pvp,costomasiva);" placeholder="PVP" required autocomplete="off" maxlength="8" onkeypress="return soloDecimales(event,this);">
				</div>
			  </div>

			  <div class="form-group">
				<label for="ganancia" class="col-sm-3 control-label">Ganancia:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="ganancia" name="ganancia" placeholder="Ganancia" required readonly="">
				</div>
			  </div>

			  <div class="form-group">
				<label for="seguridad" class="col-sm-3 control-label">Seguridad:</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="seguridad" name="seguridad" placeholder="Seguridad" required autocomplete="off" maxlength="8" onkeypress="return soloDecimales(event,this);">
				</div>
			  </div>
			  
			  <!--
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Precio</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio de venta del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  </div>
			 -->
			 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
			<button type="submit" class="btn btn-success" id="guardar_datos"><span class="glyphicon glyphicon-ok"></span> Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>