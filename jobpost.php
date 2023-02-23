<?php
session_start();
include 'dbconnection.php';
include 'session.php';

$message = '';

$jobPost  = [];
$jobTypes = [];
$sql      = "select * from job_types where is_published = 1";
$result   = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
	$count = 0;
	while ($count < mysqli_num_rows($result)) {
		$row                  = mysqli_fetch_assoc($result);
		$jobTypes[$row['id']] = $row['name'];
		$count++;
	}
}

if (isset($_POST['submit'])) {
	$profile_id  = $_POST['profile_id'];
	$title       = $_POST['title'];
	$company     = $_POST['company'];
	$city        = $_POST['city'];
	$salary      = $_POST['salary'];
	$job_type    = $_POST['job_type'];
	$post_date   = $_POST['post_date'];
	$expire_date = $_POST['expire_date'];
	$description = addslashes($_POST['description']);
	$is_remote   = $_POST['is_remote'];
	$languages   = $_POST['languages'];
	$jobPostId   = $_POST['job_post_id']??null;
	
	$sql    = "select * from companies where name = '$company' LIMIT 1";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row        = mysqli_fetch_assoc($result);
		$company_id = $row['id'];
	} else {
		$sql = "INSERT INTO companies (name, is_published)
                VALUES ('$company', 1)";
		$result     = mysqli_query($con, $sql);
		$company_id = mysqli_insert_id($con);
	}

	
	$sql    = "select * from cities where name = '$city' LIMIT 1";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row     = mysqli_fetch_assoc($result);
		$city_id = $row['id'];
	} else {
		// default 1 for India
        $sql = "INSERT INTO cities (name, is_published, country_id)
                VALUES ('$city', 1, 1)";
		$result  = mysqli_query($con, $sql);
		$city_id = mysqli_insert_id($con);
	}


	if (empty($jobPostId)) {
	    $sql = "INSERT INTO job_posts (title, company_id, city_id, salary, job_type_id, post_date, expire_date, description, html_description, is_remote, profile_id, url)
                                  VALUES ('$title', $company_id, $city_id,$salary,$job_type,'$post_date','$expire_date','$description','$description',$is_remote, $profile_id,'hargharrojgar.com')";
	} else {
		$sql = "UPDATE `har_ghar_rojgar`.`job_posts` SET
`title` = '$title',
`company_id` = $company_id,
`city_id` = $city_id,
`description` = '$description',
`html_description` = '$description',
`salary` = $salary,
`is_remote` = $is_remote,
`job_type_id` = $job_type,
`post_date` = '$post_date',
`expire_date` = '$expire_date',
`profile_id` = $profile_id
WHERE `id` = $jobPostId;
";
	}

	$result = mysqli_query($con, $sql);

	if ($result) {
		echo "Records Updated..";
		header('location: jobListing.php');
	} else {
		$message = 'Error';
	}
} elseif (isset($_GET['id'])) {
	$jobPostId = $_GET['id'];
	$sql       = "SELECT job_posts.*, c.name as company_name, cd.name as city_name, jt.name as job_type_name FROM job_posts JOIN companies as c on c.id = job_posts.company_id JOIN cities as cd on cd.id = job_posts.city_id JOIN job_types as jt on jt.id = job_posts.job_type_id WHERE job_posts.id = '$jobPostId' LIMIT 1";
	
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) {
		$jobPost = mysqli_fetch_assoc($result);
	}
    if ($_SESSION['login'] && $_SESSION['login']['is_employee']
        || $_SESSION['login']['profile_id'] != $jobPost['profile_id']) {
        echo 'Error: You are not author...';
        exit;
    }
}

?>
<html lang="en">
<head>
	<style>

      *{
  box-sizing:border-box;
}
 
