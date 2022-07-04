<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-05 13:33:39
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-06 11:05:34
 */
?>
<script type="text/javascript">

	$(document).ready(function(){
		$("#tblcataut").DataTable({
			"processing": true,
			"info": true,
			"sort": true,
			"destroy": true,
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
	
	$("#btnModal").click(function(){
		$("#modalEncabezado").text("Nueva categoría o módulo de autorización");
		$("#idcataut,#cataut").val("");
		$("#btnGuardar").show()
		$("#btnActualizar").hide();
		$("#modalCatAut").modal("show");
	});

	$("#btnGuardar").click(function(){
		if($("#cataut").val() == ""){
			Swal.fire({
				text: "Debe ingresar un nombre",
				type: "error",
				allowOutsideClick: false
			});
		}else{
			let mensaje = '', tipo = '';
			let form_data = {
				descripcion: $("#cataut").val()
			};

			$.ajax({
				url: "guardarAutCategoria",
				type: "POST",
				data: form_data,
				success: function(data){
					let obj = jQuery.parseJSON(data);
					$.each(obj, function(i, value){
						mensaje = value["mensaje"];
						tipo = value["tipo"];
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

	function editar(idCatAut,Desc){
		$("#modalEncabezado").text("Editar categoría o módulo de autorización");
		$("#idcataut").val(idCatAut);
		$("#cataut").val(Desc);
		$("#btnGuardar").hide()
		$("#btnActualizar").show();
		$("#modalCatAut").modal("show");	
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
			if($("#cataut").val() == ""){
				Swal.fire({
					text: "Debe ingresar un nombre",
					type: "error",
					allowOutsideClick: false
				});
			}else{
				let mensaje = '', tipo = '';
				let form_data = {
					id: $("#idcataut").val(),
					descripcion: $("#cataut").val()
				};

				$.ajax({
					url: "actualizarAutCategoria",
					type: "POST",
					data: form_data,
					success: function(data){
						let obj = jQuery.parseJSON(data);
						$.each(obj, function(i, value){
							mensaje = value["mensaje"];
							tipo = value["tipo"];
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
	  	 }
	  });
	});

	function Baja(id,desc,estado,fecha){
		let message = '', texto = '';
		if(estado == "A"){
			message = 'Estas seguro que deseas dar de baja la categoria '+desc+'';
			texto = 'Dar baja';
		}else{
			message = 'Estas seguro que deseas restaurar la categoria '+desc+'';
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
	  }).then((result) =>{
	  	if(result.value){
	  		let mensaje = '', tipo = '';
	  		let form_data = {
	  			id: id,
				descripcion: desc,
				estado: estado,
				fecha: fecha 
	  		};
	  		$.ajax({
	  			url: "baja",
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