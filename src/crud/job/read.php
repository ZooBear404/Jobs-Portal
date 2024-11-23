<?php require("../../header.php"); ?>

<?php
	// Check if the user is Company, Anonymous, JobSeeker, or Admin
	$user;

	if (isset($_SESSION['type'])) {
		if ($_SESSION['type'] == 'admin') {
			$user = "Admin";
		} else if ($_SESSION['type'] == 'company') {
			$user = "Company";
		} else if ($_SESSION['type'] == 'job_seeker') {
			$user = "JobSeeker";
		}
	} else {
		$user = "Anonymous";
	}

?>


<div class="top">
	<?php

		$job_id = $_GET['id'];
		$result = JobDatabase\getJobInfo($job_id)[0];
		
		$job_name = $result['name'];
		$company_id = $result['company_id'];
		$company_logo = CompanyDatabase\getCompanyLogoFromId($company_id);
		
		$images_url = "../../static/images/profiles/";

		echo "<div><img src='$images_url$company_logo' height='150rem'><p>$job_name</p></div>";
	?>

</div>
<div class="middle">
	
	<?php
			$close_date = $result['closing_date'];
			// the "Apply" Button
			if ($user == "Admin" || $user == "Company") {
				echo "<a href='delete.php?id=$job_id'><button class=''>Delete Job</button></a>";
			} else if ($user == "JobSeeker") {
				echo "<a href='apply.php?id=$job_id'><button>Apply</button></a>";
			}

			echo "<div>$close_date</div>";
	?>
</div>
<div class="end">
	<?php
		$job_summary = $result['job_summary'];
		$duties = $result['duties'];
		$requirements = $result['requirements'];
		$submission_guidelines = $result['submission_guidelines'];
		$time_created = $result['time_created'];
		$number_of_vacancies = $result['number_of_vacancies'];
		$salary_min = $result['salary_min'];
		$salary_max = $result['salary_max'];
		$years_of_experience = $result['years_of_experience'];
		$probation_period = $result['probation_period'];
		$contract_type = JobDatabase\getContractTypeById($result['contract_type_id']);
		$contract_duration =  $result['contract_duration'];
		$is_contract_extensible = $result['is_contract_extensible'];
		$minimum_education = JobDatabase\getEducationLevelNameById($result['minimum_education'])[0];
		$gender = $result['gender'];
		$employment_type_id = JobDatabase\getEducationLevelNameById($result['employment_type_id']);

		echo "<div>
			<p>Job Summary</p>
			<p>$job_summary</p>
		</div>";

		echo "<div>
			<p>Duties</p>
			<p>$duties</p>
		</div>";

		echo "<div>
			<p>Requirements</p>
			<p>$requirements</p>
		</div>";

		echo "<div>
			<p>Submission Guidelines</p>
			<p>$submission_guidelines</p>
		</div>";

		echo "<div>
			<p>Time Created</p>
			<p>$time_created</p>
		</div>";

		echo "<div>
			<p>Number of Vacancies</p>
			<p>$number_of_vacancies</p>
		</div>";

		echo "<div>
			<p>Salary Min</p>
			<p>$salary_min</p>
		</div>";

		echo "<div>
			<p>Salary Max</p>
			<p>$salary_max</p>
		</div>";

		echo "<div>
			<p>Years of Experience</p>
			<p>$years_of_experience ";
		if ($years_of_experience == 1) {
			echo "year</p>";
		} else {
			echo "years</p>";
		}
		echo "</div>";


		echo "<div>
			<p>Probation Period</p>
			<p>$probation_period ";
		if ($probation_period == 1) {
			echo "month</p>";
		} else {
			echo "months</p>";
		}
		echo "</div>";

		echo "<div>
			<p>Contract Type</p>
			<p>$contract_type</p>
		</div>";

		echo "<div>
			<p>Contract Duration </p>
			<p>$contract_duration ";
		if ($contract_duration == 1) {
			echo "month</p>";
		} else {
			echo "months</p>";
		}
		echo "</div>";

		echo "<div>
			<p>Is Contract Extensible</p>
		";

		if ($is_contract_extensible == 'T') {
			echo "<p>True</p>";
		} else if ($is_contract_extensible == 'F') {
			echo "<p>False</p>";
		}
		echo "</div>";

		echo "<div>
			<p>Minimum Education</p>
			<p>$minimum_education</p>
		</div>";

		echo "<div>
			<p>Gender</p>";
		if ($gender == 'M') {
			echo "<p>Male</p>";
		} else if ($gender == 'F') {
			echo "<p>Female</p>";
		} else if ($gender == 'E') {
			echo "<p>Male/Female</p>";
		}
		echo "</div>";

	?>

</div>


<?php 





?>