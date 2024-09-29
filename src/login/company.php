<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/output.css">
	<title>Job Seeker Sign Up</title>
</head>
<body>
	<div class="container">
		<div class="right">
			<div class="logo">Name</div>
			<div class="title">Company</div>
			<div class="footer">
				<div class="admin-login"><a href="admin-login.php">Admin</a></div>
				<div class="review">Review from user</div>
			</div>

		</div>
		<div class="left">
			<div class="login">
				<div class="job-seeker"><a href="../login/job_seeker.php">Job Seeker</a></div>
				<div class="login-button"><a href="../sign up/company.php">Sign up</a></div>
			</div>
			<div class="sign-up-form">
				<div class="sign-up-title">
					<p class="title-create-account">Login</p>
				</div>
				<div>
					<form action="" method="post">
						<div class="div-first_name">
							<label for="name_input">Name</label>
							<input type="text" name="name" id="name_input" required>
						</div>
						<div class="div-password">
							<label for="password_input">Password</label>
							<input type="password" name="password" id="password_input" required>
						</div>
						<div class="div-submit">
							<input type="submit">
						</div>
						<?php

							if ($_SERVER['REQUEST_METHOD'] == 'POST') {
								$name = $_POST['name'];
								$password = $_POST['password'];

								echo "<pre>$name, $password</pre>";

								require("../CompanyDatabase.php");
								$result = CompanyDatabase\loginCompany($name, $password);
								echo $result;
							}
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

