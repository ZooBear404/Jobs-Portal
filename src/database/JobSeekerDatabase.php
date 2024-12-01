<?php

namespace JobSeekerDatabase;

function getJobSeekerInfo($id) {
	require("db_config.php");
	$sql = "SELECT first_name, last_name, email, gender, date_of_birth FROM job_seeker WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$id]);

	if ($result->num_rows == 1) {
		return $result->fetch_assoc();
	} else {
		return null;
	}
}

function signUpJobSeeker($firstname, $lastname, $email, $gender, $date_of_birth, $password) {
	$hashed_password = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 1]);
	require("db_config.php");
	$sql = "INSERT INTO job_seeker(first_name, last_name, email, gender, date_of_birth, password) VALUES(?, ?, ?, ?, ?, ?)";
	$result = $con->execute_query($sql, [$firstname, $lastname, $email, $gender, $date_of_birth, $hashed_password]);
	if (!$result) {
		return false;
	}

	return true;
}

function loginJobSeeker($email, $password) {
	require("db_config.php");

	$find_user_sql = "SELECT password, job_seeker_id FROM job_seeker WHERE email = ?";
	$result = $con->execute_query($find_user_sql, [$email]);
	if ($result->num_rows != 1) {
		return array(4, "Error finding user");
	}
	if (!$result) {
		return array(1, "Email not found");
	}

	$fetched = $result->fetch_assoc();
	$job_seeker_password = $fetched["password"];
	$verify = password_verify($password, $job_seeker_password);
	if (!$verify) {
		return array(1, "Passwords do not match");
	}

	$job_seeker_id = $fetched['job_seeker_id'];

	$sql = "UPDATE job_seeker_login_session SET is_active = false WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$job_seeker_id]);
	if (!$result) {
		echo "updating login session went wrong!!";
		return array(2, "Updating went wrong");
	}

	$session_token = bin2hex(random_bytes(100));
	$today = date("Y-m-d");
	$expiration_date = date('Y-m-d', strtotime($today . ' + 10 days'));

	$sql = "INSERT INTO job_seeker_login_session(job_seeker_id, session_token, session_expiration) VALUES(?, ?, ?);";
	$result = $con->execute_query($sql, [$job_seeker_id, $session_token, $expiration_date]);
	if (!$result) {
		return array(3, "Creating session went wrong");
	}

	session_start();
	$_SESSION['session_token'] = $session_token;
	$_SESSION['type'] = 'job_seeker';

	header("location: ../index.php");

	return array(0, "Login Successful");
}

function getUserIdFromSessionToken(string $session_token) {
	$sql = "SELECT job_seeker_id FROM job_seeker_login_session WHERE session_token = ? AND is_active = 1";
	require("db_config.php");
	$result = $con->execute_query($sql, [$session_token]);
	if ($result->num_rows > 0) {
		return $result->fetch_row()[0];
	} else {
		return 0;
	}
}

function getUserImageUrlFromId(int $id) {
	$sql = "SELECT image_path FROM job_seeker_profile_image WHERE job_seeker_id = ?";
	require("db_config.php");
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows > 0) {
		return $result->fetch_row()[0];
	} else {
		return "default_profile_image.png";
	}
}

function getJobSeekerNameById(int $id) {
	$sql = "SELECT first_name, last_name FROM job_seeker WHERE job_seeker_id = ?";
	require("db_config.php");
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows < 1) {
		return 0;
	}

	return $result->fetch_row();
}

function getJobCvPathFromId(int $id) {
	$sql = "SELECT cv_path FROM job_seeker_cv WHERE job_seeker_cv_id = ?";
	require("db_config.php");
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_row()[0];
}

