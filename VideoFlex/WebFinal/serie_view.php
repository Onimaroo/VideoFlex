<?php   //Page chargée de présenter la série mais aussi de la noter, de la caractériser et de la regarder
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
input[type=submit] {
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

$resultat = $cnx->query("select * from serie where id_serie='".$_SESSION['serie']."'"); //On veut toutes les informations sur la serie dans la table serie
$donne = $resultat->fetchAll();
echo "<h1>".$donne[0]['titre_serie']."</h1>";
//echo "<img src='serie".$donne[0]['id_serie'].".jpg'>";
$resultat2 = $cnx->query("SELECT * from saison where id_serie='".$_SESSION['serie']."'"); //On récupere l'id des saisons
//$resultat3 = $cnx->query("SELECT max(num_saison) from saison where id_serie='".$_SESSION['serie']."'"); // On recupere le nombbre de saison qu'à la série
$donne2 = $resultat2->fetchAll();
echo "<form method='POST' action=''>";
echo '<select name="choix"';
echo '<option value="" selected="selected">-- service --</option>';
foreach($donne2 as $value){
    echo '<option value="'.$value['id_saison'].'">Saison '.$value['num_saison'].'</option>';
}
echo "</select>";
echo "<input type='submit' name='conf1' value='confirmer'>";
echo "</form>";
if(isset($_POST['conf1'])){

    $saison = $_POST["choix"];
    echo "<form method='POST' action=''>";
    $resultat3 = $cnx->query("SELECT * FROM video where id_saison='".$saison."'"); //On veut maintenant les épisodes
    $donne3 = $resultat3->fetchAll();

    foreach($donne3 as $value2){
        echo "<input type='radio' name='episode' value='".$value2['id_vid']."' />".$value2['titre']."<br />";
    }
    echo "<input type='submit' name='conf2' value='confirmer'>";
    echo "</form>";
}
if(!empty($_POST['episode']) && isset($_POST['conf2'])){ //La ou ça marche pas
    $_SESSION['episode'] = $_POST['episode'];
    $resultat12 = $cnx->query("SELECT * FROM video where id_vid='".$_SESSION['episode']."' ORDER BY titre"); //On récupère toutes les infos sur cet épisode
    $donne8 = $resultat12->fetch();
    $resultat14 = $cnx->query("SELECT avg(note) from noter where id_vid='".$_SESSION['episode']."'");
    $donne10 = $resultat14->fetch();
    echo $donne8['titre']."<br>";
    
    echo "Sortie le ".$donne8['anne_prod']."<br>";
    echo "Dure ".$donne8['duree']."<br>";
    if($donne10['avg']==NULL){
        echo "<p>Cette épisode n'a pas encore de note, n'hésitez pas à le noter</p>";
    }
    else{
        echo "<p>".(int)$donne10['avg']." /10";
    }
    echo $donne8['resume']."<br>";
    echo "<form method='POST' action=''>";
    echo "Que souhaitez vous faire ?"."<br>";
    echo "<input type='submit' name='look' value='Regarder'>";
    echo "<input type='submit' name='labe' value='Labeliser'>";
    echo "<input type='submit' name='note' value='Noter'>";
    echo "</form>";
}
if(isset($_POST['look'])){
    //On cherche si l'utilisateur à déjà regardé cet episode dans l'historique
    $resultat13 = $cnx->query("SELECT * FROM historique where id_profil='".$_SESSION['id_profil']."' AND id_vid='".$_SESSION['episode']."'");
    $donne9 = $resultat13->fetch();
    $resultat4 = $cnx->query("SELECT * FROM video where id_vid='".$_SESSION['episode']."'"); //On veut maintenant la durée de l'épisode
    $donne4 = $resultat4->fetchAll();
    $_SESSION['duree'] = $donne4[0]['duree'];
    if($donne9['id_hist']==NULL){
    echo "<form method='POST' action=''>";
    echo "Veuillez rentrer la durée de visonnage que vous souhaitez simuler";
    echo "<input type='time', name='temps' min='00:00' max='".$_SESSION['duree']."'>";
    echo "<input type='submit' name='conf3' value='confirmer'>";
    echo "</form>";
    }
    else{
        $_SESSION['duree_reprise'] = $donne9['minuteur'];
        echo"<p>Souhaitez vous reprendre ?</p>";
        echo "<form method='POST' action=''>";
        echo "<input type='submit' name='conf6' value='Oui'>";
        echo "<input type='submit' name='conf6' value='Non'>";
        echo "</form>";
    }
}

if(isset($_POST['conf6'])){
    if($_POST['conf6'] == 'Oui'){
        echo "<form method='POST' action=''>";
        echo "Veuillez rentrer la durée de visonnage que vous souhaitez simuler, vous commencez à ".$_SESSION['duree_reprise']."<br>";
        echo "<input type='time', name='temps' min='".$_SESSION['duree_reprise']."' max='".$_SESSION['duree']."'>";
        echo "<input type='submit' name='conf3' value='confirmer'>";
        echo "</form>";
    }
    else{
        echo "<form method='POST' action=''>";
        echo "Veuillez rentrer la durée de visonnage que vous souhaitez simuler";
        echo "<input type='time', name='temps' min='00:00' max='".$_SESSION['duree']."'>";
        echo "<input type='submit' name='conf3' value='confirmer'>";
        echo "</form>";
    }
    }

if(isset($_POST['conf3'])){
    $resultat5 = $cnx->prepare("INSERT INTO historique VALUES(DEFAULT,?,?,?)");
    $resultat5->execute(array($_POST['temps'],$_SESSION['id_profil'],$_SESSION['episode']));
    echo "Votre simulation a été prise en compte";
    //Rajouter episode suivant comme option
}
if(isset($_POST['labe'])){
    echo "Rentrez le label que vous souhaitez ajouter";
    echo "<form method='POST' action=''>";
    echo "<input type='text' name='txt_lab' placeholder='Label' maxlength='25'/>";
    echo "<input type='submit' name='conf4' value='confirmer'>";
    echo "</form>";
}
if(isset($_POST['conf4'])){
    if(!empty($_POST['txt_lab'])){
        $resultat6 = $cnx->query("SELECT count(nom) FROM label where nom='".$_POST['txt_lab']."'"); //On verifie si le label est deja dans la table pour ne pas le rajouter une nouvelle fois
        $donne5 = $resultat6->fetch(); //Nombre de fois que ce label apparait dans la table
        if($donne5[0] == 0){ //Signifie que ce label n'est pas dans la table label
            $resultat7 = $cnx->prepare("INSERT INTO label VALUES(DEFAULT,?)");
            $resultat7->execute(array($_POST['txt_lab']));
        }
        //Sinon, il est deja dans la table  ***Empecher d'ajouter 2 fois le meme label
        $resultat8 = $cnx->query("SELECT id_label FROM label where nom='".$_POST['txt_lab']."'");
        $donne6 = $resultat8->fetch();
        $resultat9 = $cnx->prepare("INSERT INTO caracteriser VALUES(?,?,?)");
        $resultat9->execute(array($_SESSION['id_profil'],$_SESSION['episode'],$donne6[0]));
    }
    else{
        echo "Vous n'avez rentré aucun label";
        echo "<form method='POST' action=''>";
        echo "<input type='submit' name='retour' value='Réessayer'>";
        echo "</form>";
    }
}

if(isset($_POST['note'])){
    
    $resultat10 = $cnx->query("SELECT count(id_profil) FROM noter where id_vid='".$_SESSION['episode']."' AND id_profil='".$_SESSION['id_profil']."'"); //On veut maintenant la durée de l'épisode
    $donne7 = $resultat10->fetch();
    if($donne7[0] == 0){
        echo "Choisissez une note à attribuer, attention vous ne pouvez noter qu'une seule fois une série";
        echo "<form method='POST' action=''>";
        for($i=0;$i<=10;$i++){
            echo $i."<input type='radio' name='note' value='".$i."'/>";
            echo"<br>";
        }
        echo "<input type='submit' name='conf5' value='confirmer'>";
        echo "</form>";

    }
    else {
        echo "Vous avez dêjà noté cette épisode";
        echo "<form method='POST' action=''>";
        echo "<input type='submit' name='retour' value='Retour'>";
        echo "</form>";
    }
}

if(isset($_POST['conf5']) && !empty($_POST['note'])){
    $resultat11 = $cnx->prepare("INSERT INTO noter VALUES(?,?,?)");
    $donne7 = $resultat11->execute(array($_SESSION['id_profil'],$_SESSION['episode'],$_POST['note']));
    echo "Merci, votre note a bien été prise en compte";

}

if(isset($_POST['retour'])){
    header('location:serie_view.php');
    
}
?>


<?php
//  echo "<input type='range' name='visio' min='1' max='100' value='50'>";
?>
</body>
<?php
    include("piedpage.php");
?>
</html>