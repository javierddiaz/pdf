<?php
/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
session_start();
$session_id = session_id();

/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
$codigo=$_SESSION["codigoU"];
$sql=mysqli_query($con, "select * from tb_user where id=".$_SESSION['codigoU']);
$row=mysqli_fetch_array($sql);
$_SESSION["techo"]=$row["useremail"];

?>
<table class="table">
	<tr>
		<th>CODIGO</th>
		<th>CANT.</th>
		<th>DESCRIPCION</th>
		<th><span class="pull-right">PRECIO UNIT.</span></th>
		<th><span class="pull-right">PRECIO TOTAL</span></th>
		<th></th>
	</tr>
	<?php

	$total = $_SESSION["techo"];
	

	$sumador_total = 0;
	$sql = mysqli_query($con, "select distinct * from productos_demo, tmp_cotizacion where productos_demo.id_producto=tmp_cotizacion.id_producto and tmp_cotizacion.session_id='" . $_SESSION["codigoU"] . "'");
	
	while ($row = mysqli_fetch_array($sql)) {
		$id_tmp = $row["id_tmp"];
		$codigo_producto = $row['codigo_producto'];
		$cantidad = $row['cantidad_tmp'];
		$nombre_producto = $row['nombre_producto'];
		$precio_venta = $row['precio_tmp'];
		$precio_venta_f = number_format($precio_venta, 2); //Formateo variables
		$precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
		$precio_total = $precio_venta_r * $cantidad;
		$precio_total_f = number_format($precio_total, 2); //Precio total formateado
		$precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
		$sumador_total += $precio_total_r; //Sumador

	?>
		<tr>
			<td><? echo $codigo_producto; ?></td>
			<td><? echo $cantidad; ?></td>
			<td><? echo $nombre_producto  ?></td>
			<td><span class="pull-right"><? echo $precio_venta_f; ?></span></td>
			<td><span class="pull-right"><? echo $precio_total_f; ?></span></td>
			<td><span class="pull-right"><a href="#" onclick="eliminar('<? echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></span></td>
		</tr>
	<?php
	}

	?>
	<tr>
		<td></td>
		<td></td>
		<td><span class="pull-left">SALDO $ &nbsp; </span><? echo number_format($total-$sumador_total, 2); ?></td>
		<td><span class="pull-right">TOTAL $</span></td>
		<td><span class="pull-right"><? echo number_format($sumador_total, 2); ?></span></td>
		<td></td>
	</tr>