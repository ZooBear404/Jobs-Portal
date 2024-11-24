<?php require("../../database/JobDatabase.php") ?>

<?php

$job_application_id = $_GET['job_application_id'];
$job_id = $_GET['job_id'];

JobDatabase\markJobApplicationAsAccepted($job_application_id);
header("Location:job_applicants.php?id=$job_id");


?>
