<?php //Acceuil général avant même connexion mais si deja connecté pas besoin
session_start();
if(!empty($_SESSION['login']) && !empty($_SESSION['mdp'])){ //Signifie que l'on est deja connecté 
    header('location:accueilco.php');
}
include("piedpage.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<title></title>
<style type="text/css" media="screen">
body { 
    display: inline;
	color:red;
    background-color: black;
    background-image: url('Fond.jpeg');
    font-style: bold, italic;
    font-family: Arial;
    text-align: center;
	}
.outer-div {
     padding: 80px;
}
.inner-div {
     margin: 0 auto;
     width: 500px; 
     border:3px solid black;
     border-color: #5E5E5E;
     border-radius: 10px;
     background-color: #444444;
     padding: 30px;
}
.bouton {
	border:none;
	padding:10px 6px 12px 6px;
	border-radius:8px;
	background:#d34836;
	font:bold 20px Arial;
	color:#fff;
	cursor: pointer;
}
</style>
</head>

<body>
<form method="POST" action="accueil.php">

<div class="outer-div">
<a href="https://fontmeme.com/netflix-font/"><img src="https://fontmeme.com/permalink/191219/2a708958970cb13cb89e7beab200971b.png" alt="videoflex-logo" border="0"></a>
        <div class="inner-div">
            <h1>Bonjour et bienvenue à l'accueil général !</h1>
            <h2> Veuillez vous connecter. </h2>
            <input type="submit" name="con" value="Connexion" class="bouton">
            <h2> Nouveau sur le site? </h2>
            <input type="submit" name="ins" value="Inscription" class="bouton">
        </div>
    </div>
</form>
<?php
if(isset($_POST['con'])){
    header('location:connexion.php');
}

if(isset($_POST['ins'])){
    header('location:inscription.php');
}
?>
</body>
</html>