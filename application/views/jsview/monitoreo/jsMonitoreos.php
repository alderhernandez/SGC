<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 23/4/2019 09:01 2019
 * FileName: jsRoles.php
 */
?>
<script type="text/javascript">
	$(document).ready(function () {
		$("#tblRoles").DataTable({
			"processing": true,
			"info": true,
			"sort": true,
			"destroy": true,
			"responsive": true,
			"lengthMenu": [
				[10,20,50,100, -1],
				[10,20,50,100, "Todo"]
			],
			"order": [
				[1, "desc"]
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

	$("#btnModal").click(function () {
		$("#modalRoles").modal("show");
		$("#btnGuardar").show();
		$("#btnActualizar").hide();
		$("#modalEncabezado").html("Nuevo Monitoreo Diario");
		$("#rol").val("");
		$("#comment").val("");
	});

	$("#btnGuardar").click(function () {
		let retorno;
		let mensaje;
		Swal.fire({
			type: "warning",
			text: "¿Esta Segur@? Se Desactivarán los Monitoreos Anteriores",
				allowOutsideClick: false
			}).then((result) =>{
			$.ajax({
				url: "crearmonitoreo",
				type: "POST",
				data:  {
					proceso: $("#rol").val()				
				},
				success: function (data) {
					let obj = jQuery.parseJSON(data);
					$.each(obj, function(index, val) {
						if (val["retorno"]) {
							Swal.fire({
								text: "Monitoreo Creado Correctamente!",
								type: "info",
								allowOutsideClick: false
							});
							$("#modalRoles").modal("hide");
							location.reload();
						}else{
							Swal.fire({
								text: val["mensaje"],
								type: "error",
								allowOutsideClick: false
							});
						}
					});
				}
			});
			
		});
	});

	function EditarRol(id,rol,coment){
		$("#btnGuardar").hide();
		$("#btnActualizar").show();
		$("#modalEncabezado").html("Editar Rol");
		$("#idRol").val(id);
		$("#rol").val(rol);
		$("#comment").val(coment);
		$("#modalRoles").modal("show");
	}
	
	$("#btnActualizar").click(function () {
		Swal.fire({
			text: "¿Estas seguro que deseas modificar la información este rol?",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Actualizar',
			cancelButtonText: 'Cancelar',
			allowOutsideClick: false
		}).then((result) => {
			if (result.value) {
				if($("#rol").val() == "" || $("#comment").val() == ""){
					Swal.fire({
						type: "error",
						text: "Ambos campos son requeridos",
						allowOutsideClick: false
					});
				}else{
					let mensaje = '', tipo = '';
					let form_data = {
						idrol: $("#idRol").val(),
						rol: $("#rol").val(),
						desc: $("#comment").val()
					};

					$.ajax({
						url: "actualizarRol",
						type: "POST",
						data: form_data,
						success: function (data) {
							let obj = jQuery.parseJSON(data);
							$.each(obj, function (i, item) {
								mensaje = item["mensaje"];
								tipo = item["tipo"];
							});
							Swal.fire({
								type: tipo,
								text: mensaje,
								allowOutsideClick: false
							}).then((result)=>{
								location.reload();
							});
						}
					});
				}
			}
		});
	});

	function darDeBaja(idrol,estado) {
		let mensaje = '';
		if(estado == 1){mensaje = '¿Estas seguro de deseas dar de baja este rol?'}
		else{mensaje='¿Estas seguro de deseas restaurar este rol?'}
		Swal.fire({
			text: mensaje,
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Aceptar',
			cancelButtonText: 'Cancelar',
			allowOutsideClick: false
		}).then((result)=>{
			if(result.value){
				let form_data = {
					idrol: idrol,
					estado: estado
				};
				$.ajax({
					url: "modificarEstadoRol",
					type: "POST",
					data: form_data,
					success: function (data) {
						Swal.fire({
							type: "success",
							text: "Proceso finalizado con éxito",
							allowOutsideClick: false
						}).then((result) => {
							location.reload();
						});
					},
					error: function () {
						Swal.fire({
							type: "error",
							text: "Ocurrió un error inesperado en el servidor, contáctece con el administrador",
							allowOutsideClick: false
						}).then((result) => {
							location.reload();
						});
					}
				});
			}
		});
	}
</script>
