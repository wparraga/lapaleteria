<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	include("../../config/db.php");
	include("../../config/conexion.php");
	$session_id= session_id();
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No existen articulos asignados para la Venta')</script>";
	echo "<script>window.close();</script>";
	exit;
	}

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_cliente=intval($_GET['id_cliente']);
	$id_vendedor=intval($_GET['id_vendedor']);
	$fecha=$_GET['fecha'];
	$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	$subto=floatval($_GET['subtotal']);
	$ivaa=floatval($_GET['iva']);
	$tot=floatval($_GET['total']);
	$abono=floatval($_GET['abono']);
	$saldo=floatval($_GET['saldo']);

	//Fin de variables por GET
	$sql=mysqli_query($con, "select LAST_INSERT_ID(VI_NUMERO) as last from venta_item order by VI_CODIGO desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	$numero_factura=$rw['last']+1;	

//agregado desde aqui para probar
	$insert=mysqli_query($con,"INSERT INTO venta_item VALUES ('','$id_cliente','$numero_factura','$fecha','$subto','$ivaa','$tot','$condiciones','$abono','$saldo','$id_vendedor')");
	$query=mysqli_query($con,"select distinct last_insert_id() from venta_item");
	while($r=mysqli_fetch_row($query)){
		$codvi=$r[0];
	}

	$sql=mysqli_query($con, "select * from vis_itemsconprecios, tmp where vis_itemsconprecios.PRE_CODIGO=tmp.id_producto and tmp.session_id='".$session_id."'");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$pre_codigo=$row["PRE_CODIGO"];
	$it_codigo=$row['IT_CODIGO'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['IT_ARTICULO'];
	
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	//$sumador_total+=$precio_total_r;//Sumador
	?>

	<?php 

	//Insert en la tabla detalle
	$insert_detail=mysqli_query($con, "INSERT INTO detalle_venta VALUES ('','$pre_codigo','$codvi','$nombre_producto','$precio_venta_r','$cantidad','$precio_total_f')");
	$updatestockprecios=mysqli_query($con, "update precios set PRE_CANT=PRE_CANT-'$cantidad' where PRE_CODIGO='$pre_codigo'");
	
	$nums++;
	}
	$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");