<?php


class Rvpbp_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
		$this->load->model("Informes/Rvpbp_model");
		$this->load->model("Informes/CNS_model");
	}

	public function index()
	{
		$data["rvpbp"] = $this->Rvpbp_model->getInformes();
		//print_r($data["rvpbp"]);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/rvpbp/rvpbp',$data);
		$this->load->view('footer/footer');
		$this->load->view('jsview/informes/rvpbp/jsrvpbp');
	}

	public function nuevorvpbp()
	{
		$data["monit"] = $this->CNS_model->getMonitoreo();
		if ($data["monit"]==null || count($data["monit"])<1){
			redirect('monitoreos', 'refresh');
		}
		$data["version"] = $this->CNS_model->getVersion(7);
		$data["areas"] = $this->CNS_model->mostrarAreas();
		$data["pesos"] = $this->Rvpbp_model->mostrarPesos();
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/rvpbp/crearrvpbp',$data);
		$this->load->view('footer/footer');	
		$this->load->view('jsview/informes/rvpbp/jsrvpbp');
	}

	public function guardarRVPBP()
	{
		$this->Rvpbp_model->guardarRVPBP(
			$this->input->post("enc"),
			$this->input->post("datos")
		);
	}


	public function verRVPBP($id)
	{
		$data['enc'] = $this->Rvpbp_model->getencRvpbp($id);
		$data['det'] = $this->Rvpbp_model->getdetRvpbp($id);
		//echo json_encode($data['det']);
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/rvpbp/verRVPBP',$data);
		$this->load->view('footer/footer');	
		$this->load->view('jsview/informes/rvpbp/jsrvpbp');
	}

	public function editarRVPBP($id)
	{
		$data['enc'] = $this->Rvpbp_model->getencRvpbp($id);
		$data['det'] = $this->Rvpbp_model->getdetRvpbp($id);
		$data["pesos"] = $this->Rvpbp_model->mostrarPesos();
		$data["areas"] = $this->CNS_model->mostrarAreas();
		//echo json_encode($data['enc']);
		$dias = $this->db->query("SELECT DATEDIFF(day, GETDATE(), FECHACREA) AS dias 
									FROM Reportes WHERE IDREPORTE = ".$id);

		if ($dias->result_array()[0]["dias"]<-1) {
			redirect('reporte_7', 'refresh');
		}
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/rvpbp/editarrvpbp',$data);
		$this->load->view('footer/footer');	
		$this->load->view('jsview/informes/rvpbp/jseditarrvpbp');

	}

	public function imprimirRVPBP($id)
	{
		$data['enc'] = $this->Rvpbp_model->getencRvpbp($id);
		$data['det'] = $this->Rvpbp_model->getdetRvpbp($id);
		$this->load->view('informes/rvpbp/imprimirrvpbp',$data);
	}

	public function guardareditarRVPBP()
	{
		$id = $this->input->get_post("id");
		$detalle = $this->input->get_post("datos");
		$encabezado = $this->input->get_post("enc");

		$this->Rvpbp_model->guardareditarRVPBP($id,$detalle,$encabezado);
	}
	public function BajaAltaRVPBP()
 	{
 		$id = $this->input->get_post("id");
 		$estado = $this->input->get_post("estado");
        if($estado == "I"){
			$estado = "A";
		}else{
			$estado = "I";
		}
 		$this->Rvpbp_model->BajaAltaRVPBP($id,$estado);
 	}
}