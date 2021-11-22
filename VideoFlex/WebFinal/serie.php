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

<h1>Catégorie série</h1>
<h2><em>Selectionnez la série que vous voulez regarder</em></h2>
<?php
include("connexion.inc.php");
echo "<form method='POST' action=''>";
$resultat = $cnx->query("select * from serie");
$donne = $resultat->fetchAll();
foreach($donne as $val){
    echo $val['titre_serie']."<input type ='radio' name='choix_serie' value='".$val['id_serie']."' />";
    echo "<br>";
}
echo"<input type='submit' name='vo' value='Voir'/>";

if(isset($_POST['vo'])){
    if(!empty($_POST['choix_serie'])){
    $_SESSION['serie'] = $_POST['choix_serie'];
    echo "aaaaaa";
    header('location:serie_view.php');
    }
    else{
        echo "Vous n'avez pas choisis de série";
    }
}
echo "</form>";
?>
</body>
<?php
    include("piedpage.php");
?>
</html>