<?php
require "bd.php";
$prenom = '';
$name = '';
$mdp = '';
$mdpConfirm = '';
$courriel ='';
$paramValide = true;
$pseudonyme ='';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $prenom = $_POST['prenom'];
  $name = $_POST['nom'];
  $mdp = $_POST['mdp'];
  $mdpConfirm = $_POST['mdpConfirm'];
  $courriel = $_POST['courriel'];
  $pseudonyme = $_POST['pseudonyme'];

  foreach($_POST as $value)
  {
    if(empty($value))
      $paramValide = false;
  }
  if($paramValide == true)
  {
    if($mdp == $mdpConfirm)
    {
      modifierParamUser($prenom, $name, $mdp, $courriel, $pseudonyme);
    }
  }
}
?>
<html>
<head>
<title>Profile</title>
</head>
<body>

<h1>Modifier vos donnees personnelles</h1>

<fieldset style='max-width: 25.5rem;'>
  <legend>Modifier un personnage</legend>
  <form action="profil.php" method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    Prenom: <input type="text" name="prenom" value="<?= $_SESSION['prenom'] ?>">
    <br>
    Nom: <input type="text" name="nom" value="<?= $_SESSION['nom'] ?>">
    <br>
    Mot de passe: <input type="password" name="mdp">
    <br>
    Confirmation mdp: <input type="password" name="mdpConfirm">
    <br>
    Courriel: <input type="email" name="courriel" value="<?= $_SESSION['courriel'] ?>">
    <br>
    <input type="hidden" name = "pseudonyme" value="<?= $_SESSION['pseudo'] ?>">
    <br>
    <input style="padding:5px;" class="button" type="submit" value="modifier informations" name="modifier">
 
  </form>
</fieldset>

</body>
</html>
<?php
function modifierParamUser($prenom, $name, $mdp, $courriel, $pseudonyme)
{
  global $pdo;
    try {
        $sql = "UPDATE inscrip SET nom=?, prenom=?, mdp=?, courriel=? WHERE pseudonyme=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $prenom, $mdp, $courriel, $pseudonyme]);
        $_SESSION['prenom'] =$prenom;
        $_SESSION['nom']  = $name;
        $_SESSION['mdp'] =$mdp;
        $_SESSION['courriel'] =$courriel;
      } catch (Exception $e) {
        echo " Houston, we have a problem!";
        exit;
      }

}
?>