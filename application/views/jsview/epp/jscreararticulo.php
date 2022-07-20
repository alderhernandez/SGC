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
           
           
            articulo = $("#descripcion").val(),
            fecha = $("#fecha").val()

            if(result.value){
            if ($("#descripcion").val()=='' || $("#descripcion").val().length <5 ) {               
                Swal.fire({
                    text: "Descripción demasiada corta",
                    type: "error",
                    allowOutsideClick: false
                });
            }else{
                $("#loading").modal("show");
                let mensaje = '', tipo = ''
               
                let form_data = {
                    descripcion: $("#descripcion").val()                   
                };

                $.ajax({
                    url: '<?php echo base_url("index.php/guardarCrearArticulo") ?>',
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
