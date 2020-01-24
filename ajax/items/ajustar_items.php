<?php
include('../is_logged.php');
	if (empty($_POST['aju_id'])) {
           $errors[] = "ID vacío";
       } else if ($_POST['tipo']==""){
			$errors[] = "Selecciona el tipo tranasacción";
        }else if (empty($_POST['aju_costo'])){
           $errors[] = "Costo vacío";
        }else if (empty($_POST['aju_costomasiva'])){
           $errors[] = "Costo más IVA vacío";
        }else if (empty($_POST['aju_pvp'])){
           $errors[] = "PVP vacío";
        }else if (empty($_POST['aju_ganancia'])){
           $errors[] = "Ganancia vacío";
        }else if (empty($_POST['aju_seguridad'])){
           $errors[] = "Precio de seguridad vacío";
		} else if (
			!empty($_POST['aju_id']) &&
			$_POST['tipo']!="" &&
			!empty($_POST['aju_costo']) &&
			!empty($_POST['aju_costomasiva']) &&
			!empty($_POST['aju_pvp']) &&
			!empty($_POST['aju_ganancia']) &&
			!empty($_POST['aju_seguridad'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		$id_producto=$_POST['aju_id'];
		$cant=intval($_POST['aju_cant']);
		$tipo=intval($_POST['tipo']);
		$costo=floatval($_POST['aju_costo']);
		$costomasiva=floatval($_POST['aju_costomasiva']);
		$pvp=floatval($_POST['aju_pvp']);
		$ganancia=floatval($_POST['aju_ganancia']);
		$seguridad=floatval($_POST['aju_seguridad']);
		$date=date("Y-m-d H:i:s");


		//$detalle='Aumento de stock del item '.$nombre. ' con: '.$cant.' unidades';
		if ($tipo==0){
			$sql1="INSERT INTO precios (IT_CODIGO,PRE_FECHA,PRE_CANT,PRE_COSTO,PRE_COSTOMASIVA,PRE_PVP,PRE_GANANCIA,PRE_SEGURIDAD,PRE_OBSERVACION)VALUES(
				'$id_producto','$date','$cant','$costo','$costomasiva','$pvp','$ganancia','$seguridad','INGRESO NUEVO PRECIO')";
		}else{
			$sql1="UPDATE precios SET PRE_CANT=PRE_CANT+'$cant',PRE_COSTO='$costo',PRE_COSTOMASIVA='$costomasiva',PRE_PVP='$pvp',PRE_GANANCIA='$ganancia',PRE_SEGURIDAD='$seguridad' WHERE PRE_CODIGO='$tipo'";
		}
		$sql2="INSERT INTO auditoria(AUD_FECHA,AUD_USUARIO,AUD_DETALLE,AUD_TIPO)VALUES('$date','WALTER PARRAGA','arreglos','INGRESO')";
		$query_update = mysqli_query($con,$sql1);
		$query_insert = mysqli_query($con,$sql2);
			if ($query_update && $query_insert){
					echo'<script>
						swal({
							type: "success",
							title: "Artículo ajustado exitosamente.",
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
			} else{
				$errors []= "Algo ha salido mal, intenta nuevamente.".mysqli_error($con);
			}
		} else {
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
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>
