
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center">
			INDUSTRIAS DELMOR, S.A.
		</h3>
		<h4 class="text-center">
			<?php $texto = 'SALIDA';

				if ($tipo == 2) {
					$texto = 'ENTRADA';
				}
			 ?>
			<span id="nombreRpt">CREACION DE <?php echo $texto ?> EPP </span>
		</h4>
		<h4 class="text-center">
			
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
							<input autocomplete="off" type="date"  id="fecha" value="<?php echo date ('Y-m-d') ?>"  class="form-control" placeholder="Fecha ingreso">							
						</div>
					</div>
					<div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
						<div class="form-group has-feedback">							
							<label>Buscar empleado*</label>							
							<select class="js-data-example-ajax form-control" id="selectEmpleados"></select>							
						</div>
					</div>					
					<div class="col-xd-12 col-sm-3 col-md-6 col-lg-3">
						<div class="form-group">
							<label>Artículo*</label>
							<select id="selectArticulos"  class="form-control select2" style="width: 100%;">								
								<?php
								if(!$articulos){
								}else{
									echo "
										<option value=''>Seleccione un artículo</option>";
									foreach ($articulos as $key) {
										
										echo "
										<option value='".$key["Id"]."'>".$key["Descripcion"]."</option>
										";
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-xd-12 col-sm-3 col-md-2 col-lg-2">
						<div class="form-group">
							<label>Cantidad</label>
							<input autocomplete="off" type="number" id="cantidad" class="form-control" placeholder="Ingrese una cantidad">
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
						<div class="form-group has-feedback">
							<label for=""> </label>
							<button id="btnAdd" class="btn btn-primary btn-md"><i class="fa fa-plus"></i></button>
							<label for=""> </label>
							<button id="btnDelete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
							<div class="form-group has-feedback">
								<label for="">Creado por</label>
								<input readonly="" value="<?php echo $this->session->userdata("nombre")." ".$this->session->userdata("apellidos")?>" autocomplete="off" type="text" id="monituser" class="form-control bg-info" placeholder="monitoreado por">
								<span class="fa fa-user form-control-feedback"></span>
							</div>
						</div>
					</div>
				</div>

				<table class="table table-bordered table-condensed table-striped" id="tblDatos">
					<thead>
						<tr>							
							<th class="text-center">CANTIDAD</th>
							<th class="text-center">ID</th>
							<th class="text-center">ARTÍCULO</th>							
						</tr>
					</thead>
					<tbody class="text-center">					
					</tbody>
				</table>
				<div class="row" style="margin-top:30px;">
					<div class="col-lg-12 text-center">
						<h3>Firma:</h3>						   
						<canvas id="draw-canvas" width="620" height="360"  style="border: 2px solid black; border-radius: 10px;">
							No tienes un buen navegador.
						</canvas>
					</div>					
				</div>
				<div class="row">
					<div class="col-lg-12 text-center">
						<button class=" btn btn-primary" id="draw-clearBtn">
							Limpiar <i class="fa fa-clear"></i>
						</button>
						<button style="display:none" class="d-none btn btn-primary" id="draw-submitBtn">
							clearBtn <i class="fa fa-clear"></i>
						</button>
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
