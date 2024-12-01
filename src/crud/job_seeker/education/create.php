<?php
require("../../../header.php");
$job_seeker_id = $_GET['id'];
?>

<link rel="stylesheet" href="../../../output.css">

<div class="flex flex-col items-center justify-center gap-5 p-3">
	<p class="text-3xl">Add Education</p>

	<form method="post" action="" class="flex flex-col gap-3">
		<select name="institute" id="institute" class="p-2 bg-gray-300 rounded-md">
			<?php
			$rows = JobSeekerDatabase\getInstitutes();
			
			foreach ($rows as $row) {
				$id = $row['institute_id'];
				$name = $row['name'];
				echo "<option value='$id'>$name</option>";
			}
			?>
	</select>

	<select name="education_level" id="education_level" class="p-2 bg-gray-300 rounded-md">
		<?php

	$rows = JobSeekerDatabase\getEducationLevels();

	foreach ($rows as $row) {
		$id = $row['education_level_id'];
		$name = $row['name'];
		echo "<option value=$id>$name</option>";
	}

	?>
		</select>
		
		<select name="state" id="state" class="p-2 bg-gray-300 rounded-md">
			<?php

	$rows = JobSeekerDatabase\getStates();

	foreach ($rows as $row) {
		$state_id = $row['state_id'];
		
		$country_id = $row['country_id'];
		$country_name = JobSeekerDatabase\getNameByTablePrimaryKey("country", $country_id);
		$state_name = $row['name'];
		
		echo "<option value='$state_id'>$state_name, $country_name</option>";
	}
	?>
		</select>
		
		<label for="state_date">Start Date</label>
		<input type="date" name="start_date" id="start_date" class="p-2 bg-gray-300 rounded-md">

		<label for="end_date">End Date</label>
		<input type="date" name="end_date" id="end_date" class="p-2 bg-gray-300 rounded-md">
		
		<textarea name="description" id="description" class="p-2 bg-gray-300 rounded-md"></textarea>
		
		<input type="submit" value="submit" class="p-2 bg-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-400 ">
	</form>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$institute_id = $_POST['institute'];
	$education_level_id = $_POST['education_level'];
		$state_id = $_POST['state'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$description = $_POST['description'];
		
		$result = JobSeekerDatabase\addEducation($job_seeker_id, $institute_id, $education_level_id, $state_id, $start_date, $end_date, $description);
		if (!$result) {
			echo "<p class='text-red-600'>An error occurred</p>";
		} else {
			echo "<p class='text-green-500'>Successfully Inserted</p>";
		}
	}


?>