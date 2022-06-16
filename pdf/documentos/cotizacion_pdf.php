<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/


	session_start();
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	$session_id= $_SESSION["codigoU"];
	$sql_count=mysqli_query($con,"select * from tmp_cotizacion where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	$bandera=0;
	if ($count==0)
	{
		$bandera=1;
	}

	//require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$area=$_GET['area'];
	$tel1=$_GET['tel1'];
	$instructor=$_GET['instructor'];
	$tel2=$_GET['tel2'];
	$email=$_GET['email'];
	$condiciones=$_GET['condiciones'];
	$validez=$_GET['validez'];
	$entrega=$_GET['entrega'];

	//Fin de variables por GET
	
	$sql_cotizacion=mysqli_query($con, "select LAST_INSERT_ID(numero_cotizacion) as last from cotizaciones_demo order by id_cotizacion desc limit 0,1 ");
	$rwC=mysqli_fetch_array($sql_cotizacion);
	$numero_cotizacion=$rwC['last']+1;	

    // get the HTML
     ob_start();
	 if ($bandera==0)
     	include(dirname('__FILE__').'/res/cotizacion_html.php');
	else
		include(dirname('__FILE__').'/res/cotizacion1_html.php');
    $content = ob_get_clean();

	require __DIR__.'/vendor/autoload.php';

		use Spipu\Html2Pdf\Html2Pdf;

		$html2pdf = new Html2Pdf();
		$html2pdf->writeHTML($content);
		$html2pdf->output();

		