<?php
	include('../is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_cod'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_seguridad'])) {
           $errors[] = "Seguridad vacío";   
		} else if (
			!empty($_POST['mod_cod'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		$pre_codigo=$_POST['mod_cod'];
		$pre_cant=$_POST['mod_existen'];
		$pre_seg=$_POST['mod_seguridad'];
		$sql="update precios set PRE_CANT='$pre_cant',PRE_SEGURIDAD='$pre_seg' where PRE_CODIGO='$pre_codigo'";
		$query_insert = mysqli_query($con,$sql);
			if ($query_insert){
					echo'<script>
						swal({
							type: "success",
							title: " actualizado exitosamente.",
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
				$errors []= "Algo ha salido mal,, intente nuevamente.".mysqli_error($con);
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