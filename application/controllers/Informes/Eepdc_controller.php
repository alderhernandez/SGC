<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 14/10/2019 11:32 2019
 * FileName: Eepdc_controller.php
 */
class Eepdc_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        if ($this->session->userdata("logged") != 1) {
            redirect(base_url() . 'index.php', 'refresh');
        }
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Eepdc_model");
    }

    public function index()
    {
        $data["data"] = $this->Eepdc_model->getEepdc();
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/eepdc/eepdc',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/eepdc/jsEEPDC');
    }

    public function crearEepdc()
    {
        $data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->Eepdc_model->getAreas();
        $data["version"] = $this->CNS_model->getVersion(11);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/eepdc/crearEepdc',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/eepdc/jsEEPDC');
    }

    public function getEepdcByID($idreporte)
    {
        $data["monit"] = $this->Eepdc_model->getEepdcByID($idreporte);
        $data["areas"] = $this->Eepdc_model->getAreas();
        $data["version"] = $this->CNS_model->getVersion(11);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/eepdc/editarEepdc',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/eepdc/jseditarEepdc');
    }


    public function guardarEepdc()
    {
        $this->Eepdc_model->guardarEepdc(
            $this->input->post("enc"),
            $this->input->post("detalle")
        );
    }

    public function actualizarEepdc()
    {
        $this->Eepdc_model->actualizarEepdc(
            $this->input->post("enc"),
            $this->input->post("detalle")
        );
    }

    public function darDeBaja()
    {
        $idreporte = $this->input->get_post("idreporte");
        $estado = $this->input->get_post("estado");
        if($estado == "A")
        {
            $estado = "I";
        }else{
            $estado = "A";
        }
        $this->Eepdc_model->darDeBaja($idreporte,$estado);
    }

    public function detalleEepdcAjax($idreporte)
    {
        $this->Eepdc_model->detalleEepdcAjax($idreporte);
    }
}