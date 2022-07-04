<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/11/2019 10:51 2019
 * FileName: Cdt_model.php
 */
class Cdt_model extends CI_Model
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

    public function getSalas()
    {
        $query = $this->db->get("CatSalas");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

    public function getCdt($fecha1,$fecha2)
    {
        $top_10 = "TOP 10"; $filtro = "";
        if($fecha1 != "" && $fecha2 != ""){
          $top_10 = "";
          $filtro = "AND t1.FECHAINICIO BETWEEN '".$fecha1."' AND '".$fecha2."' ";
        }
        $query = $this->db->query("SELECT ".$top_10." t1.IDREPORTE,t1.SIGLA,t1.VERSION,t1.FECHAINICIO,t1.USUARIO,t1.ESTADO
                                    FROM dbo.view_InformesTemperatura t1
                                    WHERE t1.IDTIPOREPORTE = 14
                                    ".$filtro."
                                    GROUP BY t1.IDREPORTE,t1.SIGLA,t1.VERSION,t1.FECHAINICIO,t1.USUARIO,t1.ESTADO");
        if($query->num_rows()>0){
            $i = 0; $json = array();
            foreach ($query->result_array() as $key) {
                $json["data"][$i]["IDREPORTE"] = $key["IDREPORTE"];
                $json["data"][$i]["SIGLA"] = $key["SIGLA"];
                $json["data"][$i]["VERSION"] = $key["VERSION"];
                $json["data"][$i]["FECHAINICIO"] = date_format(new DateTime($key["FECHAINICIO"]),"Y-m-d");
                $json["data"][$i]["USUARIO"] = $key["USUARIO"];
                if($key["ESTADO"] == "A"){
                      $json["data"][$i]["ESTADO"] = "<span class='text-success text-bold'>Activo</span>";
                      $json["data"][$i]["Acciones"] = "
                       <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
                           <i class='fa fa-eye'></i>
                       </a>
                       <a class='btn btn-primary btn-xs' href='".base_url("index.php/editarCdt/".$key["IDREPORTE"]."")."'>
                           <i class='fa fa-pencil'></i>
                       </a>
                       <a onclick='DardeBaja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
                           <i class='fa fa-trash'></i>
                       </a>";
                }else{
                  $json["data"][$i]["ESTADO"] = "<span class='text-danger text-bold'>Activo</span>";
                  $json["data"][$i]["Acciones"] = "
                  <a class='detalles btn btn-success btn-xs disabled' href='javascript:void(0)'>
                      <i class='fa fa-eye'></i>
                  </a>
                  <a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
                      <i class='fa fa-pencil'></i>
                  </a>
                  <a onclick='DardeBaja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")' class='btn btn-danger btn-xs' href='javascript:void(0)'>
                      <i class='fa fa-refresh'></i>
                  </a>";
                }
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function getCdtAjax($idreporte)
    {
        $json = array();
        $i = 0;
        $query = $this->db->query("SELECT dbo.view_InformesTemperatura.*, dbo.Areas.AREA
                                    FROM dbo.view_InformesTemperatura
                                    INNER JOIN dbo.Areas ON dbo.view_InformesTemperatura.IDAREA = dbo.Areas.IDAREA
                                    WHERE dbo.view_InformesTemperatura.IDREPORTE = ".$idreporte."
                                        UNION
                                    SELECT dbo.view_InformesTemperatura.*, dbo.CatSalas.NOMBRE AS NOMBRESALA
                                    FROM dbo.view_InformesTemperatura
                                    INNER JOIN dbo.CatSalas ON dbo.view_InformesTemperatura.IDSALA = dbo.CatSalas.IDCATSALA
                                    WHERE dbo.view_InformesTemperatura.IDREPORTE = ".$idreporte." ");
        if($query->num_rows()>0){
            foreach ($query->result_array() as $key) {
                $json[$i]["ID"] = $key["IDTEMPESTERILIZADOR"];
                $json[$i]["AREA"] = $key["AREA"];
                $json[$i]["TOMA1"] = number_format($key["TOMA1"],0)." ".$key["UMTOMA1"];
                $json[$i]["TOMA2"] = number_format($key["TOMA2"],0)." ".$key["UMTOMA2"];
                $json[$i]["TOMA3"] = number_format($key["TOMA3"],0)." ".$key["UMTOMA3"];
                $json[$i]["TOMA4"] = number_format($key["TOMA4"],0)." ".$key["UMTOMA4"];
                $json[$i]["HORATOMA1"] = $key["HORATOMA1"];
                $json[$i]["HORATOMA2"] = $key["HORATOMA2"];
                $json[$i]["HORATOMA3"] = $key["HORATOMA3"];
                $json[$i]["HORATOMA4"] = $key["HORATOMA4"];
                $json[$i]["OBSERVACIONES"] = $key["OBSERVACIONES"];
                $json[$i]["VERIFICACION"] = $key["VERIFICACION_AC"];
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function guardarCdt($enc,$detalle)
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
                "VERSION" => $enc[0],
                "IDTIPOREPORTE" => 14,
                "NOMBRE" => $enc[1],
                "LOTE" => $enc[2],
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
                $hra1 = '00:00'; $hra2 = '00:00'; $hra3 = '00:00'; $hra4 = '00:00';
                $area = null; $cuarto = null;
                $idreporte = $this->db->query("SELECT MAX(IDREPORTE) AS IDREPORTE FROM Reportes");
                $det = json_decode($detalle,true);
                foreach($det as $obj){
                    $idtemp = $this->db->query("SELECT ISNULL(MAX(IDTEMPESTERILIZADOR),0)+1 AS IDTEMP FROM ReportesTemperaturas");
                    if($obj[0] == "A"){
                        $area = $obj[1];
                    }else{
                        $area = null;
                    }
                    if($obj[0] == "C"){
                        $cuarto = $obj[1];
                    }else{
                        $cuarto = null;
                    }

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
                        "IDREPORTE" => $idreporte->result_array()[0]["IDREPORTE"],
                        "IDAREA" => $area,
                        "IDSALA" => $cuarto,
                        "ANIO" => gmdate(date("Y")),
                        "TOMA1" => $obj[2],
                        "TOMA2" => $obj[3],
                        "TOMA3" => $obj[4],
                        "TOMA4" => $obj[5],
                        "HORATOMA1" => $hra1,
                        "HORATOMA2" => $hra2,
                        "HORATOMA3" => $hra3,
                        "HORATOMA4" => $hra4,
                        "OBSERVACIONES" => $obj[7],
                        "VERIFICACION_AC" => $obj[8],
                        "UMTOMA1" => $obj[9],
                        "UMTOMA2" => $obj[10],
                        "UMTOMA3" => $obj[11],
                        "UMTOMA4" => $obj[12],
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

    public function bajaCdt($idreporte,$estado){
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
        $query = $this->db->query("SELECT dbo.view_InformesTemperatura.*, dbo.Areas.AREA
                                    FROM dbo.view_InformesTemperatura
                                    INNER JOIN dbo.Areas ON dbo.view_InformesTemperatura.IDAREA = dbo.Areas.IDAREA
                                    WHERE dbo.view_InformesTemperatura.IDTEMPESTERILIZADOR = ".$id."
                                        UNION
                                    SELECT dbo.view_InformesTemperatura.*, dbo.CatSalas.NOMBRE AS NOMBRESALA
                                    FROM dbo.view_InformesTemperatura
                                    INNER JOIN dbo.CatSalas ON dbo.view_InformesTemperatura.IDSALA = dbo.CatSalas.IDCATSALA
                                    WHERE dbo.view_InformesTemperatura.IDTEMPESTERILIZADOR = ".$id." ");
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
        $area = null; $cuarto = null;
        foreach($det as $obj){
            $query = $this->db->query("SELECT TOMA1,TOMA2,TOMA3,TOMA4,OBSERVACIONES,VERIFICACION_AC FROM ReportesTemperaturas
            WHERE IDTEMPESTERILIZADOR = '".$obj[0]."' ");
            foreach ($query->result_array() as $item) {
                if($obj[1] == "A"){
                    $area = $obj[2];
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "IDAREA" => $area,
                        "IDSALA" => null,
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
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(7)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }
                if($obj[1] == "C"){
                    $cuarto = $obj[2];
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "IDAREA" => null,
                        "IDSALA" => $cuarto,
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
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(7)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }
                if($obj[3] != number_format($item["TOMA1"],0)){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "TOMA1" => $obj[3],
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
                if($obj[4] != number_format($item["TOMA2"],0)){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "TOMA2" => $obj[4],
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
                if($obj[5] != number_format($item["TOMA3"],0)){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "TOMA3" => $obj[5],
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
                if($obj[6] != number_format($item["TOMA4"],0)){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "TOMA4" => $obj[6],
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
                if($obj[7] != $item["OBSERVACIONES"]){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "OBSERVACIONES" => $obj[7],
                        "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                        "USUARIOEDITA" => $this->session->userdata('id'),
                    );
                    $upd = $this->db->update("ReportesTemperaturas",$data);
                    if($upd){
                        $bandera = true;
                    }
                    if($bandera){
                       /* $mensaje[0]["mensaje"] = "Datos actualizados";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);*/
                    }else{
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(5-obs)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }

                if($obj[8] != $item["VERIFICACION_AC"]){
                    $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                    $data = array(
                        "VERIFICACION_AC" => $obj[8],
                        "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                        "USUARIOEDITA" => $this->session->userdata('id'),
                    );
                    $upd = $this->db->update("ReportesTemperaturas",$data);
                    if($upd){
                        $bandera = true;
                    }
                    if($bandera){
                        /*$mensaje[0]["mensaje"] = "Datos actualizados";
                        $mensaje[0]["tipo"] = "success";
                        echo json_encode($mensaje);*/
                    }else{
                        $mensaje[0]["mensaje"] = "Error al actualizar los datos. Error Cod(6-verif_ac)";
                        $mensaje[0]["tipo"] = "error";
                        echo json_encode($mensaje);
                    }
                }

                $this->db->where("IDTEMPESTERILIZADOR",$obj[0]);
                $data = array(
                    "UMTOMA1" => $obj[9],
                    "UMTOMA2" => $obj[10],
                    "UMTOMA3" => $obj[11],
                    "UMTOMA4" => $obj[12],
                    "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                    "USUARIOEDITA" => $this->session->userdata('id'),
                );
                $upd = $this->db->update("ReportesTemperaturas",$data);
            }
        }
    }

    public function editarCdt($id)
    {
        $query = $this->db->query("SELECT dbo.view_InformesTemperatura.*, dbo.Areas.AREA
                                    FROM dbo.view_InformesTemperatura
                                    INNER JOIN dbo.Areas ON dbo.view_InformesTemperatura.IDAREA = dbo.Areas.IDAREA
                                    WHERE dbo.view_InformesTemperatura.IDREPORTE = ".$id."
                                        UNION
                                    SELECT dbo.view_InformesTemperatura.*, dbo.CatSalas.NOMBRE AS NOMBRESALA
                                    FROM dbo.view_InformesTemperatura
                                    INNER JOIN dbo.CatSalas ON dbo.view_InformesTemperatura.IDSALA = dbo.CatSalas.IDCATSALA
                                    WHERE dbo.view_InformesTemperatura.IDREPORTE = ".$id." ");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

    public function guardarCdt1($enc,$detalle)
    {
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array(); $bandera = false;
           $this->db->where("IDREPORTE",$enc[0]);
            $encabezado = array(
                "VERSION" => $enc[1],
                "LOTE" => $enc[2],
                "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOEDITA" => $this->session->userdata("id"),
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
                $area = null; $cuarto = null;
                $det = json_decode($detalle,true);
                foreach($det as $obj){
                    $idtemp = $this->db->query("SELECT ISNULL(MAX(IDTEMPESTERILIZADOR),0)+1 AS IDTEMP FROM ReportesTemperaturas");
                    if($obj[0] == "A"){
                        $area = $obj[1];
                    }else{
                        $area = null;
                    }
                    if($obj[0] == "C"){
                        $cuarto = $obj[1];
                    }else{
                        $cuarto = null;
                    }

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
                        "IDAREA" => $area,
                        "IDSALA" => $cuarto,
                        "ANIO" => gmdate(date("Y")),
                        "TOMA1" => $obj[2],
                        "TOMA2" => $obj[3],
                        "TOMA3" => $obj[4],
                        "TOMA4" => $obj[5],
                        "HORATOMA1" => $hra1,
                        "HORATOMA2" => $hra2,
                        "HORATOMA3" => $hra3,
                        "HORATOMA4" => $hra4,
                        "UMTOMA1" => $obj[9],
                        "UMTOMA2" => $obj[10],
                        "UMTOMA3" => $obj[11],
                        "UMTOMA4" => $obj[12],
                        "OBSERVACIONES" => $obj[7],
                        "VERIFICACION_AC" => $obj[8],
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
