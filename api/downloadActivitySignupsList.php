<?php

// Fetch records from database
$query = $mysqli->query("CALL `Get Activity Signups List`(" . $mysqli->real_escape_string($_GET['year']) . ",'" . $mysqli->real_escape_string($_GET['code']) . "')");
 
if ($query->num_rows > 0) {
	$delimiter = ",";

	$filename = "activity_signups_archery_" . $_GET['year'] . $_GET['code'] . ".csv";
	 
	// Create a file pointer
	$f = fopen('php://memory', 'w');
	 
	// Set column headers
	$fields = array('FirstName', 'LastName', 'DOB', 'Gender', 'AA', 'MaxAward', 'MaxAwardDate', 'NextAward');
	fputcsv($f, $fields, $delimiter);
	 
	// Output each row of the data, format line as csv and write to file pointer
	while ($row = $query->fetch_assoc()) {
		$lineData = array($row['FirstName'], $row['LastName'], $row['DOB'], $row['Gender'], $row['AA'], $row['MaxAwardCode'], $row['MaxAwardDate'], $row['NextAwardCode']);
		fputcsv($f, $lineData, $delimiter);
	}
	 
	// Move back to beginning of file
	fseek($f, 0);
	 
	// Set headers to download file rather than displayed
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="' . $filename . '";');
	 
	// Output all remaining data on a file pointer
	fpassthru($f);
}
