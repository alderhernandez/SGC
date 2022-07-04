<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 6/9/2019 16:34 2019
 * FileName: ppcn3.php
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Monitoreo de Esterilizacion PCC N° 3

            <a href="<?php echo base_url("index.php/nuevoPCCN3")?>" class="pull-right btn btn-primary">
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
                <table class="table table-bordered table-condensed table-striped" id="tblPccn3">
                    <thead>
                    <tr>
                        <!--<th>Fecha de ingreso <br>a premezcla</th>
                        <th>Canitdad de nitrito <br>solicitado</th>
                        <th>Cantidad Kg. <br>sal de cura obtenida</th>
                        <th>Monitoreado por</th>
                        <th>Acciones</th>-->
                        <th>CodReporte</th>
                        <th>Monitoreo</th>
                        <th>Dia</th>
                        <th>Hora <br> Identific.</th>
                        <th>Fecha</th>
                        <th>Monitoreado por</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $estado = '';
                            if(!$datos){
                            }else{
                                foreach ($datos as $dato) {
                                    switch ($dato["ESTADO"])
                                    {
                                        case "A":
                                                $estado = "<span class='text-success text-bold'>Activo</span>";
                                            break;
                                        default:
                                                $estado = "<span class='text-danger text-bold'>Inactivo</span>";
                                            break;
                                    }
                                    echo "
                                        <tr>
                                            <td>".$dato["IDREPORTE"]."</td>
                                            <td>".$dato["SIGLA"]."</td>
                                            <td>".$dato["DIA"]."</td>
                                            <td>".date_format(new DateTime($dato["HORAIDENTIFICACION"]),"H:i:s")."</td>
                                            <td>".date_format(new DateTime($dato["FECHAINICIO"]),"Y-m-d")."</td>
                                            <td>".$dato["USUARIO"]."</td>
                                            <td>".$estado."</td>";
										if($dato["ESTADO"] == "A"){
											echo "
															<td class='text-center'>
																<a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
																  <i class='fa fa-eye'></i>
																</a>
																<a class='btn btn-primary btn-xs' href='".base_url("index.php/editarPccn3/".$dato["IDREPORTE"]."")."'>
																  <i class='fa fa-pencil'></i>
																</a>
																<a onclick='darDeBaja(".'"'.$dato["IDREPORTE"].'","'.$dato["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
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
																<a onclick='darDeBaja(".'"'.$dato["IDREPORTE"].'","'.$dato["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
																  <i class='fa fa-undo' aria-hidden='true'></i>
																</a>
															</td>
														";
										}
										echo "</tr>						
									";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body
            <div class="box-footer">
                Footer
            </div>-->
            <!-- /.box-footer-->
        </div>

    </section>
</div>

