<?php

?>
<script type="text/javascript">
	var selected = 'Aceptar';
	var show = true;

	 $('#exampleCheck1').change(function() {
        if($(this).is(":checked")) {
        	//alert("checked")
            $('#ocultar').show()
        }else{
        	//alert("no checked")
        	$('#ocultar').hide()
        }        
    });

	$(document).ready(function(){

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
				

		$("#txtPeso").numeric();
		$("#nitrito,#kg").numeric();
		$("#largo,#diametro").numeric();

		$('#fecha').datepicker({"autoclose":true});
		$("#tblCNS").DataTable();	



		$('#btnFiltrar').click(function(){
			let tipo = $("#tipoReporte option:selected").val();
			let url2 ='';

			
			if (tipo == 1) {
				let table = $("#tabla").DataTable({
	            "ajax": {
	                "url": "<?php echo base_url("index.php/generarReportePesoDiametro")?>",
	                "type": "POST",
	                "data": {
	                	"lote" :  $('#idlote').val(),
	                	"codigo": $('#codigo').val()                	
	                }
	            },		
	            "orderMulti": false,
	            "info": false,
	            "sort": true,
	            "destroy": true,
	            "responsive": true,
	            "searching": false,
	            "paging": false,
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
	                "search": 'Buscar:',
	                "loadingRecords": "",
	                "processing": "Procesando datos...",
	                "paginate": {
	                    "first": "Primera",
	                    "last": "Última ",
	                    "next": "Siguiente",
	                    "previous": "Anterior"
	                }
	            },
	            "columns": [
	                {"data": "CODIGOPRODUCTO"},
					{"data": "NOMBREPRODUCTO"},
					{"data": "LOTE"},
					{"data": "DIAMETRO_UTILIZADO"},
					{"data": "DIAMETRO_ESPERADO"},
					{"data": "FUNDADIAMETRO"},
					{"data": "FUNDALARGO"},
					{"data": "PESO_ESPERADO"},
					{"data": "PESO_PROMEDIO"},
					{"data": "VARIABILIDAD_3"},
					{"data": "MAQUINA"},
					{"data": "TAMANO_MUESTRA"},
					{"data": "PESOEXACTO"},
					{"data": "DEBAJO_LIMITE"},
					{"data": "ENCIMA_LIMITE"},
					{"data": "EN_RANGO"}				
	            ]           
	        	}); 

	        	let table2 = $("#tablaPesos").DataTable({
	            "ajax": {
	                "url": "<?php echo base_url("index.php/generarReporteDetallePeso")?>",
	                "type": "POST",
	                "data": {
	                	"lote" :  $('#idlote').val(),
	                	"codigo": $('#codigo').val()                	
	                }
	            },		
	            "orderMulti": false,
	            "info": false,
	            "sort": true,
	            "destroy": true,
	            "responsive": true,
	            "searching": false,
	            "paging": false,
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
	                "search": 'Buscar:',
	                "loadingRecords": "",
	                "processing": "Procesando datos...",
	                "paginate": {
	                    "first": "Primera",
	                    "last": "Última ",
	                    "next": "Siguiente",
	                    "previous": "Anterior"
	                }
	            },
	            "columns": [
	                {"data": "CODIGO"},
					{"data": "DESCRIPCION"},
					{"data": "PESOBASCULA"},
					{"data": "DIFERENCIA"}					
	            ]           
	        	});
			}


        	var ctx = document.getElementById("canvas");

		var lineSuperDraw = Chart.controllers.line.prototype.draw;
		Chart.helpers.extend(Chart.controllers.line.prototype, {
			  draw : function() {
			    var chart = this.chart;
			    var ctx = chart.chart.ctx;

			    var yRangeBegin = chart.config.data.yRangeBegin;
			    var yRangeEnd = chart.config.data.yRangeEnd;

			    var xaxis = chart.scales['x-axis-0'];
			    var yaxis = chart.scales['y-axis-0'];

			    var yRangeBeginPixel = yaxis.getPixelForValue(yRangeBegin);
			    var yRangeEndPixel = yaxis.getPixelForValue(yRangeEnd);

			    ctx.save();

			    for (var yPixel = Math.min(yRangeBeginPixel, yRangeEndPixel); yPixel <= Math.max(yRangeBeginPixel, yRangeEndPixel); ++yPixel) {
			      ctx.beginPath();
			      ctx.moveTo(xaxis.left, yPixel);
			      ctx.strokeStyle = '#52b325';
			      ctx.lineTo(xaxis.right, yPixel);
			      ctx.stroke();
			    }
			      
			    ctx.restore();

			    lineSuperDraw.apply(this, arguments);
			  }
		});

		$.ajax({
		        url: <?php echo "'".base_url('index.php/GraficaPeso')."'"?>,
		        type: 'post',
		        dataType: 'json',
		        data: {
		        	"lote" :  $('#idlote').val(),
                	"codigo": $('#codigo').val(),
                	"tipo": tipo
		        },
		        success: function (msg) {
		        nombre='peso';
		        peso = 0;
		        codigo = '';
				paramNombres = [];
				paramDatos = [];
				bgColor = [];
				bgBorder = [];
				for (var i=0; i<=6; i++) {
							//console.log(i);
							var r = Math.random() * 255;
							r = Math.round(r);

							var g = Math.random() * 255;
							g = Math.round(g);

							var b = Math.random() * 255;
							b = Math.round(b);
							bgColor.push('rgba(255,0,0, 0.8)');
							bgBorder.push('rgba(255,0,0, 0.8)');
						}
				$.each(msg, function(i,item){						
					//paramNombres.push(item["NOMBREVENDEDOR"]);

					peso = parseFloat(item["PESOGRAMOS"]);					
					codigo = item["DESCRIPCION"]
					paramDatos.push(parseFloat(item["PESOBASCULA"]));
					bgColor.push('rgba('+r+','+g+','+b+', 0.8)');
					bgBorder.push('rgba('+r+','+g+','+b+', 1)');
				});
				let arriba = 0, abajo = 0;
				if (tipo == 1) {
					arriba =  peso+(peso*0.03);
					abajo = peso+((peso*0.03)*-1);
				}else{
					arriba = peso+0.2;
					abajo = peso+(-0.2)
				}
				    var myChart = new Chart(ctx, {
					    type: 'line',
					    label:'prueba',
					    data: {
					        labels: paramDatos,//['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'],
					        datasets: [{
					            label: codigo,
					            data: paramDatos,
					            backgroundColor: 'rgba(255,0,0,0.0)'					            
					        }],
						    yRangeBegin : arriba,//peso+(peso*0.03),
						    yRangeEnd : abajo,//peso+((peso*0.03)*-1),
						    borderColor: 'rgba(0, 100, 200, 0.2)',
					    },
					    options: {
					    	elements: {
								line: {
									tension: 0.000001,
									borderColor: bgBorder
								}
							},
					        scales: {
					            yAxes: [{
					                ticks: {
					                    beginAtZero:true
					                }
					            }]
					        }
					    }
					});
		        }
		    });	


		/*******graficas de pie*/////////////
			var ctxAceptables = document.getElementById("canvasAceptables");
			$.ajax({
		        url: <?php echo "'".base_url('index.php/GraficaPesoAceptables')."'"?>,
		        type: 'post',
		        dataType: 'json',
		        data: {
		        	"lote" :  $('#idlote').val(),
                	"codigo": $('#codigo').val(),
                	"tipo": tipo
		        },
		        success: function (msg) {
		        nombre='peso';
		        peso = 0;
		        codigo = '';
				paramNombres = [];
				paramDatos = [];
				let aceptables = 0;

				$.each(msg, function(i,item){
					peso = parseFloat(item["PESOGRAMOS"]);
					codigo = 'Productos Aceptables';
					paramDatos.push(parseFloat(item["PORCENTAJE"]));
					aceptables = parseFloat(item["PORCENTAJE"]);
				});
				paramDatos.push(100-aceptables);
				    var myChart = new Chart(ctxAceptables, {
					    type: 'pie',
					    label:'Pesos',
					    data: {
					        labels: ['Productos Aceptables '+(aceptables).toString()+'%',['Otros '+(100-aceptables).toString()+'%']],//['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'],
					        datasets: [{
					            label: codigo,
					            data: paramDatos,
					            backgroundColor: [
						        'rgba(51, 204, 51, 1)',
						        'rgba(54, 162, 235, 0.2)'
						      ],
						      borderColor: [
						        'rgba(61,99,56,1)',
						        'rgba(54, 162, 235, 1)'
						        
						      ],
						      borderWidth: 1
					        }]
					    },
					    options: {
						   	cutoutPercentage: 40,
						    responsive: false,

						  }
					});
		        }
		    });	

		    /*******grafica pie por debajo de rango********/
		    var ctcDebajo = document.getElementById("canvasDebajo");
			$.ajax({
		        url: <?php echo "'".base_url('index.php/GraficaPesoDebajo')."'"?>,
		        type: 'post',
		        dataType: 'json',
		        data: {
		        	"lote" :  $('#idlote').val(),
                	"codigo": $('#codigo').val(),
                	"tipo": tipo
		        },
		        success: function (msg) {
		        nombre='peso';
		        peso = 0;
		        codigo = '';
				paramNombres = [];
				paramDatos = [];
				let aceptables = 0;

				$.each(msg, function(i,item){
					peso = parseFloat(item["PESOGRAMOS"]);
					codigo = 'Productos Aceptables';
					paramDatos.push(parseFloat(item["PORCENTAJE"]));
					aceptables = parseFloat(item["PORCENTAJE"]);
				});
				paramDatos.push(100-aceptables);
				    var myChart = new Chart(ctcDebajo, {
					    type: 'pie',
					    label:'Pesos',
					    data: {
					        labels: ['Por Debajo del Rango '+(aceptables).toString()+'%',['Otros'+(100-aceptables).toString()+'%']],//['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'],
					        datasets: [{
					            label: codigo,
					            data: paramDatos,
					            backgroundColor: [
						        'rgba(255, 0, 0, 1)',
						        'rgba(54, 162, 235, 0.2)'
						      ],
						      borderColor: [
						        'rgba(61,99,56,1)',
						        'rgba(54, 162, 235, 1)'
						        
						      ],
						      borderWidth: 1
					        }]
					    },
					    options: {
						   	cutoutPercentage: 40,
						    responsive: false,

						  }
					});
		        }
		    });	

		    /*******grafica pie por debajo de rango********/
		    var ctxArriba = document.getElementById("canvasEncima");
			$.ajax({
		        url: <?php echo "'".base_url('index.php/GraficaPesoArriba')."'"?>,
		        type: 'post',
		        dataType: 'json',
		        data: {
		        	"lote" :  $('#idlote').val(),
                	"codigo": $('#codigo').val(),
                	"tipo": tipo
		        },
		        success: function (msg) {
		        nombre='peso';
		        peso = 0;
		        codigo = '';
				paramNombres = [];
				paramDatos = [];
				let aceptables = 0;

				$.each(msg, function(i,item){
					peso = parseFloat(item["PESOGRAMOS"]);
					codigo = 'Productos Aceptables';
					paramDatos.push(parseFloat(item["PORCENTAJE"]));
					aceptables = parseFloat(item["PORCENTAJE"]);
				});
				paramDatos.push(100-aceptables);
				    var myChart = new Chart(ctxArriba, {
					    type: 'pie',
					    label:'Pesos',
					    data: {
					        labels: ['Por Encima del Rango '+(aceptables).toString()+'%',['Otros'+(100-aceptables).toString()+'%']],//['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'],
					        datasets: [{
					            label: codigo,
					            data: paramDatos,
					            backgroundColor: [
						        'rgba(255, 0, 0, 1)',
						        'rgba(54, 162, 235, 0.2)'
						      ],
						      borderColor: [
						        'rgba(61,99,56,1)',
						        'rgba(54, 162, 235, 1)'
						        
						      ],
						      borderWidth: 1
					        }]
					    },
					    options: {
						   	cutoutPercentage: 40,
						    responsive: false,

						  }
					});
		        }
		    });	


		});				
	});

