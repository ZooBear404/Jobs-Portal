<?php
require("../../../header.php");
$job_seeker_id = $_GET['id'];
?>

<link rel="stylesheet" href="../../../output.css">

<div class="flex flex-col items-center justify-center gap-5 p-3">
	<p class="text-3xl">Add Language</p>

	<form method="post" action="" class="flex flex-col gap-3">

		<select name="language" id="language" class="p-2 bg-gray-300 rounded-md">
			<?php
			$rows = JobSeekerDatabase\getLanguages();
			
			foreach ($rows as $row) {
				$id = $row['language_id'];
				$name = $row['name'];
				echo "<option value='$id'>$name</option>";
			}
			?>
	</select>

	<select name="language_fluency" id="language_fluency" class="p-2 bg-gray-300 rounded-md">
		<?php
			$rows = JobSeekerDatabase\getLanguageFluency();

			foreach ($rows as $row) {
				$id = $row['language_fluency_id'];
				$name = $row['name'];
				echo "<option value=$id>$name</option>";
			}

			?>
		</select>
		
		<input type="submit" value="submit" class="p-2 bg-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-400 ">
	</form>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$language = $_POST['language'];
	$language_fluency = $_POST['language_fluency'];

	$result = JobSeekerDatabase\addLanguage($job_seeker_id, $language, $language_fluency);
	if (!$result) {
		echo "<p class='text-red-600'>An error occurred</p>";
	} else {
		echo "<p class='text-green-500'>Successfully Inserted</p>";
	}
	sleep(3);
	header("Location:../../../");
}


?>