body {
  margin:0;
  height: 100vh;
  width: 100vw;
   overflow:scroll;
  font-family: 'Lato', sans-serif;
  font-weight: 700;
  display:flex;
  align-items: center;
  justify-content: center;
  color:#555;
 background:url("black.jpg");
}
.job-div {
  width:450px;
  height: 950px;
  padding: 65px 35px 35px 35px;
  border-radius: 25px;
  background: #ecf0f3;
  box-shadow: 8px 8px 10px #24cfaa,
              -8px -8px 10px #ffffff;
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
.title,.company,.city,.salary,.date{
  margin-bottom:30px;
  margin-top: -5px;
  border-radius: 25px;
  box-shadow: inset 8px 8px 8px #cbced1,
              inset -8px -8px 8px #D1F2EB;
}


.btn-login {
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
.btn-login:hover {
  background:#2fdbb6;
}
.btn-login:active {
  background:#1da88a;
}

.title1 {
  text-align: center;
  font-size: 40px;
  padding-top: 24px;
  margin-top: -20px;
  letter-spacing: 0.5px;
  color: #24cfaa;
}

</style>
	<title>hargharrojgar.com</title>

</head>
<body>
	
    <form method="POST" action="">
    	  
        <div class="job-div">
        	<div class="title1">Post a Job</div> 
                      	<div class="fields">
               <input type="hidden"  name="profile_id" value="<?php echo $_SESSION['login']['profile_id']??'';?>">
                <input type="hidden"  name="job_post_id" value="<?php echo $jobPost['id']??'';?>">
                <div class="title"> <input type="text"  name="title" placeholder="Title"  required value="<?php echo $jobPost['title']??'';?>"></div>
               <div class="company"> <input type="text"  name="company" placeholder="Company Name"required value="<?php echo $jobPost['company_name']??'';?>"></div>
                <div class="city"><input type="text"  name="city" placeholder="City"  required value="<?php echo $jobPost['city_name']??'';?>"><br></div>
               <div class="salary"> <input type="text"  name="salary" placeholder="Salary" required value="<?php echo $jobPost['salary']??'';?>"><br></div>
                 <div class="custom-select" style="width:200px; margin-left: 20px"></div>
                    <label>Job Type</label>
                    <select name="job_type" style="width: 300px;height: 30px;" required>
                        <option value="">Choose One</option>
<?php
foreach ($jobTypes as $id => $jobType) {
	$jobposttypeid = $jobPost['job_type_id'] == $id?'selected':false;
	if ($jobposttypeid) {
		echo "<option value='$id' selected='selected'>$jobType</option>";
	} else {
		echo "<option value='$id'>$jobType</option>";
	}
}
?>
                    </select>
                </div>
                <div class="date"> <div style="width:200px; margin-left: 20px; margin-top: 10px"></div>
                   <label>Post Date</label>
                    <input type="date" name="post_date" placeholder="Post Date" style="width: 300px"  required value="<?php echo $jobPost['post_date']??'';?>">
                </div>
                <div class="date"> <div style="width:200px; margin-left: 20px; margin-top: 10px"></div>
                    <label>End Date</label>
                    <input type="date"  name="expire_date" placeholder="Expiry Date" style="width: 300px" required value="<?php echo $jobPost['expire_date']??'';?>"><br>
                </div>
                <div class="date"> <div style="width:200px; margin-left: 20px; margin-top: 10px" ></div>
                    <label>Job Description</label>
                    <input type="text" style="width:300px;" rows="10" name="description" placeholder="Discription" required>
<?php echo $jobPost['description']??'';?>
<br>
                </div>
               <div class="date"><div style="width:200px; margin-left: 20px; margin-top: 10px"></div>
                    <label>Is Remote?</label><br>
                    <input type="radio" name="is_remote" value="1" <?php echo (isset($jobPost['is_remote']) && $jobPost['is_remote'] == 1)?'checked':'';?>><span style="margin-right: 15px">Yes</span><br>
                    <input type="radio" name="is_remote" value="0" <?php echo (isset($jobPost['is_remote']) && $jobPost['is_remote'] == 0)?'checked':'';?>><span style="margin-right: 15px">No</span>
                </div><br>
          
            <input type="submit" name="submit" value="Done" class="btn-login"><br>
         </div>
        </form>
    </div>
</div>

</body>
</html>
