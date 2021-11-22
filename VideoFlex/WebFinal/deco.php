<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['mdp']);
session_destroy(); //Fermeture de la seesion
header('location:accueil.php'); //Retour à l'acceuil de base

?>