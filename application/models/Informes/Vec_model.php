<?php

class Vec_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getInformes()
	{
		$query = $this->db->query("SELECT TOP 500 T3.AREA, T1.NOMBRES+' '+T1.APELLIDOS MONITOREADO_POR, T2.IDMONITOREO,T2.SIGLA, T0.* FROM
								Reportes T0
								INNER JOIN Usuarios T1 ON T1.IDUSUARIO = T0.IDUSUARIOCREA
								INNER JOIN Monitoreos T2 ON T2.IDMONITOREO = T0.IDMONITOREO
								INNER JOIN Areas T3 ON T3.IDAREA = T0.IDAREA
								WHERE T0.IDTIPOREPORTE = 12 order by t0.FECHACREA DESC");
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return 0;
	}
	

	public function BajaAlta($id,$estado)
	{

		

		$mensaje = array();
		$data = array(
			"ESTADO" => $estado
		);
		$this->db->where("IDREPORTE", $id);
		$update = $this->db->update("ReportesArticulos",$data);
		$this->db->where("IDREPORTE", $id);
		$update = $this->db->update("Reportes",$data);

		if($update){
			$mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito. ".$id;
			$mensaje[0]["tipo"] = "success";
			echo json_encode($mensaje);
		}else{
			$mensaje[0]["mensaje"] = "Fallo en la operación.
			 Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador.";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}

	public function guardarVEC($enc,$datos)
	{
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
		      "IDTIPOREPORTE" => '12',
		      "NOMBRE" => "VERIFICACION ESPECIFICACION DE CALIDAD",
		      "CODIGOPRODUCTO" => $enc[3],
		      "NOMBREPRODUCTO" => $enc[4],		      
		      "OBSERVACIONES" => $enc[1],
		      "LOTE" => $enc[2],		      
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
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDARTICULO),0)+1 AS IDARTICULO FROM ReportesArticulos");

					$rpt = array(
						"IDARTICULO" => $idpeso->result_array()[0]["IDARTICULO"],
		                "IDREPORTE" => $id->result_array()[0]["ID"],
		                "ESTADO" => "A",
		                "NUMERO" => $num,
		                "HORAENTRADA" => gmdate(date('H:i:s')),
		                "HORASALIDA" => gmdate(date('H:i:s')),
		                "FECHACREA" => date('Y-m-d'),
		                "CODIGO" => $obj[0],
		                "NOMBRE" => $obj[1],
		                "IDMAQUINA" => $obj[2],
		                "OPERARIO" => $obj[4],
		                "LONGITUD" => $obj[5],
		                "TEXTURA" => $obj[6],
		                "COLOR" => $obj[7],
		                "TEMP_PASTA" => $obj[8],
		                "PH_PASTA" => $obj[9],
		                "COMENTARIO" => $obj[10],
		                "LOTE" => $enc[2],
		                "IDUSUARIOCREA" => $this->session->userdata("id")
				    );

				    $num++;
				    $guardarRpt = $this->db->insert("ReportesArticulos",$rpt);
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
			return;
		}
		//$this->db->trans_rollback();
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		}
	}

	public function guardarEditarVEC($id,$enc,$detalle)
	{


		//echo json_encode($enc);
		date_default_timezone_set("America/Managua");
		$mensaje = array();
	
		$this->db->trans_begin();

		$existe = $this->db->query("SELECT IDREPORTE FROM Reportes WHERE IDREPORTE = ".$id);
		if ($existe->num_rows()>0) {

			
				$datos = array(
			      "IDAREA" => $enc[0],
			      "VERSION" => '1'.'.1',
			      "CODIGOPRODUCTO" => $enc[3],
			      "NOMBREPRODUCTO" => $enc[4],			      
			      "LOTE" => $enc[2],
			      "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
			      "OBSERVACIONES" => $enc[1],
			      "IDUSUARIOEDITA" => $this->session->userdata("id")
				);			
			$this->db->where('IDREPORTE',$id);
			$update = $this->db->update('Reportes',$datos);

			$this->db->query("DELETE FROM ReportesArticulos WHERE IDREPORTE = ".$id);
			  $det = json_decode($detalle, true);
			  //echo json_encode($datos, true);
			  $num = 1;
				foreach ($det as $obj) {
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDARTICULO),0)+1 AS IDARTICULO FROM ReportesArticulos");

					$rpt = array(
						"IDARTICULO" => $idpeso->result_array()[0]["IDARTICULO"],
		                "IDREPORTE" => $id,
		                "ESTADO" => "A",
		                "NUMERO" => $num,
		                "HORAENTRADA" => gmdate(date('H:i:s')),
		                "HORASALIDA" => gmdate(date('H:i:s')),
		                "FECHACREA" => date('Y-m-d'),
		                "CODIGO" => $obj[0],
		                "NOMBRE" => $obj[1],
		                "IDMAQUINA" => $obj[2],
		                "OPERARIO" => $obj[4],
		                "LONGITUD" => $obj[5],
		                "TEXTURA" => $obj[6],
		                "COLOR" => $obj[7],
		                "TEMP_PASTA" => $obj[8],
		                "PH_PASTA" => $obj[9],
		                "COMENTARIO" => $obj[10],
		                "IDUSUARIOEDITA" => $this->session->userdata("id")	                
				    );

				    $num++;	
				    $guardarRpt = $this->db->insert("ReportesArticulos",$rpt);
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

	public function getEncVEC($idreporte)
	{
		$query	= $this->db->query("SELECT t0.*,t1.*,t2.SIGLA,t3.AREA 
			,CAST(T4.DESCRIPCION AS CHAR)+'-'+CAST(T4.CONSECUTIVO AS CHAR)+'-'+CAST(T4.VERSION AS CHAR) VERSION
						FROM Reportes t0
						inner join Usuarios t1 on t1.IDUSUARIO = t0.IDUSUARIOCREA
						INNER JOIN Monitoreos t2 ON T2.IDMONITOREO = T0.IDMONITOREO
						INNER JOIN Areas t3 on t3.IDAREA = t0.IDAREA
						left join CatVersiones t4 on t4.IDTIPOREPORTE = T0.IDTIPOREPORTE
						WHERE t0.IDREPORTE = '".$idreporte."'");
		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;
	}

	public function getdetVEC($idreporte)
	{
				 
		$query = $this->db->query("SELECT T0.*,t1.MAQUINA
					FROM ReportesArticulos t0
					inner join CatMaquinas t1  on t1.IDMAQUINA = t0.IDMAQUINA
					WHERE T0.IDREPORTE = '".$idreporte."'"
				);

		if ($query->num_rows()>0) {
			return $query->result_array();
		}
		return 0;

	}

}