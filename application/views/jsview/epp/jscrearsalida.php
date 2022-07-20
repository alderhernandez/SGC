<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 1/10/2019 15:05 2019
 * FileName: jsmaquinas.php
 */
?>
<script type="text/javascript">
    $(document).ready(function () {

    });

    $('.select2').select2({
        placeholder: "Seleccione",
        allowClear: true,
        language: "es"
    });

    $(".js-data-example-ajax").select2({
        placeholder: '--- Seleccione un empleado ---',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url("index.php/getEmpleados")?>',
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
                    res.push({id:data[i].empID, text:data[i].nombre});
                    $("#campo").append('<input type="hidden" name="" id="'+data[i].empID+'txtpeso" class="form-control" value="'+data[i].empID+'">');
                }
                return {
                    results: res
                }
            },
            cache: true
        }
    }).trigger('change');


    $('#tblDatos tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('danger');
    });

    $("#btnDelete").click(function (){
        let table = $("#tblDatos").DataTable();
        let rows = table.rows( '.danger' ).remove().draw();
    });

    $("#btnAdd").click(function(){
        let table = $("#tblDatos").DataTable();
        let noRegistro = parseFloat(table.rows().count());
        console.log(noRegistro);

        let cantidad = parseFloat($('#cantidad').val());

        if (cantidad == '' || cantidad == 0) {
            Swal.fire({
                title: 'Aviso',
                text: "Favor ingrese una cantidad",
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar!'
            }).then((result) => {});
            return false;
        }

        var data = $('#selectEmpleados').select2('data');

        let idempleado = $("#selectEmpleados option:selected").val(),
        
        idarticulo = $("#selectArticulos option:selected").val(),
        articulo = $("#selectArticulos option:selected").text(),
        fecha = $("#fecha").val()

        if(idempleado == undefined){
            Swal.fire({
                text: "Seleccione un empleado",
                type: "warning",
                allowOutsideClick: false
            });
            return;
        }

        empleado = data[0].text
        if(cantidad<= 0 || cantidad == "" || isNaN(cantidad)){
            Swal.fire({
                text: "Ingrese una cantidad",
                type: "warning",
                allowOutsideClick: false
            });
            return;
        }else if(cantidad<1){
            Swal.fire({
                text: "Ingrese una cantidad",
                type: "warning",
                allowOutsideClick: false
            });
            return;
        }else{
            table.row.add([
                cantidad,
                idarticulo,
                articulo
                ]).draw(false);
            $("#cantidad").val("");
        }

    });

    $("#btnModal").click(function () {
        $("#modalEncabezado").text("Nueva máquina");
        $("#idmaquina").val("");
        $("#maquina").val("");
        $("#siglas").val("");
        $("#btnGuardar").show();
        $("#btnActualizar").hide();
        $("#modalMaquinas").modal("show");
    });

    function editar(idmaq,maq,siglas)
    {
        $("#modalEncabezado").text("Editar máquina");
        $("#idmaquina").val(idmaq);
        $("#maquina").val(maq);
        $("#siglas").val(siglas);
        $("#btnGuardar").hide();
        $("#btnActualizar").show();
        $("#modalMaquinas").modal("show");
    }
    
    $("#btnGuardar").click(function(){
        var canvas = document.getElementById("draw-canvas");
        var dataUrl = canvas.toDataURL();

        console.log(dataUrl)
        //drawText.innerHTML = dataUrl;
        //drawImage.setAttribute("src", dataUrl);
        

        Swal.fire({
            text: "¿Estas Seguro que Desea Guardar?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: "Cancelar",
            allowOutsideClick: false
        }).then((result)=>{
            let validtable = $('#tblDatos').DataTable();
            var data = $('#selectEmpleados').select2('data');

            let idempleado = $("#selectEmpleados option:selected").val(),

            idarticulo = $("#selectArticulos option:selected").val(),
            articulo = $("#selectArticulos option:selected").text(),
            fecha = $("#fecha").val()

            if(result.value){
             if ($('#fecha').val()=='') {
                $('#lote').focus();
                Swal.fire({
                    text: "Ingrese la fecha",
                    type: "error",
                    allowOutsideClick: false
                });             
            }else if (dataUrl.length<=10) {
                Swal.fire({
                    text: "Ingrese una firma",
                    type: "error",
                    allowOutsideClick: false
                });
            }else if (idempleado == undefined || idempleado == '' || isNaN(idempleado) ) {
                Swal.fire({
                    text: "Seleccione un empleado",
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
                let 
                mensaje = '', tipo = '',    
                datos = new Array(), i = 0;
                mensaje = '', tipo = '',    
                table = $("#tblDatos").DataTable();
                
                table.rows().eq(0).each(function(i, index){
                    let row = table.row(index);
                    let data = row.data();
                    datos[i] = [];
                    datos[i][0] = data[0];
                    datos[i][1] = data[1];
                    datos[i][2] = data[2];                  
                    i++;
                });
                console.log(datos);
                let form_data = {
                    enc: [$("#fecha").val(),data[0].id,data[0].text,dataUrl],
                    tipo: <?php echo $tipo ?>,
                    datos: JSON.stringify(datos)
                };

                $.ajax({
                    url: '<?php echo base_url("index.php/guardarSalida") ?>',
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
                            window.location.href = "<?php echo base_url("index.php/salida")?>";
                        });             
                    },error:function(){
                        Swal.fire({
                            type: "error",
                            text: "Error inesperado, Intentelo de Nuevo",
                            allowOutsideClick: false
                        });
                        $("#loading").modal("hide");
                    }
                });
            }
        }
    });
    });


    $("#btnActualizar").click(function () {
        if($("#maquina").val() == "" || $("#siglas").val() == ""){
            Swal.fire({
                text: "Todos los campos son requeridos",
                type: "error",
                allowOutsideClick: false
            });
        }else{
            let tipo = '', mensaje = '';
            let form_data = {
                idmaquina: $("#idmaquina").val(),
                maquina: $("#maquina").val(),
                siglas: $("#siglas").val()
            };
            $.ajax({
                url: "actualizarMaquina",
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

</script>
