<script type="text/javascript">
	$(document).ready(function(){
	   $("#tblareas").DataTable({
			"processing": true,
			"info": true,
			"sort": true,
			"destroy": true,
			"lengthMenu": [
				[10,20,50,100, -1],
				[10,20,50,100, "Todo"]
			],
			"order": [
				[2, "asc"]
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
		$("#modalEncabezado").text("Nueva área");
		$("#idarea").val("");
		$("#area").val("");
		$("#siglas").val("");
		$("#btnGuardar").show();
		$("#btnActualizar").hide();
		$("#modalAreas").modal("show");
	});

    $("#btnGuardar").click(function(){
    	if($("#area").val() == "" || $("#siglas").val() == ""){
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
				area: $("#area").val(), 
				siglas: $("#siglas").val()
    		};

    		$.ajax({
    			url: "guardarAreas",
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
    				}).then((result)=>{
    					location.reload();
    				});
    			}
    	   });
    	}
    });

    function editar(idarea,area,siglas){
    	$("#modalEncabezado").text("Editar área");
		$("#idarea").val(idarea);
		$("#area").val(area);
		$("#siglas").val(siglas);
		$("#btnGuardar").hide();
		$("#btnActualizar").show();
		$("#modalAreas").modal("show");
    }

	$("#btnActualizar").click(function(){
		if($("#area").val() == "" || $("#siglas").val() == ""){
    		Swal.fire({
    			imageUrl: "<?php echo base_url();?>assets/img/warning.png",
    			imageHeight: 60,
  				imageAlt: 'Advertencia',
    			text: "Todos los campos son obligatorios",
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
			}).then((result)=>{
				if(result.value){
					let mensaje = '', tipo = '';
			    	let form_data = {
			    		  idarea: $("#idarea").val(),
						  area: $("#area").val(), 
						  siglas: $("#siglas").val()
		    	    	};
		    	    $.ajax({
		    			url: "actualizarAreas",
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
		    				}).then((result)=>{
		    					location.reload();
		    				});
		    			}
		    	   });
				}
			});
    	}
	});

	function baja(idarea,area,estado){
		let message = '', text = '';
		if(estado == 1){
			message = 'Se dará de baja el área '+area+', ésta ya no podra ser utilizada en el sistema.'+
			'¿Desea continuar?';
			text = 'Dar baja';
		}else{
			message= '¿Desea restaurar el área '+area+'?';
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
			}).then((result)=>{
				if(result.value){
					let mensaje = '', tipo = '';
					let form_data = {
						idarea:  idarea,
						estado: estado
					};
					$.ajax({
						url: "Baja_AltaAreas",
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
							}).then((result)=>{
								location.reload();
							});
						}
					});
				}
			});
	}
</script>