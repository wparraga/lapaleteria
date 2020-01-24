<?php
    require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
?>
<div class="table-responsive">
    <table class="table">
        <?php   
            $resultado = $_POST['id_cliente']; 
            $nom = $_POST['nom_cliente']; 
            echo $nom;
        ?>
        <thead>
            <tr class="well">
                <th>Fecha</th>
                <th>Ref.</th>
                <th class='text-right'>Total</th>
                <th class='text-right'>Abono</th>
                <th class='text-right'>Saldo_Actual</th>
            </tr>
        </thead>
        <?php
        	$sql="select * from vis_pagosclientes where CLI_CODIGO='$resultado'";
        	$query = mysqli_query($con,$sql); 
            while ($fila = mysqli_fetch_row($query)) {
        ?>
        <tbody>
            <tr>
                <td><?php echo $fila[0]; ?></td>
                <td><?php echo $fila[1]; ?></td>
                <td class='text-right'>$ <?php echo $fila[2]; ?></td>
                <td class='text-right'>$ <?php echo $fila[3]; ?></td>
                <td class='text-right'>$ <?php echo $fila[4]; ?></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
</div>
