<style type="text/css">
    table {
        vertical-align: top;
    }

    tr {
        vertical-align: top;
    }

    td {
        vertical-align: top;
    }

    table.page_footer {
        width: 100%;
        border: none;
        background-color: white;
        padding: 2mm;
        border-collapse: collapse;
        border: none;
    }
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial">

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
            <?php
            switch ($area) {
                case 4:
                    $dato = 'Construcción';
                    break;
            }
            ?>
            <td style="width:15%; ">Area:</td>
            <td style="width:50%"><? echo $dato; ?> </td>

        </tr>
        <tr>

            <td style="width:15%; ">Instructor:</td>
            <td style="width:50%"><? echo $instructor; ?></td>
            <td style="width:15%;text-align:right"> Teléfono:</td>
            <td style="width:20%">&nbsp; <? echo $tel2; ?> </td>
        </tr>
        <tr>

            <td style="width:15%; ">Email:</td>
            <td style="width:50%"><? echo $email; ?></td>
        </tr>

    </table>


    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;padding:1mm;">
        <tr>
            <th style="width: 10%">CANT.</th>
            <th style="width: 60%">DESCRIPCION</th>
            <th style="width: 15%">PRECIO UNIT.</th>
            <th style="width: 15%">PRECIO TOTAL</th>

        </tr>
    </table>
    <?php
    $sumador_total = 0;
    $sql= mysqli_query($con, "select max(numero_cotizacion) FROM cotizaciones_demo WHERE empresa='" . $_SESSION['codigoU']."'");
    $row = mysqli_fetch_array($sql);
    $solicitud=$row[0];
    $sql = mysqli_query($con, "select * FROM detalle_cotizacion_demo WHERE numero_cotizacion=" . $solicitud);
    while ($row = mysqli_fetch_array($sql)) {
        $cantidad=$row['cantidad'];
        $precioU=$row['precio_venta'];
        $producto=$row['id_producto'];
        $sql1 = mysqli_query($con, "select * FROM productos_demo WHERE id_producto=" . $producto);
	    $row1 = mysqli_fetch_array($sql1);
        $producto=$row1['nombre_producto'];
        $total=$cantidad*$precioU;
        $sumador_total += $total;
    ?>
        <table cellspacing="0" style="width: 100%; border: solid 1px black;  text-align: center; font-size: 11pt;padding:1mm;">
            <tr>
                <td style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
                <td style="width: 60%; text-align: left"><? echo $producto ?></td>
                <td style="width: 15%; text-align: right"><? echo number_format($precioU,2); ?></td>
                <td style="width: 15%; text-align: right"><? echo number_format($total,2); ?></td>

            </tr>
        </table>
    <?php
        //Insert en la tabla detalle_cotizacion
      // $insert_detail = mysqli_query($con, "INSERT INTO detalle_cotizacion_demo (numero_cotizacion,id_producto,cantidad,precio_venta) VALUES ('$numero_cotizacion','$id_producto','$cantidad','$precio_venta_r')");

    }

    ?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 11pt;padding:1mm;">
        <tr>
            <th style="width: 30%; text-align: right;">SALDO : </th>
            <th style="width: 20%; text-align: right;"><?php echo number_format( $_SESSION['techo']- $sumador_total,2);?></th>
            <th style="width: 30%; text-align: right;">TOTAL : </th>
            <th style="width: 20%; text-align: right;">&#36; <? echo number_format($sumador_total, 2); ?></th>
        </tr>
    </table>


    <br>



</page>

<?
$date = date("Y-m-d H:i:s");
$sql = mysqli_query($con, "SELECT sum(`cantidad_tmp`*`precio_tmp`) FROM `tmp_cotizacion` WHERE `session_id`='" . $_SESSION['codigoU'] . "'");
$row = mysqli_fetch_array($sql);
$saldo=$_SESSION['techo'] -$row[0];
//$insert = mysqli_query($con, "INSERT INTO cotizaciones_demo VALUES (null,'$numero_cotizacion','$date','$area','$tel1','$session_id','','$email','$saldo','$validez','$entrega')");
//mysqli_query($con, "UPDATE tb_user set useremail=".$saldo." WHERE id=" . $_SESSION['codigoU'] );
//$delete=mysqli_query($con,"DELETE FROM tmp_cotizacion WHERE session_id='".$_SESSION['codigoU']."'");

?>