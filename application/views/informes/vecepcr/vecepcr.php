<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 24/03/2021 10:32 2021
 * FileName: vecepc.php
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h3 class="text-center">
            INDUSTRIAS DELMOR, S.A.
            <!--<small>Blank example to the fixed layout</small>-->
        </h3>
        <h4 class="text-center">
            <span id="nombreRpt">VERIFICACION ESPECIFICACIONES DE CALIDAD DE ELABORACION DE PRODUCTOS CRUDOS</span>
            <?php
            if(!$version1){
            }else{
                echo "<span id='codigoVersion' style='display:none'>".$version1."</span>";
            }
            ?>
        </h4>
        <h4 class="text-center">
            <?php
            $codReporte = $this->uri->segment(1);
            if(!$version){
            }else{
                echo $version;
            }
            $codRpt = str_replace("reporte_","",$codReporte);
            echo "<span id='codigoReporte' style='display:none'>".$codRpt."</span>";
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
                <button class="pull-right btn btn-primary" id="btnGuardar">
                    Guardar <i class="fa fa-save"></i>
                </button>
                <div class="box-tools pull-right">
                    <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>-->
                </div>
            </div>
            <div class="box-body">
                <div id="campos">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-3 col-sm-4 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Area</label>
                                    <select id="ddlAreas" class="form-control select2" style="width: 100%;">
                                        <option></option>
                                        <?php
                                        if(!$areas){
                                        }else{
                                            foreach ($areas as $key) {
                                                echo "
														<option value='".$key["IDAREA"]."'>".$key["AREA"]."</option>
													";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-4 col-md-3 col-lg-3">
                                <div class="form-group has-feedback">
                                    <label for="">Inspector</label>

                                    <input type="hidden" name="" id="idUser" class="form-control"
                                        value="<?php echo $this->session->userdata("id");?>">

                                    <input readonly=""
                                        value="<?php echo $this->session->userdata("nombre")." ".$this->session->userdata("apellidos")?>"
                                        autocomplete="off" type="text" id="monituser" class="form-control"
                                        placeholder="Inspector">
                                    <span class="fa fa-user form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Fecha</label>
                                    <?php
                                    date_default_timezone_set("America/Managua");
                                    setlocale(LC_TIME, 'es_NI','es_NI.UTF-8');
                                    echo '
                                            <input value="'.date("Y-m-d").'" readonly autocomplete="off" type="text" id="Fecha" class="form-control" placeholder="">
                                       ';
                                    ?>
                                    <span class="fa fa-calendar form-control-feedback"></span>
                                </div>
                            </div>
                            <!--<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Lote</label>
                                    <input value="" autocomplete="off" type="text" id="Lote" class="form-control"
                                        placeholder="">
                                    <span class="fa fa-barcode form-control-feedback"></span>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Producto</label>
                                    <select class="js-data-example-ajax form-control" id="ddlprod"></select>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Presentacion</label>
                                    <input readonly="" type="text" id="presentacion" class="form-control"
                                        placeholder="presentacion">
                                    <span class="fa fa-exclamation-circle form-control-feedback" hidden="true"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <div class="form-group has-feedback">
                                        <label for="">Hoja de Proceso</label>
                                        <input type="text" id="hojaproceso" class="form-control has-error"
                                            placeholder="hoja proceso">
                                        <span class="fa fa-hand-o-up form-control-feedback" hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Lote</label>
                                    <input type="text" id="lote" class="form-control" placeholder="">
                                    <span class="fa fa-barcode form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Cant. Batch</label>
                                    <input type="text" id="batch" class="form-control">
                                    <span class="fa fa-address-book form-control-feedback" hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">PH</label>
                                    <input type="text" id="ph" class="form-control">
                                    <span class="fa fa-adjust form-control-feedback" hidden="true"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <!-- TODO:  Carro de Salchicha 46.6 kg,  Carro de Mortadelas 61.2 kg-->
                                    <label for="tempPasta">Temperatura Pasta</label>
                                    <input type="text" id="tempPasta" class="form-control" placeholder="">
                                    <span class="fa fa-thermometer-0 form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-4 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Peso Cajilla Vacía</label>
                                    <input type="text" id="pesoCajillaVac" class="form-control" placeholder="">
                                    <span class="fa fa-balance-scale form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-4 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Peso Promedio Unidad</label>
                                    <input type="text" id="pesoPromUnidad" class="form-control" placeholder="">
                                    <span class="fa fa-balance-scale form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-4 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Cant. Total Unidades</label>
                                    <input type="text" id="totalunidades" class="form-control" placeholder="">
                                    <span class="fa fa-balance-scale form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea id="observaciones" class="form-control" rows="3"
                                        placeholder="Observaciones"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for=""> </label>
                                    <button id="btnAdd" class="btn btn-primary btn-lg"><i
                                            class="fa fa-plus"></i></button>
                                    <label for=""> </label>
                                    <button id="btnDelete" class="btn btn-danger btn-lg"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <table class="table table-bordered table-condensed table-striped" id="tblProdEmbutido">
                    <thead class="text-sm">
                        <tr>
                            <th>Area</th>
                            <th>codProducto</th>
                            <th>Producto</th>
                            <th>Presentacion</th>
                            <th>Hoja de <br> Proceso</th>
                            <th>Lote</th>
                            <th>Cant. <br> Batch</th>
                            <th>PH</th>
                            <th>Temperatura <br> Pasta</th>
                            <th>Peso cajilla <br> Vacia</th>
                            <th>Peso prom. <br> por unidad</th>
                            <th>Cantidad total<br> de unidades</th>
                            <th>% Rendimiento</th>
                            <th>% Merma </th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<div class="modal" id="loading" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
    data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content"
            style="background-color:transparent;box-shadow: none; border: none;margin-top: 26vh;">
            <div class="text-center">
                <img width="130px" src="<?php echo base_url()?>assets/img/loading.gif">
            </div>
        </div>
    </div>
</div>