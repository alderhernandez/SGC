<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 3/9/2019 15:08 2019
 * FileName: jseditarVeced.php
 */?>
<script type="text/javascript">
$(document).ready(function () {
    let counter = 1;
    $('#fecha').datepicker({"autoclose":true});
    $("#version,#estibas,#pesolbs,#temperatura").numeric();

    $("#btnAdd").click(function(){
        let producto = $("#ddlprod option:selected").val();
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
        let Area = $("#Area").val(),
            version = $("#version").val(),
            fecha = $("#fecha").val(),
            produccion = $("#produccion").val(),
            estibas = $("#estibas").val(),
            monituser = $("#monituser").val(),
            pesolbs = $("#pesolbs").val(),
            temperatura = $("#temperatura").val(),
            observaciones = $("#observaciones").val(),
            acciones = $("#acciones").val();

        if(fecha == "" || version == "" || produccion == "" ||  producto == "" || pesolbs == '' || temperatura == ''){
            Swal.fire({
                text: "Todos los campos son requeridos",
                type: "warning",
                allowOutsideClick: false
            });
        }else if (!t.data().count()){
            counter = 1;
            t.row.add([
                counter,
                pesolbs,
                temperatura,
                observaciones,
                acciones
            ]).draw(false);
            /*$("#estibas").val("");
            $("#monituser").val("");
            $("#pesolbs").val("");
            $("#temperatura").val("");
            $("#observaciones").val("");
            $("#acciones").val("");*/
        }else{
            t.row.add([
                counter,
                pesolbs,
                temperatura,
                observaciones,
                acciones
            ]).draw(false);
            $("#monituser").val("");
            $("#pesolbs").val("");
            $("#temperatura").val("");
            $("#observaciones").val("");
            $("#acciones").val("");
            //$("#ddlprod").val("").trigger("change");
        }
        counter++;
    });

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

$('#tblcrear tbody').on( 'click', 'tr', function () {
    $(this).toggleClass('danger');
});

$("#btnDelete").click(function (){
    let table = $("#tblcrear").DataTable();
    let rows = table.rows( '.danger' ).remove().draw();
});

$("#btnGuardar").click(function(){
    let codproducto = $("#ddlprod option:selected").val(),producto = $("#ddlprod option:selected").text(), nombre = $("#nombreRpt").html();
    let Area = $("#Area").val(), version = $("#version").val(), fecha = $("#fecha").val(),produccion = $("#produccion").val(),
        estibas = $("#estibas").val(),monituser = $("#monituser").val(), pesolbs = $("#pesolbs").val(), temperatura = $("#temperatura").val(),
        observaciones = $("#observaciones").val(), acciones = $("#acciones").val();
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
            if(fecha == "" || version == "" || produccion == "" ||  codproducto == ""){
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
                    datos[i] = fecha+","+codproducto+","+producto+","+data[1]+","+data[2]+","+data[3]+","+data[4];
                    i++;
                });

                let form_data = {
                    enc: [$("#idreporte").val(),$("#idmonitoreo").val(),Area,version,nombre,estibas,produccion],
                    datos: datos
                };

                $.ajax({
                    url: '<?php echo base_url("index.php/actualizarVeced")?>',
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
                            window.location.href = "<?php echo base_url("index.php/reporte_8")?>";
                        });
                    }
                });
            }
        }
    });
});
</script>
