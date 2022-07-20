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
        cargarEpp()
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

    function editar(id)
    {
       location.href = "<?php echo base_url('index.php/editarSalida/') ?>"+id;
    }
    
    $("#btnGuardar").click(function(){
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
                    enc: [$("#fecha").val(),data[0].id,data[0].text],
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


    function Baja(id,estado)
    {
        let message = '', text = '';
        if(estado == "1"){
            message = 'Se dará de baja el este documento, no se reflejara en los reportes.'+
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
        }).then((result) =>{
            if(result.value){
                let mensaje = '', tipo = '';
                let form_data = {
                    id: id,
                    estado: estado
                };
                $.ajax({
                    url: "BajaEPP",
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
    }

    $('#btnFiltrar').click(function(){        
        cargarEpp()
    })

    function cargarEpp(){   
    let table = $("#tblcataut").DataTable({
        "ajax": {
            "url": "mostrarEPP",
            "type": "POST",
            "data": function ( d ) {
                d.fecha1 = $("#desde").val();
                d.fecha2 = $("#hasta").val();                
                d.tipo = $("#selectTipo option:selected").val();
            }
        },
        "processing": true,
        "serverSide": true,
        "orderMulti": false,
        "info": true,
        "sort": true,
        "destroy": true,
        "responsive": true,
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
            {"data" : "Tipo"},
            {"data" : "Id"},
            {"data" : "Nombre"},
            {"data" : "FechaCrea"},
            {"data" : "FechaEdita"},
            {"data" : "Estado"},
            {"data" : "Boton"}

        ]
    });
}

</script>
