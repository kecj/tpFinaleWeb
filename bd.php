<?php

session_start();

$host = '127.0.0.1'; // 127.0.0.1 si BD et application sur même serveur
$db = 'inscrip'; // nom de la base de données
$user = 'simon-bd';
$pass = 'jeudi-bd';
$charset = 'utf8';
$pdo;
$tableName = 'inscrip';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if(!isset($_SESSION["connexion"]))
{
   
    $connexion='';
    
}
else
{
   $connexion= $_SESSION["connexion"];
}

      
//$connexion = '';

    ?>
     <link rel="stylesheet" href="tpfinale.css"> 


<ul>
  <?php
  if($connexion==1)
  {

echo "<li>Statut:Connecte</li>";
?>
<form action="index.php" method="POST">
<?php
echo '<li><input type="submit"  id="deco" name="deco" value="Déconnexion" ></form></li>';



  }
  else
{
    
  echo "<li>Statut:Visiteur</li>";
   
}   
?>

<li><a href="index.php">Page d'acceuil</a></li>

<!-- mettre temporaire jusqua le click image fonctionne -->
<?php
if(isset($_SESSION["pseudo"]))
{
echo "<li><a href='upload.php'>Upload</a></li>";
echo"<li><a href='profil.php'>Profile</a></li>";
}

else{
echo "<li><a href='login.php'>Login</a></li>";
}
?>
</ul>
<?php






if (isset($_POST['deco']))
{
    
unset($_SESSION);

    if(ini_get("session.use_cookie")){
        $params=session_get_cookie_params();
        setcookie(session_name(),'',time()- 42000, $params["path"],$params["domain"]);
    }
session_destroy();
header('Location: index.php');

}

