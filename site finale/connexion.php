<!DOCTYPE html>
<html>
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

				<form method="POST" action="verification.php">
					<div class="mb-3">
						<label for="inputEmail" class="form-label">Adresse email</label>
						<input id="inputEmail" class="form-control" type="email" name="email" placeholder="exemple@site.com"  value="<?= (isset($_COOKIE['email']) ? $_COOKIE['email'] : '') ?>">
					</div>
					<div class="mb-3">
						<label for="inputPassword" class="form-label">Mot de passe</label>
						<input id="inputPassword" class="form-control" type="password" name="mdp" aria-describedby="passwordHelp">
						<div id="passwordHelp" class="form-text">Le mot de passe doit faire entre 6 et 12 caractères.</div>
					</div>
					<div class="mb-3">
						<button type="submit" class="btn btn-primary">Se connecter</button>
					</div>
				</form>
			</div>

		</main>

		<?php include('includes/footer.php'); ?>

	</body>
</html>