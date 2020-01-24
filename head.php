<head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title;?></title>

	<?php
		require_once ("config/db.php");
		require_once ("config/conexion.php");
	?>
	<link rel="stylesheet" href="css/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/custom.css">

	<!-- selectpicker -->
	<link rel="stylesheet" href="css/selectpicker/css/bootstrap-select.css">
	<script src="css/selectpicker/js/bootstrap-select.js" defer></script>

	<!-- SweetAlert 2 -->
	<script src="js/sweetalert2/sweetalert2.all.js"></script>
	<!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>-->

	<script type="text/javascript" src="js/validador.js"></script>
	<link rel=icon href='img/logo-icon.png' sizes="32x32" type="image/png">
    <!-- select2 
	<link rel="stylesheet" href="css/select2/css/select2.min.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="css/select2/js/select2.full.min.js"></script>
	<script>
	    $(function () {
	       $('.select2').select2()
	    })
	</script>-->

</head>