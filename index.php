<?php
require "bd.php";
/*$path = '/images';
$files = scandir($path);*/
$id ='';
$fonctionDate = 0;
$mdp ='12349823589709327887230';
$pseudo='Visiteur';
if(isset($_SESSION['pseudo']))
{
$id = getID($_SESSION['pseudo']);
}
$imagesPath = ChoseOrder(2);
if(isset($_POST['Asc']))
$imagesPath = ChoseOrder(1);
if(isset($_POST['Desc']))
$imagesPath = ChoseOrder(2);
if(isset($_SESSION['mdp']))
{
  $mdp = $_SESSION['mdp'];
$pseudo = $_SESSION['pseudo'];
$sql = "SELECT * FROM inscrip  WHERE  mdp = '$mdp' and pseudonyme = '$pseudo'";

$stmt = $pdo->query($sql);
foreach ($stmt as $row) {
  $id = $row['id'];
  $_SESSION['nom'] = $row['nom'];
  $_SESSION['prenom'] = $row['prenom'];
  $_SESSION['courriel'] = $row['courriel'];
}
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Mon site!</title>
  <link rel="stylesheet" href="tpfinale.css">

</head>

<body>
  <nav>


  </nav>
  <header>
    <h1>Bienvenue au SITE! <?php
                            if (!empty($_SESSION['pseudo'])) {
                              echo $_SESSION['prenom'] . ' ' . $_SESSION['nom'];
                            }
                            ?> !</h1>
    <h3>toutes les images:</h3>
    <form action="index.php" method="post">
    <input type="submit" name = "Asc" value=Ascendant>
    <input type="submit" name = "Desc" value=Descendant>
    </form>
  </header>
  <a href=""><img src="" alt=""></a>
  <?php
  echo '<div class="gallery">';
  foreach ($imagesPath as $img)
{
$nombre=nombreCommentaires($img['idImage']);
       echo "<article>";
      echo  "<form action='gestimage.php' method='post'>
      <input type='image' name='image' value=".$img['pseudonyme']." alt='un image' src=". $img['fichier']." height=150 width=250  >
      <input type = 'hidden' name ='pseudo' value=".$img['pseudonyme'].">
      <input type = 'hidden' name ='id' value=".$img['idpseudo'].">
      <input type = 'hidden' name ='path' value=".$img['fichier'].">
      <input type = 'hidden' name ='idImage' value=".$img['idImage'].">
      <input type = 'hidden' name ='titre' value=".$img['titreimage'].">
      <input type = 'hidden' name ='descriptions' value=".$img['descriptions'].">
      <input type = 'hidden' name ='date' value=".$img['datemis'].">
      </form>";

      echo  '<h4>Titre : '.$img['titreimage']. PHP_EOL;

      echo '<br> '; 

      echo   '<h4>Description :' . $img['descriptions']. PHP_EOL;
      echo '<br> '; 

      echo '<h4>Date publier : ' . $img['datemis']. PHP_EOL.'</h4>';  

      echo '<h4>Publieur : ' . $img['pseudonyme']. PHP_EOL.'</h4>';

      echo '<h4>Commentaire : ' . $nombre. PHP_EOL.'</h4>';
  echo "</article>";
    
      
    }echo '</div>';
  
  ?>

  <footer>
    <?php include "basdepage.php";
    ?>
  </footer>
  

</body>

</html>