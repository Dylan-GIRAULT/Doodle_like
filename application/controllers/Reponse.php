<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reponse extends CI_Controller {


	public function index($clef_sondage=null) {

		$is_valid = false;

		$is_error = false;

		if($clef_sondage == null) { // si la clé n'est pas donné, on redirige vers la page de connexion
			redirect('/connexion', 'auto');
		}

		if(!$this->Model_connexion->get_sondage($clef_sondage)) {
			
			if($this->session->userdata('login')) {
				$this->load->view('templates/header-logged', array('username' => $this->session->userdata('nom')));
			}
			else {
				$this->load->view('templates/header');
			}	
			$this->load->view('form-answer-null');
			$this->load->view('templates/footer');
		}
		else {

			$info = $this->Model_connexion->get_sondage($clef_sondage);

			if($info['etat'] == 1) {
				if($this->session->userdata('login')) {
				$this->load->view('templates/header-logged', array('username' => $this->session->userdata('nom')));
				}
				else {
					$this->load->view('templates/header');
				}	
				$this->load->view('form-answer-closed');
				$this->load->view('templates/footer');
			}
			else {


				if($this->input->post('nom')) {
					$name = $this->input->post('nom');

					if(!$this->Model_connexion->get_reponseSondage_link_sondage_zoom($clef_sondage, $name)) {
						$results = $this->Model_connexion->get_optionsSondage_link_sondage($clef_sondage);

						foreach ($results as $result) {

							$sentence = "option-".$result['unix_timestamp'];

							$reponse = $this->input->post($sentence);

							if($reponse === null) { $reponse = 0; }

							$query = array(
								'nom' => $this->input->post('nom'),
								'clefSondage' => $clef_sondage
							);

							$query_type = array(
								'nom' => $this->input->post('nom'),
								'clefSondage' => $clef_sondage,
								'typeReponse' => $reponse,
								'unix_timestamp' => $result['unix_timestamp']
							);

							if(!$this->Model_connexion->get_reponseSondage_link_sondage_zoom($clef_sondage, $name)) {

								if(!$this->Model_connexion->set_reponseSondage($query)) {
									$is_error = true; $is_valid = false; 
								}
							}

							if($this->Model_connexion->set_optionReponseSondage($query_type)) {

								$is_valid = true;
							}
							else {
								$is_error = true;

								$is_valid = false;
								break;
							}

						}

					}
					else {
						$is_error = true;
					}
				}



				$unix_timestamp = $this->Model_connexion->get_optionsSondage_link_Sondage($clef_sondage);

				$data = array( 'is_valid' => $is_valid, 
					'is_error' => $is_error, 
					'options' => $unix_timestamp, 
					'description' => $info['description'],
					'lieu' => $info['lieu'],
					'titre' => $info['titre'],
					'clef' => $clef_sondage);

				if($this->session->userdata('login')) {
					$this->load->view('templates/header-logged', array('username' => $this->session->userdata('nom')));
				}
				else {
					$this->load->view('templates/header');
				}
				$this->load->view('form-answer', $data);
				$this->load->view('templates/footer');
			}
		}

	}
}