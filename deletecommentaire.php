<?php
require "bd.php";
$id = $_POST["id"];

deleteCommentaires($id);
echo $id ;
exit;
header('Location: index.php');
?>