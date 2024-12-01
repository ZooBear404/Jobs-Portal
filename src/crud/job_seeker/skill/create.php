<?php
require("../../../header.php");
$job_seeker_id = $_GET['id'];
?>

<link rel="stylesheet" href="../../../output.css">

<div class="flex flex-col items-center justify-center gap-5 p-3">
	<p class="text-3xl">Add Skill</p>

	<form method="post" action="" class="flex flex-col gap-3">
		<label for="description">Description</label>
		<textarea name="description" id="description" class="p-2 bg-gray-300 rounded-md"></textarea>	
	

		<input type="submit" value="submit" class="p-2 bg-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-400 ">
	</form>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$description = $_POST['description'];
	
	$result = JobSeekerDatabase\addSkill($job_seeker_id, $description);
	if (!$result) {
		echo "<p class='text-red-600'>An error occurred</p>";
	} else {
		echo "<p class='text-green-500'>Successfully Inserted</p>";
	}
	sleep(3);
	header("Location:../../../");
}


?>