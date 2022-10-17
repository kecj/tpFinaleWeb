<?php
require "bd.php";
$pseudo ='';

    global $pdo;
    $un = 1;
    $pseudo = $_GET['pseudo'];
    activerCompte($pseudo, $un);
  header('Location: login.php');
?>