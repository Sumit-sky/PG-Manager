<?php
session_start();


if (!isset($_SESSION['loggedin']) && $_SESSION['loggediin'] != true) {
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rentee's</title>
    <link rel="stylesheet" href="edit_staff.css">
    <?php require 'navbar.php' ?>
</head>

<body>

    <div class="preloader" id="preloader"></div>
    <div class="center">
        <form action="update_staff.php" method="post" enctype="multipart/form-data">
            <div class="form-header">

                <h1>Update Staff</h1>
            </div>

            <?php


            if (isset($_POST['edit_button'])) {
                $phoneno = $_POST['edit_phoneno'];
                $tablename = $_POST['table'];

                $query = "SELECT * FROM $tablename WHERE Phoneno= $phoneno";
                $query_run = mysqli_query($conn, $query);

                foreach ($query_run as $row) {
                    ?>



                    <div class="user-details">
                        <div class="txt_field">

                            <input type="file" id="edit_profilepic" name="edit_profilepic" accept="image/*" style="opacity:1;z-index:-1;">
                            <label for="edit_profilepic">New Picture:</label>

                        </div>

                        <div class="txt_field1" style="visibility:hidden;">
                            <input type="hidden" id="edit_pgname" name="edit_pgname" value="<?php echo $row['PGname']; ?>">
                        </div>

                        <div class="txt_field">
                            <input type="tel" id="edit_salary" step="1" pattern="\d+" name="edit_salary"
                                value="<?php echo $row['Salary'] ?>" minlength="4" maxlength="9" required>
                            <label for="edit_salary">Salary</label>
                        </div>

                        <div class="txt_field">
                            <input type="tel" id="edit_aadharno" step="1" pattern="\d+" name="edit_aadharno"
                                value="<?php echo $row['Aadharno'] ?>" minlength="12" maxlength="12" required>
                            <label for="edit_aadharno">Aadhar Number</label>
                        </div>

                        <div class="txt_field">
                            <input type="text" id="edit_fullname" maxlength="30" minlength="3" name="edit_fullname"
                                value="<?php echo $row['Fullname'] ?>" required />
                            <label>Full Name</label>
                        </div>

                        <div class="txt_field">
                            <input type="text" id="edit_fathername" maxlength="30" minlength="3" name="edit_fathername"
                                value="<?php echo $row['Fathername'] ?>" required />
                            <label>Father's Name</label>
                        </div>

                        <div class="txt_field">
                            <input type="email" id="edit_email" name="edit_email" value="<?php echo $row['Email'] ?>"
                                maxlength="30" required />
                            <label>E-mail</label>
                        </div>

                        <div class="txt_field">
                            <input type="tel" step="1" pattern="\d+" id="edit_phonenumber" name="edit_phonenumber"
                                value="<?php echo $row['Phoneno'] ?>" maxlength="10" minlength="10" required />
                            <label>Mobile Number</label>
                        </div>

                        <div class="txt_field">
                            <input type="tel" step="1" pattern="\d+" id="edit_pphonenumber" name="edit_pphonenumber"
                                value="<?php echo $row['pphoneno'] ?>" maxlength="10" minlength="10" required />
                            <label>Parent's Mobile</label>
                        </div>

                        <div class="txt_field">
                            <input type="date" id="edit_joindate" name="edit_joindate" value="<?php echo $row['DOJ'] ?>"
                                max="<?php echo date("Y-m-d"); ?>" required />
                            <label>Date of Joining</label>
                        </div>


                    </div>
                    <div class="txt_field">
                        <input type="text" id="edit_caddress" name="edit_caddress" value="<?php echo $row['Caddress'] ?>"
                            maxlength="200" minlength="20" required />
                        <label>Communication Address</label>
                    </div>
                    <div class="txt_field">
                        <input type="text" id="edit_address" name="edit_address" value="<?php echo $row['Address'] ?>"
                            maxlength="200" minlength="20" required />
                        <label>Permanent Address</label>
                    </div>


                    <div class="gender-details">
                        <input type="radio" name="edit_gender" value="Male" id="dot-1" required />
                        <input type="radio" name="edit_gender" value="Female" id="dot-2" />
                        <input type="radio" name="edit_gender" value="Nil" id="dot-3" />
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
                        <button id="submit" onclick=validateForm()>Update Data</button>
                        <button type="button" onclick="window.location.href='view_staff.php'">Cancel</button>
                    </div>



                    <?php
                }
            }

            ?>
        </form>
    </div>
    <?php require 'footer.php' ?>

    <script>
        function validateForm() {
            let x = document.forms["myForm"]["fullname"].value;
            if (x == "") {
                alert("Name must be filled out");
                return false;
            } else {

            }
        }




        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        })
    </script>
</body>

</html>