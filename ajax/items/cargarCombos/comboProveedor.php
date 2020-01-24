<?php
    require_once ("../../../config/db.php");
	require_once ("../../../config/conexion.php");
    $tabla = $_POST['proveedores']; 
?>
<select style="width:320px" class="form-control" id="proveedor" name="proveedor">
    <option value="">--Seleccione Proveedor--</option>
    <?php
        $sql="select PRO_CODIGO,PRO_NOMBRES from proveedores order by PRO_NOMBRES asc";
        $result = mysqli_query($con,$sql);
        while($d=mysqli_fetch_row($result)){
            echo '<option value="'.$d[0].'">'.$d[1].'</option>';
        }
    ?>
</select>

