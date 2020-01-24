<?php
	include('../is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_cedula'])) {
           $errors[] = "Cédula vacío";
        }else if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
        }else if (empty($_POST['mod_direccion'])) {
           $errors[] = "Dirección vacío";
		}  else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_cedula']) &&
			!empty($_POST['mod_nombre']) &&
			!empty($_POST['mod_direccion'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		include ("../../config/swee.php");
		$cedula=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cedula"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telefono"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["mod_direccion"],ENT_QUOTES)));
		$id_cliente=intval($_POST['mod_id']);
		$sql="UPDATE cliente SET CLI_CEDULA='".$cedula."', CLI_NOMBRES='".$nombre."', CLI_DIRECCION='".$direccion."', CLI_TELEFONO='".$telefono."' WHERE CLI_CODIGO='".$id_cliente."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
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