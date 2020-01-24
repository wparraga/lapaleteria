<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include ("../../config/swee.php");
function validarCI($strCedula)
{
if(is_null($strCedula) || empty($strCedula)){
    return false;
}else{
    if(is_numeric($strCedula)){
        $total_caracteres=strlen($strCedula);
        if($total_caracteres==10){
            $nro_region=substr($strCedula, 0,2);
            if($nro_region>=1 && $nro_region<=24){
                $ult_digito=substr($strCedula, -1,1);
                //extraigo los valores pares//
                $valor2=substr($strCedula, 1, 1);
                $valor4=substr($strCedula, 3, 1);
                $valor6=substr($strCedula, 5, 1);
                $valor8=substr($strCedula, 7, 1);
                $suma_pares=($valor2 + $valor4 + $valor6 + $valor8);
                //extraigo los valores impares//
                $valor1=substr($strCedula, 0, 1);
                $valor1=($valor1 * 2);
                if($valor1>9){ 
                    $valor1=($valor1 - 9); }
                else{ 
                    
                }
                $valor3=substr($strCedula, 2, 1);
                $valor3=($valor3 * 2);
                if($valor3>9){ 
                    $valor3=($valor3 - 9); }
                else{ 
                    
                }
                $valor5=substr($strCedula, 4, 1);
                $valor5=($valor5 * 2);
                if($valor5>9){ 
                    $valor5=($valor5 - 9); }
                else{ 
                    
                }
                $valor7=substr($strCedula, 6, 1);
                $valor7=($valor7 * 2);
                if($valor7>9){ 
                    $valor7=($valor7 - 9); }
                else{ 
                    
                }
                $valor9=substr($strCedula, 8, 1);
                $valor9=($valor9 * 2);
                if($valor9>9){ 
                    $valor9=($valor9 - 9); }
                else{ 
                    
                }
                $suma_impares=($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
                $suma=($suma_pares + $suma_impares);
                $dis=substr($suma, 0,1);
                $dis=(($dis + 1)* 10);
                $digito=($dis - $suma);
                if($digito==10){ 
                    $digito='0'; }
                else{ 
                    
                }
                if ($digito==$ult_digito){
                    return true;}
                else{
                     return false;}
                }else{return false;               
}
}else{return false;
}
}else{return false;
}
}
}
	$ced=validarCI($_POST['cedula']);
	$ced_cliente=intval($_POST['cedula']);
		$query=mysqli_query($con, "select * from cliente where CLI_CEDULA='".$ced_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			$v=0;
		}else{
			$v=1;
		}

	if (empty($_POST['cedula'])) {
           $errors[] = "Cedula vacío";
        } else if (empty($_POST['nombre'])){
			$errors[] = "Nombre del cliente vacío";
		} else if (empty($_POST['direccion'])){
			$errors[] = "Dirección vacío";	
		} else if ($ced==false){
			$errors[] = "Cedula Incorrecta";
		} else if ($v==1){
			$errors[] = "Cedula ya esta registrada en la base de datos";	
		} else if (
			!empty($_POST['cedula']) &&
			!empty($_POST['nombre']) &&
			!empty($_POST['direccion'])
		){

		$cedula=mysqli_real_escape_string($con,(strip_tags($_POST["cedula"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		$sql="INSERT INTO cliente (CLI_CEDULA,CLI_NOMBRES,CLI_DIRECCION,CLI_TELEFONO,CLI_SALDO) VALUES ('$cedula','$nombre','$direccion','$telefono',0)";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
					echo'<script>
						swal({
							type: "success",
							title: " Cliente registrado exitosamente.",
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
