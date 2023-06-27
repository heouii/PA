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

    if($userexists == 1){
        $user = $requser->fetch();
        if($user['is_valid'] == 0){
            $update_user = $bdd->prepare("UPDATE users SET is_valid = 1 WHERE confirm_key = ?");
            $update_user -> execute([$key]);
            echo "Votre compte a bien été confirmé ! ";
        }else{
            echo "Cet utilisateur a déjà été vérifié";
        }

    }else {
        header("location: index.php");
    }
	
//UPDATE de la key
$q_id = $bdd->prepare("SELECT id FROM users WHERE email=?");
$q_id->execute([$user['email']]);
$data = $q_id->fetchAll();



$key = "";
	for($i=1;$i < 12;$i++){

    $key .= mt_rand(0,9);

  
}

$key .= $data[0]['id'];

$last = $bdd -> prepare("UPDATE users SET confirm_key=? WHERE email=?");
$last->execute([$key,$user['email']]);

}