<?php

/**
 * @Author: pinky mejia
 * @Date:   2019-08-13 13:59:25
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-20 15:43:47
 */
class CNS_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model("Informes/CNS_model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
	}

	public function index()
	{
		$data["cns"] = $this->CNS_model->mostrarCNS();
		//echo json_encode($data["cns"]);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cns/CNS',$data);
		$this->load->view('footer/footer');	
		$this->load->view('jsview/informes/cns/jsCNS');
	}

	public function	nuevoCNS()
	{
		$data["monit"] = $this->CNS_model->getMonitoreo();
		$data["areas"] = $this->CNS_model->mostrarAreas();
        $data["version"] = $this->CNS_model->getVersion(6);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cns/crearCNS',$data);
		$this->load->view('footer/footer');	
		$this->load->view('jsview/informes/cns/jsCNS');
	}

	public function	editarCNS($id)
	{
		$data["monit"] = $this->CNS_model->editarCNS($id);
		$data["areas"] = $this->CNS_model->mostrarAreas();
        $data["version"] = $this->CNS_model->getVersion(6);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cns/editarCNS',$data);
		$this->load->view('footer/footer');	
		$this->load->view('jsview/informes/cns/jseditarCNS');
	}		

	public function mostrarCNSDetalle($idreporte)
	{
		$this->CNS_model->mostrarCNSDetalle($idreporte);
	}

	public function guardarCNS()
	{
		$this->CNS_model->guardarCNS(
			$this->input->post("enc"),
			$this->input->post("datos")
		);
	}

	public function actualizarCNS()
	{
		$this->CNS_model->actualizarCNS(
			$this->input->post("enc"),
			$this->input->post("datos")
		);
	}

	public function BajaAltaCNS()
 	{
 		$id = $this->input->get_post("id");
 		$estado = $this->input->get_post("estado");
        if($estado == "I"){
			$estado = "A";
		}else{
			$estado = "I";
		}
 		$this->CNS_model->BajaAlta($id,$estado);
 	}

}