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
	
	require_once ("config/db.php");
	require_once ("config/conexion.php");
	
	if (isset($_GET['c_codigo']))
	{
		$c_codigo=intval($_GET['c_codigo']);
		$campos="proveedores.PRO_CODIGO, proveedores.PRO_NOMBRES, proveedores.PRO_CELULAR, proveedores.PRO_DIRECCION, compras.ID_VENDEDOR, compras.CO_FECHA, compras.CO_NUMERO,compras.CO_TOTAL,compras.CO_ESTADO";
		$sql_factura=mysqli_query($con,"select $campos from compras, proveedores where compras.PRO_CODIGO=proveedores.PRO_CODIGO and CO_CODIGO='".$c_codigo."'");
		$count=mysqli_num_rows($sql_factura);
		if ($count==1)
		{
				$rw_factura=mysqli_fetch_array($sql_factura);
				$id_proveedor=$rw_factura['PRO_CODIGO'];
				$nombre_proveedor=$rw_factura['PRO_NOMBRES'];
				$telefono_proveedor=$rw_factura['PRO_CELULAR'];
				$direccion_proveedor=$rw_factura['PRO_DIRECCION'];
				$id_vendedor_db=$rw_factura['ID_VENDEDOR'];
				$fecha_factura=date("Y/m/d H:i:s", strtotime($rw_factura['CO_FECHA']));
				$condiciones=$rw_factura['CO_ESTADO'];
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
<html lang="es">
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
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Compra</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_proveedores.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_facturacompra">
				<div class="form-group row">
				  <label for="nombre_proveedor" class="col-md-1 control-label">Proveedor: </label>
				  <div class="col-md-3">
					   <input type="text" class="form-control input-sm" id="nombre_proveedor" placeholder="Selecciona Proveedor" required value="<?php echo $nombre_proveedor;?>">
					  <input id="id_proveedor" name="id_proveedor" type='hidden' value="<?php echo $id_proveedor;?>">
				  </div>
				  <label for="tel1" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="<?php echo $telefono_proveedor;?>" readonly>
							</div>
					<label for="direccion_proveedor" class="col-md-1 control-label">Dirección: </label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="direccion_proveedor" placeholder="direccion_proveedor" readonly value="<?php echo $direccion_proveedor;?>">
							</div>
				 </div>
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Registrador</label>
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
							<label for="email" class="col-md-1 control-label">Estado: </label>
							<div class="col-md-2">
								<select class='form-control input-sm ' id="condiciones" name="condiciones">
									<option value="1" <?php if ($condiciones==1){echo "selected";}?>>Pendiente</option>
									<option value="2" <?php if ($condiciones==2){echo "selected";}?>>Pagado</option>
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
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProveedor">
						 <span class="glyphicon glyphicon-user"></span> Nuevo Proveedor
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
			<div class="editar_compra" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_compraItems.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
    <script type="text/javascript" src="js/jquery/jquery-ui.js"></script>



	<script>
		$(function() {
						$("#nombre_proveedor").autocomplete({
							source: "./ajax/proveedores/autocomplete/proveedores.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_proveedor').val(ui.item.id_proveedor);
								$('#nombre_proveedor').val(ui.item.nombre_proveedor);
								$('#tel1').val(ui.item.telefono_proveedor);
								$('#direccion_proveedor').val(ui.item.direccion_proveedor);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_proveedor" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_proveedor" ).val("");
							$("#tel1" ).val("");
							$("#direccion_proveedor" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_proveedor" ).val("");
							$("#id_proveedor" ).val("");
							$("#tel1" ).val("");
							$("#direccion_proveedor" ).val("");
						}
			});	
	</script>

  </body>
</html>