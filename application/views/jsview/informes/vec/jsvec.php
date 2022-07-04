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

		$('#txtMuestreo, #txtTemperatura, #observaciones').keyup(function(e){
		    if(e.keyCode == 13)
		    {
		        $('#btnAdd').trigger("click");
		    }
		});

		$(".js-data-example-ajax").select2({
			placeholder: '--- Seleccione un Producto ---',
			allowClear: true,
			ajax: {
				url: '<?php echo base_url("index.php/getProductosSAP")?>',
				dataType: 'json',
				type: "POST",
				quietMillis: 100,
				data: function (params) {
					return {
			        q: params.term,  // search term
        			page: params.page
			      };
				},
				processResults: function (data, params) {
					params.page = params.page || 1;
					let res = [];
					for(let i  = 0 ; i < data.length; i++) {
						res.push({id:data[i].ItemCode, text:data[i].ItemName});
						$("#campo").append('<input type="hidden" name="" id="'+data[i].ItemCode+'txtpeso" class="form-control" value="'+data[i].SWeight1+'">');
					}
					return {
						results: res
					}
				},
				cache: true
			}
		}).trigger('change');
		
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
   		let codigo = $("#ddlprod option:selected").val(),
   		descripcion = $("#ddlprod option:selected").text(),
		codmaquina = $("#cmbMaquina option:selected").val(),
		maquina = $("#cmbMaquina option:selected").text(),
   		operario = $("#txtOperario").val(),   		
   		muestra = $("#txtMuestreo").val(),
   		textura = $("#txtTextura option:selected").text(),
   		color = $("#txtColor option:selected").text(),
   		tpasta = $("#txtTemperatura").val(),
   		phpasta = $("#txtPh option:selected").text(),
   		observacion = $("#observaciones").val();


   		if(codigo == ""  || descripcion == "" || codmaquina == "" || operario == "" || muestra == "" || textura == "" || phpasta == ""){
   			Swal.fire({
   				text: "Todos los campos son requeridos,Excepto Observación",
   				type: "warning",
   				allowOutsideClick: false
   			});
   		}else{   			
   			t.row.add([
				codigo,
				descripcion,
				codmaquina,
				maquina,
				operario,
				muestra,
				textura,
				color,
				tpasta,
				phpasta,
				observacion
   			]).draw(false);

   		/*$("#txtMuestreo").val("");
   		$("#observaciones").val("");*/
   		$("#txtMuestreo").focus();
   		/*$("#ppatron").val("");
   		$("#pbascula").val(""); 
   		$("#observaciones").val("");*/
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
			if($("#ddlAreas option:selected").val() == ""){
				Swal.fire({
					text: "Debe ingresar un Area, Version u Observacion",
					type: "error",
					allowOutsideClick: false
				});
			}else if ($('#lote').val()=='' || $('#lote').val().length<=3) {
				$('#lote').focus();
		    	Swal.fire({
		    		text: "No se ha agregado un Codigo de produccion valido",
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
				datos = new Array(), i = 0;
			    mensaje = '', tipo = '',	
				table = $("#tblDatos").DataTable();
				
				table.rows().eq(0).each(function(i, index){
					let row = table.row(index);
					let data = row.data();
					datos[i] = [];
					datos[i][0] = data[0];
					datos[i][1] = data[1];
					datos[i][2] = data[2];
					datos[i][3] = data[3];
					datos[i][4] = data[4];
					datos[i][5] = data[5];
					datos[i][6] = data[6];
					datos[i][7] = data[7];
					datos[i][8] = data[8];
					datos[i][9] = data[9];
					datos[i][10] = data[10];
					i++;
				});
				console.log(datos);
				let form_data = {
				    enc: [$("#ddlAreas option:selected").val(),$("#observacionGeneral").val(),$("#lote").val(),
				    		$("#ddlprod option:selected").val(),$("#ddlprod option:selected").text()],
				    datos: JSON.stringify(datos)
				};

				$.ajax({
					url: '<?php echo base_url("index.php/guardarVEC") ?>',
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
							window.location.href = "<?php echo base_url("index.php/reporte_12")?>";
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
						url: "BajaAltaVEC",
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