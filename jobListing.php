<?php
session_start();
include 'dbconnection.php';
include 'session.php';
$query  = $con->query('SELECT * FROM job_posts JOIN companies as c on c.id = job_posts.company_id');
$result = "SELECT job_posts.*, c.name as company_name, cd.name as city_name, jt.name as job_type_name 
FROM job_posts 
JOIN companies as c on c.id = job_posts.company_id 
JOIN cities as cd on cd.id = job_posts.city_id 
JOIN job_types as jt on jt.id = job_posts.job_type_id";
$result = mysqli_query($con, $result);

?>
<html>
<head>
    <link rel="stylesheet" href="jobListing.css">
    <script>
function myFunction() {

  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("jobs");
  tr = table.getElementsByTagName("tr");

 
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</head>
<body>
<?php include 'navbar.php';?>
<div class="container">
<?php if ($_SESSION['login'] && !$_SESSION['login']['is_employee']) {?>
	<a href="jobpost.php" style="float: right; padding-bottom: 15px"><strong>Create New<strong></a>
	<?php }?>
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search job by name..">
<table border ="2" id="jobs">
    <tr class="header">
    <th>Title</th>
    <th>Company</th>
    <th>City</th>
    <th>Salary</th>
    <th>Is remote ?</th>
    <th>Job Type</th>
    <th>Post date</th>
    <th>Expire date</th>
    <th>URL</th>
	<th colspan="2">Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) {
	?>
    <tr>
        <td><?php echo $row['title'];?></td>
        <td><?php echo $row['company_name'];?></td>
        <td><?php echo $row['city_name'];?></td>
        <td><?php echo $row['salary'];?></td>
        <td><?php echo $row['is_remote']?'Yes':'No';?></td>
        <td><?php echo $row['job_type_name'];?></td>
        <td><?php echo $row['post_date'];?></td>
        <td><?php echo $row['expire_date'];?></td>
        <td><?php echo $row['url'];?></td>
        <td><a href="jobview.php?id=<?php echo $row['id'];?>">View</a></td>
        <?php
            if ($_SESSION['login'] && !$_SESSION['login']['is_employee']
            && $_SESSION['login']['profile_id'] == $row['profile_id']) {?>
            <td><a href="jobpost.php?id=<?php echo $row['id'];?>">Edit</a></td><?php }
        ?>
	</tr>
	<?php }?>
</table>
</div>
</body>
</html>
