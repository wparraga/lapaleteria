<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
	include ("../../config/swee.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from venta_item where CLI_CODIGO='".$id_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM cliente WHERE CLI_CODIGO='".$id_cliente."'")){
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
			
		} else {
			echo'<script>
						swal({
							type: "error",
							title: " No se pudo eliminar éste cliente. Existen Ventas vinculadas.",
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
		 $aColumns = array('CLI_CEDULA','CLI_NOMBRES');//Columnas de busqueda
		 $sTable = "cliente";
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
		$sWhere.=" order by CLI_NOMBRES";
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
		$reload = '../../clientes.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th>Cédula</th>
					<th>Nombres</th>
					<th>Dirección</th>
					<th>Teléfono</th>
					<th>Saldo</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_cliente=$row['CLI_CODIGO'];
						$cedula_cliente=$row['CLI_CEDULA'];
						$nombre_cliente=$row['CLI_NOMBRES'];
						$direccion_cliente=$row['CLI_DIRECCION'];
						$telefono_cliente=$row['CLI_TELEFONO'];
						$saldo_cliente=$row['CLI_SALDO'];
					?>
					
					<input type="hidden" value="<?php echo $cedula_cliente;?>" id="cedula_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $direccion_cliente;?>" id="direccion_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $telefono_cliente;?>" id="telefono_cliente<?php echo $id_cliente;?>">
					<tr>
						<td><?php echo $cedula_cliente; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $direccion_cliente;?></td>
						<td><?php echo $telefono_cliente;?></td>
						<td><?php echo '$ '.$saldo_cliente;?></td>
					<td ><span class="pull-right">

					<a href="#" class='btn btn-default' title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Eliminar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></td>
						
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