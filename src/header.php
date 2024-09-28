<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="output.css">
	<title>Document</title>
</head>
<body>
	<div class="nav">
		<div class="logo">Name</div>
		<div class="buttons">
			<?php
				session_start();
				if (!isset($_SESSION['session_token'])) {
			?>
				<div class="sign-up">Sign Up</div>
				<div class="login">Login</div>
			<?php } else {
					require("db_config.php");
					$session_token = $_SESSION["session_token"];
					require("JobSeekerDatabase.php");
					$id = JobSeekerDatabase\getUserIdFromSessionToken($session_token);
					$image_url = JobSeekerDatabase\getUserImageUrlFromId($id);

					echo "<img src='static/images/profiles/$image_url' alt='P' height='50px'>";
			 } ?>
		</div>
	</div>
