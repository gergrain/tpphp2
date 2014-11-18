
<?php
if(empty($_POST['vil_nom'])){
?>
<form method='post' action=# class="form-inline">
		<h1><caption>Ajouter une ville</caption></h1>
		<label class="form-label">Nom :  </label><input type='texte' class="form-control" name='vil_nom' required=required/>
		<input type='submit' class="btn btn-primary" />
</form>
<?php
}else{
	$pdo = new Mypdo();
	$vilManager = new VilleManager($pdo);
	$ville=$_POST['vil_nom'];
	$retour = $vilManager->add($ville);
	if($retour !=0){
?>
<div class="alert alert-success" role="alert">
	<img src="image/valid.png"> La ville <b>"<?php echo $ville ?>" </b>a été ajoutée</img>
</div>
<?php
	}else{
?>
<div class="alert alert-danger" role="alert">
	<img src="image/erreur.png"> La ville <?php echo $ville ?> n'a pas été ajoutée</img>
</div>
<?php
	}
	header('Refresh: 4; URL=index.php?page=7');
}
?>