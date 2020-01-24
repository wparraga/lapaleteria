<?php
	include('../is_logged.php');
	$a=floatval($_POST['abono']);
	$sa=floatval($_POST['saldo_actual']);
	if (empty($_POST['id'])){
           $errors[] = "ID vacío";
        }else if (empty($_POST['saldo_actual'])) {
           $errors[] = "Saldo Actual vacío";
        }else if (empty($_POST['abono'])) {
           $errors[] = "Abono vacío";
        }else if (empty($_POST['saldo'])) {
           $errors[] = "Saldo vacío";
        }else if ($a>$sa) {
           $errors[] = "Abono es mayor que el saldo_actual";
		}  else if (
			!empty($_POST['id']) &&
			!empty($_POST['saldo_actual']) &&
			!empty($_POST['abono']) &&
			!empty($_POST['saldo'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		include ("../../config/swee.php");
		$saldo_actual=floatval($_POST['saldo_actual']);
		$abono=floatval($_POST['abono']);
		$saldo=floatval($_POST['saldo']);
		$id_cliente=intval($_POST['id']);
		$detalle=mysqli_real_escape_string($con,(strip_tags($_POST["observacion"],ENT_QUOTES)));
		$fecha=date("Y-m-d H:i:s");
		$sql1="UPDATE cliente SET CLI_SALDO=CLI_SALDO-'$abono' WHERE CLI_CODIGO='$id_cliente'";
		$sql2="INSERT INTO pagos(CLI_CODIGO,PAG_FECHA,PAG_DETALLE,PAG_SALDO,PAG_ABONO,PAG_SALDOACTUAL)values('$id_cliente','$fecha','$detalle','$saldo_actual','$abono','$saldo')";
		$query_update = mysqli_query($con,$sql1);
		$query_insert = mysqli_query($con,$sql2);
			if ($query_update && $query_insert){
					echo'<script>
						swal({
							type: "success",
							title: " Cliente actualizado exitosamente.",
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
				$errors []= "Algo ha salido mal intente nuevamente.".mysqli_error($con);
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