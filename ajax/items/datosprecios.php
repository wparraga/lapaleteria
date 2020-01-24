<?php
if (isset($_GET['term'])){
	$p=$_GET['term'];
include("../../../config/db.php");
include("../../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM precios where PRE_CODIGO='$p'"); 
	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_precio=$row['PRE_CODIGO'];
		$row_array['value'] = $row['CLI_NOMBRES'];
		$row_array['id_precio']=$id_precio;
		$row_array['aju_costo']=$row['PRE_COSTO'];
		$row_array['aju_costomasiva']=$row['PRE_COSTOMASIVA'];
		$row_array['aju_pvp']=$row['PRE_PVP'];
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>