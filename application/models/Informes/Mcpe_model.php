<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 27/9/2019 11:33 2019
 * FileName: Mcpe_model.php
 */
class Mcpe_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMaquinas()
    {
        $query = $this->db->get("CatMaquinas");
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        return 0;
    }

    public function guardarMcpeVerificPeso($enc,$detalle)
    {
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array(); $bandera = false;
        $query = $this->db->query("SELECT * FROM Monitoreos WHERE cast(FECHAINICIO AS DATE) = CAST(getdate() AS DATE) AND
									 CAST(FECHAFIN AS DATE) = cast(getdate() AS DATE) AND ESTADO = 'A' ");
        if($query->num_rows() > 0){
            $id = $this->db->query("SELECT ISNULL(MAX(IDREPORTE),0)+1 AS ID FROM Reportes");
            $encabezado = array(
                "IDREPORTE" => $id->result_array()[0]["ID"],
                "IDMONITOREO" => $enc[0],
                "IDAREA" => 2,
                "VERSION" => $enc[1],
                "IDTIPOREPORTE" => 4,
                "NOMBRE" => $enc[2],
                "ESTADO" => "A",
                "FECHAINICIO" => gmdate($enc[3]),
                "FECHAFIN" => gmdate($enc[3]),
                "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOCREA" => $this->session->userdata("id"),
            );
            $guardarEnc = $this->db->insert("Reportes",$encabezado);
            if($guardarEnc){
                $bandera = true;
            }else{
                $mensaje[0]["mensaje"] = "Se produjo un error al guardar los datos. COD-1(ENC)";
                $mensaje[0]["tipo"] = "error";
                echo json_encode($mensaje);
            }
            if($bandera == true){
                $num = 1; $bandera1 = false;
                $idreporte = $this->db->query("SELECT MAX(IDREPORTE) AS IDREPORTE FROM Reportes");

                $det = json_decode($detalle,true);
                foreach($det as $obj){
                    $idpeso = $this->db->query("SELECT ISNULL(MAX(IDPESO),0)+1 AS IDPESO FROM ReportesPeso");
                    $insertdet = array(
                        "IDPESO" => $idpeso->result_array()[0]["IDPESO"],
                        "IDREPORTE" => $idreporte->result_array()[0]["IDREPORTE"],
                        "ESTADO" => "A",
                        "NUMERO" => $num,
                        "CODBASCULA" => $obj[0],
                        "HORA" => $obj[1],
                        "FECHAINGRESO" => $enc[3],
                        "UNIDADPESO" => $obj[2],
                        "PESOMASA" => $obj[3],
                        "PESOBASCULA" => $obj[4],
                        "DIFERENCIA" => $obj[5],
                        "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                        "IDUSUARIOCREA" => $this->session->userdata('id')
                    );
                    $num++;
                    $guardaDet = $this->db->insert("ReportesPeso",$insertdet);
                    if($guardaDet){
                        $bandera1 = true;
                    }
                }
                if($bandera1){
                    $mensaje[0]["mensaje"] = "Datos guardados con éxito";
                    $mensaje[0]["tipo"] = "success";
                    echo json_encode($mensaje);
                }else{
                    $mensaje[0]["mensaje"] = "Se produjo un error al guardar los datos. COD-2(DET)";
                    $mensaje[0]["tipo"] = "error";
                    echo json_encode($mensaje);
                }
            }
        }else{
            $mensaje[0]["mensaje"] = "No se pudo guardar el informe porque no exsite un codigo de monitoreo para la fecha ".date("d-m-Y")."";
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

    public function guardarMcpeVerificCaract($enc,$detalle)
    {
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array(); $bandera = false;
        $query = $this->db->query("SELECT * FROM Monitoreos WHERE cast(FECHAINICIO AS DATE) = CAST(getdate() AS DATE) AND
									 CAST(FECHAFIN AS DATE) = cast(getdate() AS DATE) AND ESTADO = 'A' ");
        if($query->num_rows() > 0){
            $id = $this->db->query("SELECT ISNULL(MAX(IDREPORTE),0)+1 AS ID FROM Reportes");
            $encabezado = array(
                "IDREPORTE" => $id->result_array()[0]["ID"],
                "IDMONITOREO" => $enc[0],
                "IDAREA" => 2,
                "VERSION" => $enc[1],
                "IDTIPOREPORTE" => 4,
                "NOMBRE" => $enc[2],
                "OBSERVACIONES" => $enc[3],
                "ESTADO" => "A",
                "FECHAINICIO" => gmdate($enc[4]),
                "FECHAFIN" => gmdate($enc[4]),
                "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOCREA" => $this->session->userdata("id"),
            );
            $guardarEnc = $this->db->insert("Reportes",$encabezado);
            if($guardarEnc){
                $bandera = true;
            }else{
                $mensaje[0]["mensaje"] = "Se produjo un error al guardar los datos. COD-1(ENC)";
                $mensaje[0]["tipo"] = "error";
                echo json_encode($mensaje);
            }
            if($bandera == true){
                $num = 1; $bandera1 = false;
                $idreporte = $this->db->query("SELECT MAX(IDREPORTE) AS IDREPORTE FROM Reportes");

                $det = json_decode($detalle,true);
                foreach($det as $obj){
                    $idpeso = $this->db->query("SELECT ISNULL(MAX(IDARTICULO),0)+1 AS IDARTICULO FROM ReportesArticulos");
                    $insertdet = array(
                        "IDARTICULO" => $idpeso->result_array()[0]["IDARTICULO"],
                        "IDREPORTE" => $idreporte->result_array()[0]["IDREPORTE"],
                        "NUMERO" => $num,
                        "ESTADO" => "A",
                        "CODIGO" => $obj[0],
                        "NOMBRE" => $obj[1],
                        "VACIO" => $obj[2],
                        "GRANEL" => $obj[3],
                        "LOTE" => $obj[4],
                        "FECHAVENCIMIENTO" => $obj[5],
                        "PRESENTACION" => $obj[6],
                        "UNIDADPRESENTACION" => $obj[7],
                        "CANTIDAD_MUESTRA" => $obj[8],
                        "PV" => $obj[9],
                        "MS" => $obj[10],
                        "MC" => $obj[11],
                        "TC" => $obj[13],
                        "IDMAQUINA" => $obj[12],
                        "OPERARIO" => $obj[14],
                        "DEFECTO" => $obj[15],
                        "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                        "IDUSUARIOCREA" => $this->session->userdata('id')
                    );
                    $num++;
                    $guardaDet = $this->db->insert("ReportesArticulos",$insertdet);
                    if($guardaDet){
                        $bandera1 = true;
                    }
                }
                if($bandera1){
                    $mensaje[0]["mensaje"] = "Datos guardados con éxito";
                    $mensaje[0]["tipo"] = "success";
                    echo json_encode($mensaje);
                }else{
                    $mensaje[0]["mensaje"] = "Se produjo un error al guardar los datos. COD-2(DET)";
                    $mensaje[0]["tipo"] = "error";
                    echo json_encode($mensaje);
                }
            }
        }else{
            $mensaje[0]["mensaje"] = "No se pudo guardar el informe porque no exsite un codigo de monitoreo para la fecha ".date("d-m-Y")."";
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

    public function getMcpePesoBascula()
    {
        $query = $this->db->query("SELECT IDREPORTE,SIGLA,VERSION,HORA,DIA,AREA,ESTADOENC AS ESTADO
                                  FROM view_InformesPeso
                                  where IDTIPOREPORTE = 4 
                                  --group by IDREPORTE,SIGLA,VERSION,HORA,DIA,AREA,ESTADOENC
                                  ORDER BY IDREPORTE DESC");
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return 0;
    }

    public function getMcpePesoBasculaAjax($idreporte)
    {
        $json = array(); $i = 0; $unidadpeso = '';
        $query = $this->db->where("IDREPORTE",$idreporte)->get("view_InformesPeso");
        if($query->num_rows()>0){
            foreach ($query->result_array() as $key) {
                switch ($key["UNIDADPESO"]){
                    case "Gramos":
                        $unidadpeso = "gr";
                        break;
                    case "Libras":
                        $unidadpeso = "lbs";
                        break;
                    default:
                        $unidadpeso = "Kg";
                        break;
                }
                $json[$i]["NUMERO"] = $key["NUMERO"];
                $json[$i]["CODBASCULA"] = $key["CODBASCULA"];
                $json[$i]["HORA"] = date_format(new DateTime($key["HORA"]), "H:i:s a");
                $json[$i]["UNIDADPESO"] = $unidadpeso;
                $json[$i]["PESOMASA"] = number_format($key["PESOMASA"],0);
                $json[$i]["PESOBASCULA"] = number_format($key["PESOBASCULA"],0);
                $json[$i]["DIFERENCIA"] = number_format($key["DIFERENCIA"],0);
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function getMcpeCaractCalidad()
    {
        $query = $this->db->query("SELECT  t1.IDREPORTE, t1.SIGLA, t1.VERSION, t1.DIA, t1.ESTADO,
                                    t1.OBSERVACIONES, t1.IDAREA, t1.IDTIPOREPORTE, t2.AREA
                                    FROM dbo.view_InformesArticulos AS t1 INNER JOIN
                                    dbo.Areas AS t2 ON t1.IDAREA = t2.IDAREA
                                    WHERE (t1.IDTIPOREPORTE = 4)
                                    /*GROUP BY t1.IDREPORTE, t1.SIGLA, t1.IDTIPOREPORTE, t1.VERSION,
                                    t1.DIA, t1.ESTADO, t1.OBSERVACIONES, t1.IDAREA, t2.AREA*/
                                    ORDER BY t1.IDREPORTE DESC");
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return 0;
    }

    public function getMcpeCaractCalidadAjax($idreporte)
    {
        $json = array(); $i = 0; $empaque = ''; $unidadPeso = '';
        $query = $this->db->query("select t1.*,t2.MAQUINA,t2.SIGLAS from ReportesArticulos t1
                                    inner join CatMaquinas t2 on t1.IDMAQUINA = t2.IDMAQUINA
                                    where t1.IDREPORTE = ".$idreporte." ");
        if($query->num_rows()>0){
            foreach ($query->result_array() as $key) {
                if($key["VACIO"] == 1){
                    $empaque = "Vacio";
                }elseif ($key["GRANEL"] == 1){
                    $empaque = "Granel";
                }

                switch ($key["UNIDADPRESENTACION"])
                {
                    case "Gramos":
                        $unidadPeso = "gr";
                        break;
                    case "Libras":
                        $unidadPeso = "lbs";
                        break;
                    case "KG":
                        $unidadPeso = "kg";
                        break;
                }

                $json[$i]["NUMERO"] = $key["NUMERO"];
                $json[$i]["CODIGO"] = $key["CODIGO"];
                $json[$i]["NOMBRE"] = $key["NOMBRE"];
                $json[$i]["TIPOEMPAQUE"] = $empaque;
                $json[$i]["LOTE"] = $key["LOTE"];
                $json[$i]["FECHAVENCIMIENTO"] = date_format(new DateTime($key["FECHAVENCIMIENTO"]),"Y-m-d")." (".$key["SIGLAS"].")";
                $json[$i]["PRESENTACION"] = number_format($key["PRESENTACION"],0)." ".$unidadPeso;
                $json[$i]["PV"] = number_format($key["PV"],0);
                $json[$i]["MS"] = number_format($key["MS"],0);
                $json[$i]["MC"] = number_format($key["MC"],0);
                $json[$i]["TC"] = number_format($key["TC"],0);
                $json[$i]["OPERARIO"] = $key["OPERARIO"];
                $json[$i]["DEFECTO"] = number_format($key["DEFECTO"],2);
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function darDeBaja($idreporte,$estado)
    {
        $mensaje = array(); $bandera = false;
        $this->db->where("IDREPORTE",$idreporte);
        $datos = array(
            "ESTADO" => $estado
        );
        $baja = $this->db->update("Reportes",$datos);
        if($baja){
            $bandera = true;
        }
        if($bandera){
            $mensaje[0]["mensaje"] = "La operación se llevo a cabo con éxito";
            $mensaje[0]["tipo"] = "success";
            echo json_encode($mensaje);
        }else{
            $mensaje[0]["mensaje"] = "Ocurrio un error inesperado en el servidor. Si el problema persiste contactece con el administrador";
            $mensaje[0]["tipo"] = "error";
            echo json_encode($mensaje);
        }
    }

    public function getMcpePesoBasculaById($idreporte)
    {
        $query = $this->db->where("IDREPORTE",$idreporte)->get("view_InformesPeso");
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return 0;
    }

    public function getMcpeCaractCalidadById($idreporte)
    {
        $query = $this->db->query("SELECT t1.*,t2.MAQUINA,t2.SIGLAS from view_InformesArticulos t1
                                    inner join CatMaquinas t2 on t1.IDMAQUINA = t2.IDMAQUINA
                                    where t1.IDREPORTE = ".$idreporte." ");
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return 0;
    }

    public function actualizarMcpeVerificPeso($enc,$detalle)
    {
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array(); $bandera = false;
        $query = $this->db->query("SELECT * FROM Reportes WHERE IDREPORTE = ".$enc[0]." ");
        if($query->num_rows() > 0){
            $this->db->where("IDREPORTE",$enc[0]);
            $encabezado = array(
                "VERSION" => $enc[1],
                "FECHAINICIO" => gmdate($enc[2]),
                "FECHAFIN" => gmdate($enc[2]),
                "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOEDITA" => $this->session->userdata("id"),
            );
            $guardarEnc = $this->db->update("Reportes",$encabezado);
            if($guardarEnc){
                $bandera = true;
            }else{
                $mensaje[0]["mensaje"] = "Se produjo un error al actualizar los datos. COD-1(ENC)";
                $mensaje[0]["tipo"] = "error";
                echo json_encode($mensaje);
            }
            if($bandera == true){
                $eliminar = $this->db->where("IDREPORTE",$enc[0])->delete("ReportesPeso");
                if($eliminar){
                    $num = 1; $bandera1 = false;
                    $det = json_decode($detalle,true);
                    foreach($det as $obj){
                        $idpeso = $this->db->query("SELECT ISNULL(MAX(IDPESO),0)+1 AS IDPESO FROM ReportesPeso");
                        $insertdet = array(
                            "IDPESO" => $idpeso->result_array()[0]["IDPESO"],
                            "IDREPORTE" => $enc[0],
                            "ESTADO" => "A",
                            "NUMERO" => $num,
                            "CODBASCULA" => $obj[0],
                            "HORA" => $obj[1],
                            "FECHAINGRESO" => $enc[2],
                            "UNIDADPESO" => $obj[2],
                            "PESOMASA" => $obj[3],
                            "PESOBASCULA" => $obj[4],
                            "DIFERENCIA" => $obj[5],
                            "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                            "IDUSUARIOCREA" => $this->session->userdata('id')
                        );
                        $num++;
                        $guardaDet = $this->db->insert("ReportesPeso",$insertdet);
                        if($guardaDet){
                            $bandera1 = true;
                        }
                    }
                    if($bandera1){
                        $mensaje[0]["mensaje"] = "Datos actualizados con éxito";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);
                    }else{
                        $mensaje[0]["mensaje"] = "Se produjo un error al actualizar los datos. COD-3(DET)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }
                else{
                    $mensaje[0]["mensaje"] = "Se produjo un error al actualizar los datos. COD-2(DET)";
                    $mensaje[0]["tipo"] = "error";
                    echo json_encode($mensaje);
                }
            }
        }else{
            $mensaje[0]["mensaje"] = "No se pudo actualizar el informe porque no exsite un codigo de monitoreo para la fecha ".date("d-m-Y")."";
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

    public function actualizarMcpeVerificCaract($enc,$detalle)
    {
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array(); $bandera = false;
        $query = $this->db->query("SELECT * FROM Reportes WHERE IDREPORTE = ".$enc[0]." ");
        if($query->num_rows() > 0){
            $this->db->where("IDREPORTE",$enc[0]);
            $encabezado = array(
                "VERSION" => $enc[1],
                "OBSERVACIONES" => $enc[2],
                "FECHAINICIO" => gmdate($enc[3]),
                "FECHAFIN" => gmdate($enc[3]),
                "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOEDITA" => $this->session->userdata("id"),
            );
            $guardarEnc = $this->db->update("Reportes",$encabezado);
            if($guardarEnc){
                $bandera = true;
            }else{
                $mensaje[0]["mensaje"] = "Se produjo un error al actualizar los datos. COD-1(ENC)";
                $mensaje[0]["tipo"] = "error";
                echo json_encode($mensaje);
            }
            if($bandera == true){
                $eliminar = $this->db->where("IDREPORTE",$enc[0])->delete("ReportesArticulos");
                if($eliminar){
                    $num = 1; $bandera1 = false;
                    $det = json_decode($detalle,true);
                    foreach($det as $obj){
                        $idpeso = $this->db->query("SELECT ISNULL(MAX(IDARTICULO),0)+1 AS IDARTICULO FROM ReportesArticulos");
                        $insertdet = array(
                            "IDARTICULO" => $idpeso->result_array()[0]["IDARTICULO"],
                            "IDREPORTE" => $enc[0],
                            "NUMERO" => $num,
                            "ESTADO" => "A",
                            "CODIGO" => $obj[0],
                            "NOMBRE" => $obj[1],
                            "VACIO" => $obj[2],
                            "GRANEL" => $obj[3],
                            "LOTE" => $obj[4],
                            "FECHAVENCIMIENTO" => $obj[5],
                            "PRESENTACION" => $obj[6],
                            "UNIDADPRESENTACION" => $obj[7],
                            "CANTIDAD_MUESTRA" => $obj[8],
                            "PV" => $obj[9],
                            "MS" => $obj[10],
                            "MC" => $obj[11],
                            "TC" => $obj[13],
                            "IDMAQUINA" => $obj[12],
                            "OPERARIO" => $obj[14],
                            "DEFECTO" => $obj[15],
                            "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                            "IDUSUARIOCREA" => $this->session->userdata('id')
                        );
                        $num++;
                        $guardaDet = $this->db->insert("ReportesArticulos",$insertdet);
                        if($guardaDet){
                            $bandera1 = true;
                        }
                    }
                    if($bandera1){
                        $mensaje[0]["mensaje"] = "Datos actualizados con éxito";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);
                    }else{
                        $mensaje[0]["mensaje"] = "Se produjo un error al actualizar los datos. COD-3(DET)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }else{
                    $mensaje[0]["mensaje"] = "Se produjo un error al actualizar los datos. COD-2(DET)";
                    $mensaje[0]["tipo"] = "error";
                    echo json_encode($mensaje);
                }
            }
        }else{
            $mensaje[0]["mensaje"] = "No se pudo actualizar el informe porque no exsite un codigo de monitoreo para la fecha ".date("d-m-Y")."";
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