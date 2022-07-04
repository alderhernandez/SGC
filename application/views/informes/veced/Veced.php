<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-22 09:19:04
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-22 10:05:58
 */
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Verificación De Especificaciones De Calidad En Deshuese

			<a href="<?php echo base_url("index.php/nuevoVECED")?>" class="pull-right btn btn-primary">
				Agregar <i class="fa fa-plus"></i>
			</a>
			<!--<small>Blank example to the fixed layout</small>-->
		</h1>
		<!--<ol class="breadcrumb">
			<li class="active"></li>
		</ol>-->
		<br>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
				<a class="btn-flat" href="<?php echo base_url("index.php/Informes")?>">
					<i class="fa fa-arrow-circle-left fa-2x"></i>
				</a>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i>
					</button>
					<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fa fa-times"></i></button>-->
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<table class="table table-bordered table-condensed table-striped table-responsive" id="tblVeced">
								<thead>
								<tr>
									<!--<th>Fecha de ingreso <br>a premezcla</th>
									<th>Canitdad de nitrito <br>solicitado</th>
									<th>Cantidad Kg. <br>sal de cura obtenida</th>
									<th>Monitoreado por</th>
									<th>Acciones</th>-->
									<th>Cod <br> Reporte</th>
									<th>Monitoreo</th>
									<th>Dia</th>
									<th>Hora <br> Identific.</th>
									<th>Area</th>
									<th>Fecha</th>
									<th>Producto</th>
									<th>Cod <br> Produccion</th>
									<th>N° Estibas</th>
									<th>Monitoreado por</th>
									<th>Estado</th>
									<th>Acciones</th>
								</tr>
								</thead>
								<tbody>
								<?php
								$estado = '';
								if(!$veced)
								{
								}else{
									foreach ($veced as $item) {
										switch ($item["ESTADODET"]) {
											case 'A':
												$estado = "<span class='text-success text-bold'>Activo</span>";
												break;

											default:
												$estado = "<span class='text-danger text-bold'>Inactivo</span>";
												break;
										}
										echo "
										<tr>
											<td style='font-size:10pt;'>".$item["IDREPORTE"]."</td>
											<td style='font-size:10pt;'>".$item["SIGLA"]."</td>
											<td style='font-size:10pt;'>".date_format(new DateTime($item["DIA"]),"d")."</td>
											<td style='font-size:10pt;'>".date_format(new DateTime($item["HORAIDENTIFICACION"]),"H:i:s")."</td>
											<td style='font-size:10pt;'>".$item["AREA"]."</td>
											<td style='font-size:10pt;'>".date_format(new DateTime($item["FECHACREA"]),"Y-m-d")."</td>
											<td style='font-size:10pt;'>".$item["DESCRIPCION"]."</td>
											<td style='font-size:10pt;'>".$item["CODIGOPRODUCCION"]."</td>
											<td style='font-size:10pt;'>".$item["NOESTIBAS"]."</td>
											<td style='font-size:10pt;'>".$item["USUARIO"]."</td>
											<td style='font-size:10pt;'>".$estado."</td>";
										if($item["ESTADODET"] == "A"){
											echo "
															<td class='text-center'>
																<a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
																  <i class='fa fa-eye'></i>
																</a>
																<a class='btn btn-primary btn-xs' href='".base_url("index.php/editarVeced/".$item["IDREPORTE"]."")."'>
																  <i class='fa fa-pencil'></i>
																</a>
																<a  onclick='BajaAltaVeced(".'"'.$item["IDREPORTE"].'","'.$item["ESTADODET"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
																  <i class='fa fa-trash'></i> 	
																</a>						
															</td>
														";
										}else{
											echo "
															<td class='text-center'>
															<a class='btn btn-success btn-xs disabled' href='javascript:void(0)'>
																  <i class='fa fa-eye'></i>
																</a>
																<a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
																  <i class='fa fa-pencil'></i>
																</a>
																<a onclick='BajaAltaVeced(".'"'.$item["IDREPORTE"].'","'.$item["ESTADODET"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
																  <i class='fa fa-undo' aria-hidden='true'></i> 	
																</a>						
															</td>
														";
										}
										echo "</tr>						
									";
									}
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body
			<div class="box-footer">
				Footer
			</div>-->
			<!-- /.box-footer-->
		</div>

	</section>
</div>
