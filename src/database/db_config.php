<?php

define("hostname", "localhost");
define("username", "job");
define("dbname", "job_portal");

require("passwords.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con = new mysqli(hostname, username, password, dbname);
if ($con->connect_error) {
	die("". $con->connect_error);
}
