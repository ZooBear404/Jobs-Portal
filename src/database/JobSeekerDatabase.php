<?php
namespace JobSeekerDatabase;

function getJobSeekerInfo($id) {
	require("../db_confg.php");
	$sql = "SELECT job_seeker_id, first_name, last_name, email, gender, date_of_birth, education_level FROM job_seeker WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, $id);
	if ($result->num_rows == 1) {
		return $result->fetch_assoc();
	} else {
		return null;
	}
}

function signUpJobSeeker($firstname, $lastname, $email, $gender, $date_of_birth, $password) {
	$hashed_password = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 1]);
	require("../db_config.php");
	$sql = "INSERT INTO job_seeker(first_name, last_name, email, gender, date_of_birth, password) VALUES(?, ?, ?, ?, ?, ?)";
	$result = $con->execute_query($sql, [$firstname, $lastname, $email, $gender, $date_of_birth, $hashed_password]);
	if (!$result) {
		return false;
	}

	return true;
}

function loginJobSeeker($email, $password) {
	require("../db_config.php");

	$find_user_sql = "SELECT password, job_seeker_id FROM job_seeker WHERE email = ?";
	$result = $con->execute_query($find_user_sql, [$email]);
	if ($result->num_rows != 1) {
		return array(4, "Error finding user");
	}
	if (!$result) {
		return array(1, "Email not found");
	}

	$fetched = $result->fetch_assoc();
	$job_seeker_password = $fetched["password"];
	$verify = password_verify($password, $job_seeker_password);
	if (!$verify) {
		return array(1, "Passwords do not match");
	}

	$job_seeker_id = $fetched['job_seeker_id'];

	$sql = "UPDATE job_seeker_login_session SET is_active = false WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$job_seeker_id]);
	if (!$result) {
		echo "updating login session went wrong!!";
		return array(2, "Updating went wrong");
	}

	$session_token = bin2hex(random_bytes(100));
	$today = date("Y-m-d");
	$expiration_date = date('Y-m-d', strtotime($today.' + 10 days'));

	$sql = "INSERT INTO job_seeker_login_session(job_seeker_id, session_token, session_expiration) VALUES(?, ?, ?);";
	$result = $con->execute_query($sql, [$job_seeker_id, $session_token, $expiration_date]);
	if (!$result) {
		return array(3, "Creating session went wrong");
	}

	session_start();
	$_SESSION['session_token'] = $session_token;
	$_SESSION['type'] = 'job_seeker';

	header("location: ../index.php");

	return array(0, "Login Successful");
}

function getUserIdFromSessionToken(string $session_token) {
	$sql = "SELECT job_seeker_id FROM job_seeker_login_session WHERE session_token = ? AND is_active = 1";
	require("../db_config.php");
	$result = $con->execute_query($sql, [$session_token]);
	if ($result->num_rows > 0) {
		return $result->fetch_row()[0];
	} else {
		return 0;
	}
}

function getUserImageUrlFromId(int $id) {
	$sql = "SELECT image_path FROM job_seeker_profile_image WHERE job_seeker_id = ?";
	require("../db_config.php");
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows > 0) {
		return $result->fetch_row()[0];
	} else {
		return "default_profile_image.png";
	}

}