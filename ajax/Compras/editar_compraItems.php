<?php
	include('../is_logged.php');
	$c_codigo= $_SESSION['c_codigo'];
	if (empty($_POST['id_proveedor'])) {
           $errors[] = "Proveedor Vacio";
        }else if (empty($_POST['id_vendedor'])) {
           $errors[] = "Selecciona Registrador";
        } else if (empty($_POST['condiciones'])){
			$errors[] = "Selecciona estado de pago";
		} else if (
			!empty($_POST['id_proveedor']) &&
			!empty($_POST['id_vendedor']) &&
			!empty($_POST['condiciones'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		$id_proveedor=intval($_POST['id_proveedor']);
		$id_vendedor=intval($_POST['id_vendedor']);
		$condiciones=intval($_POST['condiciones']);
		$sql="UPDATE compras SET PRO_CODIGO='".$id_proveedor."', ID_VENDEDOR='".$id_vendedor."', CO_ESTADO='".$condiciones."' WHERE CO_CODIGO='".$c_codigo."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Factura ha sido actualizada satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
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