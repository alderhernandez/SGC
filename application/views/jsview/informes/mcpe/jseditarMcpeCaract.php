<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/10/2019 15:00 2019
 * FileName: jseditarMcpeCaract.php
 */
?>
<script type="text/javascript">
    $(document).ready(function () {

        $("#version,#version1,#Codigo1,#produccion,#pesoMasaUtil,#pesoRegistrado,#Diferencia").numeric();
        $("#CantMues,#PV,#MS,#MC,#TC,#presentacion").numeric();

        let counter = $("#tblcrear").DataTable({"info": false,"scrollX": true,"sort": false,"destroy": true,"searching": false,
            "paginate": false}).rows().count()+1;
        $('#fecha,#fechaVenc').datepicker({"autoclose":true});
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

        $('#tblcrear tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('danger');
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
                maquina = $("#ddlMaquina option:selected").text(),
                presentacion =  $("#presentacion").val(),
                unidadpresentacion = $("#textoBtnPresentacion").text(),
                cant_muestr = $("#CantMues").val(),
                PV = $("#PV").val(),
                MS = $("#MS").val(),
                MC = $("#MC").val(),
                TC = $("#TC").val(),
                operario = $("#operario").val(),
                Defecto = $("#Defecto").val();

            if(fecha == "" || produccion == "" || ddlprod == "" || ddlTipo == "" || fechaVenc == "" || PV== "" || MS == ""
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
               /* $("#produccion").val("");
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

    $("#btnDelete").click(function (){
        let table = $("#tblcrear").DataTable();
        let rows = table.rows( '.danger' ).remove().draw();
    });

    $("#MC,#PV,#MS").on("keyup",function () {
        let  PV = Number($("#PV").val()),
            MS = Number($("#MS").val()),
            MC = Number($("#MC").val()),
            suma = 0;
        suma = PV+MS+MC;
        $("#Defecto").val(suma);
    });

    $("#btnActualizar").click(function () {
        $("#loading").modal("show");
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
                if(data[6].indexOf("(M1)") >= 0 ){
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
                detalle[it][12] = maquina;
                detalle[it][13] = data[13];
                detalle[it][14] = data[14];
                detalle[it][15] = data[15];
                it++;
                console.log(data[6].toString());
            });
            let mensaje='',tipo='';
            let form_data = {
                enc: [$("#idreporte").val(),version,$("#observaciones").val(),fecha],
                detalle: JSON.stringify(detalle)
            };
            console.log(form_data);
            $.ajax({
                url: "<?php echo base_url("index.php/actualizarMcpeVerificCaract")?>",
                type: "POST",
                data: form_data,
                success: function (data) {
                    let obj = jQuery.parseJSON(data);
                    $.each(obj, function (i, index) {
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
    });
</script>
