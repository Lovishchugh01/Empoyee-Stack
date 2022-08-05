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
 
  $email = $_SESSION["email_emp"];
//  database connection
require_once "../connection.php";

$sql = "SELECT * FROM emp_leave WHERE email = '$email'  ";
$result = mysqli_query($conn , $sql);

$i = 1;

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

    <div class="container text-center pb-5" style="background-color: #143532;">
        <h2 class="text-white py-3">Leave Status</h2>
        <table class="table table-striped table-info">
            <thead>
              <tr>
                <th scope="col">S.No.</th>
                <th scope="col">Starting Date</th>
                <th scope="col">Ending Date</th>
                <th scope="col">Total Days</th>
                <th scope="col">Reason</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
    
    if( mysqli_num_rows($result) > 0){
        while( $rows = mysqli_fetch_assoc($result) ){
            $start_date= $rows["start_date"];
            $end_date = $rows["end_date"];
            $email= $rows["email"];
            $reason = $rows["reason"];
            $status = $rows["status"]; 
            $id = $rows["id"];   
            ?>
        <tr>
        <td><?php echo "$i."; ?></td>
        <td><?php echo date("jS F", strtotime($start_date)); ?></td>
        <td><?php echo date("jS F", strtotime($end_date)); ?></td>
        <td><?php $date1=date_create($start_date);
                  $date2=date_create($end_date);
                   $diff=date_diff($date1,$date2); 
                   echo $diff->format("%a days");
            ?></td>
        <td><?php echo $reason; ?></td> 
        <td><?php echo $status; ?></td> 
        <td>  <?php 
                $delete_icon = " <a href='deleteleave.php?id={$id}' id='bin' class='btn-lg'> <span ><i class='bx bx-trash '></i></span> </a>";
                echo  $delete_icon;
             ?> 
        </td>
    <?php 
            $i++;
            }
        }else{
            echo "<script>
            $(document).ready( function(){
                $('#showModal').modal('show');
                $('#addMsg').text('No leave Applied by you!!');
                $('#linkBtn').attr('href', 'apply-leave.php');
                $('#linkBtn').text('Apply for Leave');
                $('#closeBtn').text('Remind me Later');
            })
        </script>
        ";
        }
    ?>
     </tr>
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