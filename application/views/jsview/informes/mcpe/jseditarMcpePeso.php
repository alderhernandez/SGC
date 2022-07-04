<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/10/2019 09:39 2019
 * FileName: jseditarMCPE.php
 */
?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".clockpicker").clockpicker({
            donetext: "Aceptar"
        });
        $("#version,#version1,#Codigo,#produccion,#pesoMasaUtil,#pesoRegistrado,#Diferencia").numeric();
        let counter = $("#tblcrear").DataTable().rows().count() + 1;
        $('#tblcrear').DataTable( {
            "scrollX": false,
            "searching": false,
            "ordering": false,
            "paginate": false,
            "info": false,
            "destroy": true,
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
                version1 = $("#version").val(),
                Hora = $("#Hora").val(),
                Codigo = $("#Codigo").val(),
                pesoMasaUtil = $("#pesoMasaUtil").val(),
                pesoRegistrado = $("#pesoRegistrado").val(),
                Diferencia = $("#Diferencia").val(),
                btn1 = $("#textoButton1").text(),
                btn2 = $("#textoButton2").text(),
                peso='';

            if(fecha == "" || version1 == "" || Hora == "" || Codigo == "" || pesoMasaUtil == "" || pesoRegistrado == ""){
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
                        peso = "Gramos";
                        break;
                    case "lbs":
                        peso = "Libras";
                        break;
                    case "kg":
                        peso = "KG";
                        break;
                }
                t.row.add([
                    counter,
                    Hora,
                    Codigo,
                    pesoMasaUtil,
                    pesoRegistrado,
                    peso,
                    Diferencia
                ]).draw(false);
                //$("#ddlAreas").val("").trigger("change");
               /* $("#Codigo1").val("");
                $("#pesoMasaUtil").val("");
                $("#pesoRegistrado").val("");
                $("#Diferencia").val("");*/
            }
            counter++;
        });
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

    $('#tblcrear tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('danger');
    });
    $("#btnDelete").click(function (){
        let table = $("#tblcrear").DataTable();
        let rows = table.rows( '.danger' ).remove().draw();
    });

    $("#pesoRegistrado").on("keyup",function () {
        let pesoMasaUtil = $("#pesoMasaUtil").val(),
            pesoRegistrado = $("#pesoRegistrado").val(),
            diferencia = 0;
        diferencia = pesoMasaUtil-pesoRegistrado;
        $("#Diferencia").val(diferencia);
    });

    $("#btnActualizarpeso").click(function () {
        $("#loading").modal("show");
       let codigoreporte = $("#idreporte").val(),
            version = $("#version").val(),
            btn1 = $("#textoButton1").text(),
            btn2 = $("#textoButton2").text(),
            fecha = $("#fecha").val();
        let table = $("#tblcrear").DataTable();
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
                enc: [codigoreporte,version,fecha],
                detalle: JSON.stringify(detalle)
            };
            $.ajax({
                url: "<?php echo base_url("index.php/actualizarMcpeVerificPeso")?>",
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
                    }).then((result)=>{
                        location.reload();
                    });
                }
            });
        }
    });
</script>
