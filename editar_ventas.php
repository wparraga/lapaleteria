<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_compras="";
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Editar Ventas | La Paleteria";
	
	require_once ("config/db.php");
	require_once ("config/conexion.php");
	
	if (isset($_GET['vi_codigo']))
	{
		$vi_codigo=intval($_GET['vi_codigo']);
		$campos="cliente.CLI_CODIGO, cliente.CLI_NOMBRES, cliente.CLI_TELEFONO, cliente.CLI_DIRECCION,venta_item.ID_VENDEDOR,venta_item.VI_FECHA,venta_item.VI_NUMERO,venta_item.VI_SUBTOTAL,venta_item.VI_IVA,venta_item.VI_TOTAL,venta_item.VI_TIPOPAGO";
		$sql_factura=mysqli_query($con,"select $campos from venta_item, cliente where venta_item.CLI_CODIGO=cliente.CLI_CODIGO and venta_item.VI_CODIGO='".$vi_codigo."'");
		$count=mysqli_num_rows($sql_factura);
		if ($count==1)
		{
				$rw_factura=mysqli_fetch_array($sql_factura);
				$id_cliente=$rw_factura['CLI_CODIGO'];
				$nombre_cliente=$rw_factura['CLI_NOMBRES'];
				$telefono_cliente=$rw_factura['CLI_TELEFONO'];
				$direccion_cliente=$rw_factura['CLI_DIRECCION'];
				$id_vendedor_db=$rw_factura['ID_VENDEDOR'];
				$fecha_factura=date("Y/m/d H:i:s", strtotime($rw_factura['VI_FECHA']));
				$condiciones=$rw_factura['VI_TIPOPAGO'];
				$numero_venta=$rw_factura['VI_NUMERO'];
				$_SESSION['vi_codigo']=$vi_codigo;
				$_SESSION['numero_venta']=$numero_venta;
		}	
		else
		{
			header("location: venta_items.php");
			exit;	
		}
	} 
	else 
	{
		header("location: venta_items.php");
		exit;
	}
?>
<html lang="es">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Venta</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_facturaventa">
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente: </label>
				  <div class="col-md-3">
					   <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona Cliente" required value="<?php echo $nombre_cliente;?>">
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">
				  </div>
				  <label for="tel1" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="<?php echo $telefono_cliente;?>" readonly>
							</div>
					<label for="direccion_cliente" class="col-md-1 control-label">Dirección: </label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="direccion_cliente" placeholder="direccion cliente" readonly value="<?php echo $direccion_cliente;?>">
							</div>
				 </div>
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Vendedor</label>
							<div class="col-md-3">
								<select class="form-control input-sm" id="id_vendedor" name="id_vendedor">
									<?php
										$sql_vendedor=mysqli_query($con,"select * from users order by lastname");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											if ($id_vendedor==$id_vendedor_db){
												$selected="selected";
											} else {
												$selected="";
											}
											?>
											<option value="<?php echo $id_vendedor?>" <?php echo $selected;?>><?php echo $nombre_vendedor?></option>
											<?php
										}
									?>
								</select>
							</div>
							<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="fecha" value="<?php echo $fecha_factura;?>" readonly>
							</div>
							<label for="pago" class="col-md-1 control-label">Pago:</label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="condiciones" onChange="">			<option value="1" <?php if ($condiciones==1){echo "selected";}?>>
									Contado</option>
									<option value="2" <?php if ($condiciones==2){echo "selected";}?>>
									Crédito</option>
								</select>
							</div>
							<div class="col-md-2">	
								<input type="text" class="form-control input-sm" id="abono" disabled="true" placeholder="Abono" maxlength="8" required="" onkeypress="return soloDecimales(event,this);"/>
							</div>
						</div>
				<div class="col-md-12">
					<div class="pull-right">
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-refresh"></span> Actualizar datos
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar Productos para Vender
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
			<div class="editar_venta" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_ventaItems.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
    <script type="text/javascript" src="js/jquery/jquery-ui.js"></script>
    <script>
		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/clientes/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#tel1').val(ui.item.telefono_cliente);
								$('#direccion_cliente').val(ui.item.direccion_cliente);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_cliente" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#direccion_cliente" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#direccion_cliente" ).val("");
						}
			});	
	</script>

  </body>
</html>