
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center">
			INDUSTRIAS DELMOR, S.A.
		</h3>
		<h4 class="text-center">
			<span id="nombreRpt">CONTROL DE TEMPERATURAS DE CONTENEDORES EXTERNOS (CTCE)</span>
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
				<button class="pull-right btn btn-primary" id="btnGuardar">
					Guardar <i class="fa fa-save"></i>
				</button>
			</div>
			<div class="box-body">
					<div class="row">
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
								<div class="form-group has-feedback">
									<label for="vigencia">Fecha</label>
									<input autocomplete="off"  type="text" id="fecha" value="<?php echo $enc[0]["FECHACREA"] ?>"  class="form-control" placeholder="Fecha ingreso">
									<span class="fa fa-calendar form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
								<div class="form-group has-feedback">
									<label for="vigencia">Observacion general</label>
									<input autocomplete="off" type="text" id="observacionGeneral" value="<?php echo $enc[0]["OBSERVACIONES"] ?>"  class="form-control" placeholder="Observaciones">
									<span class="fa fa-pencil form-control-feedback"></span>
								</div>
							</div>
						<!--</div>-->
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">monitoreado por</label>
									<input readonly="" value="<?php echo $this->session->userdata("nombre")." ".$this->session->userdata("apellidos")?>" autocomplete="off" type="text" id="monituser" class="form-control bg-info" placeholder="monitoreado por">
									<span class="fa fa-user form-control-feedback"></span>
								</div>
							</div>
						</div>
					</div>
				<table class="table table-bordered table-condensed table-striped" id="tblDatos">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Contenedores</th>
							<th class="text-center">7:00 am</th>
							<th class="text-center">11:00 am</th>
							<th class="text-center">3:00 pm</th>
							<th class="text-center">Observaciones</th>
							<th class="text-center">Verificación de A/C</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php
							if(!$det)
							{}else{
								foreach ($det as $key) {
									echo "<tr>
										<td>".$key["IDCONTENEDOR"]."</td>
											<td class='text-bold'>".$key["NOMBRE"]." ".$key["COMENTARIO"]."</td>
											<td><input id='1toma-".$key["IDCONTENEDOR"]."' value='".number_format($key["TOMA1"],0)."' class='contenedor numeric' type='text'></td>
											<td><input id='2toma-".$key["IDCONTENEDOR"]."' value='".number_format($key["TOMA2"],0)."' class='contenedor numeric' type='text'></td>
											<td><input id='3toma-".$key["IDCONTENEDOR"]."' value='".number_format($key["TOMA3"],0)."' class='contenedor numeric' type='text'></td>
											<td><textarea id='observacion-".$key["IDCONTENEDOR"]."' class='contenedor' style='resize: none;' rows='1'></textarea></td>
											<td><textarea id='verificacion-".$key["IDCONTENEDOR"]."' class='contenedor' style='resize: none;' rows='1'></textarea></td>";
									echo "</tr>";
								}
							}
						?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-lg-12">
						<table>
							<thead>
								<tr>
									<th>contenedores Externos</th>
									<th>Parametros de Control</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Contenedores # 01-14</td>
									<td>-18º a -24 Cº</td>
								</tr>
							</tbody>
						</table>
					</div>
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
