<?php   //Page chargée de présenter le film mais aussi de la noter, de le caractériser et de le regarder
session_start();
include("verif_user.php");
include("header_gen.php");
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
$resultat = $cnx->query("select * from video where id_vid='".$_SESSION['film']."'"); //On veut toutes les informations sur le film dans la table Vidéo
$donne = $resultat->fetchAll();
echo "<h1>".$donne[0]['titre']."</h1>";
$resultat1 = $cnx->query("SELECT avg(note) from noter where id_vid='".$_SESSION['film']."'");
$donne1 = $resultat1->fetch();
echo $donne[0]['titre']."<br>";
echo "Sortie le ".$donne[0]['anne_prod']."<br>";
echo "Dure ".$donne[0]['duree']."<br>";
$_SESSION['duree'] = $donne[0]['duree'];
if($donne1['avg']==NULL){
    echo "<p>Cette épisode n'a pas encore de note, n'hésitez pas à le noter</p>";
}
else{
    echo "<p>".(int)$donne1['avg']." /10";
}
    echo "<form method='POST' action=''>";
    echo "Que souhaitez vous faire ?"."<br>";
    echo "<input type='submit' name='look' value='Regarder' class = 'bouton'>";
    echo "<input type='submit' name='labe' value='Labeliser' class = 'bouton'>";
    echo "<input type='submit' name='note' value='Noter' class = 'bouton'> ";
    echo "</form>";

if(isset($_POST['look'])){
        //On cherche si l'utilisateur à déjà regardé cet episode dans l'historique
        $resultat2 = $cnx->query("SELECT * FROM historique where id_profil='".$_SESSION['id_profil']."' AND id_vid='".$_SESSION['film']."'");
        $donne2 = $resultat2->fetch();
        if($donne2['id_hist']==NULL){
        echo "<form method='POST' action=''>";
        echo "Veuillez rentrer la durée de visonnage que vous souhaitez simuler";
        echo "<input type='time', name='temps' min='00:00' max='".$_SESSION['duree']."'>";
        echo "<input type='submit' name='conf1' value='confirmer' class = 'bouton'>";
        echo "</form>";
        }
        else{
            $_SESSION['duree_reprise'] = $donne2['minuteur'];
            echo"<p>Souhaitez vous reprendre ?</p>";
            echo "<form method='POST' action=''>";
            echo "<input type='submit' name='conf2' value='Oui' class = 'bouton'>";
            echo "<input type='submit' name='conf2' value='Non' class = 'bouton'>";
            echo "</form>";
        }
    }

if(isset($_POST['conf2'])){
    if($_POST['conf2'] == 'Oui'){
            echo "<form method='POST' action=''>";
            echo "Veuillez rentrer la durée de visonnage que vous souhaitez simuler, vous commencez à ".$_SESSION['duree_reprise']."<br>";
            echo "<input type='time', name='temps' min='".$_SESSION['duree_reprise']."' max='".$_SESSION['duree']."'>";
            echo "<input type='submit' name='conf1' value='confirmer' class = 'bouton'>";
            echo "</form>";
        }
    else{
            echo "<form method='POST' action=''>";
            echo "Veuillez rentrer la durée de visonnage que vous souhaitez simuler";
            echo "<input type='time', name='temps' min='00:00' max='".$_SESSION['duree']."'>";
            echo "<input type='submit' name='conf1' value='confirmer' class = 'bouton'>";
            echo "</form>";
        }
        }
    
if(isset($_POST['conf1'])){
    $resultat3 = $cnx->prepare("INSERT INTO historique VALUES(DEFAULT,?,?,?)");
    $resultat3->execute(array($_POST['temps'],$_SESSION['id_profil'],$_SESSION['film']));
    echo "Votre simulation a été prise en compte";
}

if(isset($_POST['labe'])){
    echo "Rentrez le label que vous souhaitez ajouter";
    echo "<form method='POST' action=''>";
    echo "<input type='text' name='txt_lab' placeholder='Label' maxlength='25'/>";
    echo "<input type='submit' name='conf3' value='confirmer' class = 'bouton'>";
    echo "</form>";
}
if(isset($_POST['conf3'])){
    if(!empty($_POST['txt_lab'])){
        $resultat4 = $cnx->query("SELECT count(nom) FROM label where nom='".$_POST['txt_lab']."'"); //On verifie si le label est deja dans la table pour ne pas le rajouter une nouvelle fois
        $donne4 = $resultat4->fetch(); //Nombre de fois que ce label apparait dans la table
        if($donne4[0] == 0){ //Signifie que ce label n'est pas dans la table label
            $resultat5 = $cnx->prepare("INSERT INTO label VALUES(DEFAULT,?)");
            $resultat5->execute(array($_POST['txt_lab']));
        }
        //Sinon, il est deja dans la table  ***Empecher d'ajouter 2 fois le meme label
        $resultat6 = $cnx->query("SELECT id_label FROM label where nom='".$_POST['txt_lab']."'");
        $donne5 = $resultat6->fetch();
        $resultat7 = $cnx->prepare("INSERT INTO caracteriser VALUES(?,?,?)");
        $resultat7->execute(array($_SESSION['id_profil'],$_SESSION['film'],$donne5[0]));
    }
    else{
        echo "Vous n'avez rentré aucun label";
        echo "<form method='POST' action=''>";
        echo "<input type='submit' name='retour' value='Réessayer' class = 'bouton'>";
        echo "</form>";
    }
}

if(isset($_POST['note'])){
    
    $resultat8 = $cnx->query("SELECT count(id_profil) FROM noter where id_vid='".$_SESSION['film']."' AND id_profil='".$_SESSION['id_profil']."'"); //On veut maintenant la durée de l'épisode
    $donne6 = $resultat8->fetch();
    if($donne6[0] == 0){
        echo "Choisissez une note à attribuer, attention vous ne pouvez noter qu'une seule fois un film";
        echo "<form method='POST' action=''>";
        for($i=0;$i<=10;$i++){
            echo $i."<input type='radio' name='note' value='".$i."'/>";
            echo"<br>";
        }
        echo "<input type='submit' name='conf4' value='confirmer' class = 'bouton'>";
        echo "</form>";

    }
    else {
        echo "Vous avez dêjà noté cette épisode";
        echo "<form method='POST' action=''>";
        echo "<input type='submit' name='retour' value='Retour' class = 'bouton'>";
        echo "</form>";
    }
}

if(isset($_POST['conf4']) && !empty($_POST['note'])){
    $resultat8 = $cnx->prepare("INSERT INTO noter VALUES(?,?,?)");
    $donne7 = $resultat8->execute(array($_SESSION['id_profil'],$_SESSION['film'],$_POST['note']));
    echo "Merci, votre note a bien été prise en compte";

}

if(isset($_POST['retour'])){
    header('location:film_view.php');
    
}      
?>
</body>
<?php
    include("piedpage.php");
?>
</html>