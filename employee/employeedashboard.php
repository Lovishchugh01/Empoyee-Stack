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

         
        $i = 1;
        


        // applied leaves--------------------------------------------------------------------------------------------
        $total_accepted = $total_pending = $total_canceled = $total_applied = 0;
        $leave = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' ";
        $result = mysqli_query($conn , $leave);

        if( mysqli_num_rows($result) > 0 ){

            $total_applied = mysqli_num_rows($result);

            while( $leave_info = mysqli_fetch_assoc($result) ){
                $status = $leave_info["status"];

                if( $status == "pending" ){
                    $total_pending += 1;
                }elseif( $status == "Accepted" ){
                    $total_accepted += 1;
                }elseif( $status = "Canceled"){
                    $total_canceled += 1;
                }
            }
        }else{
            $total_accepted = $total_pending = $total_canceled = $total_applied = 0;
        }



        // leave status--------------------------------------------------------------------------------------------------------------
        $currentDay = date( 'Y-m-d', strtotime("today") );

        $last_leave_status = "No leave applied";
        $upcoming_leave_status = "";

        // for last leave status
        $check_leave = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' ";
        $s = mysqli_query($conn , $check_leave);
        if( mysqli_num_rows($s) > 0 ){
            while( $info = mysqli_fetch_assoc($s) ){
               $last_leave_status =  $info["status"] ;
            }
    }


    // for next leave date
    $check_ = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' ORDER BY start_date ASC ";
    $e = mysqli_query($conn , $check_); 
    if( mysqli_num_rows($e) > 0 ){
        while( $info = mysqli_fetch_assoc($e) ){
            $date = $info["start_date"] ;
            $last_leave =  $info["status"] ;
           if ( $date > $currentDay && $last_leave == "Accepted" ){
               $upcoming_leave_status = date('jS F', strtotime($date) ) ;
               break;
           }
        }
}


        // total employee--------------------------------------------------------------------------------------------
        $select_emp = "SELECT * FROM employee";
        $total_emp = mysqli_query($conn , $select_emp);

       



        // highest paid employee--------------------------------------------------------------------------
        $sql_highest_salary =  "SELECT * FROM employee ORDER BY salary DESC";
        $emp_ = mysqli_query($conn , $sql_highest_salary);



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

    <div class="container text-center py-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title border-bottom pb-3">Leave Status</h5>
                      <h6 class="card-subtitle border-bottom py-3">Upcoming Leaving on : <?php echo  $upcoming_leave_status ; ?></h6>
                      <h6 class="card-subtitle pt-3">Last Leave's Status : <?php echo ucwords($last_leave_status) ;  ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title border-bottom pb-3">Applied leaves</h5>
                      <h6 class="card-subtitle border-bottom py-3">Total Accepted : <?php echo $total_accepted;  ?></h6>
                      <h6 class="card-subtitle border-bottom py-3">Total Canceled : <?php echo $total_canceled; ?></h6>
                      <h6 class="card-subtitle border-bottom py-3">Total Pending : <?php echo $total_pending; ?></h6>
                      <h6 class="card-subtitle pt-3 ">Total Applied : <?php echo $total_applied; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title border-bottom pb-3">Employees</h5>
                      <h6 class="card-subtitle border-bottom py-3 mb-3">Total Employees : <?php echo mysqli_num_rows($total_emp); ?></h6>
                      <a href="employees.php" class="card-link text-primary" style="background-color: transparent;">View All Employees</a>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <div class="container text-center pb-5" style="background-color: #143532;">
        <h2 class="text-white py-3">Employee Stack Leadership Board</h2>
        <table class="table table-striped table-info">
            <thead>
              <tr>
                <th scope="col">S.No.</th>
                <th scope="col">Employee's Id</th>
                <th scope="col">Employee's Name	</th>
                <th scope="col">Employee's Email</th>
                <th scope="col">Salary in Rs.</th>
              </tr>
            </thead>
            <tbody>
              <?php while( $emp_info = mysqli_fetch_assoc($emp_) ){
                    $emp_id = $emp_info["id"];
                    $emp_name = $emp_info["name"];
                    $emp_email = $emp_info["email"];
                    $emp_salary = $emp_info["salary"];
                ?>
            <tr>
            <th ><?php echo "$i. "; ?></th>
            <th ><?php echo $emp_id; ?></th>
            <td><?php echo $emp_name; ?></td>
            <td><?php echo $emp_email; ?></td>
            <td><?php echo $emp_salary; ?></td>
            </tr>

          <?php  
          $i++; 
                } 
            ?>
            </tbody>
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