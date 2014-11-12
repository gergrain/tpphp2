				
<?php
	
if(empty($_POST['per_nom']) && empty($_POST['per_prenom'])
	&& empty($_POST['per_tel'])&& empty($_POST['per_login'])
	&& empty($_POST['per_mail'])&& empty($_POST['per_pwd'])
	&&empty($_POST['categorie'])&& empty($_POST['div_num'])
	&& empty($_POST['dep_num'])&&empty($_POST['sal_telprof'])&&empty($_POST['fon_num'])) {
	$pdo = new Mypdo();
	$perManager = new PersonneManager($pdo);
	$personnes= $perManager->getAllPersonne();
?>
<h1>Ajouter une personne</h1>
<form method="post" class="form-inline" action=#>
		<div class="col-sm-10 col-sm-push-1">
			<div class="drt col-sm-5">
				<label>Nom :</label>
				<input type="text" name="per_nom" class="form-control" required=required/>
			</div>
			<div class="drt col-sm-5">
				<label>Prenom :</label>
				<input type="text" name="per_prenom" class="form-control" required=required/>
			</div>	
		</div>
		<div class="col-sm-10 col-sm-push-1">
			<div class="col-sm-5 drt">
				<label>Téléphone : </label>
				<input type="tel" name="per_tel" pattern="(0[0-9]{9})" class="form-control" required=required/> 
			</div>
			<div class="col-sm-5 drt ">
				<label>Mail : </label>
				<input type="email" name="per_mail" class="form-control" required=required/>
			</div>
		</div>
		<div class="col-sm-10 col-sm-push-1">
			<div class="col-sm-5 drt">
				<label>Login : </label>
				<input type="text" name="per_login" class="form-control" required=required/> 
			</div>
			<div class="col-sm-5 drt ">
				<label>Mot de passe : </label>
				<input type="password" name="per_pwd" class="form-control" required=required/>
			</div>
		</div>
		<divclass="col-sm-10"> </div>
		<div class="col-sm-10 col-sm-push-1">
			<label>Catégorie : </label>
			<input type="radio" name="categorie" value="etudiant" required=required>Etudiant
			<input type="radio" name="categorie" value="personnel" required=required>Personnel
		</div>
		<br>
		<div class="col-sm-10 col-sm-push-1">
			<input type="submit" name="Valider" class="btn btn-primary" value="Valider">
		</div>
	</form>


<?php
	}else{
		if (!(empty($_POST['per_nom']) && empty($_POST['per_prenom'])
		&& empty($_POST['per_tel'])&& empty($_POST['per_login'])
		&& empty($_POST['per_mail'])&& empty($_POST['per_pwd'])
		&&empty($_POST['categorie']))&& empty($_POST['div_num'])
		&& empty($_POST['dep_nom'])&&empty($_POST['sal_telprof'])&&empty($_POST['fon_num'])){

			$_SESSION['per_nom']=$_POST['per_nom'];
			$_SESSION['per_prenom']=$_POST['per_prenom'];
			$_SESSION['per_tel']=$_POST['per_tel'];
			$_SESSION['per_mail']=$_POST['per_mail'];
			$_SESSION['per_login']=$_POST['per_login'];
			$salt="48@!alsd";
			$_SESSION['per_pwd']=sha1(sha1($_POST['per_pwd']).$salt);

			$_SESSION['categorie']=$_POST['categorie'];

		if($_POST['categorie']=='etudiant'){
			$pdo = new Mypdo();
			$divManager = new DivisionManager($pdo);
			$depManager = new DepartementManager($pdo);
			$divisions = $divManager->getAllDivision();
			$departements = $depManager->getAllDepartement();	

	?>
	<h2>Ajouter un Etudiant</h2>
	<form method="post" action=# class="form-inline">
			<label>Annee : &nbsp</label><select class="form-control" name="div_num" > 
				<?php
				foreach ($divisions as $division){ ?> 

					<option value="<?php echo $division->getDivNum(); ?>"><?php echo $division->getDivnom() ?></option>;
		 		<?php }
	 ?>
			</select>
			<br>
			<br>
			
			<label>Département :&nbsp</label><select  class="form-control" name="dep_num" > 
				<?php
				foreach ($departements as $departement){  
				?>
					<option value="<?php echo $departement->getDepNum(); ?>"><?php echo $departement->getDepNom() ?></option>;
		 		<?php }
	 ?>
	 		</select>
			<br>
			<br>
				<input type="submit" class="btn btn-primary" name="valider" value="valider">
			</form>
	<?php
		}
		if($_POST['categorie']=='personnel'){
			$pdo = new Mypdo();
			$fonManager = new FonctionManager($pdo);
			$fonctions = $fonManager->getAllFonction();	

	?>
	<h2>Ajouter un salarié</h2>
	<form method="post" action=# class="form-inline">
			<label>Téléphone professionelle : &nbsp</label>
			<input type="text" class="form-control" name="sal_telprof" required=required>
			<br>
			
			<label>Fonction :&nbsp</label><select class="form-control" name="fon_num" > 
				<?php
				foreach ($fonctions as $fonction){  
					?>

					<option value="<?php echo $fonction->getFonNum(); ?>"><?php echo $fonction->getFonLibelle() ?></option>;
		 	<?php	}
	 ?>
	 		</select>
			<br>
			<br>
				<input type="submit" class="btn btn-primary" name="valider" value="valider">
			</form>
	<?php
		}
		
	}else{
	$pdo = new Mypdo();
	$perManager = new PersonneManager($pdo);
	$personne = new Personne($_SESSION);
	$retour = $perManager->add($personne);
	$per_num=$perManager->getLastNumPersonne();

	if($_SESSION['categorie']=='etudiant'){
			$etuManager=new EtudiantManager($pdo);
			$etudiant = new Etudiant(array('per_num'=>$per_num,'div_num'=>$_POST['div_num'],'dep_num'=>$_POST['dep_num']));
			$etuManager->add($etudiant);
	}else{
			$salManager=new SalarieManager($pdo);
			$salarie = new salarie(array('per_num'=>$per_num,'sal_telprof'=>$_POST['sal_telprof'],'fon_num'=>$_POST['fon_num']));
			$salManager->add($salarie);

	}

		if($retour){
	?>
		<br><img src="image/valid.png"> La personne a été ajoutée</img>
	<?php
		}else{
	?>
		<br><img src="image/erreur.png"> Le personne n'a pas été ajoutée</img>
	<?php
		}
	}
}
?>