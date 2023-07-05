<header class="mb-4">
	<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
	<div class="container">
	   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarNav">
	      <ul class="navbar-nav">
	        <li class="nav-item">
	        	<a class="nav-link <?= $title == 'Accueil' ? 'active' : '' ?>" href="index.php" style="a:hover:color:#DC5E18">Accueil</a>
			</li>
			<li>
				<a class="nav-link <?= $title == 'Actus&Blog' ? 'active' : '' ?>" href="blog_liste.php">Actus&Blog</a>
	        </li>
			
	        <?php if(!isset($_SESSION['email'])){
				echo '<li class="nav-item"><a class="nav-link ' . ($title == 'Connexion' ? 'active' : '') . '" href="connexion.php">Connexion</a></li>';
			}else{
				echo '<li class="nav-item"><a class="nav-link ' . ($title == 'Administration' ? 'active' : '') . '" href="users.php">Administration</a></li>';
				echo '<li class="nav-item"><a class="nav-link ' . ($title == 'Mon profil' ? 'active' : '') . '" href="profile.php">Mon profil</a></li>';
				echo '<li class="nav-item"><a class="nav-link" href="deconnexion.php">Déconnexion</a></li>';
				echo '<li class="nav-item"><a class="nav-link" href="forum.php">Forum</a></li>';
			}
			?>
			<li>
				<a class="nav-link" href="contact.php">Contact</a>
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>
</header>





