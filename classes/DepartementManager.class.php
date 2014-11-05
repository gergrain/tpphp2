<?php
class DepartementManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($departement){
		$requete = $this->db->prepare('INSERT INTO departement (dep_num,dep_nom,vil_num) values (:dep_num,:dep_nom,:vil_num)');
		$requete ->bindValue(':dep_num',$departement->getDivNum());
		$requete ->bindValue(':dep_nom',$departement->getDivNom());
		$requete ->bindValue(':vil_num',$departement->getVilNum());


		$retour=$requete->execute();
		return $retour;
	}
	public function getAllDepartement(){
		$listeDepartement = array();
		$sql='Select * from departement';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($departement=$requete->fetch(PDO::FETCH_ASSOC))
			$listeDepartement[] = new Departement($departement);
		$requete->closeCursor();

		return $listeDepartement;
	}
	public function getNomDepByNum($dep_num){
		$sql='Select * from departement where dep_num='.$dep_num;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);

		return $res;
	}
}