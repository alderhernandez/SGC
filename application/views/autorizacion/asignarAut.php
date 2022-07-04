<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-07 10:16:56
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-07 14:56:36
 */
?>
<div class="content-wrapper">
	<section class="content-header"> 
		 	<div class="row">
					<div class="col-xs-8">
						<div class="form-group">
							<label></label>
							<select id="ddlUsuarios" class="form-control select2" style="width: 100%;">
								<option></option>
								<?php
								if(!$users){
								}else{
									foreach ($users as $key) {
										echo "
												<option value='".$key["IDUSUARIO"]."'>".$key["NOMBRES"]." ".$key["APELLIDOS"]."</option>
											";
									}
								}
								?>
							</select>
						</div>
					</div>	
					<br>
					<button class=" btn btn-primary" data-toggle="modal" id="btnSetAuth">
						Agregar <i class="fa fa-plus"></i>
					</button>	
			</div>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo str_replace("_", " ", $this->uri->segment(1))?></h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div id="treeCheckbox">
				  <ul class="recorrer">
				     <?php 
				     	if (!$data) {
				     	}else{
				     		foreach ($data as $key) {
					     		echo "
										<li class='jstree-open' >".$key["DESCRIPCION"]."";
											foreach ($auts as $key2) {
											  if ($key["ID"] == $key2["IDAUTCATEGORIA"]) {
											  	 echo "
													<ul>
														<li id='".$key2["IDAUTORIZACION"]."'>
														   ".$key2["DESCRIPCION"]."
														</li>
													</ul>
											   ";
											  }
											}
									echo" </li>";	
				     		}
				     	}
					  ?>
					</ul>
				</div>
			</div>
		</div>

	</section>
</div>
</div>