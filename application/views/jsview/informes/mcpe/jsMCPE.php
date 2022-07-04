<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 26/9/2019 15:22 2019
 * FileName: jsMCPE.php
 */?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".clockpicker").clockpicker({
            donetext: "Aceptar"
        });
        $("#version,#version1,#Codigo1,#produccion,#pesoMasaUtil,#pesoRegistrado,#Diferencia").numeric();
        $("#CantMues,#PV,#MS,#MC,#TC,#presentacion").numeric();
        let counter = 1;
        let counter1 = 1;
        $('#tblcrear,#tblcrear1').DataTable( {
            "scrollX": false,
            "searching": false,
            "ordering": false,
            "paginate": false,
            "info": false,
            "language": {
                "info": "Registro _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Registro 0 a 0 de 0 entradas",
                "zeroRecords": "No se encontro coincidencia",
                "infoFiltered": "(filtrado de _MAX_ registros en total)",
                "emptyTable": "NO HAY DATOS",
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
        } );
        $('#fecha,#fecha1,#fechaVenc').datepicker({"autoclose":true});
        $("#ddlMaquina").select2({
            placeholder: '--- Seleccione una Maquina ---',
            allowClear: true
        });
        $("#ddlTipo").select2({
            placeholder: '--- Seleccione un Tipo empaque ---',
            allowClear: true,
        });

        $(".js-data-example-ajax").select2({
                placeholder: '--- Seleccione un Producto ---',
                allowClear: true,
                ajax: {
                    url: '<?php echo base_url("index.php/getProductosSAP")?>',
                    dataType: 'json',
                    type: "POST",
                    async: true,
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
                            $("#campo").append('<input type="hidden" name="" id="'+data[i].ItemCode+'txtpeso" class="form-control" value="'+data[i].SWeight1+'">');
                        }
                        return {
                            results: res
                        }
                    },
                    cache: true
                }
            }
        ).trigger('change');


        $("#ddlprod").change(function () {
            let ddlcodprod = $("#ddlprod option:selected").val();
            let unidadPeso = $("#"+ddlcodprod+"txtpeso").val();
            $("#presentacion").val(Number(unidadPeso).toFixed(0));
        });

        $("#btnAdd").click(function () {
            let t = $('#tblcrear').DataTable({
                "info": false,
                "scrollX": true,
                "sort": false,
                "destroy": true,
                "searching": false,
                "paginate": false,
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
            let fecha = $("#fecha").val(),
                ddlprod = $("#ddlprod option:selected").text(),
                ddlcodprod = $("#ddlprod option:selected").val(),
                ddlTipo = $("#ddlTipo option:selected").text(),
                produccion = $("#produccion").val(),
                fechaVenc = $("#fechaVenc").val(),
                maquina = $("#ddlMaquina option:selected").val(),
                presentacion =  $("#presentacion").val(),
                unidadpresentacion = $("#textoBtnPresentacion").text(),
                cant_muestr = $("#CantMues").val(),
                PV = $("#PV").val(),
                MS = $("#MS").val(),
                MC = $("#MC").val(),
                TC = $("#TC").val(),
                operario = $("#operario").val(),
                Defecto = $("#Defecto").val();

            if(fecha == "" || produccion == "" || /*ddlprod == "" ||*/ ddlTipo == "" || fechaVenc == "" || PV== "" || MS == ""
                || MC == "" || TC == "" || operario == ""){
                Swal.fire({
                    text: "Todos los campos son requeridos",
                    type: "warning",
                    allowOutsideClick: false
                });
            }else{
                t.row.add([
                    counter,
                    ddlcodprod,
                    ddlprod,
                    ddlTipo,
                    produccion,
                    fechaVenc,
                    maquina,
                    presentacion,
                    unidadpresentacion,
                    cant_muestr,
                    PV,
                    MS,
                    MC,
                    TC,
                    operario,
                    Defecto
                ]).draw(false);
                //$("#ddlAreas").val("").trigger("change");
                /*$("#produccion").val("");
                $("#fechaVenc").val("");
                $("#PV").val("");
                $("#MS").val("");
                $("#MC").val("");
                $("#TC").val("");
                $("#operario").val("");
                $("#Defecto").val("");*/
            }
            counter++;
        });

        $("#btnAdd1").click(function () {
            let t = $('#tblcrear1').DataTable({
                "info": false,
                "scrollX": true,
                "sort": false,
                "destroy": true,
                "searching": false,
                "paginate": false,
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
            let fecha = $("#fecha1").val(),
                version1 = $("#version1").val(),
                Hora = $("#Hora").val(),
                Codigo1 = $("#Codigo1").val(),
                pesoMasaUtil = $("#pesoMasaUtil").val(),
                pesoRegistrado = $("#pesoRegistrado").val(),
                Diferencia = $("#Diferencia").val(),
                btn1 = $("#textoButton1").text(),
                btn2 = $("#textoButton2").text(),
                peso1='';
                observaciones = $("#observaciones").val();

            if(fecha == "" || version1 == "" || Hora == "" || Codigo1 == "" || pesoMasaUtil == "" || pesoRegistrado == ""){
                Swal.fire({
                    text: "Todos los campos son requeridos",
                    type: "warning",
                    allowOutsideClick: false
                });
            }else if(btn1 != btn2){
                Swal.fire({
                    text: "La unidad de peso en Peso de masa utilizada y peso registrado en basc no coinciden",
                    type: "error",
                    allowOutsideClick: false
                });
            }else{
                switch (btn1) {
                case "gr":
                    peso1 = "Gramos";
                    break;
                case "lbs":
                    peso1 = "Libras";
                    break;
                case "kg":
                    peso1 = "KG";
                    break;
            }
                t.row.add([
                    counter1,
                    Hora,
                    Codigo1,
                    pesoMasaUtil,
                    pesoRegistrado,
                    peso1,
                    Diferencia
                ]).draw(false);
                //$("#ddlAreas").val("").trigger("change");
                /*$("#Codigo1").val("");
                $("#pesoMasaUtil").val("");
                $("#pesoRegistrado").val("");
                $("#Diferencia").val("");*/
            }
            counter1++;
        });

        $('#tblcrear tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('danger');
        });

        $('#tblcrear1 tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('danger');
        });

        $("#btnDelete").click(function (){
            let table = $("#tblcrear").DataTable();
            let rows = table.rows( '.danger' ).remove().draw();
        });

        $("#btnDelete1").click(function (){
            let table = $("#tblcrear1").DataTable();
            let rows = table.rows( '.danger' ).remove().draw();
        });
    });

    $("#MC,#PV,#MS").on("keyup",function () {
        let  PV = Number($("#PV").val()),
            Cantidad_muestra = Number($("#CantMues").val()),
            suma = 0;
        suma = (PV/Cantidad_muestra)*100;
        $("#Defecto").val(suma.toFixed(2));
    });

    $("#pesoRegistrado").on("keyup",function () {
        let pesoMasaUtil = $("#pesoMasaUtil").val(),
            pesoRegistrado = $("#pesoRegistrado").val(),
            diferencia = 0;
        diferencia = pesoMasaUtil-pesoRegistrado;
        $("#Diferencia").val(diferencia);
    });

    $("#unidadpesoCaract").children("li").click(function () {
        let unidad = '';
        switch ($(this).text()) {
            case "Gramos":
                unidad = "gr";
                break;
            case "Libras":
                unidad = "lbs";
                break;
            case "Kilogramos":
                unidad = "kg";
                break;
        }
        $("#textoBtnPresentacion").text(unidad);
    });

    $("#unidadpesoMasaUtil").children("li").click(function () {
        let unidad = '';
        switch ($(this).text()) {
            case "Gramos":
                    unidad = "gr";
                break;
            case "Libras":
                unidad = "lbs";
                break;
            case "Kilogramos":
                unidad = "kg";
                break;
        }
        $("#textoButton1").text(unidad);
    });

    $("#unidadpesoRegistrado").children("li").click(function () {
        let unidad = '';
        switch ($(this).text()) {
            case "Gramos":
                unidad = "gr";
                break;
            case "Libras":
                unidad = "lbs";
                break;
            case "Kilogramos":
                unidad = "kg";
                break;
        }
        $("#textoButton2").text(unidad);
    });

    $("#btnGuardarpeso").click(function () {
        let version1 = $("#version1").val(),
        area1 = $("#area1").val(),
        fecha1 = $("#fecha1").val(),
        Hora = $("#Hora").val(),
        Codigo1 = $("#Codigo1").val(),
        pesoMasaUtil = $("#pesoMasaUtil").val(),
        pesoRegistrado = $("#pesoRegistrado").val(),
        btn1 = $("#textoButton1").text(),
        btn2 = $("#textoButton2").text(),
        peso1 = '',
        Diferencia = $("#Diferencia").val();
        let table = $("#tblcrear1").DataTable();
        if(btn1 != btn2){
            Swal.fire({
                text: "La unidad de peso en Peso de masa utilizada y peso registrado en basc no coinciden",
                type: "error",
                allowOutsideClick: false
            });
        }else if(!table.data().count()){
            Swal.fire({
                text: "No se ha agregado ningún dato a la tabla",
                type: "error",
                allowOutsideClick: false
            });
        }else{

            let detalle = new Array(), it = 0;
            table.rows().eq(0).each(function (i, index) {
                let row = table.row(index);
                let data = row.data();
                detalle[it] = [];
                detalle[it][0] = data[2];
                detalle[it][1] = data[1];
                detalle[it][2] = data[5];
                detalle[it][3] = data[3];
                detalle[it][4] = data[4];
                detalle[it][5] = data[6];
                it++;
            });
            let mensaje='',tipo='';
            let form_data = {
                enc: [$("#idmonitoreo").val(),version1,$("#nombreRpt").text(),fecha1],
                detalle: JSON.stringify(detalle)
            };
            $.ajax({
                url: "guardarMcpeVerificPeso",
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

    $("#btnGuardar").click(function () {
        let fecha = $("#fecha").val(),
            ddlprod = $("#ddlprod option:selected").val(),
            ddlTipo = $("#ddlTipo option:selected").text(),
            produccion = $("#produccion").val(),
            fechaVenc = $("#fechaVenc").val(),
            maquina = '',
            presentacion =  $("#presentacion").val(),
            PV = $("#PV").val(),
            MS = $("#MS").val(),
            MC = $("#MC").val(),
            TC = $("#TC").val(),
            version = $("#version").val(),
            operario = $("#operario").val();
        let table = $("#tblcrear").DataTable();
        if(!table.data().count()){
            Swal.fire({
                text: "No se ha agregado ningún dato a la tabla",
                type: "error",
                allowOutsideClick: false
            });
        }else{
            let vacio = 0, granel = 0, unidad='';
            let detalle = new Array(), it = 0;
            table.rows().eq(0).each(function (i, index) {
                let row = table.row(index);
                let data = row.data();
                detalle[it] = [];
                detalle[it][0] = data[1];
                detalle[it][1] = data[2];
                /*vacio o granel*/
                if(data[3] == "Vacio"){
                    vacio = 1;
                    granel = 0;
                }else{
                    granel = 1;
                    vacio = 0;
                }
                if(data[6] == "Multivac (M1)"){
                    maquina = 3;
                }else{
                    maquina = 4;
                }
                switch (data[8]) {
                    case "gr":
                        unidad = "Gramos";
                        break;
                    case "lbs":
                        unidad = "Libras";
                        break;
                    case "kg":
                        unidad = "KG";
                        break;
                }
                detalle[it][2] = vacio;
                detalle[it][3] = granel;
                /*vacio o granel*/
                detalle[it][4] = data[4];
                detalle[it][5] = data[5];
                detalle[it][6] = data[7];
                detalle[it][7] = unidad;
                detalle[it][8] = data[9];
                detalle[it][9] = data[10];
                detalle[it][10] = data[11];
                detalle[it][11] = data[12];
                detalle[it][12] = data[6];
                detalle[it][13] = data[13];
                detalle[it][14] = data[14];
                detalle[it][15] = data[15];
                it++;
            });
            let mensaje='',tipo='';
            let form_data = {
                enc: [$("#idmonitoreo").val(),version,$("#nombreRpt").text(),$("#observaciones").val(),fecha],
                detalle: JSON.stringify(detalle)
            };
            console.log(form_data);
            $.ajax({
                url: "guardarMcpeVerificCaract",
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
                    }).then((result) => {
                        location.reload();
                    });
                }
            });
        }
    });

    function mostrarDetalles(callback,id,div)
    {
        $.ajax({
            url: "getMcpePesoBasculaAjax/"+id,
            async: true,
            success: function(response){

                let thead = '',tbody='';
                if(response != "false"){
                    let obj = $.parseJSON(response);
                    thead += "<th class='text-center bg-primary'>Numero</th>";
                    thead += "<th class='text-center bg-primary'>Codigo bascula</th>";
                    thead += "<th class='text-center bg-primary'>Hora</th>";
                    thead += "<th class='text-center bg-primary'>Peso de masa patron util.</th>";
                    thead += "<th class='text-center bg-primary'>Peso registrado en bascula</th>";
                    thead += "<th class='text-center bg-primary'>Diferencia +/-</th></tr>";
                    $.each(obj, function(i, item){
                        tbody += "<tr>"+
                            "<td class='text-center bg-info'>"+item["NUMERO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["CODBASCULA"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["HORA"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["PESOMASA"]+" "+item["UNIDADPESO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["PESOBASCULA"]+" "+item["UNIDADPESO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["DIFERENCIA"]+"</td>"+
                            "</tr>";
                    });
                    callback($("<table id='detMCPE' class='table table-bordered table-condensed table-striped'>"+ thead + tbody + "</table>")).show();
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
                        "<td></td>"+
                        '</tr>';
                    callback($('<table id="detMCPE" class="table table-bordered table-condensed table-striped">' + thead + tbody + '</table>')).show();
                }
            }
        });
    }

    $("#tblPesoBasculas").on("click","tbody .detalles", function () {
        let table = $("#tblPesoBasculas").DataTable();
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

    function mostrarDetallesCaract(callback,id,div)
    {
        $.ajax({
            url: "getMcpeCaractCalidadAjax/"+id,
            async: true,
            success: function(response){

                let thead = '',tbody='';
                if(response != "false"){
                    let obj = $.parseJSON(response);
                    thead += "<th class='text-center bg-primary'>Numero</th>";
                    thead += "<th class='text-center bg-primary'>Cod. Producto</th>";
                    thead += "<th class='text-center bg-primary'>Producto</th>";
                    thead += "<th class='text-center bg-primary'>Tipo Empaque</th>";
                    thead += "<th class='text-center bg-primary'>Codigo/Lote</th>";
                    thead += "<th class='text-center bg-primary'>Fecha vencimiento</th>";
                    thead += "<th class='text-center bg-primary'>Presentacion</th>";
                    thead += "<th class='text-center bg-primary'>P.V</th>";
                    thead += "<th class='text-center bg-primary'>M.S</th>";
                    thead += "<th class='text-center bg-primary'>M.C</th>";
                    thead += "<th class='text-center bg-primary'>T°C</th>";
                    thead += "<th class='text-center bg-primary'>Operario</th>";
                    thead += "<th class='text-center bg-primary'>% Defecto</th></tr>";
                    $.each(obj, function(i, item){
                        tbody += "<tr>"+
                            "<td class='text-center bg-info'>"+item["NUMERO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["CODIGO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["NOMBRE"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TIPOEMPAQUE"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["LOTE"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["FECHAVENCIMIENTO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["PRESENTACION"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["PV"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["MS"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["MC"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TC"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["OPERARIO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["DEFECTO"]+"</td>"+
                            "</tr>";
                    });
                    callback($("<table id='detMCPECaract' class='table table-bordered table-condensed table-striped'>"+ thead + tbody + "</table>")).show();
                }else {
                    thead += "<th class='text-center bg-primary'>Numero</th>";
                    thead += "<th class='text-center bg-primary'>Cod. Producto</th>";
                    thead += "<th class='text-center bg-primary'>Producto</th>";
                    thead += "<th class='text-center bg-primary'>Tipo Empaque</th>";
                    thead += "<th class='text-center bg-primary'>Codigo/Lote</th>";
                    thead += "<th class='text-center bg-primary'>Fecha vencimiento</th>";
                    thead += "<th class='text-center bg-primary'>Presentacion</th>";
                    thead += "<th class='text-center bg-primary'>P.V</th>";
                    thead += "<th class='text-center bg-primary'>M.S</th>";
                    thead += "<th class='text-center bg-primary'>M.C</th>";
                    thead += "<th class='text-center bg-primary'>T°C</th>";
                    thead += "<th class='text-center bg-primary'>Operario</th>";
                    thead += "<th class='text-center bg-primary'>% Defecto</th></tr>";
                    tbody += "<tr>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td>No hay datos disponibles</td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "<td></td>"+
                        "</tr>";
                    callback($('<table id="detMCPECaract" class="table table-bordered table-condensed table-striped">' + thead + tbody + '</table>')).show();
                }
            }
        });
    }

    $("#tblCaracteristicas").on("click","tbody .detalles", function () {
        let table = $("#tblCaracteristicas").DataTable();
        let tr = $(this).closest("tr");
        //$(this).addClass("detalleNumOrdOrange");
        let row = table.row(tr);
        let data = table.row($(this).parents("tr")).data();

        if(row.child.isShown())
        {
            row.child.hide();
            tr.removeClass("shown");
        }else{
            mostrarDetallesCaract(row.child,data[0],data[0]);
            tr.addClass("shown");
            $("#detMCPECaract").DataTable({
                "info": false,
                "scrollX": true,
                "sort": false,
                "destroy": true,
                "searching": false,
                "paginate": false,
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
                    url: "darDeBajaMcpe",
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
