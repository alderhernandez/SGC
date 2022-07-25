<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Epp_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Epp_model");
		$this->load->library("session");
	}

	public function salida()
	{
		$data["data"] = $this->Epp_model->getSalidas();

		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('epp/lista',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/epp/jsSalida');
	}

	function crearSalida($tipo)
	{
		$data["articulos"] = $this->Epp_model->getArticulos();
		$data["tipo"]  = $tipo;

		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('epp/crear',$data);				
		$this->load->view('footer/footer');
		$this->load->view('jsview/epp/jscrearsalida');
		$this->load->view('jsview/epp/firma');
	}

	function editarSalida($id)
	{
		$data["articulos"] = $this->Epp_model->getArticulos();
		$data["datos"] = $this->Epp_model->getDatosSalida($id);
		$data["enc"] = $this->Epp_model->getEncabezadoSalida($id);

		//echo json_encode($data["datos"] );

		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('epp/editar',$data);		
		$this->load->view('footer/footer');
		$this->load->view('jsview/epp/jseditarsalida');
		$this->load->view('jsview/epp/firma');
	}

	function articulosEpp()
	{
		//$data["data"] = $this->Epp_model->getArticulos();

		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('epp/articulos');
		$this->load->view('footer/footer');
		$this->load->view('jsview/epp/jsarticulos');
	}

	function getArticulosAjax()
	{
		$this->Epp_model->getArticulosAjax();
	}

	function crearArticulo()
	{

		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('epp/crearArticulo');
		$this->load->view('footer/footer');
		$this->load->view('jsview/epp/jscreararticulo');

	}

	function guardarCrearArticulo()
	{
		$this->Epp_model->guardarCrearArticulo(
            $this->input->post("descripcion")
        );
	}

	function editarArticulo($id)
	{
		$data["enc"] = $this->Epp_model->getArticulo($id);		
		
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('epp/editarArticulo',$data);		
		$this->load->view('footer/footer');
		$this->load->view('jsview/epp/jseditararticulo');


	}

	function guardarEditarArticulo()
	{
		$this->Epp_model->guardarEditarArticulo(
            $this->input->post("id"),
            $this->input->post("descripcion")            
        );
	}

	public function bajaArticulo()
    {
        $idreporte = $this->input->get_post("id");
        $estado = $this->input->get_post("estado");
        if($estado == "1")
        {
        	$estado = "0";
        }else{
            $estado = "1";
        }
        $this->Epp_model->bajaArticulo($idreporte,$estado);
    }

	public function getEmpleados(){
		$var = $this->input->get_post("q");
		$this->Epp_model->getEmpleados(strtoupper($var));
	}


    public function guardarSalida()
    {
        $this->Epp_model->guardarSalida(
            $this->input->post("enc"),
            $this->input->post("tipo"),
            $this->input->post("datos")
        );
    }

    
	public function actualizarSalida()
    {
        $this->Epp_model->actualizarSalida(
            $this->input->post("enc"),
            $this->input->post("datos"),
            $this->input->post("id")
        );
    }

    public function BajaEPP()
    {
        $idreporte = $this->input->get_post("id");
        $estado = $this->input->get_post("estado");
        if($estado == "1")
        {
            $estado = "0";
        }else{
            $estado = "1";
        }
        $this->Epp_model->darDeBaja($idreporte,$estado);
    }

    function mostrarEPP()
    {
    	 $this->Epp_model->mostrarEPP(
            $this->input->post("tipo"),
            $this->input->post("desde"),
            $this->input->post("hasta"),
            $this->input->post("empleado")
        );
    }


    function printEpp($id)
    {
    	$data["enc"] = $this->Epp_model->getEncEpp($id);
    	$data["det"] = $this->Epp_model->getDetEpp($id);
    	//echo json_encode($data["det"]);
    	$this->load->view('epp/printEpp',$data);
    }
}
?>