function print(obj){
    InformeContainer.innerHTML = "";
    var containers = obj.querySelectorAll("div[name=CMKPI]");
    alert(containers.length)
    var Page = 0;   
   
    for (let index = 0; index < containers.length; index++) {
        const element = containers[index];        
        
        if (element.style.display != "none") {
            //multipage
            var PrintDiv = document.createElement('div');
            PrintDiv.style = "padding:20px";
            PrintDiv.className = "page big";
            //multipage
            PrintDiv.append(CreateStringNode(`<div style="height: 50px"> <h5 style="text-aling:center">Titulo</h5></div>`))
            var elementDatos = element.querySelector(".GroupFormDatos");
            var tableDatos = elementDatos.querySelector("table").cloneNode(true); 
            tableDatos.style.height = "400px";   
            tableDatos.style.background = "#fff";
            tableDatos.style.width = "1400px !important"

            var canvas = elementDatos.querySelector("canvas").cloneNode(true); 
            canvas.style.height = "400px";   
            canvas.style.background = "#fff";
            canvas.style.width = "1400px !important"
            //var Charts = elementDatos.querySelectorAll(".WChartContainer");
            PrintDiv.setAttribute("name", "PrintPage");
            PrintDiv.appendChild(tableDatos);
            PrintDiv.appendChild(canvas);
            /*for (let i = 0; i < Charts.length; i++) {
                PrintDiv.appendChild(Charts[i].cloneNode(true))
            }*/
            Page++;
            PrintDiv.append(CreateStringNode(`<p style="height: 50px">Página:${Page}</p>`))      
            InformeContainer.append(PrintDiv);  
           // PrintDiv.style.display = "none";
        }
        
    }

    $('#modalPrint').modal('show');//modalFunction('modalPrint');
}

