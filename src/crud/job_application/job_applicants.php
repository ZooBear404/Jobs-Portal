<?php require("../../header.php"); ?>

<div>

<?php
$job_id = $_GET['id'];
$rows = JobDatabase\getJobApplicationListByJobId($job_id);

foreach ($rows as $job_application) {
	echo "<div>";
	
	$job_application_id = $job_application['job_application_id'];
	$job_seeker_id = $job_application['job_seeker_id'];
	$time_created = $job_application['time_created'];
	$is_reviewed = $job_application['is_reviewed'];
	$is_accepted = $job_application['is_accepted'];
	
	if ($is_reviewed == 'T' && $is_accepted == 'T') {
		echo "<div class='reviewed_accepted'>";
	} else if ($is_reviewed == 'T') {
		echo "<div class='reviewed'";
		echo "<div>";
		echo "<a href='accept.php?job_application_id=$job_application_id&job_id=$job_id'><button>Accept</button></a>";
		echo "</div>";
	} else {
		echo "<div class='not_reviewed'>";
		echo "<div>";
		echo "<a href='review.php?job_application_id=$job_application_id&job_id=$job_id'><button>Mark Reviewed</button></a>";
		echo "<a href='accept.php?job_application_id=$job_application_id&job_id=$job_id'><button>Accept</button></a>";
		echo "</div>";
	}
	echo "</div>";

	$job_seeker_info = JobSeekerDatabase\getJobSeekerInfo($job_seeker_id);
	
?>
		<div class="left">
		<?php
		$results = JobSeekerDatabase\getJobSeekerInfo($job_seeker_id);
		$first_name = $results['first_name'];
		$last_name = $results['last_name'];
		$email = $results['email'];
		$date_of_birth = $results['date_of_birth'];
		echo "<p>Firstname: $first_name</p>";
		echo "<p>Lastname: $last_name</p>";
		echo "<p>Email: $email</p>";
		echo "<p>Date of Birth: $date_of_birth</p>";
		?>
	</div>
	<div class="right">
		<div class="job_seeker-educations">
			<div class="job-seeker-educations-header">
				<p>Education</p>
				<?php
				echo "<a href='crud/job_seeker/education/create.php?id=$job_seeker_id'>";
				?>
				</a>
			</div>
			<ul>
				<?php
				$rows = JobSeekerDatabase\getJobSeekerEducationById($job_seeker_id);
				if ($rows == 0) {
					echo "<p>No Education found</p>";
				} else {
					foreach ($rows as $row) {
						$institute_id = $row["institute_id"];
						$institute_name = JobSeekerDatabase\getInstituteNameFromId($institute_id);
						$field_of_study_id = $row["field_of_study_id"];
						$education_level_id = $row["education_level_id"];
						$education_level_name = JobSeekerDatabase\getEducationLevelNameFromId($education_level_id);

						echo "<div class='job-seeker-education'>
								<div class='left-education'>
									<p>$institute_name</p>
									<p>$field_of_study_name</p>
									<p>$education_level_name</p>
								</div>
								<div class='right-education'>
								</div>
							</div>";
					}
				}

				?>

			</ul>
		</div>
		<div class="job-seeker-experiences">
			<div class="job-seeker-experiences-header">
				<p>Experiences</p>
			</div>
			<div class="job-seeker-experiences-list">
				<?php
				$rows = JobSeekerDatabase\getColumnNamesFromTableWithId(['job_experience_id', 'job_title', 'start_date', 'end_date'], 'job_seeker_experience', $job_seeker_id);
				if ($rows == 0) {
					echo "<p>No Experiences Found</p>";
				} else {
					foreach ($rows as $row) {
						$job_experience_id = $row['job_experience_id'];
						$job_title = $row['job_title'];
						$start_date = $row['start_date'];
						$end_date = $row['end_date'];

						if ($end_date == null) $end_date = '_';

						echo "<div class='job-seeker-experience'>
							<div class='job-seeker-experience-left'>
								<p>$job_title</p>
								<div class='job-seeker-experience-left-bottom'>
									$start_date - $end_date
								</div>
							</div>
							<div class='job-seeker-experience-right'>
							</div>
						</div>";
					}
				}
				?>
			</div>

		</div>
		<div class="job-seeker-skills">
			<div class="job-seeker-skills-header">
				<p>Skills</p>
			</div>
			<div class="job-seeker-skills-list">
				<?php
				$rows = JobSeekerDatabase\getColumnNamesFromTableWithId(['skill_id'], 'job_seeker_skill', $job_seeker_id);
				if ($rows == 0) {
					echo "<p>No Skills Found</p>";
				} else {
					foreach ($rows as $row) {
						$skill_id = $row["skill_id"];
						$row = JobSeekerDatabase\getColumnNamesFromTable(['title'], "skill");
						$skill_name = $row['skill_name'];

						echo "<div class='job-seeker-skill'>
							<div class='job-seeker-skill-left'>
								<p>$skill_name</p>
							</div>
							<div class='job-seeker-skill-right'>

							</div>
						</div>";
					}
				}


				?>
			</div>

		</div>
		<div class="job-seeker-languages">
			<div class="job-seeker-languages-header">
				<p>Languages</p>
			</div>
			<div class="job-seeker-languages-list">
				<?php
				$rows = JobSeekerDatabase\getColumnNamesFromTableWithId(['job_seeker_language_id', 'language_id', 'language_fluency_id'], 'job_seeker_language', $job_seeker_id);
				if ($rows == 0) {
					echo "<p>No Languages Found</p>";
				} else {
					foreach ($rows as $row) {
						$job_seeker_language_id = $row["job_seeker_language_id"];
						$language_id = $row["language_id"];
						$language_name = JobSeekerDatabase\getNameByTablePrimaryKey('language', $language_id);
						$job_seeker_language_fluency_id = $row['language_fluency'];
						$fluency_name = JobSeekerDatabase\getNameByTablePrimaryKey('language_fluency', $job_seeker_language_fluency_id);

						echo "<div class='job-seeker-language'>
							<div class='job-seeker-language-left'>
								<p>$language_name</p>
							</div>
							<div class='job-seeker-language-right'>

							</div>
						</div>";
					}
				}


				?>
			</div>

		</div>
	</div>
</div>

<?php	
	echo "</div>";
}
?>

</div>
