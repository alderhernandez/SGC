<?php

class vec_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Informes/CNS_model");
        $this->load->model("Informes/Pccn3_model");
        $this->load->model("Informes/Vec_model");
        if ($this->session->userdata("logged") != 1) {
            redirect(base_url() . 'index.php', 'refresh');
        }
    }

    public function index()
    {
        $data["datos"] = $this->Vec_model->getInformes();
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/vec/vec',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/vec/jsvec');
    }

    public function	nuevovec()
    {
        $data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->CNS_model->mostrarAreas();
        $data["maquinas"] = $this->CNS_model->mostrarMaquinas();
        $data["lote"] = $this->CategoriaReporte_model->MostrarLote();
        $data["version"] = $this->CNS_model->getVersion(12);

        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/vec/crearVEC',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/vec/jsvec');
    }

    public function	editarVEC($idreporte)
    {
        $data["monit"] = $this->CNS_model->getMonitoreo();
        $data["areas"] = $this->CNS_model->mostrarAreas();
        $data["maquinas"] = $this->CNS_model->mostrarMaquinas();

        $data['det'] = $this->Vec_model->getdetVEC($idreporte);
        $data['enc'] = $this->Vec_model->getEncVEC($idreporte);

        $dias = $this->db->query("SELECT DATEDIFF(day, GETDATE(), FECHACREA) AS dias 
                                    FROM Reportes WHERE IDREPORTE = ".$idreporte);

        if ($dias->result_array()[0]["dias"]<-1) {
            redirect('reporte_12', 'refresh');
        }
        //ECHO json_encode($data["det"]);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/vec/editarVEC',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/informes/vec/jseditarVEC');
    }

    public function verVEC($idreporte)
    {
        $data['enc'] = $this->Vec_model->getEncVEC($idreporte);
        $data['det'] = $this->Vec_model->getdetVEC($idreporte);

        //echo json_encode($data['enc']);
        $this->load->view('header/header');
        $this->load->view('header/menu');
        $this->load->view('informes/vec/verVEC',$data);
        $this->load->view('footer/footer');
    }
    public function imprimirVEC($idreporte)
    {
        $data['enc'] = $this->Vec_model->getEncVEC($idreporte);
        $data['det'] = $this->Vec_model->getdetVEC($idreporte);

        //echo json_encode($data['enc']);
        $this->load->view('informes/vec/imprimirVEC',$data);
    }

    public function guardarVEC()
    {
        $this->Vec_model->guardarVEC(
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


    public function guardarEditarVEC()
    {
        $id = $this->input->post("id");
        $enc = $this->input->post("enc");
        $datos = $this->input->post("datos");

        //echo json_encode($enc);
        $this->Vec_model->guardarEditarVEC($id,$enc,$datos);
    }


    public function mostrarPccn3Ajax($idreporte)
    {
        $this->Pccn3_model->mostrarPccn3Ajax($idreporte);
    }

    public function BajaAltaVEC()
    {
        $idreporte = $this->input->get_post("id");
        $estado = $this->input->get_post("estado");
        if($estado == "A"){
            $estado = "I";
        }else{
            $estado = "A";
        }

        $this->Vec_model->BajaAlta($idreporte,$estado);
    }
}