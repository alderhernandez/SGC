<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-13 08:36:22
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-13 09:17:54
 */
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Reporte de acciones correctivas y medidas preventivas (RACYMP)

			<button class="pull-right btn btn-primary" data-toggle="modal" id="btnModal">
				Agregar <i class="fa fa-plus"></i>
			</button>
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
				<a class="btn-flat" href="javascript:history.back()">
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
				<table class="table table-bordered table-condensed table-striped" id="tblracymp">
					<thead>
					<tr>
						<th>Hora</th>
						<th>N° conformidad y<br>hora de la identificacion</th>
						<th>Notificado</th>
						<th>Acciones correctivas y<br>hora de correcion</th>
						<th>Medidas preventivas</th>
						<th>Responsable</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$estado = '';
							if(!$rvpbp)
							{}else{
								foreach ($rvpbp as $key) {
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
											<td>".$key["SIGLA"]."</td>
											<td>".$key["DIA"]."</td>
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
