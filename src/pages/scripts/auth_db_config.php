<?php

define("auth_hostname", "localhost");
define("auth_username","job_auth");
define("auth_database", "job_portal_auth");

require("passwords.php");

$auth_con = new mysqli(auth_hostname, auth_username, auth_username, auth_password, auth_database);
if ($auth_con->connect_error) {
	die("". $auth_con->connect_error);
}

function close_auth_connection($auth_con) {
	$auth_con->close();
}