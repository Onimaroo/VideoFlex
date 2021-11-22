<?php  //Partie chargée de verifier si l'utilisateur est connectée afin qu'il puisse accéder au site web 

if(empty($_SESSION['login']) || empty($_SESSION['mdp'])){
    header('location:accueil.php');
}
else{
    if(empty($_SESSION['profil'])){
        echo "Vous etes identifie comme l'utilisateur : ".$_SESSION['mail'].". Connectez vous sur un profil";
    }
}
?>