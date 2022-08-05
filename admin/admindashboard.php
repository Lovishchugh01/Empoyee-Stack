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

        // database connection
        require_once "../connection.php";

         $currentDay = date( 'Y-m-d', strtotime("today") );
         $tomarrow = date( 'Y-m-d', strtotime("+1 day") );

         $today_leave = 0;
         $tomarrow_leave = 0;
         $this_week = 0;
         $next_week = 0;
            $i = 1;
        // total adminx 
        $select_admins = "SELECT * FROM admin";
        $total_admins = mysqli_query($conn , $select_admins);

        // total employee
        $select_emp = "SELECT * FROM employee";
        $total_emp = mysqli_query($conn , $select_emp);

        // employee on leave
        $emp_leave  ="SELECT * FROM emp_leave";
        $total_leaves = mysqli_query($conn , $emp_leave);

        if( mysqli_num_rows($total_leaves) > 0 ){
            while( $leave = mysqli_fetch_assoc($total_leaves) ){
                $leave = $leave["start_date"];

                //daywise
                if($currentDay == $leave){
                    $today_leave += 1;
                }elseif($tomarrow == $leave){
                   $tomarrow_leave += 1;
                }


            }
        }else {
            echo "no leave found";
        }


        // highest paid employee
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

    <div class="container text-center py-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title border-bottom pb-3">Admins</h5>
                      <li class="list-group-item mb-3 py-3">Total Admin : <?php echo mysqli_num_rows($total_admins); ?> </li>
                      <a href="manageAdmin.php" class="card-link text-primary" style="background-color: transparent;">View All Admins</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title border-bottom pb-3 ">Employees</h5>
                      <li class="list-group-item mb-3 py-3">Total Employees : <?php echo mysqli_num_rows($total_emp); ?></li>
                      <a href="manageEmployee.php" class="card-link text-primary" style="background-color: transparent;">View All Employees</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title border-bottom pb-3">Employees on Leave (Daywise)</h5>
                      <li class="list-group-item py-3 mb-3">Today :  <?php echo $today_leave; ?>  </li>
                    <li class="list-group-item py-2">Tomorrow :  <?php echo $tomarrow_leave; ?> </li>
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