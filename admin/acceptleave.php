<?php 
    
   echo $id = $_GET["id"];

   require_once "../connection.php";
   $sql = "UPDATE emp_leave SET status = 'Accepted' WHERE id = '$id' ";
   $result = mysqli_query($conn , $sql);
   if($result){
       header("Location: manageleave.php?accept-successfuly");
   }

?>