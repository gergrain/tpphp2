<h1>Proposer un trajet</h1>
<?php
$pdo = new Mypdo();
$vilManager = new VilleManager($pdo);
if(!empty($_SESSION['connexion'])){
	if(empty($_POST['vil_num1'])&&empty($_POST['vil_num2'])&&empty($_POST['pro_date'])&&empty($_POST['pro_time'])){
		$villes= $vilManager->getAllVilles();
	?>
	<form method="post" action=#>
			Ville de départ :<select name="vil_num1" > 
				<?php
				foreach ($villes as $ville){  

					echo "<option value=\"".$ville->getVilNum()."\">".$ville->getVilNom()."</option>\n";
		 		}
	 ?>
				<input type="submit" class="bouton" name="valider" value="valider">
	</form>
	<?php
	}else{
		$parcManager = new ParcoursManager($pdo);
		if((!empty($_POST['vil_num1']))&&empty($_POST['vil_num2'])&&empty($_POST['pro_date'])&&empty($_POST['pro_time'])){
			$ville= $vilManager->getNomVilleByNum($_POST['vil_num1']);
			
			$parcours= $parcManager->TrajetExistant($_POST['vil_num1']);
			$_SESSION['vil_num1']=$_POST['vil_num1'];
		?>
		<form method="post" action=#>
				<div class="champ">
					Ville de départ : <?php  echo $ville;  ?>
					Ville de d'arrivée :<select name="vil_num2" >
				</div>
					<?php
					foreach ($parcours as $parcour){  

						echo "<option value=\"".$parcour['vil_num']."\">".$vilManager->getNomVilleByNum($parcour['vil_num'])."</option>\n";
			 		}
		 ?>
		 		</select>
			 	<div>
			 		Heure départ : <input type="time" name="pro_time" value="<?php echo gmdate("H:i",time() + 3600*(2+date("I")));  ?>">
			 		</div>
			 	<div>
			 		Date de départ : <input type="date" name="pro_date" value="<?php echo date("Y-m-d");  ?>">
			 		</div>
			 	<div>
			 		Nombre de places : <input type="text" name="pro_place" pattern="([0-9])">
			 		</div>
					<input type="submit" class="bouton" name="valider" value="valider">
		</form>
		<?php
		}else{
			$sens=$parcManager->getSens($_SESSION['vil_num1'],$_POST['vil_num2']);
			$parnum=$parcManager->getParNum($_SESSION['vil_num1'],$_POST['vil_num2']);
			$persManager=new PersonneManager($pdo);
			$per_num=$persManager->getPersonneByLogin($_SESSION['connexion']);
			$proManager= new ProposeManager($pdo);
			$propose = new Propose(array('par_num' => $parnum,'per_num' =>$per_num['per_num'] ,
				'pro_date' =>$_POST['pro_date'] ,'pro_time' => $_POST['pro_time'] ,
				'pro_place' => $_POST['pro_place'] ,'pro_sens' =>$sens));
			$retour = $proManager->add($propose);
			if($retour){
		?>
			<br><img src="image/valid.png"> Votre proposition de trajet a été ajoutée</img>
		<?php
			}else{
		?>
			<br><img src="image/erreur.png"> Votre proposition de trajet n'a pas été ajoutée</img>
		<?php
			}

		?>
		<?php
		}
	}
}else{
	echo 'Vous devez être connecté pour proposer un trajet';
}
	?>