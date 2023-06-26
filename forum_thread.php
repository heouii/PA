<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

include('includes/db.php');


$title = 'Thread';
include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title><?php echo $title; ?></title>
</head>
<body>
    <main>
    <div class="container">
        <?php
        // Vérification si l'ID du thread est présent dans l'URL
        if (isset($_GET['id_thread'])) {
            $threadId = $_GET['id_thread'];

            // Requête pour récupérer les détails du thread correspondant à l'ID
            $query = 'SELECT id_thread, titre, commentaire_zero, date_thread FROM forum_thread WHERE id_thread = :id_thread';
            $stmt = $bdd->prepare($query);
            $stmt->bindParam(':id_thread', $threadId);
            $stmt->execute();
            $thread = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification si le thread existe dans la base de données
            if ($thread) {
                $titre = $thread['titre'];
                $commentaire_zero = $thread['commentaire_zero'];
                $date_thread = $thread['date_thread'];

                // Affichage des détails du thread
                echo '<h1>' . $titre . '</h1>';
                $id_thread = $_GET['id_thread'];
                echo 'id thread  >>>  ' . $id_thread;
                echo '<p><strong>Date de création :</strong> ' . $date_thread . '</p>';
                echo '<p>' . $commentaire_zero . '</p>';

                // Section des commentaires
                echo '<h2>Commentaires</h2>';

                // Récupération des commentaires associés au thread
                $query = 'SELECT id_forum_comment, commentaire, id_commentateur FROM forum_thread_comment WHERE id_forum_thread = :id_thread';
                $stmt = $bdd->prepare($query);
                $stmt->bindParam(':id_thread', $threadId);
                $stmt->execute();
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Vérification s'il y a des commentaires
                if ($comments) {
                    foreach ($comments as $comment) {
                        $commentId = $comment['id_forum_comment'];
                        $commentText = $comment['commentaire'];
                        $commentateurId = $comment['id_commentateur'];

                        // Requête pour récupérer l'email de l'utilisateur correspondant à l'id_commentateur
                        $queryUser = "SELECT email FROM users WHERE id = :id_commentateur";
                        $stmtUser = $bdd->prepare($queryUser);
                        $stmtUser->bindParam(':id_commentateur', $commentateurId);
                        $stmtUser->execute();
                        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
                        if ($user) {
                            $emailCommentateur = $user['email'];
                        } else {
                            $emailCommentateur = 'Utilisateur inconnu';
                        }

                        // Affichage du commentaire et des informations du commentateur
                        echo '<div>';
                        echo '<p><strong>Commentaire de ' .  $emailCommentateur . ' :</strong></p>';
                        echo '<p>' . $commentText . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo 'Aucun commentaire pour le moment.';
                }

                // Formulaire pour ajouter un commentaire
                echo '<h3>Ajouter un commentaire</h3>';
                    echo '<form method="POST" action="forum_comment_verification.php">';
                        echo '<textarea name="commentaire" rows="4" cols="50" required></textarea><br>';
                        echo ' <input type="hidden" name="id_thread" value="' . $threadId . '">';
                        echo '<input type="submit" value="Ajouter le commentaire">';
                    echo '</form>';
            } else {
                echo "Le thread demandé n'existe pas.";
            }
        } else {
            echo "Aucun ID de thread spécifié.";
        }
        ?>
    </div>
    </main>
    <?php include('includes/footer.php'); ?>

</body>
</html>
