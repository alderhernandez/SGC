<?php

class Monitoreo_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function crearmonitoreo($proceso){

		//$this->db->query("TRUNCATE TABLE Monitoreos");
		$result = array();
		$this->db->trans_start();
		$existe = $this->db->query("SELECT IDMONITOREO FROM Monitoreos WHERE CAST(FECHAINICIO AS DATE) >= CAST(GETDATE() AS DATE) 
		AND CAST(FECHAFIN AS DATE) <= CAST(GETDATE() AS DATE)");

		if ($existe->num_rows()>0) {
			$result[0]["mensaje"] = "Error, Ya Existe un Código de Monitoreo Para Hoy";		
			$result[0]["retorno"] = false;
			$this->db->trans_commit();
			echo json_encode($result);
			return;
		}else{
			$this->db->query("UPDATE Monitoreos SET ESTADO = 0");
			$IDMONITOREO = $this->db->query("SELECT ISNULL(MAX(IDMONITOREO),0)+1 as IDMONITOREO FROM Monitoreos");	

			$query = "INSERT INTO Monitoreos (IDMONITOREO,SIGLA,DIA,ESTADO,FECHAINICIO,FECHAFIN,FECHACREA,IDUSUARIOCREA)
							VALUES (".$IDMONITOREO->result_array()[0]["IDMONITOREO"].",(SELECT CAST(DATEPART(wk, GETDATE())AS VARCHAR)+'-'+CAST(DATEPART(DAY,GETDATE()) AS VARCHAR)),CONVERT(NVARCHAR, GETDATE(), 105),'A',GETDATE(),GETDATE(),GETDATE(),". $this->session->userdata("id").")";
			$this->db->query($query);
		}		
		if ($this->db->trans_status() === FALSE)
		{
			$result[0]["mensaje"] = "Ocurrio un error inesperado, Si el Problema Persiste Contacte al Administrador";
			$result[0]["retorno"] = false;
		    $this->db->trans_rollback();
		}else
		{
				$result[0]["mensaje"] = "Monitoreo Creado";
				$result[0]["retorno"] = true;
		        $this->db->trans_commit();
		}
		echo json_encode($result);
		return;
	}

	public function mostrarMonitoreos()
	{
		$query = $this->db->query("SELECT t0.*,t1.NOMBRES+' '+t1.APELLIDOS AS USUARIO FROM Monitoreos t0
								inner join Usuarios t1 on t1.IDUSUARIO = t0.IDUSUARIOCREA");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}
}