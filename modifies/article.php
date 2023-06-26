<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: index.php');
    exit;
}
?>
<?php
//var_dump($_SESSION['email']);
include('includes/db.php');

$title = 'page';

// Vérification si l'ID de l'article est présent dans l'URL
if (isset($_GET['id_article'])) {
    $articleId = $_GET['id_article'];

    // Requête pour récupérer les détails de l'article correspondant à l'ID
    $query = 'SELECT id_article, titre, categorie, corps_de_texte, image FROM article_post WHERE id_article = :id_article';
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':id_article', $articleId);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification si l'article existe dans la base de données
    if ($article) {
        $titre = $article['titre'];
        $corps_de_texte = $article['corps_de_texte'];
        $image = $article['image'];

        // Affichage de l'article
        include('includes/header.php');
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        ';
        //la page affichée
        echo '<div class="container">';
            
            //titre
            echo "<h1>$titre</h1>"; 
            //Retour à la page blog
            echo "<em> <a href='blog_liste.php'>Retour à la liste des sujets</a></em>";
            //structure du corps de texte
            //Image bannière
            echo "<p>$image</p>";
            echo '<div class="col-6">';
                echo "<p>$corps_de_texte</p>";
            echo '</div>';

            //Espace commentaire *en cours*
            //écrire le fichier commentaire.php
            //créer la table commentaires
                //clé étrangère de l'article pour les commentaires 
                //clé primaire 'id' pour chaque commentaire
            
            echo '<h2>Commentaires</h2>';
            echo '
                <form action="commentaire_verification.php" method="POST">
                <div class="form-group">
                        <label for="exampleFormControlTextarea1">Ecrire son com</label><br>
                        <textarea class"form-control" id="comment" name="comment" rows="2" style="width : 50%"></textarea>
                        <input type="hidden" name="id_article" value="' . htmlspecialchars($article['id_article']) . '">
                </div>
                <button type="submit" class="btn btn-success">Poster</button>
                </form>
            ';
            
        echo '</div>';
    } else {
        echo "L'article demandé n'existe pas.";
    }
                    // Requête pour récupérer les commentaires associés à l'article
                    $query = "SELECT id_comment, commentaire, date, id_commentateur FROM article_comment WHERE id_article = :id_article";
                    $stmt = $bdd->prepare($query);
                    $stmt->bindParam(':id_article', $articleId);
                    $stmt->execute();
                    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Vérification s'il y a des commentaires
                    if ($commentaires) {
                        // Affichage des commentaires
                        foreach ($commentaires as $commentaire) {
                            $commentId = $commentaire['id_comment'];
                            $commentText = $commentaire['commentaire'];
                            $commentDate = $commentaire['date'];
                            $idCommentateur = $commentaire['id_commentateur'];

                            // Requête pour récupérer l'email de l'utilisateur correspondant à l'id_commentateur
                            $queryUser = "SELECT email FROM users WHERE id = :id_commentateur";
                            $stmtUser = $bdd->prepare($queryUser);
                            $stmtUser->bindParam(':id_commentateur', $idCommentateur);
                            $stmtUser->execute();
                            $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

                            if ($user) {
                                $emailCommentateur = $user['email'];
                            } else {
                                $emailCommentateur = 'Utilisateur inconnu';
                            }

                            echo 
                            '<style>
                                .comment_container {
                                    background-color : lightgrey;
                                    max-width: 500px;
                                    margin-left : 70px;
                                    border-radius : ;
                                    border: black; 
                                }

                            </style>';

                            echo '<div class="comment_container">';
                                echo "<p>Commentaire #$commentId (le $commentDate) :</p>";
                                echo "<p>$commentText</p>";
                                echo "<p style='justify-content: right'><em>par $emailCommentateur</p>";
                            echo '</div>';
                        }
                    } else {
                        echo "Aucun commentaire pour cet article.";
                    }

} else {
    echo "Aucun ID d'article spécifié.";
}
?>
