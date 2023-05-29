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


if (isset($_SESSION['rloggedin']) && $_SESSION['rloggedin'] == true) {
  $rloggedin = true;
} else {
  $rloggedin = false;

}
echo '
    <div class="parent">
    <nav>
        <ul class="navbar">
            <li class="logo"><a href="rentee_home.php"><span>PG</span> Manager</a></li>
            <li class="item"><a href="rentee_home.php">Home</a></li>
            <li class="item"><a href="rentee_complain.php">Complain</a></li>
            <li class="item"><a href="rentee_contact.php">Contact</a></li>';
            if ($rloggedin) {
              echo '<li class="item button"><a href="rentee_logout.php">Logout</a></li>';
              
            
            }
            

echo '

            <li class="toggle"><a href="#"><i class="fas fa-bars"></i></a></li>
            <li class="item">';
           
echo '
            </li>
        </ul>
        


    </nav>
    </div>';


?>
<script src="navbar.js"></script>