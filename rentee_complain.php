<?php
session_start();
error_reporting(E_ALL ^ E_WARNING);
if (!isset($_SESSION['rloggedin']) && $_SESSION['rloggediin'] != true) {
    header("location: rentee_login.php");
    exit;
}

$showAlert = false;
if ($_POST['submit']) {

    include 'dbconnect.php';
    $table = $_SESSION['pg_name'];
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $room = $_POST['room'];
    $phone = $_POST['mobile'];
    $note = $_POST["note"];
    $date = date('Y-m-d H:i:s');
    $id = abs(crc32(uniqid()));
    if ($_FILES['supfile']['name']) {
        $supfile = $_FILES['supfile']['name'];
        $destination = 'complains/' . $supfile;
        $sql = "INSERT INTO `complainpg` (Id,PGname,`fname`, `email`,Roomno,Phoneno, `note`,supfile) VALUES ('$id','$table','$fname', '$email','$room','$phone', '$note','$destination')";
    } else {
        $sql = "INSERT INTO `complainpg` (Id,PGname,`fname`, `email`,Roomno,Phoneno, `note`) VALUES ('$id','$table','$fname', '$email','$room','$phone', '$note')";
    }
    $result = mysqli_query($conn, $sql);
    if ($result && $_FILES['supfile']['name']) {
        $showAlert = true;
        move_uploaded_file($_FILES["supfile"]["tmp_name"], "complains/" . $_FILES["supfile"]["name"]);
        echo "<script>alert('Complain Submitted, Relax'); window.location.href='rentee_complain.php';</script>";
    } elseif ($result) {
        $showAlert = true;
        echo "<script>alert('Complain Submitted, Relax'); window.location.href='rentee_complain.php';</script>";
    } else {
        $showAlert = false;
        echo "<script>alert('Failed');</script>";
    }

} elseif ($_POST['del']) {
    include 'dbconnect.php';
    $compid = $_POST['id'];
    $sql_sol = "SELECT id from complainpg where resolution='Pending' AND id='$compid'";
    $res_sol = mysqli_query($conn, $sql_sol);
    $rows_sol = mysqli_num_rows($res_sol);
    if ($rows_sol == 1) {
        $sql_up = "DELETE FROM complainpg WHERE id='$compid';";
        $res_up = mysqli_query($conn, $sql_up);
        if ($res_up) {
            echo "<script>window.alert('Complain Closed');</script>";
        } else {
            echo "<script>window.alert('Couldn't Close complain');</script>";
        }
    } else {
        echo "<script>window.alert('Couldn't Close complain! Try Again');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rasie a Complaint</title>
    <link rel="stylesheet" href="rentee_complain.css">
    <?php require 'rentee_navbar.php' ?>
</head>

<body>
    <div class="preloader" id="preloader"></div>
    <div class="center">
        <?php
        include 'dbconnect.php';
        $table = $_SESSION['pg_name'];
        $tableName = preg_replace('/\s+/', '', $table);

        $mobile_no = $_SESSION['mobile_no'];
        $aadharno = $_SESSION['aadhar_no'];


        $sql_user = "SELECT * FROM $tableName WHERE Aadharno='$aadharno' AND Phoneno='$mobile_no' ";
        $res_user = mysqli_query($conn, $sql_user);
        $res_pg = mysqli_fetch_assoc($res_user);

        ?>
        <form action="rentee_complain.php" id="form1" method="post" enctype="multipart/form-data">
            <div class="form-header">
                <h1>Complain</h1>
            </div>

            <div class="form">
                <div class="part1">
                    <div class="txt_field">
                        <label for="name" style="color:white;">
                            Name
                        </label>
                        <input type="text" maxlength="30" minlength="3" id="fname" name="fname"
                            value="<?php echo $res_pg['Fullname']; ?>" placeholder="" readonly>
                    </div>

                    <div class="txt_field">
                        <label for="email" style="color:white;">E-mail</label>
                        <input type="email" id="email" name="email" maxlength="30"
                            value="<?php echo $res_pg['Email']; ?>" placeholder="" readonly>
                    </div>
                </div>
                <div class="part2">
                    <div class="txt_field">
                        <label for="roomno" style="color:white;">Room No</label>
                        <input type="tel" id="room" name="room" value="<?php echo $res_pg['Roomno']; ?>" placeholder=""
                            readonly>
                    </div>
                    <div class="txt_field">
                        <label for="mobile" style="color:white;">Mobile No</label>
                        <input type="tel" id="mobile" name="mobile" maxlength="30"
                            value="<?php echo $res_pg['Phoneno']; ?>" placeholder="" readonly>
                    </div>
                </div>
            </div>
            <div class="txt_field">
                <textarea type="text" rows="10" id="note" name="note" cols="460" maxlength="300"
                    placeholder="Describe Your Issue here" required></textarea>
                <div class="txt_field1">
                    <label for="supfile" style="color:#ddd;">Supporting Document:</label>
                    <input type="file" accept="video/*,image/*" name="supfile" id="supfile" />
                </div>
            </div>



            <div class="btn"><input type="submit" name="submit" value="Submit"><input type="button"
                    onclick="window.location.href='rentee_home.php'" value="Cancel"></div>
        </form>

        <div class="compbox">

            <h2> Active Complaints</h2>
            <p></p>
            <?php
            include 'dbconnect.php';
            $columns = ['date', 'Id', 'note', 'supfile', 'Resolution'];
            $tableNam = 'complainpg';

            $fetchData = fetch_data($conn, $tableName, $columns);


            function fetch_data($conn, $tableName, $columns)
            {

                global $tableNam;

                $mobile_no = $_SESSION['mobile_no'];





                if (empty($conn)) {
                    $msg = "Database connection error";
                } elseif (empty($columns) || !is_array($columns)) {
                    $msg = "columns Name must be defined in an indexed array";
                } elseif (empty($tableNam)) {
                    $msg = "Table is empty";
                } else {
                    global $table;
                    $columnName = implode(", ", $columns);
                    $sql_complain = "SELECT " . $columnName . " FROM  $tableNam WHERE Phoneno='$mobile_no' AND resolution='Pending' AND PGname='$table' ORDER by 1 asc ";
                    $res_complain = mysqli_query($conn, $sql_complain);


                    if ($res_complain == true) {
                        if ($res_complain->num_rows > 0) {
                            $row = mysqli_fetch_all($res_complain, MYSQLI_ASSOC);
                            $msg = $row;
                        } else {
                            $msg = "No active complaints  :)";
                        }
                    } else {
                        $msg = mysqli_error($conn);
                    }
                }
                return $msg;
            }
            if (is_array($fetchData)) {
                foreach ($fetchData as $data) {
                    ?>
                    <div class="compbox1">
                        <div class="date">
                            Date:
                            <?php echo $data['date'] ?? ''; ?>
                        </div>
                        <div class="id">
                            Complain Id:
                            <?php echo $data['Id'] ?? ''; ?>
                        </div>
                        <div class="note">
                            Complain:
                            <?php echo $data['note'] ?? ''; ?>
                        </div>
                        <?php
                        if ($data['supfile']) {

                            echo "<div class='img'>
                            Document:
                                <img src=' $data[supfile]'>
                            </div>";
                        } ?>
                        <div class="resolution">
                            Resolution:
                            <?php echo $data['Resolution'] ?? ''; ?>
                        </div>
                        <form action="rentee_complain.php" id="form2" method="POST">
                            <input type="hidden" name="id" value="<?php echo $data['Id']; ?>">
                            <input type="submit" name="del" value="Close">
                        </form>
                    </div>
                    <?php
                }
            } else { ?>
                <div class="empty">
                    <div colspan="2">
                        <?php echo $fetchData; ?>
                    </div>
                    <div>
                        <?php
            }
            ?>
                </div>

            </div>
        </div>
    </div>

    <script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        })
    </script>

</body>
<?php require 'footer.php' ?>

</html>