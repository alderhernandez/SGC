<?php


class ctce_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
		$this->load->model("Informes/ctce_model");
		$this->load->model("Informes/CNS_model");
		$this->load->model("Informes/Rvpbp_model");
		
	}

	public function index()
	{
		$data["cpp"] = $this->ctce_model->getInformes();

		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/ctce/ctce',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/ctce/jsctce');
	}

	public function nuevoctce()
	{
		$data["monit"] = $this->CNS_model->getMonitoreo();
		if ($data["monit"]==null || count($data["monit"])<1){
			redirect('monitoreos', 'refresh');
		}
		$data["areas"] = $this->CNS_model->mostrarAreas();
		$data["pesos"] = $this->Rvpbp_model->mostrarPesos();
		$data["contenedores"] = $this->ctce_model->getContenedores();
		
		//echo json_encode($data["contenedores"]);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/ctce/crearctce',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/ctce/jsctce');
	}

	public function getGramos($value)
	{
		$this->Hana_model->getGramos($value);
	}

	public function guardarCTCE()
	{

		$this->ctce_model->guardarCTCE(
			$this->input->post("enc"),
			$this->input->post("datos")
		);
	}

	public function verCTCE($id)
	{
		$data['enc'] = $this->ctce_model->getEncCTCE($id);
		$data['det'] = $this->ctce_model->getdetCTCE($id);
		//echo json_encode($data['enc']);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/ctce/verctce',$data);
		$this->load->view('footer/footer');
		//$this->load->view('jsview/informes/ctce/jseditarCTCE');
	}

	public function editarCTCE($id)
	{
		$data['enc'] = $this->ctce_model->getEncCTCE($id);
		$data['det'] = $this->ctce_model->getdetCTCE($id);
		//echo json_encode($data['det']);
		
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/ctce/editarctce',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/ctce/jseditarCTCE');

	}

	public function getMuestra($tamano,$nivel,/*$tamano2=null,*/$nivel2=null,$bandera)
	{

		//echo "tamano: ".$tamano." nivel: ".strval($nivel);
		$this->Cpp_model->getMuestra($tamano,$nivel,/*$tamano2,*/$nivel2,$bandera);
	}

	public function imprimirCTCE($id)
	{
		$data['enc'] = $this->ctce_model->getEncCTCE($id);
		$data['det'] = $this->ctce_model->getdetCTCE($id);
		$this->load->view('informes/ctce/imprimirctce',$data);
	}

	public function guardarEditarCTCE()
	{
		$id = $this->input->post("id");
		$enc = $this->input->post("enc");
		$datos = $this->input->post("datos");

		//echo json_encode($enc);
		$this->ctce_model->guardarEditarCTCE($id,$enc,$datos);
	}
	public function BajaAltaCTCE()
 	{
 		$id = $this->input->get_post("id");
 		$estado = $this->input->get_post("estado");
        if($estado == "I"){
			$estado = "A";
		}else{
			$estado = "I";
		}
 		$this->ctce_model->BajaAltaCTCE($id,$estado);
 	}
}