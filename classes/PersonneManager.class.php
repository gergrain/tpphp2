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
	public function getNumPersonne($nom,$prenom,$login,$per_mail,$per_tel){
		$sql='select per_num from personne where per_tel=\''.$per_tel.'\' and per_mail=\''.$per_mail.'\'';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);
		return $res['per_num'];
	}
	public function suprPersonne($per_num){
		$sql='delete from propose where per_num='.$per_num.';'.
		'delete from salarie where per_num='.$per_num.';'.
		'delete from etudiant where per_num='.$per_num.';'.
		'delete from personne where per_num='.$per_num;
		$requete = $this->db->prepare($sql);
		$res=$requete->execute();
		return $res;
	}
	public function modifierPersonneSaufMdp($personne,$per_num){
		$sql="update personne set per_nom=\"".$personne->getPerNom()."\" where per_num=$per_num;
		update personne set per_prenom=\"".$personne->getPerPrenom()."\" where per_num=$per_num;
		update personne set per_mail=\"".$personne->getPerMail()."\" per_num=$per_num;
		update personne set per_tel=\"".$personne->getPerTel()."\" per_num=$per_num;
		update personne set per_login=\"".$personne->getPerLogin()."\" per_num=$per_num";
		$requete = $this->db->prepare($sql);
		$res=$requete->execute();
		return $res;
	}
	public function modifierMdpPersonne($mdp,$per_num){
		$sql="update personne set per_pwd=\"".$mdp."\" where per_num=$per_num";
		$requete = $this->db->prepare($sql);
		$res=$requete->execute();
		return $res;
	}
}