<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 23/10/2019 09:13 2019
 * FileName: editarEepdc.php
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
                echo ' <span id="nombreRpt">'.$key["NOMBREINFORME"].'</span>';
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
                echo "
                <h5 class='text-center text-danger text-bold'>
                    No existe código de monitoreo para el dia actual. para agregar un nuevo codigo </br>
                    haga click en <a href='".base_url("index.php/monitoreos")."'>Crear</a>
                </h5>";
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
                <button class="pull-right btn btn-primary" id="btnActualizar">
                    Actualizar <i class="fa fa-save"></i>
                </button>
                <div class="box-tools pull-right">

                    <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>-->
                </div>
            </div>
            <div class="box-body">
                <div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="version">Version informe</label>
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
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group has-feedback">
                                    <label>Area</label><br>
                                    <select class="form-control" id="ddlarea">
                                        <?php
                                        if(!$monit){
                                        }else{
                                            foreach ($monit as $key) {
                                            }
                                         echo "
                                                <option value='".$key["IDAREA"]."'>".$key["AREA"]."</option>
                                              ";
                                        }
                                        ?>
                                        <?php
                                        if(!$areas){
                                        }else{
                                            foreach ($areas as $area) {
                                                echo "
                                                        <option value='".$area["IDAREA"]."'>".$area["AREA"]."</option>
                                                    ";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group has-feedback">
                                    <label for="fecha">Fecha</label>
                                    <?php
                                    if(!$monit){
                                    }else{
                                        foreach ($monit as $key) {
                                        }
                                        echo '
                                            <input value="'.date_format(new DateTime($key["DIA"]),"Y/m/d").'" autocomplete="off" type="text" id="fecha" class="form-control" placeholder="Fecha">
                                           <span class="fa fa-calendar form-control-feedback"></span>
                                        ';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group has-feedback">
                                    <label>Empresa</label><br>
                                    <select class="form-control" id="ddlempresa">
                                        <?php
                                        if(!$monit){
                                        }else{
                                            foreach ($monit as $key) {
                                            }
                                            echo "
                                                <option value='".$key["IDEMPRESA"]."'>".$key["EMPRESA"]."</option>
                                              ";
                                        }
                                        ?>
                                        <option value="1">DELMOR</option>
                                        <option value="2">D´lago</option>
                                        <option value="3">Panamá</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group has-feedback">
                                    <label>Cabezal maq.</label><br>
                                    <select class="form-control" id="ddlcabezal">
                                        <?php
                                        if(!$monit){
                                        }else{
                                            foreach ($monit as $key) {
                                            }
                                            echo "
                                                <option value='".$key["CABEZALMAQUINA"]."'>".$key["MAQUINA"]."</option>
                                              ";
                                        }
                                        ?>
                                        <option value="1">Cabezal #1</option>
                                        <option value="2">Cabezal #2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-8 col-md-5 col-lg-5">
                                <div class="form-group has-feedback">
                                    <label>Nombre del producto</label><br>
                                    <select class="js-data-example-ajax form-control" id="ddlprod"></select>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Codigo</label>
                                    <input  autocomplete="off" type="text" id="produccion" class="form-control" placeholder="">
                                    <span class="fa fa-sort-alpha-desc form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">L</label>
                                    <input autocomplete="off" type="text" id="txtL" class="form-control col-xs-4" placeholder="">
                                    <span class="fa fa-clock-o form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">GC</label>
                                    <input autocomplete="off" type="text" id="txtGC" class="form-control col-xs-4" placeholder="">
                                    <span class="fa fa-clock-o form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">GT</label>
                                    <input autocomplete="off" type="text" id="txtGT" class="form-control col-xs-4" placeholder="">
                                    <span class="fa fa-clock-o form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-10 col-md-6 col-lg-6">
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
                            <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for=""> </label>
                                    <button id="btnAdd" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i></button>
                                    <label for=""> </label>
                                    <button id="btnDelete" class="btn btn-danger btn-lg"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <p class="text-bold">L:
                                <span id="spanL">
                                    <?php
                                    $sumaL = 0;
                                    if(!$monit){
                                    }else{
                                        foreach ($monit as $key) {
                                            $sumaL += $key["L"];
                                        }
                                        echo number_format($sumaL/3,2);
                                    }
                                    ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <p class="text-bold">GC:
                                <span id="spanGC">
                                    <?php
                                    $sumaGC = 0;
                                    if(!$monit){
                                    }else{
                                        foreach ($monit as $key) {
                                            $sumaGC += $key["GC"];
                                        }
                                        echo number_format($sumaGC/3,2);
                                    }
                                    ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <p class="text-bold">GT:
                                <span id="spanGT">
                                    <?php
                                    $sumaGT = 0;
                                    if(!$monit){
                                    }else{
                                        foreach ($monit as $key) {
                                            $sumaGT += $key["GT"];
                                        }
                                        echo number_format($sumaGT/3,2);
                                    }
                                    ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <p class="text-bold">T:
                                     <?php
                                     if(!$monit){
                                     }else{
                                         foreach ($monit as $key) {
                                         }
                                         echo "<span id='spanT'>".number_format($key["T"],2)."</span>";
                                     }
                                     ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered table-condensed table-striped display nowrap" id="tblcrear">
                            <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th class="text-center">Empresa</th>
                                <th class="text-center">Codigo <br> prod</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Codigo</th>
                                <th class="text-center"># Cabezal <br> Maq</th>
                                <th class="text-center">L</th>
                                <th class="text-center">GC</th>
                                <th class="text-center">GT</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php
                            if(!$monit){
                            }else{
                                foreach ($monit as $key) {
                                    echo "
                                        <tr>
                                            <td>".$key["NUMERO"]."</td>
                                            <td>".$key["EMPRESA"]."</td>
                                            <td>".$key["CODIGO"]."</td>
                                            <td>".$key["NOMBREPROD"]."</td>
                                            <td>".$key["LOTE"]."</td>
                                            <td>".$key["CABEZALMAQUINA"]."</td>
                                            <td>".number_format($key["L"],2)."</td>
                                            <td>".number_format($key["GC"],2)."</td>
                                            <td>".number_format($key["GT"],2)."</td>
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

        <div class="box-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-3 col-sm-4 col-md-3 col-lg-3">
                        <p class="text-bold text-success">Formula: T = GC+GT+K-L</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                        <p class="text-bold">T: Traslape</p>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                        <p class="text-bold">GC: Gancho del cuerpo</p>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                        <p class="text-bold">GT: Gancho de la tapa</p>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <p class="text-bold">K: Constante = 22mm</p>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <p class="text-bold">L: Altura del cierre</p>
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

