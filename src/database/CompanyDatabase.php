<?php

namespace CompanyDatabase;

function signUpCompany($name, $company_type_id, $password, $industry_type, $country_id, $state_id, $founded_year, $website, $address, $description, $logo) {
	$hashed_password = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 1]);
	require("db_config.php");
	$sql = "INSERT INTO company(name, company_type_id, industry_type_id, country_id, state_id, founded_year, website, address, description, password) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$result = $con->execute_query($sql, [$name, $company_type_id,
				$industry_type, $country_id, $state_id, $founded_year, $website, $address, $description, $hashed_password]);
	if (!$result) {
		return false;
	}

	if ($logo == null) {
		return true;
	}

	$sql = "SELECT * FROM company WHERE name = ?";
	$result = $con->execute_query($sql, [$name]);
	$company_id = $result->fetch_row()[0];

	$sql = "INSERT INTO company_logo(company_id, cover_image_path) VALUES(?, ?);";
	$result = $con->execute_query($sql, [$company_id, $logo['name']]);
	if (!$result) {
		return false;
	}

	$target_path = "static/images/profiles/";
	$target_path = $target_path . basename($logo['name']);
	
	echo $target_path;

	if (move_uploaded_file($logo['tmp_name'], $target_path)) {
		echo "file moved";
	} else {
		echo "error moving file";
	}

	return true;
}

function loginCompany($name, $password) {
	require("db_config.php");

	$find_company_sql = "SELECT password, company_id FROM company WHERE name = ?";
	$result = $con->execute_query($find_company_sql, [$name]);
	if ($result->num_rows > 1) {
		return "Error finding company";
	} else if ($result->num_rows == 0) {
		return "Company not found";
	}

	$fetched = $result->fetch_assoc();
	$company_password = $fetched['password'];
	$verify = password_verify($password, $company_password);
	if (!$verify) {
		return "Passwords don't match";
	}

	$company_id = $fetched["company_id"];

	$sql = "UPDATE company_login_session SET is_active = false WHERE company_id = ?";
	$result = $con->execute_query($sql, [$company_id]);

	$session_token = bin2hex(random_bytes(100));
	$today = date('Y-m-d');
	$expiration_date = date('Y-m-d', strtotime($today . '10 days'));

	$sql = "INSERT INTO company_login_session(company_id, session_token, session_expiration) VALUES(?, ?, ?)";
	$result = $con->execute_query($sql, [$company_id, $session_token, $expiration_date]);
	if (!$result) {
		return "Could not create session";
	}


	session_start();
	$_SESSION['session_token'] = $session_token;
	$_SESSION['type'] = 'company';

	header("location: ../index.php");


	return "Successfully created session";
}

function getCompanyTypes() {
	require("db_config.php");
	$sql = "SELECT company_type_id, name FROM company_type;";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getIndustryTypes() {
	require("db_config.php");
	$sql = "SELECT industry_type_id, name FROM industry_type";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getCountries() {
	require("db_config.php");
	$sql = "SELECT country_id, name FROM country;";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getStates() {
	require("db_config.php");
	$sql = "SELECT state_id, name FROM state";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getCompanyIdFromSessionToken($session_token) {
	$sql = "SELECT company_id FROM company_login_session WHERE is_active = 1 AND session_token = ?";
	require("db_config.php");
	$result = $con->execute_query($sql, [$session_token]);
	if ($result->num_rows > 0) {
		return $result->fetch_row()[0];
	} else {
		return 0;
	}
}

function getCompanyLogoFromId(int $id) {
	$sql = "SELECT cover_image_path FROM company_logo WHERE company_id = ?";
	require("db_config.php");
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows > 0) {
		$image = $result->fetch_assoc()['cover_image_path'];
		if ($image == '') {
			return "default_profile_image.png";
		}

		return $image;
	} else {
		return "default_profile_image.png";
	}
}

function getCompanyNameFromId(int $id) {
	require("db_config.php");
	$sql = "SELECT name FROM company WHERE id = ?";
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_row()[0];
}

function getListOfJobsPostedByCompanyId(int $id) {
	require("db_config.php");

	$sql = "SELECT job_id, name, job_summary, close_date FROM job WHERE company_id = ? AND close_date < CURDATE();";
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_assoc();
}

function getJobApplicationsForJobId(int $id) {
	require("db_config.php");

	$sql = "SELECT COUNT(*) AS total_rows FROM job_application WHERE job_id = ?";
	$result = $con->execute_query($sql, [$id]);

	return $result;
}