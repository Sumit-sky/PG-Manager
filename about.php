<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us</title>
    <link rel="stylesheet" href="about.css" />
    <?php require 'navbar.php' ?>

</head>

<body>
<div class="preloader" id="preloader"></div>

    <div class="hero">
        <h1>Welcome to PG Manager</h1>
    </div>
    <div class="section">
        <img src="https://images.pexels.com/photos/3184418/pexels-photo-3184418.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="image">
        <div class="content">
            <h1>Who We Are ?</h1>


            <p>The best application for managing your paying guest facility. Whether you run
                your PG in rooms, hostel or apartments, we've got you covered with our web applications.
                <br>
                PG Manager™ allows you to create and manage PG up to bed level. You can check-in inmates, collect
                payments, check bed availability, handle issues and even checkout inmates with a finger tip without
                having to worry about rent calculations, cause we will do it for you!<br>

                With PG Manager™, you can also track your PG's income and expenses, generate reports, send SMS and
                email notifications, manage staff and bookings, and list your PGs on our website.<br>
                We provide a better and efficient way to manage your PGs remotely. Everything you save is on our
                cloud. So you need not worry about losing your data ever again! <br>
            </p>
        </div>
    </div>

    <div class="section">
        <img src="https://cdn.pixabay.com/photo/2017/02/18/11/00/checklist-2077020_960_720.jpg" alt="image">
        <div class="content">
            <h1>Why Choose Us ?</h1>
            <ul>
                <li>We have a dedicated and experienced team of pg managers who are always ready to help you</li>
                <li>We have a large network of pgs across the city, so you can find the one that suits you best</li>
                <li>We have a transparent and fair pricing policy, with no hidden charges or commissions</li>
                <li>We have a flexible and hassle-free booking process, with online payment options and instant
                    confirmation</li>
                <li>We have a 24/7 customer support service, with a toll-free number and an online chat option</li>
                <li>We provide regular updates and feedback to the pg owners and tenants</li>
                <li>We will handle any complaints or queries from the pg owners or tenants</li>
            </ul>

        </div>
    </div>
    <p>We are confident that you will love our service and enjoy your stay at our pgs.</p>
    <p>We strive to deliver the best customer satisfaction and value for money for our clients.</p>


    <?php require 'footer.php' ?>

    <script>

		var loader = document.getElementById("preloader");
		window.addEventListener("load",function(){
			preloader.style.display = "none";
		})
	</script>
</body>


</html>