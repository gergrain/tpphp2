<script>
  	webshims.setOptions('waitReady', false);
 	webshims.setOptions('forms-ext', {types: 'date'});
 	webshims.polyfill('forms forms-ext');
</script>

<?php
$pdo = new Mypdo();
$proManager = new ProposeManager($pdo);
$vilManager = new VilleManager($pdo);
$parcManager = new ParcoursManager($pdo);
if(!empty($_SESSION['connexion'])){
	if(empty($_POST['vil_num1'])&&empty($_POST['vil_num2'])&&empty($_POST['pro_date'])&&empty($_POST['pro_time'])){
		$proposes= $proManager->getAllVilles();
	?>
	<h1>Rechercher un trajet</h1>
	<form method="post" action=# class="form-inline">
			<label>Ville de départ : &nbsp</label><select class="form-control" name="vil_num1" > 
				<?php
				foreach ($proposes as $propose){  

					echo "<option value=\"".$propose."\">".$vilManager->getNomVilleByNum($propose)."</option>\n";
		 		}
	 ?>			
	 		</select>
	 		<br>
	 		<br>
				<input type="submit" class="btn btn-primary" name="valider" value="valider">
	</form>
	<?php
	}else{
		
		if((!empty($_POST['vil_num1']))&&empty($_POST['vil_num2'])&&empty($_POST['pro_date'])&&empty($_POST['pro_time'])){
			$ville= $vilManager->getNomVilleByNum($_POST['vil_num1']);
			
			$parcours= $parcManager->TrajetExistant($_POST['vil_num1']);
			$_SESSION['vil_num1']=$_POST['vil_num1'];
		?>
		<h1>Rechercher un trajet</h1>
		<form method="post" action=# class="form-inline">
					<div>
						<div>	
							<label>Ville de départ : &nbsp</label><?php  echo $ville;  ?>
						</div>
						<div>
							<label>Ville de d'arrivée : &nbsp</label><select class="form-control" name="vil_num2" >
						</div>
					</div>
					<?php
					foreach ($parcours as $parcour){  

						echo "<option value=\"".$parcour['vil_num']."\">".$vilManager->getNomVilleByNum($parcour['vil_num'])."</option>\n";
			 		}
		 ?>
		 		</select>
			 	<div>
			 		<label>Date de départ : &nbsp</label>

			 		<!-- cdn for modernizr, if you haven't included it already -->
					<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
					<!-- polyfiller file to detect and load polyfills -->
					<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>

					<script>
					  webshims.setOptions('waitReady', false);
					  webshims.setOptions('forms-ext', {types: 'date'});
					  webshims.polyfill('forms forms-ext');
					</script>
					<input type="date" class="form-control" name="pro_date" value="<?php echo date("Y-m-d");  ?>">
			 		</div>
			 	<div>
			 		<label>Précision : &nbsp</label><select class="form-control" name="precision">
			 		<option value="0" >Ce jour</option>
			 		<option value="1">+/- 1 jour</option>
			 		<option value="2">+/- 2 jours</option>
			 		<option value="3">+/- 3 jours</option>
			 	</select>
			 	</div>
			 	<label>A partir de : &nbsp</label><SELECT multiple class="form-control" name="depart" >
			 		<OPTION value=0 selected> 0 h </option>
			 		<?php 
					for ($i = 1; $i <= 23; $i++) {
					    echo "<OPTION value=$i> $i h </option>";
					}
			 		?>
				</SELECT>
				<br>
				<br>
					<input type="submit" class="btn btn-primary" name="valider" value="valider">
		</form>
		<?php
		}else{
			$persManager = new PersonneManager($pdo);
			$par_num= $parcManager->getParNum($_SESSION['vil_num1'],$_POST['vil_num2']);
			$sens =$parcManager->getSens($_SESSION['vil_num1'],$_POST['vil_num2']);
			$trajets = $proManager->getTrajet($par_num,$sens,addJours(getFrenchDate($_POST['pro_date']),'-'.''.$_POST['precision']),addJours(getFrenchDate($_POST['pro_date']),
							$_POST['precision']),$_POST['depart']);
			if($trajets){
		?>
			<table class="table table-striped">
				<caption><h1>Liste des trajets trouvés</h1></caption>
		<thead>
			<tr>
				<th>Ville de départ</th>
				<th>Ville d'arrivée</th>
				<th>Date de départ</th>
				<th>Heure de départ</th>
				<th>Nombre de place</th>
				<th>Nom du covoitureur</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach ($trajets as $trajet) {
					
			?>
			<tr>
				<td><?php echo $vilManager->getNomVilleByNum($_SESSION['vil_num1']); ?></td>
				<td><?php echo $vilManager->getNomVilleByNum($_POST['vil_num2']); ?></td>
				<td><?php echo getFrenchDate($trajet->getProDate()); ?></td>
				<td><?php echo getHeure($trajet->getProTime()); ?></td>
				<td><?php echo $trajet->getProPlace(); ?></td>
				<td><?php echo $persManager->getPersonneByNum($trajet->getPerNum())['per_nom'].' '.$persManager->getPersonneByNum($trajet->getPerNum())['per_prenom']; ?></td>
			</tr>
			<?php
			}
			?>
		</tbody>
</table>
		<?php
			}else{
		?>
			<div class="alert alert-danger" role="alert">
				<img src="image/erreur.png">Désolé pas de trajet disponible</img>
			</div>
		<?php
			}

		?>
		<?php
		}
	}
}else{
	echo 'Vous devez être connecté pour rechercher un trajet';
}
?>