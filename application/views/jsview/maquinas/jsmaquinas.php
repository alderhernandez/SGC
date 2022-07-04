<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 1/10/2019 15:05 2019
 * FileName: jsmaquinas.php
 */
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tblMaquinas").DataTable({
            "info": true,
            "sort": true,
            "lengthMenu": [
                [10,20,50,100, -1],
                [10,20,50,100, "Todo"]
            ],
            "order": [
                [2, "desc"]
            ],
            "language": {
                "info": "Registro _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Registro 0 a 0 de 0 entradas",
                "zeroRecords": "No se encontro coincidencia",
                "infoFiltered": "(filtrado de _MAX_ registros en total)",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "lengthMenu": '_MENU_ ',
                "search": 'Buscar:  ',
                "loadingRecords": "",
                "processing": "Procesando datos  <i class='fa fa-spin fa-refresh'></i>",
                "paginate": {
                    "first": "Primera",
                    "last": "Última ",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });

    $("#btnModal").click(function () {
        $("#modalEncabezado").text("Nueva máquina");
        $("#idmaquina").val("");
        $("#maquina").val("");
        $("#siglas").val("");
        $("#btnGuardar").show();
        $("#btnActualizar").hide();
        $("#modalMaquinas").modal("show");
    });

    function editar(idmaq,maq,siglas)
    {
            $("#modalEncabezado").text("Editar máquina");
            $("#idmaquina").val(idmaq);
            $("#maquina").val(maq);
            $("#siglas").val(siglas);
            $("#btnGuardar").hide();
            $("#btnActualizar").show();
            $("#modalMaquinas").modal("show");
    }
    
    $("#btnGuardar").click(function () {
        if($("#maquina").val() == "" || $("#siglas").val() == ""){
            Swal.fire({
                text: "Todos los campos son requeridos",
                type: "error",
                allowOutsideClick: false
            });
        }else{
            let tipo = '', mensaje = '';
            let form_data = {
                maquina: $("#maquina").val(),
                siglas: $("#siglas").val()
            };
            $.ajax({
                url: "guardarMaquina",
                type: "POST",
                data: form_data,
                success: function (data) {
                    let obj = jQuery.parseJSON(data);
                    $.each(obj, function (i, index) {
                        mensaje = index["mensaje"];
                        tipo = index["tipo"];
                    });
                    Swal.fire({
                        text: mensaje,
                        type: tipo,
                        allowOutsideClick: false
                    }).then((result)=>{
                        location.reload();
                    });
                }
            });
        }
    });

    $("#btnActualizar").click(function () {
        if($("#maquina").val() == "" || $("#siglas").val() == ""){
            Swal.fire({
                text: "Todos los campos son requeridos",
                type: "error",
                allowOutsideClick: false
            });
        }else{
            let tipo = '', mensaje = '';
            let form_data = {
                idmaquina: $("#idmaquina").val(),
                maquina: $("#maquina").val(),
                siglas: $("#siglas").val()
            };
            $.ajax({
                url: "actualizarMaquina",
                type: "POST",
                data: form_data,
                success: function (data) {
                    let obj = jQuery.parseJSON(data);
                    $.each(obj, function (i, index) {
                        mensaje = index["mensaje"];
                        tipo = index["tipo"];
                    });
                    Swal.fire({
                        text: mensaje,
                        type: tipo,
                        allowOutsideClick: false
                    }).then((result)=>{
                        location.reload();
                    });
                }
            });
        }
    });

    function Baja(id,estado){
        let mensaje = '';
        if(estado == 'A'){mensaje = '¿Estas seguro de deseas dar de baja esta maquina?'}
        else{mensaje='¿Estas seguro de deseas restaurar esta maquina?'}
        Swal.fire({
            text: mensaje,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false
        }).then((result) =>{
            if(result.value){
                let message = '', tipo = '';
                let form_data = {
                    id: id,
                    estado: estado
                };
                $.ajax({
                      url: "BajaAlta",
                      type: "POST",
                      data: form_data,
                    success: function (data) {
                        let obj = jQuery.parseJSON(data);
                        $.each(obj, function (i, index) {
                           message = index["mensaje"];
                           tipo = index["tipo"];
                        });
                        Swal.fire({
                            text: message,
                            type: tipo,
                            allowOutsideClick: false
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });
            }
        });
    }
</script>
