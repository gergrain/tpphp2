<?php
class DivisionManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($division){
		$requete = $this->db->prepare('INSERT INTO division (div_num,div_nom) values (:div_num,:div_nom)');
		$requete ->bindValue(':div_num',$division->getDivNum());
		$requete ->bindValue(':div_nom',$division->getDivNom());


		$retour=$requete->execute();
		return $retour;
	}
	public function getAllDivision(){
		$listeDivision = array();
		$sql='Select * from division';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($division=$requete->fetch(PDO::FETCH_ASSOC))
			$listeDivision[] = new Division($division);
		$requete->closeCursor();

		return $listeDivision;
	}
}