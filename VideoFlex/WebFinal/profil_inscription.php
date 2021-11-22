<?php                          // ---- Fichier permettant à l'inscription de rentrer le nom des profils ***faire en sorte qu'on puisse modifier les pseudos des profils grâce a cette page***
session_start();
include("verif_user.php");
if(empty($_SESSION['abo'])){ //Dans le cas ou on a pas d'abonnement
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
</style>
</head>

<body>
<h1>Profil</h1>

<?php
echo "<form method='POST' action=''>";
if($_SESSION['abo'] == "normaux") {  //Un peu récurrent, on pourrait faire directement une boucle for en fonction de la réponse
    echo "<p>Choisissez un pseudo pour votre profil : </p>";
    echo "<input type='text' name='profil' placeholder='User 1' maxlength='10'/>";
    echo "<br><br>";
    echo "<input type='submit' name='submit' value='Continuer' class = 'bouton' />";
}
if($_SESSION['abo'] == "premium") {
    echo "<p>Choisissez un pseudo pour vos profils : </p>";
    echo "<input type='text' name='profil1' placeholder='User 1' maxlength='10'/>";
    echo "<br><br>";
    echo "<input type='text' name='profil2' placeholder='User 2' maxlength='10'/>";
    echo "<br><br>";
    echo "<input type='text' name='profil3' placeholder='User 3' maxlength='10'/>";
    echo "<br><br>";
    echo "<input type='text' name='profil4' placeholder='User 4' maxlength='10'/>";
    echo "<br><br>";
    echo "<input type='submit' name='submit' value='Continuer' class = 'bouton' />";
}
echo "</form>";

if(isset($_POST['submit'])){
    include("connexion.inc.php");
    $resultat = $cnx->prepare("INSERT INTO profil values(DEFAULT, ?, ?)"); //Préparation requete pour insèrer le pseudo et le num_cli correspondant
            
    if($_SESSION['abo'] == 'premium'){ //Cas utilisateur premium
        for($i=1; $i<=4; $i++){
            $profil = "profil".$i;
            if(empty($_POST["profil".$i])){
                $pseudo = "User ".$i;    //Si l'utilisateur n'a pas saisie de pseudo, on lui attribue automatiquement "user" suivi du numéro du profil
            }
            else{
                $pseudo = $_POST[$profil];
            }
            $resultat->execute(array($pseudo,$_SESSION['login'])); //On insère le pseudo et le num_cli correspondant
        }
    }
    if($_SESSION['abo'] == "normaux"){
        if(empty($_POST['profil'])){
            $pseudo = "User 1";
        }
        else{
            $pseudo = $_POST['profil'];
        }
        $resultat->execute(array($pseudo,$_SESSION['login']));
    }
    $_SESSION['profil'] = $pseudo;
    $resultat = $cnx->query("SELECT id_profil FROM profil WHERE pseudo = '".$pseudo."'");
    $donne = $resultat->fetch();
    $_SESSION['id_profil'] = $donne['id_profil'];
    header('location:accueilco.php');
}

?>
</body>
</html>