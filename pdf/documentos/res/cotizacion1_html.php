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
    exit;
    $sumador_total = 0;
    $sql= mysqli_query($con, "select max(numero_cotizacion) FROM cotizaciones_demo WHERE empresa=" . $_SESSION['codigoU']);
    $row = mysqli_fetch_array($sql);
    echo $row[0];
    exit;
    $sql = mysqli_query($con, "select * FROM detalle_cotizacion_demo WHERE numero_cotizacion=" . $solicitud);
    $sql = mysqli_query($con, "select * from productos_demo, detalle_cotizacion_demo where productos_demo.id_producto=tmp_cotizacion.id_producto and tmp_cotizacion.session_id='" . $session_id . "'");
    while ($row = mysqli_fetch_array($sql)) {
        $id_tmp = $row["id_tmp"];
        $id_producto = $row["id_producto"];
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
        <table cellspacing="0" style="width: 100%; border: solid 1px black;  text-align: center; font-size: 11pt;padding:1mm;">
            <tr>
                <td style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
                <td style="width: 60%; text-align: left"><? echo $nombre_producto ?></td>
                <td style="width: 15%; text-align: right"><? echo $precio_venta_f; ?></td>
                <td style="width: 15%; text-align: right"><? echo $precio_total_f; ?></td>

            </tr>
        </table>
    <?php
        //Insert en la tabla detalle_cotizacion
       $insert_detail = mysqli_query($con, "INSERT INTO detalle_cotizacion_demo (numero_cotizacion,id_producto,cantidad,precio_venta) VALUES ('$numero_cotizacion','$id_producto','$cantidad','$precio_venta_r')");

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
$insert = mysqli_query($con, "INSERT INTO cotizaciones_demo VALUES (null,'$numero_cotizacion','$date','$area','$tel1','$session_id','','$email','$saldo','$validez','$entrega')");
mysqli_query($con, "UPDATE tb_user set useremail=".$saldo." WHERE id=" . $_SESSION['codigoU'] );
$delete=mysqli_query($con,"DELETE FROM tmp_cotizacion WHERE session_id='".$_SESSION['codigoU']."'");

?>