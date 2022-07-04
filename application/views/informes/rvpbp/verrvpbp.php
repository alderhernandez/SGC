
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center"> 
			INDUSTRIAS DELMOR, S.A.
		</h3>
		<h4 class="text-center">
			<span id="nombreRpt">REGISTRO VERIFICACION DE PESO DE BASCULA</span>
		</h4>
		<h4 class="text-center">
			<?php
				if(!$enc){
				}else{
					echo "ISO-HACCP-".$enc[0]["SIGLA"]."<br>";
					echo "NO REPORTE: ".$enc[0]["IDREPORTE"]."";
				}
			?>
		</h4>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
				<a class="btn-flat" href="javascript:history.back()">
					<i class="fa fa-arrow-circle-left fa-2x"></i>
				</a>
				<a href="<?php echo base_url("index.php/imprimirRVPBP/".$enc[0]["IDREPORTE"]."")?>" target="_blank" class="pull-right btn btn-primary">
					Imprimir <i class="fa fa-print"></i>
				</a>
			</div>
			<div class="box-body">
				<div>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-4 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Area</label>
									<input autocomplete="off" type="text" disabled id="instrumento" class="form-control" value=<?php echo $enc[0]["AREA"] ?>>
									<span class="fa fa-code-fork form-control-feedback"></span>
								</div>
							</div>	
							<div class="col-xs-4 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Instrumento</label>
									<input autocomplete="off" type="text" disabled id="instrumento" class="form-control" value=<?php echo $enc[0]["NOMBREPRODUCTO"] ?>>
									<span class="fa fa-code-fork form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
								<div class="form-group has-feedback">
									<label for="vigencia">Observacion general</label>
									<input autocomplete="off" type="text" id="observacionGeneral" disabled class=" form-control" value=<?php echo $enc[0]["OBSERVACIONES"] ?>>
									<span class="fa fa-pencil form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="vigencia">Error Permitido</label>
									<input autocomplete="off" type="text" value="0.001" id="iderror" disabled="true" class="form-control" placeholder="+- 0.001kg">
									<span class="fa fa-code-fork form-control-feedback"></span>
								</div>
							</div>
						</div>
					</div>
					<hr>					
					<div class="row">
						<div class="col-xs-12">							
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">monitoreado por</label>
									<input readonly="" value="<?php echo $this->session->userdata("nombre")." ".$this->session->userdata("apellidos")?>" autocomplete="off" type="text" id="monituser" class="form-control" placeholder="monitoreado por">
									<span class="fa fa-user form-control-feedback"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<table class="table table-bordered table-condensed table-striped" id="tblDatos">
					<thead>
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Hora</th>
							<th class="text-center">Código</th>
							<th class="text-center">Peso de Masa<br>Patrón Utilizada</th>							
							<th class="text-center">Peso registrado en báscula</th>
							<th class="text-center">UnidadMedida</th>
							<th class="text-center">Diferencia</th>
							<th class="text-center">Observaciones</th>
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
											<td>".date_format(new DateTime($key["FECHACREA"]), "Y-m-d")."</td>
											<td>".date_format(new DateTime($key["HORA"]), "H:i")."</td>
											<td>".$key["CODIGO"]."</td>
											<td>".$key["PESOMASA"]."</td>
											<td>".$key["PESOBASCULA"]."</td>
											<td>".$key["UNIDADPESO"]."</td>
											<td>".$key["DIFERENCIA"]."</td>
											<td>".$key["OBSERVACION"]."</td>";
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

<div class="modal" id="loading" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content" style="background-color:transparent;box-shadow: none; border: none;margin-top: 26vh;">
			<div class="text-center">
				<img width="130px" src="<?php echo base_url()?>assets/img/loading.gif">
			</div>
		</div>
	</div>
</div>
