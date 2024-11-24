<?php

namespace JobDatabase;


function getJobInfo(int $id) {
	require("db_config.php");

	$sql = "SELECT * FROM job WHERE job_id = ?";
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows != 1) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getJobList(){ 
	require("db_config.php");

	$sql = "SELECT * FROM job;";
	$result = $con->execute_query($sql);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getJobNameById(int $id) {
	require("db_config.php");
	$sql = "SELECT name FROM job WHERE job_id = ?";
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_row()[0];
}

function getContractTypes() {
	require("db_config.php");
	$sql = "SELECT contract_type_id, name FROM contract_type;";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getEducationLevels() {
	require("db_config.php");
	$sql = "SELECT education_level_id, name FROM education_level;";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getEmploymentTypes(){ 
	require("db_config.php");
	$sql = "SELECT employment_type_id, name FROM employment_type;";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function postJob($company_id, $title, $summary, $duties, 
				$requirements, $closing_date, $number_of_vacancies, 
				$salary_min, $salary_max, $years_of_experience, 
				$probation_period, $contract_type_id, 
				$contract_duration, $is_contract_extensible, 
				$minimum_education, $gender, $employment_type_id) 
				{
	require("db_config.php");

	echo "$company_id, $title, $summary, $duties, $requirements, $closing_date, $number_of_vacancies, $salary_min, $salary_max, $years_of_experience, $probation_period, $contract_type_id, $contract_duration, $is_contract_extensible, $minimum_education, $gender, $employment_type_id.";

	$sql = "INSERT INTO job(name, job_summary, duties, requirements, close_date, number_of_vacancies, salary_min, salary_max, years_of_experience, probation_period, contract_type_id, contract_duration, is_contract_extensible, minimum_education, gender, employment_type_id, company_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$result = $con->execute_query($sql, [$title, $summary, $duties, $requirements, $closing_date, $number_of_vacancies, $salary_min, $salary_max, $years_of_experience, $probation_period, $contract_type_id, $contract_duration, $is_contract_extensible, $minimum_education, $gender, $employment_type_id, $company_id]);
	if (!$result) {
		return false;
	}

	return true;
}

function getContractTypeById($id) {
	require("db_config.php");
	$sql = "SELECT name from contract_type WHERE contract_type_id = ?";
	$result = $con->execute_query($sql, [$id]);

	return $result->fetch_row();
}

function getEducationLevelNameById($id) {
	require("db_config.php");
	$sql = "SELECT name FROM education_level WHERE education_level_id = ?";
	$result = $con->execute_query($sql, [$id]);

	return $result->fetch_row();
}

function getEmploymentTypeNameById($id){ 
	require("db_config.php");
	$sql = "SELECT name FROM employment_type WHERE employment_type_id = ?";
	$result = $con->execute_query($sql, [$id]);

	return $result->fetch_row();
}

function getJobApplicationListByJobId($job_id) {
	require("db_config.php");
	$sql = "SELECT * FROM job_application WHERE job_id = ?";
	$result = $con->execute_query($sql, [$job_id]);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function isJobAppliedForByJobSeeker($job_id, $job_seeker_id) {
	require("db_config.php");
	$sql = "SELECT * FROM job_application WHERE job_id = ? AND job_seeker_id = ?";
	$result = $con->execute_query($sql, [$job_id, $job_seeker_id]);
	if ($result->num_rows == 0) {
		return false;
	}

	return true;
}

function applyForJob($job_id, $job_seeker_id) {
	require("db_config.php");
	$sql = "INSERT INTO job_application(job_id, job_seeker_id, is_reviewed, is_accepted) VALUES (?, ?, 'F', 'F')";
	$result = $con->execute_query($sql, [$job_id, $job_seeker_id]);
	if (!$result) {
		return 0;
	}

	return 1;
}

function markJobApplicationAsAccepted($job_application_id) {
	require("db_config.php");
	$sql = "UPDATE job_application SET is_accepted = 'T', is_reviewed = 'T' WHERE job_application_id = ?";
	// mysqli_query($con, $sql);
	$result = $con->execute_query($sql, [$job_application_id]);
	if (!$result) {
		return 0;
	}

	return 1;
}

function markJobApplicationAsReviewed($job_application_id){ 
	require("db_config.php");
	$sql = "UPDATE job_application SET is_reviewed = 'T' WHERE job_application_id = ?";
	$result = $con->execute_query($sql, [$job_application_id]);
	if (!$result) {
		return 0;
	}

	return 1;
}


// (CR)UD Jobs
function job_delete($job_id) {

}

function job_update($job_id) {

}

// Job Applications

