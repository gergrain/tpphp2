<?php
	
if(empty($_POST['vil_num1']) && empty($_POST['vil_num2']) && empty($_POST['par_km'])){
	$pdo = new Mypdo();
	$vilManager = new VilleManager($pdo);
	$villes= $vilManager->getAllVilles();
?>
<h1>Ajouter un Parcours </h1>
<form method="post" class="form-inline" action=#>
		<label>Départ :&nbsp;</label><select class="form-control" name="vil_num1" > 
			<?php
			foreach ($villes as $ville){  

				echo "<option value=\"".$ville->getVilNum()."\">".$ville->getVilNom()."</option>\n";
	 		}
 ?>
		</select>
		
		<label>Arrivée :&nbsp;</label><select class="form-control" name="vil_num2" > 
			<?php
			foreach ($villes as $ville){  

				echo "<option value=\"".$ville->getVilNum()."\">".$ville->getVilNom()."</option>\n";
	 		}
 ?>
		</select>
			<label>Nombre de kilomètre(s)&nbsp; </label>
			 <input type="text" name="par_km" class="form-control"><br>
			 <br>
			<input type="submit" class="btn btn-primary" name="valider" value="valider">
		</form>


<?php
	}else{
		$pdo = new Mypdo();
		$parcManager = new ParcoursManager($pdo);
		if($_POST['vil_num1']==$_POST['vil_num2']){
?>
			<img src="image/erreur.png"> On ne peut pas choisir deux fois la même ville</img>
<?php
		}else{
			if($_POST['par_km']>0){
				if($parcManager->getParcoursExiste($_POST['vil_num1'],$_POST['vil_num2'])==1){
					
					/*var_dump($_POST);*/
					$parcours = new Parcours($_POST);
					$retour = $parcManager->add($parcours);
					if($retour !=0){
				?>
					<img alt="Valide" src="image/valid.png" /> Le Parcours a été ajoutée				<?php
					}else{
				?>
					<img alt="Erreur" src="image/erreur.png" /> Le Parcours n'a pas été ajoutée
				<?php
					}
				}else{
				?>
					<img alt="Erreur" src="image/erreur.png" /> Le Parcours est déjà référencé
		<?php	}
			}else{
?>
			<img alt="Erreur" src="image/erreur.png" /> Le kilométrage ne peut pas être égal à 0 ou ne rien contenir
<?php
			}
		}
	}
?>