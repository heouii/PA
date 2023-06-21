<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<?php 
	$title = 'Accueil';
	include('includes/head.php');
	?>
	<body>

		<?php include('includes/header.php'); ?>

		<main>
			<div class="container">
				<h1>Accueil</h1>

				<?php include('includes/message.php'); ?>
				
				<p>
					<?php 
					if(!isset($_SESSION['email'])){
						echo 'Contenu non disponible.';
					}else{
						echo 'Voici votre contenu privé :)';
					}
					?>
				</p>
			</div>
		</main>

		<?php include('includes/footer.php'); ?>

	</body>
</html>