<?php
session_start();
error_reporting(E_ALL ^ E_WARNING);
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome <?php global $username;  echo $username;?></title>
	<?php require "navbar.php" ?>
	<link rel="stylesheet" href="home.css">

	</head>

	<body>
		<div class="preloader" id="preloader"></div>
		<div class="main">

			<div class="quote">
				<h1>PG Manager™ - Manage Your Paying Guest's</h1>
				<h6>Join us today and see how PG Manager™ can transform your PG business!
				</h6>

				<button onclick="window.location.href='addpg.php'">Join Us</button>
			</div>

		</div>
		<section id="Services" class="container">
			<div class="card1">

				<button id="myBtn" type="button" onclick="openPopupteam()"
					style="border:none; background:none; padding:0px; font-size:15px; height:100%;">
					<div class="cards">
						<i class="fas fa-user-friends fa-3x"></i>
						<h3 class="Services-h3">Our Team</h3>

						<p>Passionate to make things easy for you.<br> Get to know the team behind this project.

						</p>
					</div>
				</button>
				<div id="popupteam" class="popupteam">

					<button type="button" onclick="closePopupteam()"><i class="fa fa-close"
							style="font-size:24px"></i></button>


					<h2>Our Team</h2>
					<div class="cardteam">

						<div class="bablu">

							<img src="images/team/bablu.png" alt="">
							<h2>Bablu Patel</h2>
							<p>
								Managing our Frontend to give you the best ui experience so that you can work
								flawlessly.
							</p>
						</div>
						<div class="sumit">

							<img src="images/team/sumit.jpg" alt="">
							<h2>Sumit Kumar</h2>
							<p>
								Managing our backend so that you don't have to face any issues regarding data, keeping
								it
								safe.
							</p>
						</div>
						<div class="gyani">

							<img src="images/team/gyani.jpg" alt="">
							<h2>Gyanendra Singh</h2>
							<p>
								Put his best yards to create some cool design, animations and also helping in frontend.
							</p>
						</div>

					</div>
				</div>
			</div>

			<div class="card2">
				<button id="myBtn" type="button" onclick="openPopupservices()"
					style="border:none; background:none; font-size:15px; height:100%;">
					<div class="cards">
						<i class="fas fa-tools fa-3x"></i>

						<h3 class="Services-h3">Our Services</h3>

						<p>Discover the variety of services we offer <br>which help you to manage your PG with atmost
							ease.
						</p>

					</div>
				</button>
				<div id="popupservices" class="popupservices">

					<button type="button" onclick="closePopupservices()"><i class="fa fa-close"
							style="font-size:24px"></i></button>

					<h2>Our Services</h2>
					<div class="cardservices">

					<?php
						if ($loggedin) {
							echo "

						<a href='addpg.php'>
							<div class='ourservices'>
								<i class='far fa-building' style='font-size:40px'></i>

								<h3>Register PG</h3>

								<p>
									Add your PG's for flawless management.
								</p>

							</div>
						</a>";}?>

						<a href="pgmanager.php">
							<div class="ourservices">
								<i class='far fa-building' style='font-size:40px'></i>

								<h3>Manage PG</h3>

								<p>
									Add, view, edit and delete all your paying guest.
								</p>

							</div>
						</a>

						<?php
						if (!$loggedin) {
							echo '

						<a href="login.php">
							<div class="ourservices">
							<img src="images/login.jpeg" alt="">

								<h3>Owner Login</h3>

								<p>
									Login into to your account to manage PG.
								</p>

							</div>
						</a>

						<a href="rentee_login.php">
							<div class="ourservices">
								<img src="images/accicon.png" alt="">
								

								<h3>Rentee Login</h3>

								<p>
									Login into to your account to pay rent or to complain .
								</p>

							</div>
						</a>';
						}
						?>
						<a href="complaint.php">
							<div class="ourservices">
								<img src="images/complaint.png" alt="">


								<h3>Rasie a Complaint</h3>

								<p>
									Facing issues ? Dont't worry, Tell us and we will resolve it in 24 hours.
								</p>

							</div>
						</a>
						<a href="contact.php">
							<div class="ourservices">
								<i class="fa fa-puzzle-piece" style='font-size:40px; height:40px;'></i>


								<h3>Express Integration</h3>

								<p>
									We will help you import data from books to our cloud. Just drop a mail!
								</p>

							</div>
						</a>


						<a href="#">
							<div class="ourservices">
								<img src="images/room.png" alt="">


								<h3>Room Availability</h3>

								<p>
									Check the number of rooms that can accommodate more guest.
								</p>

							</div>
						</a>




					</div>
				</div>
			</div>



			<div class="cards">
				<a href="contact.php"><i class="fas fa-headset fa-3x"></i></a>
				<a href="contact.php">
					<h3 class="Services-h3">Contact Us</h3>
				</a>
				<p>Facing issues? Found bugs?<br> Pin us and we will resolve it as early as possible.

				</p>

			</div>
		</section>

		<section id="About">
			<div class="About">
				<h1 class="About-h1">Here, You can read more about our Work</h1>
				<p class="About-p">The best application for managing your paying guest facility. Whether you run your PG
					in
					rooms, hostel
					or apartments, we've got you covered with our web applications.</p>
				<button onclick='window.location.href="about.php";'>Read More</button>
			</div>
		</section>

		<?php require 'footer.php'; ?>

		<script>
			var loader = document.getElementById("preloader");
			window.addEventListener("load", function () {
				preloader.style.display = "none";
			})
		</script>

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
			let popupservices = document.getElementById("popupservices");

			function openPopupservices() {
				popupservices.classList.add("open-popupservices");
			}

			function closePopupservices() {
				popupservices.classList.remove("open-popupservices");
			}
		</script>


	</body>

</html>