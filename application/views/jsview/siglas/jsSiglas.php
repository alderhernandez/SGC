<?php
/**
 * @Author: cesar mejia
 * @Date:   2019-07-30 09:29:13
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-07-30 13:43:12
 */
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#tblsiglas").DataTable({
			"processing": true,
			"info": true,
			"sort": true,
			"destroy": true,
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
	});

$("#siglas").keyup(function(){
	if($(this) != ""){
	   $(this).val($(this).val().toUpperCase());
	}
});	

$("#btnModal").click(function(){
	$("#modalEncabezado").text("Nueva Simbología");
	$("#idsiglas,#siglas,#desc,#cat").val("")
    $("#btnGuardar").show();
    $("#btnActualizar").hide();
	$("#modalSiglas").modal("show")
});

$("#btnGuardar").click(function(){
	if($("#siglas").val() == "" || $("#desc").val() == ""){
		Swal.fire({
    		imageUrl: "<?php echo base_url();?>assets/img/warning.png",
    		imageHeight: 60,
  			imageAlt: 'Advertencia',
    		text: "Todos los campos son obligatorios",
    		allowOutsideClick: false
       });
	}else{
		let mensaje = '', tipo = '';
		let form_data = {
			sigla: $("#siglas").val(),
			desc: $("#desc").val(),
			cat: $("#cat").val()
		};
		$.ajax({
			url: "guardarSimbologia",
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
				}).then((result) => {
					location.reload();
				});	
			}
		});
	}
});

function editar(id,sigla,desc,cat){
	$("#modalEncabezado").text("Editar Simbología");
	$("#idsiglas").val(id);
	$("#siglas").val(sigla);
	$("#desc").val(desc);
	$("#cat").val(cat);
    $("#btnGuardar").hide();
    $("#btnActualizar").show();
	$("#modalSiglas").modal("show")
}

$("#btnActualizar").click(function(){
	if($("#siglas").val() == "" || $("#desc").val() == ""){
		Swal.fire({
    		imageUrl: "<?php echo base_url();?>assets/img/warning.png",
    		imageHeight: 60,
  			imageAlt: 'Advertencia',
    		text: "Todos los campos son obligatorios",
    		allowOutsideClick: false
       });
	}else{
		let mensaje = '', tipo = '';
		let form_data = {
			idsiglas: $("#idsiglas").val(),
			sigla: $("#siglas").val(),
			desc: $("#desc").val(),
			cat: $("#cat").val()
		};
		$.ajax({
			url: "actualizarSimbologia",
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
				}).then((result) => {
					location.reload();
				});	
			}
		});
	}
});

function Baja(id,estado,sigla){
	let mensaje = '', texto = '';
	if(estado == "A"){
		mensaje = 'Se dará de baja la sigla '+sigla+', ésta ya no podra ser utilizada en el sistema.'+
			'¿Desea continuar?';
			text = 'Dar baja';
	}else{
		mensaje = '¿Desea restaurar la sigla '+sigla+'?';
			text = "Restaurar";
	}
	Swal.fire({
		text: mensaje,
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
				idsiglas: id,
				estado: estado
			};
			$.ajax({
				url: "Baja_Alta",
				type: "POST",
				data: form_data,
				success: function(data){
					let obj = jQuery.parseJSON(data);
					$.each(obj, function(index, element) {
						mensaje = element["mensaje"];
						tipo = element["tipo"];
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
