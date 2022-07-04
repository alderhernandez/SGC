
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
				if(!$monit){
				}else{
					foreach ($monit as $key) {
						echo $version."";
						echo '<div class="form-group has-feedback">
								<input type="hidden" id="idmonitoreo" class="form-control" value="'.$key["IDMONITOREO"].'">
							</div>';
					}
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
				   <button class="pull-right btn btn-primary" id="btnGuardar">
						Guardar <i class="fa fa-save"></i>
					</button>				
			</div>
			<div class="box-body">
				<div>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-4 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group">
									<label>Area</label>
									<select id="ddlAreas" class="form-control select2" style="width: 100%;">
										<option></option>
										<?php 
											if(!$areas){
											}else{
												foreach ($areas as $key) {
													echo "
														<option value='".$key["IDAREA"]."'>".$key["AREA"]."</option>
													";
												}
											}
										?>
									</select>
								</div>
							</div>	
							<div class="col-xs-4 col-sm-4 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Instrumento</label>
									<input autocomplete="off" type="text" id="instrumento" class="form-control" placeholder="Instrumento a Verificar">
									<span class="fa fa-code-fork form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-8 col-sm-7 col-md-6 col-lg-4">
								<div class="form-group has-feedback">
									<label for="vigencia">Observacion general</label>
									<input autocomplete="off" type="text" id="observacionGeneral" class="form-control" placeholder="Observaciones">
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
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Fecha ingreso</label>
									<input autocomplete="off" type="text" id="fecha" class="form-control" placeholder="Fecha ingreso">
									<span class="fa fa-calendar form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
									<label for="vigencia">Hora</label>
									<input type="text" id="hora" class="form-control" value="09:30">
									<span class="fa fa-calendar form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="">Código</label>
									<input autofocus="" autocomplete="off" type="text" id="codigo" class="form-control" placeholder="Código">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-4 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group">
									<label>Peso</label>
									<select id="ddpeso" class="form-control select2" style="width: 100%;">
										<option></option>
										<?php 
											if(!$pesos){
											}else{
												foreach ($pesos as $key) {
													echo "
														<option value='".$key["IDPESO"]."'>".$key["DESCRIPCION"]."</option>
													";
												}
											}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="">Peso masa patrón</label>
									<input autofocus="" autocomplete="off" type="text" id="ppatron" class="form-control col-xs-4" placeholder="cantidad">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Peso Bascula</label>
									<input autofocus="" autocomplete="off" type="text" id="pbascula" class="form-control col-xs-4" placeholder="cantidad">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
								<div class="form-group has-feedback">
									<label for="vigencia">Observacion</label>
									<input autocomplete="off" type="text" id="observaciones" class="form-control" placeholder="Observaciones">
									<span class="fa fa-pencil form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">monitoreado por</label>
									<input readonly="" value="<?php echo $this->session->userdata("nombre")." ".$this->session->userdata("apellidos")?>" autocomplete="off" type="text" id="monituser" class="form-control" placeholder="monitoreado por">
									<span class="fa fa-user form-control-feedback"></span>
								</div>
							</div>							
							<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for=""> </label>
									<button id="btnAdd" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i></button>
									<label for=""> </label>
									<button id="btnDelete" class="btn btn-danger btn-lg"><i class="fa fa-trash"></i></button>
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