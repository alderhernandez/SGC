<?php
/**
 * @Author: cesar mejia
 * @Date:   2019-07-30 09:29:33
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-07-30 13:41:40
 */
class Siglas_controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library("session");
		$this->load->model("Siglas_model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
	}

	public function index(){
		$data["data"] = $this->Siglas_model->cargarSimbologias();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('siglas/Siglas',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/siglas/jsSiglas');
	}

	public function guardarSimbologia(){
		$sigla = $this->input->get_post("sigla");
		$desc = $this->input->get_post("desc");
		$cat = $this->input->get_post("cat");
		$this->Siglas_model->guardarSimbologia($sigla,$desc,$cat);
	}

	public function actualizarSimbologia(){
		$id = $this->input->get_post("idsiglas");
		$sigla = $this->input->get_post("sigla");
		$desc = $this->input->get_post("desc");
		$cat = $this->input->get_post("cat");
		$this->Siglas_model->actualizarSimbologia($id,$sigla,$desc,$cat);
	}

	public function Baja_Alta(){
		$id = $this->input->get_post("idsiglas");
		$estado = $this->input->get_post("estado");
		if($estado == "A"){
			$estado = "I";
		}else{
			$estado	= "A";
		}
		$this->Siglas_model->Baja_Alta($id,$estado);
	}
}
?>