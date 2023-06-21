<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $commentaire_zero = $_POST['commentaire_zero'];

    // Insertion des données dans la table forum_thread
    include("includes/db.php");
    $query = "INSERT INTO forum_thread (titre, commentaire_zero, date_thread) VALUES (:titre, :commentaire_zero, NOW())";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':commentaire_zero', $commentaire_zero);

    if ($stmt->execute()) {
        header('location: forum.php');
        echo "Le thread a été créé avec succès.";
    } else {
        header('location: forum.php');
        echo "Une erreur est survenue lors de la création du thread.";
    }
} else {
    header('location: forum.php');
    echo "Aucune donnée de formulaire reçue.";
}
?>
