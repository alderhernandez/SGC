<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 25/10/2019 11:29 2019
 * FileName: Mdtde_model.php
 */
class Mdtde_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAreas()
    {
        $query = $this->db->get("Areas");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

    public function getMdtde()
    {
        $query = $this->db->query("SELECT t1.IDREPORTE,t2.SIGLAS,t1.VERSION,t2.AREA,t1.ANIO,t1.MES,t1.SEMANA,t1.USUARIO,t1.ESTADO
                                   FROM dbo.view_InformesTemperatura AS t1 
                                   INNER JOIN dbo.Areas AS t2 on t1.IDAREA = t2.IDAREA
                                   WHERE t1.IDTIPOREPORTE = 13
                                   GROUP BY t1.IDREPORTE,t2.SIGLAS,t1.VERSION,t2.AREA,t1.ANIO,t1.MES,t1.SEMANA,t1.USUARIO,t1.ESTADO");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

    public function getMdtdeAjax($idreporte){
        $json = array(); $i = 0;
        $query = $this->db->where("IDREPORTE",$idreporte)->get("view_InformesTemperatura ");
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key) {
                $json[$i]["IdDetalle"] = $key["IDTEMPESTERILIZADOR"];
                $json[$i]["Dia"] = $key["DIA"];
                $json[$i]["Estado"] = $key["ESTADO"];
                $json[$i]["Toma"] = number_format($key["TOMA1"],0)." "."°f";
                $json[$i]["Toma2"] = number_format($key["TOMA2"],0)." "."°f";
                $json[$i]["Toma3"] = number_format($key["TOMA3"],0)." "."°f";
                $json[$i]["Toma4"] = number_format($key["TOMA4"],0)." "."°f";
                $json[$i]["Hora"] = date_format(new DateTime($key["HORATOMA1"]), "h:i");
                $json[$i]["Hora2"] = date_format(new DateTime($key["HORATOMA2"]), "h:i");
                $json[$i]["Hora3"] = date_format(new DateTime($key["HORATOMA3"]), "h:i");
                $json[$i]["Hora4"] = date_format(new DateTime($key["HORATOMA4"]), "h:i");
                $json[$i]["Observaciones"] = $key["OBSERVACIONES"];
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function guardarMdtde($enc,$detalle)
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
                "IDMONITOREO" => $query->result_array()[0]["IDMONITOREO"],
                "IDAREA" => $enc[0],
                "VERSION" => $enc[1],
                "IDTIPOREPORTE" => 13,
                "NOMBRE" => $enc[2],
                "LOTE" => $enc[3],
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
                $hra2 = '00:00'; $hra3 = '00:00'; $hra4 = '00:00';
                $idreporte = $this->db->query("SELECT MAX(IDREPORTE) AS IDREPORTE FROM Reportes");
                $det = json_decode($detalle,true);
                foreach($det as $obj){
                    $idtemp = $this->db->query("SELECT ISNULL(MAX(IDTEMPESTERILIZADOR),0)+1 AS IDTEMP FROM ReportesTemperaturas");
                    if($obj[3] != 0){
                        $hra2 = $obj[6];
                    }
                    if($obj[4] != 0){
                        $hra3 = $obj[6];
                    }
                    if($obj[5] != 0){
                        $hra4 = $obj[6];
                    }
                    $insertdet = array(
                        "IDTEMPESTERILIZADOR" => $idtemp->result_array()[0]["IDTEMP"],
                        "IDREPORTE" => $idreporte->result_array()[0]["IDREPORTE"],
                        "IDAREA" => $enc[0],
                        "ANIO" => gmdate(date("Y")),
                        "MES" => gmdate(date("m")),
                        "SEMANA" => $obj[0],
                        "DIA" => $obj[1],
                        "TOMA1" => $obj[2],
                        "TOMA2" => $obj[3],
                        "TOMA3" => $obj[4],
                        "TOMA4" => $obj[5],
                        "HORATOMA1" => $obj[6],
                        "HORATOMA2" => $hra2,
                        "HORATOMA3" => $hra3,
                        "HORATOMA4" => $hra4,
                        "OBSERVACIONES" => $obj[7],
                        "FECHACREA" => gmdate("Y-m-d H:i:s"),
                        "USUARIOCREA" => $this->session->userdata('id')

                    );
                    $num++;
                    $guardaDet = $this->db->insert("ReportesTemperaturas",$insertdet);
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

    public function bajaMdtde($idreporte,$estado){
        $mensaje = array();
        $this->db->where("IDREPORTE", $idreporte);
        $datos = array(
            "ESTADO" => $estado
        );
        $actualizar = $this->db->update("Reportes",$datos);
        if($actualizar){
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

    public function editarDetalle($id)
    {
       $query = $this->db->where("IDTEMPESTERILIZADOR",$id)->get("view_InformesTemperatura");
       if($query->num_rows() > 0){
           return $query->result_array();
       }
       return 0;
    }

    public function updateDetalle($detalle)
    {
        date_default_timezone_set("America/Managua");
        $mensaje = array(); $bandera = false;
        $det = json_decode($detalle,true);
        foreach($det as $obj){
            $query = $this->db->query("SELECT TOMA1,TOMA2,TOMA3,TOMA4,OBSERVACIONES FROM ReportesTemperaturas
            WHERE IDTEMPESTERILIZADOR = '".$obj[0]."' ");
            foreach ($query->result_array() as $item) {
                if($obj[1] != number_format($item["TOMA1"],0)){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "TOMA1" => $obj[1],
                        "HORATOMA1" => gmdate(date("H:i:s")),
                        "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                        "USUARIOEDITA" => $this->session->userdata('id'),
                    );
                    $upd = $this->db->update("ReportesTemperaturas",$data);
                    if($upd){
                        $bandera = true;
                    }
                    if($bandera){
                        $mensaje[0]["mensaje"] = "Datos actualizados";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);
                    }else{
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(1-tom1)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }
                if($obj[2] != number_format($item["TOMA2"],0)){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "TOMA2" => $obj[2],
                        "HORATOMA2" => gmdate(date("H:i:s")),
                        "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                        "USUARIOEDITA" => $this->session->userdata('id'),
                    );
                    $upd = $this->db->update("ReportesTemperaturas",$data);
                    if($upd){
                        $bandera = true;
                    }
                    if($bandera){
                        $mensaje[0]["mensaje"] = "Datos actualizados";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);
                    }else{
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(2-tom2)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }
                if($obj[3] != number_format($item["TOMA3"],0)){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "TOMA3" => $obj[3],
                        "HORATOMA3" => gmdate(date("H:i:s")),
                        "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                        "USUARIOEDITA" => $this->session->userdata('id'),
                    );
                    $upd = $this->db->update("ReportesTemperaturas",$data);
                    if($upd){
                        $bandera = true;
                    }
                    if($bandera){
                        $mensaje[0]["mensaje"] = "Datos actualizados";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);
                    }else{
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(3-tom3)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }
                if($obj[4] != number_format($item["TOMA4"],0)){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "TOMA4" => $obj[4],
                        "HORATOMA4" => gmdate(date("H:i:s")),
                        "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                        "USUARIOEDITA" => $this->session->userdata('id'),
                    );
                    $upd = $this->db->update("ReportesTemperaturas",$data);
                    if($upd){
                        $bandera = true;
                    }
                    if($bandera){
                        $mensaje[0]["mensaje"] = "Datos actualizados";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);
                    }else{
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(4-tom4)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }
                //
                if($obj[5] != $item["OBSERVACIONES"]){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "OBSERVACIONES" => $obj[5],
                        "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                        "USUARIOEDITA" => $this->session->userdata('id'),
                    );
                    $upd = $this->db->update("ReportesTemperaturas",$data);
                    if($upd){
                        $bandera = true;
                    }
                    if($bandera){
                        $mensaje[0]["mensaje"] = "Datos actualizados";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);
                    }else{
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(5-obs)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }
            }
        }
    }

    public function editarmdtde($id)
    {
        $query = $this->db->where("IDREPORTE",$id)->get("view_InformesTemperatura");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

    public function guardarMdtde1($enc,$detalle)
    {
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array(); $bandera = false;
            $this->db->where("IDREPORTE",$enc[0]);
            $encabezado = array(
                "IDAREA" => $enc[1],
                "VERSION" => $enc[2],
                "LOTE" => $enc[3],
                "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOCREA" => $this->session->userdata("id"),
            );
            $guardarEnc = $this->db->update("Reportes",$encabezado);
            if($guardarEnc){
                $bandera = true;
            }else{
                $mensaje[0]["mensaje"] = "Se produjo un error al guardar los datos. COD-1(ENC)";
                $mensaje[0]["tipo"] = "error";
                echo json_encode($mensaje);
            }
            if($bandera == true){
                $num = 1; $bandera1 = false;
                $hra1 = '00:00'; $hra2 = '00:00'; $hra3 = '00:00'; $hra4 = '00:00';
                $det = json_decode($detalle,true);
                foreach($det as $obj){
                    $idtemp = $this->db->query("SELECT ISNULL(MAX(IDTEMPESTERILIZADOR),0)+1 AS IDTEMP FROM ReportesTemperaturas");
                    if($obj[2] != 0){
                        $hra1 = $obj[6];
                    }
                    if($obj[3] != 0){
                        $hra2 = $obj[6];
                    }
                    if($obj[4] != 0){
                        $hra3 = $obj[6];
                    }
                    if($obj[5] != 0){
                        $hra4 = $obj[6];
                    }
                    $insertdet = array(
                        "IDTEMPESTERILIZADOR" => $idtemp->result_array()[0]["IDTEMP"],
                        "IDREPORTE" => $enc[0],
                        "IDAREA" => $enc[1],
                        "ANIO" => gmdate(date("Y")),
                        "MES" => gmdate(date("m")),
                        "SEMANA" => $obj[0],
                        "DIA" => $obj[1],
                        "TOMA1" => $obj[2],
                        "TOMA2" => $obj[3],
                        "TOMA3" => $obj[4],
                        "TOMA4" => $obj[5],
                        "HORATOMA1" => $hra1,
                        "HORATOMA2" => $hra2,
                        "HORATOMA3" => $hra3,
                        "HORATOMA4" => $hra4,
                        "OBSERVACIONES" => $obj[7],
                        "FECHACREA" => gmdate("Y-m-d H:i:s"),
                        "USUARIOCREA" => $this->session->userdata('id')

                    );
                    $num++;
                    $guardaDet = $this->db->insert("ReportesTemperaturas",$insertdet);
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