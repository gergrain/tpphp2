<div class="alert alert-success" role="alert">
  <a href="#" class="alert-link">Déonnexion réussi</a>
</div>
<?php session_unset();
header('Refresh: 2; URL=index.php?page=0');
?>