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

<body class="">
	<div class="flex justify-between p-3 nav">
		<div class="text-lg font-semibold logo">Name</div>
		<div class="buttons">
			<?php

			function echo_signups() {
				echo '<div class="flex gap-2"><a href="sign up/job_seeker.php"><div class="sign-up">Sign Up</div></a>
					<a href="login/job_seeker.php"><div class="login">Login</div></a></div>';
			}

			$type;

			session_start();
			if (!isset($_SESSION['session_token'])) {
			?>
				<?php
				
				echo "<div class='flex gap-5'><a href='$path/sign up/job_seeker.php'>
					<div class='sign-up'>Sign Up</div>
				</a>";
				echo "<a href='$path/login/job_seeker.php'>
					<div class='login'>Login</div>
				</a></div>";
				?>
			<?php } else {

				if ($_SESSION['type'] == 'job_seeker') {

					$type = 'job_seeker';

					require("database/db_config.php");
					$session_token = $_SESSION["session_token"];
					$id = JobSeekerDatabase\getUserIdFromSessionToken($session_token);
					$image_url = JobSeekerDatabase\getUserImageUrlFromId($id);

					echo "<img src='/src/static/images/profiles/$image_url' alt='P' height='5rem' class='h-10'>";
				} else if ($_SESSION["type"] == "company") {

					$type = 'company';

					require("database/db_config.php");
					$session_token = $_SESSION["session_token"];
					$id = CompanyDatabase\getCompanyIdFromSessionToken($session_token);
					if ($id == null) {
						echo_signups();
						return;
					}
					$image_url = CompanyDatabase\getCompanyLogoFromId($id);

					echo "<img src='$path/static/images/profiles/$image_url' height='50px'>";
				} else if ($_SESSION["type"] = 'admin') {

					$type = 'admin';

					echo "<p>Admin</p>";
				}
			} ?>
		</div>
	</div>