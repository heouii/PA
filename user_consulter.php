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
$title = 'Profil utilisateur';
include('includes/head.php');
?>

<body>

    <?php include('includes/header.php'); ?>

    <main>
        <div class="container">
            <h1>Profil utilisateur</h1>

            <?php include('includes/message.php'); ?>

            <?php
            include('includes/db.php');

            // Vérification de l'existence de l'ID dans l'URL
            if (isset($_GET['id'])) {
                $idUtilisateur = $_GET['id'];

                $q = 'SELECT email, nom, prenom, role, image FROM users WHERE id = :id';
                $statement = $bdd->prepare($q);
                $statement->execute(['id' => $idUtilisateur]);
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Boutons Modifier et Supprimer
                    echo '<div class="mt-4">';
                    echo '<a class="btn btn-secondary btn-sm" href="users.php">Retour à la page utilisateurs</a>';
                    echo '<a class="btn btn-primary btn-sm" href="user_modifier.php?id=' . $idUtilisateur . '">Modifier</a>';
                    echo '<a class="btn btn-danger btn-sm mx" href="user_supprimer.php?id=' . $idUtilisateur . '">Supprimer</a>';
                    echo '</div>';
                    ?>

                    <h2>Informations personnelles</h2>
                    <p>Adresse e-mail : <?= $user['email'] ?></p>
                    <p>Nom : <?= $user['nom'] ?></p>
                    <p>Prénom : <?= $user['prenom'] ?></p>
                    <p>Rôle : <?= $user['role'] ?></p>

                    <h2>Image de profil</h2>
                    <img src="uploads/<?= $user['image'] ?>" alt="profil" style="max-width: 200px; max-height: 200px">

                    <h2>Derniers Commentaires</h2>

                    <?php
                    // Requête pour récupérer les commentaires de l'utilisateur
                    $q = 'SELECT c.commentaire, c.date, u.email
                          FROM comment AS c
                          INNER JOIN users AS u ON c.id_commentateur = u.id
                          WHERE u.id = :id
                          ORDER BY c.date DESC
                          LIMIT 5';

                    $statement = $bdd->prepare($q);
                    $statement->execute(['id' => $idUtilisateur]);
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

                    <?php
                } else {
                    echo '<p>Utilisateur non trouvé.</p>';
                }
            } else {
                echo '<p>ID utilisateur non spécifié.</p>';
            }
            ?>
        </div>
    </main>

</body>

</html>
