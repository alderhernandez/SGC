<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 14/10/2019 11:38 2019
 * FileName: eepdc.php
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Evaluacion De Envases Para Doble Cierre

            <a href="<?php echo base_url("index.php/crearEepdc")?>" class="pull-right btn btn-primary">
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
                        <table id="tblEepdc" class="table table-bordered table-condensed table-striped display nowrap">
                            <thead>
                                <tr>
                                    <th>Cod Reporte</th>
                                    <th>Monitoreo</th>
                                    <th>Dia</th>
                                    <th>Area</th>
                                    <th>Version</th>
                                    <th>Empresa</th>
                                    <th>Monitoreado por</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $estado = ''; $empresa = '';
                                    if(!$data){
                                    }else{
                                        foreach ($data as $key) {
                                            if($key["ESTADO"] == "A"){
                                                $estado = "<span class='text-success text-bold'>Activo</span>";
                                            }else {
                                                $estado = "<span class='text-danger text-bold'>Inactivo</span>";
                                            }
                                            if($key["IDEMPRESA"] == 1){
                                                $empresa = "DELMOR";
                                            }else if($key["IDEMPRESA"] == 2){
                                                $empresa = "D´lago";
                                            }else{
                                                $empresa = "Panamá";
                                            }
                                            echo "
                                                  <tr>
                                                        <td>".$key["IDREPORTE"]."</td>
                                                        <td>".$key["SIGLA"]."</td>
                                                        <td>".$key["DIA"]."</td>
                                                        <td>".$key["AREA"]."</td>
                                                        <td>".$key["VERSION"]."</td>
                                                        <td>".$empresa."</td>
                                                        <td>".$key["NOMBRES"]."</td>
                                                        <td>".$estado."</td>";
                                                                    if($key["ESTADO"] =="A"){
                                                                        echo "
                                                                                <td class='text-center'>
                                                                                    <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
                                                                                      <i class='fa fa-eye'></i>
                                                                                    </a>
                                                                                    <a class='btn btn-primary btn-xs' href='".base_url("index.php/getEepdcByID/".$key["IDREPORTE"]."")."'>
                                                                                      <i class='fa fa-pencil'></i>
                                                                                    </a>
                                                                                    <a onclick='BajaEepdc(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")' 
                                                                                       class='btn btn-danger btn-xs' href='javascript:void(0)'>
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
                                                                                    <a onclick='BajaEepdc(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
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
            <!-- /.box-body
            <div class="box-footer">
                Footer
            </div>-->
            <!-- /.box-footer-->
        </div>

    </section>
</div>

