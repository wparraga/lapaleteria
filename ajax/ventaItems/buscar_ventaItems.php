<?php

	include('../is_logged.php');
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
	include ("../../config/swee.php");
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_venta=intval($_GET['id']);

		$sql1=mysqli_query($con,"select * from detalle_venta where VI_CODIGO='".$id_venta."'");
		while ($row=mysqli_fetch_array($sql1)){
			$id_items=$row['PRE_CODIGO'];
			$ca_items=$row['DV_CANT']; 
			$update=mysqli_query($con,"update precios set PRE_CANT=PRE_CANT+'".$ca_items."' where PRE_CODIGO='".$id_items."'");
		}
		$del1="delete from detalle_venta where VI_CODIGO='".$id_venta."'";
		$del2="delete from venta_item where VI_CODIGO='".$id_venta."'";
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
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$sTable = "venta_item, cliente, users";
		$sWhere = "";
		$sWhere.=" WHERE venta_item.CLI_CODIGO=cliente.CLI_CODIGO and venta_item.ID_VENDEDOR=users.user_id";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (cliente.CLI_NOMBRES like '%$q%' or venta_item.VI_NUMERO like '%$q%' or venta_item.VI_FECHA like '%$q%')";	
		}
		$sWhere.=" order by venta_item.VI_CODIGO desc";
		include '../pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10;
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = '../../venta_items.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th>#</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<th>Tipo</th>
					<th class='text-right'>Total</th>
					<th class='text-right'>Abono</th>
					<th class='text-right'>Saldo</th>
					<th class='text-right'>Acciones</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$vi_codigo=$row['VI_CODIGO'];
						$vi_numero=$row['VI_NUMERO'];
						$fecha=date("Y-m-d H:i:s", strtotime($row['VI_FECHA']));
						$cli_nombres=$row['CLI_NOMBRES'];
						$cli_telefono=$row['CLI_TELEFONO'];
						$cli_direccion=$row['CLI_DIRECCION'];
						$nombre_vendedor=$row['firstname']." ".$row['lastname'];
						$vi_tipopago=$row['VI_TIPOPAGO'];
						if ($vi_tipopago==1){$text_estado="Contado";$label_class='label-success';}
						else{$text_estado="Crédito";$label_class='label-warning';}
						$vi_totalpagar=$row['VI_TOTAL'];
						$vi_abono=$row['VI_ABONO'];
						$vi_saldo=$row['VI_SALDO'];
					?>
					<tr>
						<td><?php echo $vi_numero; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $cli_telefono;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $cli_direccion;?>" ><?php echo $cli_nombres;?></a></td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'>$<?php echo number_format ($vi_totalpagar,2); ?></td>		
						<td class='text-right'>$<?php echo number_format ($vi_abono,2); ?></td>
						<td class='text-right'>$<?php echo number_format ($vi_saldo,2); ?></td>
						<td class="text-right">
						<a href="#" class='btn btn-default' title='Ver Paletas Vendidas' onclick="procesoVerDetalleventa('<?php echo $vi_codigo;?>','<?php echo $vi_numero;?>','<?php echo $fecha;?>','<?php echo $cli_nombres;?>');return false;" data-toggle="modal" data-target="#myModalDetalleventa"><i class="glyphicon glyphicon-usd"></i></a>
						<a href="#" class='btn btn-default' title='Reimprimir Recibo' onclick="imprimir_ventaItem('<?php echo $vi_codigo;?>');"><i class="glyphicon glyphicon-download"></i></a>
						

						<a href="#" class='btn btn-default' title='Eliminar Venta' onclick="eliminarventaitems('<?php echo $vi_codigo; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> 
						</td>
						
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