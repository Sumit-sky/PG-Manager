<?php
session_start();


if (!isset($_SESSION['loggedin']) && $_SESSION['loggediin'] != true) {
    header("location: login.php");
    exit;
}

$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'dbconnect.php';
    $pgname = $_POST["edit_pgname"];
    $aadharno = $_POST["edit_aadharno"];
    $salary = $_POST['edit_salary'];
    $fullname = $_POST["edit_fullname"];
    $fathername = $_POST["edit_fathername"];
    $email = $_POST["edit_email"];
    $phonenumber = $_POST["edit_phonenumber"];
    $pphonenumber = $_POST["edit_pphonenumber"];
    $joindate = $_POST["edit_joindate"];
    $caddress = $_POST["edit_caddress"];
    $address = $_POST["edit_address"];
    $gender = $_POST["edit_gender"];



    $pgnam = preg_replace('/\s+/', '', $pgname);
    $pg = $pgnam . 'staff';

    $tableName = preg_replace('/\s+/', '', $pg);
    if ($_FILES['edit_profilepic']['name']) {
        $profile = $_FILES['edit_profilepic']['name'];
        $destination = 'ProfilePictures/' . $profile;
    } else {

        $img_sql = "SELECT profilepic FROM $tableName WHERE Aadharno ='$aadharno';";
        $img_res = mysqli_query($conn, $img_sql);
        $img = mysqli_fetch_assoc($img_res);
        $destination = $img['profilepic'];
    }



    $sql = "UPDATE  $tableName SET Fullname='$fullname',Salary='$salary',Fathername='$fathername',Email='$email',Phoneno='$phonenumber',pphoneno='$pphonenumber',DOJ='$joindate',Caddress='$caddress', Address='$address',gender='$gender',profilepic='$destination' WHERE Phoneno = '$phonenumber' OR Aadharno = '$aadharno';";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        move_uploaded_file($_FILES["edit_profilepic"]["tmp_name"], "ProfilePictures/" . $_FILES["edit_profilepic"]["name"]);
        $showAlert = true;
        echo "<script>window.alert('Data updated Successfully !'); window.location.href='view_staff.php';</script>";

    } else {
        echo "<script>alert('Couldn't add data, Try again!');</script>";
    }
}



?>