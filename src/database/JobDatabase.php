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