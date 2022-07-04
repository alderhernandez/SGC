<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-09 14:07:53
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-12 09:32:27
 */
class CategoriaReporte_model extends CI_Model{
	public function __construct()
	 {
	 	parent::__construct();
	 	$this->load->database();
	 } 

	 public function mostrarCatRepor()
	 {
	 	$query = $this->db->get("CatReportes");
	 	if($query->num_rows() > 0){
	 		return $query->result_array();
	 	}
	 	return 0;
	 }

    public function mostrarCatReporActivos()
    {
        $query = $this->db->where("ESTADO","A")->get("CatReportes");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

	 public function guardarCatRep($sigla,$nombre)
	 {
	 	$this->db->trans_begin();
	 	date_default_timezone_set("America/Managua");
	 	$mensaje = array();
	 	$Id = $this->db->query("SELECT ISNULL(MAX(IDTIPOREPORTE),0)+1 AS IDTIPOREPORTE FROM CatReportes");
	 	$datos = array(
	 	  "IDTIPOREPORTE" => $Id->result_array()[0]["IDTIPOREPORTE"],
	      "SIGLA" => $sigla,
	      "NOMBRE" => $nombre,
	      "ESTADO" => "A",
	      "IDUSUARIOCREA" => $this->session->userdata("id"),
	      "FECHACREA" => gmdate(date("Y-m-d H:i:s"))
	 	);

	 	$guardar = $this->db->insert("CatReportes", $datos);
	 	if($guardar){
	 		$mensaje[0]["mensaje"] = "Datos almacenados con éxito";
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

	 public function actualizarCatRep($id,$sigla,$nombre)
	 {
	 	$this->db->trans_begin();
	 	date_default_timezone_set("America/Managua");
	 	$mensaje = array();
	 	$this->db->where("IDTIPOREPORTE",$id);
	 	$datos = array(
	      "SIGLA" => $sigla,
	      "NOMBRE" => $nombre,
	      "IDUSUARIOEDITA" => $this->session->userdata("id"),
	      "FECHAEDITA" => gmdate(date("Y-m-d H:i:s"))
	 	);

	 	$guardar = $this->db->update("CatReportes", $datos);
	 	if($guardar){
	 		$mensaje[0]["mensaje"] = "Datos actualizados con éxito";
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

	 public function Baja_AltaCatRep($id,$estado){
		$this->db->trans_begin();
		$mensaje = array();
		$this->db->where("IDTIPOREPORTE", $id);
		$data = array(
			"ESTADO" => $estado
		);
		$update = $this->db->update("CatReportes",$data);
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

	public function MostrarLote()
    {
        date_default_timezone_set("America/Managua");
        $lote = 0;
        $lote = date("W")."".date("m")."-".date("w");
        return $lote;
    }
}