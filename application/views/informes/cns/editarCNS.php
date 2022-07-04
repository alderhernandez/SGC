<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-19 14:11:22
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-20 15:53:52
 */
?>
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center"> 
			INDUSTRIAS DELMOR, S.A.
			<!--<small>Blank example to the fixed layout</small>-->
		</h3>
		<h4 class="text-center">
			<?php
			$nombre = '';
				if(!$monit){
				}else{
					foreach ($monit as $key) {
						$nombre = $key["NOMBRE"];
					}
					echo '<span id="nombreRpt">'.$nombre.'</span>';
				}
			?>
			
		</h4>
		<h4 class="text-center">
            <?php
            if(!$version){
            }else{
                echo $version;
            }
            ?>
			<?php
			$siglas = ''; $id = '';
				if(!$monit){
				}else{
					foreach ($monit as $key) {
						$id = $key["IDREPORTE"];
					}
					echo '<div class="form-group has-feedback">
								<input type="hidden" id="idreporte" class="form-control" value="'.$id.'">
							</div>';
				}
			?>
		</h4>	
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
				   <button class="pull-right btn btn-primary" id="btnActualizar">
						Actualizar <i class="fa fa-save"></i>
					</button>
				<div class="box-tools pull-right">
					
					<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fa fa-times"></i></button>-->
				</div>
			</div>
			<div class="box-body">
				<div>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
								<div class="form-group">
									<label>Area</label>
									<select id="ddlAreas" class="form-control select2" style="width: 100%;">
										<?php
											$nombre = ''; $id= '';
												if(!$monit){
												}else{
													foreach ($monit as $key) {
														$id = $key["ID_AREA"];
														$nombre = $key["AREA"];
													}
													echo "
														<option selected value='".$id."'>".$nombre."</option>
													";
												}
											?>
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
							<div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
									<div class="form-group has-feedback">
										<?php
											$version = '';
												if(!$monit){
												}else{
													foreach ($monit as $key) {
														$version = $key["VERSION"];
													}
													echo '
													<label for="vigencia">Version</label>
													<input autocomplete="off" type="text" id="version" class="form-control" value="'.$version.'">
													<span class="fa fa-code-fork form-control-feedback"></span>';
												}
											?>
									</div>
								</div>
								<div class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
									<div class="form-group has-feedback">
										<?php
											$observ = ''; 
												if(!$monit){
												}else{
													foreach ($monit as $key) {
														$observ = $key["OBSERVACIONES"];
													}
													echo '
														<label for="vigencia">Observaciones</label>
														<input autocomplete="off" type="text" id="observaciones" class="form-control" value="'.$observ.'">
														<span class="fa fa-pencil form-control-feedback"></span>
													';
												}
											?>
									</div>
								</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
								<div class="form-group has-feedback">
									<label for="vigencia">Fecha ingreso</label>
									<input autocomplete="off" type="text" id="fecha" class="form-control" placeholder="Fecha ingreso">
									<span class="fa fa-calendar form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Cantidad nitrito s.</label>
									<input autofocus="" autocomplete="off" type="text" id="nitrito" class="form-control" placeholder="cantidad nitrito">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Cantidad nitrito u.</label>
									<input autofocus="" autocomplete="off" type="text" id="nitrito2" class="form-control" placeholder="cantidad nitrito">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="form-group has-feedback">
									<label for="">Cantidad kg.</label>
									<input autofocus="" autocomplete="off" type="text" id="kg" class="form-control col-xs-4" placeholder="cantidad Kg">
									<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
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
				<table class="table table-bordered table-condensed table-striped" id="tblcrear">
					<thead>
						<tr>
							<th class="text-center">Fecha de ingreso <br>a premezcla</th>
							<th class="text-center">Canitdad de nitrito <br>solicitado</th>
							Ç<th class="text-center">Canitdad de nitrito <br>utilizado</th>
							<th class="text-center">Cantidad Kg. <br>sal de cura obtenida</th>
							<th class="text-center">Monitoreado por</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php
						$nombre = ''; $id= '';
							if(!$monit){
							}else{
							   foreach ($monit as $key) {
								   echo "<tr>
										<td>".$key["FECHAINGRESO"]."</td>
										<td>".$key["CANTIDADNITRITO"]."</td>
										<td>".$key["CANTIDADNITRITOU"]."</td>
										<td>".$key["CANTIDADKG"]."</td>
										<td>".$this->session->userdata("nombre")." ".$this->session->userdata("apellidos")."</td>
								   </tr>";
								}
							}
						?>					
					</tbody>
				</table>
			</div>
			
			<div class="box-footer">
				<p class="callout">21,336 gr de Sal Común + 1,362 gr Nitrito / 1 Batch (Total Sal Cura: 22,698 gr) <br>
				   10,668 gr de Sal Común + 681 gr Nitrito / 0,5 Batch (Total Sal Cura 11,349 gr)</p>
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