<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$resumen_ventas="active";
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Resumen de Ventas | La Paleteria";
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
	<div class="panel panel-success">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Rango de Fechas, Articulos vendidos de Contado</h4>
		</div>
		<div class="panel-body">
			
			<form class="form-horizontal" role="form" id="">
				
						<div class="form-group">
							<label for="q" class="col-md-2 control-label">Fechas:</label>
							<div class="col-md-2">
								<input type="date" class="form-control" id="q1" required="">
							</div>
							<div class="col-md-2">
								<input type="date" class="form-control" id="q2" required="">
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
	<script type="text/javascript" src="js/resumen_ventas.js"></script>
  </body>
</html>
