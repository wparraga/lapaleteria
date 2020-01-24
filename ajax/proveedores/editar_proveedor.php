<?php
	include('../is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_nombres'])) {
           $errors[] = "Nombres vacío";
        }else if (empty($_POST['mod_direccion'])) {
           $errors[] = "Dirección vacío";
        }else if (empty($_POST['mod_correo'])) {
           $errors[] = "Correo vacío";
		}  else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_nombres']) &&
			!empty($_POST['mod_direccion']) &&
			!empty($_POST['mod_correo'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		include ("../../config/swee.php");
		$nombres=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombres"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["mod_direccion"],ENT_QUOTES)));
		$celular=mysqli_real_escape_string($con,(strip_tags($_POST["mod_celular"],ENT_QUOTES)));
		$convencional=mysqli_real_escape_string($con,(strip_tags($_POST["mod_convencional"],ENT_QUOTES)));
		$correo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_correo"],ENT_QUOTES)));
		$ruc=mysqli_real_escape_string($con,(strip_tags($_POST["mod_ruc"],ENT_QUOTES)));
		$id_proveedor=intval($_POST['mod_id']);

		$sql="UPDATE proveedores SET PRO_NOMBRES='".$nombres."', PRO_DIRECCION='".$direccion."', PRO_CELULAR='".$celular."', PRO_CONVENCIONAL='".$convencional."', PRO_CORREO='".$correo."', PRO_RUC='".$ruc."' WHERE PRO_CODIGO='".$id_proveedor."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
					echo'<script>
						swal({
							type: "success",
							title: " Proveedor actualizado exitosamente.",
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