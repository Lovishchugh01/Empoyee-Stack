<?php
session_start();
if(!isset($_SESSION['email_emp']) || $_SESSION['email_emp'] == "")
{
    header("Location: employeeLogin.php");
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
    // database connection
        require_once "../connection.php";
        
    $session_email =  $_SESSION["email_emp"];
    $sql = "SELECT * FROM employee WHERE email= '$session_email' ";
    $result = mysqli_query($conn , $sql);

if(mysqli_num_rows($result) > 0 ){
   
    while($rows = mysqli_fetch_assoc($result) ){
        $name = $rows["name"];
        $email = $rows["email"];
        $dob = $rows["dob"];
        $gender = $rows["gender"];
    }
}
        $nameErr = $emailErr = "";
        // $name = $email = $dob = $gender = "";

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
                $name = "";
            }else {
                $name = $_REQUEST["name"];
            }

            if( empty($_REQUEST["email"]) ){
                $emailErr = "<p style='color:red'> * Email is required</p> ";
                $email = "";
            }else{
                $email = $_REQUEST["email"];
            }


            if( !empty($name) && !empty($email) ){
            
                // database connection
                require_once "../connection.php";
                $sql_select_query = "SELECT email FROM employee WHERE email = '$email' ";
                $r = mysqli_query($conn , $sql_select_query);

                if( mysqli_num_rows($r) > 0 ){
                    $emailErr = "<p style='color:red'> * Email Already Register</p>";
                } else{

                    $sql = "UPDATE employee SET name = '$name', email = '$email', dob = '$dob', gender= '$gender' WHERE email='$_SESSION[email_emp]' ";
                    $result = mysqli_query($conn , $sql);
                    if($result){
                        $_SESSION['email_emp']= $email;
                        echo "<script>
                        $(document).ready( function(){
                            $('#showModal').modal('show');
                            $('#modalHead').hide();
                            $('#linkBtn').attr('href', 'profile.php');
                            $('#linkBtn').text('View Profile');
                            $('#addMsg').text('Profile Edited Successfully!!');
                            $('#closeBtn').hide();
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
                        <a href="employeedashboard.php">
                            <i class='bx bxs-dashboard'></i>
                            <span class="links_name">Dashboard</span>
                        </a>
                        <span class="tooltip">Dashboard</span>
                    </li>
                    <li>
                        <a href="applyleave.php">
                            <i class='bx bxl-telegram'></i>
                            <span class="links_name">Apply for Leave</span>
                        </a>
                        <span class="tooltip">Apply Leave</span>
                    </li>
                    <li>
                        <a href="leavestatus.php">
                            <i class='bx bx-align-left'></i>
                            <span class="links_name">Leave Status</span>
                        </a>
                        <span class="tooltip">Leave Status</span>
                    </li>
                    <li>
                        <a href="employees.php">
                            <i class='bx bx-user-check'></i>
                            <span class="links_name">View All Employees</span>
                        </a>
                        <span class="tooltip">Employees</span>
                    </li>
                    <li>
                        <a href="profile.php">
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
                <h2 class="text-white text-center py-3">Edit Your Profile</h2>
                <form method="POST" action=" <?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <div class="form-group">
                        <label for="name" class="text-white">Full Name:</label>
                        <input type="text" class="form-control" value="<?php echo $name; ?>"  name="name" >
                        <?php echo $nameErr; ?>
                    </div>
                    <div class="form-group">
                        <label for="email" class="text-white">Email:</label>
                        <input type="email" class="form-control" value="<?php echo $email; ?>"  name="email" >     
                        <?php echo $emailErr; ?>
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