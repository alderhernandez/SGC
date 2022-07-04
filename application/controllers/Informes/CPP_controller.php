<?php


class CPP_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
		$this->load->model("Informes/Cpp_model");
		$this->load->model("Informes/CNS_model");
		$this->load->model("Informes/Rvpbp_model");
		$this->load->model("Maquinas_model");

	}

	public function index()
	{
		$data["cpp"] = $this->Cpp_model->getInformes();
		//print_r($data["rvpbp"]);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/CPP/cpp',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/cpp/jscpp');
	}

	public function nuevocpp()
	{
		$data["monit"] = $this->CNS_model->getMonitoreo();
		if ($data["monit"]==null || count($data["monit"])<1){
			redirect('monitoreos', 'refresh');
		}

		$data["version"] = $this->CNS_model->getVersion(10);
		$data["areas"] = $this->CNS_model->mostrarAreas();
		$data["pesos"] = $this->Rvpbp_model->mostrarPesos();
		$data["niveles"] = $this->Cpp_model->mostrarNivelInspeccion();
		$data["maq"] = $this->Maquinas_model->getMaquinas();
    	$data["lote"] = $this->CategoriaReporte_model->MostrarLote();

		//echo json_encode($data["version"]);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cpp/crearcpp',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/cpp/jscpp');
	}

	public function getGramos($value)
	{
		$this->Hana_model->getGramos($value);
	}

	public function guardarCPP()
	{
		$this->Cpp_model->guardarCPP(
			$this->input->post("enc"),
			$this->input->post("datos")
		);
	}

	public function verCPP($id)
	{
		$data['enc'] = $this->Cpp_model->getEncCPP($id);
		$data['det'] = $this->Cpp_model->getdetCPP($id);
		$data["version"] = $this->CNS_model->getVersion(10);
		//echo json_encode($data['enc']);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cpp/verCPP',$data);
		$this->load->view('footer/footer');
		//$this->load->view('jsview/informes/rvpbp/jsrvpbp');
	}

	public function editarCPP($id)
	{
		$data['det'] = $this->Cpp_model->getdetCPP($id);
		$data['enc'] = $this->Cpp_model->getEncCPP($id);
		$data["areas"] = $this->CNS_model->mostrarAreas();
		$data["pesos"] = $this->Rvpbp_model->mostrarPesos();
		$data["niveles"] = $this->Cpp_model->mostrarNivelInspeccion();
		$data["maq"] = $this->Maquinas_model->getMaquinas();

		$dias = $this->db->query("SELECT DATEDIFF(day, GETDATE(), FECHACREA) AS dias
									FROM Reportes WHERE IDREPORTE = ".$id);

		if ($dias->result_array()[0]["dias"]<-1) {
			redirect('reporte_10', 'refresh');
		}
		$decision = array();
		$decision[0] = 'Aceptar';
		$decision[1] = 'Rechazar';
		$decision[2] = 'Reclasificar';
		$decision[3] = 'Desechar';
		$decision[4] = 'Otras';
		$data["decisiones"] = $decision;

		//echo json_encode($data["enc"]);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/cpp/editarcpp',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/cpp/jseditarcpp');

	}

	public function getMuestra($tamano,$nivel,/*$tamano2=null,*/$nivel2=null,$bandera)
	{

		//echo "tamano: ".$tamano." nivel: ".strval($nivel);
		$this->Cpp_model->getMuestra($tamano,$nivel,/*$tamano2,*/$nivel2,$bandera);
	}

	public function imprimirCPP($id)
	{
		$data['enc'] = $this->Cpp_model->getEncCPP($id);
		$data['det'] = $this->Cpp_model->getdetCPP($id);
		$this->load->view('informes/cpp/imprimirCPP',$data);
	}

	public function guardarEditarCPP()
	{
		$id = $this->input->post("id");
		$enc = $this->input->post("enc");
		$datos = $this->input->post("datos");

		//echo json_encode($enc);
		$this->Cpp_model->guardarEditarCPP($id,$enc,$datos);
	}
	public function BajaAltaCPP()
 	{
 		$id = $this->input->get_post("id");
 		$estado = $this->input->get_post("estado");
        if($estado == "I"){
			$estado = "A";
		}else{
			$estado = "I";
		}
 		$this->Cpp_model->BajaAltaCPP($id,$estado);
 	}
}
