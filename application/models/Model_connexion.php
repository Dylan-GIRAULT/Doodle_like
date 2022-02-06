
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_connexion extends CI_Model {
	public function __construct(){
	$this->load->database();
	}


	public function deconnect() {

		$data = array('nom', 'prenom', 'login', 'email');

		$this->session->unset_userdata($data);
	}

	/**
	 * Créer un utilisateur
	 *
	 * contact : array avec un nom, password, prenom, login et email (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function set_utilisateur($contact){
		$data = array(
			'nom' => $contact['nom'],
			'password_hash' => password_hash($contact['password'], PASSWORD_DEFAULT),
			'prenom' => $contact['prenom'],
			'email' => $contact['email'],
			'login' => $contact['login']
		);

		return $this->db->insert('utilisateur', $data);
	}

	/**
	 * Créer un sondage
	 *
	 * sondage : array avec un titre, description, lieu, login, clef (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function set_sondage($sondage){

		$data = array(
			'login' => $sondage['login'],
			'titre' => $sondage['titre'],
			'lieu' => $sondage['lieu'],
			'etat' => 0,
			'description' => $sondage['description'],
			'clef' => $sondage['clef']
		);

		return $this->db->insert('sondage', $data);
	}


	/**
	 * Créer une réponse à un sondage
	 *
	 * contact : array avec un nom, clefSondage (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function set_reponseSondage($reponse){
		$data = array(
			'nom' => $reponse['nom'],
			'clefSondage' => $reponse['clefSondage']
		);

		return $this->db->insert('reponseSondage', $data);
	}

	/**
	 * Créer/remplace une réponse à un sondage
	 *
	 * contact : array avec un nom, clefSondage (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function replace_reponseSondage($reponse){
		$data = array(
			'nom' => $reponse['nom'],
			'clefSondage' => $reponse['clefSondage']
		);

		return $this->db->replace('reponseSondage', $data);
	}

	/**
	 * Créer une option à un sondage
	 *
	 * contact : array avec un unix_timestamp, clefSondage (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function set_optionsSondage($option){
		$data = array(
			'unix_timestamp' => $option['unix_timestamp'],
			'clefSondage' => $option['clefSondage']
		);

		return $this->db->insert('optionsSondage', $data);
	}

	/**
	 * Créer une option à un sondage
	 *
	 * contact : array avec un unix_timestamp, clefSondage, nom, typeReponse (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function set_optionReponseSondage($option) {
		$data = array(
			'unix_timestamp' => $option['unix_timestamp'],
			'clefSondage' => $option['clefSondage'],
			'nom' => $option['nom'],
			'typeReponse' => $option['typeReponse']
		);

		return $this->db->insert('optionsReponseSondage', $data);
	}

	/**
	 * Créer une option à un sondage
	 *
	 * contact : array avec un unix_timestamp, clefSondage, nom, typeReponse (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function remove_optionReponseSondage($options) {

		$this->db->where('clefSondage', $options['clefSondage']);

		$this->db->where('unix_timestamp', $options['unix_timestamp']);

		$this->db->where('nom', $options['nom']);

		return $this->db->delete('optionsReponseSondage');
	}

	/**
	 * login : String
	 *
	 * return : array lié au "$login" / toutes les informations à propos de l'utilisateur $login
	 */
	public function get_utilisateur($login) { 

		$this->db->select('*');
		$this->db->where('login', $login);
		$this->db->from('utilisateur');

		$query = $this->db->get();

		$tableau = $query->row_array();

		return $tableau;

	}

	/**
	 * login : String
	 * password : String (non hash)
	 *
	 * return : "false" le compte n'existe pas / "true" le compte existe
	 */
	public function check_utilisateur($login, $password) { 

		$this->db->select('*');
		$this->db->where('login', $login);
		$this->db->from('utilisateur');

		$query = $this->db->get();

		$tableau = $query->row_array();

		if(!isset($tableau)) return false;

		if(password_verify($password, $tableau['password_hash'])) {
			$answer = true;
		}
		else {
			$answer = false;
		}

		return $answer;

	}

	/**
	 * clef : String
	 *
	 * return : array lié au "$clef" / toutes les informations à propos du sondage $clef 
	 */
	public function get_sondage($clef=null) { 

		if($clef == null) {
			$clef = '';
		}

		$this->db->select('*');
		$this->db->where('clef', $clef);
		$this->db->from('sondage');

		$query = $this->db->get();

		$tableau = $query->row_array();

		return $tableau;

	}

	/**
	 * clef : String
	 *
	 * return : array lié au "$clef" / horaires au sondage $clef 
	 */
	public function get_unix_timestamp_from_sondage($clef=null) { 

		if($clef == null) {
			$clef = '';
		}

		$query = $this->db->query("SELECT unix_timestamp FROM sondage NATURAL JOIN optionsSondage WHERE clef = '$clef'");

		$tableau = $query->row_array();

		return $tableau;

	}

	/**
	 * login : String
	 *
	 * return : plusieurs class lié au "$login" / tous les sondages créer par l'utilisateur $login
	 */
	public function get_sondage_link_utilisateur($login) {

		$result = $this->db->query("SELECT * 
									FROM sondage
									WHERE login = '$login' ");

		$query = $result->result_array();

		return $query;

	}

	/**
	 * clef : String
	 *
	 * return : plusieurs class lié au "$clef" / tous les options du sondage $clef
	 */
	public function get_optionsSondage_link_sondage($clef) {

		$result = $this->db->query("SELECT unix_timestamp FROM optionsSondage WHERE clefSondage = '$clef' ");

		$query = $result->result_array();

		return $query;

	}

	/**
	 * Créer une option à un sondage
	 *
	 * contact : array avec un unix_timestamp, clefSondage (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function remove_reponseSondage($options) {

		$this->db->where('clefSondage', $options['clefSondage']);

		$this->db->where('nom', $options['nom']);

		return $this->db->delete('reponseSondage');
	}

	/**
	 * clef : String
	 *
	 * return : plusieurs class lié au "$clef" / tous les réponses du sondage $clef au nom de $name
	 */
	public function get_reponseSondage_link_sondage_zoom($clef, $name) {

		$result = $this->db->query("SELECT * FROM reponseSondage WHERE clefSondage = '$clef' AND nom = '$name' ");

		$query = $result->row_array();

		return $query;

	}

	/**
	 * clef : String
	 *
	 * return : plusieurs class lié au "$clef" / tous les options du sondage $clef
	 */
	public function get_optionsSondage_zoom($clef, $unix) {

		$result = $this->db->query("SELECT * FROM optionsSondage WHERE clefSondage = '$clef' AND unix_timestamp = '$unix' ");

		$query = $result->result_array();

		return $query;

	}

	/**
	 * clef : String
	 *
	 * return : plusieurs class lié au "$clef" / tous les réponses du sondage $clef au nom de $name
	 */
	public function get_optionreponseSondage_link_sondage_zoom($options) {

		$result = $this->db->query("SELECT * FROM optionsReponseSondage WHERE 
			clefSondage = '$options[clefSondage]' AND nom = '$options[nom]' AND unix_timestamp = '$options[unix_timestamp]' ");

		$query = $result->row_array();

		return $query;

	}

	/**
	 * clef : String
	 *
	 * return : plusieurs class lié au "$clef" / toutes les réponses du sondage $clef
	 */
	public function get_reponseSondage_link_sondage($clef) {

		$result = $this->db->query("SELECT nom FROM reponseSondage WHERE clefSondage = '$clef' ");

		$query = $result->result_array();

		return $query;

	}

	/**
	 * Créer une option à un sondage
	 *
	 * contact : array avec un unix_timestamp, clefSondage (RESPECTER LA NOMATION)
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function remove_optionsSondage($options) {

		$this->db->where('clefSondage', $options['clefSondage']);

		$this->db->where('unix_timestamp', $options['unix_timestamp']);

		return $this->db->delete('optionsSondage');
	}

	/**
	 * clef : String
	 *
	 * return : plusieurs class lié au "$clef" / toutes les réponses et options du sondage $clef
	 */
	public function get_optionsreponseSondage_link_sondage($clef) {

		$result = $this->db->query("SELECT nom, typeReponse, unix_timestamp FROM optionsReponseSondage WHERE clefSondage = '$clef' ");

		$query = $result->result_array();

		return $query;

	}

	/**
	 * clef : String UNIQUE
	 * reponse : String / date en unixstamp
	 *
	 * return : plusieurs class lié au "$clef" / toutes les réponses du sondage $clef
	 */
	public function update_sondage_final_answer($clef, $reponse) {

		$this->db->set('resultat', $reponse);
		$this->db->set('etat', 1);
		$this->db->where('clef', $clef);

		return $this->db->update('sondage');


	}

	/**
	 * Supprime toutes les informtions liées au sondage et le sondage
	 *
	 * clef : String UNIQUE
	 *
	 * return : "true" l'opération s'est bien passé / "false" l'opération ne s'est pas bien passé
	 */
	public function remove_sondage($clef) {

		$this->db->where('clefSondage', $clef);

		$test_optionReponse = $this->db->delete('optionsReponseSondage');

		$this->db->where('clefSondage', $clef);

		$test_options = $this->db->delete('optionsSondage');

		$this->db->where('clefSondage', $clef);

		$test_reponse = $this->db->delete('reponseSondage');
		

		$this->db->reset_query();

		$this->db->where('clef', $clef);

		$test = $this->db->delete('sondage');

		return $test_optionReponse && $test_options && $test_reponse && $test; 
			
	}
}

?>