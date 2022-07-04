<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 22/4/2019 15:14 2019
 * FileName: roles.php
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
				<h3 class="box-title">Lista de Roles</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i></button>
					<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fa fa-times"></i></button>-->
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered table-condensed table-striped" id="tblRoles">
					<thead>
						<tr>
							<th>Rol</th>
							<th>Descripción</th>
							<th>Fecha Creación</th>
							<th>Fecha Edición</th>
							<th>Fecha Baja</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
					    <?php
						$estado = '';
							if(!$roles){
							}else{
								foreach ($roles as $key) {
									switch ($key["ESTADO"]){
										case 1:
												$estado = "<span class='text-success'><b>Activo</b></span>";
											break;
										default:
											    $estado = "<span class='text-danger'><b>Inactivo</b></span>";
											break;
									}

									echo "
									<tr>
									  <td>".$key["NOMBRE_ROL"]."</td>
									  <td>".$key["DESCRIPCION"]."</td>
									  <td>".$key["FECHACREA"]."</td>
									  <td>".$key["FECHAEDITA"]."</td>
									  <td>".$key["FECHABAJA"]."</td>
									  <td>".$estado."</td>
									  <td class='text-center'>";
									  	  if($key["ESTADO"] == 1){
											echo "
												<a onclick='EditarRol(".'"'.$key["IDROL"].'","'.$key["NOMBRE_ROL"].'","'.$key["DESCRIPCION"].'"'.")'
											   href='javascript:void(0)' class='btn btn-info btn-xs'>
											   <i class='fa fa-edit'></i></a>
											  <a onclick='darDeBaja(".'"'.$key["IDROL"].'","'.$key["ESTADO"].'"'.")' href='javascript:void(0)' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></a>
											";
										  }else{
											echo "
									  	 	  <a onclick='darDeBaja(".'"'.$key["IDROL"].'","'.$key["ESTADO"].'"'.")' href='javascript:void(0)' class='btn btn-danger btn-xs'><i class='fa fa-refresh'></i></a>
											";
										  }
									  echo"</td>
									</tr>";
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


<div class="modal fade" id="modalRoles" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-users"></i> <span id="modalEncabezado"></span></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="idRol" class="form-control">
					<div class="col-xs-6">
						<div class="form-group has-feedback">
							<label for="comment">Nombre del Rol</label>
							<input type="text" id="rol" class="form-control" placeholder="Nombre del Rol">
							<span class="fa fa-users form-control-feedback"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group has-feedback">
							<label for="comment">Descripcion:</label>
							<textarea class="form-control" rows="5" id="comment"></textarea>
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
