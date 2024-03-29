<?php
/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/

session_start();
if ($_SESSION["seguir"] == "") {
	header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Solicitud Materiales</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<div class="container">
		<div class="row-fluid">
			<div class="col-md-12">
				<h2><span class="glyphicon glyphicon-edit"></span> Nueva Solicitud de Materiales</h2>
				<hr>
				<form class="form-horizontal" role="form" id="datos_cotizacion">
					<div class="form-group row">
						<label for="area" class="col-md-1 control-label">Area:</label>
						<div class="col-md-3">

							<select class="form-control" id="area" placeholder="area" required>
								<option value="<? echo $_SESSION["codigo"]; ?>"><? echo $_SESSION["nombre"]; ?> </option>
							</select>

						</div>

					</div>
					<div class="form-group row">
						<label for="instructor" class="col-md-1 control-label">Instructor:</label>
						<div class="col-md-3">
							<input type="text" class="form-control" id="instructor" placeholder="Nombre del Instructor" value="<? echo $_SESSION["instructor"]; ?>">
						</div>
						<label for="tel2" class="col-md-1 control-label">Teléfono:</label>
						<div class="col-md-2">
							<input type="text" class="form-control" id="tel2" placeholder="Teléfono" value="<? echo $_SESSION["telefono"]; ?>">
						</div>
						<label for="email" class="col-md-1 control-label">Email:</label>
						<div class="col-md-3">
							<input type="email" class="form-control" id="email" placeholder="Email" value="<? echo $_SESSION["correo"]; ?>">
						</div>
					</div>


					<div class="col-md-12">
						<div class="pull-right">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="load(1)">
								<span class="glyphicon glyphicon-plus"></span> Agregar productos
							</button>
							<button type="submit" class="btn btn-default">
								<span class="glyphicon glyphicon-print"></span> Solicitar Materiales
							</button>
							<button type="button" class="btn btn-default" onclick="location.href='index.php'">
								<span></span> Salir
							</button>
							<button type="button" class="btn btn-default" onclick="location.href='ver.php'">
								<span></span> Ver solicitudes previas
							</button>
						</div>
					</div>
				</form>
				<br><br>
				<div id="resultados" class='col-md-12'></div><!-- Carga los datos ajax -->

				<!-- Modal -->
				<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
							</div>
							<div class="modal-body">
								<form class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
										</div>
										<button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
									</div>
								</form>
								<div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
								<div class="outer_div"></div><!-- Datos ajax Final -->
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script>
		$(document).ready(function() {
			load(1);
			mostrar();
		});

		function load(page) {
			var q = $("#q").val();
			$("#loader").fadeIn('slow');
			var area1 = $("#area").val();
			$.ajax({
				url: './ajax/productos_cotizacion.php?area=' + area1 + '&action=ajax&page=' + page + '&q=' + q,
				beforeSend: function(objeto) {
					$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
				},
				success: function(data) {
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');

				}
			})
		}
		function mostrar(){
			$.ajax({
				type: "POST",
				url: "./ajax/mostrar_cotizador.php",
				beforeSend: function(objeto) {
					$("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
					$("#resultados").html(datos);
				}
			});
		}
	</script>
	<script>
		function agregar(id) {
			var precio_venta = document.getElementById('precio_venta_' + id).value;
			var cantidad = document.getElementById('cantidad_' + id).value;
			//Inicia validacion
			if (isNaN(cantidad)) {
				alert('Esto no es un numero');
				document.getElementById('cantidad_' + id).focus();
				return false;
			}
			if (isNaN(precio_venta)) {
				alert('Esto no es un numero');
				document.getElementById('precio_venta_' + id).focus();
				return false;
			}
			//Fin validacion

			$.ajax({
				type: "POST",
				url: "./ajax/agregar_cotizador.php",
				data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad,
				beforeSend: function(objeto) {
					$("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
					$("#resultados").html(datos);
				}
			});
		}

		function eliminar(id) {

			$.ajax({
				type: "GET",
				url: "./ajax/agregar_cotizador.php",
				data: "id=" + id,
				beforeSend: function(objeto) {
					$("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
					$("#resultados").html(datos);
				}
			});

		}

		$("#datos_cotizacion").submit(function() {

			if (confirm("Esta seguro de realizar el pedido, luego de realizarlo no podrá modificarlo ") == true) {
				var area = $("#area").val();
				var tel1 = $("#tel1").val();
				var instructor = $("#instructor").val();
				var tel2 = $("#tel2").val();
				var email = $("#email").val();
				var condiciones = $("#condiciones").val();
				var validez = $("#validez").val();
				var entrega = $("#entrega").val();

				VentanaCentrada('./pdf/documentos/cotizacion_pdf.php?area=' + area + '&tel1=' + tel1 + '&instructor=' + instructor + '&tel2=' + tel2 + '&email=' + email + '&condiciones=' + condiciones + '&validez=' + validez + '&entrega=' + entrega, 'Cotizacion', '', '1024', '768', 'true');

			}
		});
	</script>
</body>

</html>