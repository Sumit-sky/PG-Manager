<!--session_start();

//$showAlert = false;
//if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //include 'dbconnect.php';
  //$email = $_POST["email"];
  //$sub = 'Reset your password';
 // $otp = rand(1000,9999);
  //$msg = "'Your otp is :', $otp";
  //$from = "yadavskyst@gmail.com";
  //$hed = "From: $from";

  //$sendotp = mail($email,$sub,$msg,$hed);

  //if ($sendotp) {
    //$showAlert = true;
  //}

//}-->

<?php 
session_start();
if($_SESSION['username']){
    header('location:update_profile.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset your password</title>
  <link rel="stylesheet" href="forgotpass.css">
  <?php require 'navbar.php' ?>
</head>

<body>
  <div class="preloader" id="preloader"></div>

  <div class="center">

    <form method="" id="forgetpass" action="" autocomplete="off">
      <h1>Reset Your Password</h1>
      <div class="txt_field">
        <input type="email" id="email" name="email" required />

        <label>E-mail Id</label>
      </div>


      <div class="pass"><a href="login.php">Login Here</a> </div>
      <input type="submit" value="Send OTP" />
      <div class="signup_link">
        New to PG-Manager? <a href="signup.php">Signup Here</a>
      </div>
    </form>
  </div>

  <!--$(document).ready(function () {
    $("#forgetpass").on('submit', function (e) {
      e.preventDefault();
      
      var email = $("#email").val();
      
      alert(email);
      
      $.ajax({
        type: "POST";
        url: "forgotpass_in.php";
        data: { email: email };
        
        success: function (data) {
          
          $(".form-message").css("display", "block");
          $(".form-message").html(data);
        }
        
      });
    });
  });-->
          <script type="text/javascript">


    var loader = document.getElementById("preloader");
    window.addEventListener("load", function () {
      preloader.style.display = "none";
    })
  </script>

  <?php require 'footer.php' ?>
</body>

</html>