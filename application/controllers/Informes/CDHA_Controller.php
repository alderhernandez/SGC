<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CDHA_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Cdt_model");
        $this->load->model("Informes/CDHA_Model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
    }

    public function index()
    {
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cdha/cdhaIndex');
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/cdha/jscdhaIndex');
    }

   public function nuevoCdha()
    {
        $data["version"] = $this->CNS_model->getVersion(20);
        $data["version1"] = $this->CNS_model->getVersion1(20);
        $data["areas"] = $this->Cdt_model->getAreas();
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cdha/cdha',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/cdha/jscdha');
    }

    public function guardarCdha()
    {
        $this->CDHA_Model->guardarCdha(
            $this->input->post("datos")
        );
    }

    
    public function getCdhaAjax(){
        $fecha1 = $this->input->get_post("fecha1");
        $fecha2 = $this->input->get_post("fecha2");
        $this->CDHA_Model->getCdha($fecha1,$fecha2);
    }

    public function getDetCdhaAjax($consecutivo){
        $this->CDHA_Model->getDetCdhaAjax($consecutivo);
    }

    public function getCdhaEdit($consecutivo){
        $data["version"] = $this->CNS_model->getVersion(20);
        $data["version1"] = $this->CNS_model->getVersion1(20);
        $data["areas"] = $this->Cdt_model->getAreas();
        $data["detalle"] = $this->CDHA_Model->getCdhaEdit($consecutivo);
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cdha/cdhaEditar',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/cdha/jscdhaEditar');
    }

    public function actualizarCdha()
    {
        $this->CDHA_Model->actualizarCdha(
            $this->input->get_post("consecutivo"),
            $this->input->post("datos")
        );
    }

    public function bajaCdha(){
        $estadoUpd = "";
        $consecutivo = $this->input->get_post("consecutivo");
        $estado = $this->input->get_post("estado");
        if($estado == "A"){
            $estadoUpd = "I";
        }else{
            $estadoUpd = "A";
        }
        $this->CDHA_Model->bajaCdha($consecutivo,$estadoUpd);
    }

   /* public function getProductosSAP(){
        $var = $this->input->post("q");
        $this->Hana_model->getProductosSAP($var);
    }

    public function getPresentacionById($ItemCode){
        $this->Hana_model->getPresentacionById($ItemCode);
    }*/
}