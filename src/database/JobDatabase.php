<?php

namespace JobDatabase;

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