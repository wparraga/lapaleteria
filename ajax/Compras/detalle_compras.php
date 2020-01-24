<?php
    require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
?>
<div class="table-responsive">
    <table class="table">
        <?php   
            $resultado = $_POST['co_codigo']; 
            $num = $_POST['numero']; 
            $fec = $_POST['fecha'];
            $pro = $_POST['proveedor'];
            echo '<label>Compra:</label> '.$num.'</br>';
            echo '<label>Fecha:</label> '.$fec.'</br>';
            echo '<label>Proveedor:</label> '.$pro;
        ?>
        <thead>
            <tr class="well">
                <th>Cant.</th>
                <th>Producto</th>
                <th class='text-right'>Precio Compra</th>
                <th class='text-right'>Total</th>
            </tr>
        </thead>
        <?php
        	$sql="select * 
                  from detalle_compra 
                  where CO_CODIGO='$resultado'";
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
