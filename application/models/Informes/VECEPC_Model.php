<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VECEPC_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set("America/Managua");
    }

    public function getVecepc($fecha1,$fecha2){
        $top_10 = "TOP 10"; $filtro = "";
        if($fecha1 != "" && $fecha2 != ""){
          $top_10 = "";
          $filtro = "
          WHERE t1.Fecha >= '".$fecha1."' AND t1.Fecha <= '".$fecha2."' ";
        }
        $query = $this->db->query("SELECT ".$top_10." t1.Consecutivo,t1.Fecha,t1.Estado,
        CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario,t3.AREA
        FROM dbo.Verificacion_Elaboracion AS t1 
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
                       <a class='btn btn-primary btn-xs' href='".base_url("index.php/getVecepcEdit/".$key["Consecutivo"]."")."'>
                           <i class='fa fa-pencil'></i>
                       </a>
                       <a class='btn btn-danger btn-xs' onclick='bajaVecepc(".'"'.$key["Consecutivo"].'","'.$key["Estado"].'"'.")' href='javascript:void(0)'>
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
                  <a  class='btn btn-danger btn-xs' onclick='bajaVecepc(".'"'.$key["Consecutivo"].'","'.$key["Estado"].'"'.")' href='javascript:void(0)'>
                      <i class='fa fa-refresh'></i>
                  </a>";
                }
                $i++; //onclick='DardeBaja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")'
            }
            echo json_encode($json);
        }
    }

    public function getVecepcAjax($consecutivo)
    {
        $json = array();
        $i = 0;
        $query = $this->db->query("SELECT t1.IdVerifiElab,t1.Consecutivo,t1.IdProducto,t1.ProdCocinado,t1.Presentacion,
                                    t1.HojaProceso,t1.CantBatch,t1.Lote,t1.PesoCarroProdEmb,t1.CantidadVarilla,t1.PesoProdEmb,
                                    t1.CantTotalPzasVarillas,t1.PesoPromedEmb,t1.PorcentMermaEmb,t1.PesoPromedioCocinado,
                                    t1.ProcentMermaCocinado,t1.PesoPromedioRefri,t1.PorcentMermaRefri,t1.PesoProdTerminado,
                                    t1.PorcentRendimiento,t1.PesoCarroVacioVarilla,t1.Fecha,t1.Estado,
                                    CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario,t3.AREA
                                    FROM dbo.Verificacion_Elaboracion AS t1 
                                    INNER JOIN dbo.Usuarios AS t2 ON t1.IdUsuario = t2.IDUSUARIO
                                    INNER JOIN dbo.Areas AS t3 ON t3.IDAREA = t1.IdArea
                                    WHERE t1.Consecutivo = ".$consecutivo." ");
        if($query->num_rows()>0){
            foreach ($query->result_array() as $key) {
                $json[$i]["IdProducto"] = $key["IdProducto"];
                $json[$i]["ProdCocinado"] = $key["ProdCocinado"];
                $json[$i]["Presentacion"] = $key["Presentacion"];
                $json[$i]["HojaProceso"] = $key["HojaProceso"];
                $json[$i]["CantBatch"] = $key["CantBatch"];
                $json[$i]["PesoProdTerminado"] = $key["PesoProdTerminado"];
                $json[$i]["PorcentRendimiento"] = $key["PorcentRendimiento"];
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function getVecepcEdit($consecutivo)
    {
        $query = $this->db->query("SELECT t1.*,
                                    CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario
                                    FROM dbo.Verificacion_Elaboracion AS t1 
                                    INNER JOIN dbo.Usuarios AS t2 ON t1.IdUsuario = t2.IDUSUARIO
                                    WHERE t1.Consecutivo = ".$consecutivo." ");
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return 0;
    }

    public function guardarVecepc($detalle){
        $det = json_decode($detalle, true);
        $bandera1 = false;
        $mensaje = array();
        $cons = $this->db->query("SELECT ISNULL(MAX(Consecutivo),0)+1 AS Consecutivo FROM Verificacion_Elaboracion");
        foreach ($det as $obj) {
            $idDet = $this->db->query("SELECT ISNULL(MAX(IdVerifiElab),0)+1 AS IdVerifiElab FROM Verificacion_Elaboracion");
            $insertDet = array(
                "IdVerifiElab" => $idDet->result_array()[0]["IdVerifiElab"],     
                "Consecutivo" => $cons->result_array()[0]["Consecutivo"],               
                "IdReporte" =>  $obj[0],
                "IdCatVersion" =>  $obj[1],
                "IdArea" =>  $obj[2],
                "IdUsuario" =>  $obj[3],
                "IdProducto" =>  $obj[4],
                "ProdCocinado" =>  $obj[5],
                "Presentacion" =>  $obj[6],
                "HojaProceso" =>  $obj[7],
                "CantBatch" =>  $obj[8],
                "PH" =>  $obj[9],
                "TemperaturaPasta" =>  $obj[10],
                "Lote" =>  $obj[11],
                "PesoCarroVacioVarilla" =>  $obj[12],
                "PesoCarroProdEmb" =>  $obj[13],
                "CantidadVarilla" =>  $obj[14],
                "PesoProdEmb" =>  $obj[15],
                "CantTotalPzasVarillas" =>  $obj[16],
                "PesoPromedEmb" =>  $obj[17],
                "PorcentMermaEmb" =>  $obj[18],
                "PesoCarroProdCocinado" =>  $obj[19],
                "PesoProdCocinado" =>  $obj[20],
                "PesoPromedioCocinado" =>  $obj[21],
                "ProcentMermaCocinado" =>  $obj[22],
                "PesoCarroProdRefri" =>  $obj[23],
                "PesoProdRefri" =>  $obj[24],
                "PesoPromedioRefri" =>  $obj[25],
                "PorcentMermaRefri" =>  $obj[26],
                "PesoProdTerminado" =>  $obj[27],
                "PorcentRendimiento" =>  $obj[28],
                "Fecha" => $obj[29],
                "Estado" => "A",
                "FechaCrea" => date("Y-m-d H:i:s"),
                "IdUsuarioCrea"  => $this->session->userdata("id")
            );
            $guardarDet = $this->db->insert("Verificacion_Elaboracion", $insertDet);
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

    public function actualizarVecepc($consecutivo,$detalle){
        $det = json_decode($detalle, true);
        $bandera1 = false;
        $mensaje = array();
        //$cons = $this->db->query("SELECT ISNULL(MAX(Consecutivo),0)+1 AS Consecutivo FROM Verificacion_Elaboracion");
        $delete = $this->db->where("Consecutivo", $consecutivo)->delete("Verificacion_Elaboracion");
        if($delete){
            foreach ($det as $obj) {
                $idDet = $this->db->query("SELECT ISNULL(MAX(IdVerifiElab),0)+1 AS IdVerifiElab FROM Verificacion_Elaboracion");
                $insertDet = array(
                    "IdVerifiElab" => $idDet->result_array()[0]["IdVerifiElab"],     
                    "Consecutivo" => $obj[30],               
                    "IdReporte" =>  $obj[0],
                    "IdCatVersion" =>  $obj[1],
                    "IdArea" =>  $obj[2],
                    "IdUsuario" =>  $obj[3],
                    "IdProducto" =>  $obj[4],
                    "ProdCocinado" =>  $obj[5],
                    "Presentacion" =>  $obj[6],
                    "HojaProceso" =>  $obj[7],
                    "CantBatch" =>  $obj[8],
                    "PH" =>  $obj[9],
                    "TemperaturaPasta" =>  $obj[10],
                    "Lote" =>  $obj[11],
                    "PesoCarroVacioVarilla" =>  $obj[12],
                    "PesoCarroProdEmb" =>  $obj[13],
                    "CantidadVarilla" =>  $obj[14],
                    "PesoProdEmb" =>  $obj[15],
                    "CantTotalPzasVarillas" =>  $obj[16],
                    "PesoPromedEmb" =>  $obj[17],
                    "PorcentMermaEmb" =>  $obj[18],
                    "PesoCarroProdCocinado" =>  $obj[19],
                    "PesoProdCocinado" =>  $obj[20],
                    "PesoPromedioCocinado" =>  $obj[21],
                    "ProcentMermaCocinado" =>  $obj[22],
                    "PesoCarroProdRefri" =>  $obj[23],
                    "PesoProdRefri" =>  $obj[24],
                    "PesoPromedioRefri" =>  $obj[25],
                    "PorcentMermaRefri" =>  $obj[26],
                    "PesoProdTerminado" =>  $obj[27],
                    "PorcentRendimiento" =>  $obj[28],
                    "Fecha" => $obj[29],
                    "Estado" => "A",
                    "FechaCrea" => date("Y-m-d H:i:s"),
                    "IdUsuarioCrea"  => $this->session->userdata("id")
                );
                $guardarDet = $this->db->insert("Verificacion_Elaboracion", $insertDet);
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
    
    public function bajaVecepc($consecutivo,$estado){
        $mensaje = array();
        $this->db->where("Consecutivo", $consecutivo);
        $datos = array(
            "Estado" => $estado,
            "FechaBaja" => date("Y-m-d H:i:s"),
            "IdUsuarioBaja" => $this->session->userdata("id")
        );
        $update = $this->db->update("Verificacion_Elaboracion",$datos);
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

/* End of file VECEPC_Model.php */