<?php
class FonctionManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($fonction){
		$requete = $this->db->prepare('INSERT INTO fonction (fon_num,fon_libelle) values (:fon_num,:fon_libelle)');
		$requete ->bindValue(':fon_num',$fonction->getFonNum());
		$requete ->bindValue(':fon_libelle',$fonction->getFonLibelle());


		$retour=$requete->execute();
		return $retour;
	}
	public function getAllFonction(){
		$listeFonction = array();
		$sql='Select * from fonction';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($fonction=$requete->fetch(PDO::FETCH_ASSOC))
			$listeFonction[] = new Fonction($fonction);
		$requete->closeCursor();

		return $listeFonction;
	}
	public function getNomFonctionByNum($fon_num){
		$sql='Select * from fonction where fon_num='.$fon_num;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);

		return $res['fon_libelle'];
	}
	
}
?>
