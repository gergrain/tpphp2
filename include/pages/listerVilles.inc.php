<?php
$pdo = new Mypdo();
$vilManager = new VilleManager($pdo);
$villes= $vilManager->getAllVilles();  
?>


<table class="table table-condensed table-striped">
	<caption>
		<div >
			<h2>Liste des villes</h2>
			<a href="index.php?page=14">Gérer</a>
		</div>
		<p>Actuellement <?php echo $vilManager->getNbrVille(); ?> villes sont enregistrées</p>
	</caption>
	<thead>
		<tr>
			<th> Numéro </th>
			<th> Nom </th>
		</tr>
	</thead>
	<tbody>

	<?php
	
	foreach ($villes as $ville){  ?>

			<tr>
			<td><?php echo $ville -> getVilNum(); ?></td>
			<td><?php echo $ville->getVilNom(); ?></td>
		</tr>
	
	<?php } ?>
	</tbody>
</table>
<br>
