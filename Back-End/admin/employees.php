<?php
session_start();
require "../includes/db_config.php";

//if(!isset($_SESSION['emp_details'])) {
//    header("location: ../index.php");
//}


try {
        $result = $db_connection->query("SELECT * FROM Grp_employee LIMIT 15");
    }
    catch(PDOException $e) {
//        $output = "Error occured when adding author, please try again" . $e->getMessage();
//        include "error.html.php";
//        exit();
   }

   foreach ($result as $row) {
        $ideas[] = array('Id' => $row['empID'], 'ideastext' => $row['Name'], 'ideacomment' => $row['Email'], 'emp' => $row['DOB'], 'login' => $row['LastLoginDate']);
   }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WHPH Administrator | Employees</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="text-block">
            <h5 class="modal-title" id="exampleModalLongTitle">Sign In</h5>
            <p>To share, view and rank ideas.</p>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <span class="error">Username is required</span>
            <input type="email" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@example.co.uk" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <span class="error">Password is required</span>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Remember me</label>
            <h6 class="float-right">Forgot Password?</h6>
          </div>
          <button type="submit" class="btn mybtn w-100">Sign In</button>
        </form>
      </div>
    </div><!-- end of modal-content -->
  </div>
</div> <!-- end of modal -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark-1 text-dark">
    <div class="container">
    <a href="index.html" class="navbar-brand logo"><span>Admin Dashboard</span></a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="index.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="ideas.html" class="nav-link">Ideas</a>
            </li>
        </ul>
        <?php if(isset($_SESSION['staff_details'])): ?>
            
            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter"><?php echo $_SESSION['staff_details']['name']; ?></a>


        <?php else: ?>
        
        <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter">Sign in</a>

        <?php endif; ?>
        <a href="../logout.php" class="btn btn-outline cta">Logout</a>
    </div>
    </div>
</nav>

<div class="container" style="margin: 30px auto;">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
              <ul class="nav flex-column">
                <li class="nav-item logo-admin">
                    <a class="nav-link" href="#">
                    <span data-feather="file"></span>
                    <strong>W.H.P.H</strong>
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="index.php">
                    <span data-feather="home"></span>
                    <i class="ion-ios-gear"></i>Dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="categories.php">
                    <span data-feather="file"></span>
                    <i class="ion-ios-list"></i>Categories
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="comments.php">
                    <span data-feather="shopping-cart"></span>
                    <i class="ion-ios-chatbubble"></i>Comments
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="employees.php">
                    <span data-feather="users"></span>
                    <i class="ion-ios-people"></i>Employees
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="departments.php">
                    <span data-feather="bar-chart-2"></span>
                    <i class="ion-ios-home"></i>Departments
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="reports.php">
                    <span data-feather="layers"></span>
                    <i class="ion-ios-pie"></i>Reports
                  </a>
                </li>
              </ul>
            </div>
          </nav>
  
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
              <h1 class="h2">Dashboard</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                  <button class="btn btn-sm btn-outline-secondary">Share</button>
                  <button class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                  <span data-feather="calendar"></span>
                  This week
                </button>
              </div>
            </div>
  
            <canvas class="my-4" id="myChart" width="900" height="380"></canvas>
            <div class="export-block">
              <h2 class="submit-id">All Employees</h2>
                <form action="download.php" method="post">
                    <input type="submit" name="download" class="btn cta" value="Export CSV">
                </form>
            </div>
            
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-sm">
                <thead class="thead-dark text-center">
                  <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>Last Login</th>
                  </tr>
                </thead>
                <tbody>
                 <?php foreach($ideas as $idea) : ?>
                  <tr>
                    <td><?php echo $idea['Id']; ?></td>
                    <td><?php echo substr($idea['ideastext'], 0, 40); ?></td>
                    <td><?php echo substr($idea['ideacomment'], 0, 40); ?></td>
                    <td><?php echo $idea['emp']; ?></td>
                    <td><?php echo $idea['login']; ?></td>
                  </tr>
                 <?php endforeach; ?>

                </tbody>
              </table>
            </div>
          </main>
        </div>
      </div>

<footer class="text-muted">
<div class="container">
  <p class="float-right">
    <a href="#"><i class="ion-arrow-up-c"></i>Back to top</a>
  </p>
  <p>&copy; Copyright 2018 Team - Work Hard Play Hard. All Rights Reserved</p>
  <p>New to WHPH? <a href="index.html">Visit the homepage</a></p>
</div>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="../js/script.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          datasets: [{
            data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#FDCA40',
            borderWidth: 4,
            pointBackgroundColor: '#FDCA40'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    </script>
</body>
</html>