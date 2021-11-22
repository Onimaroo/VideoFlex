<?php
session_start();
include("verif_user.php");
include("header_gen.php");
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
input[type=submit] {
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

<?php
    echo "<h1>Bonjour ".$_SESSION['profil']." !</h1>";
?>

<h2>Les nouveautés</h2>
<?php
echo "<form method='POST' action=''>";
$date1 = date("Y-m-d"); //Date du jour
$date = "'".date("Y-m-d",strtotime('-30 days',strtotime($date1)))."'"; //On veut les vidéos sorties il y a moins de 30j
include("connexion.inc.php");
$resultat = $cnx->query("select * from video where num_ep IS NULL AND anne_prod >=".$date."::date"); //On récupère le nom des vidéos les plus récentes //On récupère le nom des vidéos les plus récentes
//$resultat = $cnx->query("select * from video where anne_prod >='2017-05-05'::date;");
$donne = $resultat->fetchall();
foreach($donne as $val){
    echo $val['titre']."<input type ='radio' name='choix_film' value='".$val['id_vid']."' />";
}
echo"<br> <input type='submit' name='conf2' value='Voir'/>";
echo "</form>";
?>
<h2>Recommandés pour vous</h2>

<?php
//On cherche les films qu'il a regardé

echo "<form method='POST' action=''>";
$resultat7 = $cnx->query("select historique.id_vid from historique,video where id_profil='".$_SESSION['id_profil']."' AND video.id_vid = historique.id_vid and num_ep IS NULL"); 
$donne1 = $resultat7->fetchAll();
if(count($donne1)!=0){
        $resultat8 = $cnx->query("select id_label from caracteriser where id_vid='".$donne1[0]['id_vid']."'"); //On selectionne les labels des films qu'il a regardé
        $donne6 = $resultat8->fetch();
        //On selectionne les films qui ont les memes label
        if(isset($donne6[0])) {
        $resultat9 = $cnx->query("select video.id_vid,titre from caracteriser,video where id_label='".$donne6[0]."'AND num_ep IS NULL AND caracteriser.id_vid 
        <>".$donne1[0]['id_vid']." AND caracteriser.id_vid=video.id_vid");
        $donne7 = $resultat9->fetchall();
        $donne71 = array_unique($donne7);
        foreach($donne7 as $val5){
            echo $val5['titre']."<input type ='radio' name='choix_film' value='".$val5['id_vid']."' />";
        }
        echo"<br> <input type='submit' name='conf2' value='Voir'/>";
        echo "</form>";  
        }
}
//On cherche les séries qu'il a regardé
$serie_reco = array();
$resultat4 = $cnx->query("select historique.id_vid from historique,video where id_profil='".$_SESSION['id_profil']."' AND video.id_vid = historique.id_vid and num_ep IS NOT NULL"); 
$donne3 = $resultat4->fetchAll();
if(count($donne3)!=0){
    echo "<form method='POST' action=''>";
    foreach($donne3 as $val3){
        $resultat5 = $cnx->query("select id_label from caracteriser where id_vid='".$val3['id_vid']."'"); //On selectionne les labels des series qu'il a regardé
        $donne4 = $resultat5->fetch();
        //On selectionne les series qui ont les memes label
        if(isset($donne4[0])) {
        $resultat6 = $cnx->query("select serie.id_serie,titre_serie from caracteriser,video,saison,serie where id_label='".$donne4[0]."' 
        AND caracteriser.id_vid <>".$val3['id_vid']." AND caracteriser.id_vid=video.id_vid
        AND video.id_saison=saison.id_saison AND saison.id_serie=serie.id_serie");
        $donne5 = $resultat6->fetchall();
        foreach($donne5 as $val4){
            echo $val4['titre_serie']."<input type ='radio' name='choix_serie' value='".$val4['id_serie']."' />";;
        }
        echo"<input type='submit' name='conf1' value='Voir'/>";
        echo "</form>"; 
        }
    }
}
if(isset($_POST['conf1'])){
    if(!empty($_POST['choix_serie'])){
    $_SESSION['serie'] = $_POST['choix_serie'];
    header('location:serie_view.php');
    }
    
}

if(isset($_POST['conf2'])){
    if(!empty($_POST['choix_film'])){
    $_SESSION['film'] = $_POST['choix_film'];
    header('location:film_view.php');
    }
    
}

?>
</body>
</html>