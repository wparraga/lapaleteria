<?php
	if (isset($con))
		{
?>
<script type="text/javascript">
	function calsaldo(abo,salact){
		var sal = salact.value - abo.value
		sal=sal.toFixed(2);
		if (!isNaN(sal)) {
			document.getElementById('saldo').value = sal;
		}
	}
</script>
	<div class="modal fade" id="myModalabonarpagar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-usd'></i> Abonar/Pagar</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="abonar_pagar" name="abonar_pagar">
			<div id="resultados_ajax_abonarpagar"></div>

			  <div class="form-group">
				<label for="mod_cedula" class="col-sm-3 control-label">Cédula</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="cedula" name="cedula" readonly>
					<input type="hidden" name="id" id="id">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Cliente</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" readonly>
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Saldo Actual $</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="saldo_actual" name="saldo_actual" readonly>
				</div>
			  </div>

			  <div class="form-group">
				<label for="abono" class="col-sm-3 control-label">Abono $</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="abono" name="abono" onkeyup="calsaldo(abono,saldo_actual);" placeholder="Ingrese Abono" required autocomplete="off" maxlength="8"  onkeypress="return soloDecimales(event,this);">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Saldo $</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="saldo" name="saldo" placeholder="Saldo" readonly>
				</div>
			  </div>

			  <div class="form-group">
				<label for="observacion" class="col-sm-3 control-label">Observación</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="observacion" name="observacion" placeholder="Observación"></textarea>
				</div>
			  </div>

	

			  <div class= "row">                          
			    <div  class="col-lg-16 col-md-16">
			        <div class="col-lg-offset-1 col-md-offset-10 col-lg-10 col-md-10">
			            <span id="resultadoabonos"></span>
			        </div>
			    </div>
			</div>




		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
			<button type="submit" class="btn btn-danger" id="guardar_datos"><span class="glyphicon glyphicon-ok"></span> Abonar/Pagar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>