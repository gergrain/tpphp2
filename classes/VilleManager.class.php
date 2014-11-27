<?php
class VilleManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($ville){
		$requete = $this->db->prepare('INSERT INTO ville (vil_nom) values (:vil_nom)');
		$requete ->bindValue(':vil_nom',$ville);

		$retour=$requete->execute();
		return $retour;
	}
	public function getAllVilles(){
		$listeVille = array();
		$sql='Select vil_num,vil_nom from ville order by vil_num';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($ville=$requete->fetch(PDO::FETCH_ASSOC))
			$listeVille[] = new Ville($ville);
		$requete->closeCursor();

		return $listeVille;
	}
	public function getAllVillesExcept($vil_num){
		$listeVille = array();
		$sql='Select vil_num,vil_nom from ville where vil_num not in(select vil_num from ville where vil_num='.$vil_num.')';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($ville=$requete->fetch(PDO::FETCH_ASSOC))
			$listeVille[] = new Ville($ville);
		$requete->closeCursor();

		return $listeVille;
	}
	public function getNomVilleByNum($vil_num){
		$sql='Select vil_nom from ville where vil_num='.$vil_num;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);

		return $res['vil_nom'];
	}

	public function getNbrVille(){
		$sql='select count(*) as nombre from ville';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);
		return $res['nombre'];
	}
}