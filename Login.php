<?php
session_start();
if($_SESSION['username']){
    header('location:home.php');
    exit;
}


$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * from users where username ='$username';";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;

                header("location: home.php");
            } else {
                $showError = "Invalid Credentials";
                echo "<script>alert('Invalid Credentials');</script>";
            }
        }
    } else {
        $showError = "Invalid Credentials";
        echo "<script>alert('Invalid Credentials');</script>";
    }

}
  



?>



<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your Account</title>
    <link rel="stylesheet" href="login.css">
    <?php require 'navbar.php' ?>

</head>

<body>
    <div class="preloader" id="preloader"></div>
    <div class="center">

        <form action="login.php" method="post">
            <div class="form-header">

                <h1>Login</h1>
            </div>
            <div class="txt_field">
                <input type="text" name="username" id="username" required />
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="password" id="password" name="password" required />
                <label>Password</label>
            </div>
            <div class="pass"><a href="forgotpass.php">Forgot Password?</a> </div>
            <div class="pass1"><a href="rentee_login.php" target="_blank">Rentee Login</a> </div>
            <input type="submit" value="Login">
            <div class="signup_link">
                New to PG-Manager? <a href="signup.php">Signup Here</a>
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