function getJobApplicationListByJobSeekerId(int $id) {
	require("db_config.php");

	$sql = "SELECT job_application_id, job_id, is_reviewed, is_accepted, time_created FROM job_application WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getJobSeekerEducationById(int $id) {
	require("db_config.php");

	$sql = "SELECT job_seeker_education_id, institute_id, education_level_id FROM job_seeker_education WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getEducationLevelNameFromId(int $id) {
	require("db_config.php");

	$sql = "SELECT name FROM education_level WHERE education_level_id = ?";
	$result = $con->execute_query($sql, [$id]);

	return $result->fetch_row()[0];
}

function getFieldOfStudyNameFromId(int $id) {
	require("db_config.php");

	$sql = "SELECT name FROM field_of_study WHERE field_of_study_id = ?";
	$result = $con->execute_query($sql, [$id]);

	return $result->fetch_row()[0];
}

function getInstituteNameFromId(int $id) {
	require("db_config.php");

	$sql = "SELECT name FROM institute WHERE institute_id = ?";
	$result = $con->execute_query($sql, [$id]);

	return $result->fetch_row()[0];
}


// From now on, a different approach

function getColumnNamesFromTableWithId(array $columnNames, string $table, int $id) {
	require("db_config.php");

	$sql = "SELECT ?";
	for ($i = 1; $i < count($columnNames); $i++) {
		$sql = $sql . ", ? ";
	}

	$sql = $sql . " FROM $table" . " WHERE " . "job_seeker_id = ?";

	array_push($columnNames, $id);

	// echo $sql;

	$result = $con->execute_query($sql, $columnNames);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getNameByTablePrimaryKey(string $table, int $id) {
	require("db_config.php");

	$sql = "SELECT name FROM " . $table . " WHERE " . $table . "_id = ?";
	$result = $con->execute_query($sql, [$id]);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_row()[0];
}

function getColumnNamesFromTable(array $columnNames, string $table) {
	require("db_config.php");

	$sql = "SELECT ?";
	for ($i = 1; $i < count($columnNames); $i++) {
		$sql = $sql . ", ? ";
	}

	$sql = $sql . " FROM $table";

	$result = $con->execute_query($sql, $columnNames);
	if ($result->num_rows == 0) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getAllFromTable($table) {
	require("db_config.php");

	$sql = "SELECT * FROM ?;";
	$result = $con->execute_query($sql, [$table]);
	if (!$result) {
		return 0;
	}

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getInstitutes() {
	require("db_config.php");
	$sql = "SELECT institute_id, name FROM institute;";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getEducationLevels() {
	require("db_config.php");
	$sql = "SELECT * FROM education_level";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}


function getStates(){ 
	require("db_config.php");
	$sql = "SELECT state_id, name, country_id FROM state";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function addEducation($job_seeker_id, $institute_id, $education_level_id, $state_id, $start_date, $end_date, $description) {
	require("db_config.php");
	$sql = "INSERT INTO job_seeker_education (job_seeker_id, institute_id, education_level_id, state_id, start_date, end_date, description) VALUES (?, ?,?, ?, ?, ?, ?);";
	$result = $con->execute_query($sql, [$job_seeker_id, $institute_id, $education_level_id, $state_id, $start_date, $end_date, $description]);
	if (!$result) {
		return 0;
	}

	return 1;
}

function addExperience($job_seeker_id, $job_title, $company_id, $employment_type_id, $start_date, $end_date, $description) {
	require("db_config.php");
	$sql = "INSERT INTO job_seeker_experience (job_title, company_id, employment_type_id, start_date, end_date, description, job_seeker_id) VALUES (?, ?, ?, ?, ?, ?, ?);";
	$result = $con->execute_query($sql, [$job_title, $company_id, $employment_type_id, $start_date, $end_date, $description, $job_seeker_id]);
	if (!$result) {
		return 0;
	}

	return 1;
}


function getExperience($job_seeker_id) {
	require("db_config.php");
	$sql = "SELECT * FROM job_seeker_experience WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$job_seeker_id]);

	return $result->fetch_all(MYSQLI_ASSOC);	
}

function getSkill($job_seeker_id) {
	require("db_config.php");
	$sql = "SELECT * FROM job_seeker_skill WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$job_seeker_id]);

	return $result->fetch_all(MYSQLI_ASSOC);	
}

function getLanguages() {
	require("db_config.php");
	$sql = "SELECT language_id, name FROM language;";
	$result = $con->execute_query($sql);

	return $result->fetch_all(MYSQLI_ASSOC);	
}

function getLanguageFluency() {
	require("db_config.php");
	$sql = "SELECT language_fluency_id, name FROM language_fluency;";
	$result = $con->execute_query($sql);
	
	return $result->fetch_all(MYSQLI_ASSOC);	
}

function addSkill($job_seeker_id, $description) {
	require("db_config.php");
	$sql = "INSERT INTO job_seeker_skill (job_seeker_id, description) VALUES (?, ?)";
	$result = $con->execute_query($sql, [$job_seeker_id, $description]);
	if (!$result) {
		return 0;
	}

	return 1;
}

function addLanguage($job_seeker_id, $language, $language_fluency) {
	require("db_config.php");
	$sql = "INSERT INTO job_seeker_language (job_seeker_id, language_id, language_fluency_id) VALUES (?, ?, ?)";
	$result = $con->execute_query($sql, [$job_seeker_id, $language, $language_fluency]);
	if (!$result) {
		return 0;
	}

	return 1;
}

function getJobSeekerLanguage($job_seeker_id) {
	require("db_config.php");
	$sql = "SELECT * FROM job_seeker_language WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$job_seeker_id]);

	return $result->fetch_all(MYSQLI_ASSOC);
}

function getLanguageName($language){ 
	require("db_config.php");
	$sql = "SELECT name from language WHERE language_id = ?";
	$result = $con->execute_query($sql, [$language]);

	return $result->fetch_row()[0];
}

function getLanguageFluencyName($language){ 
	require("db_config.php");
	$sql = "SELECT name from language_fluency WHERE language_fluency_id = ?";
	$result = $con->execute_query($sql, [$language]);

	return $result->fetch_row()[0];
}

// Danger zone
function deleteEducation($education_level_id) {
	require("db_config.php");
	$sql = "DELETE FROM job_seeker_education WHERE job_seeker_education_id = $education_level_id";
	echo $sql;
	$result = $con->execute_query($sql);
	
	return $result;
}

function deleteSkill($skill_id) {
	require("db_config.php");
	$sql = "DELETE FROM job_seeker_skill WHERE job_seeker_skill_id = ?";
	$result = $con->execute_query($sql, [$skill_id]);
	
	return $result;
}

function deleteJobSeeker($id) {
	require("db_config.php");
	$sql = "DELETE FROM job_seeker WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$id]);
	if (!$result) {
		return 0;
	}

	return 1;
}

function deleteExperience($id) {
	require("db_config.php");
	$sql = "DELETE FROM job_seeker_experience WHERE job_seeker_experience_id = ?";
	$result = $con->execute_query($sql, [$id]);
	if (!$result) {
		return 0;
	}

	return 1;	
}

function deleteLanguage($job_seeker_language_id) {
	require("db_config.php");
	$sql = "DELETE FROM job_seeker_language WHERE job_seeker_language_id = ?";
	$result = $con->execute_query($sql, [$job_seeker_language_id]);
	if (!$result) {
		return 0;
	}

	return 1;	
}


function updateJobSeeker($id, $firstname, $lastname, $email, $gender, $date_of_birth, $password) {
	require("db_config.php");
	$sql = "UPDATE job_seeker SET first_name = ?, last_name = ?, email = ?, gender = ?, date_of_birth = ?, password = ? WHERE job_seeker_id = ?";
	$result = $con->execute_query($sql, [$firstname, $lastname, $email, $gender, $date_of_birth, $password, $id]);
	if (!$result) {
		return 0;
	}

	return 1;
}