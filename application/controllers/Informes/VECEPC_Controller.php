<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VECEPC_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Cdt_model");
        $this->load->model("Informes/VECEPC_Model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
    }

    public function index()
    {
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/vecepc/vecepcIndex');
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/vecepc/jsvecepcIndex');
    }

    public function nuevoVecepc()
    {
        $data["version"] = $this->CNS_model->getVersion(18);
        $data["version1"] = $this->CNS_model->getVersion1(18);
        $data["areas"] = $this->Cdt_model->getAreas();
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/vecepc/vecepc',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/vecepc/jsvecepc');
    }

    public function getProductosSAP(){
        $var = $this->input->post("q");
        $this->Hana_model->getProductosSAP($var);
    }

    public function getPresentacionById($ItemCode){
        $this->Hana_model->getPresentacionById($ItemCode);
    }

    public function guardarVecepc()
    {
        $this->VECEPC_Model->guardarVecepc(
            $this->input->post("datos")
        );
    }
    public function actualizarVecepc()
    {
        $this->VECEPC_Model->actualizarVecepc(
            $this->input->get_post("consecutivo"),
            $this->input->post("datos")
        );
    }
    

    public function getVecepcAjax(){
        $fecha1 = $this->input->get_post("fecha1");
        $fecha2 = $this->input->get_post("fecha2");
        $this->VECEPC_Model->getVecepc($fecha1,$fecha2);
    }

    public function getVecepcAjaxDet($consecutivo){
        $this->VECEPC_Model->getVecepcAjax($consecutivo);
    }

    public function getVecepcEdit($consecutivo){
        $data["version"] = $this->CNS_model->getVersion(18);
        $data["version1"] = $this->CNS_model->getVersion1(18);
        $data["areas"] = $this->Cdt_model->getAreas();
        $data["detalle"] = $this->VECEPC_Model->getVecepcEdit($consecutivo);
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/vecepc/vecepcEditar',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/vecepc/jsvecepcEditar');
    }

    public function bajaVecepc(){
        $estadoUpd = "";
        $consecutivo = $this->input->get_post("consecutivo");
        $estado = $this->input->get_post("estado");
        if($estado == "A"){
            $estadoUpd = "I";
        }else{
            $estadoUpd = "A";
        }
        $this->VECEPC_Model->bajaVecepc($consecutivo,$estadoUpd);
    }
}

/* End of file VECEPC_Controller.php */