<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/output.css">
	<title>Job Seeker Sign Up</title>
</head>
<body>
	<div class="container grid h-screen grid-cols-2 overflow-hidden">
		<div class="flex flex-col justify-between p-3 text-white bg-black left">
			<div class="logo">Name</div>
			<div class="footer">
				<div class="title text-9xl">Job Seeker</div>
				<div class="review"></div>
			</div>
			
		</div>
		<div class="flex flex-col p-3 right">
			<div class="flex justify-end gap-3 login">
				<div class="login-button"><a href="../login/job_seeker.php">Login</a></div>
				<div class="company-login"><a href="../login/company.php">Company</a></div>
				<div class="admin-login"><a href="../login/admin.php">Admin</a></div>
			</div>
			<div class="flex flex-col h-full sign-up-form">
				<div class="sign-up-title">
					<p class="text-3xl title-create-account">Create an Account</p>
				</div>
				<form action="" method="post" class="h-full">
				
					<div class="flex flex-col justify-center h-full gap-5">
						<div class="flex flex-col gap-2">
							<div class="flex items-center gap-5 div-first_name">
								<label for="first_name_input">First Name</label>
								<input type="text" name="first_name" id="first_name_input" class="p-2 bg-gray-300 rounded-md" required>
							</div>
							<div class="div-last_name">
								<label for="last_name_input">Last Name</label>
								<input type="text" name="last_name" id="last_name_input" class="p-2 bg-gray-300 rounded-md" required>
							</div>
							<div class="div-email">
								<label for="email_input">Email</label>
								<input type="email" name="email" id="email_input" class="p-2 bg-gray-300 rounded-md" required>
							</div>
							<div class="div-password">
								<label for="password_input">Password</label>
								<input type="password" name="password" id="password_input"  class="p-2 bg-gray-300 rounded-md" required>
							</div>
							<div class="div-birth">
								<label for="date_of_birth_input">Date of Birth</label>
								<input type="date" name="birth_year" class="p-2 bg-gray-300 rounded-md">
							</div>
							<div class="gender">
								<label for="gender">Gender</label>
								<input type="radio" name="gender" value="M" id="M-input" class="p-2 bg-gray-300 rounded-md">
								<label for="M-Input">Male</label>
								<input type="radio" name="gender" value="F" id="F-input" class="p-2 bg-gray-300 rounded-md">
								<label for="F-input">Female</label>
							</div>
						</div>
						<div class="div-submit">
							<input type="submit" class="p-2 bg-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-400 div-submit">
						</div>
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
</body>
</html>

