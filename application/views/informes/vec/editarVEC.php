
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center"> 
			INDUSTRIAS DELMOR, S.A.
		</h3>
		<h4 class="text-center">
			<span id="nombreRpt">VERIFICACION ESPECIFICACION DE CALIDAD</span>
		</h4>
		<h4 class="text-center">
			<?php
					echo $enc[0]["VERSION"]."";
					echo '<div class="form-group has-feedback">
						<input type="hidden" id="idmonitoreo" class="form-control" value="'.$enc[0]["IDMONITOREO"].'">
					</div>';
			?>
		</h4>		
	</section>
	<input type="hidden" id="txtidreporte" value="<?php echo $enc[0]["IDREPORTE"] ?>">
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
													if ($key["IDAREA"] == $enc[0]["IDAREA"]) {
														echo "
														<option selected value='".$key["IDAREA"]."'>".$key["AREA"]."</option>";
													}else{
														echo "<option value='".$key["IDAREA"]."'>".$key["AREA"]."</option>";
													}
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-xs-8 col-sm-8 col-md-6 col-lg-4">
								<div class="form-group has-feedback">
									<label for="vigencia">Observacion general</label>
									<input autocomplete="off" type="text" id="observacionGeneral" class="form-control" value="<?php echo $enc[0]["OBSERVACIONES"] ?>">
									<span class="fa fa-pencil form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-8 col-sm-4 col-md-6 col-lg-2">
								<div class="form-group has-feedback">
									<label for="vigencia">Código Producción</label>
									<input autocomplete="off" type="text" id="lote" class="form-control" value="<?php echo $enc[0]["LOTE"]?>">
									<span class="fa fa-pencil form-control-feedback"></span>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-4 col-sm-10 col-md-6 col-lg-5">
								<div class="form-group has-feedback">
									<label>Nombre del producto</label><br>
									<select class="select js-data-example-ajax form-control" id="ddlprod"></select>
								</div>
							</div>
							<div class="col-xs-3 col-sm-4 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Maquinas</label>
									<select id="cmbMaquina" class="form-control select2" style="width: 100%;">
										<option></option>
										<?php 
											if(!$maquinas){
											}else{
												foreach ($maquinas as $key) {
													echo "
													<option value='".$key["IDMAQUINA"]."'>".$key["MAQUINA"]."</option>
													";
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-xs-3 col-sm-6 col-md-2 col-lg-4">
								<div class="form-group has-feedback">
									<label for="">Operario</label>
									<input autofocus="" autocomplete="off" type="text" id="txtOperario" class="form-control col-xs-4" value="<?php echo $det[0]["OPERARIO"]?>">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Muestreo</label>
									<input autofocus="" autocomplete="off" type="text" id="txtMuestreo" class="form-control col-xs-4" placeholder="Muestreo Longitud">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-4 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="vigencia">Textura</label>
									<select id="txtTextura" class="form-control select2" style="width: 100%;">
										<option></option>
										<option selected value="I">AC</option>
										<option value="II">IC</option>
										<option value="III">ND</option>
									</select>
								</div>
							</div>
							<div class="col-xs-3 col-sm-4 col-md-2 col-lg-2">
								<div class="form-group has-feedback">									
									<label for="vigencia">Color</label>
									<select id="txtColor" class="form-control select2" style="width: 100%;">
										<option></option>
										<option selected value="I">AC</option>
										<option value="II">IC</option>
										<option value="III">ND</option>
									</select>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">T Pasta</label>
									<input autofocus="" autocomplete="off" type="text" id="txtTemperatura" class="form-control col-xs-4" placeholder="T Pasta">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-4 col-md-2 col-lg-2">
								<div class="form-group has-feedback">									
									<label for="vigencia">pH Pasta</label>
									<select id="txtPh" class="form-control select2" style="width: 100%;">
										<option></option>
										<option selected value="I">AC</option>
										<option value="II">IC</option>
										<option value="III">ND</option>
									</select>

								</div>
							</div>
							<div class="col-xs-8 col-sm-8 col-md-6 col-lg-4">
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
							<th class="text-center">Código</th>
							<th class="text-center">Producto</th>
							<th class="text-center">id maquina</th>
							<th class="text-center">Maquina</th>
							<th class="text-center">Operario</th>							
							<th class="text-center">Muestreo Longitud</th>
							<th class="text-center">Textura</th>
							<th class="text-center">Color</th>
							<th class="text-center">T Pasta</th>
							<th class="text-center">pH Pasta</th>
							<th class="text-center">Observación</th>
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
											<td>".$key["IDMAQUINA"]."</td>
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

<div class="modal" id="loading" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content" style="background-color:transparent;box-shadow: none; border: none;margin-top: 26vh;">
			<div class="text-center">
				<img width="130px" src="<?php echo base_url()?>assets/img/loading.gif">
			</div>
		</div>
	</div>
</div>