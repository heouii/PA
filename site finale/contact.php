<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, intial scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <title>Contact</title>
        <style>
            #word_count {
                font-size: 9px;
            }
        </style>
    </head>
    <?php include('includes/header.php'); ?>
    <main>
    <div class="container">
        <h1>Nous contacter</h1>
        <p style="font-size: 16px;">Si vous avez des demandes, des suggestions ou des remarques à nous faire, n’hésitez pas à nous écrire à : contact@jikworks.com</p>

        <?php 

        include('includes/db.php')

    
        ?>

        <form method="POST" action="verification_contact.php"  style="max-width: 100%;">
            <div class="row mb-3">
                <div class="col-9">
                    <input type="name" name="nom" placeholder="Nom" style="max-width: 100%;">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-9">
                    <input type="email" name="email"  style="max-width: 100%;" placeholder="Votre E-Mail" 
                    value="<? (isset($_COOKIE['email']) ? $_COOKIE['email'] : '') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <input type="number" name="telephone" placeholder="Téléphone" min="10"  style="max-width: 100%;">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-9">
                    <label for="objet"></label>
                    <select id="objet" name="objet"  style="max-width: 100%;">
                        <option value="Selectionner un objet">Sélectionner un objet</option>
                        <option value="Demande d'information">Demande d'information</option>
                        <option value="Reservation">Réservation</option>
                        <option value="Sugestion">Suggestion</option>
                        <option value="Reclamation">Réclamation</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-9">
                    <textarea name="contact_commentaire" id="text" placeholder="Votre message" 
                    style="max-width: 100%;" rows="5" maxlength="500"></textarea>
                    <div id="word_count">
                        <p><span id="current_count">0</span>/500</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-9">
                    <button type="submit" class="btn btn-primary" id="envoyer" value="Envoyer"
                    style="max-width: 100%;">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</main>

</body>
        <script type="text/javascript">
            //compte des mots dans le champs textarea
            document.addEventListener('DOMContentLoaded', function() {
                let textarea = document.querySelector('textarea');
                let currentCount = document.getElementById('current_count');
                
                textarea.addEventListener('input', function() {
                    let characterCount = textarea.value.length;
                    currentCount.textContent = characterCount;
                });
            });
        </script>

        


</html>