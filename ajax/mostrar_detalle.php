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
$solicitud=$_POST['solicitud'];
?>
<table class="table">
	<tr>

		<th>CANT.</th>
		<th>DESCRIPCION</th>
		<th><span class="pull-right">PRECIO UNIT.</span></th>
		<th><span class="pull-right">PRECIO TOTAL</span></th>

	</tr>
	<?php

	$total = $_SESSION["techo"];
	

	$sumador_total = 0;
	$sql = mysqli_query($con, "select * FROM detalle_cotizacion_demo WHERE numero_cotizacion=" . $solicitud);
	while ($row = mysqli_fetch_array($sql)) {
        $cantidad=$row['cantidad'];
        $precioU=$row['precio_venta'];
        $producto=$row['id_producto'];
        $sql1 = mysqli_query($con, "select * FROM productos_demo WHERE id_producto=" . $producto);
	    $row1 = mysqli_fetch_array($sql1);
        $producto=$row1['nombre_producto'];
        $total=$cantidad*$precioU;

	?>
		<tr>

			<td><? echo $cantidad; ?></td>
			<td><? echo $producto  ?></td>
			<td><span class="pull-right"><? echo $precioU; ?></span></td>
			<td><span class="pull-right"><? echo $total; ?></span></td>
		</tr>
	<?php
	}

	?>
