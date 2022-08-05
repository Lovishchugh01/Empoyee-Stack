<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['email'] == "")
{
    header("Location: adminLogin.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Stack</title>
    <link rel="stylesheet" href="../css/index.css">
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- ===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="">
<?php 
      $old_passErr = $new_passErr = $confirm_passErr = "";
     $old_pass = $new_pass = $confirm_pass = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty($_REQUEST["old_pass"])){
            $old_passErr = " <p style='color:red'>* Old Password Is required </p>";
        }else{
            $old_pass = trim($_REQUEST["old_pass"]);
        }
        
        if(empty($_REQUEST["new_pass"])){
            $new_passErr = " <p style='color:red'>* New Password Is required </p>";
        }else{
            $new_pass = trim($_REQUEST["new_pass"]);
        }

        if(empty($_REQUEST["confirm_pass"])){
            $confirm_passErr = " <p style='color:red'>* Please Confirm new Password! </p>";
        }else{
            $confirm_pass = trim($_REQUEST["confirm_pass"]);
        }

        if(!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass) ){

            require_once "../connection.php";

            $check_old_pass = "SELECT password FROM admin WHERE email = '$_SESSION[email]' && password = '$old_pass' ";
            $result = mysqli_query($conn , $check_old_pass);
            if( mysqli_num_rows($result) > 0 ){
               
                if( $new_pass === $confirm_pass ){
                  
                    $change_pass_query = "UPDATE admin SET password = '$new_pass' WHERE email = '$_SESSION[email]' ";
                    if (mysqli_query($conn , $change_pass_query) ){
                        session_unset();
                        session_destroy();
                        echo "<script>
                        $(document).ready(function() {
                            $('#addMsg').text( 'Password Updated successfully! Log in With New Password');
                            $('#linkBtn').attr('href','login.php');
                            $('#linkBtn').text('OK, Understood');
                            $('#modalHead').hide();
                            $('#closeBtn').hide();
                            $('#showModal').modal('show');
                        });
                        </script>";
                    }
                    
                }else{
                    $confirm_passErr = "<p style='color:red'>* Confirm did not matched new Password! </p>";
                }

            }else{
               $old_passErr = " <p style='color:red'>*Sorry! Old Password is Wrong </p> ";
            }
        }
    }
?>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <div class="logo_name text-center">
                    <img src="../images/new_logo.png" alt="" class="img-fluid w-50">
                </div>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                <a href="admindashboard.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="addEmployee.php">
                    <i class='bx bx-plus-circle'></i>
                    <span class="links_name">Add Employee</span>
                </a>
                <span class="tooltip">Add Employee</span>
            </li>
            <li>
                <a href="manageEmployee.php">
                    <i class='bx bx-male-female'></i>
                    <span class="links_name">Manage Employee</span>
                </a>
                <span class="tooltip">Manage Employee</span>
            </li>
            <li>
                <a href="addAdmin.php">
                    <i class='bx bx-plus-circle'></i>
                    <span class="links_name">Add Admin</span>
                </a>
                <span class="tooltip">Add Admin</span>
            </li>
            <li>
                <a href="manageAdmin.php">
                    <i class='bx bx-face'></i>
                    <span class="links_name">Manage Admin</span>
                </a>
                <span class="tooltip">Manage Admin</span>
            </li>
            <li>
                <a href="manageLeave.php">
                    <i class='bx bx-align-left'></i>
                    <span class="links_name">Manage Leave</span>
                </a>
                <span class="tooltip">Manage leave</span>
            </li>
            <li>
                <a href="adminprofile.php">
                    <i class='bx bx-user'></i>
                    <span class="links_name">Profile</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>

            <li>
                <a href="logout.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>
    </div>
    <h1 class="text-center p-3">Employee Stack</h1>
    <div class="container pb-5 w-50 text-white" style="background-color: #143532;">
        <h2 class="text-white text-center py-3">Change Password</h2>
        <form method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <div class="form-group">
                <label for="exampleInputPassword1">Old Password:</label>
                <input type="password" name="old_pass" class="form-control">
                                            <?php echo $old_passErr; ?>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">New Password:</label>
                <input type="password" name="new_pass" class="form-control">
                                            <?php echo $new_passErr; ?>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password:</label>
                <input type="password" name="confirm_pass" class="form-control">
                                            <?php echo $confirm_passErr; ?>
            </div>
            <button type="submit" class="btn w-25 form-inline">Submit</button>
            <button type="submit" class="btn w-25">Close</button>

        </form>
    </div>
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
    <script src="../js/index.js"></script>
</body>

</html>