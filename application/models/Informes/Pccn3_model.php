<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/9/2019 14:17 2019
 * FileName: Pccn3_model.php
 */
class Pccn3_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function mostrarPccn3()
    {
        $query = $this->db->query(" SELECT t1.IDREPORTE,t1.SIGLA,t1.DIA,t1.HORAIDENTIFICACION,t1.FECHAINICIO, 
         concat(t2.NOMBRES,' ',t2.APELLIDOS) AS USUARIO,t1.ESTADO
         FROM view_InformesArticulosAcciones t1
         INNER JOIN Usuarios t2 on t1.IDUSUARIOCREA = t2.IDUSUARIO
         WHERE t1.NOMBRE LIKE '%MONITOREO DE ESTERILIZACION PCC N° 3%'
         GROUP BY  t1.IDREPORTE,t1.SIGLA,t1.DIA,t1.HORAIDENTIFICACION,
         t1.FECHAINICIO,t2.NOMBRES,t2.APELLIDOS,t1.ESTADO");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

    public function mostrarPccn3Ajax($idreporte)
    {
        $json = array(); $i = 0;
        $query = $this->db->query("SELECT IDREPORTE,NOMBREDET,CODIGOPRODUCCION,HORAENTRADA,HORASALIDA,
        TC,TIEMPO,OBSERVACIONES,ACCIONESCORRECTIVAS
        FROM view_InformesArticulosAcciones
        WHERE IDREPORTE = '".$idreporte."' ");
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $item) {
                $json[$i]["PRODUCTO"] = $item["NOMBREDET"];
                $json[$i]["CODIGO"] = $item["CODIGOPRODUCCION"];
                $json[$i]["HORAENTRADA"] = date_format(new DateTime($item["HORAENTRADA"]),"H:i");
                $json[$i]["HORASALIDA"] = date_format(new DateTime($item["HORASALIDA"]),"H:i");
                $json[$i]["TC"] = number_format($item["TC"],2);
                $json[$i]["TIEMPO"] = strval($item["TIEMPO"]);
                $json[$i]["OBSERVACIONES"] = $item["OBSERVACIONES"];
                $json[$i]["ACCIONESCORRECTIVAS"] = $item["ACCIONESCORRECTIVAS"];
                $i++;
            }
            echo json_encode($json);
        }
    }

    public function guardarPccn3($enc,$datos)
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
                "VERSION" => $enc[1],
                "NOMBRE" => $enc[2],
                "CODIGOPRODUCCION" => $enc[3],
                "FECHAINICIO" => gmdate($enc[4]),
                "FECHAFIN" => gmdate($enc[4]),
                "ESTADO" => "A",
                "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOCREA" => $this->session->userdata("id")
            );
            $guardarEnc = $this->db->insert("Reportes",$encabezado);
            if($guardarEnc){
                $num = 1; $bandera = false; $bandera1 = false;
                $idreporte = $this->db->query("SELECT MAX(IDREPORTE) AS IDREPORTE FROM Reportes");
                for ($i=0; $i < count($datos); $i++) {
                    $array = explode(",",$datos[$i]);
                    $idArticulo = $this->db->query("SELECT ISNULL(MAX(IDARTICULO),0)+1 AS IDARTICULO FROM ReportesArticulos");
                    $idAccion = $this->db->query("SELECT ISNULL(MAX(IDACCION),0)+1 AS IDACCION FROM Acciones");
                    $rpt = array(
                        "IDARTICULO" => $idArticulo->result_array()[0]["IDARTICULO"],
                        "IDREPORTE" => $idreporte->result_array()[0]["IDREPORTE"],
                        "NUMERO" => $num,
                        "ESTADO" => "A",
                        "CODIGO" => $array[0],
                        "NOMBRE" => $array[1],
                        "HORAENTRADA" => gmdate(date_format(new DateTime($array[2]), "H:i")),
                        "HORASALIDA" => gmdate(date_format(new DateTime($array[3]),"H:i")),
                        "TC" => $array[4],
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
                    $guardarRpt = $this->db->insert("ReportesArticulos",$rpt);

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

    public function BajaAlta($idreporte,$estado)
    {
        $mensaje = array();
        $this->db->where("IDREPORTE", $idreporte);
        $datos = array(
            "ESTADO" => $estado
           /* "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
            "IDUSUARIOEDITA" => $this->session->userdata('id')*/
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

    public function editarPccn3($idreporte)
    {
         $query = $this->db->where("IDREPORTE",$idreporte)->get("view_InformesArticulosAcciones");
         if($query->num_rows() > 0){
             return $query->result_array();
         }
         return 0;
    }

    public function actualizarPccn3($enc,$datos)
    {
        $this->db->trans_begin();

        date_default_timezone_set("America/Managua");
        $mensaje = array();
            $this->db->where("IDREPORTE",$enc[0]);
            $encabezado = array(
                "IDREPORTE" => $enc[0],
                "IDMONITOREO" => $enc[1],
                "VERSION" => $enc[2],
                "NOMBRE" => $enc[3],
                "CODIGOPRODUCCION" => $enc[4],
                "FECHAINICIO" => gmdate($enc[5]),
                "FECHAFIN" => gmdate($enc[5]),
                "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                "IDUSUARIOEDITA" => $this->session->userdata("id")
            );
            $guardarEnc = $this->db->update("Reportes",$encabezado);
            if($guardarEnc){
                //Eliminar datos de la tabla detalles
                $this->db->where("IDREPORTE",$enc[0])->delete("ReportesArticulos");
                $this->db->where("IDREPORTE",$enc[0])->delete("Acciones");

                $num = 1; $bandera = false; $bandera1 = false;
                $idreporte = $enc[0];
                for ($i=0; $i < count($datos); $i++) {
                    $array = explode(",",$datos[$i]);
                    $idArticulo = $this->db->query("SELECT ISNULL(MAX(IDARTICULO),0)+1 AS IDARTICULO FROM ReportesArticulos");
                    $idAccion = $this->db->query("SELECT ISNULL(MAX(IDACCION),0)+1 AS IDACCION FROM Acciones");
                    $rpt = array(
                        "IDARTICULO" => $idArticulo->result_array()[0]["IDARTICULO"],
                        "IDREPORTE" => $idreporte,
                        "NUMERO" => $num,
                        "ESTADO" => "A",
                        "CODIGO" => $array[0],
                        "NOMBRE" => $array[1],
                        "HORAENTRADA" => gmdate(date_format(new DateTime($array[2]), "H:i")),
                        "HORASALIDA" => gmdate(date_format(new DateTime($array[3]),"H:i")),
                        "TC" => $array[4],
                        "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
                        "IDUSUARIOCREA" => $this->session->userdata("id"),
                        "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
                        "IDUSUARIOEDITA" => $this->session->userdata("id")
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
                    $guardarRpt = $this->db->insert("ReportesArticulos",$rpt);

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
}