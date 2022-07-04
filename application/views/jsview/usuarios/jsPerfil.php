<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 14/5/2019 09:26 2019
 * FileName: jsPerfil.php
 */
?>
<script type="text/javascript">
	$(document).ready(function () {

	});

	$("#btnActualizarInfo").click( function () {
		let genero = 0; let mensaje = '', tipo = '';
		if($("#M").prop("checked") == true){
			genero = 1;
		}
		if($("#F").prop("checked") == true){
            genero = 2;
		}
		let form_data = {
			IdUser: $("#IdUser").val(),
			nombre: $("#nombre").val(),
			apellido: $("#apellido").val(),
			correo: $("#correo").val(),
			username: $("#username").val(),
			sexo: genero
		};
		$.ajax({
			url: "actualizarDatPerfil",
			type: "POST",
			data: form_data,
			success: function (data) {
				let obj = jQuery.parseJSON(data);
				$.each(obj, function (i, index) {
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

	});

    $("#btnUpdPass").click(function () {
		$(".confirmPass").removeClass("has-error");
		$(".newPass").removeClass("has-error");

		if($("#currentPass").val() == '' || $("#newPass").val() == '' || $("#confirmPass").val() == ''){
			Swal.fire({
				text: "Todos los campos son requeridos",
				type: "error",
				allowOutsideClick: false
			});
		}else if($("#confirmPass").val() != $("#newPass").val()){
			Swal.fire({
				text: "Las contraseñas no coinciden",
				type: "warning",
				allowOutsideClick: false
			}).then((result)=>{
				$(".confirmPass").addClass("has-error");
				$(".newPass").addClass("has-error");
			});
		}else{
			let mensaje ='', tipo ='';
			let form_data = {
				idUser: $("#IdUser").val(),
			    password: $("#currentPass").val(),
				newPassword: $("#newPass").val()
			};
			$.ajax({
				url: "actualizarPassword",
				type: "POST",
				data: form_data,
				success: function (data) {
					let obj = jQuery.parseJSON(data);
					$.each(obj, function (i, index) {
						mensaje = index["mensaje"];
						tipo = index["tipo"];
					});
					Swal.fire({
						type: tipo,
						text: mensaje,
						allowOutsideClick: false
					}).then((result)=> {
						location.reload();
					});
				}
			});
		}
	});
</script>
