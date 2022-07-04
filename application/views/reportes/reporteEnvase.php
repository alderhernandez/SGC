
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Estudio de Peso y Diametro
		</h1>		
		<br>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-danger">
			<div class="box-header with-border">
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i></button>
				</div>

				<div class="col-xs-12">
                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                       		<div class="form-group has-feedback">
                                <label>Cabezal maq.</label><br>
                                <select class="form-control" id="ddlcabezal">
                                    <option value="1">Cabezal #1</option>
                                	<option value="2">Cabezal #2</option>
                            	</select>
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
                                <label for="version">Lote</label>
                                <input autocomplete="off" type="text" id="idlote" value="" class="form-control" placeholder="Lote">
                                <span class="fa fa-code-fork form-control-feedback"></span>
                            </div>
                    	</div>
                    	<div class="col-xs-4 col-sm-6 col-md-6 col-lg-2">
                    		<div class="form-group has-feedback">
		                      	<button class="pull-right btn btn-primary" id="btnFiltrar">
									Filtrar <i class="fa fa-search"></i>
								</button>
							</div>
						</div>
                </div>
			</div>
		</div>
		<div class="row">
			<div style="width:100%;">
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
	</section>

	
</div>