<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $commentaire = $_POST['commentaire'];
    $id_thread = $_POST['id_thread'];

    // Vérification de l'existence du thread
    $queryThread = "SELECT id_thread FROM forum_thread WHERE id_thread = :id_thread";
    $stmtThread = $bdd->prepare($queryThread);
    $stmtThread->bindParam(':id_thread', $id_thread);
    $stmtThread->execute();
    $threadExists = $stmtThread->rowCount();

    if ($threadExists) {
        // Récupération de l'ID de l'utilisateur à partir de la session email
        $email = $_SESSION['email'];
        $queryUser = "SELECT id FROM users WHERE email = :email";
        $stmtUser = $bdd->prepare($queryUser);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $id_commentateur = $user['id'];

            // Insertion du commentaire dans la table forum_thread_comment
            $queryInsertComment = "INSERT INTO forum_thread_comment (commentaire, id_commentateur, id_forum_thread) 
                                   VALUES (:commentaire, :id_commentateur, :id_thread)";
            $stmtInsertComment = $bdd->prepare($queryInsertComment);
            $stmtInsertComment->bindParam(':commentaire', $commentaire);
            $stmtInsertComment->bindParam(':id_commentateur', $id_commentateur);
            $stmtInsertComment->bindParam(':id_thread', $id_thread);
            $stmtInsertComment->execute();

            // Redirection vers la page du thread
            header("Location: forum_thread.php?id_thread=$id_thread");
            exit;
        } else {
            echo "Utilisateur introuvable.";
        }
    } else {
        echo "Le thread demandé n'existe pas.";
        header("Location: forum_thread.php?id_thread=$id_thread");
            exit;
    }
} else {
    echo "Méthode de requête invalide.";
}
?>
