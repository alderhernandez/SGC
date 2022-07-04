<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 6/9/2019 16:23 2019
 * FileName: Pccn3.php
 */
class Pccn3_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Pccn3_model");
        if ($this->session->userdata("logged") != 1) {
            redirect(base_url() . 'index.php', 'refresh');
        }
    }

    public function index()
    {
        $data["datos"] = $this->Pccn3_model->mostrarPccn3();
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/pccn3/pccn3',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/pccn3/jsPCCN3');
    }

    public function	nuevoPCCN3()
    {
        $data["monit"] = $this->CNS_model->getMonitoreo();
        $data["version"] = $this->CNS_model->getVersion(9);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/pccn3/crearPCCN3',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/pccn3/jsPCCN3');
    }

    public function	editarPccn3($idreporte)
    {
        $data["editar"] = $this->Pccn3_model->editarPccn3($idreporte);
        $data["version"] = $this->CNS_model->getVersion(9);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/pccn3/editarPCCN3',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/pccn3/jseditarPCCN3');
    }

    public function guardarPccn3()
    {
        $this->Pccn3_model->guardarPccn3(
            $this->input->post("enc"),
            $this->input->post("datos")
        );
    }

    public function actualizarPccn3()
    {
        $this->Pccn3_model->actualizarPccn3(
            $this->input->post("enc"),
            $this->input->post("datos")
        );
    }


    public function mostrarPccn3Ajax($idreporte)
    {
        $this->Pccn3_model->mostrarPccn3Ajax($idreporte);
    }

    public function BajaAltaPccn3()
    {
        $idreporte = $this->input->get_post("idreporte");
        $estado = $this->input->get_post("estado");
        if($estado == "A"){
            $estado = "I";
        }else{
            $estado = "A";
        }
        $this->Pccn3_model->BajaAlta($idreporte,$estado);
    }
}