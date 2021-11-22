<?php
session_start();
//if(!empty($_SESSION['login']) && !empty($_SESSION['mdp'])){ //Signifie que l'on est deja connecté 
//  header('location:accueilco.php');
//}
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
<?php
include("connexion.inc.php");
if(isset($_POST['submit'])){
    if(!empty($_POST['profil'])) {
        $pseudo = $_POST['profil'];
        $resultat = $cnx->exec("DELETE FROM profil WHERE pseudo = '".$pseudo."'");
        header('location:compte.php');
    }
}
?>
<h2 style="font-style:oblique">Veuillez choisir le profil à effacer.</h2>
<?php
    echo "<form method='POST' action=''>";
    $resultat = $cnx->query("SELECT * FROM profil WHERE num_cli='".$_SESSION['login']."'");
    $donne = $resultat->fetchall();
    foreach($donne as $val){
        if($val['pseudo'] != $_SESSION['profil']) { //Si le profil qu'on souhaite effacer n'est pas le même que celui auquel on est connecté
            echo $val['pseudo'];
            echo "<input type='radio' name='profil' value='".$val['pseudo']."' />";
            echo "<br>";
        }
    }
    echo "<input type='submit' name='submit' value='Continuer' class = 'bouton'/>";
    echo "</form>";
?>

</body>
</html>