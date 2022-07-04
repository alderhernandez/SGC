<?php

?>
<script type="text/javascript">
	var selected = 'Aceptar';
	$(document).ready(function(){

		$("#chkAceptar").change(function() {
		    if(this.checked) {
		        selected = $(this).val();
		    }
		});
		$("#chkRechazar").change(function() {
		    if(this.checked) {
		        selected = $(this).val();
		    }
		});
		$("#chkReclasificar").change(function() {
		    if(this.checked) {
		        selected = $(this).val();
		    }
		});
		$("#chkDesechar").change(function() {
		    if(this.checked) {
		        selected = $(this).val();
		    }
		});
		$("#chkOtras").change(function() {
		    if(this.checked) {
		        selected = $(this).val();
		    }
		});

        $('.select2').select2({
			placeholder: "Seleccione",
			allowClear: true,
			language: "es"
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


		$("#txtPeso,#diametroEsperado").numeric();
		$("#nitrito,#kg").numeric();
		$("#largo,#diametro").numeric();

		$('#fecha').datepicker({"autoclose":true});
		$("#tblCNS").DataTable();

	});

	$('#cmbTamaño').change(function() {
	    //calcularMuestra();
	});
	$('#cmdNivel').change(function() {
	    //calcularMuestra();
	});
	$('#cmdNivel2').change(function() {
	    //calcularMuestra();
	});

	$('#chkEspecial').change(function(){
		if ($('#chkEspecial').is(':checked')){
			$('.especial').removeClass('invisible');
		}else{
			$('.especial').addClass('invisible');
		}
	});


	$('#txtPeso').keyup(function(e){
	    if(e.keyCode == 13)
	    {
	        $('#btnAdd').trigger("click");
	    }
	});

	function calcularMuestra() {
		let tabla = $('#tblDatos').DataTable();
		let noRegistro = tabla.data().count();

		if (noRegistro>0) {
			Swal.fire({
				title: 'Aviso',
				text: "Se eliminaran los registros ingresados",
				type: 'warning',
				showCancelButton: false,
				allowOutsideClick: false,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Aceptar!'
			}).then((result) => {
			  	if (result.value) {
			  		$('#lote').val('');
			  		$('#batch').val('');
			  		tabla.clear().draw();
				}
			});
		}

		let ok = true;

		$('#btnAdd').prop('disabled',true);
		let tamano = null;
		let nivel = null;
		let tamano2 = null;
		let nivel2 = null;
		let bandera = null;
		bandera = $('#chkEspecial').prop("checked");

		tamano = ($("#cmbTamaño option:selected").val() != '') ? $("#cmbTamaño option:selected").val():null;
		nivel = ($("#cmdNivel option:selected").val() != '') ? $("#cmdNivel option:selected").val():null;
		nivel2 = ($("#cmdNivel2 option:selected").val() != '') ? $("#cmdNivel2 option:selected").val():null;


		if (tamano == '' || nivel == '') {
			ok = false;
		}if (bandera == false && nivel2 =='' /*&& tamano2 == ''*/) {
			ok = false;
		}
		if(ok){
			$.ajax({
				url: "<?php echo base_url("index.php/getMuestra")?>"+"/"+tamano+"/"+nivel+/*"/"+tamano2+*/"/"+nivel2+"/"+bandera,
				type: "POST",
				async: true,
					success: function (data) {
						//alert(data);
						$('#muestra').val(data);
						$('#btnAdd').prop('disabled',false)
					},
					error: function (data) {
						$("#muestra").val(Number(0).toFixed(2));
						$('#btnAdd').prop('disabled',false);
				}
			});
		}else{
			$('#muestra').val(0);
		}
	}

	$('#tblDatos tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('danger');
    });

	$("#btnDelete").click(function (){
      	let table = $("#tblDatos").DataTable();
    	let rows = table.rows( '.danger' ).remove().draw();
  	});

   $("#btnAdd").click(function(){
   		let table = $("#tblDatos").DataTable();
   		let noRegistro = parseFloat(table.rows().count());
   		console.log(noRegistro);

   		let muestra = parseFloat($('#muestra').val());

   		if (muestra == '' || muestra == 0) {
   			Swal.fire({
				title: 'Aviso',
				text: "Favor Seleccione Tamaño de Muestra",
				type: 'warning',
				showCancelButton: false,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Aceptar!'
			}).then((result) => {});
			return false;
   		}

   		if (noRegistro == muestra) {
	   		Swal.fire({
				title: 'Aviso',
				text: "Ha llenado el número de muestras total",
				type: 'warning',
				showCancelButton: false,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Aceptar!'
			}).then((result) => {});
			return;
		}


   		if ($("#muestra").val() == 0 || $("#muestra").val() == '') {
   			Swal.fire({
   				text: "No existe Tamaño de muestra",
   				type: "warning",
   				allowOutsideClick: false
   			});
   		}

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
				[0, "desc"]
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
   		fecha = $("#fecha").val(),
   		hora = $("#hora").val(),
   		codigo = $("#codigo").val(),
   		observacion = $("#observacionGeneral").val(),
   		codproducto = $("#ddlprod option:selected").val(),
   		descripcion = $("#ddlprod option:selected").text(),
   		gramos = $("#diametroEsperado").val(),
   		monituser = $("#monituser").val(),
		peso = $('#txtPeso').val();

   		if(fecha == "" || peso == "" || hora == "" || codigo == "" || monituser == "" || area == "" || gramos == ''){
   			Swal.fire({
   				text: "Todos los campos son requeridos,Excepto Observación",
   				type: "warning",
   				allowOutsideClick: false
   			});
   			return;
   		}else if(peso<1){
   			Swal.fire({
   				text: "Ingrese un peso valido",
   				type: "warning",
   				allowOutsideClick: false
   			});
   			return;
   		}else{

   			let diferencia = parseFloat(peso) - parseFloat(gramos);
   			t.row.add([
   				t.rows().count()+1,
				codproducto,
				descripcion,
				gramos,
				peso,
				diferencia
   			]).draw(false);

	   		$("#txtPeso").val("");
	   		$("#txtPeso").focus();
   		}
   });


$("#btnGuardar").click(function(){

	Swal.fire({
		text: "¿Esta Seguro que Desea Guardar?",
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

		let noRegistro = parseFloat(validtable.rows().count());
   		let muestra = parseFloat($('#muestra').val());

   			if (noRegistro<muestra) {
   				Swal.fire({
					text: "Debe ingresar el numero de muestras indicadas",
					type: "error",
					allowOutsideClick: false
				});
   			}else if( $("#ddlAreas option:selected").val() == "" ) {
				Swal.fire({
					text: "Debe ingresar un Area",
					type: "error",
					allowOutsideClick: false
				});
			}else if ( $('#fecha').val() == '' ) {
		    	Swal.fire({
		    		text: "Ingrese una Fecha",
		    		type: "error",
		    		allowOutsideClick: false
		    	});
			}else if ( $("#ddlprod option:selected").val() == "") {
		    	Swal.fire({
		    		text: "Seleccione un Producto",
		    		type: "error",
		    		allowOutsideClick: false
		    	});
			}else if ( $('#lote').val() == '' ) {
		    	Swal.fire({
		    		text: "Ingrese un lote",
		    		type: "error",
		    		allowOutsideClick: false
		    	});
			}else if ( $('#batch').val()  == '') {
		    	Swal.fire({
		    		text: "Ingrese un Batch",
		    		type: "error",
		    		allowOutsideClick: false
		    	});
			}else if ( $('#muestra').val() == '' ) {
		    	Swal.fire({
		    		text: "Ingrese un nivel de Inspreccion para la muestra",
		    		type: "error",
		    		allowOutsideClick: false
		    	});
			}else if (validtable.data().count() == 0 ) {
		    	Swal.fire({
		    		text: "No se ha agregado ningún registro a la tabla",
		    		type: "error",
		    		allowOutsideClick: false
		    	});
			}else if ( $("#ddlMaquina option:selected").val() == "") {
		    	Swal.fire({
		    		text: "Seleccione una maquina",
		    		type: "error",
		    		allowOutsideClick: false
		    	});
			}else{
				$("#loading").modal("show");
			    let nombre = $("#nombreRpt").html();
			    let datos = new Array(), i = 0;
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
					i++;
				});


				let form_data = {
				    enc: [$("#ddlAreas option:selected").val(),$('#observacionGeneral').val(),$('#fecha').val(),$("#ddlprod option:selected").val(),$("#ddlprod option:selected").text(),$('#diametroEsperado').val(),nombre,$("#lote").val(),$("#batch").val(),
				    	$("#cmbTamaño option:selected").val(),$("#cmdNivel option:selected").val(),$('#chkEspecial').prop('checked'),
				    	$("#cmdNivel2 option:selected").val(),$('#muestra').val(),selected,$('#largo').val(),$('#diametro').val(),
				    	$("#ddlMaquina option:selected").val()
				    ],
				    datos: JSON.stringify(datos)//datos
				};

				$.ajax({
					url: '<?php echo base_url("index.php/guardarCPP2")?>',
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
							if (tipo == 'success') {
								window.location.href = "reporte_16";
							}
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
						url: "BajaAltaCPP",
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
