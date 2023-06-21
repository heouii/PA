<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: index.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" 
    crossorigin="anonymous">
    <title>Forum</title>

    <?php 
    $title = 'Forum';
    include('includes/header.php');
    ?>
</head>
<body>
    <main>
    <div class="container">
        <h1>Forum</h1>

        <h2>Créer un nouveau thread</h2>
        <form method="POST" action="forum_verification.php">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>

            <div class="form-group">
                <label for="commentaire_zero">Commentaire initial :</label>
                <textarea class="form-control" id="commentaire_zero" name="commentaire_zero" rows="4" cols="50" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Créer le thread</button>
        </form>


        <h2>Threads existants</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Commentaire initial</th>
                <th>Date de création</th>
            </tr>
            <?php
            include("includes/db.php");

            // Récupération des threads existants
            $query = "SELECT * FROM forum_thread";
            $stmt = $bdd->prepare($query);
            $stmt->execute();
            $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <table class="table table-striped mt-4">
                <tr>
                    <th>#</th>
                    <th>Thread</th>
                    <th>Commentaire</th>
                    <th>Date</th>
                </tr>
            
            <?php
            foreach ($threads as $thread) {
                echo "<tr>";
                    echo "<td>" . $thread['id_thread'] . "</td>";
                    echo "<td><a href='forum_thread.php?id_thread=" . $thread['id_thread'] . "'>" . $thread['titre'] . "</a></td>";
                    echo "<td>" . $thread['commentaire_zero'] . "</td>";
                    echo "<td>" . $thread['date_thread'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <main>
        <?php include('includes/footer.php') ?>
</body>
</html>
