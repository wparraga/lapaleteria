
<?php
	require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$id_items = $_POST['id_items'];
	
	$query = "SELECT PRE_COSTOMASIVA FROM vis_itemsconprecios WHERE PRE_CODIGO='$id_items'";
	$resultado=mysqli_query($con,$query);
	while($row = $resultado->fetch_assoc())
	{
		$html.= $row['PRE_COSTOMASIVA'];
	}
	
?>
<input type="hidden" name="preciocompra" id="preciocompra" value="<?php echo $html; ?>">