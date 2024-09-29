<?php

namespace AdminDatabase;

function loginAdmin($email, $password) {
	$sql = "SELECT admin_id, password FROM admin WHERE email = ?";
	require("db_config.php");
	$result = $con->execute_query($sql, [$email]);
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