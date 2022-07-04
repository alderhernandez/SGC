<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-05 14:11:57
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-07 15:50:05
 */
class Autorizaciones_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

/****************************Categorias Autorizaciones******************************************/
	public function mostrarCategorias(){
		$query = $this->db->get("AutorizacionesCategoria");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0; 
	}

	public function evitarDuplicados($descripcion){
		$query = $this->db->query("SELECT DESCRIPCION FROM AutorizacionesCategoria
  								   where ESTADO = 'A' and (DESCRIPCION like '%".$descripcion."%')");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	} 

	public function guardarAutCategoria($descripcion)
	{
		$this->db->trans_begin();
		date_default_timezone_set("America/Managua");
		$validacion = $this->evitarDuplicados($descripcion);
		if(!$validacion){
			$mensaje = array();
			$id = $this->db->query("SELECT ISNULL(MAX(ID),0)+1 AS ID FROM AutorizacionesCategoria");
			$data = array(
				"ID" => $id->result_array()[0]["ID"],
				"DESCRIPCION" => $descripcion,
				"ESTADO" => "A",
				"FECHACREA" => gmdate(date("Y-m-d H:i:s")),
				"USUARIOCREA" => $this->session->userdata("id")
			);

			$guardar = $this->db->insert("AutorizacionesCategoria",$data);

			if($guardar){
				$mensaje[0]["mensaje"] = "Datos almacenados con éxito.";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Fallo al almacenar los datos.
				Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		}else{
			$mensaje[0]["mensaje"] = "Fallo al almacenar los datos.
				 Ya existe un registro con el mismo nombre, verifique e intente de nuevo.";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}else{
		        $this->db->trans_commit();
		}
	}

	public function actualizarAutCategoria($id,$descripcion)
	{
		$this->db->trans_begin();
			date_default_timezone_set("America/Managua");
			$mensaje = array();
			$this->db->where("ID",$id);
			$data = array(
				"DESCRIPCION" => $descripcion,
				"FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
				"USUARIOEDITA" => $this->session->userdata("id")
			);

			$actualizar = $this->db->update("AutorizacionesCategoria",$data);

			if($actualizar){
				$mensaje[0]["mensaje"] = "Datos actualizados con éxito.";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Fallo al actualizar los datos.
				Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}else{
		        $this->db->trans_commit();
		}
	}

	public function baja($id,$descripcion,$estado,$fecha){
		$this->db->trans_begin();
		date_default_timezone_set("America/Managua");
		$mensaje = array();
		$validacion = $this->evitarDuplicados($descripcion);
		if($estado == "A"){
			if($validacion){
                $mensaje[0]["mensaje"] = "Fallo al restaurar ".$descripcion.".
				 Ya existe un registro con el mismo nombre en estado activo.";
			    $mensaje[0]["tipo"] = "error";
			    echo json_encode($mensaje);
			}else{
					$this->db->where("ID",$id);
					$data = array(
						"ESTADO" => $estado,
						"FECHABAJA" => $fecha,
						"USUARIOBAJA" => $this->session->userdata("id")
					);

					$actualizar = $this->db->update("AutorizacionesCategoria",$data);

					if($actualizar){
						$mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito.";
						$mensaje[0]["tipo"] = "success";
						echo json_encode($mensaje);
					}else{
						$mensaje[0]["mensaje"] = "Fallo en la operación.
						 Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
						$mensaje[0]["tipo"] = "error";
						echo json_encode($mensaje);
					}
			}
		}else{
			$this->db->where("ID",$id);
			$data = array(
				"ESTADO" => $estado,
				"FECHABAJA" => gmdate(date("Y-m-d H:i:s")),
				"USUARIOBAJA" => $this->session->userdata("id")
			);

			$actualizar = $this->db->update("AutorizacionesCategoria",$data);

			if($actualizar){
				$mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito.";
				$mensaje[0]["tipo"] = "success";
					echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Fallo en la operación.
				 Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}else{
		        $this->db->trans_commit();
		}
	}
/****************************Categorias Autorizaciones******************************************/

/****************************Crear Autorizaciones******************************************/
	public function showCategorias(){
		$query = $this->db->where("ESTADO","A")
		        ->get("AutorizacionesCategoria");
			if($query->num_rows() > 0){
				return $query->result_array();
			}
			return 0; 	
	}

	public function mostrarAutorizaciones()
	{
		$query = $this->db->get("view_Autorizaciones");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}

	public function guardarPermisos($desc,$modulo,$cat)
	 {
	 	$this->db->trans_begin();
	 	date_default_timezone_set("America/Managua");
	 	$mensaje = array();
	 	$q = $this->db->query("SELECT ISNULL(MAX(IDAUTORIZACION),0)+1 AS ID FROM Autorizaciones");
	 	$data = array(
	 	   "IDAUTORIZACION" => $q->result_array()[0]["ID"],
	       "DESCRIPCION" => $desc,
	       "MODULO" => $modulo,
	       "IDAUTCATEGORIA" => $cat,
	       "ESTADO" => "A",
	       "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
	       "USUARIOCREA" => $this->session->userdata("id")
	 	);
	 	$guardar = $this->db->insert("Autorizaciones",$data);
	 	    if($guardar){
				$mensaje[0]["mensaje"] = "Datos almacenados con éxito.";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Fallo al almacenar los datos.
				Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}
		else
		{
		        $this->db->trans_commit();
		}
	 } 

	 public function actualizarPermisos($id,$desc,$modulo,$cat)
	 {
	 	$this->db->trans_begin();
	 	date_default_timezone_set("America/Managua");
	 	$mensaje = array();
	 	$this->db->where("IDAUTORIZACION", $id);
	 	$data = array(
	       "DESCRIPCION" => $desc,
	       "MODULO" => $modulo,
	       "IDAUTCATEGORIA" => $cat,
	       "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
	       "USUARIOEDITA" => $this->session->userdata("id")
	 	);
	 	$update = $this->db->update("Autorizaciones",$data);
	 	    if($update){
				$mensaje[0]["mensaje"] = "Datos actualizados con éxito.";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Fallo al actualizar los datos.
				Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}
		else
		{
		        $this->db->trans_commit();
		}
	 } 

	 public function bajaPermisos($id,$estado,$fecha){
		$this->db->trans_begin();
		date_default_timezone_set("America/Managua");
		$mensaje = array();
		$this->db->where("IDAUTORIZACION",$id);
			$data = array(
				"ESTADO" => $estado,
				"FECHABAJA" => $fecha,
				"USUARIOBAJA" => $this->session->userdata("id")
			);

			$actualizar = $this->db->update("Autorizaciones",$data);

			if($actualizar){
				$mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito.";
				$mensaje[0]["tipo"] = "success";
					echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Fallo en la operación.
				 Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}else{
		        $this->db->trans_commit();
		}
	}
/****************************Crear Autorizaciones******************************************/

/****************************Crear Autorizaciones******************************************/
	public function mostrarUsuarios(){
		$query = $this->db->get("view_UsuariosRol");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}

	public function asignarPermiso($asig)
	{
		$this->db->trans_begin();
		date_default_timezone_set("America/Managua");
		$mensaje = array(); $guardar = '';
		$array = explode(",", $asig[0]);
		$delete = $this->db->where("IDUSUARIO",$array[0])->delete("AutorizacionesUsuario");
		if($delete){
			for ($i=0; $i < count($asig); $i++) { 
				$asignacion = explode(",", $asig[$i]);
				$insert = array(
					"IDUSUARIO" => $asignacion[0],
					"IDAUTORIZACION" => $asignacion[1],
					"FECHACREA" => gmdate(date("Y-m-d H:i:s")),
					"USUARIOCREA" => $this->session->userdata("id")
				);
				$guardar = $this->db->insert("AutorizacionesUsuario",$insert);
			}
			if($guardar){
				$mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito.";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Fallo en la operación.
				 Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.
				  COD(INS2)";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		}else{
			    $mensaje[0]["mensaje"] = "Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador. COD(DEL1)";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
		}

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		}else{
		        $this->db->trans_commit();
		}
	}

	/*
		funcion que permite determinar si un usuario x posee x permiso
    */
	public function validarPermiso($idUsuario, $idPermiso){
		$query = $this->db->select("IDAUTORIZACION")
		       ->where("IDUSUARIO", $idUsuario)
		       ->where("IDAUTORIZACION", $idPermiso)
		       ->get("AutorizacionesUsuario");
		if($query->num_rows() > 0){
			return $query->result_array();
		}       
		return 0;
	}

	public function getAuthAsig($idUsuario){
		$i = 0;
		$json = array();
		$query = $this->db->select("IDAUTORIZACION")
		       ->where("IDUSUARIO", $idUsuario)
		       ->get("AutorizacionesUsuario");
		if ($query->num_rows() > 0 ) {
			foreach ($query->result_array() as $key) {
		      $json[$i]["IDAUTORIZACION"] = $key["IDAUTORIZACION"];
		      $i++;  
		    }      
		} 
			echo json_encode($json);
	}	


/****************************Crear Autorizaciones******************************************/

}