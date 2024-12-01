<?php
require("../../../header.php");
$job_seeker_id = $_GET['id'];
?>

<link rel="stylesheet" href="../../../output.css">

<div class="flex flex-col items-center justify-center gap-5 p-3">
	<p class="text-3xl">Add Experience</p>

	<form method="post" action="" class="flex flex-col gap-3">

		<label for="job_title">Job Title</label>
		<input type="text" name="job_title" id="job_title" class="p-2 bg-gray-300 rounded-md">

		<select name="company" id="company" class="p-2 bg-gray-300 rounded-md">
			<?php
			$rows = CompanyDatabase\getCompanies();
			
			foreach ($rows as $row) {
				$id = $row['company_id'];
				$name = $row['name'];
				echo "<option value='$id'>$name</option>";
			}
			?>
	</select>

	<select name="employment_type" id="employment_type" class="p-2 bg-gray-300 rounded-md">
		<?php
			$rows = JobDatabase\getEmploymentTypes();

			foreach ($rows as $row) {
				$id = $row['employment_type_id'];
				$name = $row['name'];
				echo "<option value=$id>$name</option>";
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
	$job_title = $_POST['job_title'];
	$company_id = $_POST['company'];
	$employment_type_id = $_POST['employment_type'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$description = $_POST['description'];
	
	$result = JobSeekerDatabase\addExperience($job_seeker_id, $job_title, $company_id, $employment_type_id, $start_date, $end_date, $description);
	if (!$result) {
		echo "<p class='text-red-600'>An error occurred</p>";
	} else {
		echo "<p class='text-green-500'>Successfully Inserted</p>";
	}
	sleep(3);
	header("Location:../../../");
}


?>