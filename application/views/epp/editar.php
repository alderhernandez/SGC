
<div class="content-wrapper">
	<section class="content-header">
		<h3 class="text-center">
			INDUSTRIAS DELMOR, S.A.
		</h3>
		<h4 class="text-center">
			<span id="nombreRpt">EDICIÓN</span>
		</h4>
		<h4 class="text-center">
			
		</h4>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
				<a class="btn-flat" href="javascript:history.back()">
					<i class="fa fa-arrow-circle-left fa-2x"></i>
				</a>
				<!--<button class="pull-right btn btn-primary" id="btnGuardar">
					Guardar <i class="fa fa-save"></i>
				</button>-->
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
						<div class="form-group has-feedback">
							<label for="vigencia">Fecha</label>
							<input autocomplete="off" type="date" disabled  id="fecha" value="<?php echo $enc[0]["Fecha"]; ?>"  class="form-control">							
						</div>
					</div>
					<div class="col-xd-12 col-sm-3 col-md-2 col-lg-2">
						<div class="form-group">
							<label>Empleado</label>
							<input autocomplete="off" disabled type="text" id="empleado" value ="<?php echo $enc[0]["Nombre"]; ?>" class="form-control" >
						</div>
					</div>
					<!--<div class="col-xd-12 col-sm-3 col-md-6 col-lg-3">
						<div class="form-group">
							<label>seleccione un Artículo*</label>
							<select id="selectArticulos"  class="form-control select2" style="width: 100%;">								
								<?php
								if(!$articulos){
								}else{
									foreach ($articulos as $key) {
										echo "
										<option value='".$key["Id"]."'>".$key["Descripcion"]."</option>
										";
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-xd-12 col-sm-3 col-md-2 col-lg-2">
						<div class="form-group">
							<label>Cantidad</label>
							<input autocomplete="off" type="number" id="cantidad" class="form-control" placeholder="Ingrese una cantidad">
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
						<div class="form-group has-feedback">
							<label for=""> </label>
							<button id="btnAdd" class="btn btn-primary btn-md"><i class="fa fa-plus"></i></button>
							<label for=""> </label>
							<button id="btnDelete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></button>
						</div>
					</div>-->
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
							<div class="form-group has-feedback">
								<label for="">Creado por</label>
								<input readonly="" value="<?php echo $enc[0]["Nombres"]." ".$enc[0]["Apellidos"];?>" autocomplete="off" type="text" id="monituser" class="form-control bg-info" placeholder="monitoreado por">
								<span class="fa fa-user form-control-feedback"></span>
							</div>
						</div>
					</div>
				</div>

				<table class="table table-bordered table-condensed table-striped" id="tblDatos">
					<thead>
						<tr>							
							<th class="text-center">CANTIDAD</th>
							<th class="text-center">ID</th>
							<th class="text-center">ARTÍCULO</th>
							
						</tr>
					</thead>
					<tbody class="text-center">
						<?php 
						$estado = '';
							if(isset($datos) && !$datos){
							}else{
								foreach ($datos as $key) {
									echo "
										<tr>
											<td>".$key["Id"]."</td>
											<td>".$key["IdArticulo"]."</td>											
											<td>".$key["Descripcion"]."</td>";											
									echo"</tr>";
								}
							}
						?>
					</tbody>
				</table>
				<div class="row" style="margin-top:30px;">
					<div class="col-lg-12 text-center">
						<h3>Firma ingresada:</h3>	
						<img src="<?php echo $enc[0]["Firma"]; ?>" class="rounded mx-auto d-block" alt="..." style="border: 1px solid black; border-radius: 7px 7px 7px 7px">						
					</div>					
				</div>				
			</div>
		</div>
	</section>
</div>

<div class="modal" id="loading" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content" style="background-color:transparent;box-shadow: none; border: none;margin-top: 26vh;">
			<div class="text-center">
				<img width="130px" src="<?php echo base_url()?>assets/img/loading.gif">
			</div>
		</div>
	</div>
</div>
