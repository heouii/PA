<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}

include('includes/db.php');

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $commentaire = $_POST['comment'];
    $id_article = $_POST['id_article'];

    // Requête pour insérer le commentaire dans la table
    $query = "
        INSERT INTO article_comment (commentaire, id_commentateur, id_article, date)
        SELECT :commentaire, users.id, :id_article, NOW()
        FROM users
        WHERE users.email = :email
    ";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':commentaire', $commentaire);
    $stmt->bindParam(':id_article', $id_article);
    $stmt->bindParam(':email', $_SESSION['email']);
    
    // Exécution de la requête
    if ($stmt->execute()) {
        header("Location: article.php?id_article=$id_article");
        exit;
    } else {
        echo "Une erreur est survenue lors de l'enregistrement du commentaire.";
    }
} else {
    echo "Aucune donnée de formulaire reçue.";
}
?>
