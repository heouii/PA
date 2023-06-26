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
        $contactId = $_GET['id'];

        // Requête pour récupérer les informations du contact
        $q = 'SELECT * FROM contact WHERE id = :id';
        $statement = $bdd->prepare($q);
        $statement->execute(['id' => $contactId]);
        $contact = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$contact) {
            // Contact non trouvé
            $_SESSION['message'] = 'Contact introuvable.';
            header('location: index.php');
            exit;
        }

        $title = 'Supprimer Contact';
        include('includes/head.php');

        // Traitement de la suppression du contact
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Requête de suppression du contact
            $q = 'DELETE FROM contact WHERE id = :id';
            $statement = $bdd->prepare($q);
            $result = $statement->execute(['id' => $contactId]);

            if ($result) {
                $_SESSION['message'] = 'Contact supprimé avec succès.';
                header('location: users.php');
                exit;
            } else {
                $_SESSION['message'] = 'Une erreur est survenue lors de la suppression du contact.';
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
                        <p>Êtes-vous sûr de vouloir supprimer ce contact ?</p>
                        <p><strong>Nom :</strong> <?= $contact['nom'] ?></p>
                        <p><strong>Email :</strong> <?= $contact['email'] ?></p>
                        <p><strong>Téléphone :</strong> <?= $contact['telephone'] ?></p>
                        <p><strong>Objet :</strong> <?= $contact['objet'] ?></p>
                        <p><strong>Message :</strong> <?= $contact['contact_commentaire'] ?></p>
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
        $_SESSION['message'] = 'ID du contact non spécifié.';
        header('location: index.php');
        exit;
    }
} else {
    // L'utilisateur n'a pas le rôle d'administrateur, redirection vers la page d'accueil ou une autre page d'erreur
    header('location: index.php');
    exit;
}
?>
