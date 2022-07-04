<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 13/11/2019 15:39 2019
 * FileName: cdtDetalle.php
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
            if(!$detalle){
                echo "";
            }else{
                foreach ($detalle as $key) {
                }
                echo '<span id="nombreRpt">'.$key["NOMBRE"].'</span>';
            }
            ?>
        </h4>
        <h4 class="text-center">
            <?php
            if(!$version){
            }else{
                echo "".$version."";
            }
            ?>
            <?php
            if(!$detalle){
                echo "";
            }else{
                foreach ($detalle as $key) {
                    echo '<div class="form-group has-feedback">
								<input type="hidden" id="idmonitoreo" class="form-control" value="'.$key["IDMONITOREO"].'">
								<input type="hidden" id="iddetalle" class="form-control" value="'.$key["IDTEMPESTERILIZADOR"].'">
							</div>';
                }
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
                    Guardar <i class="fa fa-save"></i>
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
                            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Area</label>
                                    <select id="ddlAreas" class="form-control select2" style="width: 100%;">
                                        <option></option>
                                        <?php
                                        if(!$detalle){
                                            echo "";
                                        }else{
                                            foreach ($detalle as $key) {
                                            }
                                            echo '<option selected value="'.$key["IDAREA"].'">'.$key["AREA"].'</option>';
                                        }
                                        ?>
                                        <?php
                                        if(!$areas){
                                        }else{
                                            foreach ($areas as $key) {
                                                if($key["IDAREA"] != null){
                                                    echo "
														<option value='".$key["IDAREA"]."'>".$key["AREA"]."</option>
													";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Version</label>
                                    <?php
                                    if(!$detalle){
                                    }else{
                                        foreach ($detalle as $key) {
                                        }
                                        echo '<input readonly value="'.$key["VERSION"].'" autocomplete="off" type="text" id="version" class="form-control" placeholder="Version del informe">';
                                    }
                                    ?>
                                    <span class="fa fa-code-fork form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Lote</label>
                                    <?php
                                    if(!$detalle){
                                    }else{
                                        foreach ($detalle as $key) {
                                        }
                                        echo '<input readonly value="'.$key["LOTE"].'" autocomplete="off" type="text" id="Lote" class="form-control" placeholder="">';
                                    }
                                    ?>
                                    <span class="fa fa-barcode form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Fecha</label>
                                    <?php
                                    if(!$detalle){
                                    }else{
                                        foreach ($detalle as $key) {
                                        }
                                        echo '<input value="'.date_format(new DateTime($key["FECHAINICIO"]),"Y-m-d").'" readonly autocomplete="off" type="text" id="Fecha" class="form-control" placeholder="">';
                                    }
                                    ?>
                                    <span class="fa fa-calendar form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-1 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for=""> </label>
                                    <button id="btnModalTemp" class="btn btn-success"><i class="fa fa-thermometer-full"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                                <div class="form-group has-feedback">
                                    <label for="vigencia">Mes</label>
                                    <?php
                            /*date_default_timezone_set("America/Managua");
                            setlocale(LC_TIME, "spanish");
                            echo '
                                    <input value="'.strftime("%B %Y").'" readonly autocomplete="off" type="text" id="Mes" class="form-control" placeholder="">
                               ';*/
                            ?>
                                    <span class="fa fa-calendar form-control-feedback"></span>
                                </div>
                            </div>-->
                            <!-- <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                 <div class="form-group has-feedback">
                                     <label for="vigencia">Hora</label>
                                    <?php
                                   /* date_default_timezone_set("America/Managua");
                                    echo '
                                            <input readonly value="'.date("H:i").'" autocomplete="off" type="hidden" id="Hora" class="form-control">
                                       ';*/
                                    ?>
                                    <span class="fa fa-clock-o form-control-feedback"></span>
                                </div>
                            </div>-->
                            <!--<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">Dia</label>
                                    <?php
                            /*$dia = '';
                            date_default_timezone_set("America/Managua");
                            setlocale(LC_ALL,'Spanish_Nicaragua');
                            echo '
                                    <input value="'.utf8_encode(strftime("%A")).'" readonly autocomplete="off"
                                    type="text" id="Dia" class="form-control" placeholder="">
                               ';*/
                            ?>
                                    <span class="fa fa-calendar-check-o form-control-feedback"></span>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Cuartos frios</label>
                                    <select id="ddlSalas" class="form-control select2" style="width: 100%;">
                                        <option></option>
                                        <?php
                                        if(!$detalle){
                                            echo "<option selected></option>";
                                        }else{
                                            foreach ($detalle as $key) {
                                                if($key["IDSALA"] != null){
                                                    echo '<option selected value="'.$key["IDSALA"].'">'.$key["AREA"].'</option>';
                                                }
                                            }
                                        }
                                        ?>
                                        <?php
                                        if(!$salas){
                                        }else{
                                            foreach ($salas as $key) {
                                                echo "
														<option value='".$key["IDCATSALA"]."'>".$key["NOMBRE"]."</option>
													";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">6:00 a.m</label>
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <?php
                                                if(!$detalle){
                                                }else{
                                                    foreach ($detalle as $key) {
                                                    }
                                                    echo '<span id="textoBtnUM1">'.$key["UMTOMA1"].'</span>';
                                                }
                                                ?>
                                                <span class="fa fa-caret-down"></span></button>
                                            <ul class="dropdown-menu" id="UMT1">
                                                <li><a href="javascript:void(0)">°c</a></li>
                                                <li><a href="javascript:void(0)">°f</a></li>
                                            </ul>
                                        </div>
                                        <!-- /btn-group -->
                                        <?php
                                        if(!$detalle){
                                        }else{
                                            foreach ($detalle as $key) {
                                            }
                                            echo '<input value="'.number_format($key["TOMA1"],0).'" autofocus="" autocomplete="off" type="text" id="toma1" class="form-control">';
                                        }
                                        ?>
                                        <span class="fa fa-file-text-o form-control-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">8:00 a.m</label>
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <?php
                                                if(!$detalle){
                                                }else{
                                                    foreach ($detalle as $key) {
                                                    }
                                                    echo '<span id="textoBtnUM2">'.$key["UMTOMA2"].'</span>';
                                                }
                                                ?>
                                                <span class="fa fa-caret-down"></span></button>
                                            <ul class="dropdown-menu" id="UMT2">
                                                <li><a href="javascript:void(0)">°c</a></li>
                                                <li><a href="javascript:void(0)">°f</a></li>
                                            </ul>
                                        </div>
                                        <!-- /btn-group -->
                                        <?php
                                        if(!$detalle){
                                        }else{
                                            foreach ($detalle as $key) {
                                            }
                                            echo '<input value="'.number_format($key["TOMA2"],0).'" autocomplete="off" type="text" id="toma2" class="form-control">';
                                        }
                                        ?>
                                        <span class="fa fa-file-text-o form-control-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">11:00 a.m</label>
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <?php
                                                if(!$detalle){
                                                }else{
                                                    foreach ($detalle as $key) {
                                                    }
                                                    echo '<span id="textoBtnUM3">'.$key["UMTOMA3"].'</span>';
                                                }
                                                ?>
                                                <span class="fa fa-caret-down"></span></button>
                                            <ul class="dropdown-menu" id="UMT3">
                                                <li><a href="javascript:void(0)">°c</a></li>
                                                <li><a href="javascript:void(0)">°f</a></li>
                                            </ul>
                                        </div>
                                        <!-- /btn-group -->
                                        <?php
                                        if(!$detalle){
                                        }else{
                                            foreach ($detalle as $key) {
                                            }
                                            echo '<input value="'.number_format($key["TOMA3"],0).'" autocomplete="off" type="text" id="toma3" class="form-control">';
                                        }
                                        ?>
                                        <span class="fa fa-file-text-o form-control-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group has-feedback">
                                    <label for="">3:00 p.m</label>
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <?php
                                                if(!$detalle){
                                                }else{
                                                    foreach ($detalle as $key) {
                                                    }
                                                    echo '<span id="textoBtnUM4">'.$key["UMTOMA4"].'</span>';
                                                }
                                                ?>
                                                <span class="fa fa-caret-down"></span></button>
                                            <ul class="dropdown-menu" id="UMT4">
                                                <li><a href="javascript:void(0)">°c</a></li>
                                                <li><a href="javascript:void(0)">°f</a></li>
                                            </ul>
                                        </div>
                                        <!-- /btn-group -->
                                        <?php
                                        if(!$detalle){
                                        }else{
                                            foreach ($detalle as $key) {
                                            }
                                            echo '<input value="'.number_format($key["TOMA4"],0).'" autocomplete="off" type="text" id="toma4" class="form-control">';
                                        }
                                        ?>
                                        <span class="fa fa-file-text-o form-control-feedback"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group has-feedback">
                                    <label for="">monitoreado por</label>
                                    <?php
                                    if(!$detalle){
                                    }else{
                                        foreach ($detalle as $key) {
                                        }
                                        echo '<input readonly="" value="'.$key["USUARIO"].'"
                                         autocomplete="off" type="text" id="monituser" class="form-control" placeholder="monitoreado por">';
                                    }
                                    ?>
                                    <span class="fa fa-user form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group has-feedback">
                                    <label for="">Observaciones</label>
                                    <?php
                                    if(!$detalle){
                                    }else{
                                        foreach ($detalle as $key) {
                                        }
                                        echo '<input value="'.$key["OBSERVACIONES"].'" type="text" id="observaciones" class="form-control" placeholder="Observaciones">';
                                    }
                                    ?>
                                    <span class="fa fa-pencil form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group has-feedback">
                                    <label for="">Verificacion de A/C</label>
                                    <?php
                                    if(!$detalle){
                                    }else{
                                        foreach ($detalle as $key) {
                                        }
                                        echo '<input value="'.$key["VERIFICACION_AC"].'" type="text" id="Verificacion" class="form-control" placeholder="">';
                                    }
                                    ?>
                                    <span class="fa fa-pencil form-control-feedback"></span>
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
                <table class="table table-bordered table-condensed table-striped" id="tblcrear">
                    <thead>
                    <tr>
                        <th class="text-center">N°</th>
                        <th>Sigla</th>
                        <th>Codigo</th>
                        <th class="text-center">Cuartos frios/ <br> Areas</th>
                        <th class="text-center">6:00 A.M</th>
                        <th class="text-center">8:00 A.M</th>
                        <th class="text-center">11:00 A.M</th>
                        <th class="text-center">3:00 P.M</th>
                        <th class="text-center">Observaciones</th>
                        <th class="text-center">Verrificacion de A/C</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php
                    $i = 1; $sigla = ""; $codigo = 0;
                    if(!$detalle){
                    }else{
                        foreach ($detalle as $key) {
                            if($key["IDAREA"] != null){
                                $sigla = "A";
                                $codigo = $key["IDAREA"];
                            }elseif ($key["IDSALA"] != null){
                                $sigla = "C";
                                $codigo = $key["IDSALA"];
                            }
                            echo "
                                <tr>
                                    <td>".$i."</td>
                                    <td>".$sigla."</td>
                                    <td>".$codigo."</td>
                                    <td>".$key["AREA"]."</td>
                                    <td>".number_format($key["TOMA1"],0)."</td>
                                    <td>".number_format($key["TOMA2"],0)."</td>
                                    <td>".number_format($key["TOMA3"],0)."</td>
                                    <td>".number_format($key["TOMA4"],0)."</td>
                                    <td>".$key["OBSERVACIONES"]."</td>
                                    <td>".$key["VERIFICACION_AC"]."</td>
                                </tr>
                            ";
                            $i++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>


<div class="modal fade" id="modalTemp" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times-circle text-bold"></i></span></button>
                <h4 class="modal-title text-center">PARAMETROS DE TEMPERATURAS</h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-6 col-sm-7 col-md-6 col-lg-6">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Cuartos Frios</th>
                                <th>Parametros de control</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!$salas){
                            }else{
                                foreach ($salas as $key) {
                                    echo "
                                        <tr>
                                            <td>".$key["NOMBRE"]."</td>
                                            <td class='text-center'>".number_format($key["DESDE"],0)."° C a ".number_format($key["HASTA"],0)."° C"."</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-6 col-sm-5 col-md-6 col-lg-6">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Areas</th>
                                <th>Parametros de control</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!$areas){
                            }else{
                                foreach ($areas as $key) {
                                    echo "
                                        <tr>
                                            <td>".$key["AREA"]."</td>
                                            <td class='text-center'>".number_format($key["DESDE"],0)."° C a ".number_format($key["HASTA"],0)."° C"."</td>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-------------------------------------------------------------------------------------------------------------------------------------->

<div class="modal" id="loading" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" style="background-color:transparent;box-shadow: none; border: none;margin-top: 26vh;">
            <div class="text-center">
                <img width="130px" src="<?php echo base_url()?>assets/img/loading.gif">
            </div>
        </div>
    </div>
</div>


