<?php
session_start();
if($_SESSION['aadhar_no']){
    header('location:rentee_home.php');
    exit;
}


$rlogin = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'dbconnect.php';
    $pgname = $_POST["pgname"];
    $aadharno = $_POST["aadharno"];
    $mobileno = $_POST["phonenumber"];

    $tableName = preg_replace('/\s+/', '', $pgname);


    $sql = "SELECT * from $tableName where aadharno ='$aadharno' AND Phoneno ='$mobileno';";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $rlogin = true;
        session_start();
        $_SESSION['rloggedin'] = true;
        $_SESSION['pg_name']= $pgname;
        $_SESSION['mobile_no']=$mobileno;
        $_SESSION['aadhar_no']=$aadharno;
        echo "<script>window.alert('Login Success!'); window.location.href='rentee_home.php'; </script>";
    } else {
        $showError = "Invalid Credentials";
        echo "<script>window.alert('Invalid Credentials! Try again'); window.location.href='rentee_login.php';</script>";

    }
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentee Login</title>
    <link rel="stylesheet" href="rentee_login.css">
    <?php require 'rentee_navbar.php' ?>
</head>

<body>
    <div class="preloader" id="preloader"></div>
    
    <div class="center">

        <form action="rentee_login.php" method="post" id="form1">

            <div class="form-header">
                <h1>Rentee Login</h1>
            </div>

            <div class="txt_field">
                <input type="text" id="pgname" maxlength="30" minlength="3" name="pgname" required />
                <label>PG Name</label>
            </div>

            <div class="txt_field">
                <input type="tel" step="1" pattern="\d+" id="aadharno" name="aadharno" minlength="12" maxlength="12"
                    required>
                <label for="aadharno">Aadhar Number</label>
            </div>

            <div class="txt_field">
                <input type="tel" id="phonenumber" name="phonenumber" maxlength="10" minlength="10" required />
                <label>Mobile Number</label>
            </div>

            <div>
                <input type="submit" value="Login">
            </div>


        </div>
        </form>
    
    
    <?php require 'footer.php' ?>

    <script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        })
    </script>
</body>

</html>