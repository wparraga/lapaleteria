	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModalDetalleventa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-usd'></i> Detalle de la Venta </h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="detalle_ventas" name="detalle_ventas">
			<div id="resultados_ajax3"></div>

            <div class="container-fluid">
              	<span id="resultado"></span>
            </div> 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>