<?php
/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
/*session_start();
$session_id = session_id();*/

/* Connect To Database*/
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos
$codigo = $_SESSION["codigoU"];
$sql = mysqli_query($con, "select * from tb_user where id=" . $_SESSION['codigoU']);
$row = mysqli_fetch_array($sql);
$_SESSION["techo"] = $row["useremail"];

?>
<table class="table">
    Solicitudes instructor <?php echo $_SESSION["instructor"]; ?>
    <tr>
        <th>ITEM</th>
        <th>NUMERO SOLICITUD</th>
        <th><span class="pull-right">VALOR</span></th>
        <th><span class="pull-right">SALDO</span></th>
        <th><span class="pull-right">FECHA</span></th>
        <th><span class="pull-right">VER</span></th>
    </tr>
    <?php

    $total = $_SESSION["techo"];
    $saldo= $total;
    $item = 1;
    $valorTotal = 0;
    $sql = mysqli_query($con, "select * from cotizaciones_demo where empresa='" . $_SESSION["codigoU"] . "'");
    while ($row = mysqli_fetch_array($sql)) {
        $numero = $row["numero_cotizacion"];
        $sql1 = mysqli_query($con, "select SUM(cantidad*precio_venta) from detalle_cotizacion_demo where numero_cotizacion=" . $numero);
        $row1 = mysqli_fetch_array($sql1);
        $valorpedido = $row1[0];
        $valorTotal += $valorpedido;
        $saldo = $row['condiciones'];
        $fecha = $row['fecha_cotizacion'];

    ?>

        <tr>
            <td style="width:15%; "><? echo $item; ?></td>
            <td style="width:15%; "><? echo $numero; ?></td>
            <td style="width:15%; "><span class="pull-right"><? echo number_format($valorpedido, 2); ?></span></td>
            <td style="width:15%; "><span class="pull-right"><? echo number_format($saldo, 2)  ?></span></td>
            <td style="width:15%; "><span class="pull-right"><? echo $fecha; ?></span></td>
            <td><span class="pull-right"><a href="#" onclick="mostrar('<? echo $numero ?>')"><i class="glyphicon glyphicon-plus"></i></a></span></td>
        </tr>
    <?php
        $item++;
    }

    ?>
    <tr>
        <th></th>
        <th><span class="pull-right">TOTAL PEDIDOS $</span></th>
        <th><span class="pull-right"><? echo number_format($valorTotal, 2); ?></span></th>
        <th><span class="pull-right">SALDO $</span></th>
        <th><span class="pull-right"><? echo number_format($saldo, 2)  ?></span></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th><span class="pull-right">PRESUPUESTO ASIGNADO $</span></th>
        <th><span class="pull-right"><? echo number_format($valorTotal + $_SESSION["techo"], 2); ?></span></th>
        <th></th>
        <th></span></th>
        <th></th>
    </tr>
</table>
    <div id="solicitudes" class='col-md-12'></div>

    <script>

function mostrar(numero){
			$.ajax({
				type: "POST",
				url: "./ajax/mostrar_detalle.php",
                data: "solicitud=" + numero,
				beforeSend: function(objeto) {
					$("#solicitudes").html("Mensaje: Cargando...");
				},
				success: function(datos) {
					$("#solicitudes").html(datos);
				}
			});
		}
    </script>