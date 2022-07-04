<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-13 13:58:55
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-19 17:08:02
 */
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Control de Nitrito de sodio

			<a href="<?php echo base_url("index.php/nuevoCNS")?>" class="pull-right btn btn-primary">
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
				<table class="table table-bordered table-condensed table-striped" id="tblCNS">
					<thead>
					<tr>
						<!--<th>Fecha de ingreso <br>a premezcla</th>
						<th>Canitdad de nitrito <br>solicitado</th>
						<th>Cantidad Kg. <br>sal de cura obtenida</th>
						<th>Monitoreado por</th>
						<th>Acciones</th>-->
						<th>CodReporte</th>
						<th>Monitoreo</th>
						<th>Dia</th>
						<th>Hora</th>
						<th>Area</th>
						<th>Observaciones</th>
						<th>Monitoreado por</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$estado = '';
							if(!$cns)
							{}else{
								foreach ($cns as $key) {
									switch ($key["ESTADODET"]) {
										case 'A':
												$estado = "<span class='text-success text-bold'>Activo</span>";
											break; 
										
										default:
											$estado = "<span class='text-danger text-bold'>Inactivo</span>";
											break;
									}
									echo "
										<tr>
											<td>".$key["IDREPORTE"]."</td>
											<td>ISO-HACCP-".$key["SIGLA"]."</td>
											<td>".$key["FECHACREA"]."</td>
											<td>".$key["HORA"]."</td>
											<td>".$key["AREA"]."</td>
											<td>".$key["OBSERVACIONES"]."</td>
											<td>".$key["MONITOREADO_POR"]."</td>
											<td>".$estado."</td>";
											if($key["ESTADODET"] == "A"){
												echo "
													<td class='text-center'>
													    <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-eye'></i>
														</a>
														<a class='btn btn-primary btn-xs' href='".base_url("index.php/editarCNS/".$key["IDREPORTE"]."")."'>
														  <i class='fa fa-pencil'></i>
														</a>
														<a onclick='baja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADODET"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
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
														<a onclick='baja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADODET"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-undo' aria-hidden='true'></i> 	
														</a>						
													</td>
												";
											}
										echo"</tr>
									";
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<!-- /.box-body
			<div class="box-footer">
				Footer
			</div>-->
			<!-- /.box-footer-->
		</div>

	</section>
</div>
