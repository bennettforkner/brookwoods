<?php

$target_dir = "views/archery/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "csv") {
	echo "Sorry, only CSV files are allowed.";
	$uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}

$campers = array_map('str_getcsv', file($target_file));

//print_r($campers);

$sql = "
SELECT * FROM Session
WHERE Code = '" . $_POST['code'] . "' AND Year = '" . $_POST['year'] . "'
";
$session = $mysqli->query($sql)->fetch_assoc();

foreach ($campers as $camper) {
	$serialNumber = $camper[0];
	$firstName = $camper[1];
	$lastName = $camper[2];
	$campName = $camper[3];
	$attendingSession = $camper[4];
	$gender = $camper[5];

	//var_dump($camper);

	$sql = "
		SELECT * FROM Person
		WHERE FileMakerSerial = '" . $serialNumber . "'";
	$result = $mysqli->query($sql);

	if (mysqli_num_rows($result) == 0) {
		// Create
		$sql = "
			INSERT INTO Person (FileMakerSerial, FirstName, LastName, NickName, Gender)
			VALUES ('" . $serialNumber . "', '" . $firstName . "', '" . $lastName . "', '" . $campName . "', '" . ($gender == "Male" ? 'M' : 'F') . "')
		";
		$result = $mysqli->query($sql);

		$camperID = $mysqli->insert_id;
	} else {
		$camper = $result->fetch_assoc();
		$camperID = $camper['ID'];
	}

	$sql = "
		INSERT INTO Camper_Session_Assign (CamperID, SessionID)
		VALUES ('" . $camperID . "', '" . $session['ID'] . "')
	";

	try {
		$mysqli->query($sql);
	} catch (Exception $e) {
		echo "<br/>" . $sql . "<br/>";
		echo $e->getMessage() . "<br/>";
	}
}
