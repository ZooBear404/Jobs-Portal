<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../output.css">
	<title>Job Seeker Login</title>
</head>
<body>
	<body class="grid w-screen h-screen grid-cols-2 overflow-hidden">
	
		<div class="flex flex-col justify-between p-3 bg-black left">
			<div class="text-white logo">Name</div>
			<div class="text-white footer">
				<div class="title text-9xl">Job Seeker</div>
				<div class="review">استرکچر اش جور است. دیزاین اش را هم جور کن</div>
			</div>
		</div>
		<div class="flex flex-col p-3 right">
			<div class="flex items-center justify-end gap-3 login">
				<div class="login-button"><a href="../sign up/job_seeker.php">Sign Up</a></div>
				<div class="company-sign-up"><a href="../sign up/company.php">Company</a></div>
				<div class="admin-login"><a href="admin.php" class="">Admin</a></div>
			</div>
			<div class="flex flex-col h-full sign-up-form">
				<div class="sign-up-title">
					<p class="text-3xl title-create-account">Login</p>
				</div>
			
				<form action="" method="post" class="flex flex-col items-center justify-center h-full gap-12">
					<div class="flex flex-col gap-4">
						<div class="flex items-center gap-5 div-email">
							<label for="email_input">Email</label>
							<input type="email" name="email" id="email_input" placeholder="Email address" class="p-2 bg-gray-300 rounded-md" required>
						</div>
						<div class="flex items-center gap-5 div-password">
							<label for="password_input">Password</label>
							<input type="password" name="password" id="password_input" placeholder="Password" class="p-2 bg-gray-300 rounded-md" required>
						</div>
					</div>
					<div class="p-2 bg-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-400 div-submit">
						<input type="submit">
					</div>
					<?php

						use function JobSeekerDatabase\loginJobSeeker;

						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							$email = $_POST['email'];
							$password = $_POST['password'];

							require("../database/JobSeekerDatabase.php");
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
</body>
</html>
</body>
</html>