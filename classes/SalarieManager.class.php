<?php
class SalarieManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($salarie){
		$requete = $this->db->prepare('INSERT INTO salarie (per_num,sal_telprof,fon_num) values (:per_num,:sal_telprof,:fon_num)');
		$requete ->bindValue(':per_num',$salarie->getPerNum());
		$requete ->bindValue(':sal_telprof',$salarie->getSalTelProf());
		$requete ->bindValue(':fon_num',$salarie->getFonNum());


		$retour=$requete->execute();
		return $retour;
	}
	public function getAllSalarie(){
		$listeSalarie = array();
		$sql='Select * from salarie';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($salarie=$requete->fetch(PDO::FETCH_ASSOC))
			$listeSalarie[] = new Salarie($salarie);
		$requete->closeCursor();

		return $listeSalarie;
	}
	public function getSalarieByNum($per_num){
		$sql='Select * from salarie where per_num='.$per_num;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);

		return $res;
	}
}