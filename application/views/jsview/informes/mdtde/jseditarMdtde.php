<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 7/11/2019 09:13 2019
 * FileName: jseditarMdtde.php
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
                            enc: [$("#idreporte").val(),$("#ddlAreas option:selected").val(),$("#version").val(),$("#Lote").val()],
                            detalle: JSON.stringify(detalle)
                        };

                        $.ajax({
                            url: "<?php echo base_url("index.php/guardarMdtde1")?>",
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
</script>
