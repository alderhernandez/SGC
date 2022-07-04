<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 3/9/2019 14:51 2019
 * FileName: editarVeced.php
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h3 class="text-center">
            INDUSTRIAS DELMOR, S.A.
            <!--<small>Blank example to the fixed layout</small>-->
        </h3>
        <h4 class="text-center">
            <span id="nombreRpt">VERIFICACION DE ESPECIFICACIONES DE CALIDAD EN DESHUESE</span>
        </h4>
        <h4 class="text-center">
            <?php
            if(!$version){
            }else{
                echo $version;
            }
            ?>
            <?php
            $siglas = ''; $id = ''; $monit = '';
            if(!$veced){
            }else{
                foreach ($veced as $key) {
                    $id = $key["IDREPORTE"];
                    $monit = $key["IDMONITOREO"];
                }
                echo '<div class="form-group has-feedback">
								<input type="hidden" id="idreporte" class="form-control" value="'.$id.'">
                                <input type="hidden" id="idmonitoreo" class="form-control" value="'.$monit.'">
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
                <button class="pull-right btn btn-primary" id="btnGuardar">
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
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label>Area</label>
                                     <?php
                                     $idarea = ''; $area = '';
                                     if(!$veced){
                                     }else{
                                         foreach ($veced as $key) {
                                            $idarea = $key["ID_AREA"];
                                            $area = $key["AREA"];
                                         }
                                         echo '
                                             <input autocomplete="off" type="hidden" value="'.$idarea.'" id="Area" class="form-control">
                                            <input autocomplete="off" readonly="" type="text" value="'.$area.'" class="form-control">';
                                     }
                                     ?>
                                    <span class="fa fa-map-marker form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Version</label>
                                    <?php
                                    $version = '';
                                    if(!$veced){
                                    }else{
                                        foreach ($veced as $key) {
                                            $version = $key["VERSION"];
                                        }
                                        echo '
                                             <input value="'.$version.'" autocomplete="off" type="text" id="version" class="form-control" placeholder="Version del informe">';
                                    }
                                    ?>
                                    <span class="fa fa-code-fork form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group has-feedback">
                                    <label>Nombre del producto</label><br>
                                    <select class="js-data-example-ajax form-control" id="ddlprod">
                                        <?php
                                        if(!$veced){
                                        }else{
                                            foreach ($veced as $key) {
                                                echo '
                                                  <option value="'.$key["CODIGO"].'">'.$key["DESCRIPCION"].'</option>
                                                 ';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Fecha</label>
                                    <?php
                                    $fecha = '';
                                    if(!$veced){
                                    }else{
                                        foreach ($veced as $key) {
                                            $fecha = date_format(new DateTime($key["FECHACREA"]),"Y-m-d");
                                        }
                                        echo '
                                                  <input autocomplete="off" type="text" id="fecha" class="form-control" value="'.$fecha.'">
                                                 ';
                                    }
                                    ?>
                                    <span class="fa fa-calendar form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Cod produccion.</label>
                                    <?php
                                    $codigoprod = '';
                                    if(!$veced){
                                    }else{
                                        foreach ($veced as $key) {
                                            $codigoprod = $key["CODIGOPRODUCCION"];
                                        }
                                        echo '
                                                  <input  autocomplete="off" type="text" id="produccion" class="form-control" value="'.$codigoprod.'">
                                                 ';
                                    }
                                    ?>
                                    <span class="fa fa-sort-alpha-desc form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">N° estibas</label>
                                    <?php
                                    $estibas = '';
                                    if(!$veced){
                                    }else{
                                        foreach ($veced as $key) {
                                            $estibas = $key["NOESTIBAS"];
                                        }
                                        echo '
                                                  <input  autocomplete="off" type="text" id="estibas" class="form-control" value="'.$estibas.'">
                                                 ';
                                    }
                                    ?>
                                    <span class="fa fa-sort-alpha-desc form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Peso en lbs</label>
                                    <input readonly="" value="<?php echo $this->session->userdata("nombre")." ".$this->session->userdata("apellidos")?>" autocomplete="off" type="hidden" id="monituser" class="form-control" >

                                    <input type="text" id="pesolbs" class="form-control">
                                    <span class="fa fa-user form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">T° del prod</label>
                                    <input type="text" id="temperatura" class="form-control">
                                    <span class="fa fa-thermometer-half form-control-feedback"></span>
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
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-8 col-sm-10 col-md-5 col-lg-5">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Observaciones</label>
                                    <input autocomplete="off" type="text" id="observaciones" class="form-control" placeholder="Observaciones">
                                    <span class="fa fa-pencil form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-10 col-md-5 col-lg-5">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Acciones correctivas</label>
                                    <input autocomplete="off" type="text" id="acciones" class="form-control" placeholder="Acciones correctivas">
                                    <span class="fa fa-pencil form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <table class="table table-bordered table-condensed table-striped" id="tblcrear">
                    <thead>
                    <tr>
                        <th class="text-center">N°</th>
                        <th class="text-center">Pesos en <br>libras</th>
                        <th class="text-center">T° Interna del <br>producto</th>
                        <th class="text-center">Observaciones</th>
                        <th class="text-center">Acciones correctivas</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php
                    if(!$veced){
                    }else{
                        foreach ($veced as $key) {
                            echo "
                                <tr>
                                    <td>".$key["NUMERO"]."</td>
                                    <td>".number_format($key["PESOLIBRAS"],2)."</td>
                                    <td>".$key["TINTERNAPRODUCTO"]."</td>
                                    <td>".$key["OBSERVACIONESACCION"]."</td>
                                    <td>".$key["ACCIONESCORRECTIVAS"]."</td>
                                </tr>
                            ";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="box-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="callout">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-3 col-sm-2 col-md-3 col-lg-3">
                                    <p class="text-bold">CLAVES:</p>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <p class="text-bold">AC: Aceptable</p>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <p class="text-bold">I: Inaceptable</p>
                                </div>
                                <div class="col-xs-3 col-sm-4 col-md-3 col-lg-3">
                                    <p class="text-bold">NA: No aplica</p>
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
