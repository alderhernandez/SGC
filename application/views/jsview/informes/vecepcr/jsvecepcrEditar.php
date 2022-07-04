<script>
$(document).ready(function() {
    $("#ddlAreas").select2({
        placeholder: "Seleccione un area",
        allowClear: true,
        language: "es"
    });

    $(".js-data-example-ajax").select2({
        placeholder: "",
        allowClear: true,
        language: "es",
        ajax: {
            url: '<?php echo base_url("index.php/getProductosSAP")?>',
            dataType: 'json',
            type: "POST",
            async: true,
            quietMillis: 100,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                let res = [];
                for (let i = 0; i < data.length; i++) {
                    res.push({
                        id: data[i].ItemCode,
                        text: data[i].ItemName
                    });
                }
                return {
                    results: res
                }
            }
        }
    }).trigger('change');
});

$(".js-data-example-ajax").on("change", function() {
    let codigo = $("#ddlprod option:selected").val();
    let texto = $("#ddlprod option:selected").text();
    if (codigo == undefined) {
        $("#presentacion").val("");
        $("#pesoCarroVacio").val("");
    } else {
        $.ajax({
            url: '<?php echo base_url("index.php/getPresentacionById")?>' + "/" + codigo,
            type: "POST",
            success: function(data) {
                let obj = jQuery.parseJSON(data);
                $.each(obj, function(i, index) {
                    $("#presentacion").val(Number(index.SWeight1).toFixed(0));
                });
            }
        });
        /*if (texto.includes("MORTADELA")) {
            $("#pesoCarroVacio").val(Number("61.2"));
        } else if (texto.includes("SALCHICHA")) {
            $("#pesoCarroVacio").val(Number("46.6"));
        } else {
            $("#pesoCarroVacio").val("");
        }*/
    }
});

$("#btnAdd").click(function() {
    let campos, valido = true;
    campos = document.querySelectorAll("#campos input.form-control");
    [].slice.call(campos).forEach(function(campo) {
        $("#" + campo.id).parent("div").removeClass("has-error");
        if (campo.value.trim() === '') {
            valido = false;
            $("#" + campo.id).parent("div").addClass("has-error");
        }
    });

    if (!valido) {
        Swal.fire({
            text: "Todos los campos son requeridos",
            type: "warning",
            allowOutsideClick: false
        });
    } else {
        if ($("#ddlAreas").val() == "") {
            Swal.fire({
                text: "Debe seleccionar un Area",
                type: "warning",
                allowOutsideClick: false
            });
        } else if ($(".js-data-example-ajax").val() == "") {
            Swal.fire({
                text: "Debe seleccionar un producto",
                type: "warning",
                allowOutsideClick: false
            });
        }

        let ddlAreas = $("#ddlAreas").val(),
            monituser = $("#monituser").val(),
            ddlprod = $("#ddlprod option:selected").val(),
            presentacion = $("#presentacion").val(),
            pres = "0." + presentacion,
            hojaproceso = $("#hojaproceso").val(),
            lote = $("#lote").val(),
            batch = $("#batch").val(),
            ph = $("#ph").val(),
            tempPasta = $("#tempPasta").val(),
            pesoCajillaVac = $("#pesoCajillaVac").val(),
            pesoPromUnidad = $("#pesoPromUnidad").val(),
            totalunidades = $("#totalunidades").val(),
            porcentRend = (Number(totalunidades) * Number(pres) / Number(batch)) * 100,
            porcentMerma = 100 - porcentRend,
            observaciones = $("#observaciones").val();

        //total merma sumar las mermas y divir entre 3

        let t = $("#tblProdEmbutido").DataTable({
            "info": false,
            "scrollX": false,
            "sort": false,
            "destroy": true,
            "searching": false,
            "paginate": false,
            "lengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "Todo"]
            ],
            "order": [
                [0, "desc"]
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

        t.row.add([
            ddlAreas,
            ddlprod,
            $("#ddlprod option:selected").text(),
            presentacion,
            hojaproceso,
            lote,
            batch,
            ph,
            tempPasta,
            pesoCajillaVac,
            pesoPromUnidad,
            totalunidades,
            porcentRend.toFixed(2),
            porcentMerma.toFixed(2),
            observaciones
        ]).draw(false);

        $("#hojaproceso").val("");
        $("#lote").val("");
        $("#batch").val("");
        $("#ph").val("");
        $("#tempPasta").val("");
        $("#pesoCajillaVac").val("");
        $("#pesoPromUnidad").val("");
        $("#totalunidades").val("");
        $("#observaciones").val("");
    }
});

$('#tblProdEmbutido tbody').on('click', 'tr', function() {
    $(this).toggleClass('danger');
});

$("#btnDelete").click(function() {
    let table = $("#tblProdEmbutido").DataTable();
    let rows = table.rows('.danger').remove().draw();
});

$("#btnGuardar").click(function() {
    Swal.fire({
        text: "¿Estas seguro que todos los datos están correctos?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $("#loading").modal("show");
            let table = $('#tblProdEmbutido').DataTable();
            if (!table.data().count()) {
                $("#loading").modal("hide");
                Swal.fire({
                    text: "No se ha agregado ningún registro a la tabla",
                    type: "error",
                    allowOutsideClick: false
                });
            } else {

                let mensaje = '',
                    tipo = '',
                    detalle = new Array(),
                    table = $("#tblProdEmbutido").DataTable();
                let i = 0;

                table.rows().eq(0).each(function(i, index) {
                    let row = table.row(index);
                    let data = row.data();
                    detalle[i] = [];
                    detalle[i][0] = 19; //[IdReporte]
                    detalle[i][1] = $("#codigoVersion").text(); //[IdCatVersion]
                    detalle[i][2] = data[0]; //[IdArea]
                    detalle[i][3] = $("#idUser").val(); //[IdUsuario]
                    detalle[i][4] = data[1]; //[IdProducto]
                    detalle[i][5] = data[2]; //[ProdCocinado]
                    detalle[i][6] = data[3]; //[Presentacion]
                    detalle[i][7] = data[4]; //[HojaProceso]
                    detalle[i][8] = data[5]; //[Lote]
                    detalle[i][9] = data[6]; //[CantBatch]
                    detalle[i][10] = data[7]; //[PH]
                    detalle[i][11] = data[8]; //[TemperaturaPasta]
                    detalle[i][12] = data[9]; //[PesoCajillaVacia]
                    detalle[i][13] = data[10]; //[PesoPromUnidad]
                    detalle[i][14] = data[11]; //[CantidadTotalUnid]
                    detalle[i][15] = data[12]; //[Rendimiento]
                    detalle[i][16] = data[13]; //[Merma]
                    detalle[i][17] = data[14]; //[Observaciones]
                    detalle[i][18] = $("#Fecha").val();
                    detalle[i][19] = $("#Consecutivo").val();
                    i++;
                });

                let form_data = {
                    consecutivo: $("#Consecutivo").val(),
                    datos: JSON.stringify(detalle)
                };

                $.ajax({
                    url: '<?php echo base_url("index.php/actualizarVecepcr")?>',
                    type: "POST",
                    data: form_data,
                    success: function(data) {
                        let obj = jQuery.parseJSON(data);
                        $.each(obj, function(i, index) {
                            mensaje = index["mensaje"];
                            tipo = index["tipo"];
                        });
                        $("#loading").modal("hide");
                        Swal.fire({
                            text: mensaje,
                            type: tipo,
                            allowOutsideClick: false
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });
            }
        }
    });
});
</script>