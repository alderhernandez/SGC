
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center"> 
			INDUSTRIAS DELMOR, S.A.
		</h3>
		<h4 class="text-center">
			<span id="nombreRpt">EDICIÓN REGISTRO CONTROL DE DIAMETRO EN PROCESO (CDP)</span>
		</h4>
		<h4 class="text-center">
			<?php
				if(!$enc){
				}else{
					foreach ($enc as $key) {
						echo $enc[0]["VERSION"]."<br>";
						echo "NO REPORTE".$key["IDREPORTE"]."";
						echo '<div class="form-group has-feedback">
								<input type="hidden" id="idmonitoreo" class="form-control" value="'.$key["IDMONITOREO"].'">
							</div>';
					}
				}
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
							<div class="col-xd-12 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group">
									<label>Area</label>
									<select id="ddlAreas"  class="form-control select2" style="width: 100%;">
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
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
								<div class="form-group has-feedback">
									<label for="vigencia">Observacion general</label>
									<input autocomplete="off" type="text" id="observacionGeneral" value="<?php echo $enc[0]["OBSERVACIONES"] ?>" class="form-control" >
									<span class="fa fa-pencil form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Fecha</label>
									<input autocomplete="off" type="text" id="fecha" class="form-control" value="<?php echo date_format(new DateTime($enc[0]["FECHAINICIO"]), "Y/m/d") ?>" placeholder="Fecha ingreso">
									<span class="fa fa-calendar form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Lote</label>
									<input autofocus="" autocomplete="off" type="text" id="lote" value="<?php echo $enc[0]["LOTE"]?>" class="form-control col-xd-12" placeholder="Lote">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xd-12 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group">
									<label>Máquina</label>
									<select id="ddlMaquina"  class="form-control select2" style="width: 100%;">
										<option></option>
										<?php 
											if(!$maq){
											}else{
												foreach ($maq as $key) {
													if ($key["IDMAQUINA"] == $enc[0]["IDMAQUINA"]) {
														echo "
														<option selected value='".$key["IDMAQUINA"]."'>".$key["MAQUINA"]."</option>";
													}else{
														echo "<option value='".$key["IDMAQUINA"]."'>".$key["MAQUINA"]."</option>";
													}
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Funda</label>
									<input autofocus="" autocomplete="off" type="text" id="largo" class="form-control col-xs-2" 
									value="<?php echo number_format($enc[0]["FUNDALARGO"],2) ?>">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>									
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Funda</label>
									<input autofocus="" autocomplete="off" type="text" id="diametro" class="form-control col-xs-2" value="<?php echo number_format($enc[0]["FUNDADIAMETRO"],2) ?>">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
									<div class="form-group has-feedback">
										<label for="">No Batch</label>
										<input autocomplete="off" type="text" id="batch" value="<?php echo $enc[0]["NOBATCH"]?>" class="form-control" placeholder="Batch">
										<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
									</div>
								</div>
							</div>
							<div id="checkboxes" class="col-lg-12 form-check form-check-inline">
								<?php
									$chek = '';
									foreach ($decisiones as $key) {
										if ($key == $enc[0]["DECISION"]) {
											$chek = 'checked';
										}
										echo '<label class="form-check-label" for="chk'.$key.'">'.$key.'</label>';
							  			echo '<input class="form-check-input" '.$chek.' type="radio" name="inlineRadioOptions" id="chk'.$key.'" value="'.$key.'">';
							  			$chek = '';
									}
								?>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xd-12 col-sm-12 col-md-6 col-lg-5">
									<div class="form-group has-feedback">
										<label>Nombre del producto</label><br>
										<select class="select js-data-example-ajax form-control" id="ddlprod"></select>
									</div>
							</div>
							<div class="col-xd-12 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group">
									<label>Diametro esperado</label>
									<input autocomplete="off" type="text" id="diametroEsperado" class="form-control" placeholder="Diametro Esperado">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">							
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Tamaño Muestra</label>
									<select id="cmbTamaño" class="form-control select2" style="width: 100%;">
										<option></option>
										<?php 
											if(!$niveles){
											}else{
												foreach ($niveles as $key) {
													if ($enc[0]["TAMANOMUESTRA"] == intval($key["Desde"]).'-'.intval($key["Hasta"])) {
														echo "
														<option selected value='".intval($key["Desde"]).'-'.intval($key["Hasta"])."'>".intval($key["Desde"]).'-'.intval($key["Hasta"])."</option>
														";
													}else{
														echo "
														<option value='".intval($key["Desde"]).'-'.intval($key["Hasta"])."'>".intval($key["Desde"]).'-'.intval($key["Hasta"])."</option>
														";
													}
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Nivel Inspeccion</label>
									<select id="cmdNivel" class="form-control select2" style="width: 100%;">
										<option></option>
										<?php  
											$nivel = array('I','II','III');
											foreach ($nivel as $key) {
												if ($enc[0]['NIVELINSPECCION'] == $key) {
													echo '<option selected value="'.$key.'">'.$key.'</option>';
												}else{
													echo '<option value="'.$key.'">'.$key.'</option>';
												}
											}

										?>
										<!--<option value="I">I</option>
										<option value="II">II</option>
										<option value="III">III</option>-->
									</select>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-check">
									<?php 	$chekde = ''; 
									if ($enc[0]["ESPECIAL"]) {
										$chekde = 'checked';
									} ?>
								  <input <?php 	echo $chekde; ?> class="form-check-input" type="checkbox" value="" id="chkEspecial">
								  <label class="form-check-label" for="chkEspecial">
								  	Nivel Especial
								  </label>
								</div>
							</div>		
							<?php 	$chekde = 'invisible'; 
									if ($enc[0]["ESPECIAL"]) {
										$chekde = '';
									} ?>					
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-3 especial <?php 	echo $chekde; ?>">
								<div class="form-group has-feedback">
									<label for="vigencia">Nivel Inspeccion Especial</label>
									<select id="cmdNivel2" class="form-control select2" style="width: 100%;">
										<option></option>										
										<option value="S1">S1</option>
										<option value="S2">S2</option>
										<option value="S3">S3</option>
										<option value="S4">S4</option>
									</select>
							</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Muestra</label>
									<input readonly="true" autocomplete="off" type="text" id="muestra" value="<?php echo intval($enc[0]["MUESTRA"]) ?>" class="form-control">
									<span class="fa fa-truck form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Diametro</label>
									<input autocomplete="off" type="text" id="txtPeso" class="form-control">
									<span class="fa fa-truck form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">monitoreado por</label>
									<input readonly="" value="<?php echo $this->session->userdata("nombre")." ".$this->session->userdata("apellidos")?>" autocomplete="off" type="text" id="monituser" class="form-control bg-info" placeholder="monitoreado por">
									<span class="fa fa-user form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xd-12 col-sm-12 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									
									<button id="btnAdd" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i></button>
									
									<button id="btnDelete" class="btn btn-danger btn-lg"><i class="fa fa-trash"></i></button>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div style="width: 100%; overflow-y: scroll;">
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