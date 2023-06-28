<?php

// Les fichiers du formulaire arrivent dans le $_FILES


// Les données du formulaire arrivent dans le $_POST

// Si l'email n'est pas vide, enregistrer cet email dans un cookie avec la fonction setcookie()
if(isset($_POST['email']) && !empty($_POST['email'])){
	setcookie('email', $_POST['email'], time() + 24 * 3600); 
}

// Si email ou password vide > redirection vers le formulaire avec un paramètre get "message" : "Vous devez remplir les 2 champs."

if(!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['mdp']) || empty($_POST['mdp'])){
	// Redirection avec un message d'erreur
	header('location: inscription.php?message=Vous devez remplir les 2 champs !&type=danger');
	exit;
}


// Si email invalide > redirection vers le formulaire avec un paramètre get "message" : "Email invalide."

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	// Redirection avec un message d'erreur
	header('location: inscription.php?message=Email invalide !&type=danger');
	exit;
}


// Si le mot de passe ne fait pas entre 6 et 12 caractères > redirection
if(strlen($_POST['mdp']) < 6 || strlen($_POST['mdp']) > 12){
	// Redirection avec un message d'erreur
	header('location: inscription.php?message=Le mot de passe doit faire entre 6 et 12 caractères.&type=danger');
	exit;
}



// Vérifications du fichier reçu

if($_FILES['image']['error'] != 4){ // Un fichier a été envoyé

	// Vérifier le type
	$acceptable = [
					'image/jpeg',
					'image/png',
					'image/gif'
					];

	if(!in_array($_FILES['image']['type'], $acceptable)){
		// Redirection avec un message d'erreur
		header('location: inscription.php?message=L\'image doit être de type jpeg, gif ou png.&type=danger');
		exit;
	}			
	
	// Vérifier la taille
	$maxSize = 2 * 1024 * 1024; // 2Mo exprimés en octets
	
	if($_FILES['image']['size'] > $maxSize){
		// Redirection avec un message d'erreur
		header('location: inscription.php?message=L\'image doit faire moins de 2Mo.&type=danger');
		exit;
	}


	// Enregistrer le fichier sur le serveur

	// Créer un dossier uploads s'il n'existe pas
	if(!file_exists('uploads')){
		mkdir('uploads');
	}

	$from = $_FILES['image']['tmp_name'];

	$array = explode('.', $_FILES['image']['name']); // profil.min.png donne ['profil', 'min', 'png']               
	$ext = end($array); // récupère le dernier élément du tableau

	$filename = 'image-' . time() . '.' . $ext; 


	$destination = 'uploads/' . $filename;
 
	$move = move_uploaded_file($from, $destination); // Renvoie un booléen

	if(!$move){
		// Redirection avec un message d'erreur
		header('location: inscription.php?message=Erreur lors de l\'enregistrement de l\'image.&type=danger');
		exit;
	}
}

include('includes/db.php');

// Si l'email est déjà utilisé > redirection

// Requete préparée
$q = 'SELECT id FROM users WHERE email = ?';
// Préparation de la requete
$req = $bdd->prepare($q);
// Execution de la requete
$req->execute([$_POST['email']]);
// Récupération des résultats
$results = $req->fetchAll();

if(!empty($results)){
	// Redirection avec un message d'erreur
	header('location: inscription.php?message=Email déjà utilisé.&type=danger');
	exit;
}

// Si on arrive ici,c'est que les infos sont correctes...


// Préparation de la requête = SECURITE !!
$q = 'INSERT INTO users (email, mdp, image, sexe, nom, prenom, age, role,confirm_key) VALUES (:email, :mdp, :image, :sexe, :nom, :prenom, :age, :role, :key)';
$req = $bdd->prepare($q);

$result = $req->execute([
    'mdp' => hash('sha256', $_POST['mdp']),
    'email' => $_POST['email'],
    'image' => isset($filename) ? $filename : '',
    'sexe' => $_POST['sexe'],
    'nom' => $_POST['nom'],
    'prenom' => $_POST['prenom'],
    'age' => $_POST['age'],
	'role' => 'utilisateur',
	'key' => 0
]);
//Création de la clé : 
$q_id = $bdd->prepare("SELECT id FROM users WHERE email=?");
$q_id->execute([$_POST['email']]);
$data = $q_id->fetchAll();



$key = "";
	for($i=1;$i < 12;$i++){

    $key .= mt_rand(0,9);

  
}

$key .= $data[0]['id'];

// Ajout de la clé

$last = $bdd -> prepare("UPDATE users SET confirm_key=? WHERE email=?");
$last->execute([$key,$_POST['email']]);


//Envoi du mail 

include("includes/phpmailer.php");

$objet = "Vérification de votre compte JibSports";

$message = "Bonjour,
voici le lien vous permettant de vérifier votre compte JibSports : jib-sports.ddns.net/mailing/verif_mail.php?key=".$key;

$destinataire = $_POST['email'];

sendmail($message,$objet,$destinataire);

if(!$result){
	// Redirection avec un message d'erreur
	header('location: inscription.php?message=Erreur lors de l\'inscription.&type=danger');
	exit;
}


// Redirection vers la page de connexion avec un message
header('location: connexion.php?message=Un email vous a été envoyé !&type=success');
exit;

?>
