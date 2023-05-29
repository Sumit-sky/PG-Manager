<?php
session_start();

if (!isset($_SESSION['loggedin']) && $_SESSION['loggediin'] != true) {
    header("location: login.php");
    exit;
}

include 'dbconnect.php';
$user = $_SESSION['username'];
$existSql = "SELECT PGname FROM `addpg` WHERE `username` =  '$user'";
$result = mysqli_query($conn, $existSql);
$numExistRows = mysqli_num_rows($result);




if ($numExistRows == 0) {
    header("location:addpg.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Your PG</title>

    <link rel="stylesheet" href="pgmanager.css">
    <?php require 'navbar.php' ?>
</head>

<body>
    <div class="preloader" id="preloader"></div>
    <div class="container1">
        <div class="main">

            <a href="add_rentee.php">
                <div class="content1">
                    <h2>Add Rentee's </h2>
                </div>
            </a>
            <a href="view_rentee.php">
                <div class="content2">
                    <h2>Manage Rentee's</h2>
                </div>
            </a>

            <a href="add_staff.php">
                <div class="content5">
                    <h2>Add Staff</h2>
                </div>
            </a>

            <a href="view_staff.php">
                <div class="content6">
                    <h2>Manage Staff</h2>
                </div>
            </a>
            <a href="see_complains.php">
                <div class="content3">
                    <h2>Check Complains</h2>
                </div>
            </a>

            <a href="notifications.php">
                <div class="content7">
                    <h2>Send Notifications</h2>
                </div>
            </a>
            <a href="#">
                <div class="content8">
                    <h2>Check Room Availability</h2>
                </div>
            </a>

            <div class="card">
                <button id="myBtn" type="button" onclick="openPopupdel()"
                    style="border:none; background:none; padding:0px; font-size:15px; height:100%;">
                    <div class="content4">
                        <h2>Delete PG's</h2>
                    </div>
                </button>
                <div id="popupdel" class="popupdel">

                    <button type="button" onclick="closePopupdel()">
                        <i class="fa fa-close" style=" color:white; font-size:24px"></i></button>


                    <h2>Delete PG's</h2>



                    <form action="del_pg.php" method="POST">

                        <div class="selection">
                            <select name="pgname" id="pgname">

                                <?php
                                include 'dbconnect.php';

                                $user = $_SESSION['username'];
                                $existSql = "SELECT pgname FROM `addpg` WHERE `username` = '$user'";
                                $result = mysqli_query($conn, $existSql);
                                $numExistRows = mysqli_num_rows($result);
                                //$searching = $_POST['search'];
                                //      echo $searching;
                                

                                if ($numExistRows > 1) {

                                    echo " <option value='Select PG' hidden selected>Select PG </option>";
                                    $sql = "SELECT pgname FROM addpg where username = '$user' ";
                                    $res = mysqli_query($conn, $sql);


                                    while ($pgname = mysqli_fetch_assoc($res)) {

                                        echo '<option value="' . $pgname['pgname'] . '">' . $pgname['pgname'] . '</option>';
                                    }

                                    $pgnam = $_POST['pgname'];

                                    $tableName = preg_replace('/\s+/', '', $pgnam);
                                }

                                if ($numExistRows == 1) {

                                    $sql = "SELECT pgname FROM addpg where username = '$user' ";
                                    $res = mysqli_query($conn, $sql);
                                    $pgname = mysqli_fetch_assoc($res);
                                    $pgnam = $pgname['pgname'];
                                    $tableName = preg_replace('/\s+/', '', $pgnam);
                                    echo '<option value="' . $pgname['pgname'] . '">' . $pgname['pgname'] . '</option>';
                                }
                                if ($numExistRows == 0) {
                                    echo " <option value='Register Your PG' selected>Register Your PG To Data </option>";
                                }

                                ?>
                            </select>
                        </div>
                        <div class="btn">

                            <button type="submit" name="delbtn" onclick="confirAction()">Delete</button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let popupdel = document.getElementById("popupdel");

        function openPopupdel() {
            popupdel.classList.add("open-popupdel");
        }

        function closePopupdel() {
            popupdel.classList.remove("open-popupdel");
        }
    </script>
    <script>

        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        })
    </script>

    <script>
        const confirAction = () => {
            const response = confirm("All your data we be lost and can't be recovered. Are you Sure ?");

            if(!response){
                event.preventDefault();
            }
            
            else {
                window.location.href = "del_rentee.php";
            }

        }

    </script>


    <?php require 'footer.php'; ?>
</body>

</html>