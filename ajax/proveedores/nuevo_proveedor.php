<?php
	include('../is_logged.php');
	if (empty($_POST['nombres'])) {
           $errors[] = "Nombres vacío";
        } else if (empty($_POST['direccion'])){
			$errors[] = "Dirección vacío";
		} else if (empty($_POST['correo'])){
			$errors[] = "Correo vacío";			
		} else if (
			!empty($_POST['nombres']) &&
			!empty($_POST['direccion']) &&
			!empty($_POST['correo'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		include ("../../config/swee.php");
		$nombres=mysqli_real_escape_string($con,(strip_tags($_POST["nombres"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		$celular=mysqli_real_escape_string($con,(strip_tags($_POST["celular"],ENT_QUOTES)));
		$convencional=mysqli_real_escape_string($con,(strip_tags($_POST["convencional"],ENT_QUOTES)));
		$correo=mysqli_real_escape_string($con,(strip_tags($_POST["correo"],ENT_QUOTES)));
		$ruc=mysqli_real_escape_string($con,(strip_tags($_POST["ruc"],ENT_QUOTES)));

		$sql="INSERT INTO proveedores (PRO_NOMBRES,PRO_DIRECCION,PRO_CELULAR,PRO_CONVENCIONAL,PRO_CORREO,PRO_RUC) VALUES ('$nombres','$direccion','$celular','$convencional','$correo','$ruc')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				echo'<script>
						swal({
							type: "success",
							title: " Proveedor registrado exitosamente.",
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