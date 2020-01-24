<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
	include ("../../config/swee.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('CLI_CEDULA','CLI_NOMBRES');//Columnas de busqueda
		 $sTable = "vis_clientesdeudas";
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
		include '../pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5;
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = '../../clientes.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="danger">
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
			<input type="hidden" value="<?php echo $saldo_cliente;?>" id="saldo_cliente<?php echo $id_cliente;?>">
					<tr>
						<td><?php echo $cedula_cliente; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $direccion_cliente;?></td>
						<td><?php echo $telefono_cliente;?></td>
						<td><?php echo '$ '.$saldo_cliente;?></td>
					<td ><span class="pull-right">

					<a href="#" class='btn btn-default' title='Ver artículos dados a crédito' onclick="procesoVerarticulosdadosacredito('<?php echo $id_cliente;?>');return false;" data-toggle="modal" data-target="#mymodalabonos"><i class="glyphicon glyphicon-eye-open"></i></a>


					<a href="#" class='btn btn-default' title='Consultar Abonos' onclick="procesoVerabonostotales('<?php echo $id_cliente;?>','<?php echo $nombre_cliente;?>');return false;" data-toggle="modal" data-target="#mymodalabonostotales"><i class="glyphicon glyphicon-usd"></i></a>
					
					<a href="#" class='btn btn-default' title='Abonar/Pagar' onclick="obtener_datos('<?php echo $id_cliente;?>');procesoVerAbonos('<?php echo $id_cliente;?>');return false;" data-toggle="modal" data-target="#myModalabonarpagar"><i class="glyphicon glyphicon-ok-sign"></i></a> 
</span></td>
						
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