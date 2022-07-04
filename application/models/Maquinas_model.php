<?php

use mysql_xdevapi\CollectionAdd;

/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 1/10/2019 16:36 2019
 * FileName: Maquinas_model.php
 */
class Maquinas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMaquinas()
    {
        $query = $this->db->get("CatMaquinas");
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }

    public function guardarMaquina($maquina,$siglas)
    {
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array();
        $id = $this->db->query("select MAX(ISNULL(IDMAQUINA,0)+1) as IDMAQUINA from CatMaquinas");
        $datos = array(
            "IDMAQUINA" => $id->result_array()[0]["IDMAQUINA"],
            "MAQUINA" => $maquina,
            "SIGLAS" => $siglas,
            "FECHACREA" => gmdate(date("Y-m-d H:i:s")),
            "USUARIOCREA" => $this->session->userdata("id"),
            "ESTADO" => "A"
        );
        $guardar = $this->db->insert("CatMaquinas",$datos);
        if($guardar){
            $mensaje[0]["mensaje"] = "Datos almacenados con éxito";
            $mensaje[0]["tipo"] = "success";
            echo json_encode($mensaje);
        }else{
            $mensaje[0]["mensaje"] = "Error al almacenar los datos. Ocurrió un error inesperado en el servidor,
             si el problema persiste contáctece con el administrador";
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

    public function actualizarMaquina($id,$maquina,$siglas)
    {
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array();
        $this->db->where("IDMAQUINA",$id);
        $datos = array(
            "MAQUINA" => $maquina,
            "SIGLAS" => $siglas,
            "FECHAEDITA" => gmdate(date("Y-m-d H:i:s")),
            "USUARIOEDITA" => $this->session->userdata("id")
        );
        $guardar = $this->db->update("CatMaquinas",$datos);
        if($guardar){
            $mensaje[0]["mensaje"] = "Datos actualizados con éxito";
            $mensaje[0]["tipo"] = "success";
            echo json_encode($mensaje);
        }else{
            $mensaje[0]["mensaje"] = "Error al actualizar los datos. Ocurrió un error inesperado en el servidor,
             si el problema persiste contáctece con el administrador";
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
        $this->db->trans_begin();
        date_default_timezone_set("America/Managua");
        $mensaje = array();
        $this->db->where("IDMAQUINA",$id);
        $datos = array(
            "ESTADO" => $estado,
            "FECHABAJA" => gmdate(date("Y-m-d H:i:s")),
            "USUARIOBAJA" => $this->session->userdata("id")
        );
        $guardar = $this->db->update("CatMaquinas",$datos);
        if($guardar){
            $mensaje[0]["mensaje"] = "Operación exitosa";
            $mensaje[0]["tipo"] = "success";
            echo json_encode($mensaje);
        }else{
            $mensaje[0]["mensaje"] = "Error al actualizar los datos. Ocurrió un error inesperado en el servidor,
             si el problema persiste contáctece con el administrador";
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
