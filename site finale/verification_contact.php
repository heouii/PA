<?php
// Connexion à la base de données MySQL
include('includes/db.php');

    // Vérification des champs
    if (empty($_POST['nom']) || empty($_POST['email']) || empty($_POST['telephone']) || empty($_POST['objet']) || empty($_POST['contact_commentaire'])) {
        header('Location: contact.php?message=Veuillez remplir tous les champs.');
        exit();
    }

    //Vérification du format de l'email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('location: contact.php?message=E-mail invalide');
        exit;
    }

    if (strlen($_POST['contact_commentaire']) > 500) {
        header('Location: contact.php?message=Le texte dépasse la limite de 500 caractères.');
        exit();
    }

    // Préparation de la requête pour insérer les données dans la table "contact"
    $q = 'INSERT INTO contact (nom, email, telephone, objet, contact_commentaire) 
    VALUES (:nom, :email, :telephone, :objet, :contact_commentaire)';
    $req = $bdd->prepare($q);
    $result = $req->execute([
        'nom' => $_POST['nom'],
        'email' => $_POST['email'],
        'telephone' => $_POST['telephone'],
        'objet' => $_POST['objet'],
        'contact_commentaire' => $_POST['contact_commentaire']
    ]);

    if ($result) {
        // Redirection vers la page de succès avec un message de confirmation
        header('Location: contact.php?message=Nous avons bien reçu votre formulaire de contact. Nous vous répondrons dans les plus brefs délais.');
        exit;
    } else {
        // Si la requête a échoué, redirection vers la page de formulaire avec un message d'erreur
        header('Location: contact.php?message=Erreur lors de l\'envoi du formulaire. Veuillez recommencer.');
        exit;
    }
?>
