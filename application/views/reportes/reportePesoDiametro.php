
<div id="containerExport">
<div name="CMKPI" class="content-wrapper">
	<section class="content-header">
		<h1>
			Estudio de Peso y Diametro
		</h1>		
		<br>
	</section>
	<!-- Main content -->
	<section id="GroupFormDatos" class="content">
		<div class="GroupFormDatos">
			<div class="box box-danger">
				<div class="box-header with-border">
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
							<i class="fa fa-minus"></i></button>
					</div>
					<div class="col-xs-12">
	                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
	                            <div class="form-group has-feedback">
	                                <label for="version">Lote</label>
	                                <input autocomplete="off" type="text" id="idlote" value="" class="form-control" placeholder="Lote">
	                                <span class="fa fa-code-fork form-control-feedback"></span>
	                            </div>
	                        </div>                        
	                        <div class="col-xs-4 col-sm-6 col-md-6 col-lg-4">
	                        	<div class="form-group has-feedback">
		                                    <label>Nombre del producto</label><br>
		                            <select class="js-data-example-ajax form-control" id="codigo"></select>
		                      	</div>                      	
	                    	</div>
	                    	<div class="col-xs-4 col-sm-6 col-md-6 col-lg-3">
	                        	<div class="form-group has-feedback">
		                            <label>Tipo</label><br>
		                            <select id="tipoReporte" class="form-control">
									  <option value="1">Peso</option>
									  <option value="2">Diametro</option>								  
									</select>
		                      	</div>                      	
	                    	</div>
	                    	<div class="col-xs-4 col-sm-6 col-md-6 col-lg-3">
	                        	<div class="form-group form-check">
								    <input type="checkbox" checked class="form-check-input" id="exampleCheck1">
								    <label class="form-check-label" for="exampleCheck1">Mostrar tabla</label>
								  </div>
	                    	</div>
	                    	<div class="col-xs-4 col-sm-6 col-md-6 col-lg-2">
	                    		<div class="form-group has-feedback">
			                      	<button class="mt-2 pull-left btn btn-primary" id="btnFiltrar">
										Filtrar <i class="fa fa-save"></i>
									</button>
									<!--<button onclick="print(containerExport)" style="padding: 5px 10px; border-radius: 1.5rem;">Exportar PDF<i class="print"></i></button>-->

									<button onclick="printImagen()" class="mt-2 pull-right btn btn-success">PDF <i class="print"><i class="fa fa-file-pdf-o"></i></button>
								</div>
							</div>
	                </div>
				</div>						
			</div>
			<div id="exportar" style="background-color: #ffffff;">
				<div class="box-body" style="overflow-y: scroll;">
					<table class="table table-bordered table-condensed table-striped w-100" id="tabla" >
						<thead>
							<tr class="text-center">
								<th>CODIGO</th>
								<th>NOMBRE</th>
								<th>LOTE</th>
								<th>DIAMETRO UTILIZADO</th>
								<th>DIAMETRO ESPERADO</th>
								<th>FUNDA DIAMETRO</th>
								<th>FUNDA LARGO</th>
								<th>FUNDA PESO ESPERADO</th>
								<th>PESO PROMEDIO</th>
								<th>VARIABILIDAD ±3</th>
								<th>MAQUINA</th>
								<th>TAMAÑO MUESTRA</th>
								<th>PESO EXACTO</th>
								<th>DEBAJO DEL LIMITE</th>
								<th>ENCIMA DEL LIMITE</th>
								<th>EN RANGO</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div id="ocultar" class="box-body" style="overflow-y: scroll;">
					<div class="row text-center">
						<h3><strong>Pesos detallados</strong></h3><br>
					</div>
					<table class="table table-bordered table-condensed table-striped w-100" id="tablaPesos" >
						<thead>
							<tr class="text-center">
								<th>CODIGO</th>
								<th>DESCRIPCION</th>
								<th>PESO</th>
								<th>DIFERENCIA</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class="row">
					<div id="canvas2" style="width:100%;">
						<canvas  id="canvas"></canvas>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<div style="width:100%;">
						<canvas style="width:100%;" id="canvasAceptables"></canvas>
					</div>
					</div>
					<div class="col-lg-4">
						<div style="width:100%;">
						<canvas style="width:100%;" id="canvasDebajo"></canvas>
					</div>
					</div>
					<div class="col-lg-4">
						<div style="width:100%;">
						<canvas style="width:100%;" id="canvasEncima"></canvas>
					</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	
</div>
</div>

 <div class="modal fade" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Exportar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    	<div tyle="border:solid 1px #808080">
			<select id="mode" hidden>
				<option value="avoid-all">Avoid-all</option>
				<option value="css">CSS</option>
				<option value="legacy">Legacy</option>
				<option value="specify">Specified elements (using before/after/avoid)</option>
			</select>              
			<!-- Button to generate PDF. -->
			<button class="Wbtn btn_secundary" onclick="test()">Generar PDF</button>                            
			<!--<a href="#" class="Wbtn btn_secundary" onclick="excelExport('InformeContainer', this)">Generar Excel</a>-->
			<!--<a href="#" class="Wbtn btn_secundary" onclick="modalFunction('modalPrint')">Cerrar</a>-->
		</div>

		<div id="InformeContainer" class="informeContainer" style="overflow:auto"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>        
      </div>
    </div>
  </div>
</div>