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

// Vérification du rôle de l'utilisateur
if ($user && $user['role'] === 'admin') {
    // L'utilisateur a le rôle d'administrateur, le contenu de la page est accessible
    if (isset($_POST['email']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['role'])) {
        $idUtilisateur = $_GET['id'];
        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $role = $_POST['role'];

        // Vérification de l'existence de l'utilisateur dans la base de données
        $q = 'SELECT * FROM users WHERE id = :id';
        $statement = $bdd->prepare($q);
        $statement->execute(['id' => $idUtilisateur]);
        $existingUser = $statement->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            // Mise à jour des données de l'utilisateur
            $updateQuery = 'UPDATE users SET email = :email, nom = :nom, prenom = :prenom, role = :role WHERE id = :id';
            $updateStatement = $bdd->prepare($updateQuery);
            $updateStatement->execute([
                'email' => $email,
                'nom' => $nom,
                'prenom' => $prenom,
                'role' => $role,
                'id' => $idUtilisateur
            ]);

            // Vérification de la mise à jour de l'image de profil
            if ($_FILES['image']['name']) {
                $targetDir = 'uploads/';
                $targetFile = $targetDir . basename($_FILES['image']['name']);

                // Vérification du type de fichier
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png'];

                if (in_array($imageFileType, $allowedExtensions)) {
                    // Déplacement du fichier téléchargé vers le répertoire d'uploads
                    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

                    // Mise à jour du nom de fichier dans la base de données
                    $updateImageQuery = 'UPDATE users SET image = :image WHERE id = :id';
                    $updateImageStatement = $bdd->prepare($updateImageQuery);
                    $updateImageStatement->execute([
                        'image' => $_FILES['image']['name'],
                        'id' => $idUtilisateur
                    ]);
                }
            }

            $_SESSION['message'] = 'Utilisateur mis à jour avec succès.';
            header('location: users.php');
            exit;
        } else {
            // Utilisateur non trouvé
            header('location: users.php');
            exit;
        }
    } else {
        // Données du formulaire non soumises
        header('location: users.php');
        exit;
    }
} else {
    // L'utilisateur n'a pas le rôle d'administrateur, redirection vers la page d'accueil ou une autre page d'erreur
    header('location: index.php');
    exit;
}
?>
