<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/11/2019 10:59 2019
 * FileName: cdt.php
 */
?>
<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 24/10/2019 10:15 2019
 * FileName: mdte.php
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Control de Temperaturas

            <a href="<?php echo base_url("index.php/crearCdt")?>" class="pull-right btn btn-primary">
                Agregar <i class="fa fa-plus"></i>
            </a>
            <!--<small>Blank example to the fixed layout</small>-->
        </h1>
        <!--<ol class="breadcrumb">
            <li class="active"></li>
        </ol>-->
        <br>
        <div class="row">
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <div class="form-group has-feedback">
                  <input autocomplete="off" type="text" id="fechaFilter1" class="form-control" placeholder="DESDE">
                  <span class="fa fa-calendar form-control-feedback"></span>
              </div>
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <div class="form-group has-feedback">
                  <input autocomplete="off" type="text" id="fechaFilter2" class="form-control" placeholder="HASTA">
                  <span class="fa fa-calendar form-control-feedback"></span>
              </div>
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <div class="form-group has-feedback">
                <button type="button" id="btnFiltrar" class="btn btn-success" name="">
                  Filtrar <i class="fa fa-search"></i>
                </button>
                <button type="button" id="btnActualizarInfo" class="btn btn-success" name="">
                  Actualizar <i class="fa fa-refresh"></i>
                </button>
              </div>
          </div>
        </div>
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
                        <table id="tblCdt" class="table table-bordered table-condensed table-striped display nowrap">
                            <thead>
                            <tr>
                                <th>Cod Reporte</th>
                                <th>Monitoreo</th>
                                <th>Version</th>
                                <th>Fecha</th>
                                <th>Monitoreado por</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    /*$estado = '';
                                    if(!$cdt){
                                    }else{
                                        foreach ($cdt as $key) {
                                            if($key["ESTADO"] == "A")
                                            {
                                                $estado = "<span class='text-success text-bold'>Activo</span>";
                                            }else{
                                                $estado = "<span class='text-danger text-bold'>Inactivo</span>";
                                            }
                                            echo "
                                                <tr>
                                                    <td>".$key["IDREPORTE"]."</td>
                                                    <td>".$key["SIGLA"]."</td>
                                                    <td>".$key["VERSION"]."</td>
                                                    <td>".date_format(new DateTime($key["FECHAINICIO"]), "Y-m-d")."</td>
                                                    <td>".$key["USUARIO"]."</td>
                                                    <td>".$estado."</td>";
                                            if($key["ESTADO"] == "A"){
                                                echo "
                                                <td class='text-center'>
                                                   <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
                                                       <i class='fa fa-eye'></i>
                                                   </a>
                                                   <a class='btn btn-primary btn-xs' href='".base_url("index.php/editarCdt/".$key["IDREPORTE"]."")."'>
                                                       <i class='fa fa-pencil'></i>
                                                   </a>
                                                   <a onclick='DardeBaja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
                                                       <i class='fa fa-trash'></i>
                                                   </a>
                                                </td>
                                                ";
                                            }else{
                                                echo "
                                                <td class='text-center'>
                                                   <a class='detalles btn btn-success btn-xs disabled' href='javascript:void(0)'>
                                                       <i class='fa fa-eye'></i>
                                                   </a>
                                                   <a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
                                                       <i class='fa fa-pencil'></i>
                                                   </a>
                                                   <a onclick='DardeBaja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
                                                       <i class='fa fa-trash'></i>
                                                   </a>
                                                </td>
                                                ";
                                            }
                                            echo"</tr>
                                            ";
                                        }
                                    }*/
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
