<?php
class EtudiantManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($etudiant){
		$requete = $this->db->prepare('INSERT INTO etudiant(per_num,dep_num,div_num) values (:per_num,:dep_num,:div_num)');
		$requete ->bindValue(':per_num',$etudiant->getPerNum());
		$requete ->bindValue(':dep_num',$etudiant->getDepNum());
		$requete ->bindValue(':div_num',$etudiant->getDivNum());
		$retour=$requete->execute();
		return $retour;
	}
	public function getAllEtudiant(){
		$listeEtudiant = array();
		$sql='Select * from etudiant';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($etudiant=$requete->fetch(PDO::FETCH_ASSOC))
			$listeEtudiant[] = new Etudiant($etudiant);
		$requete->closeCursor();

		return $listeEtudiant;
	}
	public function getEtudiantByNum($per_num){
		$sql='Select * from etudiant where per_num='.$per_num;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);

		return $res;
	}
	public function supprimerEtubyid($per_num){
		$sql='delete from etudiant where per_num='.$per_num;
		$requete = $this->db->prepare($sql);
		
		$res = $requete->execute();
		return $res;
	}

}