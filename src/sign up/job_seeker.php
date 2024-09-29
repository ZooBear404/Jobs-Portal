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
			<div class="title">Job Seeker</div>
			<div class="footer">
				<div class="admin-login"><a href="../login/admin.php">Admin</a></div>
				<div class="review">Review from userReview from users</div>
			</div>

		</div>
		<div class="left">
			<div class="login">
				<div class="login-button"><a href="../login/job_seeker.php">Login</a></div>
			</div>
			<div class="sign-up-form">
				<div class="sign-up-title">
					<p class="title-create-account">Create an Account</p>
				</div>
				<div>
					<form action="" method="post">
						<div class="div-first_name">
							<label for="first_name_input">First Name</label>
							<input type="text" name="first_name" id="first_name_input" required>
						</div>
						<div class="div-last_name">
							<label for="last_name_input">Last Name</label>
							<input type="text" name="last_name" id="last_name_input" required>
						</div>
						<div class="div-email">
							<label for="email_input">Email</label>
							<input type="email" name="email" id="email_input" required>
						</div>
						<div class="div-password">
							<label for="password_input">Password</label>
							<input type="password" name="password" id="password_input" required>
						</div>
						<div class="div-birth">
							<label for="date_of_birth_input">Date of Birth</label>
							<input type="date" name="birth_year">
						</div>
						<div class="gender">
							<label for="gender">Gender</label>
							<input type="radio" name="gender" value="M" id="M-input">
							<label for="M-Input">Male</label>
							<input type="radio" name="gender" value="F" id="F-input">
							<label for="F-input">Female</label>
						</div>
						<div class="div-submit">
							<input type="submit">
						</div>
						<?php
							use function JobSeekerDatabase\signUpJobSeeker;

							if ($_SERVER['REQUEST_METHOD'] == 'POST') {
								$first_name = $_POST['first_name'];
								$last_name = $_POST['last_name'];
								$email = $_POST['email'];
								$password = $_POST['password'];
								$gender = $_POST['gender'];
								$date_of_birth = $_POST['birth_year'];

								echo "<pre>
									'$first_name', '$last_name', '$email', '$password', '$gender', '$date_of_birth'
								</pre>";

								require "../database/JobSeekerDatabase.php";
								$result = JobSeekerDatabase\signUpJobSeeker($first_name, $last_name, $email, $gender, $date_of_birth, $password);
								if ($result) {
									echo "<p class='success-text'>You Successfully Signed Up</p>";
								} else {
									echo "<p class='failure-text'>Something went wrong!!!</p>";
								}

							}
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

