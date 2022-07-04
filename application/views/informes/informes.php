<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-12 11:22:39
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-16 10:33:39
 */
?>
<div class="content-wrapper">
	<section class="content-header">

	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title" style="text-transform: uppercase;">
					<?php echo str_replace("_", " ", $this->uri->segment(1))?>
				</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
								<div class="col-xs-5">
									<div class="form-group has-feedback">
										<input autofocus="" autocomplete="off" type="text" id="Buscar" class="form-control" placeholder="Buscar">
									</div>
								</div>
								<div class="col-xs-5">
									<button  class="btn btn-success" type="button" name="button" onclick="Buscar()">
										Filtrar <i class="fa fa-search"></i>
									</button>
								</div>
			          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			          	<!-- small box -->
				          <?php
				          	$colores = array("red","aqua","green","yellow");
				          	$i = 0;
				          	$e = 0;
				          	if(!$rpts){
				          	}else{
				          		foreach ($rpts as $key) {
				          			echo '
									<div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
										<div class="texto-busqueda small-box bg-'.$colores[$e].'">
								            <div class="inner">
								              <p class="text-bold">'.$key["SIGLA"].'</p>

								              <p class="texto" style="font-size:9pt;">'.$key["NOMBRE"].'</p>
								            </div>
								            <div class="icon">
								              <i class="fa fa-file-text-o"></i>
								            </div>
								            <a href="'.base_url("index.php/reporte_".$key["IDTIPOREPORTE"]."").'" class="small-box-footer">
								              Crear informe <i class="fa fa-arrow-circle-right"></i>
								            </a>
							           </div>
							         </div>
				          			';
				          			$i++;
				          			$e++;
				          			if ($e == 4) {
				          				$e=0;
				          			}
				          		}
				          	}
			          ?>
			          </div>
                </div>
			</div>
		</div>

	</section>
</div>
</div>
