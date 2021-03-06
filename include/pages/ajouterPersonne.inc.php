<script>
$(document).ready(function() {
    $('#etu').hide();
    $('#perso').hide();

    $('#etudiant').change(function () {
    	
    	$('#perso').hide();
    	$('#etu').show();
	});
	$('#personnel').change(function () {
		$('#etu').hide();
	  $('#perso').show();
	});

});
</script>	
<?php
	
if(empty($_POST['per_nom']) && empty($_POST['per_prenom'])
	&& empty($_POST['per_tel'])&& empty($_POST['per_login'])
	&& empty($_POST['per_mail'])&& empty($_POST['per_pwd'])
	&&empty($_POST['categorie'])&& empty($_POST['div_num'])
	&& empty($_POST['dep_num'])&&empty($_POST['sal_telprof'])&&empty($_POST['fon_num'])) {
	$pdo = new Mypdo();
	$perManager = new PersonneManager($pdo);
	$personnes= $perManager->getAllPersonne();
	$divManager = new DivisionManager($pdo);
	$depManager = new DepartementManager($pdo);
	$divisions = $divManager->getAllDivision();
	$departements = $depManager->getAllDepartement();
	$fonManager = new FonctionManager($pdo);
	$fonctions = $fonManager->getAllFonction();		

	
?>
<h1>Ajouter une personne</h1>
<form method="post" class="form-inline" action=#>
		<div class="col-sm-10 col-sm-push-1">
			<div class="drt col-sm-5">
				<label>Nom :</label>
				<input type="text" name="per_nom" class="form-control maj" required="required" />
			</div>
			<div class="drt col-sm-5">
				<label>Prenom :</label>
					<input type="text" name="per_prenom" class="form-control capit" required="required" />
			</div>	
		</div>
		<div class="col-sm-10 col-sm-push-1 spacer">
			<div class="col-sm-5 drt">
				<label>Téléphone : </label>
					<input type="tel" name="per_tel" pattern="(0[0-9]{9})" class="form-control" required="required" maxlength="10" /> 
			</div>
			<div class="col-sm-5 drt ">
				<label>Mail : </label>
					<input type="email" name="per_mail" class="form-control" required="required" />
			</div>
		</div>
		<div class="col-sm-10 col-sm-push-1 spacer">
			<div class="col-sm-5 drt">
				<label>Login : </label>
					<input type="text" name="per_login" class="form-control" required="required" /> 
			</div>
			<div class="col-sm-5 drt ">

				<label>Mot de passe : </label>
				<input type="password" name="per_pwd" class="form-control" required="required" />
			</div>
		</div>
		<div class="col-sm-10 col-sm-push-1 spacer">
			<label>Catégorie : </label>
			<input type="radio" name="categorie" id="etudiant" value="etudiant" required="required" />Etudiant
			<input type="radio" name="categorie"  id="personnel" value="personnel" required="required" />Personnel
		</div>
		<div id="etu" >
			<div class="col-sm-7 drt spacer">
				<label>Annee : </label>
				<select class="form-control" name="div_num"> 
					<?php
					foreach ($divisions as $division){ ?> 
						<option value="<?php echo $division->getDivNum(); ?>"><?php echo $division->getDivnom() ?></option>
			 		<?php }?>
			 	</select>
			</div>
			<br>
			<div class="col-sm-7 drt spacer">
				<label>Département :&nbsp;</label>
				<select  class="form-control" name="dep_num" > 
					<?php
					foreach ($departements as $departement){  
					?>
						<option value="<?php echo $departement->getDepNum(); ?>"><?php echo $departement->getDepNom() ?></option>
			 		<?php }
		 ?>
		 		</select>
		 	</div>
	 	</div>
	 	<div id="perso">
	 		<div class="col-sm-7 drt spacer">
		 		<label>Téléphone professionelle : &nbsp;</label>
				<input type="text" class="form-control" name="sal_telprof" >
			</div>
			<div class="col-sm-7 drt spacer">
				<label>Fonction :&nbsp;</label>
				<select class="form-control" name="fon_num" > 
					<?php
					foreach ($fonctions as $fonction){  
						?>

						<option value="<?php echo $fonction->getFonNum(); ?>"><?php echo $fonction->getFonLibelle() ?></option>
			 	<?php	}
		 ?>
		 		</select>
		 	</div>
	 	</div>	

		<br>
		<div class="col-sm-10 col-sm-push-1">
			<input type="submit" name="Valider" class="btn btn-primary" value="Valider">
		</div>
	</form>


<?php
	}else{

	$salt="48@!alsd";
	$_POST['per_pwd']=sha1(sha1($_POST['per_pwd']).$salt);
	$pdo = new Mypdo();
	$perManager = new PersonneManager($pdo);
	$personne = new Personne($_POST);
	$retour = $perManager->add($personne);
	$per_num=$perManager->getLastNumPersonne();

		if($_POST['categorie']=='etudiant'){
				$etuManager=new EtudiantManager($pdo);
				$etudiant = new Etudiant(array('per_num'=>$per_num,'div_num'=>$_POST['div_num'],'dep_num'=>$_POST['dep_num']));
				$etuManager->add($etudiant);
		}else{
				$salManager=new SalarieManager($pdo);
				$salarie = new salarie(array('per_num'=>$per_num,'sal_telprof'=>$_POST['sal_telprof'],'fon_num'=>$_POST['fon_num']));
				$salManager->add($salarie);

		}
	unset($_POST);
		if($retour){
	?>
		<br><img src="image/valid.png" alt="ajouté"/> La personne a été ajoutée
	<?php
		header('Refresh: 4; URL=#');
		}else{
	?>
		<br><img src="image/erreur.png" alt="Erreur d'ajout"/> Le personne n'a pas été ajoutée
	<?php
		}
}
?>