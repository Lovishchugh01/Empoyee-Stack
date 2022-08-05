<?php
session_start();
session_unset();
 session_destroy();

unset($_SESSION['email']);
      header("Location: adminLogin.php");
?>