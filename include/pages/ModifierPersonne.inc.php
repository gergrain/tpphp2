<script>
$(document).ready(function() {
    $('#etu').hide();
    $('#perso').hide();
    if($('#etudiant').is(':checked')) {
    	$('#perso').hide();
    	$('#etu').show();
     };
     if($('#personnel').is(':checked')) {
    	$('#etu').hide();
    	$('#perso').show();
     };
   
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
	$etuManager=new EtudiantManager($pdo);
	$salManager= new SalarieManager($pdo);	

	
?>
<h1>Modifier une personne</h1>
<form method="post" class="form-inline" action=#>
		<div class="col-sm-10 col-sm-push-1">
			<div class="drt col-sm-5">
				<label>Nom :</label>
				<input type="text" name="per_nom" class="form-control" value="<?php echo $perManager->getPersonneByNum($_GET['per_num'])['per_nom']; ?>" required=required/>
			</div>
			<div class="drt col-sm-5">
				<label>Prenom :</label>
				<input type="text" name="per_prenom" class="form-control" value="<?php echo $perManager->getPersonneByNum($_GET['per_num'])['per_prenom']; ?>" required=required/>
			</div>	
		</div>
		<div class="col-sm-10 col-sm-push-1 spacer">
			<div class="col-sm-5 drt">
				<label>Téléphone : </label>
				<input type="tel" name="per_tel" pattern="(0[0-9]{9})" class="form-control" value="<?php echo $perManager->getPersonneByNum($_GET['per_num'])['per_tel']; ?>" required=required/> 
			</div>
			<div class="col-sm-5 drt ">
				<label>Mail : </label>
				<input type="email" name="per_mail" class="form-control" value="<?php echo $perManager->getPersonneByNum($_GET['per_num'])['per_mail']; ?>" required=required/>
			</div>
		</div>
		<div class="col-sm-10 col-sm-push-1 spacer">
			<div class="col-sm-5 drt">
				<label>Login : </label>
				<input type="text" name="per_login" class="form-control" value="<?php echo $perManager->getPersonneByNum($_GET['per_num'])['per_login']; ?>" required=required/> 
			</div>
			<div class="col-sm-5 drt ">

				<label>Mot de passe  <sup>(1)</sup> : </label>
				<input type="password" name="per_pwd" class="form-control" />
			</div>
		</div>
		<div class="col-sm-10 col-sm-push-1 spacer">
			<label>Catégorie : </label>
			
				<input type="radio" name="categorie" id="etudiant" value="etudiant" 
				<?php  if(!empty($etuManager->getEtudiantByNum($_GET['per_num'])['per_num'])){ echo "checked=checked";}?> 
				required=required>Etudiant
				<input type="radio" name="categorie"  id="personnel" value="personnel" 
				<?php  if(empty($etuManager->getEtudiantByNum($_GET['per_num'])['per_num'])){ echo "checked=checked";}?>  
				required=required>Personnel
		</div>
		<div id="etu" >
			<div class="col-sm-7 drt spacer">
				<label>Annee : &nbsp;</label><select class="form-control" name="div_num" > 
					<?php
					foreach ($divisions as $division){ ?> 

						<option value="<?php echo $division->getDivNum(); ?>" 
							<?php if($division->getDivNum()==$etuManager->getEtudiantByNum($_GET['per_num'])['div_num']){
								echo "selected=selected"; } ?>>
							<?php echo $division->getDivnom() ?>
						</option>
			 		<?php }
		 ?>
				</select>
			</div>
			<br>
			<div class="col-sm-7 drt spacer">
				<label>Département :&nbsp;</label><select  class="form-control" name="dep_num" > 
					<?php
					foreach ($departements as $departement){  
					?>
						<option value="<?php echo $departement->getDepNum(); ?>"
							<?php if($departement->getDepNum()==$etuManager->getEtudiantByNum($_GET['per_num'])['dep_num']){
								echo "selected=selected"; } ?>>
							<?php echo $departement->getDepNom() ?>
						</option>
			 		<?php }
		 ?>
		 		</select>
		 	</div>
	 	</div>
	 	<div id="perso">
	 		<div class="col-sm-7 drt spacer">
		 		<label>Téléphone professionelle : &nbsp;</label>
				<input type="text" class="form-control" value="<?php echo $salManager->getSalarieByNum($_GET['per_num'])['sal_telprof']; ?>" name="sal_telprof" >
			</div>
			<div class="col-sm-7 drt spacer">
				<label>Fonction :&nbsp;</label><select class="form-control" name="fon_num" > 
					<?php
					foreach ($fonctions as $fonction){  
						?>

						<option value="<?php echo $fonction->getFonNum(); ?>"
							<?php if($fonction->getFonNum()==$salManager->getSalarieByNum($_GET['per_num'])['fon_num']){
								echo "selected=selected"; } ?>>
							<?php echo $fonction->getFonLibelle() ?>
						</option>
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
	<div class="col-sm-7 spacer">
		<span id="def" class="span-one-third"><sup>(1)</sup>Le mot de passe ne sera pas modifié si le champ n'est pas rempli.</span>
	</div>

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
		<br><img src="image/valid.png"> La personne a été ajoutée</img>
	<?php
		header('Refresh: 4; URL=#');
		}else{
	?>
		<br><img src="image/erreur.png"> Le personne n'a pas été ajoutée</img>
	<?php
		}
}
?>