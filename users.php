<?php
// pour que la oage ne soit accessible qu'aux admin
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

// Vérification du rôle de l'utilisateur
if ($user && $user['role'] === 'admin') {
    // L'utilisateur a le rôle d'administrateur, le contenu de la page est accessible
    // Mettez ici le contenu de votre page réservée aux administrateurs
    // ...
} else {
    // L'utilisateur n'a pas le rôle d'administrateur, redirection vers la page d'accueil ou une autre page d'erreur
    header('location: index.php');
    exit;
}

?>

<!DOCTYPE html>
    <style> 
        table {
            color : 515151;
        }
    </style>
    <?php 
    $title = 'Utilisateurs';
    include('includes/head.php');
    ?>
    <body>

        <?php include('includes/header.php'); ?>

        <main>
            <div class="container">
                <h1><?= $title ?></h1>

                <?php include('includes/message.php'); ?>
                
                <?php include('includes/db.php'); ?>

                <?php
                $q = 'SELECT id, email, image FROM users';
                $req = $bdd->query($q);
                $users = $req->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <table class="table table-striped mt-4">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    foreach ($users as $index => $user) {
                        echo '<tr>
                                <td>' . $user['id'] . '</td>
                                <td>' . $user['image'] . '</td>
                                <td>' . $user['email'] . '</td>
                                <td>
                                    <a class="btn btn-secondary btn-sm" href="read.php?id=' . $user['id'] . '">Consulter</a>
                                    <a class="btn btn-primary btn-sm" href="update.php?id=' . $user['id'] . '">Modifier</a>
                                    <a class="btn btn-danger btn-sm" href="delete.php?id=' . $user['id'] . '">Supprimer</a>
                                </td>
                              </tr>';
                    }
                    ?>

                </table>
            </div>
        </main>


    </body>
    <?php include('includes/footer.php'); ?>

</html>
