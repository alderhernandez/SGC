<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VECEPCR_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Cdt_model");
        $this->load->model("Informes/VECEPCR_Model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
    }

    public function index()
    {
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/vecepcr/vecepcrIndex');
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/vecepcr/jsvecepcrIndex');
    }

    public function nuevoVecepcr()
    {
        $data["version"] = $this->CNS_model->getVersion(19);
        $data["version1"] = $this->CNS_model->getVersion1(19);
        $data["areas"] = $this->Cdt_model->getAreas();
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/vecepcr/vecepcr',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/vecepcr/jsvecepcr');
    }
    
    public function getPresentacionById($ItemCode){
        $this->Hana_model->getPresentacionById($ItemCode);
    }
    

    public function getProductosSAP(){
        $var = $this->input->post("q");
        $this->Hana_model->getProductosSAP($var);
    }

    

    public function guardarVecepcr()
    {
        $this->VECEPCR_Model->guardarVecepcr(
            $this->input->post("datos")
        );
    }

    public function getVecepcrAjax(){
        $fecha1 = $this->input->get_post("fecha1");
        $fecha2 = $this->input->get_post("fecha2");
        $this->VECEPCR_Model->getVecepcr($fecha1,$fecha2);
    }

    public function getVecepcrAjaxDet($consecutivo){
        $this->VECEPCR_Model->getVecepcrAjax($consecutivo);
    }

    public function getVecepcrEdit($consecutivo){
        $data["version"] = $this->CNS_model->getVersion(19);
        $data["version1"] = $this->CNS_model->getVersion1(19);
        $data["areas"] = $this->Cdt_model->getAreas();
        $data["detalle"] = $this->VECEPCR_Model->getVecepcrEdit($consecutivo);
        $this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/vecepcr/vecepcrEditar',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/vecepcr/jsvecepcrEditar');
    }
    
    public function actualizarVecepcr()
    {
        $this->VECEPCR_Model->actualizarVecepcr(
            $this->input->get_post("consecutivo"),
            $this->input->post("datos")
        );
    }

    public function bajaVecepcr(){
        $estadoUpd = "";
        $consecutivo = $this->input->get_post("consecutivo");
        $estado = $this->input->get_post("estado");
        if($estado == "A"){
            $estadoUpd = "I";
        }else{
            $estadoUpd = "A";
        }
        $this->VECEPCR_Model->bajaVecepcr($consecutivo,$estadoUpd);
    }
   
}

/* End of file VECEPC_Controller.php */