<?php
session_start();
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
<h1>Sélectionnez le forfait qui vous convient</h1>
<form method="POST" action="">
<p>
<input type="submit" name="nor" value="Normal"/>
<input type="submit" name="pre" value="Premium"/>
</p>
</form>

<?php

if(isset($_POST['pre']) || isset($_POST['nor'])){
    if(isset($_POST['pre'])){
        $abo = "premium";
    }
    else{
        $abo = "normaux";
    }
    $date_deb = date("Y-m-d"); //Utilisation de la fonction predefinie date pour avoir la date du jour actuel
    $date_fin = date("Y-m-d",strtotime(('+30 days'),strtotime($date_deb))); //Ajout de 30j à la date de base
    echo $date_fin;
    $_SESSION['abo'] = $abo;
    $_SESSION['debut'] = $date_deb;
    $_SESSION['fin'] = $date_fin;
    header('location:payement.php');
}

?>
</body>
<?php
    include("piedpage.php");
?>
</html>