<?php
$secondes = 3; 
?>
<script type="text/javascript">
var temps = <?php echo $secondes;?>;
var timer =setInterval('CompteaRebour()',1000);
function CompteaRebour(){

  temps-- ;
  s = parseInt((temps%3600)%60) ;
  document.getElementById('decompte').innerHTML= (s<10 ? "0"+s : s) + ' s ';
}
</script>
	<div class="alert alert-danger" role="alert">
  <a href="#" class="alert-link">La connexion a échoué</a>
  <p>Vous allez être redirigé dans <b id="decompte"></b></p>
</div>
<?php 
}
header('Refresh: 3; URL=index.php?page=0');
?>
