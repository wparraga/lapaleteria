<?php
	include('../is_logged.php');
	$vi_codigo= $_SESSION['vi_codigo'];
	if (empty($_POST['id_cliente'])) {
           $errors[] = "Cliente Vacio";
        }else if (empty($_POST['id_vendedor'])) {
           $errors[] = "Selecciona vendedor";
        //} else if (empty($_POST['condiciones'])){
		//	$errors[] = "Selecciona tipo de pago";
		} else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_vendedor']) &&
			!empty($_POST['condiciones'])
		){
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
		$id_cliente=intval($_POST['id_cliente']);
		$id_vendedor=intval($_POST['id_vendedor']);
		$condiciones=intval($_POST['condiciones']);
		$sql="UPDATE venta_item SET CLI_CODIGO='".$id_cliente."', ID_VENDEDOR='".$id_vendedor."', VI_TIPOPAGO='".$condiciones."' WHERE VI_CODIGO='".$vi_codigo."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Venta ha sido actualizada satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
			//$errors []= "Error desconocido.";
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