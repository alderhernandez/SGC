<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-22 09:15:33
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-28 17:05:36
 */
class Veced_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model("Informes/Veced_model");
		$this->load->model("Informes/CNS_model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
	}

	public function index()
	{
		$data["veced"] = $this->Veced_model->mostrarVeced();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/veced/Veced',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/veced/jsVeced');
	}

	public function	nuevoVECED()
	{
		$data["monit"] = $this->CNS_model->getMonitoreo();
        $data["version"] = $this->CNS_model->getVersion(8);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/veced/crearVeced',$data);
		$this->load->view('footer/footer');	
		$this->load->view('jsview/informes/veced/jsVeced');
	}

    public function editarVeced($id)
    {
        $data["veced"] = $this->Veced_model->editarVeced($id);
        $data["version"] = $this->CNS_model->getVersion(8);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/veced/editarVeced',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/veced/jseditarVeced');
    }

	public function getProductosSAP(){
		$var = $this->input->get_post("q"); 
		$this->Hana_model->getProductosSAP(strtoupper($var));
	}

	public function guardarVeced()
	{
		$this->Veced_model->guardarVeced(
			$this->input->post("enc"),
			$this->input->post("datos")
		);
	}

    public function actualizarVeced()
    {
        $this->Veced_model->actualizarVeced(
            $this->input->post("enc"),
            $this->input->post("datos")
        );
    }

	public function mostrarVecedAjax($idreporte)
	{
		$this->Veced_model->mostrarVecedAjax($idreporte);
	}

	public function BajaAltaVeced()
	{
		$id = $this->input->get_post("id");
		$estado = $this->input->get_post("estado");
		if($estado == "A"){
			$estado = "I";
		}else{
			$estado = "A";
		}
		$this->Veced_model->BajaAlta($id,$estado);
	}
}				
