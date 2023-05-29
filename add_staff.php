<?php
session_start();


if (!isset($_SESSION['loggedin']) && $_SESSION['loggediin'] != true) {
    header("location: login.php");
    exit;
}



$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'dbconnect.php';
    $pgname = $_POST["pgname"];
    $aadharno = $_POST["aadharno"];
    $salary = $_POST['salary'];
    $fullname = $_POST["fullname"];
    $fathername = $_POST["fathername"];
    $email = $_POST["email"];
    $phonenumber = $_POST["phonenumber"];
    $pphonenumber = $_POST["pphonenumber"];
    $joindate = $_POST["joindate"];
    $caddress = $_POST["caddress"];
    $address = $_POST["address"];
    $gender = $_POST["gender"];
    $profile = $_FILES['profilepic']['name'];
    $destination = 'ProfilePictures/' . $profile;





    $pgnam = preg_replace('/\s+/', '', $pgname);
    $staff = $pgnam . "staff";


    $existSql = "SELECT * FROM $staff WHERE `aadharno` =  '$aadharno'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);

    $existSql2 = "SELECT * FROM $staff WHERE `email` =  '$email'";
    $result2 = mysqli_query($conn, $existSql2);
    $numExistRows2 = mysqli_num_rows($result2);

    $existSql3 = "SELECT * FROM $staff WHERE `phoneno` =  '$phonenumber'";
    $result3 = mysqli_query($conn, $existSql3);
    $numExistRows3 = mysqli_num_rows($result3);

    if ($numExistRows > 0) {
        $showError = 'Aadhar Number already exists';
        echo "<script>alert('Aadhar Number already exists');</script>";
    } elseif ($numExistRows2 > 0) {
        $showError = 'Email already exists';
        echo "<script>alert('E-mail already exists');</script>";
    } elseif ($numExistRows3 > 0) {
        $showError = 'Mobile Number already exists';
        echo "<script>alert('Phone Number already exists');</script>";
    } else {
        $sql = "INSERT INTO $staff VALUES('$pgname','$salary','$aadharno','$fullname','$email','$fathername',$phonenumber,'$pphonenumber','$joindate','$caddress','$address','$gender','$destination')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            move_uploaded_file($_FILES["profilepic"]["tmp_name"], "ProfilePictures/" . $_FILES["profilepic"]["name"]);
            $showAlert = true;
            echo "<script>window.alert('Data Added Successfully !'); window.location.href='add_staff.php';</script>";
        } else {
            echo "<script>alert('Couldn't add data, Try again!');</script>";
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
    <title>Add Staff</title>
    <link rel="stylesheet" href="add_staff.css">
    <?php require 'navbar.php' ?>
</head>

<body>

    <div class="preloader" id="preloader"></div>

    <div class="center">
        <form action="add_staff.php" method="post" enctype="multipart/form-data">
            <div class="form-header">

                <h1>Add Staff</h1>
            </div>
            <div class="user-details">

                <div class="txt_field">

                    <label for="pgname"></label>
                    <select name="pgname" id="pgname">


                        <?php
                        include 'dbconnect.php';
                        $user = $_SESSION['username'];
                        $existSql = "SELECT pgname FROM `addpg` WHERE `username` = '$user'";
                        $result = mysqli_query($conn, $existSql);
                        $numExistRows = mysqli_num_rows($result);

                        if ($numExistRows > 1) {
                            echo " <option value='Select PG' hidden>Select PG </option>";
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

                    <label for="profilepic">Picture:</label>
                    <input type="file" id="profilepic" name="profilepic" accept="image/*" style="opacity:1;z-index:-1;"
                        required>

                </div>

                <div class="txt_field">
                    <input type="tel" id="aadharno" step="1" pattern="\d+" name="aadharno" minlength="12" maxlength="12"
                        required>
                    <label for="aadharno">Aadhar Number</label>
                </div>

                <div class="txt_field">
                    <input type="tel" id="salary" step="1" pattern="\d+" name="salary" minlength="4" maxlength="9" required>
                    <label for="salary">Salary</label>
                </div>


                <div class="txt_field">
                    <input type="text" id="fullname" maxlength="30" minlength="3" name="fullname" required />
                    <label>Full Name</label>
                </div>

                <div class="txt_field">
                    <input type="text" id="fathername" maxlength="30" minlength="3" name="fathername" required />
                    <label>Father's Name</label>
                </div>

                <div class="txt_field">
                    <input type="email" id="email" name="email" maxlength="30" required />
                    <label>E-mail</label>
                </div>

                <div class="txt_field">
                    <input type="tel" step="1" pattern="\d+" id="phonenumber" name="phonenumber" maxlength="10"
                        minlength="10" required />
                    <label>Mobile Number</label>
                </div>

                <div class="txt_field">
                    <input type="tel" step="1" pattern="\d+" id="pphonenumber" name="pphonenumber" maxlength="10"
                        minlength="10" required />
                    <label>Alternate Mobile</label>
                </div>

                <div class="txt_field">
                    <input type="date" id="joindate" name="joindate" max="<?php echo date("Y-m-d"); ?>" required />
                    <label>Date of Joining</label>
                </div>


            </div>
            <div class="txt_field">
                <input type="text" id="caddress" name="caddress" maxlength="200" minlength="20" required />
                <label>Communication Address</label>
            </div>

            <div class="txt_field">
                <input type="text" id="address" name="address" maxlength="200" minlength="20" required />
                <label>Permanent Address</label>
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

            <div class="button">
                <button id="submit" onclick=validateForm()>Add Data</button>
                <button type="button" onclick="window.location.href='pgmanager.php'">Cancel</button>
            </div>
            <div class="btn2">
                <a href="#">Don't have time ? No worries, We will do it for you. </a>
            </div>
        </form>
    </div>
    <?php require 'footer.php' ?>

    <script>
        function validateForm() {
            let x = document.forms["myForm"]["fullname"].value;
            if (x == "") {
                alert("Name must be filled out");
                return false;
            }
            else {

            }
        }




        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        })

    </script>
</body>

</html>