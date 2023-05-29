<?php
session_start();

if (!isset($_SESSION['loggedin']) && $_SESSION['loggediin'] != true) {
    header("location: login.php");
    exit;
}
elseif ($_POST['submit']) {
    include 'dbconnect.php';
    $tableName = $_POST['pgname'];
   
    $subject = $_POST['subject'];
    
    $msg = $_POST['msg'];
   
    $pgname = preg_replace('/\s+/', '', $tableName);
    

    $sql_mail = "SELECT Email FROM $pgname";
    $res_mail = mysqli_query($conn, $sql_mail);
    $result_mail = mysqli_fetch_all($res_mail,MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notification</title>
    <?php require 'navbar.php'?>
    <link rel="stylesheet" href="notifications.css">
</head>

<body>
    <div class="center">
        <form action="notifications.php" METHOD="POST" enctype="multipart/form-data">
            <h1>Send Notification</h1>
            <div class="txt_field">
                <select name="pgname" id="pgname">
                    <?php
                    include 'dbconnect.php';
                    $user = $_SESSION['username'];
                    $existSql = "SELECT pgname FROM `addpg` WHERE `username` = '$user'";
                    $result = mysqli_query($conn, $existSql);
                    $numExistRows = mysqli_num_rows($result);
                    if ($numExistRows > 1) {
                        echo " <option value='Select PG'  hidden>Select PG </option>";
                        $sql = "SELECT pgname FROM addpg where username = '$user' ";
                        $res = mysqli_query($conn, $sql);
                        while ($pgname = mysqli_fetch_assoc($res)) {
                            echo '<option value="' . $pgname['pgname'] . '">' . $pgname['pgname'] . '</option>';
                        }
                    }
                    if ($numExistRows == 1) {

                        $sql = "SELECT pgname FROM addpg where username = '$user' ";
                        $res = mysqli_query($conn, $sql);
                        $pgname = mysqli_fetch_assoc($res);
                        echo '<option value="' . $pgname['pgname'] . '">' . $pgname['pgname'] . '</option>';
                    }
                    if ($numExistRows == 0) {
                        echo " <option value='Register Your PG' selected>Register Your PG To Data </option>";
                    }
                    ?>
                </select>
            </div>
            <div class="txt_field">
                <input type="text" name="subject" id="subject" maxlength="100" required>
                <label for="subject">Subject</label>
            </div>
            <div class="txt_field">
                <textarea name="msg" id="msg" placeholder="Message here..." cols="auto" required></textarea>
                <div class="file">
                    <label for="attach">Attachment:</label>

                    <input type="file" name="attach" id="attach">
                </div>
            </div>
            <div class="btn">
                <input type="submit" name="submit" id="submit" value="Send">
                <button type="button" onclick="window.location.href='pgmanager.php'">Cancel</button>
            </div>
        </form>
    </div>
    <?php require 'footer.php' ?>
</body>

</html>