<script>
$(document).ready(function() {
    $("#fechaFilter1,#fechaFilter2").datepicker({
        "autoclose": true
    });
    cargarDatosAjax();
});

function cargarDatosAjax() {
    let table = $("#tblCdha").DataTable({
        "ajax": {
            "url": '<?php echo base_url("index.php/getCdhaAjax")?>',
            "type": "POST",
            "data": function(d) {
                d.fecha1 = $("#fechaFilter1").val();
                d.fecha2 = $("#fechaFilter2").val();
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "processing": true,
        "orderMulti": false,
        "info": true,
        "sort": true,
        "destroy": true,
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
            "search": '<i class="fa fa-search"></i>',
            "loadingRecords": "",
            "processing": "Procesando datos  <i class='fa fa-spin fa-refresh'></i>",
            "paginate": {
                "first": "Primera",
                "last": "Última ",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        "columns": [{
                "data": "Consecutivo"
            },
            {
                "data": "AREA"
            },
            {
                "data": "Usuario"
            },
            {
                "data": "Fecha"
            },
            {
                "data": "Estado"
            },
            {
                "data": "Acciones"
            }
        ]
    });
}

$("#btnActualizarInfo").click(function() {
    cargarDatosAjax();
});

$("#btnFiltrar").click(function() {
    cargarDatosAjax();
});

function mostrarDetalles(callback, id, div) {
    $.ajax({
        url: "getDetCdhaAjax/" + id,
        async: true,
        success: function(response) {

            let thead = '',
                tbody = '';
            if (response != "false") {
                let obj = $.parseJSON(response);
                thead += "<th class='text-center bg-primary'>IdProducto</th>";
                thead += "<th class='text-center bg-primary'<ProdCocinado/th>";
                thead += "<th class='text-center bg-primary'>Presentacion</th>";
                thead += "<th class='text-center bg-primary'>HojaProceso</th>";
                thead += "<th class='text-center bg-primary'>CantBatch</th>";
                thead += "<th class='text-center bg-primary'>PesoProdTerminado</th>";
                thead += "<th class='text-center bg-primary'>PorcentRendimiento</th></tr>";
                $.each(obj, function(i, item) {
                    tbody += "<tr>" +
                        "<td class='text-center bg-info'>" + item["IdProducto"] + "</td>" +
                        "<td class='text-center bg-info'>" + item["ProdCocinado"] + "</td>" +
                        "<td class='text-center bg-info'>" + item["Presentacion"] + "</td>" +
                        "<td class='text-center bg-info'>" + item["HojaProceso"] + "</td>" +
                        "<td class='text-center bg-info'>" + item["CantBatch"] + "</td>" +
                        "<td class='text-center bg-info'>" + item["PesoProdTerminado"] + "</td>" +
                        "<td class='text-center bg-info'>" + item["PorcentRendimiento"] + "</td>";
                });
                callback($("<table id='tbldetCdha' class='table table-bordered table-condensed table-striped'>" +
                    thead + tbody + "</table>")).show();
            } else {
                head += "<th class='text-center bg-primary'>IdProducto</th>";
                thead += "<th class='text-center bg-primary'<ProdCocinado/th>";
                thead += "<th class='text-center bg-primary'>Presentacion</th>";
                thead += "<th class='text-center bg-primary'>HojaProceso</th>";
                thead += "<th class='text-center bg-primary'>CantBatch</th>";
                thead += "<th class='text-center bg-primary'>PesoProdTerminado</th>";
                thead += "<th class='text-center bg-primary'>PorcentRendimiento</th></tr>";
                tbody += "<tr>" +
                    "<td class='text-center bg-info'></td>" +
                    "<td class='text-center bg-info'></td>" +
                    "<td class='text-center bg-info'></td>" +
                    "<td class='text-center bg-info'>No hay datos disponibles</td>" +
                    "<td class='text-center bg-info'></td>" +
                    "<td class='text-center bg-info'></td>" +
                    "<td class='text-center bg-info'></td>";
                callback($('<table id="tbldetCdha" class="table table-bordered table-condensed table-striped">' +
                    thead + tbody + '</table>')).show();
            }
        }
    });
}

$("#tblCdha").on("click", "tbody .detalles", function() {
    let table = $("#tblCdha").DataTable();
    let tr = $(this).closest("tr");
    //$(this).addClass("detalleNumOrdOrange");
    let row = table.row(tr);
    let data = table.row($(this).parents("tr")).data();

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass("shown");
    } else {
        mostrarDetalles(row.child, data.Consecutivo, data.Consecutivo);
        tr.addClass("shown");
    }
});

function bajaCdha(consecutivo, estado) {
    let message = '',
        text = '';
    if (estado == "A") {
        message = 'Se dará de baja el informe, éste ya no podra ser utilizada en el sistema.' +
            '¿Desea continuar?';
        text = 'Dar baja';
    } else {
        message = '¿Desea restaurar el informe ?';
        text = "Restaurar";
    }
    Swal.fire({
        text: message,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: text,
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $("#loading").modal("show");
            let mensaje = '',
                tipo = '';
            let form_data = {
                consecutivo: consecutivo,
                estado: estado
            };

            $.ajax({
                url: "bajaCdha",
                type: "POST",
                data: form_data,
                success: function(data) {
                    $("#loading").modal("hide");
                    let obj = jQuery.parseJSON(data);
                    $.each(obj, function(i, index) {
                        mensaje = index["mensaje"];
                        tipo = index["tipo"];
                    });
                    Swal.fire({
                        text: mensaje,
                        type: tipo,
                        allowOutsideClick: false
                    }).then(function() {
                        location.reload();
                    });
                }
            });
        }
    });
}
</script>