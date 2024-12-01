<?php
require("../../database/CompanyDatabase.php");
$company_id = $_GET['id'];
$result = CompanyDatabase\deleteCompany($company_id);
if ($result) {
	echo "<p>Deleted Successfully</p>";
} else {
	echo "<p>An error occurred</p>";
}

sleep(3);
header("Location:../../");


?>