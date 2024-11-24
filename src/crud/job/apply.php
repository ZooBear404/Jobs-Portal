<?php require("../../header.php"); ?>

<?php

    $job_id = $_GET['id'];
	session_start();
	$session_token;
	if (isset($_SESSION['session_token'])) {
		$session_token = $_SESSION['session_token'];
		$job_seeker_id = JobSeekerDatabase\getUserIdFromSessionToken($session_token);
		if (!$job_seeker_id) {
			echo "<div>You can't apply for jobs</div>";
		}

		if (JobDatabase\isJobAppliedForByJobSeeker($job_id, $job_seeker_id)) {
			echo "<div><p>You have already applied for this job.</p></div>";
			sleep(3);
			header("Location:../../");
		} else {
			JobDatabase\applyForJob($job_id, $job_seeker_id);
			echo "<div><p>Applied for job successfully!</p></div>";
			sleep(3);
			header("Location:../../");
		}

	} else {
		echo "<div>You can't apply for jobs</div>";
	}



?>