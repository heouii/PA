<?php

include("../includes/db.php");

if (empty($_GET['search'])) {
    header("location: ../index.php");
}

$searchValue = '%' . $_GET["search"] . '%';

$async_query = $bdd->prepare('SELECT id, nom, prenom, sexe, age, email, role FROM users WHERE email LIKE ?');
$async_query->execute([$searchValue]);

$data = $async_query->fetchAll();

header('Content-Type: application/json');
echo json_encode($data);


?>
