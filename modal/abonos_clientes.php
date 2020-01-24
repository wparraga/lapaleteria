	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade bs-example-modal-lg" id="mymodalabonostotales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-usd'></i> Abonos/Pagos Realizados</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="abonos_cliente" name="abonos_cliente">
			<div id="resultados_ajax3"></div>

            <div class="container-fluid">
              	<span id="resultadoabonostotales"></span>
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