	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Proveedor</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_proveedor" name="guardar_proveedor">
			<div id="resultados_ajax"></div>

			  <div class="form-group">
				<label for="nombres" class="col-sm-3 control-label">Nombres:</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="nombres" name="nombres" required></textarea>
				</div>
			  </div>

			  <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Dirección:</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="direccion" name="direccion" required></textarea>
				</div>
			  </div>

			  <div class="form-group">
				<label for="celular" class="col-sm-3 control-label">Celular:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="celular" name="celular" required autocomplete="off" onKeyPress="return soloNumeros(event)" maxlength="10" >
				</div>
			  </div>

			  <div class="form-group">
				<label for="convencional" class="col-sm-3 control-label">Convencional:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="convencional" name="convencional" required autocomplete="off" onKeyPress="return soloNumeros(event)" maxlength="10" >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo:</label>
				<div class="col-sm-8">
				  <input type="email" class="form-control" id="correo" name="correo" required autocomplete="off">
				</div>
			  </div>

			  <div class="form-group">
				<label for="ruc" class="col-sm-3 control-label">RUC:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="ruc" name="ruc" required autocomplete="off" onKeyPress="return soloNumeros(event)" maxlength="13" >
				</div>
			  </div>
			  

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Cerrar</button>
			<button type="submit" class="btn btn-success" id="guardar_datos"><span class="glyphicon glyphicon-ok"></span>Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>