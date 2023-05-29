<?php
session_start();

if (!isset($_SESSION['loggedin']) && $_SESSION['loggediin'] != true) {
    header("location: login.php");
    exit;
}

$showAlert = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'dbconnect.php';
    $fname = $_SESSION['username'];
    $email = $_POST['email'];
    $note = $_POST["note"];
    if ($_FILES['supfile']['name']) {
        $supfile = $_FILES['supfile']['name'];
        $destination = 'complains/' . $supfile;
        $sql = "INSERT INTO `complain` (`fname`, `email`, `note`, supfile) VALUES ('$fname', '$email', '$note','$destination')";
    } else {
        $sql = "INSERT INTO `complain` (`fname`, `email`, `note`) VALUES ('$fname', '$email', '$note')";
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
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facing Issues?</title>
    <link rel="stylesheet" href="complaint.css">
    <?php require 'navbar.php' ?>
</head>

<body>
    <div class="preloader" id="preloader"></div>
    <div class="center">

        <div class="form">
            <form action="complaint.php" method="post" enctype="multipart/form-data">
                <div class="form-header">
                    <h1>Having Issues? Tell Us</h1>
                </div>

                <div class="txt_field">
                    <input type="text" maxlength="30" minlength="3" id="fname" name="fname"
                        value="<?php echo $_SESSION['username'] ?>" placeholder="" readonly>
                    <label for="name">

                    </label>
                </div>

                <div class="txt_field">
                    <input type="email" id="email" name="email" maxlength="30" placeholder="" value="<?php
                    include 'dbconnect.php';
                    $user = $_SESSION['username'];
                    $sql_find = "SELECT * FROM users where username = '$user'";
                    $res_find = mysqli_query($conn, $sql_find);
                    $row_find = mysqli_num_rows($res_find);




                    $res_data = mysqli_fetch_assoc($res_find);

                    $email_find = $res_data['email'];

                    echo $email_find;
                    ?>" readonly>
                    <label for="email">


                    </label>
                </div>
                <div class="txt_field">
                    <textarea type="text" rows="10" id="note" name="note" cols="460" maxlength="300"
                        placeholder="Describe Your Issue here" required></textarea>
                    <div class="txt_field1">
                        <label for="supfile" style="color:#ddd;">Supporting Document:</label>
                        <input type="file" accept="video/*,image/*" name="supfile" id="supfile" />
                    </div>
                </div>

                <div class="btn"><input type="submit" value="Submit"></div>
            </form>
        </div>
    </div>
    </div>

    <?php require 'footer.php' ?>
    <script>

        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        })
    </script>
</body>

</html>