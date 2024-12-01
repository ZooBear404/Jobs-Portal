<link rel="stylesheet" href="../../../output.css">

<div class="flex flex-col items-center justify-center w-screen h-screen">

	<?php
		require("../../../database/JobSeekerDatabase.php");
		$job_seeker_id = $_GET['job_seeker_id'];
		$job_seeker_language_id = $_GET['id'];

		session_start();
		if (isset($_SESSION['session_token']) && isset($_SESSION['type'])) {
			$session_token = $_SESSION['session_token'];
			$job_seeker_id_session_token = JobSeekerDatabase\getUserIdFromSessionToken($session_token);
			if ($job_seeker_id == $job_seeker_id_session_token || $_SESSION['type'] == 'admin') {
				$result = JobSeekerDatabase\deleteLanguage($job_seeker_language_id);
				if ($result) {
					echo "<p class='text-3xl text-red-600'>Deleted Successfully</p>";
				} else {
					echo "<p class='text-3xl text-red-600'>An Error Occurred</p>";
				}
			} else {
				echo "<p class='text-3xl text-red-800'>You can't delete experience</p>";
			}
		} else {
			echo "<p class='text-3xl text-red-800'>You can't delete experience</p>";
		}

		header("Location:../../../");
	?>

</div>
