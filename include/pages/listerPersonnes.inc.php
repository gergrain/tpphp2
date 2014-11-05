<?php


$pdo = new Mypdo();
$perManager = new PersonneManager($pdo);
$listPersonne= $perManager->getAllPersonne();  
?>

<table class="table table-condensed table-striped">
	<caption><div ><h2>Liste des Personnes enregistrées</h2></div>
<p>Actuellement <?php echo $perManager->getNbrPersonne(); ?> personnes sont enregistrées</p></caption>
	<thead>
		<tr>
			<th>Numéro</th>
			<th>Nom</th>
			<th>Prénom</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	foreach ($listPersonne as $personne){  ?>

		<tr>
			<td><a href="index.php?page=13&per_num=<?php echo $personne -> getPerNum(); ?>"><?php echo $personne -> getPerNum(); ?></a></td>
			<td><?php echo $personne->getPerNom(); ?></td>
			<td><?php echo $personne->getPerPrenom(); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<br>
