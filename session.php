<?php
if (!isset($_SESSION['login']['status'])) {
	header('Location: login.php');
	exit;
}
?>
