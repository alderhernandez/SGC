<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 17/5/2019 15:39 2019
 * FileName: Areas_controller.php
 */
class Reportes_controller extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model("Areas_model");
		$this->load->model("Reportes_model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
	}

	public function reportePesoDiametro()
	{
		$data["lista"] = $this->Areas_model->mostrarAreas();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('reportes/reportePesoDiametro',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/reportes/jsreportepesodiametro');
	}

	public function generarReportePesoDiametro()
	{
		$lote = $this->input->get_post("lote"); 
		$codigo = $this->input->get_post("codigo"); 
		$this->Reportes_model->generarReportePesoDiametro($lote,$codigo);
	}

	
	public function generarReporteDetallePeso()
	{
		$lote = $this->input->get_post("lote"); 
		$codigo = $this->input->get_post("codigo"); 
		$this->Reportes_model->generarReporteDetallePeso($lote,$codigo);
	}
	public function GraficaPeso()
	{
		$lote = $this->input->get_post("lote"); 
		$codigo = $this->input->get_post("codigo"); 
		$tipo = $this->input->get_post("tipo");
		$this->Reportes_model->GraficaPeso($lote,$codigo,$tipo);
	}

	public function GraficaPesoAceptables()
	{
		$lote = $this->input->get_post("lote"); 
		$codigo = $this->input->get_post("codigo"); 
		$tipo = $this->input->get_post("tipo");
		$this->Reportes_model->GraficaPesoAceptables($lote,$codigo,$tipo);
	}

	public function GraficaPesoDebajo()
	{
		$lote = $this->input->get_post("lote"); 
		$codigo = $this->input->get_post("codigo"); 
		$tipo = $this->input->get_post("tipo");
		$this->Reportes_model->GraficaPesoDebajo($lote,$codigo,$tipo);
	}

	public function GraficaPesoArriba()
	{
		$lote = $this->input->get_post("lote"); 
		$codigo = $this->input->get_post("codigo"); 
		$tipo = $this->input->get_post("tipo");
		$this->Reportes_model->GraficaPesoArriba($lote,$codigo,$tipo);
	}


	public function reporteEnvases()
	{
		$data["lista"] = $this->Areas_model->mostrarAreas();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('reportes/reporteEnvase',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/reportes/jsreporteenvase');
		
	}

	public function GraficaEnvase()
	{
		$lote = $this->input->get_post("lote"); 
		$codigo = $this->input->get_post("codigo"); 
		$maquina = $this->input->get_post("maquina");
		$this->Reportes_model->GraficaEnvase($lote,$codigo,$maquina);
	}

}
?>