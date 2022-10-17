<?php
require "bd.php";
$pseudoUnique = 0;
$nomAdd = '';
$prenomAdd = '';
$pseudonymeAdd = '';
$mdpAdd = '';
$mdpVerif = '';
$courrielAdd = '';
$num = 5;
$champsNonVide = true; //gère s'il y a des champs vides
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  global $pdo;

  if (isset($_POST['nom'])) {
    $nomAdd = $_POST['nom'];
  }
  if ($nomAdd == NULL) { //les données sont passe le test de isset si elles sont null... donc...
    $champsNonVide = FALSE;
  }

  if (isset($_POST['prenom'])) {
    $prenomAdd = $_POST['prenom'];
  }
  if ($prenomAdd == NULL) {
    $champsNonVide = FALSE;
  }
  if (isset($_POST['pseudonyme'])) {
    $pseudonymeAdd = $_POST['pseudonyme'];
    $pseudoUnique = verifPseudoUnique($pseudonymeAdd);
  }
  if ($pseudonymeAdd == NULL) {
    $champsNonVide = FALSE;
  }

  if (isset($_POST['mdp'])) {
    $mdpAdd = $_POST['mdp'];
  }
  if (isset($_POST['mdpverif'])) {
    $mdpVerif = $_POST['mdpverif'];
  }

  if ($mdpAdd == NULL) {
    $champsNonVide = FALSE;
  }
  if (isset($_POST['courriel'])) {
    $courrielAdd = $_POST['courriel'];
  }
  if ($courrielAdd == NULL) {
    $champsNonVide = FALSE;
  }
  if ($pseudoUnique == 0 and $champsNonVide) //zero étant le count de la requête, création s'il n'y a qu'un seul 0
  {
    if (strpos($courrielAdd, '@') !== false)
      envoyerCourriel($nomAdd, $prenomAdd, $pseudonymeAdd, $mdpAdd, $courrielAdd);
  } else {
    $num = 3;
  }
  //PTETE UN ELSE QUI FAIT LE MESSAGE D'ERREUR
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
  <h1>Inscription!</h1>
  <fieldset>
    <legend>Inscription</legend>
    <form action="inscrip.php" method="post">
      <table>
        <tr>
          <td>Nom</td>
          <td><input type="text" name="nom"></td>
        </tr>
        <tr>
          <td>Prenom</td>
          <td><input type="text" name="prenom"></td>
        </tr>
        <tr>
          <td>Mot de passe</td>
          <td><input id="mdp" type="password" name="mdp"></td>
    

         <td> <input type="checkbox" onclick="MotDePasse()">Montrer mot de passe</td>
          <script>
            function MotDePasse() {//fonction java pour montrer le mot de passe
              var text = document.getElementById("mdp");
              if (text.type === "password") 
              {
               
                text.type = "text";

              } 
              else 
              {
                text.type = "password";
              }
            }
          </script>
           <?php

if($mdpVerif !=$mdpAdd)
{


    ?> <p style="color: red;">Mot de passe ne correspondent pas</p><?php

                                                        } ?>
        </tr> 

        <tr>     <td>Confirmer mot de passe</td>    <td><input id="mdpverif" type="password" name="mdpverif"></td>
        </tr>
        <tr>
          <td>Pseudonyme</td>
          <td><input type="text" name="pseudonyme"></td>
        </tr>
        <tr>
          <td>Courriel</td>
          <td><input type="email" name="courriel"></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align:center"><input type="submit" value="Valider"></td>
        </tr>
      </table>
    </form>
    <?php

    if ($num == 3) {
    ?> <p style="color: red;">Erreur de connexion</p><?php

                                                        } ?>
  </fieldset>
  <?php
  if ($pseudoUnique != 0)
    echo "<div style='color:red'>Pseudonyme déjà existant!</div>"
  ?>
  <a href="login.php">Si vous avez deja un compte loggez-vous!</a>
</body>

</html>
<?php
function envoyerCourriel($nomAdd, $prenomAdd, $pseudonymeAdd, $mdpAdd, $courrielAdd)
{

  $sujet = 'Confirmation inscription TPF prog web';
  $message = "Please Click on the link here: \"http://167.114.152.166/~simon/activation.php?pseudo=$pseudonymeAdd\"";
  //'Ceci est un message afin de confirmer votre inscription au site TPF '.$nomAdd.'<a href="http://167.114.152.166/~simon/login.php?name='.$nomAdd.'">Click Me</a>';
  $entetes      = "From: simon.huet.dionne.7@hotmail.com \r\n" .
    "Reply-To:  IDK \r\n" .
    "Return-Path: <simon.huet.dionne.7@hotmail.com>\r\n" .
    "Content-Type: text/plain; charset=utf-8\r\n" .
    "X-Mailer: PHP/'" . phpversion();
  ajouter($nomAdd, $prenomAdd, $pseudonymeAdd, $mdpAdd, $courrielAdd);
  $data = mail($courrielAdd, $sujet, $message, $entetes);
  if (!$data) {
    echo '<h3 style="color:red">Le message na pas été envoyé</h3>';
  } else {
    echo '<h3 style="color:green">Le message a été envoyé avec succès</h3>';
  }
}
?>