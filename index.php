<?php 
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IQ010</title>
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <style>
    .container {
			margin: 0 auto;
      padding-top: 100px;
      width: 500px;
    }
		.logout {
			text-align: center;
		}
  </style>
</head>
<body>
  <div class="container">
      <?php
      session_start();
      include('NotORM.php');
      $dbh = new PDO('mysql:host=localhost;dbname=aimaniva_asd', 'aimaniva_asd', 'P=TNNq1Wu!J=');
      $db = new NotORM($dbh);
      $users = ['a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13', 'a14', 'a15', 'admin'];
      $passes = Array(
        'a1' => 1048576,
        'a2' => 653421,
        'a3' => 185,
        'a4' => 456,
        'a55' => 845375,
        'a6' => 1234567890,
        'a7' => 1379811,
        'a8' => 13571357,
        'a9' => 412331,
        'a10' => 312380,
        'a11' => 4901840,
        'a12' => 93125,
        'a13' => 2901301,
        'a13' => 123,
        'a14' => 123,
        'a15' => 123,
        'admin' => 10203151000
      );

      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(@!$_SESSION['login']) {
          if(@in_array($_POST['username'], $users) && $_POST['password'] == $passes[$_POST['username']]) {
            $_SESSION['login'] = $_POST['username'];
            if($_POST['username'] == 'admin') $_SESSION['admin'] = true;
            header('Location: index.php');
            exit;
          } else {
            echo 'Password is wrong';
          }
        }
      }
      
      if(@$_SESSION['admin']) {
        if(@$_GET['res']) include('result.php');
        else include('admin.php');
        echo '<p class="logout"><a href="logout.php">logout</a></p>';
      } elseif(@$_SESSION['login']) {
        if(@$_GET['res']) include('user-result.php');
        else include('fields.php');
        echo '<p class="logout"><a href="logout.php">logout</a></p>';
      } else {
        include('login.php');
      }
      ?>
  </div>
</body>
</html>
