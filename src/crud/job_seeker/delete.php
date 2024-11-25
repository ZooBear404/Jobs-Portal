<?php
require("../../database/JobSeekerDatabase.php");

$job_seeker_id = $_GET['id'];
$result = JobSeekerDatabase\deleteJobSeeker($job_seeker_id);
if ($result == 0) {
	echo "<div><p>An error occurred</p></div>";
	sleep(5);
	header("Location:../../");
}	

?>