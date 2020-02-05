
<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_pro=intval($_GET['id']);
		$del1="delete from precios where IT_CODIGO='".$id_pro."'";
		$del2="delete from items where IT_CODIGO='".$id_pro."'";
		//$query=mysqli_query($con, "select * from precios where IT_CODIGO='".$id_PRO."'");
		//$count=mysqli_num_rows($query);
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
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
							title: " Algo a salido mal, quizas el producto tiene una ventas vinculadas.",
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
		 $aColumns = array('IT_ARTICULO','IT_CODIGOBARRA');//Columnas de busqueda
		 $sTable = "vis_itemstotales";
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
					<th>Cod.</th>
					<th>Cod. Barra</th>
					<th>Producto</th>
					<th class='text-right'>Existencia</th>
					<th class='text-center'>Acciones</th>
				</tr>
				<?php
					while ($row=mysqli_fetch_array($query)){
						$id_producto=$row['IT_CODIGO'];
						$it_articulo=$row['IT_ARTICULO'];
						$it_codigobarra=$row['IT_CODIGOBARRA'];
						$it_stock=$row['EXISTENCIA'];
				?>
					<input type="hidden" value="<?php echo $it_articulo;?>" id="nombre<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $it_codigobarra;?>" id="codigobarra<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $it_stock;?>" id="stock<?php echo $id_producto;?>">
					<tr>
						<td><?php echo $id_producto; ?></td>
						<td><?php echo $it_codigobarra; ?></td>
						<td><?php echo $it_articulo; ?></td>
						<td class='text-right'><?php echo $it_stock;?></td>
						<td ><span class="pull-right">
						<a href="#" class='btn btn-default' title='Precios' onclick="procesoVerPrecios('<?php echo $id_producto;?>','<?php echo $it_articulo;?>');return false;" data-toggle="modal" data-target="#myModalprecios"><i class="glyphicon glyphicon-usd"></i></a>

						<a href="#" class='btn btn-default' title='Editar Datos del Producto' onclick="obtener_datos('<?php echo $id_producto;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
						
						<a href="#" class='btn btn-default' title='Ajustar Stock del Producto' onclick="obtener_ajustes('<?php echo $id_producto;?>');obtenerIdItems('<?php echo $id_producto;?>');" data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-wrench"></i></a>
						<a href="#" class='btn btn-default' title='Eliminar Producto' onclick="eliminar_producto('<?php echo $id_producto; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
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