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
	$title="Nueva Compra | La Paleteria";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	if(!empty($_GET['del'])){
		$del_tmp=mysqli_query($con,"delete from tmp");
        header("Location: nueva_compraItems.php");
	}
?>
<html lang="en">
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
			<h4><i class='glyphicon glyphicon-edit'></i>Compra de Productos</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_proveedores.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_facturacompra">
				<div class="form-group row">

				  <label for="nombre_proveedor" class="col-md-1 control-label">Proveedor:</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_proveedor" placeholder="Seleccione Proveedor" required>
					  <input id="id_proveedor" type='hidden'>	
				  </div>
				  
				<label for="tel1" class="col-md-1 control-label">Teléfono:</label>
				<div class="col-md-2">
					<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" readonly>
				</div>
					<label for="mail" class="col-md-1 control-label">Dirección:</label>
							<div class="col-md-3">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Dirección" readonly>
							</div>
				 </div>
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Registrador(a):</label>
							<div class="col-md-3">
								<select class="form-control input-sm" id="id_vendedor" disabled>
									<?php
										$sql_vendedor=mysqli_query($con,"select * from users order by lastname");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											if ($id_vendedor==$_SESSION['user_id']){
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
							<label for="tel2" class="col-md-1 control-label">Fecha:</label>
							<div class="col-md-2">
								<input type="datetime" class="form-control input-sm" id="fecha" value="<?php echo date("Y-m-d H:i:s");?>" required>
							</div>
							<label for="pago" class="col-md-1 control-label">Estado:</label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="condiciones">
									<option value="1">Pendiente</option>
									<option value="2">Pagada</option>
								</select>
							</div>
						</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo Producto
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProveedor">
						 <span class="glyphicon glyphicon-user"></span> Nuevo Proveedor
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar Productos para Comprar
						</button>
						<a  href="nueva_compraItems.php?del=<?php echo $id_vendedor;?>" class="btn btn-default"><span class="glyphicon glyphicon-remove" ></span> Cancelar Compra</a>
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-saved"></span> Guardar compra/Imprimir
						</button>
					</div>	
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
			</div>	
		 </div>
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/nueva_compraItems.js"></script>
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
								$('#mail').val(ui.item.direccion_proveedor);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_proveedor" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_proveedor" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_proveedor" ).val("");
							$("#id_proveedor" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
						}
			});	
	</script>

  </body>
</html>