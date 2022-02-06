<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compte extends CI_Controller {

	public function connexion(){
		// COMPLETEZ

		if($this->session->userdata('login')) {
			redirect('/', 'auto');
		}

		if($this->session->userdata('form_id')) { $this->session->unset_userdata('form_id'); }

		$this->form_validation->set_rules('login', 'Login', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');


		if ($this->form_validation->run() === FALSE){
			$data = array( 'invalid' => false);
			$this->load->view('templates/header');
			$this->load->view('form-login', $data);
			$this->load->view('templates/footer');

		}else{

			$login = $this->input->post('login');
			$password = $this->input->post('password');

			if	($this->Model_connexion->check_utilisateur($login, $password)){

				$user = $this->Model_connexion->get_utilisateur($login);

				$newdata = array(
						'login' => $user['login'],
						'nom' => $user['nom'],
						'prenom' => $user['prenom'],
						'email' => $email['email']);

				$this->session->set_userdata($newdata);
				redirect('/', 'auto');
			}
			else {
			$data = array( 'invalid' => true);
			$this->load->view('templates/header');
			$this->load->view('form-login', $data);
			$this->load->view('templates/footer');
			}
		}
	}

	public function inscription() {


		if($this->session->userdata('login')) {
			redirect('/', 'auto');
		}

		$this->form_validation->set_rules('login', 'Login', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');


		if ($this->form_validation->run() === FALSE){
			$data = array( 'invalid' => false);
			$this->load->view('templates/header');
			$this->load->view('form-register', $data);
			$this->load->view('templates/footer');

		}else{

			$login = $this->input->post('login');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			$nom = $this->input->post('nom');
			$prenom = $this->input->post('prenom');


			if	(!$this->Model_connexion->get_utilisateur($login)){

				$user = array(
					'login' => $login,
					'password' => $password,
					'nom' => $nom,
					'prenom' => $prenom,
					'email' => $email);

				$this->Model_connexion->set_utilisateur($user);

				$newdata = array(
						'login' => $user['login'],
						'nom' => $user['nom'],
						'prenom' => $user['prenom'],
						'email' => $email['email']);

				$this->session->set_userdata($newdata);

				redirect('/', 'auto');
			}
			else {
			$data = array( 'invalid' => true);
			$this->load->view('templates/header');
			$this->load->view('form-login', $data);
			$this->load->view('templates/footer');
			}
		}
	}

	public function deconnexion(){

		if($this->session->userdata('login')) {

			$this->Model_connexion->deconnect();

			$this->load->view('templates/header');
			$this->load->view('logout');
			$this->load->view('templates/footer');
		}
		else {
			redirect('/connexion', 'auto');
		}
	}
}
?>