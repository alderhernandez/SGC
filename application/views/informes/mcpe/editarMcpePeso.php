<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/10/2019 09:31 2019
 * FileName: editarMcpe.php
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h3 class="text-center">
            INDUSTRIAS DELMOR, S.A.
            <!--<small>Blank example to the fixed layout</small>-->
        </h3>
        <h4 class="text-center">
            <?php
            if(!$monit){
            }else{
                foreach ($monit as $key) {
                }
                echo "<span id='nombreRpt'>".$key["NOMBRE"]."</span>";
            }
            ?>
        </h4>
        <h4 class="text-center">
            <?php
            if(!$version){
            }else{
                echo $version;
            }
            ?>
            <?php
            if(!$monit){
            }else{
                foreach ($monit as $key) {
                }

                echo '<div class="form-group has-feedback">
								<input type="hidden" id="idmonitoreo" class="form-control" value="'.$key["IDMONITOREO"].'">
								<input type="hidden" id="idreporte" class="form-control" value="'.$key["IDREPORTE"].'">
							</div>';
            }
            ?>
        </h4>
        <!--<ol class="breadcrumb">
            <li class="active"></li>
        </ol>-->
        <br>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                <a class="btn-flat" href="javascript:history.back()">
                    <i class="fa fa-arrow-circle-left fa-2x"></i>
                </a>
                <div class="box-tools pull-right">

                    <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>-->
                </div>
            </div>
            <div class="box-body">
                <div>
                    <div class="row">
                        <div class="col-md-12">
                                <button class="pull-right btn btn-primary" id="btnActualizarpeso">
                                    Actualizar <i class="fa fa-save"></i>
                                </button>
                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <div class="form-group has-feedback">
                                                <label for="vigencia">Version</label>
                                                <?php
                                                if(!$monit){
                                                }else{
                                                    foreach ($monit as $key) {
                                                    }
                                                    echo '
                                                       <input autocomplete="off" value="'.$key["VERSION"].'" type="text" id="version" class="form-control" placeholder="Version">
                                                       <span class="fa fa-code-fork form-control-feedback"></span>
                                                    ';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                            <div class="form-group has-feedback">
                                                <label for="vigencia">Area</label>
                                                <?php
                                                if(!$monit){
                                                }else{
                                                    foreach ($monit as $key) {
                                                    }
                                                    echo '
                                                       <input autocomplete="off" value="'.$key["AREA"].'" readonly type="text" id="area" class="form-control" placeholder="">
                                                       <span class="fa fa-map-marker form-control-feedback"></span>
                                                    ';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                                            <div class="form-group has-feedback">
                                                <label for="vigencia">Fecha</label>
                                                <?php
                                                if(!$monit){
                                                }else{
                                                    foreach ($monit as $key) {
                                                    }
                                                    echo '
                                                       <input autocomplete="off" value="'.$key["DIA"].'" type="text" id="fecha" class="form-control" placeholder="Fecha">
                                                       <span class="fa fa-calendar form-control-feedback"></span>
                                                    ';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                            <div class="has-feedback">
                                                <label for="">Hora</label>
                                                <?php
                                                if(!$monit){
                                                }else{
                                                    foreach ($monit as $key) {
                                                    }
                                                    echo '
                                                       <input autocomplete="off" value="'.date_format(new DateTime($key["HORA"]),"H:i").'" type="text" id="Hora" class="clockpicker form-control" placeholder="Fecha">
                                                       <span class="fa fa-clock-o form-control-feedback"></span>
                                                    ';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                            <div class="form-group has-feedback">
                                                <label for="vigencia">Codigo</label>
                                                <input autocomplete="off" type="text" id="Codigo" class="form-control" placeholder="">
                                                <span class="fa fa-sort-numeric-desc form-control-feedback"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-xs-2 col-sm-3 col-md-3 col-lg-3">
                                            <div class="has-feedback">
                                                <label for="">peso de masa utilizada</label>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <span id="textoButton1">gr</span>
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu" id="unidadpesoMasaUtil">
                                                            <li><a href="javascript:void(0)">Gramos</a></li>
                                                            <li><a href="javascript:void(0)">Libras</a></li>
                                                            <li><a href="javascript:void(0)">Kilogramos</a></li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input type="text" id="pesoMasaUtil" class="form-control">
                                                    <span class="fa fa-balance-scale form-control-feedback"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-4 col-md-3 col-lg-3">
                                            <div class="form-group has-feedback">
                                                <label for="vigencia">Peso registrado en basc</label>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <span id="textoButton2">gr</span>
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu" id="unidadpesoRegistrado">
                                                            <li><a href="javascript:void(0)">Gramos</a></li>
                                                            <li><a href="javascript:void(0)">Libras</a></li>
                                                            <li><a href="javascript:void(0)">Kilogramos</a></li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input autocomplete="off" type="text" id="pesoRegistrado" class="form-control" placeholder="">
                                                    <span class="fa fa-balance-scale form-control-feedback"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                            <div class="form-group has-feedback">
                                                <label for="vigencia">Diferencia</label>
                                                <input readonly autocomplete="off" type="text" id="Diferencia" class="form-control" placeholder="">
                                                <span class="form-control-feedback">+/-</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                            <div class="form-group has-feedback">
                                                <label for=""> </label>
                                                <button id="btnAdd" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i></button>
                                                <label for=""> </label>
                                                <button id="btnDelete" class="btn btn-danger btn-lg"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <table class="table table-bordered table-condensed table-striped display nowrap" id="tblcrear" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">N°</th>
                                                <th class="text-center">Hora</th>
                                                <th class="text-center">Codigo</th>
                                                <th class="text-center">Peso masa<br> utilizada</th>
                                                <th class="text-center">Peso resgistrado <br> en basc</th>
                                                <th class="text-center">unidad peso</th>
                                                <th class="text-center">Diferencia +/-</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-center">
                                            <?php
                                            $unidadpeso = '';
                                            if(!$monit){
                                            }else{
                                                foreach ($monit as $key) {
                                                    echo "
                                                    <tr>
                                                        <td>".$key["NUMERO"]."</td>
                                                        <td>".date_format(new DateTime($key["HORA"]),"H:i")."</td>
                                                        <td>".$key["CODBASCULA"]."</td>
                                                        <td>".number_format($key["PESOMASA"],0)."</td>
                                                        <td>".number_format($key["PESOBASCULA"],0)."</td>
                                                        <td>".$key["UNIDADPESO"]."</td>
                                                        <td>".number_format($key["DIFERENCIA"],0)."</td>
                                                    </tr>
                                                ";
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="callout">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                    <p class="text-bold">Simbologia:</p>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
                                    <p class="text-bold">P.V: Perdida de Vacio</p>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
                                    <p class="text-bold">M.C: Mal Codificado</p>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
                                    <p class="text-bold">M.S: Mal Sellado</p>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4">
                                    <p class="text-bold">T°C: Temperatura en Grados Centigrados</p>
                                </div>
                            </div>
                        </div>
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
