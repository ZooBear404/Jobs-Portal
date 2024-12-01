<?php
require("../../database/JobDatabase.php");

$job_id = $_GET['id'];
JobDatabase\deleteJob($job_id);
if(!$result) {
	echo "<p>Error Occurred</p>";
} else {
	echo "<p>Deleted Successfully</p>";
}

sleep(3);
header("Location:../../");


?>