<?php
session_start();
if (isset($_SESSION['username'])) {
  header('location:home.php');
  exit;
}

$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include 'dbconnect.php';
  $fname = $_POST["fname"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $phonenumber = $_POST["phonenumber"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];
  $gender = $_POST["gender"];
  $profile = $_FILES['profilepic']['name'];
  $destination = 'ProfilePictures/' . $profile;



  $existSql = "SELECT * FROM `users` WHERE `username` =  '$username'";
  $result = mysqli_query($conn, $existSql);
  $numExistRows = mysqli_num_rows($result);

  $existSql2 = "SELECT * FROM `users` WHERE `email` =  '$email'";
  $result2 = mysqli_query($conn, $existSql2);
  $numExistRows2 = mysqli_num_rows($result2);

  $existSql3 = "SELECT * FROM `users` WHERE `phonenumber` =  '$phonenumber'";
  $result3 = mysqli_query($conn, $existSql3);
  $numExistRows3 = mysqli_num_rows($result3);

  if ($numExistRows > 0) {
    $showError = 'Username already exists';
    echo "<script>alert('Username Number already exists! Try using another one.');</script>";
  } elseif ($numExistRows2 > 0) {
    $showError = 'Email already exists';
    echo "<script>alert('E-mail already exists! Try using another one or Login into your account.');</script>";
  } elseif ($numExistRows3 > 0) {
    $showError = 'Phone Number already exists';
    echo "<script>alert('Phone Number already exists! Try using another one or Login into your Account.');</script>";
  } else {
    if (($password == $cpassword)) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users(fname,username,email,phonenumber,password,gender,profilepic) VALUES('$fname','$username','$email',$phonenumber,'$hash','$gender','$destination');";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $showAlert = true;
        move_uploaded_file($_FILES["profilepic"]["tmp_name"], "ProfilePictures/" . $_FILES["profilepic"]["name"]);
        echo "<script>alert('Account Created');</script>";
        header("Location: home.php");
      }
    } else {
      $showError = 'Passwords do not match';
      echo "<script>alert('Passwords do not match');</script>";
    }
  }
}



?>
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Sign Up here</title>
  <link rel="stylesheet" href="signup.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php require 'navbar.php' ?>
</head>

