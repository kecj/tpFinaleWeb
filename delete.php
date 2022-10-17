<?php
require "bd.php";
$id = $_POST["id"];
$path = $_POST["path"];
$idImage = $_POST['idImage']; 
deleteImg($id, $path, $idImage);
header('Location: index.php');
?>