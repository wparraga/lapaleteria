<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#00ab09;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
    <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <?php echo " @paleteriaflavioalfaro - "; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 25%; color: #444444;">
                <img style="width: 110%;" src="../../img/logo.png" alt="Logo"><br>  
            </td>
			<td style="width: 50%; color: #00ab09;font-size:15px;text-align:center">
                <span style="color: #00ab09;font-size:21px;font-weight:bold"><?php echo NOMBRE_EMPRESA;?></span>
				<br><?php echo DIRECCION_EMPRESA;?><br> 
				Teléfono: <?php echo TELEFONO_EMPRESA;?><br>
				Email: <?php echo EMAIL_EMPRESA;?>
            </td>
			<td style="width: 25%;text-align:right">
			COMPRA Nº <?php echo $numero_factura;?>
			</td>
			
        </tr>
    </table>
    <br>
    <table cellspacing="0" border="0.5" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>COMPRA A</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
				$sql_proveedor=mysqli_query($con,"select * from proveedores where PRO_CODIGO='$id_proveedor'");
				$rw_proveedor=mysqli_fetch_array($sql_proveedor);
				echo $rw_proveedor['PRO_NOMBRES'];
				echo "<br>";
				echo $rw_proveedor['PRO_RUC'];
				echo "<br>";
				echo $rw_proveedor['PRO_DIRECCION'];
				echo "<br> Teléfono: ";
				echo $rw_proveedor['PRO_CELULAR'];
			?>
		   </td>
        </tr>
    </table>
	<br>
    <table cellspacing="0" border="0.5" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>PRODUCTO</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO COMPRA</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>
        </tr>

<?php
$nums=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from detalle_compra where CO_CODIGO='".$id_compra."'");

while ($row=mysqli_fetch_array($sql))
	{
	//$id_producto=$row["id_producto"];
	//$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['DC_CANT'];
	$nombre_producto=$row['DC_DETALLE'];
	
	$precio_venta=$row['DC_PRECIO'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right">$<?php echo $precio_venta_f;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right">$<?php echo $precio_total_f;?></td>
            
        </tr>

	<?php 

	
	$nums++;
	}
	$subtotal=number_format($subto,2,'.','');
	$total_iva=number_format($ivaa,2,'.','');
	$total_factura=number_format($tot,2,'.','');
?>
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL:</td>
            <td style="font-size:11pt; text-align: right;font-weight:bold">$<?php echo number_format($total_factura,2);?></td>
        </tr>
    </table>
    <br>
		<table cellspacing="0" border="0.5" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:25%;" class='midnight-blue'>REGISTRADOR</td>
		   <td style="width:25%;" class='midnight-blue'>FECHA</td>
		   <td style="width:20%;" class='midnight-blue'>ESTADO DE PAGO</td>
        </tr>
		<tr>
			<td style="width:25%;">
				<?php 
					$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
					$rw_user=mysqli_fetch_array($sql_user);
					echo $rw_user['firstname']." ".$rw_user['lastname'];
				?>
		    </td>
		    <td style="width:25%;"><?php echo $fecha_factura;?></td>
		    <td style="width:20%;" >
				<?php 
					if ($condiciones==1){echo "Pendiente";}
					elseif ($condiciones==2){echo "Pagada";}
				?>
		   	</td>
        </tr>
    </table>
	<br>
	<div style="font-size:11pt;text-align:center;font-weight:bold">Gracias por su compra!</div>
</page>