function ajouter($nomAdd, $prenomAdd, $pseudonymeAdd, $mdpAdd, $courrielAdd)
{
  global $pdo;
  try {
    $sql = "INSERT INTO inscrip (nom, prenom, pseudonyme, mdp, courriel) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["$nomAdd", "$prenomAdd", "$pseudonymeAdd", "$mdpAdd", "$courrielAdd"]);
  } catch (Exception $e) {
    echo "$nomAdd, $prenomAdd, $pseudonymeAdd, $mdpAdd, $courrielAdd";
    echo " Houston, we have a problem!";
    exit;
  }
}
function getID($pseudo){
  global $pdo;
 
  try {
    $sql = "SELECT id from inscrip where pseudonyme = '$pseudo'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(); 
       $resultat = $stmt->fetch(PDO::FETCH_BOTH);
      return $resultat[0];
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}
function getFilePathsArrayById($id)
{
  global $pdo;
 
  try {
    $sql = "SELECT fichier from images where id = $id";
    $stmt = $pdo->query($sql); 
      return $stmt; //foreach elem in $resultat
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}

function getAllImagesAsc()
{
  global $pdo;
 
  try {
    $sql = "SELECT idImage, idpseudo, fichier, descriptions, titreimage, datemis, inscrip.pseudonyme FROM images left outer join inscrip on inscrip.id = idpseudo order by datemis ASC";
    $stmt = $pdo->query($sql); 
      return $stmt; //foreach elem in $resultat
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}
function getAllImages()
{
  global $pdo;
 
  try {
    $sql = "SELECT idImage, idpseudo, fichier, descriptions, titreimage, datemis, inscrip.pseudonyme FROM images left outer join inscrip on inscrip.id = idpseudo";
    $stmt = $pdo->query($sql); 
      return $stmt; //foreach elem in $resultat
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}
function getImages($id)
{
  global $pdo;
 
  try {
    $sql = "SELECT idImage, idpseudo, fichier, descriptions, titreimage, datemis, inscrip.pseudonyme FROM images left outer join inscrip on inscrip.id = idpseudo where images.idImage=$id";
    $stmt = $pdo->query($sql); 
    $stmt->execute(); 
      return $stmt; //foreach elem in $resultat
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}
function getAllImagesDesc()
{
  global $pdo;
 
  try {
    $sql = "SELECT idImage, idpseudo, fichier, descriptions, titreimage, datemis, inscrip.pseudonyme FROM images left outer join inscrip on inscrip.id = idpseudo order by datemis DESC";
    $stmt = $pdo->query($sql); 
      return $stmt; //foreach elem in $resultat
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}

function insertImage($id, $titre, $description, $filepath, $date){
  global $pdo;

  try{
    $sql = "INSERT INTO images (idpseudo, fichier, descriptions, titreimage, datemis) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["$id", "$filepath", "$description", "$titre", "$date"]);
  }catch (Exception $e) {
    echo "$id", "$filepath", "$description", "$titre", "$date";
    echo " Houston, we have a problem!";
    exit;
  }
}

function verifPseudoUnique($pseudonymeAdd){
    global $pdo;
     
    try {
      $sql = "SELECT COUNT(*) from inscrip where pseudonyme = '$pseudonymeAdd'";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(); 
          $resultat = $stmt->fetch(PDO::FETCH_NUM);
        return $resultat[0];
    } catch (Exception $e) {
    
      echo $e;
      exit;
    }
  }
  function deleteImg($id, $path, $idImage){
    global $pdo;
  //3 param, trouver le id unique afin de ne pas avoir de bug si 2 images avec la même path et poster par le même user;
    try {
        $sql = "Delete from images where idpseudo = $id and fichier = '$path' and idImage = $idImage";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $filePointer = $path;
        unlink($filePointer);
        //header("Location: index.php");
      } catch (Exception $e) {
        echo " Houston, we have a problem!";
        exit;
      }
  }
  function VérifierProprioImage($id, $path, $idImage){
    global $pdo;
     
    try {                                                     //50                                             2                   
      $sql = "SELECT COUNT(*) from images where idPseudo = ? and fichier = ? and idImage = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$id, $path, $idImage]); 
          $resultat = $stmt->fetch(PDO::FETCH_NUM);
        return $resultat[0];
    } catch (Exception $e) {

      echo $e;
      exit;
    }
  }

function rechercheUserAndPassw($pseudo, $mdp){
  global $pdo;
 
  try {
    $sql = "SELECT COUNT(*) from inscrip where mdp = '$mdp' and pseudonyme = '$pseudo'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(); 
       $resultat = $stmt->fetch(PDO::FETCH_NUM);
      return $resultat[0];
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}
function rechercheSiActif($pseudo){
  global $pdo;
 
  try {
    $sql = "SELECT COUNT(*) from inscrip where pseudonyme = '$pseudo' and actif = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(); 
       $resultat = $stmt->fetch(PDO::FETCH_NUM);
      return $resultat[0];
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}

function activerCompte($pseudo, $un){
    global $pdo;
    try {
        $sql = "UPDATE inscrip SET actif=? WHERE pseudonyme=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$un, $pseudo]);
      } catch (Exception $e) {
        echo "$pseudo";
        echo " Houston, we have a problem!";
        exit;
      }
}
function ChoseOrder($ordre = 0){
  $toReturn = '';
if($ordre == 0)
  $toReturn = getAllImages();
if($ordre == 1)
  $toReturn = getAllImagesAsc();
if($ordre == 2)
  $toReturn = getAllImagesDesc();

return $toReturn;
}
function nombreCommentaires($idImage)
{
  
  global $pdo;
  try {
    $sql = "SELECT COUNT(idComment) from Commentaire where idImage=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idImage]);
    $resultat = $stmt->fetch(PDO::FETCH_NUM);
    return $resultat[0];
  } catch (Exception $e) {
  
    echo " Houston, we have a problem!";
    exit;
  }
}
function GetinfodesCommentaire($idImage)
{
  
  global $pdo;
  try {
    $sql = "SELECT * from Commentaire where idImage=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idImage]);
    $resultat = $stmt->fetch(PDO::FETCH_NUM);
    return $resultat[0];
  } catch (Exception $e) {
  
    echo " Houston, we have a problem!";
    exit;
  }
}
function insertComment($commentaire, $idImage, $pseudonyme, $datePublier)
{
  global $pdo;
  try {
    $sql = "INSERT INTO Commentaire (commentaire, idImage, pseudonyme, datePublier) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["$commentaire", "$idImage", "$pseudonyme", "$datePublier"]);
  } catch (Exception $e) {
    echo " Houston, we have a problem!";
    exit;
  }
}
function getComments($idImage)//donne les commentaires selon l'image ainsi que le pseudo, si pseudo identique, btn delete
{
  global $pdo;
 
  try {
    $sql = "SELECT * FROM Commentaire where idImage = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idImage]); 
      return $stmt; //foreach elem in $resultat
  } catch (Exception $e) {

    echo $e;
    exit;
  }
}
function deleteCommentaires($id){
  global $pdo;
//3 param, trouver le id unique afin de ne pas avoir de bug si 2 images avec la même path et poster par le même user;
  try {

      $sql = "delete from Commentaire where idComment=?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$id]);
      
  
      //header("Location: index.php");
    } catch (Exception $e) {
      echo " Houston, we have a problem!";
      exit;
    }
}
function VérifierProprioCommentaire($id, $idcomment){
  global $pdo;
   
  try {                                                                                                               
    $sql = "SELECT COUNT(*) from Commentaire c join inscrip i on c.pseudonyme=i.pseudonyme where c.idComment= ? and i.id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idcomment, $id]); 
        $resultat = $stmt->fetch(PDO::FETCH_NUM);
      return $resultat[0];
  } catch (Exception $e) {
  
    echo $e;
    exit;
  }
}