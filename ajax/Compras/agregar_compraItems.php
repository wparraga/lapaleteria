<?php

include('../is_logged.php');
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['pcompra'])){$pcompra=$_POST['pcompra'];}
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
if (!empty($id) and !empty($cantidad) and !empty($pcompra))
{
	$query=mysqli_query($con, "select * from tmp where id_producto='".$id."'");
	$count=mysqli_num_rows($query);
	while ($row=mysqli_fetch_array($query))
	{$cant=$row['cantidad_tmp'];}
	if ($cantidad>$cant){
		if($count>=1){
			$update_tmp=mysqli_query($con,"update tmp set cantidad_tmp=cantidad_tmp+'$cantidad' where id_producto='$id'");
		}else{
		   $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id) VALUES ('$id','$cantidad','$pcompra','$session_id')");	
		}
	}
}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
	$id_tmp=intval($_GET['id']);	
	$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_tmp."'");
}

?>
<table class="table">
<tr>
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th>PRODUCTO</th>
	<th class='text-right'>PRECIO COMPRA.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from precios,items, tmp where precios.IT_CODIGO=items.IT_CODIGO and precios.PRE_CODIGO=tmp.id_producto and tmp.session_id='".$session_id."'");
	while ($row=mysqli_fetch_array($sql))
	{
		$id_tmp=$row["id_tmp"];
		$codigo_producto=$row['IT_CODIGOBARRA'];
		$cantidad=$row['cantidad_tmp'];
		$nombre_producto=$row['IT_ARTICULO'];
		
		$precio_compra=$row['precio_tmp'];
		$precio_compra_f=number_format($precio_compra,2);//Formateo variables
		$precio_compra_r=str_replace(",","",$precio_compra_f);//Reemplazo las comas
		$precio_total=$precio_compra_r*$cantidad;
		$precio_total_f=number_format($precio_total,2);//Precio total formateado
		$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
		$sumador_total+=$precio_total_r;//Sumador
	
		?>
<script>
	function calculariva(subto,viva){
		iiva=(subto*viva)/100;
		iiva=iiva.toFixed(2);
		to=parseFloat(subto)+parseFloat(iiva);
		to=to.toFixed(2);
        document.getElementById('iva').value = iiva; 
        document.getElementById('total').value = to;               
	}

	function nocalculariva(subto){
		iiva=0;
		to=subto;
		document.getElementById('iva').value = iiva; 
        document.getElementById('total').value = to; 
            
	}
</script>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td><?php echo $nombre_producto;?></td>
			<td class='text-right'><?php echo $precio_compra_f;?></td>
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php

	}
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
?>
<tr>
	<td class='text-right' colspan=4>SUBTOTAL $</td>
	<td class='text-right'><input type="text" id="subtotal" name="subtotal" size="6" style="text-align:right" value="<?php echo number_format($subtotal,2);?>" maxlength="0"></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4>IVA (<?php echo IVA?>)% $
		<label class="radio-inline">
			<input type="radio" name="wasa" id="Radios1" value="Si" onclick="calculariva('<?php echo $subtotal;?>','<?php echo IVA?>');">Si
		</label>
		<label class="radio-inline">
			<input type="radio" name="wasa" id="Radios2" value="No" onclick="nocalculariva('<?php echo $subtotal;?>');">No
		</label>
	</td>
	<td class='text-right'><input type="text" id="iva" name="iva" size="6" value="0" style="text-align:right" maxlength="0"></td>

</tr>
<tr>
	<td class='text-right' colspan=4>TOTAL $</td>
	<td class='text-right'><input type="text" id="total" name="total" size="6" style="text-align:right" value="<?php echo number_format($total_factura,2);?>" maxlength="0"></td>
	<td></td>
</tr>
</table>
