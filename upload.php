<?php
require "bd.php";
$id = getID($_SESSION['pseudo']);
$titre = '';
$description = '';
$date = date('Y-m-d');
?>
<html>
<head>
<title>Upload</title>
</head>
<body>
<!-- Test d'image -->
<form action="upload.php" enctype="multipart/form-data" method="post">
Choisisser votre image :
<input type="file" name="file"><br/>
<br>
<?php
    echo"Titre: <input type='text' minlength='5' name='titre'><br/>";
    echo"<br>";
    echo"Description: <input type='description' minlength='5' name='description'><br/>";
    echo"<br>";
    echo"<input type='submit' value='Upload' name='SubmitImage'> <br/>";
?>

</form>
<?php
if(isset($_POST['SubmitImage']) and isset($_POST['titre']))
{ 
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $filepath = "images/" . $_FILES["file"]["name"];
    $filepath = str_replace(' ', '-', $filepath);
    insertImage($id, $titre, $description, $filepath, $date);
if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) 
{
echo "<img src=".$filepath." height=300 width=300 />";
} 
else 
{
echo "Erreur";
}
} 
?>

</body>
</html>