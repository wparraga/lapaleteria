<?php
    require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
?>
<div class="table-responsive">
    <table class="table">
        <?php   
            $resultado = $_POST['vi_codigo']; 
            $num = $_POST['numero']; 
            $fec = $_POST['fecha'];
            $cli = $_POST['cliente'];
            $total = $_POST['total'];
            echo '<label>Venta #:</label> '.$num.'</br>';
            echo '<label>Fecha:</label> '.$fec.'</br>';
            echo '<label>Cliente:</label> '.$cli.'</br>';
            echo '<label>Total: $</label>'.$total;
        ?>
        <thead>
            <tr class="well">
                <th>Cant.</th>
                <th>Descripción</th>
                <th class='text-right'>PVP</th>
                <th class='text-right'>Total</th>
            </tr>
        </thead>
        <?php
        	$sql="select * 
                  from detalle_venta 
                  where VI_CODIGO='$resultado'";
        	$query = mysqli_query($con,$sql); 
            while ($fila = mysqli_fetch_row($query)) {
        ?>
        <tbody>
            <tr>
                <td><?php echo $fila[5]; ?></td>
                <td><?php echo $fila[3]; ?></td>
                <td class='text-right'>$<?php echo $fila[4]; ?></td>
                <td class='text-right'>$<?php echo $fila[6]; ?></td>
            </tr>
        </tbody>

        <?php } ?>
    </table>
</div>
