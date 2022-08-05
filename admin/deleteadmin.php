<?php 

require_once "../connection.php";

$id =  $_GET["id"];

$sql = "DELETE FROM admin WHERE id = $id ";

mysqli_query($conn , $sql); 

header("Location: manageAdmin.php?delete-success-where-id=" .$id );


?>