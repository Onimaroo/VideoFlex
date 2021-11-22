<?php
session_start();
include("verif_user.php");
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
</style>

</head>

<body>
<h1>Choisissez le profil</h1>

<?php
//echo $_SESSION['abo'];
include("connexion.inc.php");
if($_SESSION['abo'] == "normaux"){  //Un peu récurrent, on pourrait faire directement une boucle for ou une fonction en fonction de la réponse
    $resultat = $cnx->query("SELECT * FROM profil WHERE num_cli='".$_SESSION['login']."'"); //Le profil étant normal, aucun choix de profil n'est disponible
    $donne = $resultat->fetch();
    $_SESSION['profil'] = $donne['pseudo'];
    $_SESSION['id_profil'] = $donne['id_profil'];
    header('location:accueilco.php');
}
if($_SESSION['abo'] == "premium"){ //S'il s'agit d'un abonnement premium on crée les 4 choix possibles de profils
    echo "<form method='POST' action=''>";
    $resultat = $cnx->query("SELECT * FROM profil WHERE num_cli='".$_SESSION['login']."'");
    $donne = $resultat->fetchall();
    foreach($donne as $val){
        echo $val['pseudo'];
        echo "<input type='radio' name='profil' value='".$val['pseudo']."' />";
    }
    echo "<input type='submit' name='sub' value='Continuer' class = 'bouton'/>";
    echo "</form>";
    if(isset($_POST['sub'])){
        $_SESSION['profil'] = $_POST['profil'];
        $resultat2 = $cnx->query("SELECT * FROM profil WHERE pseudo='".$_SESSION['profil']."'");
        $donne2 = $resultat2->fetchAll();
        $_SESSION['id_profil'] = $donne2[0]['id_profil'];
        echo $_SESSION['id_profil'];
        header('location:accueilco.php');
    }
}
?>
</body>
</html>