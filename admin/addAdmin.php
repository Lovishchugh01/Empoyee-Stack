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

$nameErr = $emailErr = $passErr =  "";
$name = $email = $dob = $gender = $pass = "";

if( $_SERVER["REQUEST_METHOD"] == "POST" ){

    if( empty($_REQUEST["gender"]) ){
        $gender ="";
    }else {
        $gender = $_REQUEST["gender"];
    }


    if( empty($_REQUEST["dob"]) ){
        $dob = "";
    }else {
        $dob = $_REQUEST["dob"];
    }

    if( empty($_REQUEST["name"]) ){
        $nameErr = "<p style='color:red'> * Name is required</p>";
    }else {
        $name = $_REQUEST["name"];
    }

    if( empty($_REQUEST["email"]) ){
        $emailErr = "<p style='color:red'> * Email is required</p> ";
    }else{
        $email = $_REQUEST["email"];
    }

    if( empty($_REQUEST["pass"]) ){
        $passErr = "<p style='color:red'> * Password is required</p> ";
    }else{
        $pass = $_REQUEST["pass"];
    }


    if( !empty($name) && !empty($email) && !empty($pass) ){

        // database connection
        require_once "../connection.php";

        $sql_select_query = "SELECT email FROM admin WHERE email = '$email' ";
        $r = mysqli_query($conn , $sql_select_query);

        if( mysqli_num_rows($r) > 0 ){
            $emailErr = "<p style='color:red'> * Email Already Register</p>";
        } else{

            $sql = "INSERT INTO admin( name , email , password , dob, gender ) VALUES( '$name' , '$email' , '$pass' , '$dob' , '$gender' )  ";
            $result = mysqli_query($conn , $sql);
            if($result){
                $name = $email = $dob = $gender = $pass = "";
                echo "<script>
                $(document).ready( function(){
                    $('#showModal').modal('show');
                    $('#modalHead').hide();
                    $('#linkBtn').attr('href', 'manage-admin.php');
                    $('#linkBtn').text('View Admins');
                    $('#addMsg').text('Admin Added Successfully!');
                    $('#closeBtn').text('Add More?');
                })
             </script>
             ";
        }

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
            <div class="container p-5 w-50 text-white" style="background-color: #143532;">
                <h2 class="text-white text-center">Add Admin</h2>
                <form method="POST" action=" <?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" value="<?php echo $name; ?>"  name="name" >
                                   <?php echo $nameErr; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" value="<?php echo $email; ?>"  name="email" >     
                                    <?php echo $emailErr; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" value="<?php echo $pass; ?>" name="pass" > 
                                    <?php echo $passErr; ?>  
                    </div><div class="form-group">
                        <label for="password">Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary">
                    </div>
                    <div class="form-group">
                        <label for="dob" class="text-white">Date of Birth:</label>
                        <input type="date" class="form-control" value="<?php echo $dob; ?>" name="dob" >  
                    </div>

                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="">
                            Gender:
                        </label>
                    </div>

                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" <?php if($gender == "Male" ){ echo "checked"; } ?>  value="Male"  selected>
                        <label class="form-check-label" for="male">
                            Male
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" <?php if($gender == "Female" ){ echo "checked"; } ?>  value="Female">
                        <label class="form-check-label" for="female">
                            Female
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" <?php if($gender == "Other" ){ echo "checked"; } ?>  value="Other">
                        <label class="form-check-label" for="other">
                            Other
                        </label>
                    </div>
                    <p></p>
                    <button type="submit" class="btn w-100 form-inline">Add</button>
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