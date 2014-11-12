	<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
		<div class=" navbar-inner">
			<div class="container">
				<ul class="nav navbar-nav">
					<li>
						<a href="index.php?page=0" ><img src="image/accueil.gif" alt="Accueil"/>  Accueil </a>
					</li>
					<li class="dropdown">
						<a href="#link" class="dropdown-toggle" data-toggle="dropdown"><img src="image/personne.png" alt="Personne"/> Personne <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?page=1">Ajouter</a></li>
							<li><a href="index.php?page=2">Lister</a></li>
							<li><a href="index.php?page=4">Gérer</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#link" class="dropdown-toggle" data-toggle="dropdown"><img src="image/parcours.gif" alt="Parcours"/> Parcours <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?page=5">Ajouter</a></li>
							<li><a href="index.php?page=6">Lister</a></li>

						</ul>
					</li>
					<li class="dropdown">
						<a href="#link" class="dropdown-toggle" data-toggle="dropdown"><img src="image/ville.png" alt="Ville"/> Ville <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?page=7">Ajouter</a></li>
							<li><a href="index.php?page=8">Lister</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#link" class="dropdown-toggle" data-toggle="dropdown"><img src="image/trajet.png" alt="Trajet"/> Trajet <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="index.php?page=9">Proposer</a></li>
							<li><a href="index.php?page=10">Rechercher</a></li>
						</ul>
					</li>
					
				</ul>
				<ul class="nav pull-right navbar-nav">
				<?php
				$pdo = new Mypdo();
						if(empty($_SESSION['connexion'])){
							if(empty($_POST['per_log'])&&empty($_POST['resultat'])&&empty($_POST['per_passwd'])){
						?>	
		          <li class="dropdown">
		            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Connexion</a>
		            <div class="dropdown-menu connect">
		              <form class="form" method='post'  action=# > 
		              	<caption>Pour vous connecter</caption>
		                <input name="per_log" class="form-control" type="text" placeholder="Identifiant" required=required> 
		                <input name="per_passwd" class="form-control" type="password" placeholder="Mot de passe" required=required><br>
		                <label>
		                	<?php 	$_SESSION['img1']=rand(1,9);
									$_SESSION['img2']=rand(1,9);?>
							<img src="image/nb/<?php	echo $_SESSION['img1']; ?>.jpg"> + 
							<img src="image/nb/<?php	echo $_SESSION['img2']; ?>.jpg"> = 
						</label>
						<input type='texte' name='resultat' class="form-control" placeholder="Résultat" required=required/><br>
		                <button type="submit" id="btnLogin" class="btn">Connexion</button>
		              </form>
						              <?php
							}else{
								if($_SESSION['img1']+$_SESSION['img2']==$_POST['resultat']){
									$persManager= new PersonneManager($pdo);
									$personne = $persManager->getPersonneByLogin($_POST['per_log']);
									$salt="48@!alsd";
									if(sha1(sha1($_POST['per_passwd']).$salt)==$personne['per_pwd']){
										
										$_SESSION['connexion']=$_POST['per_log'];
										?>
										<li>
											<a>Utilisateur : <?php  echo $_SESSION['connexion'] ?></a>
										</li>
										<li><a href="index.php?page=12" >Déconnexion</a></li>
									<?php
									header('Location: index.php?page=11');
									}else{
										echo 'Erreur d\'auhtentification.<br> Cliquez <a href="index.php?page=11">ici</a> pour revenir ';
									}
								}
							}
?>
		            </div>
		          </li>
		          <?php
						}else{
								?>
								<li>
									<a>Utilisateur : <?php  echo $_SESSION['connexion'] ?></a>
								</li>
								<li><a href="index.php?page=12" >Déconnexion</a></li>
							<?php
						}
					?>
		        </ul>

				<!--<ul class="nav navbar-nav navbar-right">
					
					<?php
						if(empty($_SESSION['connexion'])){
						?>
							<li><a href="index.php?page=11" class="btn btn-primary btn-large" > Connexion</a></li>
						<?php
						}else{
								?>
								<li><a>Utilisateur : <?php  echo $_SESSION['connexion'] ?></a> </li>
								<li><a href="index.php?page=12" class="btn btn-primary btn-large"><b>Déconnexion</b></a></li>

							<?php
						}
						?>
					
				</ul>-->
			</div>
		</div>
	</nav>
	<div id="corp">