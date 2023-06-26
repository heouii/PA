<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}

if (isset($_GET['id'])) {
    $idUtilisateur = $_GET['id'];

    include('includes/db.php');

    // Récupération des informations de l'utilisateur
    $q = 'SELECT email, nom, prenom FROM users WHERE id = :id';
    $statement = $bdd->prepare($q);
    $statement->execute(['id' => $idUtilisateur]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérification de la confirmation de suppression
        if (isset($_POST['confirm']) && $_POST['confirm'] === 'oui') {
            // Suppression de l'utilisateur de la table users
            $q = 'DELETE FROM users WHERE id = :id';
            $statement = $bdd->prepare($q);
            $statement->execute(['id' => $idUtilisateur]);

            // Redirection vers la page users.php
            header('location: users.php');
            exit;
        }

        $title = 'Supprimer utilisateur';
        include('includes/head.php');
        ?>

        <body>

            <?php include('includes/header.php'); ?>

            <main>
                <div class="container">
                    <h1>Supprimer utilisateur</h1>

                    <?php include('includes/message.php'); ?>

                    <h2>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</h2>
                    <p>Email : <?= $user['email'] ?></p>
                    <p>Nom : <?= $user['nom'] ?></p>
                    <p>Prénom : <?= $user['prenom'] ?></p>
                    <p>Cette opération sera irréversible.</p>

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="confirm">Confirmez la suppression :</label>
                            <input type="radio" id="confirm" name="confirm" value="oui"> Oui
                            <input type="radio" id="confirm" name="confirm" value="non" checked> Non
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </div>
                    </form>
                </div>
            </main>

        </body>

        </html>
        <?php
    } else {
        // Utilisateur non trouvé, redirection vers la page users.php
        header('location: users.php');
        exit;
    }
} else {
    // ID utilisateur non spécifié, redirection vers la page users.php
    header('location: users.php');
    exit;
}
?>
