<?php
class ProposeManager{
	private $db;
	public function __construct($db){
		$this->db = $db;
	}
	public function add($propose){
		$requete = $this->db->prepare('INSERT INTO propose (par_num,per_num,pro_date,pro_time,pro_place,pro_sens)
											 values (:par_num,:per_num,:pro_date,:pro_time,:pro_place,:pro_sens)');
		$requete ->bindValue(':par_num',$propose->getParNum());
		$requete ->bindValue(':per_num',$propose->getPerNum());
		$requete ->bindValue(':pro_date',$propose->getProDate());
		$requete ->bindValue(':pro_time',$propose->getProTime());
		$requete ->bindValue(':pro_place',$propose->getProPlace());
		$requete ->bindValue(':pro_sens',$propose->getProSens());
		$retour=$requete->execute();
		return $retour;
	}
	public function getAllPropose(){
		$listePropose = array();
		$sql='Select * from propose';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($propose=$requete->fetch(PDO::FETCH_ASSOC))
			$listePropose[] = new Propose($propose);
		$requete->closeCursor();

		return $listePropose;
	}
	public function getAllVilles(){
		$listevilles = array();
		$sql='Select vil_num1 as vil_num from propose pro
				join parcours par on  par.par_num=pro.par_num
			union
			Select vil_num2 as vil_num from propose pro
				join parcours par on  par.par_num=pro.par_num';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($propose=$requete->fetch(PDO::FETCH_ASSOC))
			$listeVilles[] = $propose['vil_num'];
		$requete->closeCursor();

		return $listeVilles;		
	}
	public function getTrajet($par_num,$sens,$datedeb,$datefin,$heure){
		$listTrajet = array();
		$sql="select * from propose where 
		par_num=$par_num and pro_sens=$sens 
		and pro_time>=\"$heure:00\" and pro_date between \"$datedeb\" and \"$datefin\"";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while($propose=$requete->fetch(PDO::FETCH_ASSOC))
			$listTrajet[] = new Propose($propose);
		$requete->closeCursor();
		return $listTrajet;
	}
}
?>