<?php
session_start();
include("header_gen.php");
include("verif_user.php");
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

<?php
    include("connexion.inc.php");
    $resultat = $cnx->query("SELECT * FROM client WHERE num_cli='".$_SESSION['login']."'"); //Le profil étant normal, aucun choix de profil n'est disponible
    $donne = $resultat->fetch();
    $_SESSION['nom'] = $donne['nom'];
    $_SESSION['prenom'] = $donne['prenom'];
    $_SESSION['adresse'] = $donne['adresse'];
    echo "<h3>Pseudo: ".$_SESSION['profil']."</h3>";
    echo "<h3>Nom: ".$_SESSION['nom']."</h3>";
    echo "<h3>Prénom: ".$_SESSION['prenom']."</h3>";
    echo "<h3>Adresse: ".$_SESSION['adresse']."</h3>";
    echo "<h3>Adresse mail: ".$_SESSION['mail']."</h3>";
    echo "<h3>Type et date de début/fin d'abonnement: ".$_SESSION['abo']." ".$_SESSION['debut']." ".$_SESSION['fin']."</h3>";
    if ($_SESSION['abo'] == 'premium') {
        echo "<h2> Liste des profils: <h2>";
        $recherche = $cnx->query("SELECT * FROM profil WHERE num_cli='".$_SESSION['login']."'");
        $donnees = $recherche -> fetchAll();
        foreach($donnees as $val){
            echo $val['pseudo'];
            echo "   ";
        }
    }
?>
<?php
    if(isset($_POST['submit']))
        header("location:modification.php");
    if(isset($_POST['ajout']))
        header("location:ajout_profil.php");
    if(isset($_POST['suppression']))
        header("location:suppr_profil.php");
?>
    
<form method="POST">
     <input type="submit" name="submit" value="Modifier" class="bouton"/>
     <br>
</form>

<?php
    if ($_SESSION['abo'] == 'premium') {
        $recherche = $cnx->query("SELECT * FROM profil WHERE num_cli='".$_SESSION['login']."'");
        $taille = count($recherche -> fetchAll());
        echo "<h2> Gestion des profils premium </h2> <br>";
        echo "<form method='POST'>";
        if ($taille < 4)
            echo "<input type='submit' name='ajout' value='Ajouter' class='bouton'/>";
        if ($taille > 1)       
            echo "<input type='submit' name='suppression' value='Supprimer' class='bouton'/>";
        echo "</form>";
    }
?>
</head>

<body>
</body>
<?php
    include("piedpage.php");
?>
</html>