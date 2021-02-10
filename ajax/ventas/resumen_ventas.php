
<?php
	include('../is_logged.php');
	require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){
     $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
     $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));

		$sTable = "vis_resumenventas";
		$sWhere = "";
		if ( $_GET['q1'] != "" && $_GET['q2'] != "" )
		{
			$sWhere = "WHERE date(Fecha) between '$q1' and '$q2'";
		}
		$sWhere.=" order by Fecha asc";
		include '../pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 500;
		$adjacents  = 4;
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './resumen_ventas.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);

		//para gastos-inversion
	 $t1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['t1'], ENT_QUOTES)));
     $t2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['t2'], ENT_QUOTES)));
		$sTable1 = "gastos_inversion";
		$sWhere1 = "";
		if ( $_GET['t1'] != "" && $_GET['t2'] != "" )
		{
			$sWhere1 = "WHERE date(gas_fecha) between '$t1' and '$t2'";
		}
		$sWhere1.=" order by gas_fecha asc";
		$page1 = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page1 = 500;
		$adjacents1  = 4;
		$offset1 = ($page1 - 1) * $per_page1;
		$count_query1   = mysqli_query($con, "SELECT count(*) AS numrows1 FROM $sTable1  $sWhere1");
		$row1= mysqli_fetch_array($count_query1);
		$numrows1 = $row1['numrows1'];
		$total_pages1 = ceil($numrows1/$per_page1);
		$reload1 = './resumen_ventas.php';
		$sql1="SELECT * FROM  $sTable1 $sWhere1 LIMIT $offset1,$per_page1";
		$query1 = mysqli_query($con, $sql1);

		if ($numrows>0 || $numrows1>0){
			?>
			<div class="table-responsive">
			<label>Ventas</label>
			  <table class="table">
				<tr  class="success">
					<th>Fecha</th>
					<th>Articulo</th>
					<th>Vendido</th>
					<th>Costo+IVA</th>
					<th>PVP</th>
					<th>Total</th>
					<th>Ganancia</th>
				</tr>
				<?php
					while ($row=mysqli_fetch_array($query)){
						$vi_fecha=$row['Fecha'];
						$it_articulo=$row['Articulo'];
						$vendido=$row['Vendido'];
						$costomasiva=$row['CostoMasIVA'];
						$pvp=$row['pvp'];
						$total=$row['Total'];
						$ganancia=$row['Ganancia'];
				?>
					<tr>
						<td><?php echo $vi_fecha; ?></td>
						<td><?php echo $it_articulo; ?></td>
						<td><?php echo $vendido; ?></td>
						<td class='text-right'>$ <?php echo $costomasiva; ?></td>
						<td class='text-right'>$ <?php echo $pvp; ?></td>
						<td class='text-right'>$ <?php echo $total;?></td>
						<td class='text-right'>$ <?php echo $ganancia;?></td>
				<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right"><?echo paginate($reload, $page, $total_pages, $adjacents);?></span></td>
				</tr>
			  </table>
			  <label>Gastos-Inversión</label>
				<table class="table">
				<tr  class="success">
					<th>Fecha</th>
					<th>Tipo</th>
					<th>Detalle</th>
					<th>Valor</th>
				</tr>
				<?php
					while ($row1=mysqli_fetch_array($query1)){
						$fecha=$row1['gas_fecha'];
						$tipo=$row1['gas_tipo'];
						$detalle=$row1['gas_detalle'];
						$valor=$row1['gas_valor'];
				?>
					<tr>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $tipo; ?></td>
						<td><?php echo $detalle; ?></td>
						<td class='text-right'>$ <?php echo $valor; ?></td>
				<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right"><?echo paginate($reload1, $page1, $total_pages1, $adjacents1);?></span></td>
				</tr>
				</table>
			  <?php
			  	$query1 = mysqli_query($con, "select sum(Vendido) from vis_resumenventas where date(Fecha) BETWEEN '$q1' AND '$q2'");
			  	while ($row=mysqli_fetch_array($query1)){
			  		$tv=$row[0];}
			  	$query2 = mysqli_query($con, "select sum(CostoMasIVA) from vis_resumenventas where date(Fecha) BETWEEN '$q1' AND '$q2'");
			  	while ($row=mysqli_fetch_array($query2)){
			  		$ti=$row[0];}
			  	$query3 = mysqli_query($con, "select sum(Total) from vis_resumenventas where date(Fecha) BETWEEN '$q1' AND '$q2'");
			  	while ($row=mysqli_fetch_array($query3)){
			  		$tve=$row[0];}
			  	$query4 = mysqli_query($con, "select sum(Ganancia) from vis_resumenventas where date(Fecha) BETWEEN '$q1' AND '$q2'");
			  	while ($row=mysqli_fetch_array($query4)){
			  		$tg=$row[0];}
			  	$query5 = mysqli_query($con, "select sum(gas_valor) from gastos_inversion where date(gas_fecha) BETWEEN '$t1' AND '$t2'");
			  	while ($row=mysqli_fetch_array($query5)){
			  		$tgi=$row[0];}
			  ?>
				<div class="col-sm-2">
				  <label># Vendidos: </label><input type="text" class="form-control" value="<?php echo $tv;?>" name="tv" maxlength="0" >
				</div>
				<div class="col-sm-2">
				  <label>Venta Total: </label><input type="text" class="form-control" value="<?php echo '$ '.$tve;?>" name="tve"maxlength="0" >
				</div>
				<div class="col-sm-2">
				  <label>Invertido: </label><input type="text" class="form-control" value="<?php echo '$ '.$ti;?>"  name="ti"maxlength="0" >
				</div>
				<div class="col-sm-2">
				  <label>Ganancia: </label><input type="text" class="form-control" value="<?php echo '$ '.$tg;?>" name="tg" maxlength="0" >
				</div>
				<div class="col-sm-2">
				  <label>Total Gastos Inversión: </label><input type="text" class="form-control" value="<?php echo '$ '.$tgi;?>" name="tgi" maxlength="0" >
				</div>
			</div>
			<?php
		}
	}
?>