function test() {
        // Get the element.
        var element = document.getElementById('InformeContainer');

        // Choose pagebreak options based on mode.
        var mode = document.getElementById('mode').value;
        var pagebreak = (mode === 'specify') ?
            { mode: '', before: '.before', after: '.after', avoid: '.avoid' } :
            { mode: mode };

        // Generate the PDF.
        html2pdf().from(element).set({
          filename: "Informe" + '.pdf',
          pagebreak: pagebreak,
          jsPDF: {orientation: 'landscape', unit: 'in', format: [19,10.9], compressPDF: true}
        }).save();
      }
function CreateStringNode(string) {
    let node = document.createRange().createContextualFragment(string);
    return node;
}

function printImagen() {
	var w = document.getElementById("exportar").offsetWidth;
	var h = document.getElementById("exportar").offsetHeight;
	//alert(w+' '+h)
	html2canvas(document.getElementById("exportar"), {
	    dpi: 300, // Set to 300 DPI
	    scale: 3, // Adjusts your resolution
	    onrendered: function(canvas) {
	    	var img = canvas.toDataURL("image/jpeg", 1);
	    	var doc = new jsPDF('L', 'px', [2000, 2000]);
	    	doc.addImage(img, 'JPEG', 0, 0, 2000, 2000);
	    	doc.save('sample-file.pdf');
	    }
	});
}
</script>