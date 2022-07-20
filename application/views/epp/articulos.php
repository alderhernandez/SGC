
<div class="content-wrapper">
	<section class="content-header">		
		<h1>
			CONTROL DE ARTICULOS EPP
			<a href="<?php echo base_url('index.php/crearArticulo') ?>" class="pull-right btn btn-primary" data-toggle="modal" id="btnModal">
				Crear <i class="fa fa-plus"></i>
			</a>
		</h1>		
		<br>
	<section class="content">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Administración de artículos</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i>
					</button>				
				</div>
			</div>		
			<div class="box-body">			
				<table class="table table-bordered table-condensed table-striped" id="tblcataut">
					<thead>
						<tr>
							<th>No</th>
							<th>Descripción</th>
							<th>Creado por</th>
							<th>Creado el</th>
							<th>Editado el</th>
							<th>Editado el</th>
							<th>Editado el</th>
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