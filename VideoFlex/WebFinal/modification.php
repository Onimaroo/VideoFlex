<?php
session_start();
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
<h2 style="font-style:oblique">Veuillez rentrer les informations vous concernant.</h2>
<form method="POST" action="">
<p>
 <input type="text" name="Nom" placeholder="Nom" maxlength="25"/> <!-- On limite ici le nombre de caractère possible pour éviter que l'erreur arrive lorsqu'on les places dans la base -->
 <br />
 <input type="text" name="Prenom" placeholder="Prénom" maxlength="25"/>
 <br />
 <input type="text" name="Adresse" placeholder="Adresse" maxlength="100"/>
 <br />
 <input type="email" name="Courriel" placeholder="E-mail" maxlength="75"/>
 <br />
 <input type="password" name="Mdp" placeholder="Mot de passe" />
 <br />
 <br>
 <br>
 <input type="submit" name="submit" value="Continuer" class = 'bouton'/>
</p>
</form>

<?php
if(isset($_POST['submit'])){
    if(!empty($_POST['Nom']) && !empty($_POST['Prenom']) && !empty($_POST['Adresse']) && !empty($_POST['Courriel']) && !empty($_POST['Mdp'])){ //Si rien est vide
        $email = $_POST['Courriel'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //Filtre permettant de vérifier si l'adresse email est valide ou non
            echo "Adresse email non valide";
        }
        include("connexion.inc.php");
        $resultat = $cnx->query("SELECT * FROM client where courriel ='".$email."'");
        $donne = $resultat->fetch();
        if($donne['nom']!=NULL){
            echo "Cette adresse mail a deja été utilisé";  //En qlq sorte l'adresse mail est la clé primaire du client
        }
        else{
            $nom = $_POST['Nom'];
            $prenom = $_POST['Prenom'];
            $adresse = $_POST['Adresse'];
            $mdp = md5($_POST['Mdp']);  //Chiffrement md5 pour le mdp  
            $resultat = $cnx->exec("UPDATE client SET nom = '".$nom."' WHERE num_cli = '".$_SESSION['login']."'");
            $_SESSION['nom'] = $nom;
            $resultat2 = $cnx->exec("UPDATE client SET prenom = '".$prenom."' WHERE num_cli = '".$_SESSION['login']."'");
            $_SESSION['prenom'] = $prenom;
            $resultat3 = $cnx->exec("UPDATE client SET adresse = '".$adresse."' WHERE num_cli = '".$_SESSION['login']."'");  
            $_SESSION['adresse'] = $adresse;
            $resultat4 = $cnx->exec("UPDATE client SET courriel = '".$email."' WHERE num_cli = '".$_SESSION['login']."'");  
            $_SESSION['mail'] = $email;
            header('location:accueilco.php');
        }
    }
    else{
        echo "Veuillez rentrer toutes les informations";
    }
}
?>
</body>
</html>