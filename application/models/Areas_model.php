<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 18/5/2019 08:43 2019
 * FileName: Areas_model.php
 */
class Areas_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function mostrarAreas(){
		$query = $this->db->query("SELECT t1.*,CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) as NOMBRES FROM Areas t1
		                           inner join [Usuarios] t2 on t1.USUARIOCREA = t2.IDUSUARIO");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	} 

	/*Validar que no se puedan ingresar regitsros repetidos*/
	public function validaRepetidos($area,$siglas){
		$query = $this->db->query("SELECT AREA,SIGLAS FROM Areas
			                       where ESTADO = 1 and (AREA like '%".$area."%'
  								   or SIGLAS like '%".$siglas."%')");
  		if($query->num_rows() > 0){
  			return true;
  		}else{
			return false;
  		}
	}

	public function guardarAreas($area,$siglas){
		date_default_timezone_set("America/Managua");
		$mensaje = array();
		$valida = $this->validaRepetidos($area,$siglas);
		if(!$valida){
			$id = $this->db->query("SELECT ISNULL(MAX(IDAREA),0)+1 AS IDAREA FROM Areas");
			$data = array(
				"IDAREA" => $id->result_array()[0]["IDAREA"],
				"AREA" => $area,
				"SIGLAS" => $siglas,
				"USUARIOCREA" => $this->session->userdata("id"),
				"FECHACREA" => gmdate(date("Y-m-d H:i:s")),
				"ESTADO" => 1
			);
			$save = $this->db->insert("Areas",$data);
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
		}else{
			$mensaje[0]["mensaje"] = "Fallo al almacenar los datos.
				 Ya existe un área con el mismo nombre o las mismas siglas, verifique e intente de nuevo.";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}

	public function actualizarAreas($idarea,$area,$siglas){
		date_default_timezone_set("America/Managua");
		$mensaje = array();
		$this->db->where("IDAREA", $idarea);
		$data = array(
			"AREA" => $area,
			"SIGLAS" => $siglas,
			"USUARIOEDITA" => $this->session->userdata("id"),
			"FECHAEDITA" => gmdate(date("Y-m-d H:i:s"))
		);
		$update = $this->db->update("Areas",$data);
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
	}

	public function Baja_Alta($idarea,$estado,$userbaja,$fecha){
		date_default_timezone_set("America/Managua");
		$mensaje = array();
		$this->db->where("IDAREA", $idarea);
		$data = array(
			"ESTADO" => $estado,
			"USUARIOBAJA" => $userbaja,
			"FECHABAJA" => $fecha
		);
		$update = $this->db->update("Areas",$data);
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
	}
}
