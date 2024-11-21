<?php

namespace AdminDatabase;

function loginAdmin($name, $password) {
	$sql = "SELECT admin_id, password FROM admin WHERE name = ?";
	require("db_config.php");
	$result = $con->execute_query($sql, [$name]);
	if ($result->num_rows == 0) {
		return "Admin not found";
	}

	$admin = $result->fetch_assoc();
	$admin_id = $admin['admin_id'];
	$admin_password = $admin['password'];

	$verify = password_verify($password, $admin_password);
	if (!$verify) {
		return "Passwords not match";
	}

	$session_token = bin2hex(random_bytes(100));
	$today = date("Y-m-d");
	$expiration_date = date("Y-m-d", strtotime($today . '10 days'));

	$sql = "INSERT INTO admin_login_session(admin_id, session_token, expiration_date) VALUES(?, ?, ?)";
	$result = $con->execute_query($sql, [$admin_id, $session_token, $expiration_date]);
	if (!$result) {
		return "Could not create session";
	}

	session_start();
	$_SESSION['session_token'] = $session_token;
	$_SESSION['type'] = 'admin';
	header("location: ../index.php");

	return "Successfully logged in";
}

function getJobSeekerList() {
	require("db_config.php");

	$sql = "SELECT job_seeker_id, first_name, last_name FROM job_seeker;";
	$result = $con->execute_query($sql);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getJobsList() {
	require("db_config.php");

	$sql = "SELECT job_id, name, company_id FROM job;";
	$result = $con->execute_query($sql);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getJobApplicationsList() {
	require("db_config.php");

	$sql = "SELECT job_application_id, job_seeker_id, job_id, job_seeker_cv_id, is_reviewed, is_accepted FROM job_application;";
	$result = $con->execute_query($sql);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getCompaniesList() {
	require("db_config.php");

	$sql = "SELECT company_id, name FROM company;";
	$result = $con->execute_query($sql);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}