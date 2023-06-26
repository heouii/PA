<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <style>
		p {
			color : white;
		}
		.container h1 {
			color : white;
		}
        .background-image {
            background-image: url('imagerie/pexels-victor-freitas-949131.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .header, .footer {
            background-image: url('imagerie/pexels-victor-freitas-949131.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="background-image">
        <?php 
        $title = 'Accueil';
        include('includes/head.php');
        ?>

        <header class="header">
            <?php include('includes/header.php'); ?>
        </header>

        <main>
            <div class="container" style="height:1000px">
                <h1>Accueil</h1>

                <?php include('includes/message.php'); ?>
                
                <p>
                    <?php 
                    if(!isset($_SESSION['email'])){
                        echo 'Contenu non disponible.';
                    }else{
                        echo 'Voici votre contenu privé :)';
                    }
                    ?>
                </p>
            </div>
        </main>

        <footer class="footer">
            <?php include('includes/footer.php'); ?>
        </footer>
    </div>
</body>
</html>
