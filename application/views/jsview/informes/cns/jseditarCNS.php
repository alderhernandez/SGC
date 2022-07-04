<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-19 14:24:32
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-20 16:02:39
 */
?>
<script type="text/javascript">
	$(document).ready(function(){
        $("#nitrito,#kg,#version").numeric();
		$('#fecha').datepicker({"autoclose":true});
		$('.select2').select2({
			placeholder: "Seleccione un area",
			allowClear: true,
			language: "es"
		});

		$("#tblCNS").DataTable();
	});

	$('#tblcrear tbody').on( 'click', 'tr', function () {
          $(this).toggleClass('danger');
      });

	$("#btnDelete").click(function (){
      let table = $("#tblcrear").DataTable();
      let rows = table.rows( '.danger' ).remove().draw();
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
   		let fecha = $("#fecha").val(),
   		cantidad = $("#nitrito").val(),
   		cantidad2 = $("#nitrito2").val(),
   		kg = $("#kg").val(),
   		monituser = $("#monituser").val();

   		if(fecha == "" || cantidad == "" || kg == "" || monituser == ""){
   			Swal.fire({
   				text: "Todos los campos son requeridos",
   				type: "warning",
   				allowOutsideClick: false
   			});
   		}else{
   			t.row.add([
				fecha,
				cantidad,
				cantidad2,
				kg,
				monituser	   			
   			]).draw(false);

   		/*$("#fecha").val("");
   		$("#nitrito").val("");
   		$("#kg").val(""); */
   		//$("#ddlAreas").val("").trigger("change");
   		}
   });


$("#btnActualizar").click(function(){
	Swal.fire({
		text: "¿Estas seguro que todos los datos están correctos?",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		allowOutsideClick: false
	}).then((result)=>{
		let validtable = $('#tblcrear').DataTable();
		if(result.value){
			if($("#ddlAreas option:selected").val() == "" || $("#version").val() == "" || $("#observaciones").val() == ""){
				Swal.fire({
					text: "Debe ingresar un Area, Version u Observacion",
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
			    let nombre = $("#nombreRpt").html(),
			    mensaje = '', tipo = '',	
				table = $("#tblcrear").DataTable();
				let datos = new Array(), i = 0;
				
				table.rows().eq(0).each(function(i, index){
					let row = table.row(index);
					let data = row.data();
					datos[i] = data[0]+","+data[1]+","+data[2]+","+data[3];
					i++;
				});

				let form_data = {
				    enc: [$("#idreporte").val(),$("#ddlAreas option:selected").val(),$("#version").val(),$("#observaciones").val()],
				    datos: datos	
				};

				$.ajax({
					url: '<?php echo base_url("index.php/actualizarCNS")?>',
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
							window.location.href = "<?php echo base_url("index.php/reporte_6")?>";  
						});				
					}
				});
			}
		}
	});
});
</script>