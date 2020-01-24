<?php
include('../is_logged.php');
	if (empty($_POST['nombre'])) {
           $errors[] = "Nombre del Item vacío";
        } else if (empty($_POST['pvp'])){
			$errors[] = "PVP vacío";
		} else if (empty($_POST['ganancia'])){
			$errors[] = "Ganancia vacío";
		} else if (empty($_POST['seguridad'])){
			$errors[] = "Precio ultimo vacío";		
		} else if (
			!empty($_POST['nombre']) &&
			!empty($_POST['codigobarra']) &&
			!empty($_POST['pvp']) &&
			!empty($_POST['ganancia']) &&
			!empty($_POST['seguridad'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		include ("../../config/swee.php");
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$codigobarra=mysqli_real_escape_string($con,(strip_tags($_POST["codigobarra"],ENT_QUOTES)));
		$stock=intval($_POST['stock']);
		$costo=floatval($_POST['costo']);
		$costomasiva=floatval($_POST['costomasiva']);
		$pvp=floatval($_POST['pvp']);
		$ganancia=floatval($_POST['ganancia']);
		$seguridad=floatval($_POST['seguridad']);

		$date=date("Y-m-d H:i:s");
		$sql1="INSERT INTO items (IT_ARTICULO,IT_CODIGOBARRA)VALUES('$nombre','$codigobarra')";
		$query_new_insert1 = mysqli_query($con,$sql1);
		$query=mysqli_query($con,"select distinct last_insert_id() from items");
		while($r=mysqli_fetch_row($query)){
            $coditems=$r[0];
        }
        $sql2="INSERT INTO precios(IT_CODIGO,PRE_FECHA,PRE_CANT,PRE_COSTO,PRE_COSTOMASIVA,PRE_PVP,PRE_GANANCIA,PRE_SEGURIDAD,PRE_OBSERVACION)VALUES
		 ('$coditems','$date','$stock','$costo','$costomasiva','$pvp','$ganancia','$seguridad','INGRESO NUEVA COMPRA')";
		 $query_new_insert2 = mysqli_query($con,$sql2);


		if ($query_new_insert1 && $query_new_insert2){
					echo'<script>
						swal({
							type: "success",
							title: " Producto registrado exitosamente.",
							showConfirmButton: true,
							confirmButtonColor: "#d9534f",
							confirmButtonText: "Aceptar",
							closeOnConfirm: false
							}).then(function(result){
							if (result.value) {
								location.reload(true);
							}
						})
					</script>';
		}else{
				$errors []= "Algo ha salido mal intenta nuevamente.".mysqli_error($con);
			 }
		}else{
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Listo!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>