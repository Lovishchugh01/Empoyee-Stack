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



$reasonErr = $startdateErr = $lastdateErr = "";
$reason = $start_date = $end_date = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if( empty($_REQUEST["reason"]) ){
        $reasonErr = "<p style='color:red'>* Reason is Required</p>";    
    }else{
        $reason = $_REQUEST["reason"];
    }
 
    if( empty($_REQUEST["start_date"]) ){
        $startdateErr = "<p style='color:red'>* Start Date is Required</p>";    
    }else{
        $start_date = $_REQUEST["start_date"];
    }
     
    if( empty($_REQUEST["end_date"]) ){
        $lastdateErr = "<p style='color:red'>* Last Date is Required</p>";    
    }else{
        $end_date = $_REQUEST["end_date"];
    }

        if( !empty($reason) && !empty($start_date) && !empty($end_date) ){
          
            // database connection 
            require_once "../connection.php";

            $sql = "INSERT INTO emp_leave( reason , start_date , end_date , email , status ) VALUES( '$reason' , '$start_date' , '$end_date' , '$_SESSION[email_emp]' , 'pending' )";
            $result = mysqli_query($conn , $sql);
            if($result){
                $reason = $start_date = $end_date = "";
                echo "<script>
            $(document).ready( function(){
                $('#showModal').modal('show');
                $('#addMsg').text('leave Applied , Please Wait until it is approved!!');
                $('#linkBtn').attr('href', 'leavestatus.php');
                $('#linkBtn').text('Check Leave Status');
                $('#closeBtn').text('Apply Another');
            })
        </script>
        ";
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
            <div class="container pb-5 w-50" style="background-color: #143532;">
                <h2 class="text-white text-center py-3">Apply for Leave</h2>

                <form method="POST" action=" <?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <div class="form-group">
                        <label for="email" class="text-white">Reason:</label>
                        <input type="text" class="form-control" value="<?php echo $reason; ?> " name="reason" >  
                        <?php echo $reasonErr; ?> 
                    </div>
                    <div class="form-group">
                        <label for="startDate" class="text-white">Start Date:</label>
                        <input type="date" class="form-control"  value="<?php echo $start_date; ?>"  name="start_date" >
                        <?php echo $startdateErr; ?>
                    </div>
                    <div class="form-group">
                        <label for="endDate" class="text-white">End Date:</label>
                        <input type="date" class="form-control"  value="<?php echo $end_date; ?>"  name="end_date" >
                        <?php echo $lastdateErr; ?>
                    </div>
                    
                    <button type="submit" class="btn w-100">Apply Now</button>
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