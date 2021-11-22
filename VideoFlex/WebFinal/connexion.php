<?php
session_start();
if(!empty($_SESSION['login']) && !empty($_SESSION['mdp'])){ //Signifie que l'on est deja connecté, on ne peut donc pas accéder à cette poage
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
	color:red;
    background-color: black;
    background-image: url('Fond.jpeg');
    font-style: bold, italic;
    font-family: Arial;
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
  
input[type=text], input[type=password] {
  color: white;
  font-style: italic;
  border: none;
  border-bottom: 2px solid red;
  background-color: transparent;
  padding:10px 6px 12px 6px;
}
    
input[type=text]:active, input[type=password]:active {
  color: white;
  font-style: italic;
  border: none;
  border-bottom: 2px solid red;
  background-color: transparent;
  padding:10px 6px 12px 6px;
}
</style>

</head>

<body>
<h1 style="display:inline;border-width:5px;border-style:double;border-color:red; padding:0 10px 0 10px;">Formulaire de connexion</h1>
<form method="POST" action="">
<p>
 <input type="text" name="Id" placeholder="E-mail" maxlength="75"/>
 <br />
 <input type="password" name="Mdp" placeholder="Mot de passe" maxlength="25"/>
 <br />
 <br>
 <br>
 <input type="submit" name="submit" value="Valider" class = "bouton"/>
</p>
</form>

<?php

if(isset($_POST['submit'])){
    if(!empty($_POST['Id']) && !empty($_POST['Mdp'])){ //On regarde si toutes les informations sont rentrées
        $email = $_POST['Id'];
        $mdp = md5($_POST['Mdp']);
        include("connexion.inc.php");
        $resultat1 = $cnx->query("SELECT * FROM client WHERE courriel='".$email."'"); //On cherche dans la base si l'adresse existe
        
        if($resultat1 == NULL){ //Filtre permettant de vérifier si l'adresse email est valide ou non
            echo "Adresse email non reconnu";
            echo "<p>Cliquez <a href='inscription.php'>ici</a> pour vous inscire";
        }

        $resultat2 = $cnx->query("SELECT * FROM client where courriel ='".$email."'");
        $donne = $resultat2->fetch();
        if($donne['mdp']!=$mdp){ //Le mdp est donc différent de celui de la base
            echo "Mot de passe incorrect, veuillez réessayer"; 
        }
        else{
            $_SESSION['login'] = $donne['num_cli'];
            $_SESSION['mdp'] = $mdp;
            $_SESSION['mail'] = $email;
            $_SESSION['abo'] = $donne['type_abo'];
            $_SESSION['debut'] = $donne['date_deb_abo'];
            $_SESSION['fin'] = $donne['date_fin_abo'];
            header("location:profil.php");
        }
    }
    else{
        echo "Veuillez rentrer toutes les informations";
    }
}
?>
</body>
</html>