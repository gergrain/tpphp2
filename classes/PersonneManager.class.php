<?php
class PersonneManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($personne){
		$requete = $this->db->prepare('INSERT INTO personne (per_nom,per_prenom,per_tel,per_mail,per_login,per_pwd) values (:per_nom,:per_prenom,:per_tel,:per_mail,:per_login,:per_pwd)');
		$requete ->bindValue(':per_nom',$personne->getPerNom());
		$requete ->bindValue(':per_prenom',$personne->getPerPrenom());
		$requete ->bindValue(':per_tel',$personne->getPerTel());
		$requete ->bindValue(':per_mail',$personne->getPerMail());
		$requete ->bindValue(':per_login',$personne->getPerLogin());
		$requete ->bindValue(':per_pwd',$personne->getPerPwd());

		$retour=$requete->execute();
		return $retour;
	}
	public function getAllPersonne(){
		$listePersonne = array();
		$sql='Select * from personne ';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($personne=$requete->fetch(PDO::FETCH_ASSOC))
			$listePersonne[] = new Personne($personne);
		$requete->closeCursor();

		return $listePersonne;
	}
	public function getPersonneByNum($per_num){
		$sql='Select * from personne where per_num='.$per_num;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);

		return $res;
	}
	public function getNbrPersonne(){
		$sql='select count(*) as nombre from personne';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);
		return $res['nombre'];
	}
	public function getPersonneByLogin($per_login){
		$sql='Select * from personne where per_login =\''.$per_login.'\'';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);

		return $res;
	}
	public function getLastNumPersonne(){
	
		return $this->db->lastInsertId('per_num');
	}

}