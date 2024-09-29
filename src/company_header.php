<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="output.css">
	<title>Company</title>
</head>
<body>
	<div class="nav">
		<div class="logo">Name</div>
		<div class="buttons">
			<?php
				function echo_signups() {
					echo '<a href="sign up/job_seeker.php"><div class="sign-up">Sign Up</div></a>
					<a href="login/job_seeker.php"><div class="login">Login</div></a>';
				}
				session_start();
				if (!isset($_SESSION['company_session_token'])) {
					echo_signups();
			?>
			<?php } else {
					require("db_config.php");
					$session_token = $_SESSION["company_session_token"];
					require("CompanyDatabase.php");
					$id = CompanyDatabase\getCompanyIdFromSessionToken($session_token);
					if ($id == null) {
						echo_signups();
						return;
					}
					$image_url = CompanyDatabase\getCompanyLogoFromId($id);

					echo "<img src='static/images/profiles/$image_url' alt='P' height='50px'>";
			 } ?>
		</div>
	</div>
