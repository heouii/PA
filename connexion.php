<!DOCTYPE html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion</title>
</head>
<div class="graybackground">
<style> 
	main {
		min-height: 500px;
		color : white;
	}

	.graybackground {
		background-image: url('imagerie/pexels-photo-669576.jpeg');
		background-repeat: no-repeat;
                background-size: cover;
		background-color: #515151;
	}
	
	.graytext {
		color : lightgray;
	}

	.btn-orange {
		background-color: #DC5E18;
		border-color: #DC5E18;
		color : white;  
	}
</style>
	<?php 
	$title = 'Connexion';
	include('includes/head.php');
	?>
	<body>

		<?php include('includes/header.php'); ?>

		<main>
			<div class="container">
				<h1>Connexion</h1>

				<?php include('includes/message.php'); ?>

				<form method="POST" action="verification.php" class="contact-form">
					<div class="mb-3">
						<label for="inputEmail" class="form-label">Adresse email</label>
						<input id="inputEmail" class="form-control" type="email" name="email" placeholder="exemple@site.com"  value="<?= (isset($_COOKIE['email']) ? $_COOKIE['email'] : '') ?>">
					</div>
					<div class="mb-3">
						<label for="inputPassword" class="form-label">Mot de passe</label>
						<input id="inputPassword" class="form-control" type="password" name="mdp" aria-describedby="passwordHelp">
						<div id="passwordHelp" class="graytext">Le mot de passe doit faire entre 6 et 12 caractères.</div>
					</div>
					<div class="mb-3">
						<button type="submit" class="btn btn-primary" style='background-color: #DC5E18 ;
		border-color: #DC5E18' >Se connecter</button>
					</div>
				</form>
				<a href="mailing/formulaire_mdp.php"> Mot de passe oublié ? </a>
			</div>

		</main>

		<?php include('includes/footer.php'); ?>

	</body>
</div>
</html>