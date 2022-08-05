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
 
//  database connection
require_once "../connection.php";

$sql = "SELECT * FROM admin";
$result = mysqli_query($conn , $sql);

$i = 1;
$you = "";


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
            <div class="container text-center pb-5" style="background-color: #143532;">
        <h2 class="text-white py-3">Manage Admin</h2>
        <table style="width:100%" class="table table-hover table-info text-center ">
    <tr>
        <th>S.No.</th>
        <th>Name</th>
        <th>Email</th> 
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Action</th>
    </tr>
    <?php 
    
    if( mysqli_num_rows($result) > 0){
        while( $rows = mysqli_fetch_assoc($result) ){
            $name= $rows["name"];
            $email= $rows["email"];
            $dob = $rows["dob"];
            $gender = $rows["gender"];
            $id = $rows["id"];
            if($gender == "" ){
                $gender = "Not Defined";
            } 

            if($dob == "" ){
                $dob = "Not Defined";
                $age = "Not Defined";
            }else{
                $dob = date('jS F, Y' , strtotime($dob));
                $date1=date_create($dob);
                $date2=date_create("now");
                $diff=date_diff($date1,$date2);
                $age = $diff->format("%Y Years"); 
            }
           
            ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td> <?php echo $name ; ?></td>
        <td><?php echo $email; ?></td>
        <td><?php echo $gender; ?></td>
        <td><?php echo $dob; ?></td>
        

        <td>  <?php 
                $edit_icon = "<a href='editadmin.php?id= {$id}' class='btn-sm  '> <span ><i class='bx bx-edit-alt'></i></span> </a>";
                $delete_icon = " <a href='deleteadmin.php?id={$id}' id='bin' class='btn-sm'> <span ><i class='bx bx-trash'></i></span> </a>";
                echo $edit_icon . $delete_icon;
             ?> 
        </td>

      
        

    <?php 
            $i++;
            }
        }else{
        echo "no admin found";
        }
    ?>
     </tr>
    </table>
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