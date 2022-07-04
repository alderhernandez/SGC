<?php
/**
 * Created by Cesar Mejía.
 * User: Sistemas
 * Date: 1/10/2019 14:48 2019
 * FileName: Maquinas_controller.php
 */
class Maquinas_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        if ($this->session->userdata("logged") != 1) {
            redirect(base_url() . 'index.php', 'refresh');
        }
        $this->load->model("Maquinas_model");
    }

    public function index()
    {
        $data["maq"] = $this->Maquinas_model->getMaquinas();
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('maquinas/maquinas',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/maquinas/jsmaquinas');
    }

    public function guardarMaquina()
    {
        $maquina = $this->input->get_post("maquina");
        $siglas = $this->input->get_post("siglas");
        $this->Maquinas_model->guardarMaquina($maquina,$siglas);
    }

    public function actualizarMaquina()
    {
        $id = $this->input->get_post("idmaquina");
        $maquina = $this->input->get_post("maquina");
        $siglas = $this->input->get_post("siglas");
        $this->Maquinas_model->actualizarMaquina($id,$maquina,$siglas);
    }

    public function BajaAlta()
    {
        $id = $this->input->get_post("id");
        $estado = $this->input->get_post("estado");
        if($estado == "A"){
            $estado = "I";
        }else{
            $estado = "A";
        }
        $this->Maquinas_model->BajaAlta($id,$estado);
    }
}