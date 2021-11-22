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
<h2 style="font-style:oblique">Veuillez entrer le nom du pseudo.</h2>
<form method="POST" action="">
<p>
 <input type="text" name="Pseudo" placeholder="Pseudo" maxlength="25"/> <!-- On limite ici le nombre de caractère possible pour éviter que l'erreur arrive lorsqu'on les places dans la base -->
 <br>
 <br>
 <input type="submit" name="submit" value="Continuer" class = 'bouton'/>
</p>
</form>

<?php
include("connexion.inc.php");
if(isset($_POST['submit'])){
    if(!empty($_POST['Pseudo'])) {
        $pseudo = $_POST['Pseudo'];
        $resultat = $cnx->exec("INSERT INTO profil VALUES (DEFAULT, '".$pseudo."',".$_SESSION['login'].")");
        header('location:compte.php');
    }
}
?>
    
</body>
</html>