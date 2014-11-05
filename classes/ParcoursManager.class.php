<?php
class ParcoursManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($parcours){
		$requete = $this->db->prepare('INSERT INTO parcours (par_km,vil_num1,vil_num2) values (:par_km,:vil_num1,:vil_num2)');
		$requete ->bindValue(':par_km',$parcours->getParKm());
		$requete ->bindValue(':vil_num1',$parcours->getVilNum1());
		$requete ->bindValue(':vil_num2',$parcours->getVilNum2());

		$retour=$requete->execute();
		return $retour;
	}
	public function getAllParcours(){
		$listeParcours = array();
		$sql='Select * from parcours order by par_num';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($parcours=$requete->fetch(PDO::FETCH_ASSOC))
			$listeParcours[] = new Parcours($parcours);
		$requete->closeCursor();

		return $listeParcours;
	}
	public function getNbrParcours(){
		$sql='select count(*) as nombre from parcours';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$res = $requete->fetch(PDO::FETCH_ASSOC);
		return $res['nombre'];
	}
	public function getParcoursExiste($vil_num1,$vil_num2){
		$sql='select  * from parcours where vil_num1='.$vil_num1.' and vil_num2='.$vil_num2;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		if ($requete->fetch(PDO::FETCH_ASSOC)) {
			return -1;
		}
		$sql='select  * from parcours where vil_num2='.$vil_num1.' and vil_num1='.$vil_num2;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		if ($requete->fetch(PDO::FETCH_ASSOC)) {
			return -1;
		}
		return 1;
	}
	public function TrajetExistant($vil_num){
		$listeNum = array();
		$sql='select  par_num,vil_num1 as vil_num from parcours where vil_num2='.$vil_num.'
		union
		 select  par_num,vil_num2 as vil_num from parcours where vil_num1='.$vil_num;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($parcours=$requete->fetch(PDO::FETCH_ASSOC))
			$listeNum[] = $parcours;
		$requete->closeCursor();

		return $listeNum;

	}
	public function getSens($vil_num1,$vil_num2){
		$sql='select  0 as sens from parcours where vil_num2='.$vil_num2.' and vil_num1='.$vil_num1.'
		union
		 select  1 as sens from parcours where vil_num2='.$vil_num1.' and vil_num1='.$vil_num2;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$sens=$requete->fetch(PDO::FETCH_ASSOC);
		$requete->closeCursor();

		return $sens['sens'];
	}
	public function getParNum($vil_num1,$vil_num2){
		$sql='select  par_num from parcours where vil_num2='.$vil_num2.' and vil_num1='.$vil_num1.'
		union
		 select  par_num from parcours where vil_num2='.$vil_num1.' and vil_num1='.$vil_num2;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$parnum=$requete->fetch(PDO::FETCH_ASSOC);
		$requete->closeCursor();

		return $parnum['par_num'];
	}

}