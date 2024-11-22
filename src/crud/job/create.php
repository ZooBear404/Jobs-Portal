<?php require("../../header.php"); ?>

<div class="container">
	<form action="" method="post">
		<div class="title">
			<label for="title">Title</label>
			<input type="text" name="title" id="title">
		</div>
		
		<div class="summary">
			<label for="summary">Summary</label>
			<textarea name="summary" id="summary"></textarea>
		</div>

		<div class="duties">
			<label for="duties">Duties & Responsibilities</label>
			<textarea name="duties" id="duties"></textarea>
		</div>

		<div class="requirements">
			<label for="requirements">Requirements</label>
			<textarea name="requirements" id="requirements"></textarea>
		</div>

		<div class="closing_date">
			<label for="closing_date">Closing Date</label>
			<input type="date" name="closing_date" id="closing_date">
		</div>

		<div class="number_of_vacancies">
			<label for="number_of_vacancies">Number of Vacancies</label>
			<input type="number" name="number_of_vacancies" id="number_of_vacancies" min="1">
		</div>

		<div class="salary_range">
			<label for="salary_range">Salary Range</label>
			<input type="number" name="salary_range_min" id="salary_range_min">
			<input type="number" name="salary_range_max" id="salary_range_max">
		</div>

		<div class="year_of_experience">
			<label for="years_of_experience">Years of Experience</label>
			<input type="number" name="years_of_experience" id="years_of_experience" step="0.1">
		</div>

		<div class="probation_period">
			<label for="probation_period">Probation Period (months)</label>
			<input type="number" name="probation_period" id="probation_period" min="0">
		</div>

		<div class="contract_type">
			<label for="contract_type">Contract Type</label>
			<select name="contract_type" id="contract_type">
				<?php
					$rows = JobDatabase\getContractTypes();
					foreach ($rows as $row) {
						$contract_type_name = $row["name"];
						$contract_type_id = $row["contract_type_id"];
						echo "<option value='$contract_type_id'>$contract_type_name</option>";
					}
				?>
			</select>
		</div>

		<div class="contract_duration">
			<label for="contract_duration">Contract Duration (months)</label>
			<input type="number" name="contract_duration" id="contract_duration" min="0">
		</div>

		<div class="is_contract_extensible">
			<label for="is_contract_extensible">Is Contract Extensible</label>
			
			<div>
				<label for="is_contract_extensible_true">True</label>
				<input type="radio" name="is_contract_extensible" id="is_contract_extensible" value="T">
			</div>
			<div>
				<label for="is_contract_extensible_false">False</label>
				<input type="radio" name="is_contract_extensible" id="is_contract_extensible" value="F">
			</div>
		</div>

		<div class="minimum_education">
			<label for="minimum_education">Minimum Education</label>
			<select name="minimum_education" id="minimum_education">
					<?php
						$rows = JobDatabase\getEducationLevels();

						foreach ($rows as $row) {
							$education_id = $row['education_level_id'];
							$name = $row['name'];
							echo "<option value='$education_id'>$name</option>";
						}
					?>
			</select>
		</div>

		<div class="gender">
			<label for="gender">Gender</label>
			
			<div>
				<label for="gender_male">Male</label>
				<input type="radio" name="gender" id="gender_male" value="M">
				
				<label for="gender_female">Female</label>
				<input type="radio" name="gender" id="gender_female" value="F">
			</div>
		</div>

		<div class="employment_type">
			<label for="employment_type">Employment Type</label>
			<select name="employment_type" id="employment_type">
				<?php
					$rows = JobDatabase\getEmploymentTypes();

					foreach ($rows as $row) {
						$employment_type_id = $row['employment_type_id'];
						$name = $row['name'];

						echo "<option value='$employment_type_id'>$name</option>";
					}
				?>
			</select>
		</div>

		<input type="submit" value="submit">
	</form>


</div>



<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		session_start();
		$company_id;
		if (isset($_SESSION['session_token'])) {
			$session_token = $_SESSION['session_token'];
			$company_id = CompanyDatabase\getCompanyIdFromSessionToken($session_token);
		} else {
			echo "<p>ERROR: YOU CAN'T CREATE JOB POSTS</p>";
			header("location:../../../../index.php");
		}

		$title = $_POST['title'];
		$summary = $_POST['summary'];
		$duties = $_POST['duties'];
		$requirements = $_POST['requirements'];
		$closing_date = $_POST['closing_date'];
		$number_of_vacancies = $_POST['number_of_vacancies'];
		$salary_min = $_POST['salary_range_min'];
		$salary_max = $_POST['salary_range_max'];
		$years_of_experience = $_POST['years_of_experience'];
		$probation_period = $_POST['probation_period'];
		$contract_type_id = $_POST['contract_type'];
		$contract_duration = $_POST['contract_duration'];
		$is_contract_extensible = $_POST['is_contract_extensible'];
		$minimum_education = $_POST['minimum_education'];
		$gender = $_POST['gender'];
		$employment_type_id = $_POST['employment_type'];


		$result = JobDatabase\postJob($company_id, $title, $summary,
										$duties, $requirements, $closing_date,
										$number_of_vacancies, $salary_min, $salary_max,
										$years_of_experience, $probation_period, 
										$contract_type_id, $contract_duration,
										$is_contract_extensible, $minimum_education,
										$gender, $employment_type_id);

		if (!$result) {
			echo "<p>Error: Could not post Job</p>";
		} else {
			echo "<p>Job posted successfully</p>";
		}

	}



?>