<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sondage extends CI_Controller {

	public function Creation() {

		if(!$this->session->userdata('login')) { // si la personne n'est pas connecté
			redirect('/connexion', 'auto');
		}

		$login = $this->session->userdata('login');
		$nom = $this->session->userdata('nom');

		if($this->input->post('form_id')) {  // si form_id est renvoyé par un formulaire 
			$form_id = $this->input->post('form_id');

			if($form_id != 1) { // si l'utilisateur n'est pas sur la première page
				$this->session->set_userdata(array('form_id' => $form_id));
			}

		}

		if(!$this->session->userdata('form_id')) { $this->session->set_userdata(array('form_id' => 0)); } // si form_id n'est pas défini

		if($this->session->userdata('form_id') == 6) { //FINI / aller sur la dernière page
			$data = array(
				'is_error' => false,
				'error_message' => '',
				'clef' => $this->session->userdata('clef')
			);

			$this->load->view('templates/header-logged', array('username' => $nom));
			$this->load->view('create-step4', $data);
			$this->load->view('templates/footer');

			$this->session->unset_userdata('clef');
			$this->session->unset_userdata('form_id');
		}

		elseif($this->session->userdata('form_id') == 5) { // FINI si le créateur du sondage souhaite voter sur son sondage
			$results = $this->Model_connexion->get_optionsSondage_link_sondage($this->session->userdata('clef'));

			$continue = true;

			$this->session->set_userdata(array('form_id' => 6));

			foreach ($results as $result) {
				
				$sentence = "option-".$result['unix_timestamp'];

				$reponse = $this->input->post($sentence);

				if($reponse === null) { $reponse = 2; }

				$data_reponse = array(
					'nom' => $this->session->userdata('nom'),
					'clefSondage' => $this->session->userdata('clef')
				);

				$data_reponseSondage = array(
					'nom' => $this->session->userdata('nom'),
					'clefSondage' => $this->session->userdata('clef'),
					'unix_timestamp' => $result['unix_timestamp'],
					'typeReponse' => $reponse
				);

				if(!$this->Model_connexion->get_reponseSondage_link_sondage_zoom($this->session->userdata('clef'), $this->session->userdata('nom'))) {
					$this->Model_connexion->set_reponseSondage($data_reponse); 
				}

				if($this->Model_connexion->set_optionreponseSondage($data_reponseSondage)) {
					$continue = true;

				}

				else {
					$continue = false;
					$this->session->set_userdata(array('form_id' => 4));
					$data = array( 'is_error' => true,
						'error_message' => 'Problème implémentation dans les dates transmises',
						'options' => $this->Model_connexion->get_optionsSondage_link_sondage($this->session->userdata('clef'))
					); 

					$this->load->view('templates/header-logged', array('username' => $nom));
					$this->load->view('create-step3', $data);
					$this->load->view('templates/footer');
					break;

				}
				
			}

			if($continue) {
				$this->session->set_userdata(array('form_id' => 6));

				redirect('/creation');
			}
		}

		elseif($this->session->userdata('form_id') == 4) { // FINI / aller sur la 3ème page

			$data = array( 'is_error' => false,
				'error_message' => '',
				'options' => $this->Model_connexion->get_optionsSondage_link_sondage($this->session->userdata('clef'))
			); 

			$this->load->view('templates/header-logged', array('username' => $nom));
			$this->load->view('create-step3', $data);
			$this->load->view('templates/footer');

		}

		elseif($this->session->userdata('form_id') == 3) { // si tu veux créer un timestamp

			$date = $this->input->post('date');
			$temps = $this->input->post('temps');

			$unix = strtotime($date.' '.$temps);

			$data = array(
				'unix_timestamp' => $unix,
				'clefSondage' => $this->session->userdata('clef')
			);

			$this->session->set_userdata(array('form_id' => 1));

			if($this->Model_connexion->get_optionsSondage_zoom($data['clefSondage'], $data['unix_timestamp'])) { // si la date est déjà présente dans la BD

				$options = $this->Model_connexion->get_optionsSondage_link_sondage($this->session->userdata('clef'));

				$data = array( 'options' =>$options, 'is_error' => true, 'error_message' => 'la date donnée est déjà présente');
				$this->load->view('templates/header-logged', array('username' => $nom));
				$this->load->view('create-step2', $data);
				$this->load->view('templates/footer');
			}

			elseif($this->Model_connexion->set_optionsSondage($data)) { // si mettre une option réussi

				redirect('/creation');
			}
			else { // si mettre une option échoue
				$options = $this->Model_connexion->get_optionsSondage_link_sondage($this->session->userdata('clef'));

				$data = array( 'options' =>$options, 'is_error' => true, 'error_message' => 'Erreur en ajoutant une option');
				$this->load->view('templates/header-logged', array('username' => $nom));
				$this->load->view('create-step2', $data);
				$this->load->view('templates/footer');
			}

		}

		elseif($this->session->userdata('form_id') == 2) { // FINI si tu veux supprimer un timestamp

			$unix_timestamp = $this->input->post('to_delete_timestamp');
			$clefSondage = $this->session->userdata('clef');

			$unix = array('clefSondage' => $clefSondage,
				'unix_timestamp' => $unix_timestamp
			);

			$this->session->set_userdata(array('form_id' => 1));

			if($this->Model_connexion->remove_optionsSondage($unix)) { // si supprimer l'option réussi

				redirect('/creation');

			} else { // si supprimer l'option échoue
				$options = $this->Model_connexion->get_optionsSondage_link_sondage($this->session->userdata('clef'));

				$data = array( 'options' =>$options, 'is_error' => true, 'error_message' => 'Erreur en supprimant une option');
				$this->load->view('templates/header-logged', array('username' => $nom));
				$this->load->view('create-step2', $data);
				$this->load->view('templates/footer');
			}
		}

		elseif($this->session->userdata('form_id') == 1) { // aller sur la 2eme page de création

			$options = $this->Model_connexion->get_optionsSondage_link_sondage($this->session->userdata('clef'));


			$data = array( 'options' =>$options, 'is_error' => false, 'error_message' => '');
			$this->load->view('templates/header-logged', array('username' => $nom));
			$this->load->view('create-step2', $data);
			$this->load->view('templates/footer');

		}

		else {

			$this->session->unset_userdata('clef');

			$this->form_validation->set_rules('titre', 'Titre', 'required|trim');
			$this->form_validation->set_rules('lieu', 'Lieu', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');

			if ($this->form_validation->run() === FALSE){ // si le formulaire est incorrect
				$data = array( 'is_error' => false, 'error_message' => '');
				$this->load->view('templates/header-logged', array('username' => $nom));
				$this->load->view('create-step1', $data);
				$this->load->view('templates/footer');

			}else{


				$titre = $this->input->post('titre');
				$description = $this->input->post('description');
				$lieu = $this->input->post('lieu');
				$form_id = $this->input->post('form_id');
				$clef = uniqid();

				while($this->Model_connexion->get_sondage($clef)) { // sort de la boucle uniquement si clef n'est pas déjà inscrit
					$clef = uniqid();
				} 

				$query = array(
					'titre' => $titre,
					'description' => $description,
					'lieu' => $lieu,
					'login' => $login,
					'clef' => $clef
				);

				if	($this->Model_connexion->set_sondage($query)){ // si le sondage est créé

					$this->session->set_userdata(array('form_id' => $form_id));

					$this->session->set_userdata(array('clef' => $clef));

					redirect('/creation');
					
				}
				else { // si la création échoue
					$data = array( 'is_error' => true, 'error_message' => 'Problème dans la mise des éléments dans la base de donnée' );
					$this->load->view('templates/header-logged', array('username' => $nom));
					$this->load->view('create-step1', $data);
					$this->load->view('templates/footer');
				}
			}
		}
	}


	public function gestion($clef=null) {

		if(!$this->session->userdata('login')) { // vérifie si la personne est connecté
			redirect('/connexion', 'auto');
		}

		if($clef == null) {
			redirect('/', 'auto');	
		}

		$result_sondage = $this->Model_connexion->get_sondage($clef);

		if(!$result_sondage) { // vérifie si le sondage existe pas

			$this->load->view('templates/header-logged', array('username' => $this->session->userdata('nom')));

			$this->load->view('form-answer-null');

			$this->load->view('templates/footer');
		}
		else {

			if(!$this->session->userdata('login') == $result_sondage['login']) { // vérifie si le sondage lui appartient
				redirect('/', 'auto');
			}


			$result_answer = $this->Model_connexion->get_optionsreponseSondage_link_sondage($clef);

			$result_unix = $this->Model_connexion->get_optionsSondage_link_sondage($clef);

			$result_person = $this->Model_connexion->get_reponseSondage_link_sondage($clef);

			$nom = $this->session->userdata('nom');

			$i = 0;

			$tab_plus = array();

			$calcul = null;

			foreach($result_person as $person) {
				$y = 0;

				foreach($result_answer as $answer) {


					if($person['nom'] == $answer['nom']) {

						$tab['nom'] = $answer['nom'];

						$tab["reponses"][$y] = $answer['typeReponse'];

						$tab_plus[$i] = $tab;

						$y = $y + 1;

						if($answer['typeReponse'] == 2) {
							if(!isset($calcul[$answer['unix_timestamp']])) {$calcul[$answer['unix_timestamp']] = 0; }
							$calcul[$answer['unix_timestamp']]++;
						}

					} 
				}
				$i = $i + 1;


			}
			$bigger = 0;
			$unix_bigger = null;
			if(isset($calcul)) {
				foreach($calcul as $possible => $number) {

					if($number > $bigger) {
						$bigger = $number;
					}

				}
				$i = 0;
				foreach($calcul as $possible => $number) {

					if($number == $bigger) {
						$unix_bigger[$i] = $possible; 

						$i++;
					}
				}
			}

			
			$sondage = $this->Model_connexion->get_sondage_link_utilisateur($this->session->userdata('login'));

			foreach($sondage as $row) {

				if(!$this->Model_connexion->get_optionsSondage_link_sondage($row['clef'])) {
					$this->Model_connexion->remove_sondage($row['clef']);
				}
			}

			$sondage = $this->Model_connexion->get_sondage_link_utilisateur($this->session->userdata('login'));
			$data = array(
				'sondages' => $sondage,
				'titre' => $result_sondage['titre'],
				'description' => $result_sondage['description'],
				'lieu' => $result_sondage['lieu'],
				'clef' => $clef,
				'options' => $result_unix,
				'answers' => $tab_plus,
				'final' => $result_sondage['resultat'],
				'bigger' => $unix_bigger
			);

			

			if($this->input->post('result')) {


				if($this->Model_connexion->update_sondage_final_answer($clef, $this->input->post('result'))) {

					redirect("/gestion/$clef", 'auto');
				}
				else {

					$this->load->view('templates/header-logged', array('username' => $nom));

					$this->load->view('sondage-ouvert', $data);

					$this->load->view('templates/footer');
				}

			}

			elseif($this->input->post('clefToDelete')) {

				if($this->Model_connexion->remove_sondage($clef)) {

					redirect("/", 'auto');
				}
				else {


					$this->load->view('templates/header-logged', array('username' => $nom));

					$this->load->view('sondage-ferme', $data);

					$this->load->view('templates/footer');

				}
			}

			else {


				$this->load->view('templates/header-logged', array('username' => $nom));

				if($result_sondage['etat'] == 1) {
					$this->load->view('sondage-ferme', $data);
				}
				else {
					$this->load->view('sondage-ouvert', $data);
				}

				$this->load->view('templates/footer');
			}


		}
	}

}