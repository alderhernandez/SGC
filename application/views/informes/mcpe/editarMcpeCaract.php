<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/10/2019 15:01 2019
 * FileName: editarMcpeCaract.php
 */
?>
<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 23/9/2019 16:04 2019
 * FileName: crearMcpe.php
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
                            <button class="pull-right btn btn-primary" id="btnActualizar">
                                Actualizar <i class="fa fa-save"></i>
                            </button>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                </div>
                            </div>
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
                                                   <input value="'.$key["VERSION"].'" autocomplete="off" type="text" id="version" class="form-control" placeholder="Version">
                                                   <span class="fa fa-code-fork form-control-feedback"></span>
                                                ';
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                        <div class="form-group has-feedback">
                                            <label for="vigencia">Area</label>
                                            <input autocomplete="off" value="Empaque" readonly type="text" id="area" class="form-control" placeholder="">
                                            <span class="fa fa-map-marker form-control-feedback"></span>
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
                                                   <input value="'.$key["DIA"].'" autocomplete="off" type="text" id="fecha" class="form-control" placeholder="Fecha">
                                                   <span class="fa fa-calendar form-control-feedback"></span>
                                                ';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-5 col-lg-5">
                                        <div class="form-group has-feedback">
                                            <label>Nombre del producto</label><br>
                                            <select class="js-data-example-ajax form-control" id="ddlprod"></select>
                                        </div>
                                    </div>
                                    <div id="campo">

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                                                <div class="form-group has-feedback">
                                                    <label>Maquina</label>
                                                    <select class="form-control" id="ddlMaquina">
                                                        <option value=""></option>
                                                        <?php
                                                        if(!$maq){
                                                        }else{
                                                            foreach ($maq as $item) {
                                                                echo "
                                                                   <option value='".$item["IDMAQUINA"]."'>
                                                                      ".$item["MAQUINA"]." (".$item["SIGLAS"].")
                                                                    </option>
                                                                 ";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                                                <div class="form-group has-feedback">
                                                    <label>Tipo de empaque</label><br>
                                                    <select class="form-control" id="ddlTipo">
                                                        <option selected value="1">Vacio</option>
                                                        <option value="2">Granel</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                                <div class="form-group has-feedback">
                                                    <label for="">Codigo</label>
                                                    <input  autocomplete="off" type="text" id="produccion" class="form-control" placeholder="codigo">
                                                    <span class="fa fa-sort-alpha-desc form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                                                <div class="form-group has-feedback">
                                                    <label for="">Fecha Venc.</label>
                                                    <input autocomplete="off" type="text" id="fechaVenc" class="form-control col-xs-4" placeholder="Fecha Venc">
                                                    <span class="fa fa-calendar form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                                                <div class="form-group has-feedback">
                                                    <label for="">Cantidad muestra.</label>
                                                    <input autocomplete="off" type="text" id="CantMues" class="form-control col-xs-4" placeholder="">
                                                    <span class="fa fa-sort-numeric-desc form-control-feedback"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <div class="has-feedback">
                                                    <label for="">P.V</label>
                                                    <input type="text" id="PV" class="form-control">
                                                    <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <div class="has-feedback">
                                                    <label for="">M.S</label>
                                                    <input type="text" id="MS" class="form-control">
                                                    <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <div class="has-feedback">
                                                    <label for="">M.C</label>
                                                    <input type="text" id="MC" class="form-control">
                                                    <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <div class="has-feedback">
                                                    <label for="">T°C</label>
                                                    <input type="text" id="TC" class="form-control">
                                                    <span class="fa fa-thermometer-empty form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-sm-3 col-md-3 col-lg-3">
                                                <label for="">Presentacion</label>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <span id="textoBtnPresentacion">gr</span>
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu" id="unidadpesoCaract">
                                                            <li><a href="javascript:void(0)">Gramos</a></li>
                                                            <li><a href="javascript:void(0)">Libras</a></li>
                                                            <li><a href="javascript:void(0)">Kilogramos</a></li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <input autocomplete="off" type="text" id="presentacion" class="form-control" placeholder="">
                                                    <span class="fa fa-balance-scale form-control-feedback"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                                <div class="form-group has-feedback">
                                                    <label for="vigencia">Operario</label>
                                                    <input autocomplete="off" type="text" id="operario" class="form-control" placeholder="Operario">
                                                    <span class="fa fa-pencil-square-o form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                                <div class="has-feedback">
                                                    <label for="">% Defecto</label>
                                                    <input readonly type="text" id="Defecto" class="form-control">
                                                    <span class="fa fa-percent form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-9 col-md-6 col-lg-6">
                                                <div class="form-group has-feedback">
                                                    <label for="vigencia">Observaciones</label>
                                                    <?php
                                                    if(!$monit){
                                                    }else{
                                                        foreach ($monit as $key) {
                                                        }
                                                        echo '
                                                           <input value="'.$key["OBSERVACIONES"].'" autocomplete="off" type="text" id="observaciones" class="form-control" placeholder="Observaciones">
                                                           <span class="fa fa-pencil form-control-feedback"></span>
                                                        ';
                                                    }
                                                    ?>
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
                                                    <th class="text-center">Cod Prod</th>
                                                    <th class="text-center">Producto</th>
                                                    <th class="text-center">Tipo <br> Empaque</th>
                                                    <th class="text-center">Codigo</th>
                                                    <th class="text-center">Fecha <br> Vencimiento</th>
                                                    <th class="text-center">Maquina</th>
                                                    <th class="text-center">Presentacion</th>
                                                    <th class="text-center">Unidad <br> Presentacion</th>
                                                    <th class="text-center">Cantidad <br> Muestra</th>
                                                    <th class="text-center">P.V</th>
                                                    <th class="text-center">M.S</th>
                                                    <th class="text-center">M.C</th>
                                                    <th class="text-center">T°C</th>
                                                    <th class="text-center">Operario</th>
                                                    <th class="text-center">% Defecto</th>
                                                </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                <?php
                                                $tipo = ''; $unidadPeso= '';
                                                if(!$monit){
                                                }else{
                                                    foreach ($monit as $key) {
                                                        switch ($key["UNIDADPRESENTACION"])
                                                        {
                                                            case "Gramos":
                                                                $unidadPeso = "gr";
                                                                break;
                                                            case "Libras":
                                                                $unidadPeso = "lbs";
                                                                break;
                                                            case "KG":
                                                                $unidadPeso = "kg";
                                                                break;
                                                        }
                                                        if($key["VACIO"] == 1){
                                                            $tipo = "Vacio";
                                                        }else if($key["GRANEL"] == 1){
                                                            $tipo = "Granel";
                                                        }
                                                        echo "
                                                            <tr>
                                                                <th>".$key["NUMERO"]."</th>
                                                                <th>".$key["CODIGO"]."</th>
                                                                <th>".$key["NOMBREDET"]."</th>
                                                                <th>".$tipo."</th>
                                                                <th>".$key["LOTE"]."</th>
                                                                <th>".date_format(new DateTime($key["FECHAVENCIMIENTO"]),"Y-m-d")."</th>
                                                                <th>".$key["MAQUINA"]." (".$key["SIGLAS"].")</th>
                                                                <th>".number_format($key["PRESENTACION"],0)."</th>
                                                                <th>".$unidadPeso."</th>
                                                                <th>".number_format($key["CANTIDAD_MUESTRA"],0)."</th>
                                                                <th>".number_format($key["PV"],0)."</th>
                                                                <th>".number_format($key["MS"],0)."</th>
                                                                <th>".number_format($key["MC"],0)."</th>
                                                                <th>".number_format($key["TC"],0)."</th>
                                                                <th>".$key["OPERARIO"]."</th>
                                                                <th>".number_format($key["DEFECTO"],2)."</th>
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
                </div>
            </div>

            <div class="box-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="callout">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                        <p class="text-bold">Simbologia:</p>
                                    </div>
                                    <div class="col-xs-3 col-sm-4 col-md-2 col-lg-3">
                                        <p class="text-bold">P.V: Perdida de Vacio</p>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
                                        <p class="text-bold">M.C: Mal Codificado</p>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-3">
                                        <p class="text-bold">M.S: Mal Sellado</p>
                                    </div>
                                    <div class="col-xs-3 col-sm-6 col-md-4 col-lg-4">
                                        <p class="text-bold">T°C: Temperatura en Grados Centigrados</p>
                                    </div>
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
