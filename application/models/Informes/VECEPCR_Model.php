<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VECEPCR_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set("America/Managua");
    }

    public function getVecepcr($fecha1,$fecha2){
        $top_10 = "TOP 10"; $filtro = "";
        if($fecha1 != "" && $fecha2 != ""){
          $top_10 = "";
          $filtro = "
          WHERE t1.Fecha >= '".$fecha1."' AND t1.Fecha <= '".$fecha2."' ";
        }
        $query = $this->db->query("SELECT ".$top_10." t1.Consecutivo,t1.Fecha,t1.Estado,
        CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario,t3.AREA
        FROM dbo.Verificacion_Elab_Crudos AS t1 
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
                       <a class='btn btn-primary btn-xs' href='".base_url("index.php/getVecepcrEdit/".$key["Consecutivo"]."")."'>
                           <i class='fa fa-pencil'></i>
                       </a>
                       <a class='btn btn-danger btn-xs' onclick='bajaVecepcr(".'"'.$key["Consecutivo"].'","'.$key["Estado"].'"'.")' href='javascript:void(0)'>
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
                  <a  class='btn btn-danger btn-xs' onclick='bajaVecepcr(".'"'.$key["Consecutivo"].'","'.$key["Estado"].'"'.")' href='javascript:void(0)'>
                      <i class='fa fa-refresh'></i>
                  </a>";
                }
                $i++; //onclick='DardeBaja(".'"'.$key["IDREPORTE"].'","'.$key["ESTADO"].'"'.")'
            }
            echo json_encode($json);
        }
    }

    public function getVecepcrAjax($consecutivo)
    {
        $json = array();
        $i = 0;
        $query = $this->db->query("SELECT
        CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario,t3.AREA,t1.IdVerifiElabCrudo,t1.Consecutivo,t1.IdProducto,t1.ProdCrudos,
        t1.Presentacion,t1.HojaProceso,t1.Lotes,t1.CantBatch,t1.PH,t1.TemperaturaPasta,t1.PesoCajillaVacia,t1.PesoPromUnidad,
        t1.CantidadTotalUnidades,t1.PorcentajeRendimiento,t1.PorcentajeMerma,t1.Observaciones,t1.Estado,t1.Fecha
        FROM dbo.Verificacion_Elab_Crudos AS t1
        INNER JOIN dbo.Usuarios AS t2 ON t1.IdUsuario = t2.IDUSUARIO
        INNER JOIN dbo.Areas AS t3 ON t3.IDAREA = t1.IdArea
        WHERE t1.Consecutivo = ".$consecutivo." ");
        
        if($query->num_rows()>0){
            foreach ($query->result_array() as $key) {
                $json[$i]["IdProducto"] = $key["IdProducto"];
                $json[$i]["ProdCrudos"] = $key["ProdCrudos"];
                $json[$i]["Presentacion"] = $key["Presentacion"];
                $json[$i]["HojaProceso"] = $key["HojaProceso"];
                $json[$i]["Lotes"] = $key["Lotes"];
                $json[$i]["CantBatch"] = $key["CantBatch"];
                $json[$i]["PorcentajeRendimiento"] = $key["PorcentajeRendimiento"];
                $json[$i]["PorcentajeMerma"] = $key["PorcentajeMerma"];
                $json[$i]["Observaciones"] = $key["Observaciones"];
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function getVecepcrEdit($consecutivo)
    {
        $query = $this->db->query("SELECT t1.*,
                                    CONCAT(t2.NOMBRES,' ',t2.APELLIDOS) AS Usuario
                                    FROM dbo.Verificacion_Elab_Crudos AS t1 
                                    INNER JOIN dbo.Usuarios AS t2 ON t1.IdUsuario = t2.IDUSUARIO
                                    WHERE t1.Consecutivo = ".$consecutivo." ");
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return 0;
    }

    public function guardarVecepcr($detalle){
        $det = json_decode($detalle, true);
        $bandera1 = false;
        $mensaje = array();
        $cons = $this->db->query("SELECT ISNULL(MAX(Consecutivo),0)+1 AS Consecutivo FROM Verificacion_Elab_Crudos");
        foreach ($det as $obj) {
            $idDet = $this->db->query("SELECT ISNULL(MAX(IdVerifiElabCrudo),0)+1 AS IdVerifiElabCrudo FROM Verificacion_Elab_Crudos");
            $insertDet = array(
                "IdVerifiElabCrudo" => $idDet->result_array()[0]["IdVerifiElabCrudo"],     
                "Consecutivo" => $cons->result_array()[0]["Consecutivo"],             
                "IdReporte" => $obj[0],
                "IdCatVersion" => $obj[1],
                "IdArea" => $obj[2],
                "IdUsuario" => $obj[3],
                "IdProducto" => $obj[4],
                "ProdCrudos" => $obj[5],
                "Presentacion" => $obj[6],
                "HojaProceso" => $obj[7],
                "Lotes" => $obj[8],
                "CantBatch" => $obj[9],
                "PH" => $obj[10],
                "TemperaturaPasta" => $obj[11],
                "PesoCajillaVacia" => $obj[12],
                "PesoPromUnidad" => $obj[13],
                "CantidadTotalUnidades" => $obj[14],
                "PorcentajeRendimiento" => $obj[15],
                "PorcentajeMerma" => $obj[16],
                "Observaciones" => $obj[17],
                "Fecha" => $obj[18],
                "Estado" => "A",
                "FechaCrea" => date("Y-m-d H:i:s"),
                "IdUsuarioCrea"  => $this->session->userdata("id")
            );
            $guardarDet = $this->db->insert("Verificacion_Elab_Crudos", $insertDet);
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

    public function actualizarVecepcr($consecutivo,$detalle){
        $det = json_decode($detalle, true);
        $bandera1 = false;
        $mensaje = array();
        //$cons = $this->db->query("SELECT ISNULL(MAX(Consecutivo),0)+1 AS Consecutivo FROM Verificacion_Elaboracion");
        $delete = $this->db->where("Consecutivo", $consecutivo)->delete("Verificacion_Elab_Crudos");
        if($delete){
            foreach ($det as $obj) {
                $idDet = $this->db->query("SELECT ISNULL(MAX(IdVerifiElabCrudo),0)+1 AS IdVerifiElabCrudo FROM Verificacion_Elab_Crudos");
                $insertDet = array(
                    "IdVerifiElabCrudo" => $idDet->result_array()[0]["IdVerifiElabCrudo"],     
                    "Consecutivo" =>  $obj[19],             
                    "IdReporte" => $obj[0],
                    "IdCatVersion" => $obj[1],
                    "IdArea" => $obj[2],
                    "IdUsuario" => $obj[3],
                    "IdProducto" => $obj[4],
                    "ProdCrudos" => $obj[5],
                    "Presentacion" => $obj[6],
                    "HojaProceso" => $obj[7],
                    "Lotes" => $obj[8],
                    "CantBatch" => $obj[9],
                    "PH" => $obj[10],
                    "TemperaturaPasta" => $obj[11],
                    "PesoCajillaVacia" => $obj[12],
                    "PesoPromUnidad" => $obj[13],
                    "CantidadTotalUnidades" => $obj[14],
                    "PorcentajeRendimiento" => $obj[15],
                    "PorcentajeMerma" => $obj[16],
                    "Observaciones" => $obj[17],
                    "Fecha" => $obj[18],
                    "Estado" => "A",
                    "FechaCrea" => date("Y-m-d H:i:s"),
                    "IdUsuarioCrea"  => $this->session->userdata("id")
                );
                $guardarDet = $this->db->insert("Verificacion_Elab_Crudos", $insertDet);
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
    
    public function bajaVecepcr($consecutivo,$estado){
        $mensaje = array();
        $this->db->where("Consecutivo", $consecutivo);
        $datos = array(
            "Estado" => $estado,
            "FechaBaja" => date("Y-m-d H:i:s"),
            "IdUsuarioBaja" => $this->session->userdata("id")
        );
        $update = $this->db->update("Verificacion_Elab_Crudos",$datos);
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