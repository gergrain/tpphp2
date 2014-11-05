<?php
class Salarie{
	private $per_num;
	private $sal_telprof;
	private $fon_num;

	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this -> affecte($valeur);
		}
	}
	public function affecte($donnees){
		foreach ($donnees as $attribut => $valeur) {
			switch ($attribut) {
				case 'per_num':
					$this->setPernum($valeur);
					break;
				case 'sal_telprof':
					$this->setSalTelProf($valeur);
					break;
				case 'fon_num':
					$this->setFonNum($valeur);
					break;
			}
		}
	}
	public function getPernum(){
		return $this->per_num;
	}
	public function setPernum($per_num){
		$this->per_num=$per_num;
	}
	public function getSalTelProf(){
		return $this->sal_telprof;
	}
	public function setSalTelProf($sal_telprof){
		$this->sal_telprof=$sal_telprof;
	}
	public function getFonNum(){
		return $this->fon_num;
	}
	public function setFonNum($fon_num){
		$this->fon_num=$fon_num;
	}

}