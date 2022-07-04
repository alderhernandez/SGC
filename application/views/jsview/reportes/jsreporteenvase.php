<?php

?>
<script type="text/javascript">
	var selected = 'Aceptar';
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
			let url2 ='';



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
		        url: <?php echo "'".base_url('index.php/GraficaEnvase')."'"?>,
		        type: 'post',
		        dataType: 'json',
		        data: {
		        	"lote" :  $('#idlote').val(),
                	"codigo": $('#codigo').val(),
                	"maquina": $('#ddlcabezal').val()
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

					peso = parseFloat(item["FECHACREA"]);					
					codigo = item["NOMBRE"]
					paramDatos.push(parseFloat(item["CANTIDAD"]));
					bgColor.push('rgba('+r+','+g+','+b+', 0.8)');
					bgBorder.push('rgba('+r+','+g+','+b+', 1)');
				});
				let arriba = 1.30, abajo = 1.03;
				/*if (tipo == 1) {
					arriba =  peso+(peso*0.03);
					abajo = peso+((peso*0.03)*-1);
				}else{
					arriba = peso+0.2;
					abajo = peso+(-0.2)
				}*/
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
			/*var ctxAceptables = document.getElementById("canvasAceptables");
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
		    });	*/

		    /*******grafica pie por debajo de rango********/
		    /*var ctcDebajo = document.getElementById("canvasDebajo");
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
		    });	*/

		    /*******grafica pie por debajo de rango********/
		    /*var ctxArriba = document.getElementById("canvasEncima");
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
		    });	*/


		});				
	});

	
</script>