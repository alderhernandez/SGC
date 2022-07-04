<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 11/11/2019 10:27 2019
 * FileName: Cdt_controller.php
 */
class Cdt_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Cdt_model");
        if ($this->session->userdata("logged") != 1) {
            redirect(base_url() . 'index.php', 'refresh');
        }
    }

    public function index()
    {
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/cdt/cdt');
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/cdt/jscdt');
    }

    public function mostrarCdt(){
      $fecha1 = $this->input->get_post("fecha1");
      $fecha2 = $this->input->get_post("fecha2"); 
      $this->Cdt_model->getCdt($fecha1,$fecha2);
    }

    public function crearCdt()
    {
        $data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->Cdt_model->getAreas();
        $data["salas"] = $this->Cdt_model->getSalas();
        $data["lote"] = $this->CategoriaReporte_model->MostrarLote();
        $data["version"] = $this->CNS_model->getVersion(14);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/cdt/crearCdt',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/cdt/jscdt');
    }

    public function editarDetalle($id)
    {
        //$data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->Cdt_model->getAreas();
        $data["salas"] = $this->Cdt_model->getSalas();
        $data["detalle"] = $this->Cdt_model->editarDetalle($id);
        $data["version"] = $this->CNS_model->getVersion(14);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/cdt/cdtDetalle',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/cdt/jscdtDetalle');
    }

    public function editarCdt($id)
    {
        //$data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->Cdt_model->getAreas();
        $data["salas"] = $this->Cdt_model->getSalas();
        $data["detalle"] = $this->Cdt_model->editarCdt($id);
        $data["version"] = $this->CNS_model->getVersion(14);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/cdt/editarCdt',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/cdt/jseditarCdt');
    }

   public function guardarCdt()
   {
       $this->Cdt_model->guardarCdt(
           $this->input->post("enc"),
           $this->input->post("detalle")
       );
   }
    public function guardarCdt1()
    {
        $this->Cdt_model->guardarCdt1(
            $this->input->post("enc"),
            $this->input->post("detalle")
        );
    }

    public function updateDetalle()
    {
        $this->Cdt_model->updateDetalle(
            $this->input->post("detalle")
        );
    }

    public function getCdtAjax($idreporte)
    {
        $this->Cdt_model->getCdtAjax($idreporte);
    }

    public function bajaCdt()
    {
        $idreporte = $this->input->get_post("idreporte");
        $estado = $this->input->get_post("estado");
        if($estado == "A"){
            $estado = "I";
        }else{
            $estado = "A";
        }
        $this->Cdt_model->bajaCdt($idreporte,$estado);
    }
}
