
<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('IT_ARTICULO');//Columnas de busqueda
		 $sTable = "vis_itemsexistencia";
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
		$sWhere.=" order by IT_ARTICULO asc";
		include '../pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5;
		$adjacents  = 4;
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './productos.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th>Items</th>
					<th class='text-right'>#Comprados</th>
					<th class='text-right'>#Vendidos</th>
					<th class='text-right'>#Existen</th>
					<th>Obs.</th>
				</tr>
				<?php
					while ($row=mysqli_fetch_array($query)){
						$it_articulo=$row['IT_ARTICULO'];
						$comprados=$row['Comprados'];
						$vendidos=$row['vendidos'];
						$existen=$row['existen'];
						$obs=$row['PRE_OBSERVACION'];
				?>
					<tr>
						<td><?php echo $it_articulo; ?></td>
						<td class='text-right'><?php echo $comprados; ?></td>
						<td class='text-right'><?php echo $vendidos; ?></td>
						<td class='text-right'><?php echo $existen; ?></td>

						<td><?php echo $obs;?></td>
					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>