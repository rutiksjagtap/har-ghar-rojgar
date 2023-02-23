<?php
session_start();

?>
<html lang="en" lang="hi">
<head>
	<title>hargharrojgar.com</title>
	<link rel="stylesheet" href="home.css">
</head>
<body>
	<marquee><b><i>website has been prepared with the objective of bringing job seekers and employers on a common platform.</b></i></marquee>
	<div class="wrapper">
			<nav class="navbar">
			<a href="home.php">
			<img class="logo" src="logo.jpeg">
			<ul>
				<li><a class="active" href="home.php">Home</a></li>
				<li><a href="about.html">About</a></li>
				<li><a href="jobListing.php">Jobs</a></li>
				<li><a href="contact.html">Contact</a></li>
                <li>
<?php
if (isset($_SESSION['login']['status'])) {
	echo '<a href="logout.php">Logout</a>';
}
?>
</li>
			</ul>
			</nav>
			<div class="center">
			<h1>HAR &nbsp;GHAR<h1 style="color:#927768">रोजगार</h1></h1>
			<h2><u>Chalo,Kuchh Kaam Kare</u></h2>
<?php
if (!isset($_SESSION['login']['status'])) {?>
	<a href="login.php">
				            				<div class="buttons">
				            					<button>Get Started>></button>
				            				</div>
				            	            </a>
	<?php }?>
</div>
</body>
</html>

  