<?php

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
	
	require_once "dbconnection.php";

	
    $sql = "SELECT jp.*, c.name as company_name, cd.name as city_name, jt.name as job_type_name, u.email
            FROM job_posts as jp
            JOIN companies as c on c.id = jp.company_id 
            JOIN cities as cd on cd.id = jp.city_id 
            JOIN job_types as jt on jt.id = jp.job_type_id
            JOIN profiles as p on p.id = jp.profile_id
            JOIN users as u  on u.profile_id = p.id
            WHERE jp.id = ?";

	if ($stmt = mysqli_prepare($con, $sql)) {
		
		mysqli_stmt_bind_param($stmt, "i", $param_id);

		
		$param_id = trim($_GET["id"]);

		
		if (mysqli_stmt_execute($stmt)) {
			$result = mysqli_stmt_get_result($stmt);

			if (mysqli_num_rows($result) == 1) {
				
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
			} else {
				
				header("location: error.php");
				exit();
			}

		} else {
			echo "Oops! Something went wrong. Please try again later.";
		}
	}

	
	mysqli_stmt_close($stmt);

	
	mysqli_close($con);
} else {
	
	header("location: error.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3"><?php echo $row["title"];?></h1>
                    <div class="form-group">
                        <label>Title</label>
                        <p><b><?php echo $row["title"];?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Company</label>
                        <p><b><?php echo $row["company_name"];?></b></p>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <p><b><?php echo $row["city_name"];?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <p><b><?php echo $row["description"];?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Job Type</label>
                        <p><b><?php echo $row["job_type_name"];?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p><b><?php echo $row["salary"] . ' INR per month';?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Contact email</label>
                        <p><b><?php echo $row["email"];?></b></p>
                        
                        <p> *NOTE: Please send request on mentioned email id for applying this job application.</p>
                    </div>
                    <p><a href="jobListing.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
