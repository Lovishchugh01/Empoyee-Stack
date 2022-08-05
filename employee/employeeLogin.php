
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Stack</title>
    <link rel="stylesheet" href="../css/index.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>

    </style>
</head>

<body class="bgimg">
 <?php 

$email_err = $pass_err = $login_Err = "";
$email = $pass = "";

if( $_SERVER["REQUEST_METHOD"] == "POST" ){
   
  if( empty($_REQUEST["email"]) ){
   $email_err = " <p style='color:red'> * Email Can Not Be Empty</p> ";
  }else {
   $email = $_REQUEST["email"];
  }

  if ( empty($_REQUEST["password"]) ){
   $pass_err =  " <p style='color:red'> * Password Can Not Be Empty</p> ";
  }else {
    $pass = $_REQUEST["password"];
  }

  if( !empty($email) && !empty($pass) ){

    // database connection
    require_once "../connection.php";

    $sql_query = "SELECT * FROM employee WHERE email='$email' && password = '$pass'  ";
    $result = mysqli_query($conn , $sql_query);

    if ( mysqli_num_rows($result) > 0 ){
     while( $rows = mysqli_fetch_assoc($result) ){
      session_start();
      session_unset();
      $_SESSION["email_emp"] = $rows["email"];
      header("Location: employeedashboard.php?login-sucess");
     }
    }else{
      $login_Err = "<div class='alert alert-warning alert-dismissible fade show'>
      <strong>Invalid Email/Password</strong>
      <button type='button' class='close' data-dismiss='alert' >
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }

  }

}

?>
    <div class="container text-dark py-5 my-5">
        <div class="p-5 m-5 main">
            <h1 class="text-center">Employee Stack</h1>
            <h4 class="py-2 text-center"> Login As Employee </h4>
            <div class="text-center my-5"> <?php echo $login_Err; ?> </div>
            <form method="POST" action=" <?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <div class="form-group row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                        <img src="../images/drawing.png" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <p></p>
                        <input type="email" class="form-control" value = "<?php echo $email; ?>"  name="email" placeholder="Your Email">      
                        <?php echo $email_err; ?>
                        <p></p>
                        <input type="password" class="form-control" name="password" placeholder="Enter Password">
                        <?php echo $pass_err; ?>
                        <p></p>
                        <button type="submit" class="btn px-5">Login</button>
                        <p class="mt-4">Not an Employee <a href="../admin/adminLogin.php" style="background-color: white;">Login</a> As Admin.</p>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <hr>
    <footer class="container text-center">
        <p>Designed and developed by <a href="">Techster</a></p>
    </footer>


    <!-- Bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>