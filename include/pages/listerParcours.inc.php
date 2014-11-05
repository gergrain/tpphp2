<?php
$pdo = new Mypdo();
$parcManager = new ParcoursManager($pdo);
$vilManager = new VilleManager($pdo);
$listParcours= $parcManager->getAllParcours();  
?>

<table class="table table-striped table-condensed">
	<caption>
		<div >
			<h2>Liste des Parcours</h2>
		</div>
		<p>Actuellement <?php echo $parcManager->getNbrParcours(); ?> parcours sont enregistrés</p>
	</caption>
	<thead>
		<tr>
			<th>Numéro</th>
			<th>Nom ville</th>
			<th>Nom ville</th>
			<th>Nombre de Km</th>
		</tr>
	</thead>
	<TBODY>
	<?php
	
	foreach ($listParcours as $parcours){  ?>

		<tr><td><?php echo $parcours -> getParNum(); ?></td>

		<td><?php echo $vilManager->getNomVilleByNum($parcours->getVilNum1()); ?></td>
		<td><?php echo $vilManager->getNomVilleByNum($parcours->getVilNum2()); ?></td>
		<td><?php echo $parcours->getParKm(); ?></td></tr>
	<?php } ?>
	</TBODY>
</table>
<br>
