<?php

/**
 * @Author: cesar mejia
 * @Date:   2019-08-12 11:15:54
 * @Last Modified by:   cesar mejia
 * @Last Modified time: 2019-08-13 08:53:44
 */
class racymp_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		if ($this->session->userdata("logged") != 1) {
			redirect(base_url() . 'index.php', 'refresh');
		}
	}

	public function index()
	{
		$this->load->view('header/header');
		$this->load->view('header/menu');
		$this->load->view('informes/racymp/RACYMP');
		$this->load->view('footer/footer');
	}
}