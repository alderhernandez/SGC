<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Usuarios_model");
		$this->load->library("session");
	}

	public function index()
	{
		$this->load->view('header/header_login');
		$this->load->view('Login');
	}

	public function iniciarSesion(){
		$this->form_validation->set_rules('usuario', 'nombre', 'required');
		$this->form_validation->set_rules('password', 'pass', 'required');

		if ($this->form_validation->run() == FALSE) {
			redirect('?error=1');
		}else{
			$name = $this->input->get_post("usuario");
			$pass = md5($this->input->get_post("password"));
			$data["user"] = $this->Usuarios_model->iniciarSesion($name,$pass);

			if($data["user"] == 0){
				redirect("?error=2");
			}else{
				$session_data = array(
					'id' =>  $data["user"][0]["IDUSUARIO"],
					'idRol' =>  $data["user"][0]["IDROL"],
					'rol' =>  $data["user"][0]["NOMBRE_ROL"],
					'user' =>  $data["user"][0]["NOMBREUSUARIO"],
					'nombre' =>  $data["user"][0]["NOMBRES"],
					'apellidos' =>  $data["user"][0]["APELLIDOS"],
					'sexo' =>  $data["user"][0]["SEXO"],
					'correo' =>  $data["user"][0]["CORREO"],
					'estado' =>  $data["user"][0]["ESTADO"],
					"logged" => 1
				);
				$this->session->set_userdata($session_data);
				redirect("Informes");
			}
		}
	}

	public function Salir()
	{
		$this->session->sess_destroy();
		$session_data = array('logged' => 0);
		redirect(base_url() . 'index.php', 'refresh');
	}

}
