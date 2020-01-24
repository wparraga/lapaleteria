<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$gastos_inversion="active";
	$active_usuarios="";	
	$title="Gastos - Inversión | La Paleteria";
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
		    <div class="pull-right">
				<button type='button' class="btn btn-success" data-toggle="modal" data-target="#nuevoGastoinversion"><span class="glyphicon glyphicon-plus" ></span> Ingresar Gastos-Inversión</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Gastos-Inversión</h4>
		</div>
		<div class="panel-body">
			<?php
				include("modal/registro_gastosinversion.php");
				//include("modal/editar_gastosinversion.php");
			?>
			<form class="form-horizontal" role="form" id="">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Detalle: </label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Detalle del Gasto - Inversión" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/gastos_inversion.js"></script>
  </body>
</html>
