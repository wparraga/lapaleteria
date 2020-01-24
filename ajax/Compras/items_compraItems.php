<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('IT_CODIGOBARRA', 'IT_ARTICULO');//Columnas de busqueda
		 $sTable = "vis_itemsconprecios";
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
		include '../pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5;
		$adjacents  = 4;
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = '../../index.php';
		$sql="SELECT * FROM $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);

		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th>COD.</th>
					<th>Artículo</th>
					<th>Existen</th>
					<th>P.Compra</th>
					<th>Cant.</th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_producto=$row['PRE_CODIGO'];
					$codigo_producto=$row['IT_CODIGOBARRA'];
					$nombre_producto=$row['IT_ARTICULO'];
					$existencia=$row['PRE_CANT'];
					$pcmasiva=$row["PRE_COSTOMASIVA"];
				?>
					<tr>
						<td><?php echo $codigo_producto; ?></td>
						<td><?php echo $nombre_producto; ?></td>
						<td><?php echo $existencia; ?></td>
						<td>$<?php echo $pcmasiva; ?></td>
						<td class='col-xs-1'>
							<div class="pull-right">
								<input type="hidden" id="pcompra_<?php echo $id_producto; ?>" value="<?php echo $pcmasiva;?>">

								<input type="text" class="form-control" style="text-align:right" id="cantidad_<?php echo $id_producto; ?>" value="1" maxlength="3" onkeypress="return soloNumeros(event,this);">
							</div>
					    </td>
						<td class='text-center'><a class='btn btn-success'href="#" onclick="agregarcompra('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a>
						</td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>