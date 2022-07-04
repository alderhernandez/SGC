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
    }
});

$('#tblProdEmbutido tbody').on('click', 'tr', function() {
    $(this).toggleClass('danger');
});

$("#btnDelete").click(function() {
    let table = $("#tblProdEmbutido").DataTable();
    let rows = table.rows('.danger').remove().draw();
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
            lote = $("#lote").val(),
            batch = $("#batch").val(),
            pesoCarroVacio = $("#pesoCarroVacio").val(),
            pesoCarroBugi = $("#pesoCarroBugi").val(),
            pesoProdCrudo = $("#pesoProdCrudo").val(),
            pesoBugi = $("#pesoBugi").val(),
            pesoCocinadoBugi = $("#pesoCocinadoBugi").val(),
            totalpzacocinadas = $("#totalpzacocinadas").val(),
            porcentajeMermaCocinado = (Number(pesoCocinadoBugi) - Number(pesoBugi)) / Number(totalpzacocinadas),
            cantTotalPzasProd = $("#cantTotalPzasProd").val(),
            pesoCarroProdCong = $("#pesoCarroProdCong").val(),
            pesoProdRefrigerado = Number(pesoCarroProdCong) - Number(pesoBugi),
            porcentajeMermaRefri = (Number(pesoProdRefrigerado) - Number(pesoBugi)) / Number(totalpzacocinadas),
            mermaTotal = (Number(porcentajeMermaCocinado) + Number(porcentajeMermaRefri)) / 2,
            TotalRecorte = $("#TotalRecorte").val(),
            pesoProdTerm = $("#pesoProdTerm").val(),
            porcentajeRend = (Number(pesoProdTerm) + Number(TotalRecorte)) / Number(batch) * 100,
            observaciones = $("#observaciones").val();


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
            lote,
            batch,
            pesoCarroVacio,
            pesoCarroBugi,
            pesoProdCrudo,
            pesoBugi,
            pesoCocinadoBugi,
            totalpzacocinadas,
            cantTotalPzasProd,
            porcentajeMermaCocinado.toFixed(2),
            pesoCarroProdCong,
            pesoProdRefrigerado.toFixed(2),
            porcentajeMermaRefri.toFixed(2),
            mermaTotal.toFixed(2),
            TotalRecorte,
            pesoProdTerm,
            porcentajeRend.toFixed(2),
            observaciones
        ]).draw(false);
    }
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
                    detalle[i][0] = $("#codigoReporte").text(); //[IdReporte]
                    detalle[i][1] = $("#codigoVersion").text(); //[IdCatVersion]
                    detalle[i][2] = data[0]; //[IdArea]
                    detalle[i][3] = $("#idUser").val(); //[IdUsuario]
                    detalle[i][4] = data[1]; //IdProducto
                    detalle[i][5] = data[2]; //ProdCocinados
                    detalle[i][6] = data[3]; //Presentacion
                    detalle[i][7] = data[4]; //HojaProceso
                    detalle[i][8] = data[5]; //Lotes
                    detalle[i][9] = data[6]; //CantBatch
                    detalle[i][10] = data[7]; //PesoCarroVacio
                    detalle[i][11] = data[8]; //PesoCarroProdCrudo
                    detalle[i][12] = data[9]; //PesoProdCrudo
                    detalle[i][13] = data[10]; //PesoBugi
                    detalle[i][14] = data[11]; //PesoProdCocinadoBugi
                    detalle[i][15] = data[12]; //TotalPiezasCocinada
                    detalle[i][16] = data[13]; //TotalPiezasPorProd
                    detalle[i][17] = data[14]; //PorcentajeMermaCocinado
                    detalle[i][18] = data[15]; //PesoCarroProdCongelado
                    detalle[i][19] = data[16]; //PesoProdRefrigerado
                    detalle[i][20] = data[17]; //PorcentajeMermaRefrigeracion
                    detalle[i][21] = data[18]; //MermaTotal
                    detalle[i][22] = data[19]; //TotalRecorte
                    detalle[i][23] = data[20]; //PesoProdTerminado
                    detalle[i][24] = data[21]; //PorcentajeRend
                    detalle[i][25] = data[22]; //Observaciones
                    detalle[i][26] = $("#Fecha").val(); //[Fecha]
                    i++;
                });

                let form_data = {
                    datos: JSON.stringify(detalle)
                };

                console.log(form_data);

                $.ajax({
                    url: '<?php echo base_url("index.php/guardarCdha")?>',
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