<?php
    require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
    $resultado = $_POST['idItem']; 
?>
<select class="form-control" id="tipo" name="tipo">
    <option value="">--Seleccione tipo transacción--</option>
    <?php
        $sql="select PRE_CODIGO,PRE_COSTO,PRE_CANT,PRE_PVP from precios where IT_CODIGO='$resultado'";
        $result = mysqli_query($con,$sql);
        while($d=mysqli_fetch_row($result)){
            echo '<option value="'.$d[0].'">Ingresar sobre costo: $'.$d[1].' - Existen: '.$d[2].' - PVP: $'.$d[3].'</option>';
        }

    ?>
    <option value="0">Ingresar con nuevo Precio</option>
</select>
