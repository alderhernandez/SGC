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
            hojaproceso = $("#hojaproceso").val(),
            batch = $("#batch").val(),
            ph = $("#ph").val(),
            tempPasta = $("#tempPasta").val(),
            lote = $("#lote").val(),
            pesoCarroVacio = $("#pesoCarroVacio").val(),
            pesoCarroProdEmb = $("#pesoCarroProdEmb").val(),
            cantidadVarilla = $("#cantVarilla").val(),
            pesoProdEmb = Number(pesoCarroProdEmb) - Number(pesoCarroVacio),
            totalpza = $("#totalpza").val(),
            pesoPromEmb = Number(pesoProdEmb) / Number(cantidadVarilla),
            porcentmermaProdEmb = (Number(cantidadVarilla) * Number(pesoPromEmb) / Number(batch)) * 100,
            pesoCarroCocinad = $("#pesoCarroCocinad").val(),
            pesoProdCocinado = $("#pesoProdCocinado").val(),
            pesoPromCocinado = Number(pesoProdCocinado) / Number(cantidadVarilla),
            porcentMermaProdCocinado = (Number(cantidadVarilla) * Number(pesoPromCocinado) / Number(batch)) *
            100, //100 - (Number(totalpza) * Number(pesoPromEmb) * 100) / Number(batch),
            pesoCarroProdRefri = $("#pesoCarroProdRefri").val(),
            pesoProdRefri = $("#pesoProdRefri").val(),
            pesoPromRefri = Number(pesoProdRefri) / Number(cantidadVarilla),
            porcentMermaProdRefri = (Number(cantidadVarilla) * Number(pesoPromRefri) / Number(batch)) * 100,
            pesoProdTerminado = $("#pesoProdTerm").val(),
            porcentRendimiento = Number(pesoProdTerminado) * 100 / Number(batch);

        //total merma sumar las mermas y divir entre 3

        let t = $("#tblProdEmbutido").DataTable({
            "info": false,
            "scrollX": true,
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
            batch,
            ph,
            tempPasta,
            lote,
            pesoCarroVacio,
            pesoCarroProdEmb,
            cantidadVarilla,
            pesoProdEmb.toFixed(2),
            totalpza,
            pesoPromEmb.toFixed(2),
            porcentmermaProdEmb.toFixed(2),
            pesoCarroCocinad,
            pesoProdCocinado,
            pesoPromCocinado.toFixed(2),
            porcentMermaProdCocinado.toFixed(2),
            pesoCarroProdRefri,
            pesoProdRefri,
            pesoPromRefri.toFixed(2),
            porcentMermaProdRefri.toFixed(2),
            pesoProdTerminado,
            porcentRendimiento.toFixed(2)
        ]).draw(false);

        $("#ph").val("");
        $("#tempPasta").val("");
        $("#pesoCarroProdEmb").val("");
        $("#totalpza").val("");
        $("#pesoPromEmb").val("");
        $("#pesoCarroCocinad").val("");
        $("#pesoProdCocinado").val("");
        $("#pesoCarroProdRefri").val("");
        $("#pesoProdRefri").val("");
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
                    detalle[i][0] = 18; //[IdReporte]
                    detalle[i][1] = $("#codigoVersion").text(); //[IdCatVersion]
                    detalle[i][2] = data[0]; //[IdArea]
                    detalle[i][3] = $("#idUser").val(); //[IdUsuario]
                    detalle[i][4] = data[1]; //[IdProducto]
                    detalle[i][5] = data[2]; //[ProdCocinado]
                    detalle[i][6] = data[3]; //[Presentacion]
                    detalle[i][7] = data[4]; //[HojaProceso]
                    detalle[i][8] = data[5]; //[CantBatch]
                    detalle[i][9] = data[6]; //[PH]
                    detalle[i][10] = data[7]; //[TemperaturaPasta]
                    detalle[i][11] = data[8]; //[Lote]
                    detalle[i][12] = data[9]; //[PesoCarroVacioVarilla]
                    detalle[i][13] = data[10]; //[PesoCarroProdEmb]
                    detalle[i][14] = data[11]; //[CantidadVarilla]
                    detalle[i][15] = data[12]; //[PesoProdEmb]
                    detalle[i][16] = data[13]; //[CantTotalPzasVarillas]
                    detalle[i][17] = data[14]; //[PesoPromedEmb]
                    detalle[i][18] = data[15]; //[PorcentMermaEmb]
                    detalle[i][19] = data[16]; //[PesoCarroProdCocinado]
                    detalle[i][20] = data[17]; //[PesoProdCocinado]
                    detalle[i][21] = data[18]; //[PesoPromedioCocinado]
                    detalle[i][22] = data[19]; //[ProcentMermaCocinado]
                    detalle[i][23] = data[20]; //[PesoCarroProdRefri]
                    detalle[i][24] = data[21]; //[PesoProdRefri]
                    detalle[i][25] = data[22]; //[PesoPromedioRefri]
                    detalle[i][26] = data[23]; //[PorcentMermaRefri]
                    detalle[i][27] = data[24]; //[PesoProdTerminado]
                    detalle[i][28] = data[25]; //[PorcentRendimiento]
                    detalle[i][29] = $("#Fecha").val(); //[Fecha]
                    i++;
                });

                let form_data = {
                    datos: JSON.stringify(detalle)
                };

                console.log(form_data);

                $.ajax({
                    url: '<?php echo base_url("index.php/guardarVecepc")?>',
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