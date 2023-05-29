<?php
session_start();

if (!isset($_SESSION['rloggedin']) && $_SESSION['rloggediin'] != true) {
    header("location: rentee_login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php require "rentee_navbar.php" ?>
    <link rel="stylesheet" href="rentee_home.css">

</head>

<body>
    <div class="preloader" id="preloader"></div>


    <div class="php">

        <?php
        include 'dbconnect.php';

        $db = $conn;
        $table = $_SESSION['pg_name'];
        $tableName = preg_replace('/\s+/', '', $table);
        
        $columns = [
            'profilepic',
            'PGname',
            'Roomrent',
            'Roomno',
            'Aadharno',
            'fullname',
            'email',
            'fathername',
            'phoneno',
            'pphoneno',
            'doj',
            'address',
            'gender'
        ];

        $fetchData = fetch_data($db, $tableName, $columns);


        function fetch_data($db, $tableName, $columns)
        {
            $mobile_no = $_SESSION['mobile_no'];
            $aadharno = $_SESSION['aadhar_no'];
            
            if (empty($db)) {
                $msg = "Database connection error";
            } elseif (empty($columns) || !is_array($columns)) {
                $msg = "columns Name must be defined in an indexed array";
            } elseif (empty($tableName)) {
                $msg = "Table is empty";
            } else {

                $columnName = implode(", ", $columns);

                // if ($_POST['pgname']){
                $query = "SELECT " . $columnName . " FROM $tableName where aadharno ='$aadharno'";
                //}
                //elseif($_POST['search']){
                //  $searching = $_POST['search'];
                //$query = "SELECT " . $columnName . " FROM $tableName where fullname LIKE '%$searching%'";
                //}
                $result = $db->query($query);

                if ($result == true) {
                    if ($result->num_rows > 0) {
                        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $msg = $row;
                    } else {
                        $msg = "No Data Found";
                    }
                } else {
                    $msg = mysqli_error($db);
                }
            }
            return $msg;
        }
        ?>
    </div>
    </form>










    <div class="col-sm-8">
        <div class="empt"></div>
        <div class="container">
            <?php echo $deleteMsg ?? ''; ?>




            <?php
            if (is_array($fetchData)) {
                foreach ($fetchData as $data) {
                    ?>

                    <head>
                        <title>Welcome,
                            <?php echo $data['fullname'] ?? ''; ?>
                        </title>
                    </head>
                    <div class="profile">
                        <img src=" <?php if ($data['profilepic']) {
                            echo $data['profilepic'];
                        } else {
                            echo 'images/accicon.png';
                        }
                        ?>">
                        <h1>Hello,
                            <?php echo $data['fullname'] ?>
                        </h1>
                    </div>
                    <h2>Your Details</h2>
                    <div class="smallcards">
                        <div class="smallcards1">

                            <div class="pgname">
                                PG Name:
                                <?php echo $data['PGname'] ?? ''; ?>
                            </div>
                            <div class="room">
                                Room Number:
                                <?php echo $data['Roomno'] ?? ''; ?>
                            </div>
                            <div class="roomrent">
                                Rent: Rs
                                <?php echo $data['Roomrent'] ?? ''; ?>
                            </div>
                            <div class="doj">
                                Date of Joining:
                                <?php echo $data['doj'] ?? ''; ?>
                            </div>
                            <div class="ffname">
                                Father's Name:
                                <?php echo $data['fathername'] ?? ''; ?>
                            </div>
                            <div class="pphone">
                                Parent's Mobile:
                                <?php echo $data['pphoneno'] ?? ''; ?>
                            </div>
                        </div>
                        <div class="smallcards1">
                            <div class="aadhar">
                                Aadhar Number:
                                <?php echo $data['Aadharno'] ?? '';
                                $aadhar = $data['Aadharno']; ?>

                            </div>
                            <div class="fname">
                                Name:
                                <?php echo $data['fullname'] ?? ''; ?>
                            </div>
                            <div class="gender">
                                Gender:
                                <?php echo $data['gender'] ?? ''; ?>
                            </div>
                            <div class="phone">
                                Mobile Number:
                                <?php echo $data['phoneno'] ?? ''; ?>
                            </div>
                            <div class="email">
                                E-mail:
                                <?php echo $data['email'] ?? ''; ?>
                            </div>
                            <div class="address">
                                Address:
                                <?php echo $data['address'] ?? ''; ?>
                            </div>
                        </div>
                    </div>
                    <div class="btn">
                        <div class="wrong">
                            <button type="submit" onclick="openPopupteam()">Wrong Details ?</button>

                            <div id="popupteam" class="popupteam">

                                <button type="button" onclick="closePopupteam()">
                                    <i class="fa fa-close" style=" color:black; font-size:24px"></i></button>


                                <h2>Wrong Details?</h2>
                                <p>To edit deatails such as Father name, parents mobile, address ,Name<br> <br> Please Contact
                                    Your PG Manager:</p>
                                <?php

                                $sql_user = "SELECT Mobileno FROM addpg WHERE pgname='$table' ";
                                $res_user = mysqli_query($conn, $sql_user);
                                $res_pg = mysqli_fetch_assoc($res_user);
                                $res = $res_pg['Mobileno'];
                                ?>
                                <p>Call Now:
                                    <?php echo $res ?>
                                </p>
                            </div>
                        </div>
                        <div class="salary">
                            <button type="submit">Pay Rent</button>
                        </div>
                        <div class="edit">
                            <button type="submit" name="edit_button" onclick="openPopupdate()">Edit</button>

                            <div id="popupdate" class="popupdate">

                                <button type="button" onclick="closePopupdate()">
                                    <i class="fa fa-close" style=" color:black; font-size:24px"></i></button>


                                <h2>Edit Details</h2>
                                <form action="rentee_home.php" method="POST" enctype="multipart/form-data">
                                    <label for="update_profile">New Profile Pic:</label>
                                    <input type="file" id="update_profile" name="update_profile" accept="image/*">
                                    <label for="update_email">E-mail:</label>
                                    <input type="email" name="update_email" value="<?php echo $data['email'] ?>">
                                    <label for="update_phoneno">Mobile Number:</label>
                                    <input type="tel" name="update_phoneno" value="<?php echo $data['phoneno'] ?>">
                                    <input type="hidden" name="table" value="<?php echo $tableName ?>">
                                    <input type="Submit" name="update_button" Value="Save Changes">
                                </form>
                                <?php
                                if (isset($_POST['update_button'])) {
                                    $phoneno = $_POST['update_phoneno'];
                                    $tablename = $_POST['table'];
                                    $email = $_POST['update_email'];
                                    if ($_FILES['update_profile']['name']) {
                                        $profile = $_FILES['update_profile']['name'];
                                        $destination = 'ProfilePictures/'. $profile;
                                    } else {

                                        $img_sql = "SELECT profilepic FROM $tableName WHERE Aadharno ='$aadhar';";
                                        $img_res = mysqli_query($conn, $img_sql);
                                        $img = mysqli_fetch_assoc($img_res);
                                        $destination = $img['profilepic'];
                                    }
                                    $sql = "UPDATE  $tableName SET Email='$email',Phoneno='$phoneno',profilepic='$destination' WHERE Aadharno = '$aadhar';";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result) {
                                        move_uploaded_file($_FILES["update_profile"]["tmp_name"], "ProfilePictures/".$_FILES["update_profile"]["name"]);
                                        echo "<script>window.alert('Updated Successfully !'); window.location.href='rentee_home.php';</script>";

                                    } else {
                                        echo "<script>alert('Couldn't update, Try again!');</script>";
                                    }

                                } ?>
                            </div>
                        </div>

                    </div>
                    <?php
                }
            } else { ?>
                <div class="empty">
                    <div colspan="14">
                        <?php echo $fetchData; ?>
                    </div>
                    <div>
                        <?php
            } ?>
                </div>
            </div>



        </div>
    </div>
    <script>
        let popupteam = document.getElementById("popupteam");

        function openPopupteam() {
            popupteam.classList.add("open-popupteam");
        }

        function closePopupteam() {
            popupteam.classList.remove("open-popupteam");
        }
    </script>
    <script>
        let popupdate = document.getElementById("popupdate");

        function openPopupdate() {
            popupdate.classList.add("open-popupdate");
        }

        function closePopupdate() {
            popupdate.classList.remove("open-popupdate");
        }
    </script>

    <script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        })
    </script>
    <?php require 'footer.php' ?>
</body>

</html>