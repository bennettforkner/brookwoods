<?php
	
$sql = "INSERT INTO Person
	(FirstName,LastName,Gender)
	VALUES
	('" . $_POST['FirstName'] . "','" . $_POST['LastName'] . "','" . $_POST['Gender'] . "')";
	
$res2 = $mysqli->query($sql);

if ($res2) {
	echo "<p style='color:green;'>Person entered successfully.</p>";
	echo "<script>
		location.replace('
			/archery/camperProgressSearch?q=" . $_POST['FirstName'] . " " . $_POST['LastName'] . "
		');
	</script>";
} else {
	echo "<p style='color:red;'>Person failed: " . $sql . "</p>";
}
