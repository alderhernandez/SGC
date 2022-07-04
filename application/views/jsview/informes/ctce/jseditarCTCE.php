<?php

?>
<script type="text/javascript">
	$(document).ready(function(){
		
	let table = $("#tblDatos").DataTable({"paginate":false,"searching":false});

	$(".numeric").numeric();
	$('.clockpicker').clockpicker();
	$("#ppatron,#pbascula,#iderror").numeric();


		$("#nitrito,#kg").numeric();
		$('#fecha').datepicker({"autoclose":true});
		$('.select2').select2({
			placeholder: "Seleccione",
			allowClear: true,
			language: "es"
		});	
		
	});
   

$("#btnGuardar").click(function(){
	let bandera = true;
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
		if(result.value){
			if (!validtable.data().count() ) {
		    	Swal.fire({
		    		text: "No se ha agregado ningún registro a la tabla",
		    		type: "error",
		    		allowOutsideClick: false
		    	});
			}else{
				$("#loading").modal("show");
			    let nombre = $("#nombreRpt").html(),
			    mensaje = '', tipo = '',	
				datos = new Array(), i = 0;
			    mensaje = '', tipo = '';
				
				var registro = 0;
				table.rows().eq(0).each(function(i, index){
					let row = table.row(index);
					let data = row.data();
					var id = data[0];
					datos[i] = [];
					datos[i][0] = data[0];
					datos[i][1] = data[1];
					datos[i][2] = $('#1toma-'+id).val();
					datos[i][3] = $('#2toma-'+id).val();
					datos[i][4] = $('#3toma-'+id).val();
					datos[i][5] = $('#observacion-'+id).val();
					datos[i][6] = $('#verificacion-'+id).val();
					registro +=  parseFloat($('#1toma-'+id).val()) || 0 + parseFloat($('#2toma-'+id).val()) || 0
					parseFloat($('#3toma-'+id).val()) || 0;
					console.log(registro);
					i++;
				});
				console.log("final: "+registro);
				let form_data = {
				    enc: [$("#observacionGeneral").val()],
				    datos: JSON.stringify(datos),
				    id: '<?php echo $enc[0]["IDREPORTE"] ?>'
				};
				if (registro == 0) {
					bandera = false;
					Swal.fire({
			    		text: "No se ha agregado ningún registro a la tabla",
			    		type: "error",
			    		allowOutsideClick: false
			    	});
			    	$("#loading").modal("hide");
				}
				if(bandera){
					$.ajax({
						url: '<?php echo base_url("index.php/guardarEditarCTCE") ?>',
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
								//window.location.href = "reporte_15";  
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
		}
	});
});




function baja(id,estado){
		let message = '', text = '';
		if(estado == "A"){
			message = 'Se dará de baja el informe, éste ya no podra ser utilizada en el sistema.'+
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
			}).then((result)=>{
				if(result.value){
					let mensaje = '', tipo = '';
					let form_data = {
						id:  id,
						estado: estado
					};
					$.ajax({
						url: "BajaAltaRVPBP",
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