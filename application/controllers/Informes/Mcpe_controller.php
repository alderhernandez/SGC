<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 23/9/2019 11:36 2019
 * FileName: Mcpe_controller.php
 */
class Mcpe_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Mcpe_model");
        if ($this->session->userdata("logged") != 1) {
            redirect(base_url() . 'index.php', 'refresh');
        }
    }

    public function index()
    {
        //return  "asdasd";
        $data["peso"] = $this->Mcpe_model->getMcpePesoBascula();
        $data["caract"] = $this->Mcpe_model->getMcpeCaractCalidad();
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/mcpe/mcpe',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/mcpe/jsMCPE');
    }

    public function nuevoMCPE()
    {
        $data["monit"] = $this->CNS_model->getMonitoreo();
        $data["maq"] = $this->Mcpe_model->getMaquinas();
        $data["version"] = $this->CNS_model->getVersion(4);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/mcpe/crearMcpe',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/mcpe/jsMCPE');
    }

    public function editarMcpePeso($idreporte)
    {
        $data["monit"] = $this->Mcpe_model->getMcpePesoBasculaById($idreporte);
        $data["version"] = $this->CNS_model->getVersion(4);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/mcpe/editarMcpePeso',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/mcpe/jseditarMcpePeso');
    }

    public function editarMcpeCaract($idreporte)
    {
        $data["monit"] = $this->Mcpe_model->getMcpeCaractCalidadById($idreporte);
        $data["maq"] = $this->Mcpe_model->getMaquinas();
        $data["version"] = $this->CNS_model->getVersion(4);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/mcpe/editarMcpeCaract',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/mcpe/jseditarMcpeCaract');
    }


    public function guardarMcpeVerificPeso()
    {
        $this->Mcpe_model->guardarMcpeVerificPeso(
            $this->input->post("enc"),
            $this->input->post("detalle")
        );
    }

    public function guardarMcpeVerificCaract()
    {
        $this->Mcpe_model->guardarMcpeVerificCaract(
            $this->input->post("enc"),
            $this->input->post("detalle")
        );
    }

    public function getMcpePesoBasculaAjax($idreporte)
    {
        $this->Mcpe_model->getMcpePesoBasculaAjax($idreporte);
    }

    public function getMcpeCaractCalidadAjax($idreporte)
    {
        $this->Mcpe_model->getMcpeCaractCalidadAjax($idreporte);
    }

    public function darDeBaja()
    {
        $idreporte = $this->input->get_post("idreporte");
        $estado = $this->input->get_post("estado");
        if($estado == "A"){
              $estado = "I";
        }else{
            $estado = "A";
        }
        $this->Mcpe_model->darDeBaja($idreporte,$estado);
    }


    public function actualizarMcpeVerificPeso()
    {
        $this->Mcpe_model->actualizarMcpeVerificPeso(
            $this->input->post("enc"),
            $this->input->post("detalle")
        );
    }

    public function actualizarMcpeVerificCaract()
    {
        $this->Mcpe_model->actualizarMcpeVerificCaract(
            $this->input->post("enc"),
            $this->input->post("detalle")
        );
    }



}