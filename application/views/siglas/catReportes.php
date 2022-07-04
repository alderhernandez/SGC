<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-09 10:54:32
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-12 09:38:47
 */
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Categorias de reportes
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
				<h3 class="box-title">Lista de Categorias de reportes</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i>
					</button>
					<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fa fa-times"></i></button>-->
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered table-condensed table-striped" id="tblsiglasRep">
					<thead>
					<tr>
						<th>Siglas</th>
						<th>Descripcion</th>
						<th>Fecha crea</th>
						<th>Fecha edita</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$estado = '';
						if(!$lista){
						}else{
							foreach ($lista as $key) {
								switch ($key["ESTADO"]) {
									case 'A':
										$estado = '<span class="text-success text-bold">Activo</span>';
										break;
									
									default:
										$estado = '<span class="text-danger text-bold">Inactivo</span>';
										break;
								}
								echo "
								 <tr>
									<td>".$key["SIGLA"]."</td>
									<td>".$key["NOMBRE"]."</td>
									<td>".date_format(new DateTime($key["FECHACREA"]),"Y-m-d")."</td>
									<td>".$key["FECHAEDITA"]."</td>
									<td>".$estado."</td>";
								         if($key["ESTADO"] == "A"){ //id,estado,sigla
												echo "
													<td class='text-center'>
														<a onclick='editar(".'"'.$key["IDTIPOREPORTE"].'","'.$key["SIGLA"].'","'.$key["NOMBRE"].'"'.")' class='btn btn-primary btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-pencil'></i>
														</a>
														<a onclick='Baja(".'"'.$key["IDTIPOREPORTE"].'","'.$key["ESTADO"].'","'.$key["SIGLA"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
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
														<a onclick='Baja(".'"'.$key["IDTIPOREPORTE"].'","'.$key["ESTADO"].'","'.$key["SIGLA"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-undo' aria-hidden='true'></i> 	
														</a>						
													</td>
												";
											}
								 echo "</tr>
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


<div class="modal fade" id="modalReport" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-cubes"></i> <span id="modalEncabezado"></span></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-5">
						<input autocomplete="off" type="hidden" id="idsiglas" class="form-control">
						<div class="form-group has-feedback">
							<label for="vigencia">Siglas</label>
							<input autofocus="" autocomplete="off" type="text" id="siglas" class="form-control" placeholder="siglas">
							<span class="fa fa-sort-alpha-desc form-control-feedback"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
		                  <label for="descripcion">Descripción</label>
		                  <textarea id="descripcion" class="form-control" rows="3" placeholder="Descripción"></textarea>
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