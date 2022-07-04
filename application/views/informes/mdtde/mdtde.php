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
            Monitoreos De Temperatura Del Esterilizador

            <a href="<?php echo base_url("index.php/crearMdtde")?>" class="pull-right btn btn-primary">
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
                        <table id="tblMdtdedet" class="table table-bordered table-condensed table-striped table-responsive display nowrap">
                            <thead>
                            <tr>
                                <th>Cod Reporte</th>
                                <th>Monitoreo</th>
                                <th>Version</th>
                                <th>Area</th>
                                <th>Mes</th>
                                <th>Semana del</th>
                                <th>Monitoreado por</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $mes = ''; $estado = '';
                                    if(!$mdtde){
                                    }else{
                                        foreach ($mdtde as $item) {
                                            switch ($item["MES"])
                                            {
                                                case 1:
                                                    $mes = "Enero";
                                                    break;
                                                case 2:
                                                    $mes = "Febrero";
                                                    break;
                                                case 3:
                                                    $mes = "Marzo";
                                                    break;
                                                case 4:
                                                    $mes = "Abril";
                                                    break;
                                                case 5:
                                                    $mes = "Mayo";
                                                    break;
                                                case 6:
                                                    $mes = "Junio";
                                                    break;
                                                case 7:
                                                    $mes = "Julio";
                                                    break;
                                                case 8:
                                                    $mes = "Agosto";
                                                    break;
                                                case 9:
                                                    $mes = "Septiembre";
                                                    break;
                                                case 10:
                                                    $mes = "Octubre";
                                                    break;
                                                case 11:
                                                    $mes = "Noviembre";
                                                    break;
                                                default:
                                                    $mes = "Diciembre";
                                                    break;
                                            }
                                            switch ($item["ESTADO"]){
                                                case "A":
                                                    $estado = "<span class='text-bold text-success'>Activo</span>";
                                                    break;
                                                default:
                                                    $estado = "<span class='text-bold text-danger'>Inactivo</span>";
                                            }
                                            echo "
                                                <tr>
                                                    <td>".$item["IDREPORTE"]."</td>
                                                    <td>".$item["SIGLAS"]."</td>
                                                    <td>".$item["VERSION"]."</td>
                                                    <td>".$item["AREA"]."</td>
                                                    <td>".$mes." ".$item["ANIO"]."</td>
                                                    <td>".$item["SEMANA"]."</td>
                                                    <td>".$item["USUARIO"]."</td>
                                                    <td>".$estado."</td>";
                                            if($item["ESTADO"] == "A"){
                                                echo "
                                                <td class='text-center'>
                                                   <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
                                                       <i class='fa fa-eye'></i>
                                                   </a>
                                                   <a class='btn btn-primary btn-xs' href='".base_url('index.php/editarmdtde/'.$item["IDREPORTE"].'')."'>
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
                                                   <a class='detalles btn btn-success btn-xs disabled' href='javascript:void(0)'>
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
            <!-- /.box-body
            <div class="box-footer">
                Footer
            </div>-->
            <!-- /.box-footer-->
        </div>

    </section>
</div>

