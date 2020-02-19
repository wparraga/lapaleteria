<?php
		if (isset($title))
		{
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <?php
      $position= $_SESSION['user_tipo'];
      if($position=='U') {
    ?>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="<?php echo $active_facturas;?>"><a href="venta.php"><i class='glyphicon glyphicon-usd'></i> Ventas</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
          </ul>
        </div>
    <?php
      }
    ?>
    <?php
      if($position=='A') {
    ?>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Clientes</a></li>
            <li class="<?php echo $active_proveedores;?>"><a href="proveedores.php"><i class='glyphicon glyphicon-user'></i> Proveedores</a></li>
            <li class="<?php echo $active_productos;?>"><a href="items.php"><i class='glyphicon glyphicon-barcode'></i> Productos</a></li>

            <li class="<?php echo $active_compras;?>"><a href="compra_items.php"><i class='glyphicon glyphicon-usd'></i> Compras</a></li> 
            <li class="<?php echo $resumen_compras;?>"><a href="resumen_compra.php"><i class='glyphicon glyphicon glyphicon-usd'></i> Resumen de Compras</a></li>

            <li class="<?php echo $active_facturas;?>"><a href="venta_items.php"><i class='glyphicon glyphicon-usd'></i> Ventas</a></li>           
            <li class="<?php echo $resumen_ventas;?>"><a href="resumen_ventas.php"><i class='glyphicon glyphicon glyphicon-usd'></i> Resumen de Ventas</a></li>

           


            <li class="<?php echo $gastos_inversion;?>"><a href="gastos_inversion.php"><i class='glyphicon glyphicon glyphicon-retweet'></i> Gastos-Inversión</a></li>

            <li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-lock'></i> Usuarios</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
          </ul>
        </div>
  </div>
  <?php
    }
  ?>
</nav>
	<?php
		}
	?>