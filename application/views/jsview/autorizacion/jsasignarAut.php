<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-07 10:28:13
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-07 16:14:00
 */
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').select2({
			placeholder: "Seleccione un usuario",
			allowClear: true,
			language: "es"
		});

		$('#treeCheckbox').jstree({
			'core' : {
				'themes' : {
					'responsive': true
				}
			},
			'types' : {
				'default' : {
					'icon' : 'fa fa-folder'
				},
				'file' : {
					'icon' : 'fa fa-folder'
				}
			},
			'plugins': ['types', 'checkbox']
		});
	});

$("#btnSetAuth").on('click', function(){
	let ddlUser = $("#ddlUsuarios option:selected").val();
	if(ddlUser != ""){
	     let i = 0,
		 array = new Array(),
		 mensaje = '',
		 tipo = '';
		$("#treeCheckbox li .jstree-leaf").each(function(){
			if ($(this).children().hasClass("jstree-clicked")) {
				array[i] = ddlUser+","+$(this).attr('id');
			 	i++;
			}
		});

		let form_data = {
			datos: array
		};

		$.ajax({
		url: "asignarPermiso",
		type: "POST",
		data: form_data,
		success: function(data){
			let obj = jQuery.parseJSON(data);
			$.each(obj, function(index, val) {
				mensaje = val["mensaje"];
				tipo = val["tipo"];
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

	}else{
		Swal.fire({
			text: "Debe seleccionar un usuario",
			type: "error",
			allowOutsideClick: false
		});
	}
	
});	

$("#ddlUsuarios").on("change", function(){
	$("#treeCheckbox").jstree("refresh");
	if ($("#ddlUsuarios option:selected").val() != '') {
		$.ajax({
		url: "getAuthAsig/" + $(this).val(),
		type: "GET",
		dataType: "json",
		contentType: false,
		processData:false,
		success: function(datos){
		   $.each(datos, function(key, value){
			  $("#"+value.IDAUTORIZACION).find(".jstree-anchor").addClass("jstree-clicked");
		  });
		}
	});
  }
});

</script>