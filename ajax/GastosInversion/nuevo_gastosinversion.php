<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include ("../../config/swee.php");
	if (empty($_POST['tipo'])) {
           $errors[] = "Tipo de gastos o inversión vacío";
        } else if (empty($_POST['valor'])){
			$errors[] = "Valor vacío";
		} else if (empty($_POST['detalle'])){
			$errors[] = "Detalle vacío";		
		} else if (
			!empty($_POST['tipo']) &&
			!empty($_POST['detalle']) &&
			!empty($_POST['valor'])
		){
		$tipo=intval($_POST['tipo']);
		if ($tipo==1){
			$tip="GASTOS";}
		if ($tipo==2){
			$tip="INVERSIÓN";}
		if ($tipo==3){
			$tip="DEPOSITO";}
		if ($tipo==4){
			$tip="ITEMS USO PERSONAL - OTROS";
			$id_items=intval($_POST['items']);
			$updateitems = mysqli_query($con,"update precios set PRE_CANT=PRE_CANT-1 where PRE_CODIGO='$id_items'");}
		if ($tipo==5){
			$tip="CELULAR/CHIP USO PERSONAL -OTROS";
			$id_items=intval($_POST['items']);
			$updatecelular = mysqli_query($con,"update precios set PRE_CANT=PRE_CANT-1 where PRE_CODIGO='$id_items'");}
		$valor=floatval($_POST['valor']);
		$detalle=mysqli_real_escape_string($con,(strip_tags($_POST["detalle"],ENT_QUOTES)));
		$date=date("Y-m-d H:i:s");
		$sql="INSERT INTO gastos_inversion (gas_fecha,gas_tipo,gas_detalle,gas_valor) VALUES ('$date','$tip','$detalle','$valor')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
					echo'<script>
						swal({
							type: "success",
							title: " Registrado exitosamente.",
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
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>
