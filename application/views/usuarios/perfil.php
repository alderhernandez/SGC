<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 3/5/2019 15:09 2019
 * FileName: perfil.php
 */
?>

<div class="content-wrapper" style="min-height: 1126px;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $this->uri->segment(1)?>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-3">

				<!-- Profile Image -->
				<div class="box box-danger">
					<div class="box-body box-profile">
						<?php
						$img = '';
						if(!$usuarios){
						}else{
							foreach ($usuarios as $key){
							if ($key["SEXO"] == 1) {
								$img = 'user2.png';
							}else{
								$img = 'female.jpg';
							}
								echo "<img src='".base_url()."/assets/img/".$img."' alt='".$key['NOMBREUSUARIO']."'
							  	class='profile-user-img img-responsive img-circle'/>
							  	
							  	<h3 class='profile-username text-center'>
							".$key['NOMBREUSUARIO']."
						</h3>

						<p class='text-muted text-center'>".$key["NOMBRE_ROL"]."</p>
						<ul class='list-group list-group-unbordered'>
							<li class='list-group-item'>
								<strong><i class='fa fa-pencil margin-r-5'></i> ".$key["NOMBRES"]."</strong>
							</li>
							<li class='list-group-item'>
								<strong><i class='fa fa-pencil-square-o margin-r-5'></i> ".$key["APELLIDOS"]."</strong>
							</li>
							<li class='list-group-item'>
								<strong><i class='fa fa-envelope margin-r-5'></i> ".$key["CORREO"]."</strong>
							</li>
							<li class='list-group-item'>
								<strong><i class='fa fa-intersex scale margin-r-5'></i>";
									if($key["SEXO"] == 1){
										echo 'Hombre';
									}else{
										echo 'Mujer';
									}
						     echo "</strong>
							</li>
						</ul>";
							}
						}
						?>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-6">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs nav-tabs-justified">
						<li class="active"><a class="" href="#settings" data-toggle="tab">Información personal</a></li>
						<li><a href="#ChangePass" data-toggle="tab">Cambiar Contraseña</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="settings">
							<?php
							$checked = ""; $checked1 = ""; $readonly ="";
								if($this->session->userdata('idRol') > 2){
									$readonly = "readonly";
								}
								if(!$usuarios){
								}else{
									foreach ($key as $item) {
										if($key["SEXO"] === 1){
											$checked = "checked";
										}else{
											$checked1 = "checked";
										}
									}
									echo '
											<div class="form-horizontal">
												<div class="form-group">
												<input type="hidden" id="IdUser" class="form-control" value="'.$key["IDUSUARIO"].'">
													<label for="inputName" class="col-sm-2 control-label">Nombre</label>
				
													<div class="col-sm-10">
														<input id="nombre" '.$readonly.' value="'.$key["NOMBRES"].'" type="text" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label">Apellidos</label>
				
													<div class="col-sm-10">
													<input type="text" id="apellido" '.$readonly.' value="'.$key["APELLIDOS"].'" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-2 control-label">Rol</label>
				
													<div class="col-sm-10">
													<input type="text" '.$readonly.' value="'.$key["NOMBRE_ROL"].'" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label for="correo" class="col-sm-2 control-label">Correo</label>
				
													<div class="col-sm-10">
														<input id="correo" value="'.$key["CORREO"].'" type="text" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label for="username" class="col-sm-2 control-label">Usuario</label>
				
													<div class="col-sm-10">
														<input id="username" value="'.$key["NOMBREUSUARIO"].'" type="text" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-offset-2 col-sm-10">
														<div class="col-xs-4">
															<div class="form-group">
																<div class="radio">
																	<label>
																		<input type="radio" name="sexo" id="M" value="1" '.$checked.'>
																		Hombre
																	</label>
																</div>
															</div>
														</div>
														<div class="col-xs-4">
															<div class="form-group">
																<div class="radio">
																	<label>
																		<input type="radio" name="sexo" id="F" value="2" '.$checked1.'>
																		Mujer
																	</label>
																</div>
															</div>
														</div>
													</div>
												 </div>
												<div class="form-group">
													<div class="col-sm-offset-2 col-sm-10">
														<button id="btnActualizarInfo" type="button" class="btn btn-primary">Actualizar</button>
													</div>
												</div>
											</div>
										';
								}
							?>
						</div>
						<div class="tab-pane" id="ChangePass">
							<div class="form-horizontal">
								<div class="form-group">
									<label for="currentPass" class="col-sm-4 control-label">Contraseña actual</label>

									<div class="col-sm-8">
										<input type="password" class="form-control" id="currentPass" placeholder="">
									</div>
								</div>
								<div class="form-group newPass">
									<label for="newPass" class="col-sm-4 control-label ">Nueva Contraseña</label>

									<div class="col-sm-8">
										<input type="password" class="form-control" id="newPass" placeholder="">
									</div>
								</div>
								<div class="form-group confirmPass">
									<label for="confirmPass" class="col-sm-4 control-label">Confirmar Contraseña</label>

									<div class="col-sm-8">
										<input type="password" class="form-control" id="confirmPass" placeholder="">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-10">
										<button id="btnUpdPass" type="button" class="btn btn-primary">Actualizar</button>
									</div>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.nav-tabs-custom -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

	</section>
	<!-- /.content -->
</div>
