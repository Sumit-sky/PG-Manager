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
    <title>Manage Your PG</title>
    <?php require 'navbar.php' ?>
    <link rel="stylesheet" href="view_staff.css">
    
</head>


<body>
<div class="preloader" id="preloader"></div>
    <!--<span class="ai-android"></span><div class="searchbar">
            <form action="view_rentee.php" method="POST">
                <input id="search" name="search" type="search" placeholder="Search here...">
                <button type="submit">Search</button>
            </form>
        </div>-->
    <form action="view_staff.php" method="POST">

        <div class="selection">
            <select name="pgname" id="pgname" onchange="this.form.submit()">

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
                    $pg = $pgnam.'staff';
                
                $tableName = preg_replace('/\s+/', '', $pg);

                    
                }

                if ($numExistRows == 1) {

                    $sql = "SELECT pgname FROM addpg where username = '$user' ";
                    $res = mysqli_query($conn, $sql);
                    $pgname = mysqli_fetch_assoc($res);
                    $pgnam = $pgname['pgname'];
                    $pg = $pgnam.'staff';
                    $tableName = preg_replace('/\s+/', '', $pg);
                    
                    echo '<option value="' . $pgname['pgname'].'staff' . '">' . $pgname['pgname'] . '</option>';
                }
                if ($numExistRows == 0) {
                    echo " <option value='Register Your PG' selected>Register Your PG To Data </option>";
                }

                ?>
            </select>





        </div>

        <div class="php">

            <?php


            $db = $conn;

            $columns = [
                'profilepic',
                'Salary',
                'PGname',
                'Aadharno',
                'fullname',
                'email',
                'fathername',
                'phoneno',
                'pphoneno',
                'doj',
                'caddress',
                'address',
                'gender'
            ];

            $fetchData = fetch_data($db, $tableName, $columns);


            function fetch_data($db, $tableName, $columns)
            {
                

                
                
                
                
                if (empty($db)) {
                    $msg = "Database connection error";
                } elseif (empty($columns) || !is_array($columns)) {
                    $msg = "columns Name must be defined in an indexed array";
                } elseif (empty($tableName)) {
                    $msg = "Table is empty";
                }
                elseif ($tableName=='staff') {
                    $msg = "Table is empty";
                } else {

                    $columnName = implode(", ", $columns);

                    

                    // if ($_POST['pgname']){
                    $query = "SELECT " . $columnName . " FROM $tableName ";
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
        <div class="container11">
            <?php echo $deleteMsg ?? ''; ?>




            <?php
            if (is_array($fetchData)) {
                foreach ($fetchData as $data) {
                    ?>
                    <div class="smallcards">
                        <div class="profile7">
                            <img src=" <?php if ($data['profilepic']) {
                                echo $data['profilepic'];
                            } else {
                                echo 'images/accicon.png';
                            }
                            ''; ?>">
                        </div>
                        <div class="pgname">
                            PG Name:
                            <?php echo $data['PGname'] ?? ''; ?>
                        </div>
                        
                        <div class="doj">
                            Date of Joining:
                            <?php echo $data['doj'] ?? ''; ?>
                        </div>
                        <div class="aadhar">
                            Aadhar Number:
                            <?php echo $data['Aadharno'] ?? ''; ?>
                        </div>
                        <div class="salary">
                            Salary: Rs
                            <?php echo $data['Salary'] ?? ''; ?>
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
                        <div class="ffname">
                            Father's Name:
                            <?php echo $data['fathername'] ?? ''; ?>
                        </div>
                        <div class="pphone">
                            Alternate Mobile:
                            <?php echo $data['pphoneno'] ?? ''; ?>
                        </div>
                        <div class="caddress">
                            Communication Address:
                            <?php echo $data['caddress'] ?? ''; ?>
                        </div>
                        <div class="address">
                            Permanent Address:
                            <?php echo $data['address'] ?? ''; ?>
                        </div>
                        <div class="btn">
                            <div class="edit">
                                <form action="edit_staff.php" method="POST">
                                    <input type="hidden" name="edit_profile" value="<?php echo $data['profilepic'] ?>">
                                    <input type="hidden" name="edit_pgname" value="<?php echo $data['PGname'] ?>">
                                    <input type="hidden" name="edit_salary" value="<?php echo $data['Salary'] ?>">
                                    <input type="hidden" name="edit_doj" value="<?php echo $data['doj'] ?>">
                                    <input type="hidden" name="edit_aadharno" value="<?php echo $data['Aadharno'] ?>">
                                    <input type="hidden" name="edit_fullname" value="<?php echo $data['fullname'] ?>">
                                    <input type="hidden" name="edit_gender" value="<?php echo $data['gender'] ?>">
                                    <input type="hidden" name="edit_phoneno" value="<?php echo $data['phoneno'] ?>">
                                    <input type="hidden" name="edit_email" value="<?php echo $data['email'] ?>">
                                    <input type="hidden" name="edit_fathername" value="<?php echo $data['fathername'] ?>">
                                    <input type="hidden" name="edit_pphoneno" value="<?php echo $data['pphoneno'] ?>">
                                    <input type="hidden" name="edit_address" value="<?php echo $data['address'] ?>">
                                    <input type="hidden" name="table" value="<?php echo $tableName ?>">
                                    <button type="submit" name="edit_button">Edit</button>
                                </form>
                            </div>
                            <div class="delete">
                                <form action="del_staff.php" method="POST">
                                    <input type="hidden" name="table" value="<?php echo $tableName ?>">
                                    <input type="hidden" name="edit_aadharno" value="<?php echo $data['Aadharno'] ?>">
                                    <button type="submit" name="delbtn" onclick="cfnAction()">Delete</button>
                                </form>
                            </div>
                            <div class="salary">
                                <button type="submit">Pay Salary</button>
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
    <div id="search results"></div>

    <script>

         var loader = document.getElementById("preloader");
         window.addEventListener("load", function () {
          preloader.style.display = "none";
          })

        const cfnAction = () => {
            const response = confirm("Are you Sure ?");

            if(!response){
                event.preventDefault();
            }
            
            else {
                window.location.href = "del_rentee.php";
            }
        }

    </script>
    <?php require 'footer.php' ?>
</body>

</html>