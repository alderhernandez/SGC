
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center">
			INDUSTRIAS DELMOR, S.A.
		</h3>
		<h4 class="text-center">
			<span id="nombreRpt">EDITAR ARTÍCULO</span>
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
					<div class="col-xd-12 col-sm-12 col-md-4 col-lg-4">
						<div class="form-group">
							<label>Descripción</label>
							<input autocomplete="off" type="text" id="descripcion" value ="<?php echo $enc[0]["Descripcion"]; ?>" class="form-control" >
						</div>
					</div>					
				</div>
				<div class="row">
					
						<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
							<div class="form-group has-feedback">
								<label for="">Editado por el usuario actual</label>
								<input readonly="" value="<?php echo $this->session->userdata("nombre")." ".$this->session->userdata("apellidos")?>" autocomplete="off" type="text" id="monituser" class="form-control bg-info" placeholder="monitoreado por">
								<span class="fa fa-user form-control-feedback"></span>
							</div>
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
