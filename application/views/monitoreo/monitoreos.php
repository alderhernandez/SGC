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
			Monitoreos Diarios
			<button class="pull-right btn btn-primary" data-toggle="modal" id="btnModal">
				Agregar <i class="fa fa-plus"></i>
			</button>			
		</h1>		
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
							<th>Fecha Inicio</th>
							<th>Fecha Fin</th>
							<th>Fecha Crea</th>
							<th>Usuario</th>
							<th>Estado</th>						
						</tr>
					</thead>
					<tbody>
					    <?php
						$estado = '';
							if(!$monitoreos){
							}else{
								foreach ($monitoreos as $key) {
									switch ($key["ESTADO"]){
										case 'A':
												$estado = "<span class='text-success'><b>Activo</b></span>";
											break;
										default:
											    $estado = "<span class='text-danger'><b>Inactivo</b></span>";
											break;
									}

									echo "
									<tr>
									  <td>".$key["SIGLA"]."</td>
									  <td>".$key["DIA"]."</td>
									  <td>".$key["FECHAINICIO"]."</td>
									  <td>".$key["FECHAFIN"]."</td>
									  <td>".$key["FECHACREA"]."</td>
									  <td>".$key["USUARIO"]."</td>
									  <td>".$estado."</td>									
									</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>			
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
			<div class="modal-body text-center">
				<h4>¿Desea Crear Consecutivo de Monitero?</h4>
			</div>
			<div class="modal-footer">
				<button id="btnGuardar" type="button" class="btn btn-primary">Si</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>				
			</div>
		</div>
	</div>
</div>
