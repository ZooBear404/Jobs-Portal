<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/output.css">
	<title>Job Seeker Sign Up</title>
</head>
<body class="grid w-screen h-screen grid-cols-2 overflow-hidden">
		<div class="flex flex-col justify-between p-3 text-white bg-black left">
			<div class="logo">Name</div>
			<div class="footer">
				<div class="title text-8xl">Company</div>
				<div class="review"></div>
			</div>
			
		</div>
		<div class="flex flex-col p-3 overflow-y-auto right">
			<div class="flex justify-end gap-3 login">
				<div class="login-button"><a href="../login/company.php">Login</a></div>
				<div class="job-seeker"><a href="../sign up/job_seeker.php">Job Seeker</a></div>
				<div class="admin-login"><a href="../login/admin.php">Admin</a></div>
			</div>
			<div class="flex flex-col sign-up-form">
				<div class="sign-up-title">
					<p class="text-3xl title-create-account">Create an Account</p>
				</div>
				<div>
					<form action="" method="post" enctype="multipart/form-data" class="flex flex-col justify-center h-full gap-3">
						<div class="flex items-center gap-5 div-first_name">
							<label for="name_input">Name</label>
							<input type="text" name="company_name" id="name_input" class="p-2 bg-gray-300 rounded-md" required>
						</div>
						<div class="flex items-center gap-5 div-last_name">
							<label for="company_type">Company Type</label>
							<select name="company_type" id="company_type" class="p-2 bg-gray-300 rounded-md">
								<?php
								use function CompanyDatabase\getCompanyTypes;
									require("../database/CompanyDatabase.php");
									$rows = CompanyDatabase\getCompanyTypes();
									foreach ($rows as $row) {
										$company_type_id = $row["company_type_id"];
										$name = $row["name"];
										echo "<option value=$company_type_id>$name</option>";
									}
								?>

							</select>
						</div>
						<div class="flex items-center gap-5 div-password">
							<label for="password_input">Password</label>
							<input type="password" name="password" id="password_input" class="p-2 bg-gray-300 rounded-md" required>
						</div>
						<div class="flex items-center gap-5 div-industry-type">
							<label for="industry_type">Industry Type</label>
							<select name="industry_type" id="industry_type" class="p-2 bg-gray-300 rounded-md">
								<?php
									$rows = CompanyDatabase\getIndustryTypes();
									foreach ($rows as $row) {
										$industry_type_id = $row["industry_type_id"];
										$name = $row["name"];
										echo "<option value=$industry_type_id>$name</option>";
									}
								?>
							</select>
						</div>
						<div class="flex items-center gap-5 div-country">
							<label for="country_input">Country</label>
							<select name="country" id="country" class="p-2 bg-gray-300 rounded-md">
								<?php
									$rows = CompanyDatabase\getCountries();
									foreach ($rows as $row) {
										$country_id = $row["country_id"];
										$name = $row["name"];
										echo "<option value=$country_id>$name</option>";
									}
								?>
							</select>
						</div>
						<div class="flex items-center gap-5 div-state">
							<label for="state_input">State</label>
							<select name="state" id="state" class="p-2 bg-gray-300 rounded-md">
								<?php
									$rows = CompanyDatabase\getStates();
									foreach ($rows as $row) {
										$state_id = $row['state_id'];
										$name = $row['name'];
										echo "<option value=$state_id>$name</option>";
									}
								?>
							</select>
						</div>
						<div class="flex items-center gap-5 div-founded-year">
							<label for="founded_year">Founded In</label>
							<input type="number" name="founded_year" id="founded_year" min="flex flex-col p-3 overflow-y-auto" class="p-2 bg-gray-300 rounded-md">
						</div>
						<div class="flex items-center gap-5 div-website">
							<label for="website">Website Link</label>
							<input type="url" name="website" id="website" class="p-2 bg-gray-300 rounded-md">
						</div>
						<div class="flex items-center gap-5 div-address">
							<label for="address">Address</label>
							<input type="text" name="address" id="address" class="p-2 bg-gray-300 rounded-md">
						</div>
						<div class="flex items-center gap-5 div-description">
							<label for="description">Description</label>
							<textarea name="description" id="description" cols="30" rows="10" class="p-2 bg-gray-300 rounded-md"></textarea>
						</div>
						<div class="flex items-center gap-5 div-logo">
							<label for="logo">Logo</label>
							<input type="file" name="logo" id="logo" accept="image/png, image/jpeg" class="p-2 bg-gray-300 rounded-md">
						</div>
						<div class="p-2 bg-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-400 div-submit">
							<input type="submit">
						</div>
						<?php

							if ($_SERVER['REQUEST_METHOD'] == 'POST') {
								$name = $_POST['company_name'];
								$company_type_id = $_POST['company_type'];
								$password = $_POST['password'];
								$industry_type_id = $_POST['industry_type'];
								$country_id = $_POST['country'];
								$state_id = $_POST['state'];
								$founded_year = $_POST['founded_year'];
								$website = $_POST['website'];
								$address = $_POST['address'];
								$description = $_POST['description'];
								$logo = $_FILES['logo'];

								echo "<pre>
									$name, $company_type_id, $password, $industry_type_id, $country_id, $state_id, $founded_year, $website, $address, $description, $logo
								</pre>";

								$result = CompanyDatabase\signUpCompany($name, $company_type_id, $password, $industry_type_id, $country_id, $state_id, $founded_year, $website, $address, $description, $logo); 
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

