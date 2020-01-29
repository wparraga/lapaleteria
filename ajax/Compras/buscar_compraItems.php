<?php

	include('../is_logged.php');
	require_once ("../../config/db.php");
	require_once ("../../config/conexion.php");
	include ("../../config/swee.php");
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_compra=intval($_GET['id']);

		$sql1=mysqli_query($con,"select * from detalle_compra where CO_CODIGO='".$id_compra."'");
		while ($row=mysqli_fetch_array($sql1)){
			$id_items=$row['PRE_CODIGO'];
			$ca_items=$row['DC_CANT']; 
			$update=mysqli_query($con,"update precios set PRE_CANT=PRE_CANT-'".$ca_items."' where PRE_CODIGO='".$id_items."'");
		}
		$del1="delete from detalle_compra where CO_CODIGO='".$id_compra."'";
		$del2="delete from compras where CO_CODIGO='".$id_compra."'";
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
		$sTable = "compras, proveedores, users";
		$sWhere = "";
		$sWhere.=" WHERE compras.PRO_CODIGO=proveedores.PRO_CODIGO and compras.ID_VENDEDOR=users.user_id";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (proveedores.PRO_NOMBRES like '%$q%' or compras.CO_NUMERO like '%$q%' or compras.CO_FECHA like '%$q%')";	
		}
		$sWhere.=" order by compras.CO_CODIGO desc";
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
					<th>Proveedor</th>
					<th>Registrador</th>
					<th class='text-right'>Total</th>
					<th class='text-right'>Estado</th>
					<th class='text-right'>Acciones</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$c_codigo=$row['CO_CODIGO'];
						$c_numero=$row['CO_NUMERO'];
						$fechacompra=date("Y-m-d H:i:s", strtotime($row['CO_FECHA']));
						$pro_nombres=$row['PRO_NOMBRES'];
						$pro_telefono=$row['PRO_CELULAR'];
						$pro_direccion=$row['PRO_DIRECCION'];
						$nombre_vendedor=$row['firstname']." ".$row['lastname'];
						$c_estado=$row['CO_ESTADO'];
						if ($c_estado==1){$text_estado="Pendiente";$label_class='label-warning';}
						else{$text_estado="Pagada";$label_class='label-success';}
						$c_totalpagar=$row['CO_TOTAL'];
					?>
					<tr>
						<td><?php echo $c_numero; ?></td>
						<td><?php echo $fechacompra; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $pro_telefono;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $pro_direccion;?>" ><?php echo $pro_nombres;?></a></td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td class='text-right'>$<?php echo number_format ($c_totalpagar,2); ?></td>	
						<td class='text-right'><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class="text-right">
						<a href="#" class='btn btn-default' title='Ver Productos Comprados' onclick="procesoVerDetalleCompra('<?php echo $c_codigo;?>','<?php echo $c_numero;?>','<?php echo $fechacompra;?>','<?php echo $pro_nombres;?>','<?php echo $c_totalpagar;?>');return false;" data-toggle="modal" data-target="#myModalDetalleCompra"><i class="glyphicon glyphicon-usd"></i></a>
						<a href="editar_compras.php?c_codigo=<?php echo $c_codigo;?>" class='btn btn-default' title='Editar Compra' ><i class="glyphicon glyphicon-edit"></i></a>
						<a href="#" class='btn btn-default' title='Reimprimir Recibo' onclick="ver_compraItem('<?php echo $c_codigo;?>');"><i class="glyphicon glyphicon-download"></i></a>
						<a href="#" class='btn btn-default' title='Eliminar Compra' onclick="eliminarcompraitems('<?php echo $c_codigo; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> 
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