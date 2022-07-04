<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/11/2019 11:14 2019
 * FileName: jdcdt.php
 */
?>
<script type="text/javascript">
    $(document).ready(function () {
        cargarCdt();
        $("#fechaFilter1,#fechaFilter2").datepicker({"autoclose":true});

        $("#version,#toma1,#toma2,#toma3,#toma4").numeric();
        let counter = 1;
        $("#ddlAreas").select2({
            placeholder: "Seleccione un area",
            allowClear: true,
            language: "es"
        });

        $("#ddlSalas").select2({
            placeholder: "Seleccione una opcion",
            allowClear: true,
            language: "es"
        });

        $("#btnModalTemp").click(function () {
            $("#modalTemp").modal("show");
        });

        $('#tblcrear tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('danger');
        });

        $("#btnDelete").click(function (){
            let table = $("#tblcrear").DataTable();
            let rows = table.rows( '.danger' ).remove().draw();
        });

        $("#UMT1").children("li").click(function () {
            $("#textoBtnUM1").text($(this).text());
        });
        $("#UMT2").children("li").click(function () {
            $("#textoBtnUM2").text($(this).text());
        });
        $("#UMT3").children("li").click(function () {
            $("#textoBtnUM3").text($(this).text());
        });
        $("#UMT4").children("li").click(function () {
            $("#textoBtnUM4").text($(this).text());
        });

        $("#btnFiltrar").on("click", function(){
          if($("#fechaFilter1").val() == "" || $("#fechaFilter2").val() == ""){
            Swal.fire({
                text: "Debe proporcionar ambas fechas",
                type: "warning",
                allowOutsideClick: false
            });
          }else if($("#fechaFilter1").val() > $("#fechaFilter2").val()){
            Swal.fire({
                text: "La primera fecha debe ser menor a la segunda fecha",
                type: "error",
                allowOutsideClick: false
            });
          }else{
              cargarCdt();
          }
        })

        $("#btnActualizarInfo").on("click", function(){
          cargarCdt();
        });

        function cargarCdt(){
        	let table = $("#tblCdt").DataTable({
        		"ajax": {
        			"url": "mostrarCdt",
        			"type": "POST",
        			"data": function ( d ) {
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
        			[10,20,50,100, -1],
        			[10,20,50,100, "Todo"]
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
        		"columns": [
        		{"data" : "IDREPORTE"},
        		{"data" : "SIGLA"},
        		{"data" : "VERSION"},
        		{"data" : "FECHAINICIO"},
        		{"data" : "USUARIO"},
        		{"data" : "ESTADO"},
        		{"data" : "Acciones"}
        	]
        	});
      }

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
            let areaselect = $("#ddlAreas option:selected").text(),
                salaselect = $("#ddlSalas option:selected").text(),
                toma1 = 0,
                toma2 = 0,
                toma3 = 0,
                toma4 = 0,
                obs = $("#observaciones").val(),
                vac = $("#Verificacion").val(),
                area_cuarto = '',sigla = '', codigo = 0;
            if($("#ddlAreas option:selected").val() != ""){
                area_cuarto = areaselect;
                sigla = "A";
                codigo = $("#ddlAreas option:selected").val();
            }
            if($("#ddlSalas option:selected").val() != ""){
                area_cuarto = salaselect;
                sigla = "C";
                codigo = $("#ddlSalas option:selected").val();
            }

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
            if($("#version").val() == "" || $("#lote").val() == ""){
                Swal.fire({
                    text: "Todos los campos son requeridos",
                    type: "warning",
                    allowOutsideClick: false
                });
            }else{
                t.row.add([
                    counter,
                    sigla,
                    codigo,
                    area_cuarto,
                    toma1,
                    toma2,
                    toma3,
                    toma4,
                    obs,
                    vac
                ]).draw(false);

                counter++;
                //$("#ddlAreas").val("").trigger("change");
            }
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
                    if($("#version").val() == "" || $("#lote").val() == ""){
                        $("#loading").modal("hide");
                        Swal.fire({
                            text: "Los campos Areas, Version y Lote son obligatorios",
                            type: "error",
                            allowOutsideClick: false
                        });
                    }else{
                        let mensaje = '', tipo = '', table = $("#tblcrear").DataTable();
                        let detalle = new Array(), i = 0;
                        let umtoma1 = '',
                            umtoma2 = '',
                            umtoma3 = '',
                            umtoma4 = '';

                        table.rows().eq(0).each(function(i, index){
                            let row = table.row(index);
                            let data = row.data();
                            detalle[i] = [];
                            detalle[i][0] = data[1];
                            detalle[i][1] = data[2];
                            detalle[i][2] = data[4];
                            detalle[i][3] = data[5];
                            detalle[i][4] = data[6];
                            detalle[i][5] = data[7];
                            detalle[i][6] = $("#Hora").val();
                            detalle[i][7] = data[8];
                            detalle[i][8] = data[9];
                            if(data[4] != 0){
                                umtoma1 =  $("#textoBtnUM1").text();
                            }
                            if(data[5] != 0){
                                umtoma2 = $("#textoBtnUM2").text();
                            }
                            if(data[6] != 0){
                                umtoma3 = $("#textoBtnUM3").text();
                            }
                            if(data[7] != 0){
                               umtoma4 = $("#textoBtnUM4").text();
                            }
                            detalle[i][9] = umtoma1;
                            detalle[i][10] = umtoma2;
                            detalle[i][11] = umtoma3;
                            detalle[i][12] = umtoma4;
                            i++;
                        });

                        let form_data = {
                            enc: [$("#version").val(),$("#nombreRpt").html(),$("#Lote").val(),$("#Fecha").val()],
                            detalle: JSON.stringify(detalle)
                        };

                        console.log(form_data);

                        $.ajax({
                            url: "guardarCdt",
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
            url: "getCdtAjax/"+id,
            async: true,
            success: function(response){

                let thead = '',tbody='';
                if(response != "false"){
                    let obj = $.parseJSON(response);
                    thead += "<th class='text-center bg-primary'>Cuartos frios/ <br> Areas</th>";
                    thead += "<th class='text-center bg-primary'>6:00 a.m</th>";
                    thead += "<th class='text-center bg-primary'>8:00 a.m</th>";
                    thead += "<th class='text-center bg-primary'>11:00 a.m</th>";
                    thead += "<th class='text-center bg-primary'>3:00 p.m</th>";
                    thead += "<th class='text-center bg-primary'>observacion</th>";
                    thead += "<th class='text-center bg-primary'>verificaion A/C</th>";
                    thead += "<th class='text-center bg-primary'>Acciones</th></tr>";
                    $.each(obj, function(i, item){
                        tbody += "<tr>"+
                            "<td class='text-center bg-info'>"+item["AREA"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TOMA1"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TOMA2"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TOMA3"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TOMA4"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["OBSERVACIONES"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["VERIFICACION"]+"</td>"+
                            "<td class='text-center bg-info'><a class='btn btn-primary btn-xs' href='<?php echo base_url("index.php/editarDetalleCdt/")?>"+item["ID"]+"'>" +
                            "                                                       <i class='fa fa-pencil'></i>" +
                            "                                                   </a></td>"+
                            "</tr>";
                    });
                    callback($("<table id='detCdt' class='table table-bordered table-condensed table-striped'>"+ thead + tbody + "</table>")).show();
                }else {
                    thead += "<th class='text-center bg-primary'>Cuartos frios/ <br> Areas</th>";
                    thead += "<th class='text-center bg-primary'>6:00 a.m</th>";
                    thead += "<th class='text-center bg-primary'>8:00 a.m</th>";
                    thead += "<th class='text-center bg-primary'>11:00 a.m</th>";
                    thead += "<th class='text-center bg-primary'>3:00 p.m</th>";
                    thead += "<th class='text-center bg-primary'>observacion</th>";
                    thead += "<th class='text-center bg-primary'>verificaion A/C</th>";
                    thead += "<th class='text-center bg-primary'>Acciones</th></tr>";
                    tbody += '<tr >' +
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td>No hay datos disponibles</td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        '</tr>';
                    callback($('<table id="detCdt" class="table table-bordered table-condensed table-striped">' + thead + tbody + '</table>')).show();
                }
            }
        });
    }

    $("#tblCdt").on("click","tbody .detalles", function () {
        let table = $("#tblCdt").DataTable();
        let tr = $(this).closest("tr");
        //$(this).addClass("detalleNumOrdOrange");
        let row = table.row(tr);
        let data = table.row($(this).parents("tr")).data();

        if(row.child.isShown())
        {
            row.child.hide();
            tr.removeClass("shown");
        }else{
            mostrarDetalles(row.child,data.IDREPORTE,data.IDREPORTE);
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
                    url: "bajaCdt",
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
