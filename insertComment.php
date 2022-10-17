<?php
require "bd.php";
$commentaire = $_POST["commentaire"];
$pseudo = $_POST["pseudo"];
$idImage = $_POST['idImage']; 
$date= date('Y-m-d');
insertComment($commentaire, $idImage, $pseudo, $date);
header('Location: index.php');
?>