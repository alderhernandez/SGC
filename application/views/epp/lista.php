
<div class="content-wrapper">
	<section class="content-header">
		<!--<h1>
			CONTROL DE EPP
			<a href="<?php echo base_url('index.php/crearSalida') ?>" class="pull-right btn btn-primary" data-toggle="modal" id="btnModal">
				Crear <i class="fa fa-plus"></i>
			</a>
		</h1>		
		<br>-->

		
		<!-- Main content -->
		<section class="content">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Creación de salidas</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
							<i class="fa fa-minus"></i>
						</button>				
					</div>
				</div>
				<div class="dropdown" style="padding-left: 25px;">
					<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Crear
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1" >
						<li><a href="<?php echo base_url('index.php/crearSalida/1') ?>">Salida</a></li>		
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url('index.php/crearSalida/2') ?>">Entrada</a></li>
					</ul>
				</div>
				<div class="box-body">
					<div class="col-xs-8 col-sm-6 col-md-6 col-lg-4">
						<div class="form-group has-feedback">							
							<label>Buscar empleado*</label>
							<select class="js-data-example-ajax form-control" id="selectEmpleados"></select>						
							
						</div>
					</div>	
					<div class="col-xd-12 col-sm-3 col-md-6 col-lg-2">
						<div class="form-group">
							<label>Seleccione un tipo*</label>
							<select id="selectTipo"  class="form-control select2" style="width: 100%;">
								<option selected value="">Seleccione opcional</option>
								<option value="1">Salida</option>
								<option value="2">Entrada</option>
							</select>
						</div>
					</div>
					<div class="col-xd-12 col-sm-3 col-md-6 col-lg-2">
						<div class="form-group">
							<label>Desde: </label>
							<input type="date" id="desde" class="form-control">

						</div>
					</div>
					<div class="col-xd-12 col-sm-3 col-md-6 col-lg-2">
						<div class="form-group">
							<label>Hasta: </label>
							<input type="date" id="hasta" class="form-control">
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
						<div class="form-group has-feedback mt-2" style="margin-top:25px">
							<label for=""></label>
							<button id="btnFiltrar" class="mt-2 btn btn-primary btn-md">Filtrar</button>
						</div>
					</div>
					<table class="table table-bordered table-condensed table-striped" id="tblcataut">
						<thead>
							<tr>
								<th>Tipo</th>
								<th>No</th>
								<th>Empleado</th>
								<th>Fecha Creacion</th>
								<th>Fecha Edición</th>						
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>

			</div>

		</section>
	</div>


	<div class="modal fade" id="modalCatAut" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="fa fa-cubes"></i> <span id="modalEncabezado"></span></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12">
								<input autocomplete="off" type="hidden" id="idcataut" class="form-control">
								<div class="form-group has-feedback">
									<label for="usuario">Categoría o Módulo</label>
									<input autocomplete="off" type="text" id="cataut" class="form-control" placeholder="Escriba el nombre de la categoría o módulo">
									<span class="fa fa-pencil form-control-feedback"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button id="btnGuardar" type="button" class="btn btn-primary">Guardar</button>
						<button id="btnActualizar" type="button" class="btn btn-primary">Actualizar</button>
					</div>
				</div>
			</div>
		</div>