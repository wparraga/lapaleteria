<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	$id_compra= intval($_GET['id_compra']);
	$sql_count=mysqli_query($con,"select * from compras where CO_CODIGO='".$id_compra."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Compra no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_factura=mysqli_query($con,"select * from compras where CO_CODIGO='".$id_compra."'");
	$rw_factura=mysqli_fetch_array($sql_factura);

	$numero_factura=$rw_factura['CO_NUMERO'];
	$id_proveedor=$rw_factura['PRO_CODIGO'];
	$id_vendedor=$rw_factura['ID_VENDEDOR'];
	$fecha_factura=$rw_factura['CO_FECHA'];
	$condiciones=$rw_factura['CO_ESTADO'];
	$tot=$rw_factura['CO_TOTAL'];
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_compraItems_html.php');
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
        $html2pdf->Output('compraItems.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
