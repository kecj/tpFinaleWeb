<?php
require "bd.php";
//session_start();
$connexion = false;
$pseudo = "";
$mdp = "";
$erreur = "";
$num=5;
$_SESSION["connexion"]=false;

// si on est arrivé ici suite à une requête POST (par le formulaire)
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // on conserve le pseudonyme pour le réafficher au besoin
  $pseudo = $_POST['pseudo'];
  $mdp = $_POST['mdp'];
  $_SESSION['pseudo']=$pseudo;
  $_SESSION['mdp']=$mdp;
  echo $connexion;
  echo "test";
        echo  $_SESSION["connexion"];
  if(isset($mdp) and isset($pseudo)){
    echo $connexion;
echo "test";
      echo  $_SESSION["connexion"];
  // si les données de connexion sont valides
    $num= rechercheUserAndPassw($pseudo, $mdp);
    $compteActivé = rechercheSiActif($pseudo);
    if($num==1 && $compteActivé ==1)
    {
      $_SESSION['pseudo']=$pseudo;
      $_SESSION["connexion"]=true;
    
      header('Location: index.php');
   
    }
    else if(isset($num))
  {
    $num=3;
  }
  

    } else {
    $erreur = "Données de connexion invalides";
  }
}
// si on est arrivé ici suite à une requête GET (autrement que par le formulaire)
else {

  // si l'usager est déjà identifié
  if (!empty($_SESSION['pseudo'])) {
    $pseudo = $_SESSION['pseudo'];
  }
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon site</title>
  <link rel="stylesheet" href="tpfinale.css">
</head>
<body>
  <h1>Page de connexion</h1>

  <fieldset>
    <legend>Veuillez vous identifier</legend>
      <form action="login.php" method="post">
        <table>
          <tr>
            <td>Pseudonyme</td>
            <td><input require type="text" name="pseudo" value="<?= $pseudo ?>"></td>
          </tr>
          <tr>
            <td>Mot de passe</td>
            <td><input require type="password" name="mdp"></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center"><input type="submit" value="Valider"></td>
          </tr>
        </table>
      </form>
      <?php 
        
      if($num==3)
    {
      ?> <p style="color: red;">Erreur de connexion</p><?php 
    
    }?>
  </fieldset> <a href="inscrip.php" >  Pour vous inscrire!</a>
  <?php include "basdepage.php";
 ?>

  
</body>
</html>
