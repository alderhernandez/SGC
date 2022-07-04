<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-28 15:49:05
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-28 17:08:47
 */
class Veced_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function mostrarVeced()
	{
		$query = $this->db->query(" SELECT t1.IDREPORTE,t1.SIGLA,t1.DIA,t1.HORAIDENTIFICACION,T1.AREA,t1.FECHACREA,t1.DESCRIPCION,T1.CODIGOPRODUCCION,
                                    T1.NOESTIBAS,T1.ESTADODET,CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) USUARIO FROM view_InformesPesoAcciones t1
                                    INNER JOIN Usuarios t2 ON t1.IDUSUARIOCREA = t2.IDUSUARIO 
                                    WHERE NOMBRE LIKE '%VERIFICACION DE ESPECIF%'
                                    GROUP BY t1.IDREPORTE,t1.SIGLA,t1.DIA,t1.HORAIDENTIFICACION,T1.AREA,t1.FECHACREA,t1.DESCRIPCION,T1.CODIGOPRODUCCION,
                                    T1.NOESTIBAS,T1.ESTADODET,t2.NOMBRES,t2.APELLIDOS");
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return 0;
	}

	public function  mostrarVecedAjax($idreporte)
	{
		$json = array();$i = 0;
		$query = $this->db->where("IDREPORTE",$idreporte)->get("view_InformesPesoAcciones");
		if($query->num_rows() >	0)
		{
			foreach ($query->result_array() as $item)
			{
				$json[$i]["NUMERO"] = $item["NUMERO"];
				$json[$i]["PESOLIBRAS"] = number_format($item["PESOLIBRAS"],2);
				$json[$i]["TINTERNAPRODUCTO"] = $item["TINTERNAPRODUCTO"];
				$json[$i]["OBSERVACIONESACCION"] = $item["OBSERVACIONESACCION"];
				$json[$i]["ACCIONESCORRECTIVAS"] = $item["ACCIONESCORRECTIVAS"];
				$i++;
			}
			echo json_encode($json);
		}
	}

	public function guardarVeced($enc,$datos)
	{
		$this->db->trans_begin();

		date_default_timezone_set("America/Managua");
		$mensaje = array();
		$query = $this->db->query("SELECT * FROM Monitoreos WHERE cast(FECHAINICIO AS DATE) = CAST(getdate() AS DATE) AND
									 CAST(FECHAFIN AS DATE) = cast(getdate() AS DATE) AND ESTADO = 'A' ");
		if($query->num_rows() > 0)
		{
			$id = $this->db->query("SELECT ISNULL(MAX(IDREPORTE),0)+1 AS ID FROM Reportes");
			$encabezado = array(
			  "IDREPORTE" => $id->result_array()[0]["ID"],
		      "IDMONITOREO" => $enc[0],
		      "IDAREA" => $enc[1],
		      "VERSION" => $enc[2],
		      "NOMBRE" => $enc[3],
		      //"OBSERVACIONES" => $enc[4],
		      "NOESTIBAS" => $enc[4],
		      "CODIGOPRODUCCION" => $enc[5],
		      "FECHAINICIO" => gmdate(date("Y-m-d H:i:s")),
		      "FECHAFIN" => gmdate(date("Y-m-d H:i:s")),
		      "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
		      "IDUSUARIOCREA" => $this->session->userdata("id"),
			);
			$guardarEnc = $this->db->insert("Reportes",$encabezado);
			if($guardarEnc){
				$num = 1; $bandera = false; $bandera1 = false;
				$idreporte = $this->db->query("SELECT MAX(IDREPORTE) AS IDREPORTE FROM Reportes");
				for ($i=0; $i < count($datos); $i++) { 
					$array = explode(",",$datos[$i]);
					$idpeso = $this->db->query("SELECT ISNULL(MAX(IDPESO),0)+1 AS IDPESO FROM ReportesPeso");
					$idAccion = $this->db->query("SELECT ISNULL(MAX(IDACCION),0)+1 AS IDACCION FROM Acciones");
					$rpt = array(
						"IDPESO" => $idpeso->result_array()[0]["IDPESO"],
		                "IDREPORTE" => $idreporte->result_array()[0]["IDREPORTE"],
		                "ESTADO" => "A",
		                "NUMERO" => $num,
		                "HORA" => gmdate(date("H:i:s")),
		                "FECHAINGRESO" => $array[0],
		                "CODIGO" => $array[1],
		                "DESCRIPCION" => $array[2],
		                "PESOLIBRAS" => $array[3],
		                "TINTERNAPRODUCTO" => $array[4],
		                "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
		                "IDUSUARIOCREA" => $this->session->userdata("id")
				    );

					$acc = array(
						"IDACCION" => $idAccion->result_array()[0]["IDACCION"],
		                "IDREPORTE" => $idreporte->result_array()[0]["IDREPORTE"],
		                "NUMERO" => $num,
		                "ESTADO" => "A",
		                "HORA" => gmdate(date("H:i:s")),
		                "HORAIDENTIFICACION" => gmdate(date("H:i:s")),
		                "OBSERVACIONES" => $array[5],
		                "ACCIONESCORRECTIVAS" => $array[6]
					);

				    $num++;	
				    $guardarRpt = $this->db->insert("ReportesPeso",$rpt);

				    if($array[5] != ""){
				    	 $guardarRptAcciones = $this->db->insert("Acciones",$acc);
				    	 if($guardarRptAcciones){
				    	 	$bandera1 = true;
				    	 }
				    }
				   
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
				if($bandera1 != true){
						$mensaje[0]["mensaje"] = "Error al guardar los datos del informe COD(3_DET_ACCIONES)";
						$mensaje[0]["tipo"] = "error";
						echo json_encode($mensaje);
					}
			}else{
				$mensaje[0]["mensaje"] = "Error al guardar los datos COD(1_ENC)";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
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

    public function editarVeced($id)
    {
        $query = $this->db->where("IDREPORTE",$id)->get("view_InformesPesoAcciones");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

    public function actualizarVeced($enc,$datos)
    {
        $this->db->trans_begin();

        date_default_timezone_set("America/Managua");
        $mensaje = array();
        $this->db->where("IDREPORTE",$enc[0]);
            $encabezado = array(
                "IDREPORTE" => $enc[0],
                "IDMONITOREO" => $enc[1],
                "IDAREA" => $enc[2],
                "VERSION" => $enc[3],
                "NOMBRE" => $enc[4],
                //"OBSERVACIONES" => $enc[4],
                "NOESTIBAS" => $enc[5],
                "CODIGOPRODUCCION" => $enc[6],
                "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOEDITA" => $this->session->userdata("id"),
            );
            $guardarEnc = $this->db->update("Reportes",$encabezado);
            if($guardarEnc){
                /*$deleterpt =*/ $this->db->where("IDREPORTE",$enc[0])->delete("ReportesPeso");
                /*$deleteacc =*/ $this->db->where("IDREPORTE",$enc[0])->delete("Acciones");
                $num = 1; $bandera = false; $bandera1 = false;
                $idreporte = $enc[0];
                for ($i=0; $i < count($datos); $i++) {
                    $array = explode(",",$datos[$i]);
                    $idpeso = $this->db->query("SELECT ISNULL(MAX(IDPESO),0)+1 AS IDPESO FROM ReportesPeso");
                    $idAccion = $this->db->query("SELECT ISNULL(MAX(IDACCION),0)+1 AS IDACCION FROM Acciones");
                    $rpt = array(
                        "IDPESO" => $idpeso->result_array()[0]["IDPESO"],
                        "IDREPORTE" => $idreporte,
                        "ESTADO" => "A",
                        "NUMERO" => $num,
                        "HORA" => gmdate(date("H:i:s")),
                        "FECHAINGRESO" => $array[0],
                        "CODIGO" => $array[1],
                        "DESCRIPCION" => $array[2],
                        "PESOLIBRAS" => $array[3],
                        "TINTERNAPRODUCTO" => $array[4],
                        "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                        "IDUSUARIOCREA" => $this->session->userdata("id")
                    );

                    $acc = array(
                        "IDACCION" => $idAccion->result_array()[0]["IDACCION"],
                        "IDREPORTE" => $idreporte,
                        "NUMERO" => $num,
                        "ESTADO" => "A",
                        "HORA" => gmdate(date("H:i:s")),
                        "HORAIDENTIFICACION" => gmdate(date("H:i:s")),
                        "OBSERVACIONES" => $array[5],
                        "ACCIONESCORRECTIVAS" => $array[6]
                    );

                    $num++;
                    $guardarRpt = $this->db->insert("ReportesPeso",$rpt);

                    if($array[5] != ""){
                        $guardarRptAcciones = $this->db->insert("Acciones",$acc);
                        if($guardarRptAcciones){
                            $bandera1 = true;
                        }
                    }

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
                if($bandera1 != true){
                    $mensaje[0]["mensaje"] = "Error al guardar los datos del informe COD(3_DET_ACCIONES)";
                    $mensaje[0]["tipo"] = "error";
                    echo json_encode($mensaje);
                }
            }else{
                $mensaje[0]["mensaje"] = "Error al guardar los datos COD(1_ENC)";
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

	public function BajaAlta($id,$estado)
	{
		$mensaje = array(); $bandera = false;
		$this->db->where("IDREPORTE", $id);
		$data = array(
			"ESTADO" => $estado
		);
		$update = $this->db->update("ReportesPeso",$data);
		if($update){
			$bandera = true;
		}
		if($bandera){
			$this->db->where("IDREPORTE", $id);
			$dataAcc = array(
				"ESTADO" => $estado
			);
			$updateAcc = $this->db->update("Acciones",$dataAcc);
			if($updateAcc){
				$mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito.";
				$mensaje[0]["tipo"] = "success";
				echo json_encode($mensaje);
			}else{
				$mensaje[0]["mensaje"] = "Fallo en la operación.
			 Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador. COD(ACC)";
				$mensaje[0]["tipo"] = "error";
				echo json_encode($mensaje);
			}
		}else{
			$mensaje[0]["mensaje"] = "Fallo en la operación.
			 Ocurrió un error inesperado en el servidor, si el error persiste contáctece con el administrador. COD(RPT)";
			$mensaje[0]["tipo"] = "error";
			echo json_encode($mensaje);
		}
	}
}
