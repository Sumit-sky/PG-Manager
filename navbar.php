<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="navbar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

</head>

</html>


<?php


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $loggedin = true;
} else {
  $loggedin = false;

}
echo '
    <div class="parent">
    <nav>
        <ul class="navbar">
            <li class="logo"><a href="Home.php"><span>PG</span> Manager</a></li>
            
            <li class="item"><a href="pgmanager.php">Manage PG</a></li>
            <li class="item"><a href="addpg.php">Register PG</a></li>
            <li class="item"><a href="contact.php">Contact</a></li>
            <li class="item"><a href="about.php">About Us</a></li>';
if (!$loggedin) {
  echo '
            <li class="item button"><a href="login.php">Login</a></li>
            <li class="item button secondary"><a href="signup.php">Sign Up</a></li>';
}

echo '

            <li class="toggle"><a href="#"><i class="fas fa-bars"></i></a></li>
            <li class="item">';
if ($loggedin) {
  require 'accsection.php';

}
echo '
            </li>
        </ul>
        


    </nav>
    </div>';


?>
<script src="navbar.js"></script>

<!-- <li class=" item has-subnavbar">
                <a tabindex="0">Rooms</a>
                <ul class="subnavbar">
                    <li class="subitem"><a href="#">Search your PG‘s</a></li>
                    <li class="subitem"><a href="#">Rent a Room</a></li>
                
                </ul>
            </li> -->