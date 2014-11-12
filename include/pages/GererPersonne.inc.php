<script>

var num=0;
$(function() {
    
    $('.btnValider').click(function (e) {
	  num=this.parentNode.getAttribute("id");
	});
	$('#Valider').click(function(){
		document.location.href ="index.php?page=4&per_num="+num ;
	});
});

</script>
	
	<?php
$pdo = new Mypdo();
$perManager = new PersonneManager($pdo);
$listPersonne= $perManager->getAllPersonne(); 
if(!empty($_GET['per_num'])){
	$res=$perManager->suprPersonne($_GET['per_num']);
	unset($_GET['per_num']);
}

?>

<table class="table table-condensed table-striped">
	<caption><div ><h1>Gérer des personnes enregistrées</h1></div>
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

		<tr id="<?php echo $personne -> getPerNum(); ?>">
			<td><?php echo $personne -> getPerNum(); ?></td>
			<td><?php echo $personne->getPerNom(); ?></td>
			<td><?php echo $personne->getPerPrenom(); ?></td>
			<td><a href="index.php?page=1&amp;per_num=<?php echo $personne -> getPerNum(); ?>"><img src="image/modifier.png"/></a></td>
			<td class="btnValider"><a href=#  data-toggle="modal" data-target=".supprimer">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<div class="modal fade supprimer" id="myModal"tabindex="-1" role="dialog" area-hiden="true" data-backdrop="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    	<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span>&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title">Supprimer une personne</h4>
      	</div>
      	<div class="modal-body">
	     	<h5>Voulez vous vraiment supprimer cette personne?</h5>
	    </div>
	    <div class="modal-footer">
        	<button class="btn btn-primary" id="Valider">Valider</button>
        	<button class="btn btn-danger" data-dismiss="modal" class="sr-only"><span>Annuler</span></button>
      </div>
    </div>
  </div>
</div>


<br>
