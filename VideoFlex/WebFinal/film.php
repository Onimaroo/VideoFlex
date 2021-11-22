<?php
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

<h1>Catégorie Films</h1>
<h2><em> Selectionnez le film que vous voulez regarder</em></h2>
<?php
include("connexion.inc.php");
echo "<form method='POST' action=''>";
$resultat = $cnx->query("select * from video where num_ep is NULL");
$donne = $resultat->fetchAll();
foreach($donne as $val){
    echo $val['titre']."<input type ='radio' name='choix_film' value='".$val['id_vid']."' />";
    echo "<br><br>";
}
echo"<input type='submit' name='vo' value='Voir' class = 'bouton' />";

if(isset($_POST['vo'])){
    if(!empty($_POST['choix_film'])){
    $_SESSION['film'] = $_POST['choix_film'];
    echo "aaaaaa";
    header('location:film_view.php');
    }
    else{
        echo "Vous n'avez pas choisis de film";
    }
}
echo "</form>";
?>

</body>
<?php
    include("piedpage.php");
?>
</html>