<?php
	include('../is_logged.php');
	$c_codigo= $_SESSION['c_codigo'];
	$numero_compra= $_SESSION['numero_compra'];

	if (isset($_POST['id'])){$id=intval($_POST['id']);}
	if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
	if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}

	
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
	

	if (!empty($c_codigo) and !empty($cantidad) and !empty($precio_venta))
		{
			$insert_tmp=mysqli_query($con, "INSERT INTO detalle_factura (numero_factura, id_producto,cantidad,precio_venta) VALUES ('$numero_factura','$id','$cantidad','$precio_venta')");
		}
	
	if (isset($_GET['iddet']) and isset($_GET['idpro']) and isset($_GET['cant']))//codigo elimina un elemento del array
	{
		$id_detalle=intval($_GET['iddet']);
		$id_pro=intval($_GET['idpro']);
		$cant=intval($_GET['cant']);
		$actualizar=mysqli_query($con, "UPDATE precios SET PRE_CANT=PRE_CANT-'".$cant."' WHERE PRE_CODIGO='".$id_pro."'");
		$delete=mysqli_query($con, "DELETE FROM detalle_compra WHERE DC_CODIGO='".$id_detalle."'");
	}

?>
<table class="table">
<tr>
	<th class='text-center'>CANT.</th>
	<th>PRODUCTO</th>
	<th class='text-right'>PRECIO COMPRA.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from compras, detalle_compra,precios where compras.CO_CODIGO=detalle_compra.CO_CODIGO and precios.PRE_CODIGO=detalle_compra.PRE_CODIGO and compras.CO_CODIGO='$c_codigo'");
	while ($row=mysqli_fetch_array($sql))
	{
	$dc_codigo=$row["DC_CODIGO"];
	$codigo_producto=$row['PRE_CODIGO'];
	$cantidad=$row['DC_CANT'];
	$nombre_producto=$row['DC_DETALLE'];
	
	
	$precio_compra=$row['DC_PRECIO'];
	$precio_compra_f=number_format($precio_compra,2);//Formateo variables
	$precio_compra_r=str_replace(",","",$precio_compra_f);//Reemplazo las comas
	$precio_total=$precio_compra_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
		?>
		<tr>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td><?php echo $nombre_producto;?></td>
			<td class='text-right'><?php echo $precio_compra_f;?></td>
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminardeldetalle('<?php echo $dc_codigo;?>','<?php echo $codigo_producto;?>','<?php echo $cantidad;?>');return false;"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$total_factura=number_format($sumador_total,2,'.','');
	$update=mysqli_query($con,"update compras set CO_TOTAL='$total_factura' where CO_CODIGO='$c_codigo'");
?>
<tr>
	<td class='text-right' colspan=4>TOTAL $</td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	<td></td>
</tr>

</table>
