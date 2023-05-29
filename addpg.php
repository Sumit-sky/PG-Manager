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
    $pgname = $_POST["pgname"];
    $mobileno = $_POST["mobileno"];
    $pgaddress = $_POST["pgaddress"];
    $username = $_SESSION["username"];
    $rooms = $_POST["rooms"];
    $floors = $_POST["floors"];
    $roomtype = $_POST['roomtype'];

    $existSql = "SELECT * FROM `addpg` WHERE `mobileno` =  '$mobileno'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);



    if ($numExistRows > 0) {
        $showError = 'Phone Number already exists';
        echo "<script>alert('Phone Number already exists');</script>";
    } else {

        $sql = "INSERT INTO `addpg` VALUES ('$pgname', '$mobileno', '$pgaddress','$rooms','$floors','$username','$roomtype')";
        $result = mysqli_query($conn, $sql);

        $pgnam = preg_replace('/\s+/', '', $pgname);

        $staff = $pgnam . "staff";

        $sql2 = " create table $pgnam(PGname varchar(100) not null, Roomno int not null, Roomrent int not null, Aadharno varchar(12) not null, Fullname char(30) not null, Email varchar(30) not null unique, Fathername char(30) not null, Phoneno varchar(10) not null, pphoneno varchar(10) not null, DOJ date not null, Address varchar(300) not null, gender char(10)not null, profilepic varchar(200) not null, Primary Key(Aadharno,Phoneno),FULLTEXT(Aadharno,Fullname,Email,Phoneno) )";
        $result2 = mysqli_query($conn, $sql2);

        $sql3 = " create table $staff (PGname varchar(100) not null, Salary int not null, Aadharno varchar(12) not null, Fullname char(30) not null, Email varchar(30) not null unique, Fathername char(30) not null, Phoneno varchar(10) not null, pphoneno varchar(10) not null, DOJ date not null,Caddress varchar(300) not null, Address varchar(300) not null, gender char(10)not null, profilepic varchar(200) not null, Primary Key(Aadharno,Phoneno),FULLTEXT(Aadharno,Fullname,Email,Phoneno) )";
        $result3 = mysqli_query($conn, $sql3);


        if ($result && $result2 && $result3) {

            $showAlert = true;

            header("location: pgmanager.php");
            echo "<script>alert('PG registered successfully!');</script>";

        } else {
            $showAlert = false;
            echo "<script>alert('Failed to register, please try again!');</script>";
        }

    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New PG</title>
    <link rel="stylesheet" href="addpg.css">
    <?php require 'navbar.php' ?>
</head>

<body onload="disableSubmit()">
    <div class="preloader" id="preloader"></div>
    <div class="center">

        <form action="addpg.php" method="post">
            <div class="form-header">

                <h1>Register New PG</h1>
            </div>
            <div class="pg-details">

                <div class="txt_field">
                    <input type="text" value="Username: <?php echo $_SESSION['username'] ?>" id="username"
                        name="username" disabled />
                </div>

                <div class="txt_field">
                    <input type="text" name="pgname" id="pgname" onkeydown="return /[a-z, ]/i.test(event.key)"
                        required />
                    <label>PG Name</label>
                </div>


                <div class="txt_field">
                    <input type="tel" id="mobileno" name="mobileno" minlength="10" maxlength=10 step="9999999999"
                        required />
                    <label>Mobile Number</label>
                </div>

                <div class="txt_field">
                    <input type="number" id="floors" name="floors" minlength="1" maxlength=10 required />
                    <label>Number of Floors</label>
                </div>

                <div class="txt_field">
                    <input type="number" id="rooms" name="rooms" minlength="1" maxlength=10 required />
                    <label>Number of Rooms on each Floor</label>
                </div>

                <div class="txt_field">

                    <select name="roomtype" id="roomtype" required>
                        <option value='Single Room' selected>Single Room</option>
                        <option value='Double Sharing'>Double Sharing </option>

                    </select>
                </div>


            </div>

            <div class="txt_field">
                <input type="text" id="pgaddress" name="pgaddress" minlength="20" maxlength="200" required />
                <label>PG Address</label>
            </div>

            
            <div class="button">
                <input type="submit" id="submit" value="Register">
                

            </div>

            <div class="signup_link">
                Manage Your PG ! <a href="pgmanager.php"> Click Here</a>
            </div>

        </form>
    </div>

    <?php require 'footer.php' ?>
    <script>
        


        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        })
    </script>

</body>

</html>