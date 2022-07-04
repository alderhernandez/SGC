<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 22/4/2019 15:14 2019
 * FileName: menu.php
 */
?>
<div class="wrapper">

	<header class="main-header">
		<!-- Logo -->
		<a href="" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><b>SGC</b></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>SGC</b></span>
		</a>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- Messages: style can be found in dropdown.less-->
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-envelope-o"></i>
							<span class="label label-success">4</span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">You have 4 messages</li>
							<li>
								<!-- inner menu: contains the actual data -->
								<ul class="menu">
									<li><!-- start message -->
										<a href="#">
											<div class="pull-left">
												<img src="<?PHP echo base_url();?>assets/img/user2.png" class="img-circle" alt="User Image">
											</div>
											<h4>
												Support Team
												<small><i class="fa fa-clock-o"></i> 5 mins</small>
											</h4>
											<p>Why not buy a new awesome theme?</p>
										</a>
									</li>
									<!-- end message -->
								</ul>
							</li>
							<li class="footer"><a href="#">See All Messages</a></li>
						</ul>
					</li>
					<!-- Notifications: style can be found in dropdown.less -->
					<li class="dropdown notifications-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-bell-o"></i>
							<span class="label label-warning">10</span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">You have 10 notifications</li>
							<li>
								<!-- inner menu: contains the actual data -->
								<ul class="menu">
									<li>
										<a href="#">
											<i class="fa fa-users text-aqua"></i> 5 new members joined today
										</a>
									</li>
								</ul>
							</li>
							<li class="footer"><a href="#">View all</a></li>
						</ul>
					</li>
					<!-- Tasks: style can be found in dropdown.less -->
					<li class="dropdown tasks-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-flag-o"></i>
							<span class="label label-danger">9</span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">You have 9 tasks</li>
							<li>
								<!-- inner menu: contains the actual data -->
								<ul class="menu">
									<li><!-- Task item -->
										<a href="#">
											<h3>
												Design some buttons
												<small class="pull-right">20%</small>
											</h3>
											<div class="progress xs">
												<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
													<span class="sr-only">20% Complete</span>
												</div>
											</div>
										</a>
									</li>
									<!-- end task item -->
								</ul>
							</li>
							<li class="footer">
								<a href="#">View all tasks</a>
							</li>
						</ul>
					</li>
					<!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php
							$img = '';
							if ($this->session->userdata("sexo") == 1) {
								$img = 'user2.png';
							}else{
								$img = 'female.jpg';
							}
							echo "<img src='".base_url()."/assets/img/".$img."' alt='".$this->session->userdata('user')."'
						  class='user-image'/>";
							?>

							<span class="hidden-xs">
								<?php echo $this->session->userdata('user');?>
							</span>
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header">
								<?php
								$img = '';
								if ($this->session->userdata("sexo") == 1) {
									$img = 'user2.png';
								}else{
									$img = 'female.jpg';
								}
									echo "<img src='".base_url()."/assets/img/".$img."' alt='".$this->session->userdata('user')."'
						  			class='img-circle'/>";
								?>

								<p>
									<?php echo $this->session->userdata('user');?>
									<small><?php echo $this->session->userdata('rol');?></small>
								</p>
							</li>
							<!-- Menu Body -->
							<!--<li class="user-body">
								<div class="row">
									<div class="col-xs-4 text-center">
										<a href="#">Followers</a>
									</div>
									<div class="col-xs-4 text-center">
										<a href="#">Sales</a>
									</div>
									<div class="col-xs-4 text-center">
										<a href="#">Friends</a>
									</div>
								</div>
							</li> -->
							<!-- Menu Footer-->
							<li class="user-footer" style="box-shadow:#1e282c 2px 2px 2px">
								<div class="pull-left">
									<a href="<?php echo base_url("index.php/Perfil")?>" class="btn btn-default btn-flat">Perfil</a>
								</div>
								<div class="pull-right">
									<a href="<?php echo base_url("index.php/cerrarSesion")?>" class="btn btn-default btn-flat">Finalizar Sesión</a>
								</div>
							</li>
						</ul>
					</li>
					<!-- Control Sidebar Toggle Button
					<li>
						<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
					</li>-->
				</ul>
			</div>
		</nav>
	</header>

	<!-- =============================================== -->

	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">

			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
				<li class="header">Menu principal</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-key"></i> <span>Autorizaciones</span>
						<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="<?php echo base_url("index.php/CategoriasAut")?>">
								<i class="fa fa-circle-o text-warning"></i> Crear Categorias
							</a>
						</li>
						<li><a href="<?php echo base_url("index.php/Permisos")?>"><i class="fa fa-circle-o text-warning"></i> Crear Permisos</a></li>
						<li><a href="<?php echo base_url("index.php/Asignar_Permiso")?>"><i class="fa fa-circle-o text-warning"></i> Asignar Permisos</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-users"></i> <span>Usuarios</span>
						<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="<?php echo base_url("index.php/Roles")?>">
								<i class="fa fa-circle-o text-warning"></i> Roles
							</a>
						</li>
						<li><a href="<?php echo base_url("index.php/Perfil")?>"><i class="fa fa-circle-o text-warning"></i> Mi Perfil</a></li>
						<li><a href="<?php echo base_url("index.php/Usuarios")?>"><i class="fa fa-circle-o text-warning"></i> Crear y administrar usuarios</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-map-marker"></i>
						<span>Areas</span>
						<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
					</a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url("index.php/Areas")?>"><i class="fa fa-circle-o text-warning"></i> Crear y administrar áreas</a></li>
					</ul>
				</li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-sitemap"></i> <span>Maquinas</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url("index.php/Maquinas")?>"><i class="fa fa-circle-o text-warning"></i> Crear y administrar máquinas</a></li>
                    </ul>
                </li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-bookmark"></i>
						<span>Elementos</span>
						<span class="pull-right-container">
			              <i class="fa fa-angle-left pull-right"></i>
			            </span>
					</a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url("index.php/Simbologia")?>"><i class="fa fa-circle-o text-warning">
						</i> Simbología</a></li>
						<li><a href="<?php echo base_url("index.php/CatReportes")?>"><i class="fa fa-circle-o text-warning">
						</i> Categorias Reportes</a></li>
						<li><a href="<?php echo base_url("index.php/Informes")?>"><i class="fa fa-circle-o text-warning">
						</i> Informes</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-files-o"></i>
						<span>Monitoreos Diarios</span>
						<span class="pull-right-container">
			              <i class="fa fa-angle-left pull-right"></i>
			            </span>
					</a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url("index.php/monitoreos")?>"><i class="fa fa-circle-o text-warning"></i> Monitoreos</a></li>
						<li><a href="<?php echo base_url("index.php/CatReportes")?>"><i class="fa fa-circle-o text-warning">
						</i> Categorias Reportes</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-files-o"></i>
						<span>Reportes</span>
						<span class="pull-right-container">
			              <i class="fa fa-angle-left pull-right"></i>
			            </span>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="<?php echo base_url("index.php/reportePesoDiametro")?>">
								<i class="fa fa-circle-o text-warning"></i> Reporte Estudio de peso y Diametro</a>
						</li>
						<li>
							<a href="<?php echo base_url("index.php/reporteEnvases")?>">
								<i class="fa fa-circle-o text-warning"></i> Reporte Evaluación de envases doble cierre</a>
						</li>
					</ul>					
				</li>				
				<!--<li>
				<a href="../calendar.html">
						<i class="fa fa-folder"></i> <span>Calendar</span>
						<span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
					</a>
				</li>
				<li>
					<a href="../mailbox/mailbox.html">
						<i class="fa fa-envelope"></i> <span>Mailbox</span>
						<span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
					</a>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-folder"></i> <span>Examples</span>
						<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
					</a>
					<ul class="treeview-menu">
						<li><a href="../examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
						<li><a href="../examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
						<li><a href="../examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
						<li><a href="../examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
						<li><a href="../examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
						<li><a href="../examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
						<li><a href="../examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
						<li><a href="../examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
						<li><a href="../examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-share"></i> <span>Multilevel</span>
						<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
					</a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
						<li class="treeview">
							<a href="#"><i class="fa fa-circle-o"></i> Level One
								<span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
							</a>
							<ul class="treeview-menu">
								<li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
								<li class="treeview">
									<a href="#"><i class="fa fa-circle-o"></i> Level Two
										<span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
									</a>
									<ul class="treeview-menu">
										<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
										<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
					</ul>
				</li>
				<li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
				<li class="header">LABELS</li>
				<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
				<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
				<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- =============================================== -->



