<?php

class ctce_model extends CI_Model
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

	public function getContenedores()
	{
		$query = $this->db->get("CatContenedores");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}
	public function mostrarNivelInspeccion()
	{
		$query = $this->db->get("CatNivelInspeccion");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return 0;
	}

	public function getMuestra($tamano,$nivel,/*$tamano2,*/$nivel2,$bandera){
		$arreglo = explode("-",$tamano);
		//print_r($arreglo);

		try{
			$query = "SELECT MUESTRA FROM CatMuestras
					WHERE LETRA =
					(SELECT ".strval($nivel)." FROM CatNivelInspeccion WHERE Desde= ".$arreglo[0]." and Hasta <= ".$arreglo[1].")";

			//echo $query."<br>";

			$query = $this->db->query("SELECT MUESTRA FROM CatMuestras
			WHERE LETRA = (SELECT ".strval($nivel)." FROM CatNivelInspeccion WHERE Desde= ".$arreglo[0]." and Hasta <= ".$arreglo[1].")");

			if ($query->num_rows()>0){
				if ($bandera == "true"){
					$muestra  = $query->result_array()[0]["MUESTRA"];


					//echo "SELECT MUESTRA FROM CatMuestras WHERE LETRA =
					//(SELECT ".strval($nivel2)." FROM CatNivelInspeccion WHERE (".$muestra." >= DESDE) and (".$muestra." <= HASTA)) <br>";
					$query = $this->db->query("SELECT MUESTRA FROM CatMuestras WHERE LETRA =
					(SELECT ".strval($nivel2)." FROM CatNivelInspeccion WHERE (".$muestra." >= DESDE) and (".$muestra." <= HASTA))");

					if ($query->num_rows()>0) {
						echo  $query->result_array()[0]["MUESTRA"]; return;
					}
				}else{
					echo $query->result_array()[0]["MUESTRA"]; return;
				}
			}
			echo 0;return;
		}catch(Excepcion $ex){
			echo 0; return;
		}
	}

	public function getInformes()
	{
		$query = $this->db->query("SELECT T1.NOMBRES+' '+T1.APELLIDOS MONITOREADO_POR, T2.IDMONITOREO,T2.SIGLA, T0.* FROM
								Reportes T0
								INNER JOIN Usuarios T1 ON T1.IDUSUARIO = T0.IDUSUARIOCREA
								INNER JOIN Monitoreos T2 ON T2.IDMONITOREO = T0.IDMONITOREO
								WHERE T0.IDTIPOREPORTE = 15 order by t0.FECHACREA DESC");
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return 0;
	}


	public function guardarCTCE($enc,$datos)
	{
		$this->db->trans_begin();

		date_default_timezone_set("America/Managua");
		$mensaje = array();

		//VERIFICAR SI ESXISTE EL MONITOREO CORRESPONDIENTE AL DIA DE HOY
		$query = $this->db->query("SELECT IDMONITOREO FROM Monitoreos WHERE cast(FECHAINICIO AS DATE) = CAST(getdate() AS DATE) AND
									 CAST(FECHAFIN AS DATE) = cast(getdate() AS DATE) AND ESTADO = 'A' ");
		if($query->num_rows() > 0)
		{

			$id = $this->db->query("SELECT ISNULL(MAX(IDREPORTE),0)+1 AS ID FROM Reportes");
			$encabezado = array(
			  "IDREPORTE" => $id->result_array()[0]["ID"],
		      "IDMONITOREO" => $query->result_array()[0]["IDMONITOREO"],
		      "IDAREA" => null,
		      "VERSION" => '1',
		      "IDTIPOREPORTE" => '15',
		      "NOMBRE" => "CONTROL DE TEMPERATURAS DE CONTENEDORES EXTERNOS (CTCE)",
		      "OBSERVACIONES" => $enc[0],
		      //"LOTE" => $enc[7],pendiente
		      "ESTADO" => 'A',
		      "FECHAINICIO" => gmdate(gmdate($enc[1])),
		      "FECHAFIN" => gmdate(gmdate($enc[1])),
		      "FECHACREA" => gmdate(gmdate($enc[1])),
		      "IDUSUARIOCREA" => $this->session->userdata("id")
			);

			$inserto = $this->db->insert("Reportes",$encabezado);
			if ($inserto) {
				$num = 1; $bandera = false;
				$det = json_decode($datos, true);
				foreach ($det as $obj) {
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDTEMPESTERILIZADOR),0)+1 AS ID FROM ReportesTemperaturas");

					$rpt = array(
						"IDTEMPESTERILIZADOR" => $idpeso->result_array()[0]["ID"],
		                "IDREPORTE" => $id->result_array()[0]["ID"],
		                "IDCONTENEDOR" => intval($obj[0]),
		                "TOMA1" => floatval($obj[2]),
		                "TOMA2" => floatval($obj[3]),
		                "TOMA3" => floatval($obj[4]),
		                "OBSERVACIONES" => $obj[5],
		                "VERIFICACION_AC" => $obj[6],
		                "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
		                "USUARIOCREA" => $this->session->userdata("id")
				    );

				    $num++;
				    $guardarRpt = $this->db->insert("ReportesTemperaturas",$rpt);
				    $bandera=false;
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
			$mensaje[0]["mensaje"] = "No se pudo guardar el informe porque no exsite un codigo de monitoreo para la fecha ".date("d-m-Y")."";
			$mensaje[0]["tipo"] = "error";
			$this->db->trans_rollback();
			echo json_encode($mensaje);
			return;
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


	public function getEncCTCE($idreporte)
	{
		$query	= $this->db->query("SELECT t0.*,t1.*,t2.SIGLA
						FROM Reportes t0
						inner join Usuarios t1 on t1.IDUSUARIO = t0.IDUSUARIOCREA
						INNER JOIN Monitoreos t2 ON T2.IDMONITOREO = T0.IDMONITOREO
						where t0.IDREPORTE = '".$idreporte."'");
		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;
	}

	public function getdetCTCE($idreporte)
	{

		$query = $this->db->query("SELECT T0.*,T1.NOMBRE,T1.COMENTARIO
					FROM ReportesTemperaturas t0
					INNER JOIN CatContenedores t1 on t1.IDCATCONTENEDOR = T0.IDCONTENEDOR
					WHERE T0.IDREPORTE = '".$idreporte."'"
				);

		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;

	}

	public function guardarEditarCTCE($id,$enc,$detalle)
	{
		//echo json_encode($enc);
		date_default_timezone_set("America/Managua");
		$mensaje = array();

		$this->db->trans_begin();

		$existe = $this->db->query("SELECT IDREPORTE FROM Reportes WHERE IDREPORTE = ".$id);
		if ($existe->num_rows()>0) {

			$datos = array(
			      "OBSERVACIONES" => $enc[0],
			      "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
			      "IDUSUARIOEDITA" => $this->session->userdata("id")
				);

			$this->db->where('IDREPORTE',$id);
			$update = $this->db->update('Reportes',$datos);
			$this->db->query("DELETE FROM ReportesTemperaturas WHERE IDREPORTE = ".$id);
			  $det = json_decode($detalle, true);
			  //echo json_encode($datos, true);
			  $num = 1;
				foreach ($det as $obj){
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDTEMPESTERILIZADOR),0)+1 AS ID FROM ReportesTemperaturas");

					$rpt = array(
						"IDTEMPESTERILIZADOR" => $idpeso->result_array()[0]["ID"],
		                "IDREPORTE" => $id,
		                "IDCONTENEDOR" => intval($obj[0]),
		                "TOMA1" => floatval($obj[2]),
		                "TOMA2" => floatval($obj[3]),
		                "TOMA3" => floatval($obj[4]),
		                "OBSERVACIONES" => $obj[5],
		                "VERIFICACION_AC" => $obj[6],
		                "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
		                "USUARIOEDITA" => $this->session->userdata("id")
				    );

				    $num++;
				    $guardarRpt = $this->db->insert("ReportesTemperaturas",$rpt);
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
		if ($this->db->trans_status() === FALSE)
		{
			$mensaje[0]["mensaje"] = "No se pudo guardar el informe intentelo nuevamente";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		}
	}


	public function BajaAltaCTCE($id,$estado)
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
