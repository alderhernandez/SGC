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
        Swal.fire({
            text: "¿Estas Seguro que Desea Actualizar Este Registro?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: "Cancelar",
            allowOutsideClick: false
        }).then((result)=>{           
           
            idarticulo = <?php echo $enc[0]["Id"]; ?>,
            articulo = $("#descripcion").val(),
            fecha = $("#fecha").val()

            if(result.value){
             if ($('#idarticulo').val()=='') {               
                Swal.fire({
                    text: "ERROR AL OBTENER IDENTIFICADOR DEL ARTICULO",
                    type: "error",
                    allowOutsideClick: false
                });             
            }else if ($("#descripcion").val()=='' || $("#descripcion").val().length <5 ) {               
                Swal.fire({
                    text: "Descripción demasiada corta",
                    type: "error",
                    allowOutsideClick: false
                });
            }else{
                $("#loading").modal("show");
                let mensaje = '', tipo = ''
               
                let form_data = {
                    descripcion: $("#descripcion").val(),                   
                    id: <?php echo $enc[0]["Id"]; ?>
                };

                $.ajax({
                    url: '<?php echo base_url("index.php/guardarEditarArticulo") ?>',
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
                            window.location.href = "<?php echo base_url("index.php/articulosEpp")?>";
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


</script>
