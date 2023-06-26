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

        $title = 'Modifier Article';
        include('includes/head.php');

        // Traitement du formulaire de modification de l'article
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newTitle = $_POST['title'];
            $newCategory = $_POST['category'];
            $newContent = $_POST['content'];

            // Validation des données du formulaire (vous pouvez ajouter des validations supplémentaires selon vos besoins)

            // Requête de mise à jour de l'article
            $q = 'UPDATE article_post SET titre = :title, categorie = :category, corps_de_texte = :content WHERE id_article = :id';
            $statement = $bdd->prepare($q);
            $result = $statement->execute([
                'title' => $newTitle,
                'category' => $newCategory,
                'content' => $newContent,
                'id' => $articleId
            ]);

            if ($result) {
                $_SESSION['message'] = 'Article modifié avec succès.';
                header('location: administration.php');
                exit;
            } else {
                $_SESSION['message'] = 'Une erreur est survenue lors de la modification de l\'article.';
                header('location: administration.php');
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

                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="title">Titre :</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $article['titre'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Catégorie :</label>
                            <input type="text" class="form-control" id="category" name="category" value="<?= $article['categorie'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Contenu :</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required><?= $article['corps_de_texte'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>

                    <a class="btn btn-secondary mt-3" href="users.php">Retour</a>
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