<body onload="disableSubmit()">
  <!-- <div class="preloader" id="preloader"></div> -->


  <div class="center">
    <form action="signup.php" method="post" enctype="multipart/form-data">
      <div class="form-header">

        <h1>Sign Up Here</h1>
      </div>
      <div class="txt_field">

        <label for="profilepic">Select Profile Picture </label>
        <input type="file" name="profilepic" id="profilepic" accept="image/*" style="opacity:1;z-index:-1;" required>

      </div>
      <div class="user-details">
        <div class="txt_field">

          <input type="text" id="fname" maxlength="30" minlength="3" name="fname" required />
          <label>Fullname</label>
        </div>

        <div class="txt_field">

          <input type="text" id="username" maxlength="15" minlength="5" name="username" required />
          <label>Username</label>
        </div>

        <div class="txt_field">

          <input type="email" id="email" name="email" maxlength="30" required />
          <label>E-mail</label>
        </div>
        <div class="txt_field">

          <input type="tel" id="phonenumber" name="phonenumber" maxlength="10" minlength="10" required />
          <label>Phone Number</label>
        </div>
        <div class="txt_field">

          <input type="password" id="password" minlength="8" maxlength="20" name="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
            required />
          <label>Password</label>
        </div>

        <div id="message">
          <h3>Password must contain the following:</h3>
          <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
          <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
          <p id="number" class="invalid">A <b>number</b></p>
          <p id="length" class="invalid">Minimum <b>8 characters</b></p>
        </div>

        <div class="txt_field">

          <input type="password" id="cpassword" minlength="8" maxlength="20" name="cpassword" required />
          <label>Confirm Password</label>
        </div>
      </div>

      <div class="gender-details">
        <input type="radio" name="gender" value="Male" id="dot-1" required />
        <input type="radio" name="gender" value="Female" id="dot-2" />
        <input type="radio" name="gender" value="Nil" id="dot-3" />
        <span class="gender-title">Gender</span>
        <div class="category">
          <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender">Male</span>
          </label>
          <label for="dot-2">
            <span class="dot two"></span>
            <span class="gender">Female</span>
          </label>
          <label for="dot-3">
            <span class="dot three"></span>
            <span class="gender">Others</span>
          </label>
        </div>
      </div>

      <input type="checkbox" name="terms" id="terms" style="margin-bottom:20px;" onchange="activateButton(this)"
        required>
      <label onclick="openterms()" for="terms"> I agree the Terms & Conditions</label>


      <div class="button">
        <button id="submit" onclick=validateForm()>Sign Up</button>
      </div>
      <div class="btn2">
        <a href="login.php">Already have a account?</a>
      </div>
    </form>
  </div>
  <div id="popupterms" class="popupterms">

    <button type="button" onclick="closeterms()"><i class="fa fa-close"
        style=" color:black; font-size:24px"></i></button>

    <h3>Terms and Conditions</h3>
    <p>Welcome to PG Manager!</p>
    <p>These terms and conditions outline the rules and regulations for the use of PG Manager’s Website.</p>
    <p>By accessing this website we assume you accept these terms and conditions. Do not continue to use PG Manager if
      you do not agree to take all of the terms and conditions stated on this page.</p>
    <p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all
      Agreements: “Client”, “You” and “Your” refers to you, the person log on this website and compliant to the
      Company’s terms and conditions. “The Company”, “Ourselves”, “We”, “Our” and “Us”, refers to our Company. “Party”,
      “Parties”, or “Us”, refers to both the Client and ourselves. All terms refer to the offer, acceptance and
      consideration of payment necessary to undertake the process of our assistance to the Client in the most
      appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s
      stated services, in accordance with and subject to, prevailing law of India. Any use of the above terminology or
      other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and
      therefore as referring to same.</p>
    <h4>Cookies</h4>
    <p>We employ the use of cookies. By accessing PG Manager, you agreed to use cookies in agreement with the PG
      Manager’s Privacy Policy.</p>
    <p>Most interactive websites use cookies to let us retrieve the user’s details for each visit. Cookies are used by
      our website to enable the functionality of certain areas to make it easier for people visiting our website. Some
      of our affiliate/advertising partners may also use cookies.</p>
    <h4>License</h4>
    <p>Unless otherwise stated, PG Manager and/or its licensors own the intellectual property rights for all material on
      PG Manager. All intellectual property rights are reserved. You may access this from PG Manager for your own
      personal use subjected to restrictions set in these terms and conditions.</p>
    <p>You must not:<br>1. Republish material from PG Manager<br>2. Sell, rent or sub-license material from PG
      Manager<br>3. Reproduce, duplicate or copy material from PG Manager<br>4. Redistribute content from PG Manager</p>
    <p>This Agreement shall begin on the date hereof.</p>
    <p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain
      areas of the website. PG Manager does not filter, edit, publish or review Comments prior to their presence on the
      website. Comments do not reflect the views and opinions of PG Manager,its agents and/or affiliates. Comments
      reflect the views and opinions of the person who post their views and opinions. To the extent permitted by
      applicable laws, PG Manager shall not be liable for the Comments or for any liability, damages or expenses caused
      and/or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this website.</p>
    <p>PG Manager reserves the right to monitor all Comments and to remove any Comments which can be considered
      inappropriate, offensive or causes breach of these Terms and Conditions.</p>
    <p>You warrant and represent that:<br>1. You are entitled to post the Comments on our website and have all necessary
      licenses and consents to do so;<br>2. The Comments do not invade any intellectual property right, including
      without limitation copyright, patent or trademark of any third party;<br>3. The Comments do not contain any
      defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy<br>4. The
      Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful
      activity.</p>
    <p>You hereby grant PG Manager a non-exclusive license to use, reproduce, edit and authorize others to use,
      reproduce and edit any of your Comments in any and all forms, formats or media.</p>
  </div>


  <?php require 'footer.php' ?>
  <script>
    function validateForm() {
      let x = document.forms["myForm"]["fname"].value;
      if (x == "") {
        alert("Name must be filled out");
        return false;
      }
      else {

      }
    }

    function disableSubmit() {
      document.getElementById("submit").disabled = true;
    }

    function activateButton(element) {

      if (element.checked) {
        document.getElementById("submit").disabled = false;
      }
      else {
        document.getElementById("submit").disabled = true;
      }

    }


    var loader = document.getElementById("preloader");
    window.addEventListener("load", function () {
      preloader.style.display = "none";
    })
  </script>
  <script>
    let popupterms = document.getElementById("popupterms");

    function openterms() {
      popupterms.classList.add("open-popupterms");
    }

    function closeterms() {
      popupterms.classList.remove("open-popupterms");
    }
  </script>

</body>

</html>