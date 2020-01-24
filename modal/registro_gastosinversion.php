	<?php
		if (isset($con))
		{
	?>
		<script language="javascript" src="./js/jquery-3.1.1.min.js"></script>
		<script language="javascript">
			$(document).ready(function(){
				$("#items").change(function () {
					$("#items option:selected").each(function () {
						id_items = $(this).val();
						$.post("./ajax/GastosInversion/getprecioitems.php", { id_items: id_items }, function(data){
							$("#preciocompra").html(data);
						});
					});
				})
			});
		</script>

	<!-- Modal -->
	<div class="modal fade bs-example-modal-lg" id="nuevoGastoinversion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Gasto o Inversión</h4>
		  </div>
		  <div class="modal-body" id="limpia">
		  <form class="form-horizontal" method="post" id="guardar_gastoinversion" name="guardar_gastoinversion">
			<div id="resultados_ajax"></div>

			  <div class="form-group">
				<label for="tipo" class="col-sm-2 control-label">Tipo:</label>
				<div class="col-sm-9">
				 <select class="form-control" id="tipo" name="tipo" onChange="document.getElementById('items').disabled=this.selectedIndex!=4; document.getElementById('celular').disabled=this.selectedIndex!=5;" required>
					<option value="">-- Selecciona tipo --</option>
					<option value="1">GASTOS</option>
					<option value="2">INVERSIÓN</option>
					<option value="3">DEPOSITOS</option>
					<option value="4">ITEMS USO PERSONAL</option>
					<option value="5">CELULAR/CHIP USO PERSONAL</option>
				  </select>
				</div>
			  </div>

			  <div class="form-group">
				<label for="articulo" class="col-sm-2 control-label">Items:</label>
				<div class="col-sm-9">
				 <select class="form-control" id="items" name="items" disabled="true" required >
				   <option value="">--Seleccione Items--</option>
			       <?php
			            $sql="select PRE_CODIGO,IT_ARTICULO,PRE_COSTOMASIVA,PRE_CANT,PRE_COSTOMASIVA from vis_itemsconprecios where PRE_CANT>=1 order by IT_ARTICULO";
			            $result = mysqli_query($con,$sql);
			            while($d1=mysqli_fetch_row($result)){
			              echo '<option value="'.$d1[0].'">'.$d1[1].' - Existen: '.$d1[3].' -PC: '.$d1[4].'</option>';
			            }
			          ?>
			      </select>
				</div>
			  </div>

			  <div class="form-group">
				<label for="celular" class="col-sm-2 control-label">Celular:</label>
				<div class="col-sm-9">
				 <select class="form-control" id="celular" name="celular" disabled="true" required >
				 	<option value="">--Seleccione Celular--</option>
			       <?php
			            $sql="select ASO_CODIGO,CEL_MARCA,CEL_MODELO,ASO_IMESN,ASO_ICCID,ASO_COSTOMASIVA from vis_celularesconprecios order by CEL_MARCA";
			            $result = mysqli_query($con,$sql);
			            while($d=mysqli_fetch_row($result)){
			              echo '<option value="'.$d[0].'">'.$d[1].' '.$d[2].' IMESN: '.$d[3].' ICCID: '.$d[4].' -PC: '.$d[5].'</option>';
			            }
			          ?>
			      </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="valor" class="col-sm-2 control-label">Valor:</label>
				<div class="col-sm-9">
				  <span id="preciocompra"></span>
				  <input type="text" class="form-control" id="valor" name="valor" required autocomplete="off" maxlength="8"  onkeypress="return soloDecimales(event,this);">
				</div>
			  </div>
			  <div class="form-group">
				<label for="detalle" class="col-sm-2 control-label">Detalle:</label>
				<div class="col-sm-9">
					<textarea class="form-control" id="detalle" name="detalle" ></textarea>
				</div>
			  </div>
			  

		  </div>
		  <div class="modal-footer">
		  	<button class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
			<button type='submit' class="btn btn-success" id="guardar_datos"><span class="glyphicon glyphicon-ok"></span> Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

	<?php
		}
	?>