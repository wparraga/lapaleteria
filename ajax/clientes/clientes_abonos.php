<?php
    require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
?>
<div class="table-responsive">
    <table class="table table-bordered">
        <?php   
            $resultado = $_POST['id_cliente']; 
        ?>
        <thead>
            <tr class="well">
                <th>Venta</th>
                <th class='text-right'>Total</th>
                <th class='text-right'>Abonos</th>
                <th class='text-right'>Saldo</th>
            </tr>
        </thead>
        <?php
        	$sql="CALL PRO_SALDOS('$resultado')";
        	$query = mysqli_query($con,$sql) or die(mysqli_error($con)); 
            while ($fila = mysqli_fetch_row($query)){
        ?>
        <tbody>
            <tr>
                <td><?php echo $fila[3]; ?></td>
                <td class='text-right'>$ <?php echo $fila[0]; ?></td>
                <td class='text-right'>$ <?php echo $fila[1]; ?></td>
                <td class='text-right'>$ <?php echo $fila[2]; ?></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
</div>
