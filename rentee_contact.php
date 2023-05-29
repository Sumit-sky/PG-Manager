<?php
session_start();


if (!isset($_SESSION['rloggedin']) && $_SESSION['rloggediin'] != true) {
    header("location: rentee_login.php");
    exit;
}

$showAlert = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'dbconnect.php';
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    $note = $_POST["note"];

    $sql = "INSERT INTO `reviews` (`fname`, `email`, `note`) VALUES ('$fname', '$email', '$note')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $showAlert = true;
    } else {
        $showAlert = false;
    }

}
?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Share your Experience</title>
    <link rel="stylesheet" href="rentee_contact.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <?php require 'rentee_navbar.php' ?>
</head>

<body>
    <div class="preloader" id="preloader"></div>

    <div class="full">
        <div class="cont2">
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


            <div class="form">
                <form action="rentee_contact.php" method="post"
                    onsubmit="alert('Review Submitted Successfully! '); setTimeout(function(){window.location.reload();},700);">
                    <p>How's PG Manager? Review Now !</p>
                    <div class="input_field">
                        <label for="name"> Name :</label>
                        <input type="text" maxlength="30" minlength="3" id="fname" name="fname" value="<?php echo $res_pg['Fullname']; ?>" readonly>
                    </div>
                    <div class="input_field">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" maxlength="30"  value="<?php echo $res_pg['Email']; ?>" readonly>
                    </div>
                    <div class="input_field">
                        <label for="msg">Review :</label>
                        <textarea rows="10" id="note" name="note" cols="60" maxlength="300" placeholder="Type here..."
                            required></textarea>
                    </div>
                    <div class="btn">
                        <button type="submit" onclick="">Submit</button>




                        <!--<div class="popup" id="popup">
                            <img src="images/tick.png" alt="">
                            <h2>Thank You!</h2>
                            <p>Review Submitted Successfully</p>

                            <button type="submit" onclick="closePopup()">OK</button>


                        </div>-->
                    </div>
                </form>
            </div>
        </div>

        <div class="cont1">
            <p>Facing Issues ?</p>
            <div class="mno">
                <i style="font-size: 18px" class="fa fa-phone"></i> <a href="tel:+919467181804" target="_blank"  style="color:black"> +919467181804</a>
            </div>
            <div class="mno" style="color:black">
                <i class="fa fa-envelope"></i> <a href="mailto:yadavskyst@gmail.com" target="_blank"  style="color:black">yadavskyst@gmail.com</a>
            </div>
            <p>Meet Us</p>
            <div class="mno">
                <i class="material-icons">place</i> <a href="https://goo.gl/maps/yADY22DLK5PUDdMg9" target="_blank" style="color:black"> Cluster Innovation Centre, Delhi
                University, Delhi-110046</a>
            </div>
        </div>

    </div>
    
    
    <script>
        
        let popup = document.getElementById("popup");
        
        function openPopup() {
            popup.classList.add("open-popup");
        }
        
        function closePopup() {
            popup.classList.remove("open-popup");
        }
        
        
        
        
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function () {
            preloader.style.display = "none";
        });
        </script>
</body>
<?php require 'footer.php' ?>
</html>