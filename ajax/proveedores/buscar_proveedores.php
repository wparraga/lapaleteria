<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
	include ("../../config/swee.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_proveedor=intval($_GET['id']);
		if ($delete1=mysqli_query($con,"DELETE FROM proveedores WHERE PRO_CODIGO='".$id_proveedor."'")){
				echo'<script>
						swal({
							type: "success",
							title: " Datos eliminados exitosamente.",
							showConfirmButton: true,
							confirmButtonColor: "#d9534f",
							confirmButtonText: "Aceptar",
							closeOnConfirm: false
							}).then(function(result){
							if (result.value) {
								
							}
						})
					</script>';
		}else {
			echo'<script>
						swal({
							type: "error",
							title: " Algo a salido mal, intente nuevamente.",
							showConfirmButton: true,
							confirmButtonColor: "#d9534f",
							confirmButtonText: "Aceptar",
							closeOnConfirm: false
							}).then(function(result){
							if (result.value) {
							}
						})
					</script>';
			
		}		
	}

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('PRO_NOMBRES');//Columnas de busqueda
		 $sTable = "proveedores";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by PRO_NOMBRES";
		include '../pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clientes.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th>Nombres</th>
					<th>Celular</th>
					<th>Convencional</th>
					<th>Correo</th>
					<th>RUC</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_proveedor=$row['PRO_CODIGO'];
						$nombre_proveedor=$row['PRO_NOMBRES'];
						$direccion_proveedor=$row['PRO_DIRECCION'];
						$celular_proveedor=$row['PRO_CELULAR'];
						$convencional_proveedor=$row['PRO_CONVENCIONAL'];
						$correo_proveedor=$row['PRO_CORREO'];
						$ruc_proveedor=$row['PRO_RUC'];
					?>
					
					<input type="hidden" value="<?php echo $nombre_proveedor;?>" id="nombre_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $direccion_proveedor;?>" id="direccion_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $celular_proveedor;?>" id="celular_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $convencional_proveedor;?>" id="convencional_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $correo_proveedor;?>" id="correo_proveedor<?php echo $id_proveedor;?>">
					<input type="hidden" value="<?php echo $ruc_proveedor;?>" id="ruc_proveedor<?php echo $id_proveedor;?>">
					<tr>
						<td><?php echo $nombre_proveedor; ?></td>
						<td><?php echo $celular_proveedor;?></td>
						<td><?php echo $convencional_proveedor;?></td>
						<td><?php echo $correo_proveedor;?></td>
						<td><?php echo $ruc_proveedor;?></td>
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar proveedor' onclick="obtener_datos('<?php echo $id_proveedor;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Borrar proveedor' onclick="eliminar('<?php echo $id_proveedor; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>