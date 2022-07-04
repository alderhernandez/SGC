<?php

class Cpp_model extends CI_Model
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
		$query = $this->db->query("SELECT top 20 T3.AREA, T1.NOMBRES+' '+T1.APELLIDOS MONITOREADO_POR, T2.IDMONITOREO,T2.SIGLA, T0.* FROM
								Reportes T0
								INNER JOIN Usuarios T1 ON T1.IDUSUARIO = T0.IDUSUARIOCREA
								INNER JOIN Monitoreos T2 ON T2.IDMONITOREO = T0.IDMONITOREO
								INNER JOIN Areas T3 ON T3.IDAREA = T0.IDAREA
								WHERE T0.IDTIPOREPORTE = 10 order by t0.FECHACREA DESC ");
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return 0;
	}


	public function guardarCPP($enc,$datos)
	{
		///echo date("Y-m-d H:i:s");
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
		      "IDAREA" => $enc[0],	
		      "VERSION" => '1',
		      "IDTIPOREPORTE" => '10',
		      "NOMBRE" => "REGISTRO CONTROL DE PESO EN PROCESO (CPP)",
		      "CODIGOPRODUCTO" => $enc[3],
		      "NOMBREPRODUCTO" => $enc[4],
		      "OBSERVACIONES" => $enc[1],
		      "LOTE" => $enc[7],
		      "PESOGRAMOS" => $enc[5],
		      "NOBATCH" => $enc[8],
		      "IDMAQUINA" => $enc[17],
		      "DECISION" => $enc[14],
		      "FUNDALARGO" =>$enc[15],
		      "FUNDADIAMETRO" =>$enc[16],
		      "TAMANOMUESTRA" => $enc[9],
		      "NIVELINSPECCION" => $enc[10],
		      "ESPECIAL" => $enc[11],
		      "NIVELINSPECCION2" => $enc[12],
		      "MUESTRA" => $enc[13],
		      "ESTADO" => 'A',
		      "FECHAINICIO" => gmdate(date("Y-m-d H:i:s")),
		      "FECHAFIN" => gmdate(date("Y-m-d H:i:s")),
		      "FECHACREA" => gmdate(date("Y-m-d H:i:s")),

		      "IDUSUARIOCREA" => $this->session->userdata("id")
			);

			$inserto = $this->db->insert("Reportes",$encabezado);	
			if ($inserto) {
				$num = 1; $bandera = false;
				$det = json_decode($datos, true);
				foreach ($det as $obj) {					
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDPESO),0)+1 AS IDPESO FROM ReportesPeso");

					$rpt = array(
						"IDPESO" => $idpeso->result_array()[0]["IDPESO"],
		                "IDREPORTE" => $id->result_array()[0]["ID"],
		                "ESTADO" => "A",
		                "NUMERO" => $num,
		                "HORA" => gmdate(date('H:i:s')),
		                "FECHAINGRESO" => $enc[2],
		                "CODIGO" => $obj[1],
		                "DESCRIPCION" => $obj[2],
		                "PESOMASA" => $obj[3],
		                "PESOBASCULA" => $obj[4],
		                "UNIDADPESO" => 'Gramos',
		                "DIFERENCIA" => $obj[5],
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
					$this->db->trans_commit();
					echo json_encode($mensaje);
					return;
				}else{
					$mensaje[0]["mensaje"] = "Error al guardar los datos del informe COD(2_DET)";
					$mensaje[0]["tipo"] = "error";
					$this->db->trans_rollback();
					echo json_encode($mensaje);					
					return;
				}
			}
		}else{
			$mensaje[0]["mensaje"] = "No se pudo guardar el informe porque no exsite un codigo de 
										monitoreo para la fecha ".date("d-m-Y")."";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
			$this->db->trans_rollback();
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

	public function getencRvpbp($idreporte)
	{
		$this->db->where('IDREPORTE',$idreporte);
		$query = $this->db->get('Reportes');

		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;

	}

	public function getEncCPP($idreporte)
	{
		$query	= $this->db->query("SELECT t0.*,t1.IDUSUARIO,t1.NOMBREUSUARIO,t1.NOMBRES,t1.APELLIDOS,t2.SIGLA,t3.AREA,
CAST(T4.DESCRIPCION AS CHAR)+'-'+CAST(T4.CONSECUTIVO AS CHAR)+'-'+CAST(T4.VERSION AS CHAR) VERSION 
FROM Reportes t0
						inner join Usuarios t1 on t1.IDUSUARIO = t0.IDUSUARIOCREA
						INNER JOIN Monitoreos t2 ON T2.IDMONITOREO = T0.IDMONITOREO
						INNER JOIN Areas t3 on t3.IDAREA = t0.IDAREA
						left join CatVersiones t4 on t4.IDTIPOREPORTE = T0.IDTIPOREPORTE
						where t0.IDREPORTE = '".$idreporte."'");		
		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;
	}

	public function getdetCPP($idreporte)
	{
				 
		$query = $this->db->query("SELECT T0.*
					FROM ReportesPeso t0
					WHERE T0.IDREPORTE = '".$idreporte."'"
				);

		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;

	}

	public function guardarEditarCPP($id,$enc,$detalle)
	{
		//echo json_encode($enc);
		date_default_timezone_set("America/Managua");
		$mensaje = array();
	
		$this->db->trans_begin();

		$existe = $this->db->query("SELECT IDREPORTE FROM Reportes WHERE IDREPORTE = ".$id);
		if ($existe->num_rows()>0) {

			if ($enc[3] != '' && $enc[4] != '' && $enc[5] != '') {
				$datos = array(
			      "IDAREA" => $enc[0],
			      "VERSION" => '1'.'.1',
			      "CODIGOPRODUCTO" => $enc[3],
			      "NOMBREPRODUCTO" => $enc[4],
			      "PESOGRAMOS" => $enc[5],
			      "OBSERVACIONES" => $enc[6],
			      "LOTE" => $enc[7],
			      "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
			      "OBSERVACIONES" => $enc[1],
			      "DECISION" => $enc[14],
			      "IDMAQUINA" => $enc[17],		      	
		      	  "FUNDALARGO" =>$enc[15],
		      	  "FUNDADIAMETRO" =>$enc[16],
			      "IDUSUARIOEDITA" => $this->session->userdata("id")
				);
			}else{
				$datos = array(
			      "IDAREA" => $enc[0],
			      "VERSION" => '1'.'.1',
			      "OBSERVACIONES" => $enc[6],
			      "LOTE" => $enc[7],
			      "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
			      "OBSERVACIONES" => $enc[1],
			      "DECISION" => $enc[14],
			      "IDMAQUINA" => $enc[17],		      	
		      	  "FUNDALARGO" =>$enc[15],
		      	  "FUNDADIAMETRO" =>$enc[16],		      	  
			      "IDUSUARIOEDITA" => $this->session->userdata("id")
				);
			}
			$this->db->where('IDREPORTE',$id);
			$update = $this->db->update('Reportes',$datos);
			$this->db->query("DELETE FROM ReportesPeso WHERE IDREPORTE = ".$id);
			  $det = json_decode($detalle, true);
			  //echo json_encode($datos, true);
			  $num = 1;
				foreach ($det as $obj) {
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDPESO),0)+1 AS IDPESO FROM ReportesPeso");


					$rpt = array(
						"IDPESO" => $idpeso->result_array()[0]["IDPESO"],
		                "IDREPORTE" => $id,
		                "ESTADO" => "A",
		                "NUMERO" => $num,
		                "HORA" => gmdate(date('H:i:s')),
		                "FECHAINGRESO" => $enc[2],
		                "CODIGO" => $obj[1],
		                "DESCRIPCION" => $obj[2],
		                "PESOMASA" => $obj[3],
		                "PESOBASCULA" => $obj[4],
		                "UNIDADPESO" => 'Gramos',
		                "DIFERENCIA" => $obj[5],
		                "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
		                "IDUSUARIOEDITA" => $this->session->userdata("id")		                
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
					$this->db->trans_commit();
					echo json_encode($mensaje);
					return;
				}else{
					$mensaje[0]["mensaje"] = "Error al guardar los datos del informe COD(2_DET)";
					$mensaje[0]["tipo"] = "error";
					echo json_encode($mensaje);
					$this->db->trans_rollback();
					return;
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
	

	public function BajaAltaCPP($id,$estado)
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