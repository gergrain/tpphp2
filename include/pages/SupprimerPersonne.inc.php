<script>
$(function() {
    $('.suppr').bind('click', function (e) {
        e.target(window.alert("hello"))
    });
});
$("#myModal").modal("show");
$("#myModal").css("z-index", "1500");
</script>
	
	<?php


$pdo = new Mypdo();
$perManager = new PersonneManager($pdo);
$listPersonne= $perManager->getAllPersonne();  
?>

<table class="table table-condensed table-striped">
	<caption><div ><h1>Supprimer des personnes enregistrées</h1></div>
<p>Actuellement <?php echo $perManager->getNbrPersonne(); ?> personnes sont enregistrées</p></caption>
	<thead>
		<tr>
			<th>Numéro</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Modifier</th>
			<th>Supprimer</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	foreach ($listPersonne as $personne){  ?>

		<tr>
			<td><?php echo $personne -> getPerNum(); ?></td>
			<td><?php echo $personne->getPerNom(); ?></td>
			<td><?php echo $personne->getPerPrenom(); ?></td>
			<td><a href=# ><img src="image/modifier.png" alt="Ville"/></a></td>
			<td><a href=# data-toggle="modal" data-target=".bs-example-modal-sm"><span class="glyphicon glyphicon-trash"></span></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<div class="modal fade bs-example-modal-sm" id="myModal"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    	<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title">Supprimer une personne</h4>
      	</div>
      	<div class="modal-body">
	     	<h5>Voulez vous vraiment supprimer cette personne?</h5>
	    </div>
	    <div class="modal-footer">
        	<button class="btn btn-primary" id="suppr">Valider</button>
        	<button class="btn btn-danger"><span aria-hidden="true">Annuler</span></button>
      </div>
    </div>
  </div>
</div>

<br>
