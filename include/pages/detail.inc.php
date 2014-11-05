<?php
	$per_num=$_GET['per_num'];
	$pdo = new Mypdo();
	$perManager = new PersonneManager($pdo);
	$personne = $perManager->getPersonneByNum($per_num);
	$salManager = new SalarieManager($pdo);
	$salarie = $salManager->getSalarieByNum($per_num);
	$etuManager = new EtudiantManager($pdo);
	$etudiant= $etuManager->getEtudiantByNum($per_num);

	if(empty($salarie)){
		$depManager = new DepartementManager($pdo);
		$departement = $depManager->getNomDepByNum($etudiant['dep_num']);
		$vilManager = new VilleManager($pdo);
		$ville = $vilManager->getNomVilleByNum($departement['vil_num']);
		?>
		

	<table class="table ">
		<caption><h2> Détail sur l'étudiant <?php  echo $personne['per_nom']; ?></h2></caption>
		<thead>
			<tr>
				<th>Prénom</th>
				<th>Mail</th>
				<th>Tel</th>
				<th>departement</th>
				<th>Ville</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $personne['per_prenom']; ?></td>
				<td><?php echo $personne['per_mail']; ?></td>
				<td><?php echo $personne['per_tel']; ?></td>
				<td><?php echo $departement['dep_nom']; ?></td>
				<td><?php echo $ville; ?></td>
			</tr>
		</tbody>
</table>
<br>

		<?php
	}else{
		$fonManager = new FonctionManager($pdo);
		$fonction = $fonManager->getNomFonctionByNum($salarie['fon_num']);
		?>
		
		<table class="table table-condensed">
			<caption><h2> Détail sur le salarié <?php  echo $personne['per_nom']; ?></h2></caption>
			<thead>	
				<tr>
					<th>Prénom</th>
					<th>Mail</th>
					<th>Téléphone</th>
					<th>Tél Pro</th>
					<th>Fonction</th>
				</tr>
			</thead>
			<tbody>	
				<tr>
					<td><?php echo $personne['per_prenom']; ?></td>
					<td><?php echo $personne['per_mail']; ?></td>
					<td><?php echo $personne['per_tel']; ?></td>
					<td><?php echo $salarie['sal_telprof']; ?></td>
					<td><?php echo $fonction; ?></td>
				</tr>
			</tbody>
		</table>
<br>
		<?php
	}
?>
