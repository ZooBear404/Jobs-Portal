<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../output.css">
	<title>Job Seeker Sign Up</title>
</head>
<body class="grid w-screen h-screen grid-cols-2 overflow-hidden">
	
	<div class="flex flex-col justify-between p-3 text-white bg-black left">
		<div class="logo">Name</div>
		<div class="footer">
			<div class="text-9xl title">Admin</div>
			<div class="review">Review from user</div>
		</div>
		
	</div>
	<div class="flex flex-col p-3 right">
		<div class="flex justify-end gap-3 login">
			<div class="job-seeker"><a href="../login/job_seeker.php">Job Seeker</a></div>
			<div class="admin-login"><a href="company.php">Company Login</a></div>
			<div class="login-button"><a href="../sign up/company.php">Company Sign up</a></div>
		</div>
		<div class="flex flex-col h-full sign-up-form">
			<div class="sign-up-title">
				<p class="text-3xl title-create-account">Login</p>
			</div>

			<form action="" method="post" class="flex flex-col justify-center h-full gap-3">
				<div class="flex items-center gap-5 div-first_name">
					<label for="email_input">Email</label>
					<input type="text" name="email" id="email_input" class="p-2 bg-gray-300 rounded-md" required>
				</div>
				<div class="flex items-center gap-5 div-password">
					<label for="password_input">Password</label>
					<input type="password" name="password" id="password_input" class="p-2 bg-gray-300 rounded-md" required>
				</div>
				<div class="p-2 bg-gray-200 rounded-md w-44 hover:bg-gray-300 active:bg-gray-400 div-submit">
					<input type="submit">
				</div>
				<?php

					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$email = $_POST['email'];
						$password = $_POST['password'];

						require("../database/AdminDatabase.php");

						$result = AdminDatabase\loginAdmin($email, $password);
						echo $result;
					}
				?>
			</form>

		</div>
	</div>

</body>
</html>

