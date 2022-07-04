<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 25/4/2019 14:48 2019
 * FileName: usuarios.php
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
				<h3 class="box-title">Lista de Usuarios</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i></button>
					<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fa fa-times"></i></button>-->
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered table-condensed table-striped" id="tblUsuarios">
					<thead>
					<tr>
						<th>Rol</th>
						<th>Usuario</th>
						<th>Nombre</th>
						<th>Correo</th>
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
							if(!$usuarios){
							}else{
								foreach ($usuarios as $key)
								{
									switch ($key["ESTADO"]){
										case 0:
											$estado = '<span class="text-danger"><b>Inactivo</b></span>';
											break;
										case 1:
											$estado = '<span class="text-success"><b>Activo</b></span>';
											break;
									}
									echo "
										<tr>
											<td>".$key["NOMBRE_ROL"]."</td>
											<td>".$key["NOMBREUSUARIO"]."</td>
											<td>".$key["NOMBRES"]." ".$key["APELLIDOS"]."</td>
											<td>".$key["CORREO"]."</td>
											<td>".date_format(new DateTime($key["FECHACREA"]), "Y-m-d")."</td>
											<td>".$key["FECHAEDITA"]."</td>
											<td>".$key["FECHABAJA"]."</td>
											<td>".$estado."</td>
											<td class='text-center'>
												<a onclick='Editar(".'"'.$key["IDUSUARIO"].'","'.$key["NOMBREUSUARIO"].'","'.$key["NOMBRES"].'",
												       "'.$key["APELLIDOS"].'","'.$key["CORREO"].'","'.$key["IDROL"].'",
												       "'.$key["NOMBRE_ROL"].'","'.$key["SEXO"].'"'.")'
												  href='javascript:void(0)' class='btn btn-primary btn-xs'>
												  <i class='fa fa-pencil'></i>
												</a>
												<a onclick='darDeBaja(".'"'.$key["IDUSUARIO"].'","'.$key["ESTADO"].'"'.")'
												 href='javascript:void(0)' class='btn btn-danger btn-xs'>
												  <i class='fa fa-trash'></i>
												</a>
											</td>
										</tr>
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


<div class="modal fade" id="modalUsuarios" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-user"></i> <span id="modalEncabezado"></span></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-6">
						<input autocomplete="off" type="hidden" id="Id" class="form-control">
						<div class="form-group has-feedback">
							<label for="usuario">Nombre de usuario</label>
							<input autocomplete="off" type="text" id="usuario" class="form-control" placeholder="Nombre de usuario">
							<span class="fa fa-user form-control-feedback"></span>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group has-feedback">
							<label for="nombre">Nombres</label>
							<input autocomplete="off" type="text" id="nombre" class="form-control" placeholder="Nombres">
							<span class="fa fa-pencil form-control-feedback"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group has-feedback">
							<label for="apellido">Apellidos</label>
							<input autocomplete="off" type="text" id="apellido" class="form-control" placeholder="Apellidos">
							<span class="fa fa-pencil-square form-control-feedback"></span>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group has-feedback">
							<label for="correo">Correo</label>
							<input autocomplete="off"  type="text" id="correo" class="form-control" placeholder="usuario@delmor.com.ni">
							<span class="fa fa-envelope form-control-feedback"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group has-feedback" id="formPass">
							<label for="password">Contraseña</label>
							<input autocomplete="off" type="password" id="password" class="form-control" placeholder="Contraseña">
							<span class="fa fa-lock form-control-feedback"></span>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group has-feedback" id="formConfPass">
							<label for="password">Confirmar Contraseña</label>
							<input autocomplete="off" type="password" id="confirmPass" class="form-control" placeholder="Contraseña">
							<span class="fa fa-lock form-control-feedback"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label>Rol</label>
							<select id="roles" class="form-control select2" style="width: 100%;">
								<option></option>
								<?php
								if(!$roles){
								}else{
									foreach ($roles as $key) {
										echo "
												<option value='".$key["IDROL"]."'>".$key["NOMBRE_ROL"]."</option>
											";
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-xs-6">
						<label for="">Sexo</label>
						<div class="row">
							<div class="col-xs-4">
								<div class="form-group">
									<div class="radio">
										<label>
											<input type="radio" name="sexo" id="M" value="1" checked="">
											Hombre
										</label>
									</div>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<div class="radio">
										<label>
											<input type="radio" name="sexo" id="F" value="2" checked="">
											Mujer
										</label>
									</div>
								</div>
							</div>
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

