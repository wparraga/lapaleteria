<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_compras="active";
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Editar Compra | La Paleteria";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_GET['c_codigo']))
	{
		$c_codigo=intval($_GET['c_codigo']);
		$campos="proveedores.PRO_CODIGO, proveedores.PRO_NOMBRES, proveedores.PRO_CELULAR, proveedores.PRO_DIRECCION, compras.ID_VENDEDOR, compras.CO_FECHA, compras.CO_TIPOPAGO, compras.CO_NUMERO,compras.CO_SUBTOTAL,compras.CO_IVA,compras.CO_TOTAL";
		$sql_factura=mysqli_query($con,"select $campos from compras, proveedores where compras.PRO_CODIGO=proveedores.PRO_CODIGO and CO_CODIGO='".$c_codigo."'");
		$count=mysqli_num_rows($sql_factura);
		if ($count==1)
		{
				$rw_factura=mysqli_fetch_array($sql_factura);
				$id_proveedor=$rw_factura['PRO_CODIGO'];
				$nombre_proveedor=$rw_factura['PRO_NOMRES'];
				$telefono_proveedor=$rw_factura['PRO_CELULAR'];
				$direccion_proveedor=$rw_factura['PRO_DIRECCION'];
				$id_vendedor_db=$rw_factura['ID_VENDEDOR'];
				$fecha_factura=date("d/m/Y", strtotime($rw_factura['CO_FECHA']));
				//$condiciones=$rw_factura['condiciones'];
				$estado_compra=$rw_factura['CO_TIPOPAGO'];
				$numero_compra=$rw_factura['CO_NUMERO'];
				$_SESSION['c_codigo']=$c_codigo;
				$_SESSION['numero_compra']=$numero_compra;
		}	
		else
		{
			header("location: compra_items.php");
			exit;	
		}
	} 
	else 
	{
		header("location: compra_items.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Factura</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura">
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required value="<?php echo $nombre_cliente;?>">
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">	
				  </div>
				  <label for="tel1" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="<?php echo $telefono_cliente;?>" readonly>
							</div>
					<label for="mail" class="col-md-1 control-label">Email</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly value="<?php echo $email_cliente;?>">
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
							<label for="email" class="col-md-1 control-label">Pago</label>
							<div class="col-md-2">
								<select class='form-control input-sm ' id="condiciones" name="condiciones">
									<option value="1" <?php if ($condiciones==1){echo "selected";}?>>Efectivo</option>
									<option value="2" <?php if ($condiciones==2){echo "selected";}?>>Cheque</option>
									<option value="3" <?php if ($condiciones==3){echo "selected";}?>>Transferencia bancaria</option>
									<option value="4" <?php if ($condiciones==4){echo "selected";}?>>Crédito</option>
								</select>
							</div>
							<div class="col-md-2">
								<select class='form-control input-sm ' id="estado_factura" name="estado_factura">
									<option value="1" <?php if ($estado_factura==1){echo "selected";}?>>Pagado</option>
									<option value="2" <?php if ($estado_factura==2){echo "selected";}?>>Pendiente</option>
								</select>
							</div>
						</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-refresh"></span> Actualizar datos
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="button" class="btn btn-default" onclick="imprimir_factura('<?php echo $id_factura;?>')">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
				<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_factura.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#tel1').val(ui.item.telefono_cliente);
								$('#mail').val(ui.item.email_cliente);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_cliente" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
						}
			});	
	</script>

  </body>
</html>