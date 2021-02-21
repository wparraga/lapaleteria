<?php

include("../../config/db.php");
include("../../config/conexion.php");

$session_id = session_id();
$sql_count = mysqli_query($con, "SELECT * FROM tmp WHERE session_id='" . $session_id . "'");
$count = mysqli_num_rows($sql_count);
if ($count == 0) {
    echo "<script>alert('No hay Productos agregados')</script>";
    echo "<script>window.close();</script>";
    exit;
}

$id_cliente=intval($_POST['id_cliente']);
$id_vendedor=intval($_POST['id_vendedor']);
$fecha=$_POST['fecha'];
$condiciones=mysqli_real_escape_string($con,(strip_tags($_POST['condiciones'], ENT_QUOTES)));

$sql=mysqli_query($con, "SELECT LAST_INSERT_ID(VI_NUMERO) as last FROM venta_item ORDER BY VI_CODIGO DESC limit 0,1 ");
    $rw=mysqli_fetch_array($sql);
    $numero_factura=$rw['last']+1;  

$nums = 1;
$sumador_total = 0;
$sql2 = mysqli_query($con, "select * from vis_itemsconprecios, tmp where vis_itemsconprecios.PRE_CODIGO=tmp.id_producto and tmp.session_id='".$session_id."'");
while ($row = mysqli_fetch_array($sql2)) {
    $cantidad=$row['cantidad_tmp'];
    $precio_venta=$row['precio_tmp'];
    $precio_venta_f=number_format($precio_venta,2);
    $precio_venta_r=str_replace(",","",$precio_venta_f);
    $precio_total=$precio_venta_r*$cantidad;
    $precio_total_f=number_format($precio_total,2);
    $precio_total_r=str_replace(",","",$precio_total_f);/
    $sumador_total+=$precio_total_r;
    $nums++;
}
$total_venta = number_format($sumador_total, 2, '.', '');
$date=date("Y-m-d H:i:s");


$insert=mysqli_query($con,"INSERT INTO venta_item (CLI_CODIGO,VI_NUMERO,VI_FECHA,VI_SUBTOTAL,VI_TOTAL,ID_VENDEDOR) VALUES ($id_cliente','$numero_factura','$fecha','$total_venta','$total','$id_vendedor')");
$query=mysqli_query($con,"select distinct last_insert_id() from venta_item");
while($r=mysqli_fetch_row($query)){
    $codvi=$r[0];

$numero = 1;
$sumador = 0;
$sql3=mysqli_query($con, "select * from vis_itemsconprecios, tmp where vis_itemsconprecios.PRE_CODIGO=tmp.id_producto and tmp.session_id='".$session_id."'");
while ($row = mysqli_fetch_array($sql3)) {
    $id_tmp=$row["id_tmp"];
    $pre_codigo=$row["PRE_CODIGO"];
    $it_codigo=$row['IT_CODIGO'];
    $cantidad=$row['cantidad_tmp'];
    $nombre_producto=$row['IT_ARTICULO'];
    $precio_venta=$row['precio_tmp'];
    $precio_venta_f=number_format($precio_venta,2);
    $precio_venta_r=str_replace(",","",$precio_venta_f);
    $precio_total=$precio_venta_r*$cantidad;
    $precio_total_f=number_format($precio_total,2);
    $precio_total_r=str_replace(",","",$precio_total_f);/
    //$sumador_total+=$precio_total_r;
    $insert_detail=mysqli_query($con, "INSERT INTO detalle_venta VALUES ('','$pre_codigo','$codvi','$nombre_producto','$precio_venta_r','$cantidad','$precio_total_f')");
    $updatestockprecios=mysqli_query($con, "update precios set PRE_CANT=PRE_CANT-'$cantidad' where PRE_CODIGO='$pre_codigo'");

    $numero++;
}
$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
?>