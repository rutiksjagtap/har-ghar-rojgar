<?php
session_start();
include 'dbconnection.php';
if (isset($_POST['submit'])) {
	$name       = $_POST['name'];
	$email      = $_POST['email'];
	$password   = $_POST['password'];
	$recruiter  = $_POST['is_recruiter']?0:1;
	$today      = date("Y-m-d");
	$sql        = "INSERT INTO profiles (first_name, last_name, middle_name, degree_type_id, date_of_birth, mobile_no) VALUES ('$name', '$name', '$name', 1, '$today', '7889')";
	$profile    = mysqli_query($con, $sql);
	$profile_id = mysqli_insert_id($con);
	if ($profile_id) {
		$sql    = "INSERT INTO users (email, password, is_employee, profile_id) VALUES ('$email','$password', $recruiter, $profile_id)";
		$result = mysqli_query($con, $sql);
		if ($result) {
			echo "Records added successfully.";
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
		} else {
			echo "ERROR: Could not able to execute";
		}
	} else {
		echo "ERROR: Could not able to execute";
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
.reg-div {
  width:430px;
  height: 700px;
  padding: 60px 35px 35px 35px;
  border-radius: 40px;
  background: #ecf0f3;
  box-shadow: 10px 10px 15px #24cfaa,
              -10px -10px 15px #ffffff;
}

.title {
  text-align: center;
  font-size: 40px;
  padding-top: 24px;
  letter-spacing: 0.5px;
  color: #24cfaa;
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
.name,.email,.password {
  margin-bottom: 30px;
  border-radius: 25px;
  box-shadow: inset 8px 8px 8px #cbced1,
              inset -8px -8px 8px #D1F2EB;
}
.fields svg {
  height: 22px;
  margin:0 10px -3px 25px;
}
.register-button {
  outline: none;
  border: none;
  margin-top: 70px;
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
.register-button:hover {
  background:#2fdbb6;
}
.register-button:active {
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
    <form method="POST" action="registration.php">
            <div class="reg-div">
     <div class="title">Registration</div>    
      <div class="fields">
        <div class="name"><input type="text" name="name"class="user-input" placeholder="Enter Name" /></div>
        <div class="email"><input type="text" name="email"class="email-input" placeholder="Enter Email" /></div>
        <div class="password"><input type="password" name="password" class="pass-input" placeholder="Create Password" /></div>
            <lable class="lable">Who you are?</lable>
            <input type="radio" name="is_recruiter" value="1"><span style="margin-right: 15px">Recruiter</span>
            <input type="radio" name="is_recruiter" value="0"><span style="margin-right: 15px">Job Seeker</span>
      </div>
      <button name="submit" value="Register" class="register-button">Register</button>
      <div class="link">
        Already have an account! <a href="login.php">LOGIN</a>
      </div>
    </div></div>

</body>
</html>
