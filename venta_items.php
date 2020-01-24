<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Venta Items | La Paleteria";
?>
<!DOCTYPE html>
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
		    <div class="pull-right">
				 <a  href="nueva_ventaItems.php" class="btn btn-success"><span class="glyphicon glyphicon-plus" ></span> Nueva Venta de Items</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Venta de Items</h4>
		</div>
			<div class="panel-body">
			<?php
				include("modal/detalle_ventas.php");
			?>
				<form class="form-horizontal" role="form" id="">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Buscar por:</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre del cliente, # de Venta o Fecha" onkeyup='load(1);'>
							</div>
							
							
							
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>	
		
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/venta_items.js"></script>
  </body>
</html>