<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CDHA_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set("America/Managua");
    }

    
    public function guardarCdha($detalle){
        $det = json_decode($detalle, true);
        $bandera1 = false;
        $mensaje = array();
        $cons = $this->db->query("SELECT ISNULL(MAX(Consecutivo),0)+1 AS Consecutivo FROM Verificacion_Horno_Ahumados");
        foreach ($det as $obj) {
            $idDet = $this->db->query("SELECT ISNULL(MAX(IdVerifiElabHorno),0)+1 AS IdVerifiElabHorno FROM Verificacion_Horno_Ahumados");
            $insertDet = array(  
                "IdVerifiElabHorno" => $idDet->result_array()[0]["IdVerifiElabHorno"],
                "Consecutivo" => $cons->result_array()[0]["Consecutivo"],
                "IdReporte" => $obj[0],
                "IdCatVersion" => $obj[1],
                "IdArea" => $obj[2],
                "IdUsuario" => $obj[3],
                "IdProducto" => $obj[4],
                "ProdCocinados" => $obj[5],
                "Presentacion" => $obj[6],
                "HojaProceso" => $obj[7],
                "Lotes" => $obj[8],
                "CantBatch" => $obj[9],
                "PesoCarroVacio" => $obj[10],
                "PesoCarroProdCrudo" => $obj[11],
                "PesoProdCrudo" => $obj[12],
                "PesoBugi" => $obj[13],
                "PesoProdCocinadoBugi" => $obj[14],
                "TotalPiezasCocinada" => $obj[15],
                "TotalPiezasPorProd" => $obj[16],
                "PorcentajeMermaCocinado" => $obj[17],
                "PesoCarroProdCongelado" => $obj[18],
                "PesoProdRefrigerado" => $obj[19],
                "PorcentajeMermaRefrigeracion" => $obj[20],
                "MermaTotal" => $obj[21],
                "TotalRecorte" => $obj[22],
                "PesoProdTerminado" => $obj[23],
                "PorcentajeRend" => $obj[24],
                "Observaciones" => $obj[25],
                "Fecha" => $obj[26],
                "Estado" => "A",
                "FechaCrea" => date("Y-m-d H:i:s"),
                "IdUsuarioCrea"  => $this->session->userdata("id")
            );
            $guardarDet = $this->db->insert("Verificacion_Horno_Ahumados", $insertDet);
            if ($guardarDet) {
                $bandera1 = true;
            }
        }
        if ($bandera1) {
            $mensaje[0]["mensaje"] = "Datos guardados con éxito";
            $mensaje[0]["tipo"] = "success";
            echo json_encode($mensaje);
        } else {
            $mensaje[0]["mensaje"] = "Se produjo un error al guardar los datos. COD-2(DET)";
            $mensaje[0]["tipo"] = "error";
            echo json_encode($mensaje);
        }
    }

    public function getCdha($fecha1,$fecha2){
        $top_10 = "TOP 10"; $filtro = "";
        if($fecha1 != "" && $fecha2 != ""){
          $top_10 = "";
          $filtro = "
          WHERE t1.Fecha >= '".$fecha1."' AND t1.Fecha <= '".$fecha2."' ";
        }
        $query = $this->db->query("SELECT ".$top_10." t1.Consecutivo,t1.Fecha,t1.Estado,
        CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario,t3.AREA
        FROM dbo.Verificacion_Horno_Ahumados AS t1 
        INNER JOIN dbo.Usuarios AS t2 ON t1.IdUsuario = t2.IDUSUARIO
        INNER JOIN dbo.Areas AS t3 ON t3.IDAREA = t1.IdArea
        ".$filtro."
        group by t1.Consecutivo,t1.Fecha,t1.Estado,t2.NOMBRES,t2.APELLIDOS,t3.AREA");
        if($query->num_rows()>0){
            $i = 0; $json = array();
            foreach ($query->result_array() as $key) {
                //$json["data"][$i]["IDREPORTE"] = $key["IDREPORTE"];
                $json["data"][$i]["Consecutivo"] =  $key["Consecutivo"];
                $json["data"][$i]["Fecha"] =  $key["Fecha"];
                $json["data"][$i]["Usuario"] =  $key["Usuario"];
                $json["data"][$i]["AREA"] =  $key["AREA"];
                
                if($key["Estado"] == 'A'){
                      $json["data"][$i]["Estado"] = "<span class='text-success text-bold'>Activo</span>";
                      $json["data"][$i]["Acciones"] = "
                       <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
                           <i class='fa fa-eye'></i>
                       </a>
                       <a class='btn btn-primary btn-xs' href='".base_url("index.php/getCdhaEdit/".$key["Consecutivo"]."")."'>
                           <i class='fa fa-pencil'></i>
                       </a>
                       <a class='btn btn-danger btn-xs' onclick='bajaCdha(".'"'.$key["Consecutivo"].'","'.$key["Estado"].'"'.")' href='javascript:void(0)'>
                           <i class='fa fa-trash'></i>
                       </a>"; //".base_url("index.php/getVecepcEdit/".$key["Consecutivo"]."")."
                }else{
                  $json["data"][$i]["Estado"] = "<span class='text-danger text-bold'>Inactivo</span>";
                  $json["data"][$i]["Acciones"] = "
                  <a class='detalles btn btn-success btn-xs' href='javascript:void(0)'>
                      <i class='fa fa-eye'></i>
                  </a>
                  <a class='btn btn-primary btn-xs disabled' href='javascript:void(0)'>
                      <i class='fa fa-pencil'></i>
                  </a>
                  <a  class='btn btn-danger btn-xs' onclick='bajaCdha(".'"'.$key["Consecutivo"].'","'.$key["Estado"].'"'.")' href='javascript:void(0)'>
                      <i class='fa fa-refresh'></i>
                  </a>";
                }
                $i++; //onclick='DardeBaja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")'
            }
            echo json_encode($json);
        }
    }

    public function getDetCdhaAjax($consecutivo)
    {
        $json = array();
        $i = 0;
        $query = $this->db->query("SELECT t1.IdVerifiElabHorno,t1.Consecutivo,t1.IdProducto,t1.ProdCocinados,t1.Presentacion,
                                    t1.HojaProceso,t1.CantBatch,t1.Lotes,t1.PesoProdTerminado,
                                    t1.PorcentajeRend,t1.Fecha,t1.Estado,
                                    CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario,t3.AREA
                                    FROM dbo.Verificacion_Horno_Ahumados AS t1 
                                    INNER JOIN dbo.Usuarios AS t2 ON t1.IdUsuario = t2.IDUSUARIO
                                    INNER JOIN dbo.Areas AS t3 ON t3.IDAREA = t1.IdArea
                                    WHERE t1.Consecutivo = ".$consecutivo." ");
        if($query->num_rows()>0){
            foreach ($query->result_array() as $key) {
                $json[$i]["IdProducto"] = $key["IdProducto"];
                $json[$i]["ProdCocinado"] = $key["ProdCocinados"];
                $json[$i]["Presentacion"] = $key["Presentacion"];
                $json[$i]["HojaProceso"] = $key["HojaProceso"];
                $json[$i]["CantBatch"] = $key["CantBatch"];
                $json[$i]["PesoProdTerminado"] = $key["PesoProdTerminado"];
                $json[$i]["PorcentRendimiento"] = $key["PorcentajeRend"];
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function getCdhaEdit($consecutivo)
    {
        $query = $this->db->query("SELECT t1.*,
                                    CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario
                                    FROM dbo.Verificacion_Horno_Ahumados AS t1 
                                    INNER JOIN dbo.Usuarios AS t2 ON t1.IdUsuario = t2.IDUSUARIO
                                    WHERE t1.Consecutivo = ".$consecutivo." ");
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return 0;
    }


    public function actualizarCdha($consecutivo,$detalle){
        $det = json_decode($detalle, true);
        $bandera1 = false;
        $mensaje = array();
        //$cons = $this->db->query("SELECT ISNULL(MAX(Consecutivo),0)+1 AS Consecutivo FROM Verificacion_Elaboracion");
        $delete = $this->db->where("Consecutivo", $consecutivo)->delete("Verificacion_Horno_Ahumados");
        if($delete){
            foreach ($det as $obj) {
                $idDet = $this->db->query("SELECT ISNULL(MAX(IdVerifiElabHorno),0)+1 AS IdVerifiElabHorno FROM Verificacion_Horno_Ahumados");
                $insertDet = array(
                    "IdVerifiElabHorno" => $idDet->result_array()[0]["IdVerifiElabHorno"],     
                    "Consecutivo" => $obj[27],               
                    "IdReporte" => $obj[0],
                    "IdCatVersion" => $obj[1],
                    "IdArea" => $obj[2],
                    "IdUsuario" => $obj[3],
                    "IdProducto" => $obj[4],
                    "ProdCocinados" => $obj[5],
                    "Presentacion" => $obj[6],
                    "HojaProceso" => $obj[7],
                    "Lotes" => $obj[8],
                    "CantBatch" => $obj[9],
                    "PesoCarroVacio" => $obj[10],
                    "PesoCarroProdCrudo" => $obj[11],
                    "PesoProdCrudo" => $obj[12],
                    "PesoBugi" => $obj[13],
                    "PesoProdCocinadoBugi" => $obj[14],
                    "TotalPiezasCocinada" => $obj[15],
                    "TotalPiezasPorProd" => $obj[16],
                    "PorcentajeMermaCocinado" => $obj[17],
                    "PesoCarroProdCongelado" => $obj[18],
                    "PesoProdRefrigerado" => $obj[19],
                    "PorcentajeMermaRefrigeracion" => $obj[20],
                    "MermaTotal" => $obj[21],
                    "TotalRecorte" => $obj[22],
                    "PesoProdTerminado" => $obj[23],
                    "PorcentajeRend" => $obj[24],
                    "Observaciones" => $obj[25],
                    "Fecha" => $obj[26],
                    "Estado" => "A",
                    "FechaCrea" => date("Y-m-d H:i:s"),
                    "IdUsuarioCrea"  => $this->session->userdata("id")
                );
                $guardarDet = $this->db->insert("Verificacion_Horno_Ahumados", $insertDet);
                if ($guardarDet) {
                    $bandera1 = true;
                }
            }
        }else{
            $mensaje[0]["mensaje"] = "Error al intentar actualizar los datos Cod-1(DEL)";
            $mensaje[0]["tipo"] = "error";
            echo json_encode($mensaje);
        }
        if ($bandera1) {
            $mensaje[0]["mensaje"] = "Datos guardados con éxito";
            $mensaje[0]["tipo"] = "success";
            echo json_encode($mensaje);
        } else {
            $mensaje[0]["mensaje"] = "Se produjo un error al guardar los datos. COD-2(DET)";
            $mensaje[0]["tipo"] = "error";
            echo json_encode($mensaje);
        }
    }

    public function bajaCdha($consecutivo,$estado){
        $mensaje = array();
        $this->db->where("Consecutivo", $consecutivo);
        $datos = array(
            "Estado" => $estado,
            "FechaBaja" => date("Y-m-d H:i:s"),
            "IdUsuarioBaja" => $this->session->userdata("id")
        );
        $update = $this->db->update("Verificacion_Horno_Ahumados",$datos);
        if ($update) {
            $mensaje[0]["mensaje"] = "Datos actualizados con exito";
            $mensaje[0]["tipo"] = "success";
            echo json_encode($mensaje);
        } else{
            $mensaje[0]["mensaje"] = "Se produjo un error al actualizar los datos. Pongase en contacto con el administrador";
            $mensaje[0]["tipo"] = "error";
            echo json_encode($mensaje);
        }
    }

}

/* End of file CDHA_Model.php */


?>