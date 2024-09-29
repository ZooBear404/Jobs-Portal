<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../output.css">
	<title>Job Seeker Login</title>
</head>
<body>
	<body>
	<div class="container">
		<div class="right">
			<div class="logo">Name</div>
			<div class="title">Job Seeker</div>
			<div class="footer">
				<div class="admin-login"><a href="admin.php">Admin</a></div>
				<div class="review">Review from userReview from users</div>
			</div>

		</div>
		<div class="left">
			<div class="login">
				<div class="login-button"><a href="../sign up/job_seeker.php">Sign Up</a></div>
			</div>
			<div class="sign-up-form">
				<div class="sign-up-title">
					<p class="title-create-account">Login</p>
				</div>
				<div>
					<form action="" method="post">
						<div class="div-email">
							<label for="email_input">Email</label>
							<input type="email" name="email" id="email_input" required>
						</div>
						<div class="div-password">
							<label for="password_input">Password</label>
							<input type="password" name="password" id="password_input" required>
						</div>
						<div class="div-submit">
							<input type="submit">
						</div>
						<?php

							use function JobSeekerDatabase\loginJobSeeker;

							if ($_SERVER['REQUEST_METHOD'] == 'POST') {
								$email = $_POST['email'];
								$password = $_POST['password'];

								require("../JobSeekerDatabase.php");
								$result = loginJobSeeker($email, $password);
								if ($result[0] == 1) {
									echo "<p class='failure'>Email not found!!!</p>";
								} else if ($result[0] == 2) {
									echo "<p class='failure'>Update went wrong</p>";
								} else if ($result[0] == 3) {
									echo "<p class='failure'>Creating session went wrong</p>";
								} else if ($result[0] == 4) {
									echo "<p class='failure'>Error finding user</p>";
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
</body>
</html>