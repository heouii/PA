<?php
// Pour que la page ne soit accessible qu'aux admins
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
    $title = 'Administration';
    include('includes/head.php');
    
    ?>

    <script defer src="js/search.js"></script>

    <body>

        <?php include('includes/header.php'); ?>

        <main>
            <div class="container">
                <h1><?= $title ?></h1>
                <div class="container mt-4">
                        <button class="btn btn-primary" onclick="toggleUsersTable()">Utilisateurs</button>
                        <button class="btn btn-primary" onclick="toggleArticle()">Article</button>
                        <button class="btn btn-primary" onclick="toggleContact()">Contact</button>
                        <button class="btn btn-primary" onclick="toggleForumThreads()">Forum Threads</button>
                        <button class="btn btn-primary" onclick="toggleForumThreadComments()">Forum Thread Comments</button>
                        <button class="btn btn-primary" onclick="toggleArticleComments()">Article Comments</button>
                    </div> <br>

                <?php include('includes/message.php'); ?>

                

                <div id="usersTable" style="display: none;">
                    <h2>Liste des utilisateurs</h2>
                    <?php include('includes/db.php'); ?>

                    <?php
                    $q = 'SELECT id, nom, prenom, sexe, age, email, role FROM users';
                    $req = $bdd->query($q);
                    $users = $req->fetchAll(PDO::FETCH_ASSOC);
                    ?>


                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>nom</th>
                            <th>prenom</th>
                            <th>sexe</th>
                            <th>age</th>
                            <th>role</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>

                        <tbody id="searchInput">

                        <?php
                        foreach ($users as $index => $user) {
                            echo '<tr>
                                <td>' . $user['id'] . '</td>
                                <td>' . $user['nom'] . '</td>
                                <td>' . $user['prenom'] . '</td>
                                <td>' . $user['sexe'] . '</td>
                                <td>' . $user['age'] . '</td>
                                <td>' . $user['role'] . '</td>
                                <td>' . $user['email'] . '</td>
                                <td>
                                    <a class="btn btn-secondary btn-sm" href="user_consulter.php?id=' . $user['id'] . '">Consulter</a>
                                    <a class="btn btn-primary btn-sm" href="user_modifier.php?id=' . $user['id'] . '">Modifier</a>
                                    <a class="btn btn-danger btn-sm" href="user_supprimer.php?id=' . $user['id'] . '">Supprimer</a>
                                </td>
                              </tr>';
                        }
                        ?>
                        </tbody>

                    </table>
                </div>

                <div id="article" style="display: none;">
                    <h2>Articles de Blog</h2>
                    <?php include('includes/db.php'); ?>

                    <?php
                    $q = 'SELECT id_article, nom, prenom, titre, categorie, LEFT(corps_de_texte, 50) AS extrait, image FROM article_post LIMIT 5';
                    $req = $bdd->query($q);
                    $articles = $req->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Extrait</th>
                            <th>Image</th>
                        </tr>

                        <?php
                        foreach ($articles as $index => $article) {
                            echo '<tr>
                                <td>' . $article['id_article'] . '</td>
                                <td>' . $article['nom'] . '</td>
                                <td>' . $article['prenom'] . '</td>
                                <td>' . $article['titre'] . '</td>
                                <td>' . $article['categorie'] . '</td>
                                <td>' . $article['extrait'] . '</td>
                                <td>' . $article['image'] . '</td>
                              </tr>';
                        }
                        ?>

                    </table>
                </div>

                <div id="contact" style="display: none;">
                    <h2>Contact</h2>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Objet</th>
                            <th>Message</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM contact';
                        $req = $bdd->query($q);
                        $contacts = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($contacts as $contact) {
                            echo '<tr>
                                    <td>' . $contact['id'] . '</td>
                                    <td>' . $contact['nom'] . '</td>
                                    <td>' . $contact['email'] . '</td>
                                    <td>' . $contact['telephone'] . '</td>
                                    <td>' . $contact['objet'] . '</td>
                                    <td>' . $contact['contact_commentaire'] . '</td>
                                </tr>';
                        }
                        ?>
                    </table>
                </div>

                <div id="forumThreads" style="display: none;">
                    <h2>Forum Threads</h2>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Post original</th>
                            <th>Autheur</th>
                            <th>Date</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM forum_thread';
                        $req = $bdd->query($q);
                        $forumThreads = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($forumThreads as $thread) {
                            echo '<tr>
                                    <td>' . $thread['id_thread'] . '</td>
                                    <td>' . $thread['titre'] . '</td>
                                    <td>' . $thread['commentaire_zero'] . '</td>
                                    <td>' . $thread['author'] . '</td>
                                    <td>' . $thread['date_thread'] . '</td>
                                </tr>';
                        }
                        ?>
                    </table>

                </div>

                <div id="forumThreadComments" style="display: none;">
                    <h2>Forum Thread Comments</h2>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Thread ID</th>
                            <th>Autheur</th>
                            <th>Commentaire</th>
                            <th>Date</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM forum_thread_comment';
                        $req = $bdd->query($q);
                        $forumThreadComments = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($forumThreadComments as $forumThreadComments) {
                            echo '<tr>
                                    <td>' . $forumThreadComments['id_forum_comment'] . '</td>
                                    <td>' . $forumThreadComments['id_forum_thread'] . '</td>
                                    <td>' . $forumThreadComments['id_commentateur'] . '</td>
                                    <td>' . $forumThreadComments['commentaire'] . '</td>
                                    <td>' . $forumThreadComments['date'] . '</td>
                                </tr>';
                        }
                        ?>
                    </table>

                </div>

                <div id="articleComments" style="display: none;">
                    <h2>Article Comments</h2>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>commenatire</th>
                            <th>id comment</th>
                            <th>id_commentateur</th>
                            <th>Date</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM article_comment';
                        $req = $bdd->query($q);
                        $articleComments = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($articleComments as $comment) {
                            echo '<tr>
                                    <td>' . $comment['id_comment'] . '</td>
                                    <td>' . $comment['commentaire'] . '</td>
                                    <td>' . $comment['id_commentateur'] . '</td>
                                    <td>' . $comment['id_article'] . '</td>
                                    <td>' . $comment['date'] . '</td>
                                </tr>';
                        }
                        ?>
                    </table>

                </div>

                <script>
                    function toggleUsersTable() {
                        var usersTable = document.getElementById('usersTable');
                        var article = document.getElementById('article');
                        var contact = document.getElementById('contact');
                        var forumThreads = document.getElementById('forumThreads');
                        var forumThreadComments = document.getElementById('forumThreadComments');
                        var articleComments = document.getElementById('articleComments');

                        usersTable.style.display = 'block';
                        article.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreads.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleArticle() {
                        var article = document.getElementById('article');
                        var usersTable = document.getElementById('usersTable');
                        var contact = document.getElementById('contact');
                        var forumThreads = document.getElementById('forumThreads');
                        var forumThreadComments = document.getElementById('forumThreadComments');
                        var articleComments = document.getElementById('articleComments');

                        article.style.display = 'block';
                        usersTable.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreads.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleContact() {
                        var article = document.getElementById('article');
                        var usersTable = document.getElementById('usersTable');
                        var contact = document.getElementById('contact');
                        var forumThreads = document.getElementById('forumThreads');
                        var forumThreadComments = document.getElementById('forumThreadComments');
                        var articleComments = document.getElementById('articleComments');

                        contact.style.display = 'block';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        forumThreads.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleForumThreads() {
                        var forumThreads = document.getElementById('forumThreads');
                        var usersTable = document.getElementById('usersTable');
                        var article = document.getElementById('article');
                        var contact = document.getElementById('contact');
                        var forumThreadComments = document.getElementById('forumThreadComments');
                        var articleComments = document.getElementById('articleComments');

                        forumThreads.style.display = 'block';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleForumThreadComments() {
                        var forumThreadComments = document.getElementById('forumThreadComments');
                        var usersTable = document.getElementById('usersTable');
                        var article = document.getElementById('article');
                        var contact = document.getElementById('contact');
                        var forumThreads = document.getElementById('forumThreads');
                        var articleComments = document.getElementById('articleComments');

                        forumThreadComments.style.display = 'block';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreads.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleArticleComments() {
                        var articleComments = document.getElementById('articleComments');
                        var usersTable = document.getElementById('usersTable');
                        var article = document.getElementById('article');
                        var contact = document.getElementById('contact');
                        var forumThreads = document.getElementById('forumThreads');
                        var forumThreadComments = document.getElementById('forumThreadComments');

                        articleComments.style.display = 'block';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreads.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                    }
                </script>
            </div>
        </main>

        <?php include('includes/footer.php'); ?>

    </body>

    </html>
<?php } else {
    // L'utilisateur n'a pas le rôle d'administrateur, rediriger vers une autre page par exemple
    header('location: index.php');
    exit;
}
