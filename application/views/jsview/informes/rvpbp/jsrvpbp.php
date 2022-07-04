<?php

?>
<script type="text/javascript">
	$(document).ready(function(){

	$('.clockpicker').clockpicker();
	$("#ppatron,#pbascula,#iderror").numeric();


		$("#nitrito,#kg").numeric();
		$('#fecha').datepicker({"autoclose":true});
		$('.select2').select2({
			placeholder: "Seleccione",
			allowClear: true,
			language: "es"
		});

		$("#tblCNS").DataTable();
	});

	$('#tblDatos tbody').on( 'click', 'tr', function () {
          $(this).toggleClass('danger');
      });

	$("#btnDelete").click(function (){
      let table = $("#tblDatos").DataTable();
      let rows = table.rows( '.danger' ).remove().draw();
  });

   $("#btnAdd").click(function(){
   		let t = $('#tblDatos').DataTable({
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
   		let area = $("#ddlAreas option:selected").val(),
		instrumento = $("#instrumento").val(),
   		fecha = $("#fecha").val(),   		
   		hora = $("#hora").val(),
   		codigo = $("#codigo").val(),
   		peso = $("#ddpeso option:selected").text(),
   		ppatron = $("#ppatron").val(),
   		pbascula = $("#pbascula").val(),   		
   		observacion = $("#observaciones").val(), 
   		monituser = $("#monituser").val();


   		if(fecha == ""  || instrumento == "" || hora == "" || codigo == "" || ppatron == "" || pbascula == "" || monituser == "" || area == "" || peso == ""){
   			Swal.fire({
   				text: "Todos los campos son requeridos,Excepto Observación",
   				type: "warning",
   				allowOutsideClick: false
   			});
   		}else{

   			let diferencia = parseFloat(ppatron) - parseFloat(pbascula);
   			t.row.add([
				fecha,
				hora,
				codigo,
				ppatron,
				pbascula,
				peso,
				diferencia,
				observacion
   			]).draw(false);

   		/*$("#hora").val("");
   		$("#ppatron").val("");
   		$("#pbascula").val(""); 
   		$("#observaciones").val(""); */

   		//$("#ddlAreas").val("").trigger("change");
   		}
   });


$("#btnGuardar").click(function(){
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
			if($("#ddlAreas option:selected").val() == "" || $("#instrumento").val() == "" 
				|| $("#iderror").val() == ""){
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
				table = $("#tblDatos").DataTable();
				let datos = new Array(), i = 0;
				
				table.rows().eq(0).each(function(i, index){
					let row = table.row(index);
					let data = row.data();
					datos[i] = data[0]+"|"+data[1]+"|"+data[2]+"|"+data[3]+"|"+data[4]+"|"+data[5]+"|"+data[6]+"|"+data[7];
					i++;
				});

				let form_data = {
				    enc: [$("#idmonitoreo").val(),$("#ddlAreas option:selected").val(),nombre,$("#observaciones").val(),$("#iderror").val(),$("#instrumento").val(),$("#observacionGeneral").val()],
				    datos: datos
				};

				$.ajax({
					url: '<?php echo base_url("index.php/guardarRVPBP")?>',
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
							window.location.href = "reporte_7";  
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

function mostrarDetalles(callback,id,div)
{
	$.ajax({
		url: "mostrarCNSDetalle/"+id,
		async: true,
		success: function(response){
			let thead = '',tbody='', cont = 0;
			if(response != "false"){
				let obj = $.parseJSON(response);
				let temp = obj.length;
				let cantRows = 0;
				thead += "<tr class=''><th class='text-center bg-primary'>NumLinea</th>";
				thead += "<th class='text-center bg-primary'>Fecha ingreso</th>";
				thead += "<th class='text-center bg-primary'>Cant. Nitrito</th>";
				thead += "<th class='text-center bg-primary'>Cant. Kg</th>";
				thead += "<th class='text-center bg-primary'>Fecha crea</th>";
				thead += "<th class='text-center bg-primary'>Hora crea</th></tr>";
				$.each(JSON.parse(response), function(i, item){
					tbody += "<tr>"+
						"<td class='text-center bg-info'>"+item["NUMERO"]+"</td>"+
						"<td class='text-center bg-info'>"+item["FECHAINGRESO"]+"</td>"+
						"<td class='text-center bg-info'>"+item["CANTIDADNITRITO"]+"</td>"+
						"<td class='text-center bg-info'>"+item["CANTIDADKG"]+"</td>"+
						"<td class='text-center bg-info'>"+item["FECHACREADET"]+"</td>"+
						"<td class='text-center bg-info'>"+item["HORA"]+"</td>";
				});
				callback($("<table id='detCNS' class='table table-bordered table-condensed table-striped'>"+ thead + tbody + "</table>")).show();
			}else {
				thead += "<tr class=''><th class='text-center bg-primary'>NumLinea</th>";
				thead += "<th class='text-center bg-primary'>Fecha ingreso</th>";
				thead += "<th class='text-center bg-primary'>Cant. Nitrito</th>";
				thead += "<th class='text-center bg-primary'>Cant. Kg</th>";
				thead += "<th class='text-center bg-primary'>Fecha crea</th>";
				thead += "<th class='text-center bg-primary'>Hora crea</th></tr>";
				tbody += '<tr >' +
					    "<td></td>"+
						"<td></td>"+
						"<td></td>"+
						"<td>No hay datos disponibles</td>"+
						"<td></td>"+
						"<td></td>"+
					'</tr>';
				callback($('<table id="detCNS" class="table table-bordered table-condensed table-striped">' + thead + tbody + '</table>')).show();
			}
		}
	});
}

$("#tblCNS").on("click","tbody .detalles", function () {
        let table = $("#tblCNS").DataTable();
        let tr = $(this).closest("tr");
        //$(this).addClass("detalleNumOrdOrange");
        let row = table.row(tr);
        let data = table.row($(this).parents("tr")).data();
        
        if(row.child.isShown())
           {
              row.child.hide();
               tr.removeClass("shown");
           }else{
               mostrarDetalles(row.child,data[0],data[0]);
               tr.addClass("shown");
           }
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