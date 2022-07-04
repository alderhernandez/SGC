
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center"> 
			INDUSTRIAS DELMOR, S.A.
		</h3>
		<h4 class="text-center">
			<span id="nombreRpt">REGISTRO CONTROL DE PESO EN PROCESO (CPP)</span>
		</h4>
		<h4 class="text-center">
			<?php
				if(!$enc){
				}else{					
					echo $version."";
					echo '<div class="form-group has-feedback">
						<input type="hidden" id="idmonitoreo" class="form-control" value="'.$enc[0]["IDMONITOREO"].'">
					</div>';
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
				<a href="<?php echo base_url("index.php/imprimirCPP/".$enc[0]["IDREPORTE"]."")?>" target="_blank" class="pull-right btn btn-primary">
					Imprimir <i class="fa fa-print"></i>
				</a>
			</div>
			<div class="box-body">
				<div>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-4 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group">
									<label for="vigencia">Area</label>
									<input  type="text" disabled="true" id="observacionGeneral" value="<?php echo $enc[0]["AREA"]?>" class="form-control">
								</div>
							</div>
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
								<div class="form-group has-feedback">
									<label for="vigencia">Observacion general</label>
									<input disabled="true" type="text" id="observacionGeneral" class="form-control" 
										value="<?php echo $enc[0]["OBSERVACIONES"] ?>" />
										
									<span class="fa fa-pencil form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Fecha</label>
									<input disabled="true" type="text" id="fecha" class="form-control" value="<?php echo $enc[0]["FECHACREA"] ?>">
									<span class="fa fa-calendar form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Lote</label>
									<input disabled="true" autocomplete="off" type="text" id="lote" value = "<?php echo $enc[0]["LOTE"] ?>" class="form-control col-xs-4" >
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Peso Gr</label>
									<input disabled="true" autocomplete="off" type="text" id="lote" value = "<?php echo $enc[0]["PESOGRAMOS"] ?>" class="form-control col-xs-4" >
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Funda Largo</label>
									<input disabled="true" autocomplete="off" type="text" id="lote" value = "<?php echo $enc[0]["FUNDALARGO"] ?>" class="form-control col-xs-4" >
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Funda Diametro</label>
									<input disabled="true" autocomplete="off" type="text" id="lote" value = "<?php echo $enc[0]["FUNDADIAMETRO"] ?>" class="form-control col-xs-4" >
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
						</div>
					</div>
					<hr>
					

					<div class="row">
						<div class="col-xs-12">							
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Tamaño Muestra</label>
									<input disabled="true" type="text" id="fecha" class="form-control" value="<?php echo $enc[0]["TAMANOMUESTRA"] ?>">
								</div>
							</div>
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Nivel Inspeccion</label>
									<input disabled="true" type="text" id="fecha" class="form-control" value="<?php echo $enc[0]["NIVELINSPECCION"] ?>">
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-check">
									<?php 	$chekde = ''; if ($enc[0]["ESPECIAL"]) {
										$chekde = 'checked';
									} ?>
								  <input <?php 	echo $chekde; ?> class="form-check-input" type="checkbox" value="" id="chkEspecial">
								  <label class="form-check-label" for="chkEspecial">
								  	Nivel Especial
								  </label>
								</div>
							</div>							
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-3 especial">
								<div class="form-group has-feedback">
									<label for="vigencia">Nivel Inspeccion Especial</label>
									<input disabled="true" type="text" id="fecha" class="form-control" value="<?php echo $enc[0]["NIVELINSPECCION2"] ?>">
							</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Muestra</label>
									<input disabled="true" type="text" id="fecha" class="form-control" value="<?php echo $enc[0]["MUESTRA"] ?>">
									<span class="fa fa-truck form-control-feedback"></span>
								</div>
							</div>							
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">monitoreado por</label>
									<input readonly="" value="<?php echo $enc[0]["NOMBRES"].' '.$enc[0]["APELLIDOS"]  ?>" type="text" id="monituser" class="form-control bg-info">
									<span class="fa fa-user form-control-feedback"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<table class="table table-bordered table-condensed table-striped" id="tblDatos">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Codigo</th>
							<th class="text-center">Descripción</th>
							<th class="text-center">Peso Original</th>
							<th class="text-center">Peso Gr</th>
							<th class="text-center">Diferencia</th>
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
											<td>".$key["NUMERO"]."</td>
											<td>".$key["CODIGO"]."</td>
											<td>".$key["DESCRIPCION"]."</td>
											<td>".$key["PESOMASA"]."</td>
											<td>".$key["PESOBASCULA"]."</td>
											<td>".$key["DIFERENCIA"]."</td>";
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