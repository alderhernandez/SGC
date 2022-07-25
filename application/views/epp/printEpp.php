<!doctype html>
	<html lang="es">
	<head>
		<meta>
		<title></title>
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/LOGOS_DELMOR1.png" />
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js')?>"></script>
		<style>
			td.firmas{
				width: 180px;
				padding: 5px;
				/* border-top: 0px; */
				border-right: 0px;
				border-top: 1px solid black;
				border-left: 0px;
				border-bottom: 0px;	
			}

			td.firmasespacio{
				width: 180px;
				padding: 5px;
				/* border-top: 0px; */
				border-right: 0px;
				border-top: 0px;
				border-left: 0px;
				border-bottom: 0px;	
			}
			#footer {
				padding: 30px 30px;
				width:1000px;
				height: auto;
				margin: 0 auto;
				font-family: 'arial'!important;
				text-transform: uppercase!important;
				margin-top:10vh;
			}
			.footer {
				margin-top: 80px;
			}
			.footer tr td {
				width: 50%;
				text-align: center;
				padding: 5px 5px;
				border: none;
			}
			table {
				color: black;
				font-size: 10pt;
				font-weight:bold;
				font-family: 'arial'!important;
				text-transform: uppercase!important;
				border-collapse: collapse;
				width: 1000px!important;
				margin: 0 auto;
				margin-bottom: 5px;
			}
			table th,td{
				text-align: center;
				border: 1px solid black;
			}
			.encabezado{
				margin:0;
				padding: 0;
				font-weight:800;
			}

			.negrita{
				font-weight:700;
				text-align:left;
			}

		/*.contenedor {
			width: 80%;
			height: 100%;
			margin: 0 auto;
			border: 1px solid black;
			border-radius: 2px;
			padding: 2px 2px;
        }*/

        span {
        	text-transform: uppercase!important;
        	font-weight: bold;
        	font-size: 10px;
        	margin-left:20%;
        }

        #img{
        	border:none;
        	width:20px;
        }
		/* .contenedor {
			width: 98%;
			height: 100%;
			margin: 0 auto;
			border: 1px solid black;
			border-radius: 2px;
			padding: 2px 2px;
        } */

        .black{
        	background-color:#484747;
        	color:white;
        	font-weight:bold;
        }

        #consecutivo{
        	margin-left:-90px;
        	float:right;
        	margin-right:20px;
        	border-left:1px solid black;
        	padding-left:5px;
        	font-size: 12px !important;
        	line-height: 0.5;
        	text-align:center;
        }
        .container{
        	margin: 0 auto;
        	max-width: 1280px;
        	width: 90%;
        }

        #tblMain thead td{
        	font-size: 8pt;
        }
    </style>
    <script>
    	$(document).ready(function(){


    		console.log(document.body.innerHTML);

    		let form_data = {
    			consecutivo: <?php echo $consecutivo; ?>,
    			idusuario: <?php echo $usuario; ?>,
    			desde: '<?php echo $desde;  ?>',
    			hasta: '<?php echo $hasta; ?>',
    			tipo: 3,
    			html: document.body.innerHTML
    		};				

    		$.ajax({
    			url: '<?php echo base_url("index.php/guardarHistortial") ?>',
    			type: 'POST',
    			data: form_data,
    			success: function(data)
    			{						
    				window.print();
    				let obj = jQuery.parseJSON(data);
    				$.each(obj, function(index, val) {
    					mensaje = val["mensaje"];
    					tipo = val["tipo"]; 
    				});
    				Swal.fire({
    					type: tipo,
    					text: mensaje,
    					allowOutsideClick: false
    				}).then((result)=>{
    					location.reload();
    				});				
    			},error:function(){
    				Swal.fire({
    					type: "error",
    					text: "Error inesperado, Intentelo de Nuevo",
    					allowOutsideClick: false
    				});					
    			}
    		});
    	})
    </script>
</head>

<body>
	<?php
		date_default_timezone_set("America/Managua");
		setlocale(LC_ALL,'Spanish_Nicaragua');
	?>
	<div class="contenedor">
		<div class="contenedor-secundario">
			<table class="table-produccion">
				<thead>
					<tr>
						<td rowspan="3" id="img">
							<img width="110px" id="img1" src="<?php echo base_url()?>assets/img/LOGOS_DELMOR.png" alt="">
						</td>
						<td class="encabezado" colspan="13">Industrias delmor S.A</td>
					</tr>
					<tr>
						<td class="encabezado" colspan="13">Departamento de Calidad</td>
					</tr>
					<tr>
						<td class="encabezado" colspan="13">INFORME DE EPP
							<span id="consecutivo" style="font-size:11pt;">
							</span> </td>
						</tr>
						<tr>
							<td colspan="1" class="negrita" style="width:200px;">Identificador:</td>
							<td colspan="7"><span style="font-size:11pt;">
								<?php					
									ECHO $enc[0]["Id"];
								?>
							</span></td>
						</tr>
						<tr>
							<td colspan="1" class="negrita">Elaborado por:</td>
							<td colspan="7"><span style="font-size:11pt;">
								<?php					
									ECHO $enc[0]["Nombres"].' '.$enc[0]["Apellidos"];
								?>
							</span></td>
						</tr>
						<tr>
							<td colspan="1" class="negrita">Fecha de elaboración:</td>
							<td colspan="7"><span style="font-size:11pt;">
								<?php					
									ECHO $enc[0]["FechaCrea"];
								?>
							</span></td>
						</tr>
						<tr>
							<td colspan="1" class="negrita" style="width:200px;">Impreso el:</td>
							<td colspan="7"><span style="font-size:11pt;">
								<?php
									$ruta = '';	
									ECHO date('Y-m-d H:m:s');
								?>
							</span></td>
						</tr>
						<tr>
							<td colspan="1" class="negrita">Nombre del empleado</td>
							<td><span style="font-size:11pt;">
								<?php
									echo $enc[0]["Nombre"];
								?></span></td>				
							</tr>			
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>


				<h2 align="center">VENTAS CONSOLIDADAS</h2>
				<div class="contenedor-secundario">
					<table class="table-produccion" id="tblMain">
						<thead>
						<tr>							
							<th class="text-center">CANTIDAD</th>
							<th class="text-center">ID</th>
							<th class="text-center">ARTÍCULO</th>
							
						</tr>
					</thead>
					<tbody class="text-center">
						<?php 
						$estado = '';
							
								foreach ($det as $key) {
									echo "
										<tr>
											<td>".$key["Id"]."</td>
											<td>".$key["IdArticulo"]."</td>
											<td>".$key["ARTICULO"]."</td>";
									echo"</tr>";
								}
						?>
					</tbody>
					</table>
				</div>
				<br>

				<div class="row" style="margin-top:0px; text-align: center;">
					<div class="col-lg-12 text-center">
						<h3>Firma ingresada:</h3>	
						<img src="<?php echo $enc[0]["Firma"]; ?>" class="rounded mx-auto d-block" alt="..." style="border: 1px solid black; border-radius: 7px 7px 7px 7px">
					</div>
				</div>	
</div>
</div>
</body>
</html>
