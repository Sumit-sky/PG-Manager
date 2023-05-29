<?php

session_start();




  include 'dbconnect.php';
  $pgname = $_POST['table'];
  $aadharno = $_POST['edit_aadharno'];
  

  $sql = "DELETE FROM $pgname  WHERE `Aadharno` = '$aadharno'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $showAlert = true;
    echo "<script>window.alert('Data deleted Successfully !'); window.location.href='view_rentee.php';</script>";
    exit();
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentee deleted successfully</title>
</head>
<body>
    
</body>
</html>
