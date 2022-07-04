<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-23 10:23:40
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-28 17:12:58
 */
?>
<script type="text/javascript">
	$(document).ready(function(){
	    $("#tblVeced").DataTable();
		let counter = 1;
		$('#fecha').datepicker({"autoclose":true});
		$("#version,#estibas,#pesolbs,#temperatura").numeric();

		$("#btnAdd").click(function(){
		let producto = $("#ddlprod option:selected").val();
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
   		let Area = $("#Area").val(),
		 version = $("#version").val(),
		 fecha = $("#fecha").val(),
		 produccion = $("#produccion").val(),
		 estibas = $("#estibas").val(),
		 monituser = $("#monituser").val(),
		 pesolbs = $("#pesolbs").val(),
		 temperatura = $("#temperatura").val(),
		 observaciones = $("#observaciones").val(),
		 acciones = $("#acciones").val();

   		if(fecha == "" || version == "" || produccion == "" ||  producto == "" || pesolbs == '' || temperatura == ''){
   			Swal.fire({
   				text: "Todos los campos son requeridos",
   				type: "warning",
   				allowOutsideClick: false
   			});
   		}else if (!t.data().count()){
	   			counter = 1;
	   			t.row.add([
					counter,
					pesolbs,
					temperatura,
					observaciones,
					acciones	   			
	   			]).draw(false);
			/*$("#estibas").val("");
			$("#monituser").val("");
			$("#pesolbs").val("");
			$("#temperatura").val("");
			$("#observaciones").val("");
			$("#acciones").val("");*/
   		}else{
   			t.row.add([
				counter,
				pesolbs,
				temperatura,
				observaciones,
				acciones	   			
   			]).draw(false);
			$("#monituser").val("");
			$("#pesolbs").val("");
			//$("#temperatura").val("");
			//$("#observaciones").val("");
			//$("#acciones").val("");
			//$("#ddlprod").val("").trigger("change");
   		}
			counter++;
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
						/*$("#campo").append('<input type="hidden" name="" id="'+data[i].ItemCode+'txtpeso" class="form-control" value="'+data[i].SWeight1+'">');*/
					}
					return {
						results: res
					}
				},
				cache: true
			}
		}).trigger('change');
});

    $('#tblcrear tbody').on( 'click', 'tr', function () {
          $(this).toggleClass('danger');
      });

	$("#btnDelete").click(function (){
      let table = $("#tblcrear").DataTable();
      let rows = table.rows( '.danger' ).remove().draw();
  });	

	$("#btnGuardar").click(function(){
		let codproducto = $("#ddlprod option:selected").val(),producto = $("#ddlprod option:selected").text(), nombre = $("#nombreRpt").html();
		   		let Area = $("#Area").val(), version = $("#version").val(), fecha = $("#fecha").val(),produccion = $("#produccion").val(),
				 estibas = $("#estibas").val(),monituser = $("#monituser").val(), pesolbs = $("#pesolbs").val(), temperatura = $("#temperatura").val(),
				 observaciones = $("#observaciones").val(), acciones = $("#acciones").val();
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
			if(fecha == "" || version == "" || produccion == "" ||  codproducto == ""){
				Swal.fire({
					text: "Todos los campos son requeridos",
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
			   let mensaje = '', tipo = '',
				table = $("#tblcrear").DataTable();
				let datos = new Array(), i = 0;
				
				table.rows().eq(0).each(function(i, index){
					let row = table.row(index);
					let data = row.data();
					datos[i] = fecha+","+codproducto+","+producto+","+data[1]+","+data[2]+","+data[3]+","+data[4];
					i++;
				});

				let form_data = {
				    enc: [$("#idmonitoreo").val(),Area,version,nombre,estibas,produccion],
				    datos: datos	
				};

				$.ajax({
					url: 'guardarVeced',
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
							window.location.href = "reporte_8";  
						});				
					}
				});
			}
		}
	});
});


    function mostrarDetalles(callback,id,div)
    {
        $.ajax({
            url: "mostrarVecedAjax/"+id,
            async: true,
            success: function(response){
                let thead = '',tbody='', cont = 0;
                if(response != "false"){
                    let obj = $.parseJSON(response);
                    let temp = obj.length;
                    let cantRows = 0;
                    thead += "<th class='text-center bg-primary'>N°</th>";
                    thead += "<th class='text-center bg-primary'>Peso Libras</th>";
                    thead += "<th class='text-center bg-primary'>T° Interna del Prod</th>";
                    thead += "<th class='text-center bg-primary'>Observaciones</th>";
                    thead += "<th class='text-center bg-primary'>Acciones Correctivas</th></tr>";
                    $.each(JSON.parse(response), function(i, item){
                        tbody += "<tr>"+
                            "<td class='text-center bg-info'>"+item["NUMERO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["PESOLIBRAS"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["TINTERNAPRODUCTO"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["OBSERVACIONESACCION"]+"</td>"+
                            "<td class='text-center bg-info'>"+item["ACCIONESCORRECTIVAS"]+"</td>";
                    });
                    callback($("<table id='detCNS' class='table table-bordered table-condensed table-striped'>"+ thead + tbody + "</table>")).show();
                }else {
                    thead += "<th class='text-center bg-primary'>Numero</th>";
                    thead += "<th class='text-center bg-primary'>Peso Libras</th>";
                    thead += "<th class='text-center bg-primary'>T° Interna del Prod</th>";
                    thead += "<th class='text-center bg-primary'>Observaciones</th>";
                    thead += "<th class='text-center bg-primary'>AAcciones Correctivas</th></tr>";
                    tbody += '<tr >' +
                        "<td></td>"+
                        "<td></td>"+
                        "<td>No hay datos disponibles</td>"+
                        "<td></td>"+
                        "<td></td>"+
                        '</tr>';
                    callback($('<table id="detVeced" class="table table-bordered table-condensed table-striped">' + thead + tbody + '</table>')).show();
                }
            }
        });
    }

    $("#tblVeced").on("click","tbody .detalles", function () {
        let table = $("#tblVeced").DataTable();
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

    function BajaAltaVeced(id, estado)
    {
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
        }).then((result) => {
            if(result.value){
                let mensaje = '', tipo = '';
                let form_data = {
                    id:  id,
                    estado: estado
                };
                $.ajax({
                    url: "BajaAltaVeced",
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
        })
    }
</script>
