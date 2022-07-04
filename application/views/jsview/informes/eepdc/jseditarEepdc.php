<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 23/10/2019 09:13 2019
 * FileName: jseditarEepdc.php
 */
?>
<script type="text/javascript">
    $(document).ready(function () {

        $("#version,#txtL,#txtGC,#txtGT").numeric();
        let counter =  $("#tblcrear").DataTable().rows().count() + 1;
        $('#tblcrear').DataTable( {
            "scrollX": false,
            "destroy": true,
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

        $('#fecha').datepicker({"autoclose":true});

        $("#ddlcabezal").select2({
            placeholder: '--- Seleccione una opcion ---',
            allowClear: true
        });
        $("#ddlarea").select2({
            placeholder: '--- Seleccione una Maquina ---',
            allowClear: true
        });
        $("#ddlempresa").select2({
            placeholder: '--- Seleccione una Empresa ---',
            allowClear: true
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

        $("#btnAdd").click(function () {
            let t = $('#tblcrear').DataTable({
                "info": false,
                "scrollX": false,
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
            let version = $("#version").val(),
                area = $("#ddlarea option:selected").val(),
                fecha = $("#fecha"),
                empresa = $("#ddlempresa option:selected").text(),
                cabezal = $("#ddlcabezal option:selected").val(),
                prod = $("#ddlprod option:selected").text(),
                codprod = $("#ddlprod option:selected").val(),
                produccion = $("#produccion").val(),
                txtL = $("#txtL").val(),
                txtGC = $("#txtGC").val(),
                txtGT = $("#txtGT").val();
            if(!t.data().count()){
                counter = 1;
            }
            if(version == "" || area =="" || fecha == "" || empresa == "" || cabezal == "" || prod ==""||produccion==""||txtL==""||txtGC==""||txtGT==""){
                Swal.fire({
                    text: "Todos los campos son requeridos",
                    type: "warning",
                    allowOutsideClick: false
                });
            }else{
                t.row.add([
                    counter,
                    empresa,
                    codprod,
                    prod,
                    produccion,
                    cabezal,
                    txtL,
                    txtGC,
                    txtGT
                ]).draw(false);
            }
            counter++;
            calculos();
        });

        function calculos()
        {
            const K = 0.22; let T = 0;
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
        }),contador = 0;
            let detalle = new Array(),detalle1 = new Array(),detalle2 = new Array(), it = 0,
                sumaL = 0,sumaGC = 0, sumaGT = 0;
            t.rows().eq(0).each(function (i, index) {
                let row = t.row(index);
                let data =  row.data();
                detalle[it] = parseFloat(data[6]);
                detalle1[it] = parseFloat(data[7]);
                detalle2[it] = parseFloat(data[8]);
                it++;
                contador = it;
            });
            sumaL = detalle.reduce((a, b) => a + b, 0);
            sumaGC = detalle1.reduce((a, b) => a + b, 0);
            sumaGT = detalle2.reduce((a, b) => a + b, 0);

            if(contador != 3){
                $("#spanL").html(parseFloat(sumaL).toFixed(2));
                $("#spanGC").html(parseFloat(sumaGC).toFixed(2));
                $("#spanGT").html(parseFloat(sumaGT).toFixed(2));

                T = (Number($("#spanGC").html())+Number($("#spanGT").html())+K)-Number($("#spanL").html());
                $("#spanT").html(parseFloat(T).toFixed(2));
            }else{
                $("#spanL").html(parseFloat(sumaL/3).toFixed(2));
                $("#spanGC").html(parseFloat(sumaGC/3).toFixed(2));
                $("#spanGT").html(parseFloat(sumaGT/3).toFixed(2));

                T = (Number($("#spanGC").html())+Number($("#spanGT").html())+K)-Number($("#spanL").html());
                $("#spanT").html(parseFloat(T).toFixed(2));
            }
        }

        $('#tblcrear tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('danger');
        });
        $("#btnDelete").click(function (){
            let table = $("#tblcrear").DataTable();
            let rows = table.rows( '.danger' ).remove().draw();
            calculos();
        });
    });

    $("#btnActualizar").click(function () {
        let version = $("#version").val(),
            area = $("#ddlarea option:selected").val(),
            fecha = $("#fecha").val(),
            T = $("#spanT").html(),
            empresa = 0,
            observaciones = $("#observaciones").val();
        let table = $("#tblcrear").DataTable();
        if(!table.data().count()){
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
                if(data[1] == "DELMOR"){
                    empresa = 1;
                }else if(data[1] == "D´lago"){
                    empresa = 2;
                }else if(data[1] == "Panamá"){
                    empresa = 3;
                }
                detalle[it][0] = empresa;
                detalle[it][1] = data[2];
                detalle[it][2] = data[3];
                detalle[it][3] = data[4];
                detalle[it][4] = data[5];
                detalle[it][5] = T;
                detalle[it][6] = data[6];
                detalle[it][7] = data[7];
                detalle[it][8] = data[8];
                it++;
                console.log(data[1]);
            });
            let mensaje='',tipo='';
            let form_data = {
                enc: [$("#idreporte").val(),area,version,observaciones],
                detalle: JSON.stringify(detalle)
            };
            console.log(form_data);
           $.ajax({
                url: "<?php echo base_url("index.php/actualizarEepdc")?>",
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
</script>
