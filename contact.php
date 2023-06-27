<?php
session_start();
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}
?>


<!DOCTYPE html>
<div class="background-image">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <title>Contact</title>
        <style>
            #word_count {
                font-size: 9px;
            }
        </style>
        <style>
            p h1 h2 {
                color: white;
            }

            a {
                color: white
            }

            .container h1 {
                color: white;
            }


            html p {
                color: white;
            }

            .background-image {
                background-image: url('imagerie/pexels-ivan-samkov-4164520.jpg');
                background-repeat: no-repeat;
                background-size: cover;
            }

            .header,
            .footer {
                background-image: url('imagerie/pexels-ivan-samkov-4164520.jpg');
                background-repeat: no-repeat;
                background-size: cover;
            }

            
            .contact-form {
                display: flex;
                flex-direction: column;
                align-items:flex-end;
                margin: auto;
                
            }

            .btn-orange {
                background-color: #DC5E18;
                border-color: #DC5E18;
                color : white;  
            }

        </style>
    </head>
    <?php 
	$title = "Contact";
	include('includes/header.php'); ?>
    <?php include('includes/db.php') ?>
    <main>
    <div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Nous contacter</h1>
            <p style="font-size: 16px;">Si vous avez des demandes, des suggestions ou des remarques à nous faire, n’hésitez pas à nous écrire à : contact@jikworks.com</p>
        </div>
        <div class="col-md-6">
        <br><br><br>

            <form method="POST" action="verification_contact.php"   class="contact-form">
                <div class="row mb-3 col-9">
                     
                <input type="name" name="nom" placeholder="Nom" >
                <!-- class="form-control bg-light bg-gradient bg-opacity-10 text-white p-2"> -->


                    
                </div>
                 <div class="row mb-3 col-9">
                     
                        <input type="email" name="email"   placeholder="Votre E-Mail" value="<? (isset($_COOKIE['email']) ? $_COOKIE['email'] : '') ?>">
                    
                </div>
                 <div class="row mb-3 col-9">
                     
                        <input type="number" name="telephone" placeholder="Téléphone" min="10"  >
                    
                </div>
                 <div class="row mb-3 col-9">
                     
                        <label for="objet"></label>
                        <select id="objet" name="objet"  >
                            <option value="Selectionner un objet">Sélectionner un objet</option>
                            <option value="Demande d'information">Demande d'information</option>
                            <option value="Reservation">Réservation</option>
                            <option value="Sugestion">Suggestion</option>
                            <option value="Reclamation">Réclamation</option>
                            <option value="Autre">Autre</option>
                        </select>
                    
                </div>
                 <div class="row mb-3 col-9">
                     
                        <textarea name="contact_commentaire" id="text" placeholder="Votre message"   rows="5" maxlength="500"></textarea>
                        <div id="word_count">
                            <p><span id="current_count">0</span>/500</p>
                        
                    </div>
                </div>
                 <div class="row mb-3 col-9">
                     
                        <button type="submit" class="btn btn-orange" id="envoyer" value="Envoyer"  >Envoyer</button>
                    
                </div>
            </form>
        </div>
    </main>

    </body>
    <script type="text/javascript">
        //compte des mots dans le champs textarea
        document.addEventListener('DOMContentLoaded', function () {
            let textarea = document.querySelector('textarea');
            let currentCount = document.getElementById('current_count');

            textarea.addEventListener('input', function () {
                let characterCount = textarea.value.length;
                currentCount.textContent = characterCount;
            });
        });
    </script>

    <footer class="footer">
        <?php include('includes/footer.php'); ?>
    </footer>
</div>
</html>
