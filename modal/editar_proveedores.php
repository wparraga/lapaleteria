	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Proveedores</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_proveedor" name="editar_proveedor">
			<div id="resultados_ajax2"></div>

			  <div class="form-group">
				<label for="mod_nombres" class="col-sm-3 control-label">Nombres:</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_nombres" name="mod_nombres" required></textarea>
				  <input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Dirección:</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="mod_direccion" name="mod_direccion" required></textarea>
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_celular" class="col-sm-3 control-label">Celular:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_celular" name="mod_celular" required autocomplete="off" onKeyPress="return soloNumeros(event)" maxlength="10" >
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_convencional" class="col-sm-3 control-label">Convencional:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_convencional" name="mod_convencional" required autocomplete="off" onKeyPress="return soloNumeros(event)" maxlength="10" >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_correo" class="col-sm-3 control-label">Correo:</label>
				<div class="col-sm-8">
				  <input type="email" class="form-control" id="mod_correo" name="mod_correo" required autocomplete="off">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_ruc" class="col-sm-3 control-label">RUC:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_ruc" name="mod_ruc" required autocomplete="off" onKeyPress="return soloNumeros(event)" maxlength="13" >
				</div>
			  </div>


			 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
			<button type="submit" class="btn btn-success" id="actualizar_datos"><span class="glyphicon glyphicon-ok"></span> Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>