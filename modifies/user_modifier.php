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
    if (isset($_GET['id'])) {
        $idUtilisateur = $_GET['id'];

        // Requête pour récupérer les données de l'utilisateur
        $q = 'SELECT email, nom, prenom, role, image FROM users WHERE id = :id';
        $statement = $bdd->prepare($q);
        $statement->execute(['id' => $idUtilisateur]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $email = $user['email'];
            $nom = $user['nom'];
            $prenom = $user['prenom'];
            $role = $user['role'];
            $image = $user['image'];
        } else {
            // Utilisateur non trouvé
            header('location: users.php');
            exit;
        }
    } else {
        // ID utilisateur non spécifié
        header('location: users.php');
        exit;
    }
} else {
    // L'utilisateur n'a pas le rôle d'administrateur, redirection vers la page d'accueil ou une autre page d'erreur
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<?php
$title = 'Modifier utilisateur';
include('includes/head.php');
?>

<body>

    <?php include('includes/header.php'); ?>

    <main>
        <div class="container">
            <h1><?= $title ?></h1>

            <?php include('includes/message.php'); ?>

            <form method="POST" action="user_update.php?id=<?= $idUtilisateur ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required>
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= $nom ?>" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= $prenom ?>" required>
                </div>
                <div class="form-group">
                    <label for="role">Rôle</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="admin" <?= ($role === 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="utilisateur" <?= ($role === 'utilisateur') ? 'selected' : '' ?>>Utilisateur</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image de profil</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <?php if ($image): ?>
                    <div class="form-group">
                        <label>Image de profil actuelle</label>
                        <br>
                        <img src="uploads/<?= $image ?>" alt="profil" style="max-width: 200px; max-height: 200px">
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </main>

</body>

</html>
