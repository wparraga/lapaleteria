<?php
	include('../is_logged.php');
	$vi_codigo= $_SESSION['vi_codigo'];
	$numero_venta= $_SESSION['numero_venta'];

	if (isset($_POST['id'])){$id=intval($_POST['id']);}
	if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
	if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}
	if (isset($_POST['nombre_producto'])){$nombre_producto=$_POST['nombre_producto'];}
	if (isset($_POST['valor'])){$valor=floatval($_POST['valor']);}

	
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");



	if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and !empty($nombre_producto) and !empty($valor))
		{
			$insert_tmp=mysqli_query($con, "INSERT INTO detalle_venta (PRE_CODIGO,VI_CODIGO,DV_DETALLE,DV_PRECIO,DV_CANT,DV_TOTAL)VALUES('$id','$vi_codigo','$nombre_producto','$precio_venta','$cantidad','$valor')");
			$updatepro=mysqli_query($con, "UPDATE precios SET PRE_CANT=PRE_CANT-'".$cantidad."' WHERE PRE_CODIGO='".$id."'");
		}
	
	if (isset($_GET['iddet']) and isset($_GET['idpro']) and isset($_GET['cant']))//codigo elimina un elemento del array
	{
		$id_detalle=intval($_GET['iddet']);
		$id_pro=intval($_GET['idpro']);
		$cant=intval($_GET['cant']);
		$actualizar=mysqli_query($con, "UPDATE precios SET PRE_CANT=PRE_CANT+'".$cant."' WHERE PRE_CODIGO='".$id_pro."'");
		$delete=mysqli_query($con, "DELETE FROM detalle_venta WHERE DV_CODIGO='".$id_detalle."'");
	}

?>
<table class="table">
<tr>
	<th class='text-center'>CANT.</th>
	<th>PRODUCTO</th>
	<th class='text-right'>PRECIO VENTA</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from venta_item,detalle_venta,precios where venta_item.VI_CODIGO=detalle_venta.VI_CODIGO and precios.PRE_CODIGO=detalle_venta.PRE_CODIGO and venta_item.VI_CODIGO='$vi_codigo'");
	while ($row=mysqli_fetch_array($sql))
	{
	$dv_codigo=$row["DV_CODIGO"];
	$codigo_producto=$row['PRE_CODIGO'];
	$cantidad=$row['DV_CANT'];
	$nombre_producto=$row['DV_DETALLE'];
	$precio_venta=$row['DV_PRECIO'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
?>
<tr>
	<td class='text-center'><?php echo $cantidad;?></td>
	<td><?php echo $nombre_producto;?></td>
	<td class='text-right'><?php echo $precio_venta_f;?></td>
	<td class='text-right'><?php echo $precio_total_f;?></td>
	<td class='text-center'><a href="#" onclick="eliminardeldetalle('<?php echo $dv_codigo;?>','<?php echo $codigo_producto;?>','<?php echo $cantidad;?>');return false;"><i class="glyphicon glyphicon-trash"></i></a></td>
</tr>		
<?php
}
	$total_factura=number_format($sumador_total,2,'.','');
	$update=mysqli_query($con,"update venta_item set VI_SUBTOTAL='$total_factura',VI_TOTAL='$total_factura',VI_ABONO='$total_factura' where VI_CODIGO='$vi_codigo'");
?>
<tr>
	<td class='text-right' colspan=4>TOTAL $</td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	<td></td>
</tr>

</table>
