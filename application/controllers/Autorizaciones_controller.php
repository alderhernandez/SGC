<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-05 13:29:30
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-07 16:11:26
 */
class Autorizaciones_controller extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model("Autorizaciones_model");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}

	}

/****************************Categorias Autorizaciones******************************************/
	public function index(){
		$data["data"] = $this->Autorizaciones_model->mostrarCategorias();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('autorizacion/categoriasAut',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/autorizacion/jscategoriasAut');
	}

    public function guardarAutCategoria()
	{
		$descripcion = $this->input->get_post("descripcion");
		$this->Autorizaciones_model->guardarAutCategoria($descripcion);
	}

	public function actualizarAutCategoria()
	{
		$id = $this->input->get_post("id");
		$descripcion = $this->input->get_post("descripcion");
		$this->Autorizaciones_model->actualizarAutCategoria($id,$descripcion);
	}

	public function baja()
	{
		$fecha = '';
		$id = $this->input->get_post("id");
		$descripcion = $this->input->get_post("descripcion");
		$estado = $this->input->get_post("estado");
		if($estado == "I"){
			$estado = "A";
			$fecha = $this->input->get_post("fecha");
		}else{
			$estado = "I";
			$fecha = gmdate(date("Y-m-d H:i:s"));
		}
		$this->Autorizaciones_model->baja($id,$descripcion,$estado,$fecha);
	}
/****************************Categorias Autorizaciones******************************************/

 /****************************Crear Autorizaciones******************************************/ 
  	public function indexCrear(){
 		$data["cats"] = $this->Autorizaciones_model->showCategorias();
 		$data["auts"] = $this->Autorizaciones_model->mostrarAutorizaciones();
 		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('autorizacion/CrearAut',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/autorizacion/jsCrearAut');
 	}

 	public function guardarPermisos()
 	{
 		$desc = $this->input->get_post("desc");
 		$modulo = $this->input->get_post("modulo");
 		$cat = $this->input->get_post("cat");
 		$this->Autorizaciones_model->guardarPermisos($desc,$modulo,$cat);
 	}

 	public function actualizarPermisos()
 	{
 		$id = $this->input->get_post("id");
 		$desc = $this->input->get_post("desc");
 		$modulo = $this->input->get_post("modulo");
 		$cat = $this->input->get_post("cat");	
 		$this->Autorizaciones_model->actualizarPermisos($id,$desc,$modulo,$cat);	
 	}

 	public function bajaPermisos()
 	{
 		$fecha = '';
 		$id = $this->input->get_post("id");
 		$estado = $this->input->get_post("estado");
        if($estado == "I"){
			$estado = "A";
			$fecha = $this->input->get_post("fecha");
		}else{
			$estado = "I";
			$fecha = gmdate(date("Y-m-d H:i:s"));
		}
 		$this->Autorizaciones_model->bajaPermisos($id,$estado,$fecha);	
 	}
 /****************************Crear Autorizaciones******************************************/ 

 /****************************Asignar Permisos******************************************/
 	public function indexAsignar()
 	{		
 		$data["users"] = $this->Autorizaciones_model->mostrarUsuarios();
 		$data["data"] = $this->Autorizaciones_model->mostrarCategorias();
 		$data["auts"] = $this->Autorizaciones_model->mostrarAutorizaciones();
 		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('autorizacion/asignarAut',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/autorizacion/jsasignarAut');
 	}

 	public function asignarPermiso()
 	{
 		$data = $this->input->get_post("datos");
 		$this->Autorizaciones_model->asignarPermiso($data);
 	}

 	public function getAuthAsig($idUsuario)
 	{
 		$this->Autorizaciones_model->getAuthAsig($idUsuario);
 	}
 /****************************Asignar Permisos******************************************/
}