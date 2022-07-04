<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-09 10:55:30
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-12 09:40:02
 */
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#tblsiglasRep").DataTable({
			"processing": true,
			"info": true,
			"sort": true,
			"destroy": true,
			"lengthMenu": [
				[10,20,50,100, -1],
				[10,20,50,100, "Todo"]
			],
			"order": [
				[2, "desc"]
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

	$("#btnModal").click(function(){
		$("#modalEncabezado").text("Nueva Categoria Reporte");
		$("#idsiglas,#siglas,#descripcion").val("");
		$("#btnGuardar").show();
		$("#btnActualizar").hide();
		$("#modalReport").modal("show");
	});

	$("#btnGuardar").click(function(){
		if($("#siglas").val() == "" || $("#descripcion").val() == ""){
			Swal.fire({
				text: "Todos los campos son obligatorios",
				type: "error",
				allowOutsideClick: false
			});
		}else{
			let mensaje = '', tipo = '';
			let form_data = {
				sigla: $("#siglas").val(),
				nombre: $("#descripcion").val()
			};
			$.ajax({
				url: "guardarCatRep",
				type: "POST",
				data: form_data,
				success: function(data){
					let obj = jQuery.parseJSON(data);
					$.each(obj, function(index, val) {
						 mensaje = val["mensaje"];
						 tipo = val["tipo"];
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

	function editar(id,siglas,nombre){
		$("#modalEncabezado").text("Editar Categoria Reporte");
		$("#idsiglas").val(id);
		$("#siglas").val(siglas);
		$("#descripcion").val(nombre);
		$("#btnGuardar").hide();
		$("#btnActualizar").show();
		$("#modalReport").modal("show");
	}

$("#btnActualizar").click(function(){
		if($("#siglas").val() == "" || $("#descripcion").val() == ""){
			Swal.fire({
				text: "Todos los campos son obligatorios",
				type: "error",
				allowOutsideClick: false
			});
		}else{
			Swal.fire({
			  text: "¿Estas seguro(a) que deseas modificar estos datos?",
			  type: 'question',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Actualizar',
			  cancelButtonText: 'Cancelar',
			  allowOutsideClick: false
			}).then((result) => {
				if(result.value){
					let mensaje = '', tipo = '';
					let form_data = {
						id: $("#idsiglas").val(),
						sigla: $("#siglas").val(),
						nombre: $("#descripcion").val()
					};
					$.ajax({
						url: "actualizarCatRep",
						type: "POST",
						data: form_data,
						success: function(data){
							let obj = jQuery.parseJSON(data);
							$.each(obj, function(index, val) {
								 mensaje = val["mensaje"];
								 tipo = val["tipo"];
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
	});


function Baja(id,estado,sigla){
	let mensaje = '', texto = '';
	if(estado == "A"){
		mensaje = 'Se dará de baja la categoria '+sigla+', ésta ya no podra ser utilizada en el sistema.'+
			'¿Desea continuar?';
			text = 'Dar baja';
	}else{
		mensaje = '¿Desea restaurar la categoria '+sigla+'?';
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
				id: id,
				estado: estado
			};
			$.ajax({
				url: "Baja_AltaCatRep",
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