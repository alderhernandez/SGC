<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-06 11:18:01
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-06 15:49:44
 */
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').select2({
			placeholder: "Seleccione una categoria",
			allowClear: true,
			language: "es"
		});
       $("#tblPermisos").DataTable({
			"processing": true,
			"info": true,
			"sort": true,
			"destroy": true,
			"lengthMenu": [
				[10,20,50,100, -1],
				[10,20,50,100, "Todo"]
			],
			"order": [
				[0, "asc"]
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

	$("#categorias").change(function(){
		let cat = $("#categorias option:selected").text();
		$("#modulo").val(cat+"/");
	});

	$("#btnModal").click(function(){
		$("#modalEncabezado").text("Nueva Autorizacion");
		$("#categorias").val("").trigger("change");
		$("#idpermiso,#modulo,#descripcion").val("");
		$("#btnGuardar").show()
		$("#btnActualizar").hide();
		$("#modalPermisos").modal("show");
	});

	$("#btnGuardar").click(function(){
		if($("#modulo").val() == "" || $("#descripcion").val() == "" || $("#categorias option:selected").val() == ""){
			Swal.fire({
				text: "Todos los campos son requeridos",
				type: "error",
				allowOutsideClick: false
			});
		}else{
			let mensaje = '', tipo = '';
			let form_data = {
				desc: $("#descripcion").val(),
				modulo: $("#modulo").val(),
				cat: $("#categorias option:selected").val()
			};
			$.ajax({
				url: "guardarPermisos",
				type: "POST",
				data: form_data,
				success: function(data){
					let obj = jQuery.parseJSON(data);
					$.each(obj, function(index, val) {
						 mensaje = val["mensaje"];
						 tipo = val["tipo"];
					}); 

					Swal.fire({
						type: tipo,
						text: mensaje,
						allowOutsideClick: false
					}).then((result) =>{
						location.reload();
					});
				}
			});
		}
	});

	function editar(id,modulo,cat,desc){
		$("#modalEncabezado").text("Editar Autorizacion");
		$("#categorias").val(cat).trigger("change");
		$("#idpermiso").val(id);
		$("#modulo").val(modulo);	
		$("#descripcion").val(desc);
		$("#btnGuardar").hide()
		$("#btnActualizar").show();
		$("#modalPermisos").modal("show");
	}

	$("#btnActualizar").click(function(){
		Swal.fire({
		text: "¿Estas seguro que deseas modificar estos datos?",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: "Aceptar",
		cancelButtonText: 'Cancelar',
		allowOutsideClick: false
	  }).then((result)=>{
	  	if(result.value){
	  		if($("#modulo").val() == "" || $("#descripcion").val() == "" || $("#categorias option:selected").val() == "")
	  		{
			Swal.fire({
				text: "Todos los campos son requeridos",
				type: "error",
				allowOutsideClick: false
			});
		}else{
			let mensaje = '', tipo = '';
			let form_data = {
				id: $("#idpermiso").val(),
				desc: $("#descripcion").val(),
				modulo: $("#modulo").val(),
				cat: $("#categorias option:selected").val()
			};
			$.ajax({
				url: "actualizarPermisos",
				type: "POST",
				data: form_data,
				success: function(data){
					let obj = jQuery.parseJSON(data);
					$.each(obj, function(index, val) {
						 mensaje = val["mensaje"];
						 tipo = val["tipo"];
					}); 

					Swal.fire({
						type: tipo,
						text: mensaje,
						allowOutsideClick: false
					}).then((result) =>{
						location.reload();
					});
				}
			});
		  }
	  	}
	  });
	});

	function Baja(id,estado,fecha)
	{
		let message = '', texto = '';
		if(estado == "A"){
			message = 'Estas seguro que deseas dar de baja este permiso';
			texto = 'Dar baja';
		}else{
			message = 'Estas seguro que deseas restaurar este permiso';
			texto = "Restaurar";
		} 
     Swal.fire({
		text: message,
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: texto,
		cancelButtonText: 'Cancelar',
		allowOutsideClick: false
	  }).then((result) => {
	  	if(result.value){
	  		let mensaje = '', tipo = '';
	  		let form_data = {
	  			id: id,
				estado: estado,
				fecha: fecha
	  		};
	  		$.ajax({
	  			url: "bajaPermisos",
	  			type: "POST",
	  			data: form_data,
	  			success: function(data){
	  				let obj = jQuery.parseJSON(data);
	  				$.each(obj, function(i, value){
	  					mensaje = value["mensaje"];
	  					tipo = value["tipo"];
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
	  });
	}
</script>