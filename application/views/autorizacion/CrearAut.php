<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-06 11:15:30
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-07 13:44:31
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
				<h3 class="box-title">Lista de <?php echo $this->uri->segment(1)?></h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i>
					</button>
					<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fa fa-times"></i></button>-->
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered table-condensed table-striped" id="tblPermisos">
					<thead>
					<tr>
						<th>Cod <br> Autorizacion</th>
						<th>Descripción</th>
						<th>Modulo</th>
						<th>Categoría</th>
						<th>Fecha <br> Creacion</th>
						<th>Fecha <br> Actualiza</th>
						<th>Fecha <br> Baja</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
					</thead>
					<tbody>
						<?php
						$estado = '';
							if(!$auts){
							}else{
								foreach ($auts as $key) {
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
											<td>".$key["IDAUTORIZACION"]."</td>
											<td>".$key["DESCRIPCION"]."</td>
											<td>".$key["MODULO"]."</td>
											<td>".$key["CATEGORIA"]."</td>
											<td>".$key["FECHACREA"]."</td>
											<td>".$key["FECHAEDITA"]."</td>
											<td>".$key["FECHABAJA"]."</td>
											<td>".$estado."</td>";
											if($key["ESTADO"] == "A"){ //id,estado,fecha,desc
												echo "
													<td class='text-center'>
														<a onclick='editar(".'"'.$key["IDAUTORIZACION"].'","'.$key["MODULO"].'","'.$key["IDCATEGORIA"].'","'.$key["DESCRIPCION"].'"'.")' class='btn btn-primary btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-pencil'></i>
														</a>
														<a onclick='Baja(".'"'.$key["IDAUTORIZACION"].'","'.$key["ESTADO"].'","'.$key["FECHABAJA"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
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
														<a onclick='Baja(".'"'.$key["IDAUTORIZACION"].'","'.$key["ESTADO"].'","'.$key["FECHABAJA"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
														  <i class='fa fa-undo' aria-hidden='true'></i> 	
														</a>						
													</td>
												";
											}
											
									echo"</tr>";
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


<div class="modal fade" id="modalPermisos" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-key"></i> <span id="modalEncabezado"></span></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-6">
						<input autocomplete="off" type="hidden" id="idpermiso" class="form-control">
						<div class="form-group has-feedback">
							<label for="usuario">Módulo</label>
							<input autocomplete="off" type="text" id="modulo" class="form-control" placeholder="Escriba el nombre del módulo">
							<span class="fa fa-pencil form-control-feedback"></span>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label>Categoría</label>
							<select id="categorias" class="form-control select2" style="width: 100%;">
								<option></option>
								<?php
								if(!$cats){
								}else{
									foreach ($cats as $key) {
										echo "
												<option value='".$key["ID"]."'>".$key["DESCRIPCION"]."</option>
											";
									}
								}
								?>
							</select>
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