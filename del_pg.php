<?php

session_start();




include 'dbconnect.php';
$user = $_SESSION['username'];
$pgnam = $_POST['pgname'];



$tableName = preg_replace('/\s+/', '', $pgnam);
$pg = $tableName.'staff';


$sql_addpg = "DELETE FROM addpg  WHERE `PGname` = '$pgnam'";
$result_addpg = mysqli_query($conn, $sql_addpg);

$sql_drop = "drop table $tableName";
$res_drop = mysqli_query($conn,$sql_drop);

$sql_staff = "drop table $pg";
$res_staff = mysqli_query($conn,$sql_staff);
if ($result_addpg && $res_drop && $res_staff) {
    $showAlert = true;
    echo "<script>window.alert('PG deleted Successfully !'); window.location.href='pgmanager.php';</script>";
    exit();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PG deleted successfully</title>
</head>

<body>

</body>

</html>