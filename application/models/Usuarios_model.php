<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 23/4/2019 09:09 2019
 * FileName: Usuarios_model.php
 */
class Usuarios_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function iniciarSesion($name,$pass){
		if($name != false && $pass != false){
			$query = $this->db->query("
				SELECT T1.*,T2.NOMBRE_ROL,T2.IDROL
  				FROM Usuarios T1
				inner join Roles T2 on T1.IDROL = T2.IDROL 
				where T1.NOMBREUSUARIO = '".$name."' and T1.PASSWORD = '".$pass."'
				and T1.ESTADO = '1' 
			");
			if($query->num_rows() == 1){
				return $query->result_array();
			}
			return 0;
		}
	}

	//region FUNCIONES PARA MODULO ROLES
	public function guardarRol($rol, $desc){
		$mensaje = array();
		$id = $this->db->query("SELECT ISNULL(MAX(IDROL),0)+1 AS IDROL FROM Roles");
		$datos = array(
			"IDROL" => $id->result_array()[0]["IDROL"],
			"NOMBRE_ROL" => $rol,
			"DESCRIPCION" => $desc,
			"FECHACREA" => gmdate(date("Y-m-d H:i:s")),
			"ESTADO" => 1
		);
		$guardar = $this->db->insert("Roles",$datos);
		if($guardar){
			$mensaje[0]["mensaje"] = "Datos guardados correctamente";
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "Error al guardar los datos. Ocurrio un error inesperado 
			en el servidor, contáctece con el administrador";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}

	public function mostrarRoles(){
		$query = $this->db->get("Roles");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}

	public function actualizarRol($idrol,$rol, $desc){
		$mensaje = array();
		$this->db->where("IDROL",$idrol);
		$datos = array(
			"NOMBRE_ROL" => $rol,
			"DESCRIPCION" => $desc,
			"FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
		);
		$actualizar = $this->db->update("Roles",$datos);
		if($actualizar){
			$mensaje[0]["mensaje"] = "Datos actualizados correctamente";
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "Error al actualizar los datos. Ocurrio un error inesperado 
			en el servidor, contáctece con el administrador";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}

	public function modificarEstadoRol($idrol, $estado, $fechabaja){
		$this->db->where("IDROL",$idrol);
		$data = array(
			"ESTADO" => $estado,
			"FECHABAJA" => $fechabaja
		);
		$this->db->update("Roles", $data);
	}
	//endregion

	public function guardarUsuario($idrol, $usuario, $nombre, $apellido, $sexo, $password, $correo){
		$mensaje = array();
		$query = $this->db->query("SELECT ISNULL(MAX(IDUSUARIO),0)+1 AS IDUSUARIO FROM Usuarios");
		$data = array(
			 "IDUSUARIO" => $query->result_array()[0]["IDUSUARIO"],
			 "IDROL" => $idrol,
			 "NOMBREUSUARIO" => $usuario,
			 "NOMBRES" => $nombre,
			 "APELLIDOS" => $apellido,
			 "SEXO" => $sexo,
			 "PASSWORD" => md5($password),
			 "CORREO" => $correo,
			 "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
			 "ESTADO" => 1
		);
		$save = $this->db->insert("Usuarios",$data);
		if($save){
			$mensaje[0]["mensaje"] = "Usuario registrado con éxito";
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "No se pudo guardar el usuario. Ocurrió un error inesperado en el servidor, contáctece con 
			el administrador";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}

	public function mostrarUsuarios(){
		$query = $this->db->query("SELECT T1.*,T2.NOMBRE_ROL
  									FROM Usuarios T1
									inner join Roles T2 on T1.IDROL = T2.IDROL ");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}

	public function actualizarUsuario($idUsuario,$idrol, $usuario, $nombre, $apellido, $sexo, $correo){
		$mensaje = array();
		$this->db->where("IDUSUARIO",$idUsuario);
		$data = array(
			"IDROL" => $idrol,
			"NOMBREUSUARIO" => $usuario,
			"NOMBRES" => $nombre,
			"APELLIDOS" => $apellido,
			"SEXO" => $sexo,
			"CORREO" => $correo,
			"FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
		);
		$upd = $this->db->update("Usuarios",$data);
		if($upd){
			$mensaje[0]["mensaje"] = "Usuario actualizado con éxito";
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "No se pudo actualizar el usuario. Ocurrió un error inesperado en el servidor, contáctece con 
			el administrador";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}

	public function modificarEstadoUsuario($idUser, $estado, $fechabaja){
		$this->db->where("IDUSUARIO",$idUser);
		$data = array(
			"ESTADO" => $estado,
			"FECHABAJA" => $fechabaja
		);
		$this->db->update("Usuarios", $data);
	}

	//region Funciones para modulo Perfil
	public function mostrarUsuariosPerfil(){
		$query = $this->db->query("SELECT T1.*,T2.NOMBRE_ROL
  									FROM Usuarios T1
									inner join Roles T2 on T1.IDROL = T2.IDROL
									where T1.IDUSUARIO = '".$this->session->userdata("id")."' ");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}

	public function actualizarPassword($idUser, $password, $newPassword){
		$mensaje = array();
		$query = $this->db->select("PASSWORD")
			->where("IDUSUARIO", $idUser)
			->where("PASSWORD", md5($password))
			->get("Usuarios");
		if($query->num_rows() > 0){
			$this->db->where("IDUSUARIO", $idUser);
			$data = array(
				"PASSWORD" => md5($newPassword)
			);
			$this->db->update("Usuarios",$data);
			$mensaje[0]["mensaje"] = "La contraseña se actualizó con éxito, cierre e inicie sesión de nuevo";
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "La contraseña que intentas cambiar es errónea o no existe.
			                          Si el problema persiste contáctece con el administrador";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}

	public function actualizarDatPerfil($IdUser, $nombre, $apellido, $correo, $username, $sexo){
		$mensaje = array();
		$this->db->where("IDUSUARIO", $IdUser);
		$data = array(
			"NOMBRES" => $nombre,
			"APELLIDOS" => $apellido,
			"CORREO" => $correo,
			"NOMBREUSUARIO" => $username,
			"SEXO" => $sexo
		);
		$upd = $this->db->update("Usuarios",$data);
		if($upd){
			$mensaje[0]["mensaje"] = "Datos actualizados correctamente";
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "Error al actualizar los datos del usuario, si el problema persiste
										contáctece con el administrador";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}
	//endregion

}
