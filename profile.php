<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<?php
$title = 'Mon profil';
include('includes/head.php');
?>

<body>

    <?php include('includes/header.php'); ?>

    <main>
        <div class="container">
            <h1>Mon profil</h1>

            <?php include('includes/message.php'); ?>

            <?php
            include('includes/db.php');

            $q = 'SELECT email, nom, prenom, role, image FROM users WHERE email = :email';
            $statement = $bdd->prepare($q);
            $statement->execute(['email' => $_SESSION['email']]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            ?>

            <h2>Informations personnelles</h2>
            <p>Adresse e-mail : <?= $user['email'] ?></p>
            <p> Nom : <?= $user['nom'] ?></p>
            <p> Prénom : <?= $user['prenom'] ?></p>
			<p> Rôle : <?= $user['role'] ?> </p>

            <h2>Image de profil</h2>
            <img src="uploads/<?= $user['image'] ?>" alt="profil" style="max-width: 200px; max-height: 200px">

            <h2>Derniers Commentaires</h2>

            <?php
            // Requête pour récupérer les commentaires de l'utilisateur
            $q = 'SELECT c.commentaire, c.date, u.email
                  FROM comment AS c
                  INNER JOIN users AS u ON c.id_commentateur = u.id
                  WHERE u.email = :email
                  ORDER BY c.date DESC
                  LIMIT 5'; // Limite à 5 commentaires, vous pouvez modifier cela selon vos besoins

            $statement = $bdd->prepare($q);
            $statement->execute(['email' => $_SESSION['email']]);
            $commentaires = $statement->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <!-- Affichage des commentaires -->
            <?php if (!empty($commentaires)): ?>
                <?php foreach ($commentaires as $commentaire): ?>
                    <div>
                        <p>Commentaire: <?= $commentaire['commentaire'] ?></p>
                        <p>Date: <?= $commentaire['date'] ?></p>
                        <p>Auteur: <?= $commentaire['email'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun commentaire trouvé.</p>
            <?php endif; ?>
        </div>
    </main>

</body>

</html>
