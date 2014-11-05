<h1>Rechercher un trajet</h1>
<?php
$pdo = new Mypdo();
$proManager = new ProposeManager($pdo);
$vilManager = new VilleManager($pdo);
if(!empty($_SESSION['connexion'])){
	if(empty($_POST['vil_num1'])&&empty($_POST['vil_num2'])&&empty($_POST['pro_date'])&&empty($_POST['pro_time'])){
		$proposes= $proManager->getAllVilles();
		var_dump($proposes);
	?>
	<form method="post" action=#>
			Ville de départ :<select name="vil_num1" > 
				<?php
				foreach ($proposes as $propose){  

					echo "<option value=\"".$propose."\">".$vilManager->getNomVilleByNum($propose)."</option>\n";
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
			 		Date de départ : <input type="date" class="form-control" name="pro_date" value="<?php echo date("Y-m-d");  ?>">
			 		</div>
			 	<div>
			 		Précision : <select name="precision">
			 		<option value="0">Ce jour</option>
			 		<option value="1">+/- 1 jour</option>
			 		<option value="2">+/- 2 jours</option>
			 		<option value="3">+/- 3 jours</option>
			 	</select>
			 	</div>
			 	A partir de : <SELECT multiple class="form-control" name="depart" >
			 		<?php 
					for ($i = 00; $i <= 23; $i++) {
					    echo "<OPTION> $i h </option>";
					}
			 		?>
				</SELECT>
				<br>
					<input type="submit" class="bouton" name="valider" value="valider">
		</form>
		<?php
		}else{
			
			if($retour){
		?>
			<br>
		<?php
			}else{
		?>
			<br><img src="image/erreur.png">Désolé pas de trajet disponible</img>
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