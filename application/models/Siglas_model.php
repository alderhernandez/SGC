<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-07-30 09:50:18
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-05 11:41:37
 */
class Siglas_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		date_default_timezone_set("America/Managua");
	}

	public function cargarSimbologias(){
		$query = $this->db->get("CatSimbologias");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}

	public function guardarSimbologia($sigla,$desc,$cat){
		$this->db->trans_begin();

        $mensaje = array();
		$id = $this->db->query("SELECT ISNULL(MAX(IDSIMBOLOGIA),0)+1 AS IDSIMBOLOGIA FROM CatSimbologias");
		$data = array(
	       "IDSIMBOLOGIA" => $id->result_array()[0]["IDSIMBOLOGIA"],
	       "SIGLA" => $sigla,         
	       "DESCRIPCION" => $desc,
	       "CATEGORIA" => $cat,
	       "ESTADO" => "A",
	       "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
	       "IDUSUARIOCREA" => $this->session->userdata("id")
		);
		$save = $this->db->insert("CatSimbologias", $data);
		if($save){
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

	public function actualizarSimbologia($id,$sigla,$desc,$cat){
		$this->db->trans_begin();

		$mensaje = array();
		$this->db->where("IDSIMBOLOGIA", $id);
		$data = array(
	       "SIGLA" => $sigla,         
	       "DESCRIPCION" => $desc,
	       "CATEGORIA" => $cat,
	       "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
	       "IDUSUARIOEDITA" => $this->session->userdata("id")
		);
		$update = $this->db->update("CatSimbologias", $data);
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

	public function Baja_Alta($id,$estado){
		$this->db->trans_begin();

		$mensaje = array();
		$this->db->where("IDSIMBOLOGIA", $id);
		$data = array(
			"ESTADO" => $estado
		);
		$update = $this->db->update("CatSimbologias",$data);
		if($update){
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
		}
		else
		{
		        $this->db->trans_commit();
		}
	}
	
}