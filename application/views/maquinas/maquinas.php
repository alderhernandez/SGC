<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 1/10/2019 14:56 2019
 * FileName: maquinas.php
 */
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $this->uri->segment(1)?>
            <button class="pull-right btn btn-primary" data-toggle="modal" id="btnModal">
                Agregar <i class="fa fa-plus"></i>
            </button>
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
                <h3 class="box-title">Lista de Maquinas</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                        <i class="fa fa-minus"></i></button>
                    <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>-->
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed table-striped" id="tblMaquinas">
                    <thead>
                    <tr>
                        <th>Maquina</th>
                        <th>Siglas</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Edición</th>
                        <th>Fecha Baja</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $estado = '';
                            if(!$maq){
                            }else{
                                foreach ($maq as $item) {
                                    switch ($item["ESTADO"])
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
                                            <td>".$item["MAQUINA"]."</td>
                                            <td>".$item["SIGLAS"]."</td>
                                            <td>".date_format(new DateTime($item["FECHACREA"]),"Y-m-d")."</td>
                                            <td>".$item["FECHAEDITA"]."</td>
                                            <td>".$item["FECHABAJA"]."</td>
                                            <td>".$estado."</td>";
									  	  if($item["ESTADO"] == "A"){
											echo "
											<td class='text-center'>
												 <a onclick='editar(".'"'.$item["IDMAQUINA"].'","'.$item["MAQUINA"].'","'.$item["SIGLAS"].'"'.")'
												    href='javascript:void(0)' class='btn btn-primary btn-xs'>
											        <i class='fa fa-pencil'></i></a>
											      <a onclick='Baja(".'"'.$item["IDMAQUINA"].'","'.$item["ESTADO"].'"'.")' href='javascript:void(0)' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></a>
											  </td>
											";
										  }else{
											echo "
									  	 	  <td class='text-center'>
												 <a href='javascript:void(0)' class='btn btn-primary btn-xs disabled'>
											        <i class='fa fa-pencil'></i></a>
											      <a onclick='Baja(".'"'.$item["IDMAQUINA"].'","'.$item["ESTADO"].'"'.")' href='javascript:void(0)' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></a>
											  </td>
											";
										  }
									  echo"</td>
									</tr>";
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


<div class="modal fade" id="modalMaquinas" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-sitemap"></i> <span id="modalEncabezado"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6">
                        <input autocomplete="off" type="hidden" id="Id" class="form-control">
                        <div class="form-group has-feedback">
                            <label for="maquina">Nombre máquina</label>
                            <input autocomplete="off" type="hidden" id="idmaquina" class="form-control">
                            <input autocomplete="off" type="text" id="maquina" class="form-control" placeholder="Nombre maquina">
                            <span class="fa fa-sitemap form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group has-feedback">
                            <label for="siglas">Siglas</label>
                            <input autocomplete="off" type="text" id="siglas" class="form-control" placeholder="siglas">
                            <span class="fa fa-pencil form-control-feedback"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnGuardar" type="button" class="btn btn-primary">Guardar</button>
                <button id="btnActualizar" type="button" class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </div>
</div>


