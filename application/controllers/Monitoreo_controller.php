<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoreo_controller extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Monitoreo_model");
		$this->load->model("Usuarios_model");
		$this->load->library("session");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
	}

	public function index(){		
		$data["monitoreos"] = $this->Monitoreo_model->mostrarMonitoreos();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('monitoreo/monitoreos',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/monitoreo/jsMonitoreos');
	}

	public function crearmonitoreo()
	{
		$estado = $this->input->get_post("proceso");
		$this->Monitoreo_model->crearmonitoreo($estado);		
	}
}
?>