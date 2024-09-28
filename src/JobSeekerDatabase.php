<?php
namespace JobSeekerDatabase;

function getJobSeekerInfo($id) {
	require("db_confg.php");
	$sql = "SELECT job_seeker_id, first_name, last_name, email, gender, date_of_birth, education_level FROM job_seeker WHERE job_seeker_id = '$id'";
	$result = $con->query($sql);
	if ($result->num_rows == 1) {
		return $result->fetch_assoc();
	} else {
		return null;
	}
}
