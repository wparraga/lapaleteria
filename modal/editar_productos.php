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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Datos del Producto</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
			<div id="resultados_ajax2"></div>


			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Producto:</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre del producto" required></textarea>
				  <input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_codigobarra" class="col-sm-3 control-label">Código Barra:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_codigobarra" name="mod_codigobarra" placeholder="Código de barra" required autocomplete="off">
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