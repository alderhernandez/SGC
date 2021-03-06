<!doctype html>
<html lang="es">
<head>
	<meta>
	<title></title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/LOGO.png" />
	<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
	<style>
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
			width: 1000px;
			margin: 0 auto;
			margin-bottom: 5px;
			text-align: center!important;
		}
		tbody{
			font-size: 12px;
		}
		table th,td{
			text-align: center;
			border: 1px solid black;
		}
		#tblMain thead td{
			font-size: 8pt;
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
	</style>
	<script>
		$(document).ready(function(){
			window.print();
		})
	</script>
</head>
<body>	
<div class="content-wrapper">
	<table class="table-produccion">
			<thead>
			<tr>
				<td rowspan="3" id="img">
					<img width="110px" id="img1" src="<?php echo base_url()?>assets/img/LOGO.png" alt="">
				</td>
				<td class="encabezado" colspan="13">Industrias delmor S.A.</td>
			</tr>
			<tr>
				<td class="encabezado" colspan="13">Gerencia de Calidad</td>
			</tr>
			<tr>
				<td class="encabezado" colspan="13">VERIFICACION ESPECIFICACION DE CALIDAD<br>
				<?php
				if(!$det){
					}else{
						echo $enc[0]["VERSION"]."<br>";
						echo "NO REPORTE: ".$enc[0]["IDREPORTE"]."";
					}
				?>
			</tr>
			<tr>
				<td colspan="1" class="negrita ">Area:</td>
				<td colspan="7">
					<?php echo $enc[0]["AREA"] ?>
				</td>
			</tr>
			<tr>
				<td colspan="1" class="" style="width:200px;">NOMBRE DEL PRODUCTO:</td>
				<td colspan="7"><?php echo $enc[0]["NOMBREPRODUCTO"] .' ('.$enc[0]["CODIGOPRODUCTO"].')' ?>
				</td>
			</tr>
			<tr>
				<td colspan="1" class="">Fecha:</td>
				<td class=""><?php echo $enc[0]["FECHACREA"] ?></td>
			</tr>
			<tr>
				<td colspan="1" class="negrita ">Observacion:</td>
				<td colspan="7">
					<?php echo $enc[0]["OBSERVACIONES"] ?>
				</td>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

	<!-- Main content -->
	<section class="content">
		<div class="box box-danger">			
			<div class="box-body">
				<div>
				
				<br>
				<table class="table table-bordered table-condensed table-striped" id="tblDatos">
					<thead>
						<tr>
							<th class="text-center">C??digo</th>
							<th class="text-center">Producto</th>
							<th class="text-center">Maquina</th>
							<th class="text-center">Operario</th>
							<th class="text-center">Muestreo Longitud</th>
							<th class="text-center">Textura</th>
							<th class="text-center">Color</th>
							<th class="text-center">T Pasta</th>
							<th class="text-center">pH Pasta</th>
							<th class="text-center">Observaci??n</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php
						$estado = '';
							if(!$det)
							{}else{
								foreach ($det as $key) {
									echo "
										<tr>
											<td>".$key["CODIGO"]."</td>
											<td>".$key["NOMBRE"]."</td>
											<td>".$key["MAQUINA"]."</td>											
											<td>".$key["OPERARIO"]."</td>
											<td>".$key["LONGITUD"]."</td>
											<td>".$key["TEXTURA"]."</td>
											<td>".$key["COLOR"]."</td>
											<td>".$key["TEMP_PASTA"]."</td>
											<td>".$key["PH_PASTA"]."</td>
											<td>".$key["COMENTARIO"]."</td>";
										echo"</tr>
									";
								}
							}
						?>
					</tbody>
				</table>
			</div>			
		</div>
	</section>
</div>

</body>