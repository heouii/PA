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
        $threadId = $_GET['id'];

        // Requête pour récupérer les informations du thread
        $q = 'SELECT * FROM forum_thread WHERE id_thread = :id';
        $statement = $bdd->prepare($q);
        $statement->execute(['id' => $threadId]);
        $thread = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$thread) {
            // Thread non trouvé
            $_SESSION['message'] = 'Thread introuvable.';
            header('location: users.php');
            exit;
        }

        $title = 'Supprimer Thread';
        include('includes/head.php');

        // Traitement de la suppression du thread
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Requête de suppression du thread
            $q = 'DELETE FROM forum_thread WHERE id_thread = :id';
            $statement = $bdd->prepare($q);
            $result = $statement->execute(['id' => $threadId]);

            if ($result) {
                $_SESSION['message'] = 'Thread supprimé avec succès.';
                header('location: users.php');
                exit;
            } else {
                $_SESSION['message'] = 'Une erreur est survenue lors de la suppression du thread.';
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
                        <p>Êtes-vous sûr de vouloir supprimer ce thread ?</p>
                        <p><strong>Titre :</strong> <?= $thread['titre'] ?></p>
                        <p><strong>Post original :</strong> <?= $thread['commentaire_zero'] ?></p>
                        <p><strong>Auteur :</strong> <?= $thread['author'] ?></p>
                        <p><strong>Date :</strong> <?= $thread['date_thread'] ?></p>
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
        $_SESSION['message'] = 'ID du thread non spécifié.';
        header('location: users.php');
        exit;
    }
} else {
    // L'utilisateur n'a pas le rôle d'administrateur, redirection vers la page d'accueil ou une autre page d'erreur
    header('location: index.php');
    exit;
}
?>
