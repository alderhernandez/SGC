<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 17/5/2019 15:46 2019
 * FileName: Areas.php
 */
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<?php echo $this->uri->segment(1)?>
			<button class="pull-right btn btn-primary" data-toggle="modal" id="btnModal">
				Agregar <i class="fa fa-plus"></i>
			</button>
			<!--<small>Blank example to the fixed layout</small>-->
		</h1>
		<!--<ol class="breadcrumb">
			<li class="active"></li>
		</ol>-->
		<br>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Lista de Areas</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i>
					</button>
					<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fa fa-times"></i></button>-->
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered table-condensed table-striped" id="tblareas">
					<thead>
					<tr>
						<th>Area</th>
						<th>Siglas</th>
						<th>Fecha Creacion</th>
						<th>Usuario crea</th>
						<th>Fecha edicion</th>
						<th>Fecha Baja</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
					</thead>
					<tbody>
						<?php 
							if(!$lista){
							}else{
								$estado = '';
								foreach ($lista as $key) {
									switch ($key["ESTADO"]) {
										case 1:
											$estado = 	'<span class="text-success text-bold">Activo</span>';
											break;
										
										default:
											$estado = '<span class="text-danger text-bold">Inactivo</span>';
											break;
									}
									echo "
										<tr>
											<td>".$key["AREA"]."</td>
											<td>".$key["SIGLAS"]."</td>
											<td>".date_format(new DateTime($key["FECHACREA"]), "Y-m-d")."</td>
											<td>".$key["NOMBRES"]."</td>
											<td>".$key["FECHAEDITA"]."</td>
											<td>".$key["FECHABAJA"]."</td>
											<td>".$estado."</td>";
											if($key["ESTADO"] == 1){
												echo "
													<td class='text-center'>
														<a onclick='editar(".'"'.$key["IDAREA"].'","'.$key["AREA"].'","'.$key["SIGLAS"].'"'.")' class='btn btn-primary btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-pencil'></i>
														</a>
														<a onclick='baja(".'"'.$key["IDAREA"].'","'.$key["AREA"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-trash'></i> 	
														</a>						
													</td>
												";
											}else{
                                               echo "
													<td class='text-center'>
														<a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
														  <i class='fa fa-pencil'></i>
														</a>
														<a onclick='baja(".'"'.$key["IDAREA"].'","'.$key["AREA"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-undo' aria-hidden='true'></i> 	
														</a>						
													</td>
												";
											}
											
									echo"</tr>
									";
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<!-- /.box-body
			<div class="box-footer">
				Footer
			</div>-->
			<!-- /.box-footer-->
		</div>

	</section>
</div>


<div class="modal fade" id="modalAreas" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-map-marker"></i> <span id="modalEncabezado"></span></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-8">
						<input autocomplete="off" type="hidden" id="idarea" class="form-control">
						<div class="form-group has-feedback">
							<label for="usuario">Nombre área</label>
							<input autocomplete="off" type="text" id="area" class="form-control" placeholder="Nombre área">
							<span class="fa fa-map-marker form-control-feedback"></span>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="form-group has-feedback">
							<label for="vigencia">Siglas</label>
							<input autocomplete="off" type="text" id="siglas" class="form-control" placeholder="siglas">
							<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
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


