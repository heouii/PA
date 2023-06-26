<?php 
session_start();
if(!isset($_SESSION['email'])){
	header('location: index.php');
	exit;
}
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Poster un article</title>
</head>

<body>
    <div class="container">
        <?php 
          	$title = 'postArticle';
            include('includes/header.php'); ?>
        <h1>Publier un article</h1>
        <?php
        if (isset($_GET['message']) && !empty($_GET['message'])) {
            echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
        }
        ?>
        <form method="POST" action="post_article_verification.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="nom" placeholder="Votre nom" style="max-width: 100%;">
                </div>
                <div class="col-md-6">
                    <input type="text" name="prenom" placeholder="Votre prénom" style="max-width: 100%;">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="titre" placeholder="Titre de l'article" style="max-width: 100%;">
                </div>
                <div class="col-md-2">
                    <!-- <label for="categorie">Catégorie :</label>-->
                    <select id="categorie" name="categorie" style="max-width: 100%;">
                        <option value="actualite">Actualité</option>
                        <option value="nutrition">Nutrition</option>
                        <option value="exercice_physique">Exercices physique</option>
                        <option value="interview">Interview</option>
                        <option value="divers">Divers</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="file" name="image" accept="image/jpeg, image/png, image/gif" style="max-width: 100%;">
                </div>
            </div>
            <div class="col-md-12">
                <div col-md-2>
                    <textarea name="corps_de_texte" id="text" placeholder="Corps de texte" rows="7" maxlength="3000" 
                    style="max-width: 100%;"></textarea>
                </div>  
            </div>    
                    <div id="count"> <p><span id="current_count">0</span>/3000</p> </div>
            <!-- Ajout dynamique de champs image et texte -->
            <!-- <div id="ajout_images_textes"></div> -->
            <!-- <button type="button" onclick="ajouterChamps()">Ajouter</button> -->
            <br>
            <button type="submit" class="btn btn-primary" value="Poster">Poster</button>
        </form>
    </div>
</body>


                    <script  type="text/javascript">
                        //compte des mots dans le champs textarea
                        document.addEventListener('DOMContentLoaded', function() {
                            var textarea = document.querySelector('textarea');
                            var currentCount = document.getElementById('current_count');
                            
                            textarea.addEventListener('input', function() {
                                var characterCount = textarea.value.length;
                                currentCount.textContent = characterCount;
                            });
                        });
                    
                        let count = 0; // Initial count for new image fields
                        function ajouterChamps() {
                            var div = document.createElement('div');
                            var champImage = document.createElement('input');
                            champImage.type = 'file';
                            champImage.name = 'images[]' + count;
                            champImage.id = 'images[]' + count;
                            champImage.accept = 'image/png, image/jpg';

                            var champTexte = document.createElement('textarea');
                            champTexte.name = 'textes[]' + count;
                            champTexte.id = 'textes[]' + count;
                            champTexte.placeholder = 'corps de texte';

                            div.appendChild(champImage);
                            div.appendChild(champTexte);

                            document.getElementById('ajout_images_textes').appendChild(div);
                        }
                    </script>


                    <style>
                        /* Ajouter des marges autour des champs de saisie */
                        input[type="text"],
                        textarea,
                        select {
                            margin: 10px 0;
                            padding: 5px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            box-sizing: border-box;
                            width: 100%;
                            max-width: 500px;
                        }

                        /* Ajouter des marges autour des champs d'image */
                        #image_banniere_article,
                        input[type="file"] {
                            margin: 10px 0;
                        }

                        /* Ajouter une marge entre les champs d'image et texte ajoutés dynamiquement */
                        #ajout_images_textes>div {
                            margin-top: 20px;
                        }

                        /* Design responsive pour les petits écrans */
                        @media only screen and (max-width: 600px) {

                            input[type="text"],
                            textarea,
                            select {
                                max-width: 100%;
                            }
                        }
                    </style>
            

</html>