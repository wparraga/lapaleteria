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
	$active_productos="active";
	$active_clientes="";
	$active_usuarios="";	
	$title="Items | La Paleteria";
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
				<a  href="consultaExistencias.php" class="btn btn-success"><span class="glyphicon glyphicon-transfer" ></span> Consultar Existencias de Productos Vendidos</a>
				<button type='button' class="btn btn-primary btn-success" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nuevo Producto</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Producto</h4>
		</div>
		<div class="panel-body">
		
		
			<?php
			include("modal/registro_productos.php");
			include("modal/editar_productos.php");
			include("modal/ajustar_productos.php");
			include("modal/precios_productos.php");
			?>
			<form class="form-horizontal" role="form" id="" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Código o nombre</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Código de Barra o nombre del Producto" onkeyup='load(1);' autocomplete="off">
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
	<script type="text/javascript" src="js/items.js"></script>
  </body>
</html>


<script>
$( "#guardar_producto" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/items/nuevo_items.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_productos").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_productos").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_producto" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/items/editar_items.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})


$( "#ajustar_producto" ).submit(function( event ) {
  $('#actualizar_ajuste').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/items/ajustar_items.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax3").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax3").html(datos);
			$('#actualizar_ajuste').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})


	function procesoVerPrecios(codigoItem,nomItem){
		var resultado=""; 
        var parametros = {
                "codigoItem" : codigoItem,
                "nomItem" : nomItem
        };
        request = $.ajax({
                data:  parametros,
                url:   'ajax/items/precios_items.php',
                type:  'post',
                success: function (response) {
                       $("#resultado").html(response);
                }
        });
        }

	function obtener_datos(id){
			var nombre = $("#nombre"+id).val();
			var codigobarra = $("#codigobarra"+id).val();
			var stock = $("#stock"+id).val();
			var costo = $("#costo"+id).val();
			var costomasiva = $("#costomasiva"+id).val();
			var pvp = $("#pvp"+id).val();
			var ganancia = $("#ganancia"+id).val();
			var seguridad = $("#seguridad"+id).val();
			$("#mod_id").val(id);
			$("#mod_nombre").val(nombre);
			$("#mod_codigobarra").val(codigobarra);
			$("#mod_stock").val(stock);
			$("#mod_costo").val(costo);
			$("#mod_costomasiva").val(costomasiva);
			$("#mod_pvp").val(pvp);
			$("#mod_ganancia").val(ganancia);
			$("#mod_seguridad").val(seguridad);
		}


	function obtener_ajustes(id){
			var nombre = $("#nombre"+id).val();
			var codigobarra = $("#codigobarra"+id).val();
			var proveedor = $("#proveedor"+id).val();
			var stock = $("#stock"+id).val();
			$("#aju_id").val(id);
			$("#aju_nombre").val(nombre);
			$("#aju_codigobarra").val(codigobarra);
			$("#aju_proveedor").val(proveedor);
			$("#aju_stock").val(stock);
		}


	function obtenerIdItems(idItem){
        var resultadoID=""; 
        var parametros = {
                "idItem" : idItem
        };
        request = $.ajax({
                data:  parametros,
                url:   'ajax/items/id_items.php',
                type:  'post',
                success: function (response) {
                       $("#resultadoID").html(response);
                }
        });
    }
</script>