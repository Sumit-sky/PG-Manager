<?php

session_start();




  include 'dbconnect.php';
  $username = $_SESSION['username'];
  

  $sql = "DELETE FROM users WHERE `users`.`username` = '$username'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $showAlert = true;
    session_unset();
    session_destroy();
    
    header("location: signup.php");
    exit();
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account deleted successfully</title>
</head>
<body>
    
</body>
</html>
