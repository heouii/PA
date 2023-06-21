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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Actus&Blog</title>
    
    <?php 
  	$title = 'Actus&Blog';
    include('includes/header.php'); ?>

</head>

<body> 
    <div class="container">
        <div class="barre_blog">
            <!-- BOUTON NOUVEL ARTICLE -->
            <a href="article_post.php">
                <div class="bouton_nouvel_article">
                    <div class="overlap-group-1">
                        <div class="nouvel-article">Nouvel Article</div>
                    </div>
                </div>
            </a>
            <!-- BARRE DE RECHERCHE -->
            <form action="search.php" method="GET">
                <div class="barre_de_recherche">
                    <div class="que-recherchez-vous">Que recherchez-vous ?</div>
                    <div class="centered-content">
                        <input type="text" name="query" placeholder="Recherchez ici" style="display: inline-block; width : 350px;" />
                        <input type="submit" value="Rechercher" style="display: inline-block;" />
                    </div>
                </div>
            </form>
            <!-- FILTRE DE RECHERCHE -->
            <form action="search.php" method="GET">
                <div class="filtre_article">
                    <div class="catgories">
                        <select name="categorie">
                            <option value="">Toutes les catégories</option>
                            <option value="actualite">Actualité</option>
                            <option value="nutrition">Nutrition</option>
                            <option value="exercice_physique">Exercice Physique</option>
                        </select>
                    </div>
                    <input type="submit" value="Filtrer" style="display: inline-block;" />
                </div>
            </form>
        </div>
        <?php
            include("includes/db.php");
        
            // Requête pour récupérer les articles
            $query = "SELECT id_article, titre, categorie, corps_de_texte, image FROM article_post";
            $stmt = $bdd->prepare($query);
            $stmt->execute();
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Affichage des résultats
            foreach ($articles as $article) {
                echo '<div class="article-box">';
        
                if (!empty($article['image'])) {
                    echo '<img src="' . $article['image'] . '" alt="Image de l\'article" style="max-width:150px" >';
                } else {
                    echo '<div class="image-placeholder" ></div>';
                }

        
                echo '<h2><a href="article.php?id_article=' . $article['id_article'] . '">' . $article['titre'] . '</a></h2>';
        
                // Récupération des 15 premiers mots du corps de texte de l'article
                $corpsDeTexte = $article['corps_de_texte'];
                $mots = explode(' ', $corpsDeTexte);
                $premiersMots = array_slice($mots, 0, 15);
                $premiersMotsTexte = implode(' ', $premiersMots);
        
                echo '<p class="introduction"><strong>Introduction:</strong> ' . $premiersMotsTexte . '...</p>';
                echo '</div>';
            }
        
        ?>
    </div>
    
</body>
</html>
