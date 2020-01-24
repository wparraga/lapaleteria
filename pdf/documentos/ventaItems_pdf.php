<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	
	
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	$session_id= session_id();
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No existen articulos asignados para la Venta')</script>";
	echo "<script>window.close();</script>";
	exit;
	}

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_cliente=intval($_GET['id_cliente']);
	$id_vendedor=intval($_GET['id_vendedor']);
	$fecha=$_GET['fecha'];
	$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	$subto=floatval($_GET['subtotal']);
	$ivaa=floatval($_GET['iva']);
	$tot=floatval($_GET['total']);
	$abono=floatval($_GET['abono']);
	$saldo=floatval($_GET['saldo']);

	//Fin de variables por GET
	$sql=mysqli_query($con, "select LAST_INSERT_ID(VI_NUMERO) as last from venta_item order by VI_CODIGO desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	$numero_factura=$rw['last']+1;	
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ventaItems_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('ventaItems.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
