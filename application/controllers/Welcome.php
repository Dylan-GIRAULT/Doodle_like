<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		if(!$this->session->userdata('login')) {
			redirect('/connexion', 'auto');
		}

		if($this->session->userdata('clef')) { $this->session->unset_userdata('clef'); }

		if($this->session->userdata('form_id')) { $this->session->unset_userdata('form_id'); }

		$login = $this->session->userdata('login');
		
		$data = $this->Model_connexion->get_sondage_link_utilisateur($login);

		foreach($data as $row) {

			if(!$this->Model_connexion->get_optionsSondage_link_sondage($row['clef'])) {
				$this->Model_connexion->remove_sondage($row['clef']);
			}
		}

		$data = $this->Model_connexion->get_sondage_link_utilisateur($login);

		$this->load->view('templates/header-logged', array('username' => $this->session->userdata('nom')));
		$this->load->view('sondage-home', array( 'sondages' => $data));
		$this->load->view('templates/footer');
			
		
	}
}
