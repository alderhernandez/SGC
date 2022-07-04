<?php


?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			REGISTRO VERIFICACION DE PESO DE BASCULA (RVPBP)

			<a href="<?php echo base_url("index.php/nuevorvpbp")?>" class="pull-right btn btn-primary">
				Agregar <i class="fa fa-plus"></i>
			</a>
			<!--<small>Blank example to the fixed layout</small>-->
		</h1>
		
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
						<th>Cod Reporte</th>
						<th>Monitoreo</th>
						<th>Fecha</th>
						<th>Área</th>
						<th>Instrumento Verificado</th>
						<th>Realizado por</th>
						<th>Verificado por</th>
						<th>Acciones</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$estado = '';
							if(!$rvpbp)
							{}else{
								foreach ($rvpbp as $key) {
									switch ($key["ESTADO"]) {
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
											<td>".$key["FECHACREA"]."</td>
											<td>".$key["AREA"]."</td>
											<td>".$key["AREA"]."</td>
											<td>".$key["MONITOREADO_POR"]."</td>
											<td>".$key["MONITOREADO_POR"]."</td>
											<td>".$estado."</td>";
											if($key["ESTADO"] == "A"){
												echo "
													<td class='text-center'>
													    <a class='detalles btn btn-success btn-xs' href='".base_url("index.php/verRVPBP/".$key["IDREPORTE"]."")."'>
														  <i class='fa fa-eye'></i>
														</a>
														<a class='btn btn-primary btn-xs' href='".base_url("index.php/editarRVPBP/".$key["IDREPORTE"]."")."'>
														  <i class='fa fa-pencil'></i>
														</a>
														<a onclick='baja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
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
														<a onclick='baja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
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
		</div>

	</section>
</div>
