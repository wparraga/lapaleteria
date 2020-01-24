<?php
	include('../is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre de Item vacío";
        } else if (empty($_POST['mod_codigobarra'])){
			$errors[] = "Código de Barra vacío";
		} else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_nombre']) &&
			!empty($_POST['mod_codigobarra'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$codigobarra=mysqli_real_escape_string($con,(strip_tags($_POST["mod_codigobarra"],ENT_QUOTES)));
		$id_producto=$_POST['mod_id'];
		$date=date("Y-m-d H:i:s");
		$detalle='Edición de datos del item'.$nombre;
		$sql1="update items set IT_ARTICULO='$nombre',IT_CODIGOBARRA='$codigobarra' where IT_CODIGO='$id_producto'";
		$sql2="INSERT INTO auditoria(AUD_FECHA,AUD_USUARIO,AUD_DETALLE,AUD_TIPO)VALUES('$date','WALTER PARRAGA','$detalle','EDICION')";

		$query_update = mysqli_query($con,$sql1);
		$query_insert = mysqli_query($con,$sql2);

			if ($query_update && $query_insert){
					echo'<script>
						swal({
							type: "success",
							title: " Producto actualizado exitosamente.",
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