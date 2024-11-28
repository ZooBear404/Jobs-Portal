<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/output.css">
	<title>Job Seeker Sign Up</title>
</head>
<body>
	<div class="grid w-screen h-screen grid-cols-2 overflow-hidden">
		<div class="flex flex-col justify-between p-3 text-white bg-black left">
			<div class="logo">Name</div>
			<div class="footer">
				<div class="title text-8xl">Company</div>
				<div class="review"></div>
			</div>
			
		</div>
		<div class="flex flex-col p-3 right">
			<div class="flex justify-end gap-3 login">
				<div class="login-button"><a href="../sign up/company.php">Sign up</a></div>
				<div class="job-seeker"><a href="../login/job_seeker.php">Job Seeker</a></div>
				<div class="admin-login"><a href="admin.php">Admin</a></div>
			</div>
			<div class="flex flex-col h-full sign-up-form">
				<div class="sign-up-title">
					<p class="text-3xl title-create-account">Login</p>
				</div>
					<form action="" method="post" class="flex flex-col items-center justify-center h-full gap-3">
							<div class="flex items-center gap-5 div-first_name">
								<label for="name_input">Name</label>
								<input type="text" name="name" id="name_input" class="p-2 bg-gray-300 rounded-md" required>
							</div>
							<div class="div-password">
								<label for="password_input">Password</label>
								<input type="password" name="password" id="password_input" class="p-2 bg-gray-300 rounded-md" required>
							</div>
						<div class="div-submit">
							<input type="submit" class="p-2 bg-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-400 div-submit">
						</div>
						<?php

							if ($_SERVER['REQUEST_METHOD'] == 'POST') {
								$name = $_POST['name'];
								$password = $_POST['password'];

								echo "<pre>$name, $password</pre>";

								require("../database/CompanyDatabase.php");
								$result = CompanyDatabase\loginCompany($name, $password);
								echo $result;
							}
						?>
					</form>
			</div>
		</div>
	</div>
</body>
</html>

