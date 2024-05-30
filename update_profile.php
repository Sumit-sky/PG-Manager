<?php

include 'dbconnect.php';
session_start();
$user_id = $_SESSION['username'];

if (isset($_POST['update_profile'])) {

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_phoneno = mysqli_real_escape_string($conn, $_POST['update_phoneno']);

   mysqli_query($conn, "UPDATE `users` SET fname = '$update_name', email = '$update_email', phonenumber='$update_phoneno' WHERE username = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, $_POST['update_pass']);
   $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
   $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_pass']);

   if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
      if (password_verify($update_pass, $old_pass) && $new_pass == $confirm_pass) {
         $hash = password_hash($new_pass, PASSWORD_DEFAULT);
         mysqli_query($conn, "UPDATE `users` SET password = '$hash' WHERE username = '$user_id'") or die('query failed');
         echo "<script>alert('Password updated');</script>";
      } elseif (!password_verify($update_pass, $old_pass)) {
         echo "<script>alert('Old password is wrong');</script>";
      } elseif ($new_pass != $confirm_pass) {
         echo "<script>alert('Passwords don't match');</script>";
      } else {
         echo "<script>alert('Passwords don't match');</script>";
      }
   } else {
      echo "<script>alert('Passwords don't match');</script>";
   }
   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'ProfilePictures/'.$update_image;

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'image is too large';
      } else {
         $image_update_query = mysqli_query($conn, "UPDATE `users` SET profilepic = '$update_image_folder' WHERE username = '$user_id'") or die('query failed');
         if ($image_update_query) {
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'Image updated succssfully!';
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
   <title>Update Profile</title>
   <?php require 'navbar.php' ?>
   <link rel="stylesheet" href="update_profile.css">

</head>

<body>

   <div class="update-profile">

      <?php
      $select = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select) > 0) {
         $fetch = mysqli_fetch_assoc($select);
      }
      ?>

      <form action="update_profile.php" method="post" enctype="multipart/form-data">
         <div class="flex">
            <div class="image">
               <?php
               if ($fetch['profilepic'] == '') {
                  echo '<img src="images/default-avatar.png">';
               } else {
                  echo '<img src="' . $fetch['profilepic'] . '">';
               }
               if (isset($message)) {
                  foreach ($message as $message) {
                     echo '<div class="message">' . $message . '</div>';
                  }
               }
               ?>
            </div>
         </div>
         <div class="txt_field">
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png">
            <label>New Picture</label>
         </div>


         <div class="user-details">


            <div class="txt_field">
               <input type="text" name="update_name" maxlength="30" minlength="3"
                  value="<?php echo $fetch['fname']; ?>">
               <label>Fullname</label>
            </div>
            <div class="txt_field">
               <input type="email" name="update_email" maxlength="30" value="<?php echo $fetch['email']; ?>">
               <label>E-mail</label>
            </div>
            <div class="txt_field">

               <input type="tel" name="update_phoneno" value="<?php echo $fetch['phonenumber']; ?>" maxlength="10"
                  minlength="10" />
               <label>Phone Number</label>
            </div>

            <div class="txt_field">
               <input type="password" name="update_pass" minlength="8" maxlength="20">
               
               <label>Old Password</label>
            </div>
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <div class="txt_field">
               <input type="password" name="new_pass" minlength="8" maxlength="20"
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
               <label>New Password</label>
            </div>
            <div class="txt_field">
               <input type="password" name="confirm_pass" minlength="8" maxlength="20">

               <label>Confirm New Password</label>
            </div>
         </div>
         <div class="button">

            <input type="submit" value="Update Profile" name="update_profile" class="btn">
            <input type="button" value="Cancel" onclick="window.location.href='home.php'">
         </div>
   </div>
   </form>
   <?php require 'footer.php' ?>
</body>

</html>