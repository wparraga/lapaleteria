<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
	include ("../../config/swee.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_gastoinversion=intval($_GET['id']);
		if ($delete1=mysqli_query($con,"DELETE FROM gastos_inversion WHERE gas_codigo='".$id_gastoinversion."'")){
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
		 $aColumns = array('gas_fecha','gas_tipo','gas_detalle');//Columnas de busqueda
		 $sTable = "gastos_inversion";
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
		$sWhere.=" order by gas_fecha";
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
					<th>Fecha</th>
					<th>Tipo</th>
					<th>Detalle</th>
					<th>Valor</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_gasto=$row['gas_codigo'];
						$fecha=$row['gas_fecha'];
						$tipo=$row['gas_tipo'];
						$detalle=$row['gas_detalle'];
						$valor=$row['gas_valor'];
					?>
					
					<input type="hidden" value="<?php echo $fecha;?>" id="fecha<?php echo $id_gasto;?>">
					<input type="hidden" value="<?php echo $tipo;?>" id="tipo<?php echo $id_gasto;?>">
					<input type="hidden" value="<?php echo $detalle;?>" id="detalle<?php echo $id_gasto;?>">
					<input type="hidden" value="<?php echo $valor;?>" id="valor<?php echo $id_gasto;?>">
					<tr>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $tipo; ?></td>
						<td><?php echo $detalle;?></td>
						<td>$<?php echo $valor;?></td>
					<td ><span class="pull-right">

					<a href="#" class='btn btn-default' title='Editar Gasto-Inversión' onclick="obtener_datos('<?php echo $id_gasto;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Eliminar Gasto-Inversión' onclick="eliminar('<?php echo $id_gasto; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></td>
						
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