<?php
session_start();
include 'dbconnection.php';
$message = '';
if (isset($_POST['submit'])) {
	$email    = $_POST['email'];
	$password = $_POST['password'];
	$sql      = "select * from users where email='$email' and password='$password'";
	$result   = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);

		$_SESSION['login']           = $row;
		$_SESSION['login']['status'] = true;

		header('location:home.php');
	} else {
		session_destroy();
		$message = 'Invalid login or password';
	}
}

?>
<html>
<head>
	<style>

      * {
  box-sizing: border-box;
}
body {
  margin:0;
  height: 100vh;
  width: 100vw;
  overflow: hidden;
  font-family: 'Lato', sans-serif;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  color:#555;
 background:url("black.jpg");
}
.login-div {
  width:430px;
  height: 700px;
  padding: 60px 35px 35px 35px;
  border-radius: 40px;
  background: #ecf0f3;
  box-shadow: 10px 10px 15px #24cfaa,
              -10px -10px 15px #ffffff;
   }
.logo {
  background:url("logo.jpg");
  width:100px;
  height: 100px;
  border-radius: 50%;
  margin:0 auto;
  box-shadow: 

  0px 0px 2px #5f5f5f,
 
  0px 0px 0px 5px #ecf0f3,
  
  8px 8px 15px #a7aaaf,

  -8px -8px 15px #ffffff
  ;
}
.title {
  text-align: center;
  font-size: 28px;
  padding-top: 24px;
  letter-spacing: 0.5px;
}
.sub-title {
  text-align: center;
  font-size: 15px;
  padding-top: 7px;
  letter-spacing: 3px;
}
.fields {
  width: 100%;
  padding: 75px 5px 5px 5px;
}
.fields input {
  border: none;
  outline:none;
  background: none;
  font-size: 18px;
  color: #555;
  padding:20px 10px 20px 5px;
}
.username, .password {
  margin-bottom: 30px;
  border-radius: 25px;
  box-shadow: inset 8px 8px 8px #cbced1,
              inset -8px -8px 8px #D1F2EB;
}
.fields svg {
  height: 22px;
  margin:0 10px -3px 25px;
}
.signin-button {
  outline: none;
  border:none;
  cursor: pointer;
  width:100%;
  height: 60px;
  border-radius: 30px;
  font-size: 20px;
  font-weight: 700;
  font-family: 'Lato', sans-serif;
  color:#fff;
  text-align: center;
  background: #24cfaa;
  box-shadow: 3px 3px 8px #b1b1b1,
              -3px -3px 8px #ffffff;
  transition: 0.5s;
}
.signin-button:hover {
  background:#2fdbb6;
}
.signin-button:active {
  background:#1da88a;
}
.link {
  padding-top: 20px;
  text-align: center;
}
.link a {
  text-decoration: none;
  color:#aaa;
  font-size: 15px;
}
.fields svg {
  height: 22px;
  margin:0 10px -3px 25px;
}


    </style>


</head>
<body>

  
<div class="container">
    <form method='POST' action='login.php'>
            <div class="login-div">
      <div class="logo"></div>
      <div class="title">H G R</div>
      <div class="sub-title">HarGharRojgar</div>
      <div class="fields">
        <div class="username"><input type="username" name="email" class="user-input" placeholder="Username" /></div>
        <div class="password"><input type="password" name="password" class="pass-input" placeholder="Password" /></div>
      </div>
      <button name="submit" class="signin-button">Login</button>
      <div class="link">
        Not have an acoount!<a href="registration.php">Sign up</a>
      </div>
    </div>

</body>
</html>
