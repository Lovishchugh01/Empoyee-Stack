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
    


    // databaseconnection
    require_once "../connection.php";

    $sql_command = "SELECT * FROM admin WHERE email = '$_SESSION[email]' ";
    $result = mysqli_query($conn , $sql_command);

    if( mysqli_num_rows($result) > 0){
       while( $rows = mysqli_fetch_assoc($result) ){
           $name = ucwords($rows["name"]);
           $gender = ucwords($rows["gender"]);
           $dob= $rows["dob"];
            $dp = $rows["dp"];
       }

       if( empty($gender)){
           $gender = "Not Defined";
       }

       if( empty($dob)){
            $dob = "Not Defined";
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

    <div class="container">
        <div class="card m-auto w-50" style="width: 18rem;">
            <img class="card-img-top img-fluid" src="../images/<?php if(!empty($dp)){ echo $dp; }else{ echo "logo.png"; } ?>" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title text-center"><?php echo $name; ?></h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Email:<?php echo $_SESSION["email"] ?></li>
                <li class="list-group-item">Gender:  <?php echo $gender ?></li>

                <li class="list-group-item">Date of Birth: <?php echo $dob ?></li>
            </ul>
            <div class="card-body">
                <a href="editprofile.php" class="card-link">Edit Profile</a>
                <a href="changePassword.php" class="card-link">Change Password</a>
                <a href="changeDP.php" class="card-link">Change Profile Photo</a>
            </div>
        </div>
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