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

        $title = 'Consulter Thread';
        include('includes/head.php');
?>

        <body>

            <?php include('includes/header.php'); ?>

            <main>
                <div class="container">
                    <h1><?= $title ?></h1>
                    <?php include('includes/message.php'); ?>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $thread['titre'] ?></h5>
                            <p class="card-text"><strong>Auteur :</strong> <?= $thread['author'] ?></p>
                            <p class="card-text"><strong>Date :</strong> <?= $thread['date_thread'] ?></p>
                            <p class="card-text"><strong>Post original :</strong></p>
                            <p class="card-text"><?= $thread['commentaire_zero'] ?></p>
                        </div>
                    </div>

                    <a class="btn btn-secondary mt-3" href="users.php">Retour</a>
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
