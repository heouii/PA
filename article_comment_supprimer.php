<?php
session_start();

include('includes/db.php');

if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}

$email = $_SESSION['email'];

// Requête pour récupérer le rôle de l'utilisateur connecté
$q = 'SELECT role FROM users WHERE email = :email';
$statement = $bdd->prepare($q);
$statement->execute(['email' => $email]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if ($user && $user['role'] === 'admin') {
    if (isset($_GET['id'])) {
        $commentId = $_GET['id'];

        // Requête pour récupérer les informations du commentaire
        $q = 'SELECT * FROM article_comment WHERE id_comment = :id';
        $statement = $bdd->prepare($q);
        $statement->execute(['id' => $commentId]);
        $comment = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$comment) {
            // Commentaire non trouvé
            $_SESSION['message'] = 'Commentaire introuvable.';
            header('location: index.php');
            exit;
        }

        $title = 'Supprimer Commentaire';
        include('includes/head.php');

        // Traitement de la suppression du commentaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Requête de suppression du commentaire
            $q = 'DELETE FROM article_comment WHERE id_comment = :id';
            $statement = $bdd->prepare($q);
            $result = $statement->execute(['id' => $commentId]);

            if ($result) {
                $_SESSION['message'] = 'Commentaire supprimé avec succès.';
                header('location: users.php');
                exit;
            } else {
                $_SESSION['message'] = 'Une erreur est survenue lors de la suppression du commentaire.';
                header('location: users.php');
                exit;
            }
        }
?>

<body>

    <?php include('includes/header.php'); ?>

    <main>
        <div class="container">
            <h1><?= $title ?></h1>
            <?php include('includes/message.php'); ?>

            <div class="alert alert-danger">
                <p>Êtes-vous sûr de vouloir supprimer ce commentaire ?</p>
                <p><strong>ID Article :</strong> <?= $comment['id_article'] ?></p>
                <p><strong>Auteur :</strong> <?= $comment['author'] ?></p>
                <p><strong>Commentaire :</strong> <?= $comment['content'] ?></p>
            </div>

            <form method="POST" action="">
                <button type="submit" class="btn btn-danger">Supprimer</button>
                <a class="btn btn-secondary" href="users.php">Annuler</a>
            </form>
        </div>
    </main>

</body>
<?php include('includes/footer.php'); ?>

</html>

<?php
    } else {
        $_SESSION['message'] = 'ID du commentaire non spécifié.';
        header('location: index.php');
        exit;
    }
} else {
    // L'utilisateur n'a pas le rôle d'administrateur, redirection vers la page d'accueil ou une autre page d'erreur
    header('location: index.php');
    exit;
}
?>
