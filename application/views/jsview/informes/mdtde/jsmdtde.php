<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 24/10/2019 10:16 2019
 * FileName: jsmdtde.php
 */
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#version,#toma1,#toma2,#toma3,#toma4").numeric();
        let counter = 1;
        $("#ddlAreas").select2({
            placeholder: "Seleccione un area",
            allowClear: true,
            language: "es"
        });
        /*$("#Toma").select2({
            placeholder: "Seleccione un opcion",
            allowClear: true,
            language: "es"
        });*/
        $("#semana").daterangepicker({
            locale: {
                format: 'DD',
                daysOfWeek: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
                monthNames: ["En","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"]
            }
        });

        $("#btnAdd").click(function(){
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
            let semana = $("#semana").val(),
                dia = $("#Dia").val(),
                tomaselect = $("#Toma option:selected").val(),
                toma1 = 0,
                toma2 = 0,
                toma3 = 0,
                toma4 = 0,
                obs = $("#observaciones").val();

            if($("#toma1").val() != ""){
                toma1 = $("#toma1").val();
            }
            if($("#toma2").val() != ""){
               toma2 = $("#toma2").val();
            }
            if($("#toma3").val() != ""){
                toma3 = $("#toma3").val();
            }
            if($("#toma4").val() != ""){
                toma4 = $("#toma4").val();
            }

            if($("#ddlAreas option:selected").val() == "" || $("#version").val() == ""
                || $("#lote").val() == ""){
                Swal.fire({
                    text: "Todos los campos son requeridos",
                    type: "warning",
                    allowOutsideClick: false
                });
            }else{
                t.row.add([
                    counter,
                    semana,
                    dia,
                    toma1,
                    toma2,
                    toma3,
                    toma4,
                    obs
                ]).draw(false);

                counter++;
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
    });


    $("#btnGuardar").click(function () {
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
            if(result.value)
            {
                $("#loading").modal("show");
                let table = $('#tblcrear').DataTable();
                if(!table.data().count())
                {
                    $("#loading").modal("hide");
                    Swal.fire({
                        text: "No se ha agregado ningún registro a la tabla",
                        type: "error",
                        allowOutsideClick: false
                    });
                }else{
                    if($("#ddlAreas option:selected").val() == "" || $("#version").val() == "" || $("#lote").val() == ""){
                        $("#loading").modal("hide");
                        Swal.fire({
                            text: "Los campos Areas, Version y Lote son obligatorios",
                            type: "error",
                            allowOutsideClick: false
                        });
                    }else{
                        let mensaje = '', tipo = '', table = $("#tblcrear").DataTable();
                        let detalle = new Array(), i = 0;

                        table.rows().eq(0).each(function(i, index){
                            let row = table.row(index);
                            let data = row.data();
                            detalle[i] = [];
                            detalle[i][0] = data[1];
                            detalle[i][1] = data[2];
                            detalle[i][2] = data[3];
                            detalle[i][3] = data[4];
                            detalle[i][4] = data[5];
                            detalle[i][5] = data[6];
                            detalle[i][6] = $("#Hora").val();
                            detalle[i][7] = data[7];
                            i++;
                        });

                        let form_data = {
                            enc: [$("#ddlAreas option:selected").val(),$("#version").val(),$("#nombreRpt").html(),$("#Lote").val(),$("#Fecha").val()],
                            detalle: JSON.stringify(detalle)
                        };

                       $.ajax({
                            url: "guardarMdtde",
                            type: "POST",
                            data: form_data,
                            success: function (data) {
                                let obj = jQuery.parseJSON(data);
                                $.each(obj, function (i,index) {
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
            }
        });
    });

    function mostrarDetalles(callback,id,div)
    {
        $.ajax({
            url: "getMdtdeAjax/"+id,
            async: true,
            success: function(response){

                let thead = '',tbody='';
                if(response != "false"){
                    let obj = $.parseJSON(response);
                    thead += "<th class='text-center bg-primary'>Dia</th>";
                    thead += "<th class='text-center bg-primary'>1ra Toma</th>";
                    thead += "<th class='text-center bg-primary'>2da Toma</th>";
                    thead += "<th class='text-center bg-primary'>3ra Toma</th>";
                    thead += "<th class='text-center bg-primary'>4ta Toma</th>";
                    thead += "<th class='text-center bg-primary'>Hora <br> 1ra Toma</th>";
                    thead += "<th class='text-center bg-primary'>Hora <br> 2da Toma</th>";
                    thead += "<th class='text-center bg-primary'>Hora <br> 3ra Toma</th>";
                    thead += "<th class='text-center bg-primary'>Hora <br> 4ta Toma</th>";
                    thead += "<th class='text-center bg-primary'>observacion</th>";
                    thead += "<th class='text-center bg-primary'>Acciones</th></tr>";
                    $.each(obj, function(i, item){
                        tbody += "<tr>"+
                            "<td class='text-center bg-info'>"+item["Dia"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Toma"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Toma2"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Toma3"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Toma4"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Hora"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Hora2"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Hora3"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Hora4"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["Observaciones"]+"</td>"+
                            "<td class='text-center bg-info'><a class='btn btn-primary btn-xs' href='<?php echo base_url("index.php/editarDetalle/")?>"+item["IdDetalle"]+"'>" +
                            "                                                       <i class='fa fa-pencil'></i>" +
                            "                                                   </a></td>"+
                            "</tr>";
                    });
                    callback($("<table id='detMdtde' class='table table-bordered table-condensed table-striped'>"+ thead + tbody + "</table>")).show();
                }else {
                    thead += "<th class='text-center bg-primary'>Numero</th>";
                    thead += "<th class='text-center bg-primary'>Codigo bascula</th>";
                    thead += "<th class='text-center bg-primary'>Hora</th>";
                    thead += "<th class='text-center bg-primary'>Peso de masa</th>";
                    thead += "<th class='text-center bg-primary'>Peso reg. en bascula</th>";
                    thead += "<th class='text-center bg-primary'>Diferencia</th></tr>";
                    tbody += '<tr >' +
                        "<td></td>"+
                        "<td></td>"+
                        "<td>No hay datos disponibles</td>"+
                        "<td></td>"+
                        "<td></td>"+
                        '</tr>';
                    callback($('<table id="detMdtde" class="table table-bordered table-condensed table-striped">' + thead + tbody + '</table>')).show();
                }
            }
        });
    }

    $("#tblMdtdedet").on("click","tbody .detalles", function () {
        let table = $("#tblMdtdedet").DataTable();
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

    function DardeBaja(idreporte,estado) {
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
        }).then((result) => {
            if(result.value){
                let mensaje = '', tipo = '';
                let form_data = {
                    idreporte:  idreporte,
                    estado: estado
                };
                $.ajax({
                    url: "bajaMdtde",
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
