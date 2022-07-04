<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 17/5/2019 15:39 2019
 * FileName: Areas_controller.php
 */
class Areas_controller extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model("Areas_model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
	}

	public function index()
	{
		$data["lista"] = $this->Areas_model->mostrarAreas();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('Areas/Areas',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/areas/jsAreas');
	}

	public function guardarAreas(){
		$area = $this->input->get_post("area");
		$siglas = $this->input->get_post("siglas");
		$this->Areas_model->guardarAreas($area,$siglas);
	}

	public function actualizarAreas()
	{
		$idarea = $this->input->get_post("idarea"); 
		$area = $this->input->get_post("area");
		$siglas = $this->input->get_post("siglas");
		$this->Areas_model->actualizarAreas($idarea,$area,$siglas);	
	}

	public function Baja_Alta()
	{
		$idarea = $this->input->get_post("idarea");
		$estado = $this->input->get_post("estado");
		if($estado == 1){
			$estado = 0;
			$fechabaja = gmdate(date("Y-m-d H:i:s"));
			$userbaja = $this->session->userdata("id");
		}else{
			$estado = 1;
			$fechabaja = NULL;
			$userbaja = NULL;
		}
		$this->Areas_model->Baja_Alta($idarea,$estado,$userbaja,$fechabaja);
	}
}
?>

