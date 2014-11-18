<script>

var num=0;
$(function() {
    
    $('.btnValider').click(function (e) {
	  num=this.parentNode.getAttribute("id");
	});
	$('#Valider').click(function(){
		document.location.href ="index.php?page=14&vil_num="+num ;
	});
});

</script>

<?php
$pdo = new Mypdo();
$vilManager = new VilleManager($pdo);
$villes= $vilManager->getAllVilles();  


if(!empty($_GET['vil_num'])){
	$res=$vilManager->suprVill($_GET['vil_num']);
	unset($_GET['vil_num']);
	header('Refresh:0 ; URL=index.php?page=14');
}
?>


<table class="table table-condensed table-striped">
	<caption>
		<div >
			<h2>Modifier des villes</h2>

		</div>
		<p>Actuellement <?php echo $vilManager->getNbrVille(); ?> villes sont enregistrées</p>
	</caption>
	<thead>
		<tr>
			<th> Numéro </th>
			<th> Nom </th>
			<th>Modifier</th>
			<th>Supprimer</th>
		</tr>
	</thead>
	<tbody>

	<?php
	
	foreach ($villes as $ville){  ?>

			<tr id="<?php echo $ville -> getVilNum(); ?>">
			<td><?php echo $ville -> getVilNum(); ?></td>
			<td><?php echo $ville->getVilNom(); ?></td>
			<td><img src="image/modifier.png"/></a></td>
			<td class="btnValider"><a href=#  data-toggle="modal" data-target=".supprimer">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
		</tr>



	<?php } ?>
	</tbody>
</table>
<br>
<div class="modal fade supprimer" id="myModal"tabindex="-1" role="dialog" area-hiden="true" data-backdrop="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    	<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span>&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title">Supprimer une ville</h4>
      	</div>
      	<div class="modal-body">
	     	<h5>Voulez vous vraiment supprimer cette ville?</h5>
	    </div>
	    <div class="modal-footer">
        	<button class="btn btn-primary" id="Valider">Valider</button>
        	<button class="btn btn-danger" data-dismiss="modal" class="sr-only"><span>Annuler</span></button>
      </div>
    </div>
  </div>
</div>