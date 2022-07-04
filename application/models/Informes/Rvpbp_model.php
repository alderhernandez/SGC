<?php

class Rvpbp_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function mostrarPesos(){
		$query = $this->db->get("catPeso");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}

	public function getInformes()
	{
		$query = $this->db->query("SELECT TOP 20 T3.AREA, T1.NOMBRES+' '+T1.APELLIDOS MONITOREADO_POR, T2.IDMONITOREO,T2.SIGLA, T0.*                    FROM
								Reportes T0
								INNER JOIN Usuarios T1 ON T1.IDUSUARIO = T0.IDUSUARIOCREA
								INNER JOIN Monitoreos T2 ON T2.IDMONITOREO = T0.IDMONITOREO
								INNER JOIN Areas T3 ON T3.IDAREA = T0.IDAREA
								WHERE T0.IDTIPOREPORTE = 7 order by t0.FECHACREA DESC");
		if($query->num_rows() > 0)
		{	
			return $query->result_array();
		}
		return 0;
	}


	public function guardarRVPBP($enc,$datos)
	{
		

		$this->db->trans_begin();

		date_default_timezone_set("America/Managua");
		$mensaje = array();
		//print_r($datos);

		//VERIFICAR SI ESXISTE EL MONITOREO CORRESPONDIENTE AL DIA DE HOY
		$query = $this->db->query("SELECT IDMONITOREO FROM Monitoreos WHERE cast(FECHAINICIO AS DATE) = CAST(getdate() AS DATE) AND
									 CAST(FECHAFIN AS DATE) = cast(getdate() AS DATE) AND ESTADO = 'A' ");
		if($query->num_rows() > 0)
		{

			$id = $this->db->query("SELECT ISNULL(MAX(IDREPORTE),0)+1 AS ID FROM Reportes");
			$encabezado = array(
			  "IDREPORTE" => $id->result_array()[0]["ID"],
		      "IDMONITOREO" => $query->result_array()[0]["IDMONITOREO"],
		      "IDAREA" => $enc[1],	
		      "VERSION" => '1',
		      "IDTIPOREPORTE" => '7',
		      "NOMBRE" => "REGISTRO VERIFICACION DE PESO DE BASCULA DE PREMEZCLA",
		      "NOMBREPRODUCTO" => $enc[5],
		      "OBSERVACIONES" => $enc[6],
		      "FECHAINICIO" => gmdate(date("Y-m-d H:i:s")),
		      "FECHAFIN" => gmdate(date("Y-m-d H:i:s")),
		      "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
		      "ESTADO" => 'A',
		      "IDUSUARIOCREA" => $this->session->userdata("id")
			);

			$inserto = $this->db->insert("Reportes",$encabezado);
			if ($inserto) {
				$num = 1; $bandera = false;
				for ($i=0; $i < count($datos); $i++) {
					$array = explode("|",$datos[$i]);
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDPESO),0)+1 AS IDPESO FROM ReportesPeso");
					$rpt = array(
						"IDPESO" => $idpeso->result_array()[0]["IDPESO"],
		                "IDREPORTE" => $id->result_array()[0]["ID"],
		                "ESTADO" => "A",
		                "NUMERO" => $num,
		                "HORA" => $array[1],
		                "FECHAINGRESO" => $array[0],
		                "CODIGO" => $array[2],
		                "PESOMASA" => $array[3],
		                "OBSERVACION" => $array[7],
		                "PESOBASCULA" => $array[4],
		                "UNIDADPESO" => $array[5],
		                "DIFERENCIA" => $array[6],
		                "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
		                "IDUSUARIOCREA" => $this->session->userdata("id")
				    );

				    $num++;
				    $guardarRpt = $this->db->insert("ReportesPeso",$rpt);
				    if($guardarRpt){
					    $bandera = true;
				    }
				}
				if($bandera == true){
					$mensaje[0]["mensaje"] = "Datos guardados correctamente";
					$mensaje[0]["tipo"] = "success";
					echo json_encode($mensaje);
				}else{
					$mensaje[0]["mensaje"] = "Error al guardar los datos del informe COD(2_DET)";
					$mensaje[0]["tipo"] = "error";
					echo json_encode($mensaje);
				}
			}

		}else{
			$mensaje[0]["mensaje"] = "No se pudo guardar el informe porque no exsite un codigo de 
										monitoreo para la fecha ".date("d-m-Y")."";
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

	/*public function getencRvpbp($idreporte)
	{
		$this->db->where('IDREPORTE',$idreporte);
		$query = $this->db->get('Reportes');

		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;

	}*/

	public function getencRvpbp2($idreporte)
	{
		$this->db->where('IDREPORTE',$idreporte);
		$query = $this->db->get('ReportesPeso');

		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;
	}


	public function getdetRvpbp($idreporte)
	{
				 
		$query = $this->db->query("SELECT T0.*,T1.NOMBRES,T1.APELLIDOS
									FROM ReportesPeso t0
									INNER JOIN Usuarios t1 on t0.IDUSUARIOCREA = t1.IDUSUARIO	
									WHERE T0.IDREPORTE = '".$idreporte."'");

		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;

	}

	public function getencRvpbp($idreporte)
	{
		
		$query = $this->db->query("SELECT T0.*,T1.AREA,T2.NOMBRES,T2.APELLIDOS,T3.SIGLA
								,CAST(T4.DESCRIPCION AS CHAR)+'-'+CAST(T4.CONSECUTIVO AS CHAR)+'-'+CAST(T4.VERSION AS CHAR) VERSION
								FROM Reportes T0
								INNER JOIN Areas T1 ON T1.IDAREA = T0.IDAREA
								INNER JOIN Usuarios T2 ON T2.IDUSUARIO = T0.IDUSUARIOCREA
								INNER JOIN Monitoreos T3 ON T3.IDMONITOREO = T0.IDMONITOREO
								left join CatVersiones t4 on t4.IDTIPOREPORTE = T0.IDTIPOREPORTE
								WHERE IDREPORTE = '".$idreporte."'");

		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;
	}

	public function guardareditarRVPBP	($id,$detalle,$enc)
	{

		//echo $id;
		date_default_timezone_set("America/Managua");
		$mensaje = array();
	
		$this->db->trans_begin();

		$existe = $this->db->query("SELECT IDREPORTE FROM Reportes WHERE IDREPORTE = ".$id);
		$datos = array(		      
		      "IDAREA" => $enc[1],
		      "VERSION" => '1'.'.1',		      
		      "NOMBREPRODUCTO" => $enc[5],
		      "OBSERVACIONES" => $enc[6],		      
		      "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
		      "IDUSUARIOEDITA" => $this->session->userdata("id")
			);
		$this->db->where('IDREPORTE',$id);
		$update = $this->db->update('Reportes',$datos);
		$num = 1;
		if ($update) {
			$this->db->query("DELETE FROM ReportesPeso WHERE IDREPORTE = ".$id);
			for ($i=0; $i < count($detalle); $i++) {
					$array = explode("|",$detalle[$i]);
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDPESO),0)+1 AS IDPESO FROM ReportesPeso");
					$rpt = array(
						"IDPESO" => $idpeso->result_array()[0]["IDPESO"],
		                "IDREPORTE" => $id,
		                "ESTADO" => "A",
		                "NUMERO" => $num,
		                "HORA" => $array[1],
		                "FECHAINGRESO" => $array[0],
		                "CODIGO" => $array[2],
		                "PESOMASA" => $array[3],
		                "OBSERVACION" => $array[7],
		                "PESOBASCULA" => $array[4],
		                "UNIDADPESO" => $array[5],
		                "DIFERENCIA" => $array[6],		                
		                "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
		                "IDUSUARIOCREA" => $this->session->userdata("id")
				    );

				    $num++;	
				    $guardarRpt = $this->db->insert("ReportesPeso",$rpt);
				    if($guardarRpt){
					    $bandera = true;
					    $mensaje[0]["mensaje"] = "Datos guardados correctamente";
						$mensaje[0]["tipo"] = "success";
				    }
				}
				echo json_encode($mensaje);
		}
		if ($this->db->trans_status() === FALSE)
		{
			$mensaje[0]["mensaje"] = "Ocurrio un error inesperado intentelo nuevamente";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);				
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		}
	}
	

	public function BajaAltaRVPBP($id,$estado)
	{

		$mensaje = array();
		$data = array(
			"ESTADO" => $estado
		);
		$this->db->where("IDREPORTE", $id);		
		$update = $this->db->update("ReportesPeso",$data);
		$this->db->where("IDREPORTE", $id);
		$update = $this->db->update("Reportes",$data);

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