<?php
//FAIT LA MODIFICATION ET RETOUR VERS L'INDEX
require "fonctions.php";
$id = '';
$nom = '';
$race = '';
$sexe = '';
$age = NULL;
$region = NULL;
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    global $pdo;

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $race = $_POST['race'];
    $sexe = $_POST['sexe'];
    if(is_numeric($_POST['age']));
        $age = $_POST['age'];
    $region = $_POST['region'];
    modifier($id, $nom, $sexe, $race, $age, $region);
}
function modifier($id, $nom, $sexe, $race, $age, $region) {

    global $pdo;
    if($age ==  NULL)
    {
        try {
      $sql = "UPDATE personnage SET nom=?, sexe=?, race=?, age=?, region=? WHERE id=?";
      $stmt= $pdo->prepare($sql);
      $stmt->execute([$nom, $sexe, $race, NULL, $region, $id]);
        } catch (Exception $e) {
      echo "Doh";
          exit;
        }
    }
    else {
        try {
      $sql = "UPDATE personnage SET nom=?, sexe=?, race=?, age=?, region=? WHERE id=?";
      $stmt= $pdo->prepare($sql);
      $stmt->execute([$nom, $sexe, $race, $age, $region, $id]);
        } catch (Exception $e) {
      echo "Doh";
      exit;

        }
    }
    
    header('Location:index.php');
}
?>