<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 22/4/2019 11:13 2019
 * FileName: Login.php
 */
?>

<div class="login-box">
	<div class="login-logo">
		<b>SGC</b>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Sistema de Gestion de Calidad</p>

		<form action="<?php echo base_url('index.php/iniciarSesion')?>" method="post">
			<div class="form-group has-feedback">
				<input autocomplete="off" type="text" name="usuario" class="form-control" placeholder="Usuario">
				<span class="fa fa-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input autocomplete="off" type="password" name="password" class="form-control" placeholder="Contraseña">
				<span class="fa fa-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar Sesion</button>
				</div>
			</div>
		</form>

	</div>

	<br><br>

	<div class="social-auth-links text-center">
		<img src="<?PHP echo base_url();?>assets/img/LOGO.png" alt="">
		<br><br>
		<p>&copy; Todos los derechos reservados DELMOR <?php echo date("Y")?></p>
	</div>
</div>
