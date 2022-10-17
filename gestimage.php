<?php
require "bd.php";


if ($_SERVER['REQUEST_METHOD'] == "POST" /*and isset*/) {

  // on conserve le pseudonyme pour le réafficher au besoin
  
  if(isset($_SESSION['pseudo']))
  {
    $idActuelConnexion = getID($_SESSION['pseudo']);
  }else
  $idActuelConnexion=null;
  
  $pseudo = $_POST['pseudo'];//==oui
  $id = $_POST['id'];//50
  $path = $_POST['path'];
  $idImage = $_POST['idImage']; //=2
  $descriptions = $_POST['descriptions'];
  $date = $_POST['date'];
  $titre = $_POST['titre'];
}
function supprimer($id) {
 
  $pdo = getPdo();
$sql = "DELETE FROM personnage WHERE id=?";

$stmt= $pdo->prepare($sql);

$stmt->execute([$id]);

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="tpfinale.css">
  <title>Gestion Image</title>
 </head>

<body>
<span><h2>Voici votre image </h2></span>
    
    <?php
    $img=getImages($id);
   
      echo "<img src='$path' max-width:1000px; max-height:750px;>"; 

      echo  "<h4>Titre : $titre ";

      echo '<br> '; 

      echo  '<h4>Description :' . $descriptions. PHP_EOL;
      echo '<br> '; 

      echo "<h4>Date publier : $date";  

      echo "<h4>Publieur : $pseudo";
      
      if($propriétaire = VérifierProprioImage($idActuelConnexion, $path, $idImage) == 1)
      {

        echo"<form action='delete.php' method='post'>";
        echo"<input type ='hidden' name='id' value ='$id'>";
        echo" <input type = 'hidden' name ='path' value='$path'>";
        echo" <input type = 'hidden' name ='idImage' value='$idImage'>";
        echo"<input style='padding:5px; class='button' type='submit' value='supprimer votre image' name='modifier'>";
        
      }
   
    ?>
</form>

<?php
if(isset($idActuelConnexion))
{
echo "<h1>Poster un commentaire: </h1>";
echo"<form action='insertComment.php' method='post'>";
echo"<textarea name='commentaire' id='commentaire' cols='40' rows='5'></textarea>";
echo'<input type="hidden" name="pseudo" value='. $_SESSION['pseudo'].'>';
echo"<input type='hidden' name='idImage' value='$idImage'>";
echo"<input type='submit' />";
}
?>
</form>
<br>
<h1>Commentaires: </h1>
<?php
 $commentaires=getComments($idImage);

 
if(!isset($idActuelConnexion))
{
 
foreach ($commentaires as $commentaire)
{

  echo '<div class="comment">';
  echo'<div> Pseudo : '.$commentaire['pseudonyme'].'</div>';
  echo'<div> Commentaire : ' .$commentaire['commentaire'].'</div>';
  echo'<div> Date : '.$commentaire['datePublier'].'</div>';
  echo '</div>';
}
}
else 
{
  foreach ($commentaires as $commentaire)
{
  if($propriétaireCommentaire= VérifierProprioCommentaire($idActuelConnexion,$commentaire['idComment']) == 1)
      { echo '<div class="comment">';
  echo"<form action='deletecommentaire.php' method='post'>";
  echo"<input type ='hidden' name='id' value =".$commentaire['idComment'].">";
  echo'<div> Pseudo : '.$commentaire['pseudonyme'].'</div>';
  echo'<div> Commentaire : ' .$commentaire['commentaire'].'</div>';
  echo'<div> Date : '.$commentaire['datePublier'].'</div>';
  echo"<input style='padding:5px; class='button' type='submit' value='supprimer votre commentaire' name='modifier'>";
  echo '</div>';
}
else
{
  echo '<div class="comment">';
  echo'<div> Pseudo : '.$commentaire['pseudonyme'].'</div>';
  echo'<div> Commentaire : ' .$commentaire['commentaire'].'</div>';
  echo'<div> Date : '.$commentaire['datePublier'].'</div>';
  echo '</div>';
}
  echo '<br>';
}
}
?>

    <?php include "basdepage.php";
 ?>