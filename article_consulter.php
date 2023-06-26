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
        $articleId = $_GET['id'];

        // Requête pour récupérer les informations de l'article
        $q = 'SELECT * FROM article_post WHERE id_article = :id';
        $statement = $bdd->prepare($q);
        $statement->execute(['id' => $articleId]);
        $article = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$article) {
            // Article non trouvé
            $_SESSION['message'] = 'Article introuvable.';
            header('location: index.php');
            exit;
        }

        $title = 'Consulter Article';
        include('includes/head.php');
?>

        <body>

            <?php include('includes/header.php'); ?>

            <main>
                <div class="container">
                    <h1><?= $title ?></h1>
                    <?php include('includes/message.php'); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <h3>Informations de l'article :</h3>
                            <p><strong>ID :</strong> <?= $article['id_article'] ?></p>
                            <p><strong>Titre :</strong> <?= $article['titre'] ?></p>
                            <p><strong>Catégorie :</strong> <?= $article['categorie'] ?></p>
                            <p><strong>Auteur :</strong> <?= $article['nom'] . ' ' . $article['prenom'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <h3>Contenu de l'article :</h3>
                            <p><?= $article['corps_de_texte'] ?></p>
                        </div>
                    </div>

                    <a class="btn btn-secondary" href="users.php">Retour</a>
                </div>
            </main>

        </body>
        <?php include('includes/footer.php'); ?>

        </html>

<?php
    } else {
        $_SESSION['message'] = 'ID de l\'article non spécifié.';
        header('location: index.php');
        exit;
    }
} else {
    // L'utilisateur n'a pas le rôle d'administrateur, redirection vers la page d'accueil ou une autre page d'erreur
    header('location: index.php');
    exit;
}
?>
