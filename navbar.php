<center>
    <marquee><b><i>website has been prepared with the objective of bringing job seekers and employers on a common platform.</b></i></marquee>
    <div class="wrapper">
        <nav class="navbar">
            <a href="home.php">
                <img class="logo" src="logo.jpeg">
            </a>
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
    </div>
</center>
