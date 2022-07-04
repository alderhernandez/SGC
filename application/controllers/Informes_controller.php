<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-12 11:24:23
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-12 11:46:42
 */
class Informes_controller extends CI_Controller
{
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
		$data["rpts"] = $this->CategoriaReporte_model->mostrarCatReporActivos();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/informes',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/informes');
	}
}
