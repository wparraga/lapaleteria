<?php
    require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
?>
<div class="table-responsive">
    <table class="table">
        <?php   
            $resultado = $_POST['id_cliente']; 
        ?>
        <thead>
            <tr class="well">
                <th>Fecha</th>
                <th>Venta</th>
                <th>Detalle</th>
                <th class='text-right'>Precio</th>
                <th class='text-right'>Cant.</th>
                <th class='text-right'>Total</th>
            </tr>
        </thead>
        <?php
        	$sql="
                select vc.VC_FECHAVENTA,vc.VC_TIPOPAGO,dv.DVC_DETALLE,dv.DVC_PRECIO,dv.DVC_CANT,dv.DVC_TOTAL
                from cliente c,venta_celular vc,detalle_ventacelular dv
                where c.CLI_CODIGO=vc.CLI_CODIGO and vc.VC_CODIGO=dv.VC_CODIGO and vc.VC_TIPOPAGO=2 and c.CLI_CODIGO='$resultado'
                union
                select vi.VI_FECHA,vi.VI_TIPOPAGO,dv.DV_DETALLE,dv.DV_PRECIO,dv.DV_CANT,dv.DV_TOTAL
                from cliente c,venta_item vi,detalle_venta dv
                where c.CLI_CODIGO=vi.CLI_CODIGO and vi.VI_CODIGO=dv.VI_CODIGO and vi.VI_TIPOPAGO=2 and c.CLI_CODIGO='$resultado' ";
        	$query = mysqli_query($con,$sql); 
            while ($fila = mysqli_fetch_row($query)) {
        ?>
        <tbody>
            <tr>
                <td><?php echo $fila[0]; ?></td>
                <td><?php echo 'CRÉDITO'; ?></td>
                <td><?php echo $fila[2]; ?></td>
                <td class='text-right'>$<?php echo $fila[3]; ?></td>
                <td class='text-right'><?php echo $fila[4]; ?></td>
                <td class='text-right'>$<?php echo $fila[5]; ?></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
</div>
