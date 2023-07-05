²<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
</head>
<body>
    <?php
    $title = "Newsletter";
    include("../../includes/header.php"); 
    ?>
    
    <main>
        <form method="POST" action="add_address_newsletter.php">
            <input type="email" name = "email" placeholder="Entrez votre email">
            <input type="submit">

        </form>

    </main>
    
</body>
</html>