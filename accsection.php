<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
    crossorigin="anonymous" />
  <link href="accsection.css" rel="stylesheet" />
</head>
<?php
include 'dbconnect.php';
$username = $_SESSION['username'];
$existSql = "SELECT profilepic FROM `users` WHERE `username` =  '$username'";
$result = mysqli_query($conn, $existSql);
$numExistRows = mysqli_num_rows($result);
if ($numExistRows == 1) {
  $row = mysqli_fetch_assoc($result);
  if ($row['profilepic']) {
    $destination = $row['profilepic'];
  } else {
    $destination = 'images/accicon.png';
  }
} else {
  $destination = 'images/accicon.png';
}

?>

<body>
  <div class="action" id="action">
    <div class="profile1" onclick="menuToggle();">
      <img src="<?php echo $destination ?>" />
    </div>
    <div class="menu" id="menu">
      <div class="pop">
        <button type="button" onclick="openPopupt()">
          <?php echo $_SESSION['username'] ?>
        </button>
        <div id="popupt" class="popupt">

          <button type="button" onclick="closePopupt()">
            <i class="fa fa-close" style=" color:white; font-size:24px"></i></button>


          <div class="container">

            <div class="profile">
              <?php
              include 'dbconnect.php';
              $user = $_SESSION['username'];
              $select = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$user'");
              if (mysqli_num_rows($select) > 0) {
                $fetch = mysqli_fetch_assoc($select);
              }
              if ($fetch['profilepic'] == '') {
                echo '<img src="images/default-avatar.png">';
              } else {
                echo '<img src="' . $fetch['profilepic'] . '">';
              }
              ?>
              <h3>
                <?php echo $fetch['fname']; ?>
              </h3>
              <h3>
                <?php echo $fetch['email']; ?>
              </h3>
              <h3>
                <?php echo $fetch['phonenumber']; ?>
              </h3>
              <div class="but">
                <a href="update_profile.php" class="btn">Update Profile</a>
                <a href="logout.php" class="delete-btn">Logout</a>
              </div>
            </div>

          </div>
        </div>
      </div>
      <ul>
        <li>
          <a href="#">Buy Premium</a>
        </li>

        <li>
          <a href="addpg.php">Register New PG </a>
        </li>

        <li><a href="complaint.php">Facing Issues?</a></li>

        <li>
          <button style="outline: none; background: none; border: none; padding-left: 0px; font-size:17px;"
            onclick="confirmAction()">
            <a href="#">Delete Account</a>
          </button>
        </li>

        <li>
          <a href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
  </div>
  <script>

    function menuToggle() {
      const toggleMenu = document.getElementById("menu");
      toggleMenu.classList.toggle("active");
    }

    const confirmAction = () => {
      const response = confirm("This will delete all your data and account information from our cloud. Are you Sure ?");

      if (!response) {
        event.preventDefault();
      }

      else {
        window.location.href = "delacc.php";
      }

    }


  </script>
  <script>
    let popupt = document.getElementById("popupt");

    function openPopupt() {
      popupt.classList.add("open-popupt");
    }

    function closePopupt() {
      popupt.classList.remove("open-popupt");
    }
  </script>

</body>

</html>