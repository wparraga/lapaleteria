<?php
    require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
?>
<div class="table-responsive">
    <table class="table">
        <?php   
            $resultado = $_POST['tabla'];
        ?>
        <thead>
            <tr class="well">
                <th>Clientes</th>
                <th>Deudas</th>
            </tr>
        </thead>
        <?php
        	$sql="select CLI_NOMBRES,CLI_SALDO from cliente where CLI_SALDO>0 order by CLI_NOMBRES asc";
        	$query = mysqli_query($con,$sql); 
            while ($fila = mysqli_fetch_row($query)) {
        ?>
        <tbody>
            <tr>
                <td><?php echo $fila[0]; ?></td>
                <td>$ <?php echo $fila[1]; ?></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
    <?php 
        $query1 = mysqli_query($con, "select count(*) from cliente where CLI_SALDO>0");
        while ($row=mysqli_fetch_array($query1)){
            $count=$row[0];}
        $query2 = mysqli_query($con, "select sum(CLI_SALDO) from cliente where CLI_SALDO>0");
        while ($row=mysqli_fetch_array($query2)){
            $sum=$row[0];}
              ?>
    <div class="form-group pull-right">
        <label for="tel1" class="col-md-2 control-label">Deudores:</label>
        <div class="col-md-2">
            <input type="text" class="form-control input-sm" value="<?php echo $count;?>">
        </div>
        <label for="tel1" class="col-md-1 control-label">Total:</label>
        <div class="col-md-3">
            <input type="text" class="form-control input-sm" value="<?php echo '$ '.$sum;?>">
        </div>
    </div>
</div>
