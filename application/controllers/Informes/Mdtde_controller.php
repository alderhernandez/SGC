<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 24/10/2019 10:10 2019
 * FileName: Mdtde_controller.php
 */
class Mdtde_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Mdtde_model");
        if ($this->session->userdata("logged") != 1) {
            redirect(base_url() . 'index.php', 'refresh');
        }
    }

    public function index()
    {
        $data["mdtde"] = $this->Mdtde_model->getMdtde();
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/mdtde/mdtde',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/mdtde/jsmdtde');
    }

    public function crearMdtde()
    {
        $data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->Mdtde_model->getAreas();
        $data["lote"] = $this->CategoriaReporte_model->MostrarLote();
        $data["version"] = $this->CNS_model->getVersion(13);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/mdtde/crearMdtde',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/mdtde/jsmdtde');
    }

    public function editarDetalle($id)
    {
        //$data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->Mdtde_model->getAreas();
        $data["detalle"] = $this->Mdtde_model->editarDetalle($id);
        $data["version"] = $this->CNS_model->getVersion(13);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/mdtde/mdtdeDetalle',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/mdtde/jsmdtdeDetalle');
    }

    public function editarmdtde($id)
    {
        //$data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->Mdtde_model->getAreas();
        $data["detalle"] = $this->Mdtde_model->editarmdtde($id);
        $data["version"] = $this->CNS_model->getVersion(13);

        //echo json_encode($data["detalle"]);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/mdtde/editarMdtde',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/mdtde/jseditarMdtde');
    }

   public function guardarMdtde()
   {
       $this->Mdtde_model->guardarMdtde(
           $this->input->post("enc"),
           $this->input->post("detalle")
       );
   }

    public function guardarMdtde1()
    {
        $this->Mdtde_model->guardarMdtde1(
            $this->input->post("enc"),
            $this->input->post("detalle")
        );
    }

    public function updateDetalle()
    {
        $this->Mdtde_model->updateDetalle(
            $this->input->post("detalle")
        );
    }

   public function getMdtdeAjax($idreporte)
   {
       $this->Mdtde_model->getMdtdeAjax($idreporte);
   }

   public function bajaMdtde()
   {
       $idreporte = $this->input->get_post("idreporte");
       $estado = $this->input->get_post("estado");
       if($estado == "A"){
           $estado = "I";
       }else{
           $estado = "A";
       }
       $this->Mdtde_model->bajaMdtde($idreporte,$estado);
   }
}