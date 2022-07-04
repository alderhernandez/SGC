<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 23/9/2019 13:54 2019
 * FileName: mcpe.php
 */?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
             Monitoreos De Calidad En Proceso De Empaque

            <a href="<?php echo base_url("index.php/nuevoMCPE")?>" class="pull-right btn btn-primary">
                Agregar <i class="fa fa-plus"></i>
            </a>
            <!--<small>Blank example to the fixed layout</small>-->
        </h1>
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
                <a class="btn-flat" href="<?php echo base_url("index.php/Informes")?>">
                    <i class="fa fa-arrow-circle-left fa-2x"></i>
                </a>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                        <i class="fa fa-minus"></i>
                    </button>
                    <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>-->
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs nav-tabs-justified">
                                    <li class="active"><a class="" href="#settings" data-toggle="tab">Caracteristicas de calidad</a></li>
                                    <li><a href="#ChangePass" data-toggle="tab">Verificacion de peso de baculas</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="settings">
                                        <div class="row">
                                            <div>
                                                <table id="tblCaracteristicas" class="table table-bordered table-condensed table-striped display nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>CodReporte</th>
                                                            <th>Cod Monitoreo</th>
                                                            <th>Version Informe</th>
                                                            <th>Fecha</th>
                                                            <th>Observaciones</th>
                                                            <th>Area</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                                                      $estado = '';
                                                            if(!$caract){
                                                            }else{
                                                                foreach ($caract as $item) {
                                                                    if($item["ESTADO"] == "A"){
                                                                        $estado = "<span class='text-success text-bold'>Activo</span>";
                                                                    }else {
                                                                        $estado = "<span class='text-danger text-bold'>Inactivo</span>";
                                                                    }
                                                                    echo "
                                                                        <tr>
                                                                            <td>".$item["IDREPORTE"]."</td>
                                                                            <td>".$item["SIGLA"]."</td>
                                                                            <td>".$item["VERSION"]."</td>
                                                                            <td>".$item["DIA"]."</td>
                                                                            <td>".$item["OBSERVACIONES"]."</td>
                                                                            <td>".$item["AREA"]."</td>
                                                                            <td>".$estado."</td>";
                                                                    if($item["ESTADO"] =="A"){
                                                                        echo "
                                                                                <td class='text-center'>
                                                                                    <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
                                                                                      <i class='fa fa-eye'></i>
                                                                                    </a>
                                                                                    <a class='btn btn-primary btn-xs' href='".base_url("index.php/editarMcpeCaract/".$item["IDREPORTE"]."")."'>
                                                                                      <i class='fa fa-pencil'></i>
                                                                                    </a>
                                                                                    <a onclick='DardeBaja(".'"'.$item["IDREPORTE"].'","'.$item["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
                                                                                      <i class='fa fa-trash'></i>
                                                                                    </a>
                                                                                </td>
                                                                            ";
                                                                    }else{
                                                                        echo "
                                                                                <td class='text-center'>
                                                                                    <a class='btn btn-success btn-xs disabled' href='javascript:void(0)'>
                                                                                      <i class='fa fa-eye'></i>
                                                                                    </a>
                                                                                    <a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
                                                                                      <i class='fa fa-pencil'></i>
                                                                                    </a>
                                                                                    <a onclick='DardeBaja(".'"'.$item["IDREPORTE"].'","'.$item["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
                                                                                      <i class='fa fa-trash'></i>
                                                                                    </a>
                                                                                </td>
                                                                            ";
                                                                    }
                                                                    echo"</tr>
                                                                     ";
                                                                }
                                                            }
                                                      ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="ChangePass">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <table id="tblPesoBasculas" class="table table-bordered table-condensed table-striped display nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>CodReporte</th>
                                                            <th>Cod Monitoreo</th>
                                                            <th>Version informe</th>
                                                            <th>Hora</th>
                                                            <th>Fecha</th>
                                                            <th>Area</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $estado = '';
                                                            if(!$peso){
                                                            }else{
                                                                foreach ($peso as $item) {
                                                                    if($item["ESTADO"]=="A"){
                                                                        $estado = "<span class='text-success text-bold'>Activo</span>";
                                                                    }else{
                                                                        $estado = "<span class='text-danger text-bold'>Inactivo</span>";
                                                                    }
                                                                     echo "
                                                                        <tr>
                                                                            <td>".$item["IDREPORTE"]."</td>
                                                                            <td>".$item["SIGLA"]."</td>
                                                                            <td>".$item["VERSION"]."</td>
                                                                            <td>".date_format(new DateTime($item["HORA"]), "H:i:s a")."</td>
                                                                            <td>".$item["DIA"]."</td>
                                                                            <td>".$item["AREA"]."</td>
                                                                            <td>".$estado."</td>";
                                                                         if($item["ESTADO"] =="A"){
                                                                             echo "
                                                                                <td class='text-center'>
                                                                                    <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
                                                                                      <i class='fa fa-eye'></i>
                                                                                    </a>
                                                                                    <a class='btn btn-primary btn-xs' href='".base_url("index.php/editarMcpePeso/".$item["IDREPORTE"]."")."'>
                                                                                      <i class='fa fa-pencil'></i>
                                                                                    </a>
                                                                                    <a onclick='DardeBaja(".'"'.$item["IDREPORTE"].'","'.$item["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
                                                                                      <i class='fa fa-trash'></i>
                                                                                    </a>
                                                                                </td>
                                                                            ";
                                                                         }else{
                                                                             echo "
                                                                                <td class='text-center'>
                                                                                    <a class='btn btn-success btn-xs disabled' href='javascript:void(0)'>
                                                                                      <i class='fa fa-eye'></i>
                                                                                    </a>
                                                                                    <a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
                                                                                      <i class='fa fa-pencil'></i>
                                                                                    </a>
                                                                                    <a onclick='DardeBaja(".'"'.$item["IDREPORTE"].'","'.$item["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
                                                                                      <i class='fa fa-trash'></i>
                                                                                    </a>
                                                                                </td>
                                                                            ";
                                                                         }
                                                                        echo"</tr>
                                                                     ";
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body
            <div class="box-footer">
                Footer
            </div>-->
            <!-- /.box-footer-->
        </div>

    </section>
</div>
