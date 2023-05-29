<?php
session_start();
error_reporting(E_ALL ^ E_WARNING);
if (!isset($_SESSION['loggedin']) && $_SESSION['loggediin'] != true) {
    header("location: login.php");
    exit;
} elseif ($_POST['solved']) {
    include 'dbconnect.php';
    $compid = $_POST['id'];
    $sql_sol = "SELECT id from complainpg where resolution='Pending' AND id='$compid'";
    $res_sol = mysqli_query($conn, $sql_sol);
    $rows_sol = mysqli_num_rows($res_sol);
    if ($rows_sol == 1) {
        $sql_up = "UPDATE complainpg SET resolution='Solved' WHERE id='$compid';";
        $res_up = mysqli_query($conn, $sql_up);
        echo "<script>window.alert(Status Updated!);</script>";
        if ($res_up) {
            echo "<script>window.alert('Status Updated!');</script>";
        } else {
            echo "<script>window.alert('Couldn't update status!');</script>";
        }
    } else {
        echo "<script>window.alert('Couldn't update status!');</script>";
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
            echo "<script>window.alert('Complain Deleted');</script>";
        } else {
            echo "<script>window.alert('Couldn't Delete');</script>";
        }
    } else {
        echo "<script>window.alert('Couldn't Delete!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complains From Rentee's</title>
    <?php require 'navbar.php' ?>
    <link rel="stylesheet" href="see_complains.css">
</head>

<body>
    <form action="see_complains.php" method="POST">
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
                    echo " <option value='Select PG' selected>Select PG </option>";
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
    </form>
    <div class="compsee">
        <?php
        include 'dbconnect.php';
        $columns = ['supfile','date', 'Id', 'PGname', 'fname', 'email', 'Roomno', 'Phoneno', 'note', 'Resolution'];
        $tableNam = 'complainpg';
        $fetchData = fetch_data($conn, $tableNam, $columns);
        function fetch_data($conn, $tableNam, $columns)
        {
            global $tableNam;
            global $pgnam;
            if (empty($conn)) {
                $msg = "Database connection error";
            } elseif (empty($columns) || !is_array($columns)) {
                $msg = "columns Name must be defined in an indexed array";
            } elseif (empty($tableNam)) {
                $msg = "Table is empty";
            } else {
                $columnName = implode(", ", $columns);
                $sql_complain = "SELECT " . $columnName . " FROM  $tableNam where PGname='$pgnam' AND resolution='Pending' ";
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
                <div class="compsee1">
                    <div class="date">
                        Date:
                        <?php echo $data['date'] ?? ''; ?>
                    </div>
                    <div class="room">
                        Room No:
                        <?php echo $data['Roomno'] ?? ''; ?>
                    </div>
                    <div class="name">
                        Name:
                        <?php echo $data['fname'] ?? ''; ?>
                    </div>
                    <div class="phone">
                        Mobile No:
                        <?php echo $data['Phoneno'] ?? ''; ?>
                    </div>
                    <!--<div class="email">
                            E-mail:
                            <?php echo $data['email'] ?? ''; ?>
                        </div>-->
                    <div class="co">
                        <div class="id">
                            Complain Id:
                            <?php echo $data['Id'] ?? ''; ?>
                        </div>
                        <div class="note">
                            <h3>Complain:</h3>
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
                            <b>Resolution:</b>
                            <?php echo $data['Resolution'] ?? ''; ?>
                        </div>
                    </div>
                    <form action="see_complains.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $data['Id']; ?>">
                        <input type="submit" name="solved" Value="Solved">
                        <input type="submit" name="del" onclick="confirmActin()" Value="Delete">
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
    <?php require 'footer.php'; ?>
    <script>
    const confirmActin = () => {
      const response = confirm("Are you Sure ?");

      if (!response) {
        event.preventDefault();
      }

    }


  </script>
</body>

</html>