<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 9/9/2019 15:13 2019
 * FileName: jsPCCN3.php
 */
?>
<script type="text/javascript">
    $(document).ready(function () {
       /* $(".clockpicker").clockpicker({
            donetext: "Aceptar"
        });*/

        $('#fecha').datepicker({"autoclose":true});
        $("#temperatura,#produccion,#tiempo,#version").numeric();
        $(".js-data-example-ajax").select2({
                placeholder: '--- Seleccione un Producto ---',
                allowClear: true,
                ajax: {
                    url: '<?php echo base_url("index.php/getProductosSAP")?>',
                    dataType: 'json',
                    type: "POST",
                    quietMillis: 100,
                    data: function (params) {
                        return {
                            q: params.term,  // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        let res = [];
                        for(let i  = 0 ; i < data.length; i++) {
                            res.push({id:data[i].ItemCode, text:data[i].ItemName});
                            /*$("#campo").append('<input type="hidden" name="" id="'+data[i].ItemCode+'txtpeso" class="form-control" value="'+data[i].SWeight1+'">');*/
                        }
                        return {
                            results: res
                        }
                    },
                    cache: true
                }
            }
        ).trigger('change');
    });

    function calculardiferencia(){
        var hora_inicio = $('#entrada').val();
        var hora_final = $('#salida').val();

        // Expresión regular para comprobar formato
        var formatohora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

        // Si algún valor no tiene formato correcto sale
        if (!(hora_inicio.match(formatohora)
            && hora_final.match(formatohora))){
            return;
        }

        // Calcula los minutos de cada hora
        var minutos_inicio = hora_inicio.split(':')
            .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
        var minutos_final = hora_final.split(':')
            .reduce((p, c) => parseInt(p) * 60 + parseInt(c));

        // Si la hora final es anterior a la hora inicial sale
        if (minutos_final < minutos_inicio) return;

        // Diferencia de minutos
        var diferencia = minutos_final - minutos_inicio;

        // Cálculo de horas y minutos de la diferencia
        var horas = Math.floor(diferencia / 60);
        var minutos = diferencia % 60;

        $('#tiempo').val(horas + ':'
            + (minutos < 10 ? '0' : '') + minutos);
    }

    $('#salida').change(calculardiferencia);

    $("#btnAdd").click(function () {
    let t = $('#tblcrear').DataTable({
        "info": false,
        "sort": false,
        "destroy": true,
        "searching": false,
        "paginate": false,
        "lengthMenu": [
            [10,20,50,100, -1],
            [10,20,50,100, "Todo"]
        ],
        "order": [
            [3, "desc"]
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
    let codproducto = $("#ddlprod option:selected").val(),
        producto = $("#ddlprod option:selected").text(),
        produccion = $("#produccion").val(),
        entrada = $("#entrada").val(),
        salida = $("#salida").val(),
        temperatura = $("#temperatura").val(),
        tiempo = $('#tiempo').val(),
        observaciones = $("#observaciones").val(),
        acciones = $("#acciones").val();

    if(codproducto == "" || produccion == "" || entrada == "" || salida == "" || temperatura == ""){
        Swal.fire({
            text: "Todos los campos son requeridos",
            type: "warning",
            allowOutsideClick: false
        });
    }else{
        t.row.add([
            codproducto,
            producto,
            produccion,
            entrada,
            salida,
            temperatura,
            tiempo,
            observaciones,
            acciones
        ]).draw(false);

        /*$("#entrada").val("");
        $("#salida").val("");
        $("#temperatura").val("");
        $("#tiempo").val("");
        $("#observaciones").val("");
        $("#acciones").val("");*/
        //$("#ddlAreas").val("").trigger("change");
    }
});

    $('#tblcrear tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('danger');
    });

    $("#btnDelete").click(function (){
        let table = $("#tblcrear").DataTable();
        let rows = table.rows( '.danger' ).remove().draw();
    });


    $("#btnGuardar").click(function(){
        let version = $("#version").val(),
        fecha = $("#fecha").val(),
        ddlprod = $("#ddlprod option:selected").val(),
        produccion = $("#produccion").val(),
        nombre = $("#nombreRpt").html();
        Swal.fire({
            text: "¿Estas seguro que todos los datos están correctos?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: "Cancelar",
            allowOutsideClick: false
        }).then((result)=>{
            let validtable = $('#tblcrear').DataTable();
            if(result.value){
                if(fecha == "" || version == "" || produccion == "" ||  ddlprod == ""){
                    Swal.fire({
                        text: "Todos los campos son requeridos",
                        type: "error",
                        allowOutsideClick: false
                    });
                }else if (!validtable.data().count() ) {
                    Swal.fire({
                        text: "No se ha agregado ningún registro a la tabla",
                        type: "error",
                        allowOutsideClick: false
                    });
                }else{
                    $("#loading").modal("show");
                    mensaje = '', tipo = '',
                        table = $("#tblcrear").DataTable();
                    let datos = new Array(), i = 0;

                    table.rows().eq(0).each(function(i, index){
                        let row = table.row(index);
                        let data = row.data();
                        datos[i] = data[0]+","+data[1]+","+data[3]+","+data[4]+","+data[5]+","+data[7]+","+data[8];
                        i++;
                    });

                    let form_data = {
                        enc: [$("#idmonitoreo").val(),version,nombre,produccion,fecha],
                        datos: datos
                    };

                    console.log(form_data);

                    $.ajax({
                        url: 'guardarPccn3',
                        type: 'POST',
                        data: form_data,
                        success: function(data)
                        {
                            $("#loading").modal("hide");
                            let obj = jQuery.parseJSON(data);
                            $.each(obj, function(index, val) {
                                mensaje = val["mensaje"];
                                tipo = val["tipo"];
                            });
                            Swal.fire({
                                type: tipo,
                                text: mensaje,
                                allowOutsideClick: false
                            }).then((result)=>{
                                window.location.href = "reporte_9";
                            });
                        }
                    });
                }
            }
        });
    });

    function mostrarDetalles(callback,id,div)
    {
        $.ajax({
            url: "mostrarPccn3Ajax/"+id,
            async: true,
            success: function(response){

                let thead = '',tbody='';
                if(response != "false"){
                    let obj = $.parseJSON(response);
                    thead += "<th class='text-center bg-primary'>Productos</th>";
                    thead += "<th class='text-center bg-primary'>Codigo</th>";
                    thead += "<th class='text-center bg-primary'>Hora Entrada</th>";
                    thead += "<th class='text-center bg-primary'>Hora Salida</th>";
                    thead += "<th class='text-center bg-primary'>T°C</th>";
                    thead += "<th class='text-center bg-primary'>Tiempo</th>";
                    thead += "<th class='text-center bg-primary'>Observaciones</th>";
                    thead += "<th class='text-center bg-primary'>Acciones Correctivas</th></tr>";
                    $.each(obj, function(i, item){
                        tbody += "<tr>"+
                            "<td class='text-center bg-info'>"+item["PRODUCTO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["CODIGO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["HORAENTRADA"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["HORASALIDA"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TC"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TIEMPO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["OBSERVACIONES"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["ACCIONESCORRECTIVAS"]+"</td>"+
                            "</tr>";
                    });
                    callback($("<table id='detPccn3' class='table table-bordered table-condensed table-striped'>"+ thead + tbody + "</table>")).show();
                }else {
                    thead += "<th class='text-center bg-primary'>Productos</th>";
                    thead += "<th class='text-center bg-primary'>Codigo</th>";
                    thead += "<th class='text-center bg-primary'>Hora Entrada</th>";
                    thead += "<th class='text-center bg-primary'>Hora Salida</th>";
                    thead += "<th class='text-center bg-primary'>T°C</th>";
                    thead += "<th class='text-center bg-primary'>Tiempo</th>";
                    thead += "<th class='text-center bg-primary'>Observaciones</th>";
                    thead += "<th class='text-center bg-primary'>Acciones Correctivas</th></tr>";
                    tbody += '<tr >' +
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td>No hay datos disponibles</td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        '</tr>';
                    callback($('<table id="detPccn3" class="table table-bordered table-condensed table-striped">' + thead + tbody + '</table>')).show();
                }
            }
        });
    }

    $("#tblPccn3").on("click","tbody .detalles", function () {
        let table = $("#tblPccn3").DataTable();
        let tr = $(this).closest("tr");
        //$(this).addClass("detalleNumOrdOrange");
        let row = table.row(tr);
        let data = table.row($(this).parents("tr")).data();

        if(row.child.isShown())
        {
            row.child.hide();
            tr.removeClass("shown");
        }else{
            mostrarDetalles(row.child,data[0],data[0]);
            tr.addClass("shown");
        }
    });

    function darDeBaja(idreporte,estado)
    {
        let message = '', text = '';
        if(estado == "A"){
            message = 'Se dará de baja el informe, éste ya no podra ser utilizada en el sistema.'+
                '¿Desea continuar?';
            text = 'Dar baja';
        }else{
            message= '¿Desea restaurar el informe ?';
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
        }).then((result)=>{
            if(result.value){
                let mensaje = '', tipo = '';
                let form_data = {
                    idreporte:  idreporte,
                    estado: estado
                };
               $.ajax({
                    url: "BajaAltaPccn3",
                    type: "POST",
                    data: form_data,
                    success: function(data){
                        let obj = jQuery.parseJSON(data);
                        $.each(obj, function(i, index){
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
    }
</script>
