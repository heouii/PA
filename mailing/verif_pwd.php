<?php

//Email de confirmation

// On récupère la clé et on vérifie les trucs bizarres

if(isset($_GET['key'])){
    

    $key = intval($_GET['key']);
    try{
		include("../includes/db.php");

    }catch (Exception $e) {
        
		header("location: ../index.php");
		exit;
    }


    $requser = $bdd ->prepare("SELECT * FROM users WHERE confirm_key = ?");

    $requser-> execute([$key]);

    $userexists = $requser->rowCount();
	
// UPDATE de la table SI l'utilisateur existe

    if($userexists != 1){
		header("location: ../index.php");
		exit;
	}
	
$title = "Réinitialiser mot de passe";
include("../includes/head.php");

}else{
	header("location: ../index.php");
}
 ?>
 
 <main>
	
	<form action = "update_pwd.php" method = "POST">
		<input type = "password" name = "pwd" placeholder = "Votre mot de passe">
		<input type = "password" name = "pwd_verif" placeholder = "Confirmer mot de passe">
		<input type = "hidden" name = "key" value = "<?= $key; ?>">
		<input type = "submit">
		
	
	</form>
 
 
 </main>

