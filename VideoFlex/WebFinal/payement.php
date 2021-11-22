<?php
session_start();
include("verif_user.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<title>Formulaire de saisie d'informations bancaires</title>
<style type="text/css">
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
  
input {
  color: white;
  font-style: italic;
  border: none;
  border-bottom: 2px solid red;
  background-color: transparent;
  padding:10px 6px 12px 6px;
}
    
input:active {
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
<h1>Formulaire de saisie d'informations bancaires</h1>
<form method="POST" action="">
	<table>
		<tr>
	<td>Prénom</td><td><input type="text" name="prenom"/></td>
		</tr>
	<tr><td>Nom</td><td><input type="text" name="nom"/></td>
		</tr>
	<tr><td>Numéro de carte bancaire</td><td> <input type="text" name="CB" maxlength="16" size="15"/></td>
		</tr>
	<tr><td>Cryptogramme</td><td><input type="text" name="crypto" maxlength="3" size="3"/></td>
		</tr>
</table><br/>
    <input type="submit" name="prec" value="Précédent" class = 'bouton' />
	<input type="reset" name="reset" value="Annuler" class = 'bouton'/> 
	<input type="submit" name="submit" value="Procéder au payement" class = 'bouton' />
<?php
    if(isset($_POST['submit'])){
        if(!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['CB']) && !empty($_POST['crypto'])){
            include("connexion.inc.php");
            $resultat = $cnx->prepare("UPDATE client SET date_deb_abo = ?, date_fin_abo = ?, type_abo = ? WHERE courriel= ?");
            echo $_SESSION['fin'];
            echo $_SESSION['debut'];
            
            $resultat->execute(array($_SESSION['debut'],$_SESSION['fin'],$_SESSION['abo'],$_SESSION['mail']));
            header('location:profil_inscription.php');
        }
        else{
            echo "Information manquante !";
        }
    }
    if(isset($_POST['prec'])){
        header('location:abonnement.php');
    }
?>
<p> Par mesure de sécurité, aucune donnée bancaire n'est enregistrée sur notre site, vous êtes donc priés de les rerentrer à chaque fois</p>
</form>
</body>
<?php
    include("piedpage.php");
?>
</html>
