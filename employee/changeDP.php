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
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
            $filename = $_FILES["dp"]['name'];
            $temp_loc = $_FILES["dp"]["tmp_name"];

            $temp_ex = explode("." , $filename);
            $extension = strtolower( end($temp_ex) );
            $allowed_types = array("png","jpg","jpeg");

        if( in_array($extension , $allowed_types)  ){
            $new_file_name = uniqid("",true).$filename;
            $location = "../images/".$new_file_name;
            if(move_uploaded_file($temp_loc, $location)){
                
                // database connection 
                require_once "../connection.php";
                $sql = "UPDATE employee SET dp = '$new_file_name' WHERE email = '$_SESSION[email_emp]' ";
                $result = mysqli_query($conn , $sql);
                if($result){
                    echo "<script>
                    $(document).ready( function(){
                        $('#showModal').modal('show');
                        $('#addMsg').text('Profile Photo Update Succefully!!');
                        $('#linkBtn').attr('href', 'profile.php');
                        $('#linkBtn').text('Check Profile');
                        $('#closeBtn').text('Upload Again');
                    })
                </script>
                ";
                }
                
            }
        } else{ echo "<script>
            $(document).ready( function(){
                $('#showModal').modal('show');
                $('#addMsg').text('Only JPG, PNG and JPEG files allowed!!');
                $('#linkBtn').attr('href', 'profile.php');
                $('#linkBtn').hide();
                $('#closeBtn').text('Ok, Understood');
            })
        </script>
        ";
         
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
                <h2 class="text-white text-center py-3">Change Profile Picture</h2>
                <form method="POST" enctype="multipart/form-data" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <div class="form-group">
                        <label for="file">Select Image: </label>
                        <input type="file" class="form-control-file border p-2" id="file" name="dp">
                    </div>
                    <button type="submit" class="btn w-25 form-inline">Save Changes</button>
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