<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	require("database/CompanyDatabase.php");
	require("database/AdminDatabase.php");
	require("database/JobDatabase.php");
	require("database/JobSeekerDatabase.php");
	?>
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
			function echo_signups() {
				echo '<a href="sign up/job_seeker.php"><div class="sign-up">Sign Up</div></a>
					<a href="login/job_seeker.php"><div class="login">Login</div></a>';
			}

			$type;

			session_start();
			if (!isset($_SESSION['session_token'])) {
			?>
				<a href="sign up/job_seeker.php">
					<div class="sign-up">Sign Up</div>
				</a>
				<a href="login/job_seeker.php">
					<div class="login">Login</div>
				</a>
			<?php } else {

				if ($_SESSION['type'] == 'job_seeker') {

					$type = 'job_seeker';

					require("database/db_config.php");
					$session_token = $_SESSION["session_token"];
					$id = JobSeekerDatabase\getUserIdFromSessionToken($session_token);
					$image_url = JobSeekerDatabase\getUserImageUrlFromId($id);

					echo "<img src='static/images/profiles/$image_url' alt='P' height='50px'>";
				} else if ($_SESSION["type"] == "company") {

					$type = 'company';

					require("database/db_config.php");
					$session_token = $_SESSION["session_token"];
					require("database/CompanyDatabase.php");
					$id = CompanyDatabase\getCompanyIdFromSessionToken($session_token);
					if ($id == null) {
						echo_signups();
						return;
					}
					$image_url = CompanyDatabase\getCompanyLogoFromId($id);

					echo "<img src='static/images/profiles/$image_url' alt='P' height='50px'>";
				} else if ($_SESSION["type"] = 'admin') {

					$type = 'admin';

					echo "<p>Admin</p>";
				}
			} ?>
		</div>
	</div>