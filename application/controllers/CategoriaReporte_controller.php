<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-09 10:49:31
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-12 09:38:28
 */
 class CategoriaReporte_controller extends CI_Controller{
 	public function __construct()
 	{
 		parent::__construct();
 		$this->load->library("session");
 		$this->load->model("CategoriaReporte_model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
 	}

 	public function index()
 	{
 		$data["lista"] = $this->CategoriaReporte_model->mostrarCatRepor();
 		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('siglas/catReportes',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/siglas/jscatReportes');
 	}

 	public function guardarCatRep()
 	{
 		$sigla = $this->input->get_post("sigla");
 		$nombre = $this->input->get_post("nombre");
 		$this->CategoriaReporte_model->guardarCatRep($sigla,$nombre);
 	}

 	public function actualizarCatRep()
 	{
 		$id = $this->input->get_post("id");
 		$sigla = $this->input->get_post("sigla");
 		$nombre = $this->input->get_post("nombre");
 		$this->CategoriaReporte_model->actualizarCatRep($id,$sigla,$nombre);
 	}

 	public function Baja_AltaCatRep()
 	{
 		$id = $this->input->get_post("id");
 		$estado = $this->input->get_post("estado");
 		if($estado == "A"){
 			$estado = "I";
 		}else{
 			$estado = "A";
 		}
 		$this->CategoriaReporte_model->Baja_AltaCatRep($id,$estado);
 	}

 }