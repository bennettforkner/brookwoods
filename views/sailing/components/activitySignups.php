<?php

	$sql = "SELECT *
	FROM Session
	WHERE EndDate > CURRENT_TIMESTAMP
	AND StartDate < CURRENT_TIMESTAMP
	ORDER BY EndDate asc
	LIMIT 1";

	$activeSession = $mysqli->query($sql)->fetch_assoc();

	$year = isset($_GET['year']) ? $mysqli->real_escape_string($_GET['year']) : $activeSession['Year'];
	$code = isset($_GET['code']) ? $mysqli->real_escape_string($_GET['code']) : $activeSession['Code'];

	$sql = "SELECT *
	FROM Session
	WHERE EndDate > DATE_SUB(NOW(), INTERVAL 5 YEAR)
	ORDER BY EndDate DESC";

	$allSessions = $mysqli->query($sql);

	$sql = "CALL `Get Activity Signups List`(" . $year . ",'" . $code . "')";

	$result = $mysqli->query($sql);

?>

<html>
	<body style='margin:20px;'>
		<style>
			#content {
				width:80%;
				max-width:1080px;
				background-color:white;
				margin:auto;
				padding:50px;
				margin-top:50px;
				padding-top:5px;
			}
			table {
				border-collapse:collapse;
				width:100%;
			}
			th,td {
				text-align:left;
				border-color:black;
				border-width:1px;
				border-style:solid;
				padding:3px;
			}

		</style>
		<div id='content' style='position:relative;'>

			
			<h1 style='text-align:center;'>Activity Signups List</h1>
			<a href='/api/downloadActivitySignupsList.php?year=<?= $year ?>&code=<?= $code ?>'
				target='post_location'
				style='text-decoration:none;
					padding:3px;
					border-color:#333333;
					border-style:solid;
					border-width:1px;
					border-radius:3px;
					color:black;
					display:block;
					position:absolute;
					top:10px;
					right:10px;
				'>
				Export List
			</a>
			<iframe name=post_location style='height:0px;width:0px;border-style:none;'></iframe>
			<select onchange="changeSession(this.value)" style='display:block;margin:auto;margin-bottom:20px;'>
				<?php
				while ($row = $allSessions->fetch_assoc()) {
					$selected = $row['Year'] == $year && $row['Code'] == $code ? "selected" : "";
					$optionName = $row['Year'] . " - " . $row['Name'];
					echo "
						<option " . $selected . " value='
						{\"year\":\"" . $row['Year'] . "\",\"code\":\"" . $row['Code'] . "\"}
						'>" . $optionName . "</option>
					";
				}
				?>
			</select>
			<table>
				<tr>
					<th>Name</th>
					<th>Gender</th>
					<th>Max Award</th>
					<th>Date Awarded</th>
					<th>Next Award</th>
				</tr>
				<?php

				if ($result->num_rows > 0) {
					// output data of each row
					while ($row = $result->fetch_assoc()) {
						$name = $row['LastName'] . ", " . $row['FirstName']
						. ($row['NickName'] ? (" \"" . $row["NickName"]
						. "\"") : "");
						echo "<tr>
							<td>" . $name . "</td>
							<td>" . $row['Gender'] . "</td>
							<td>" . $row['MaxAward'] . "</td>
							<td>" . $row['MaxAwardDate'] . "</td>
							<td>" . $row['NextAward'] . "</td>
						</tr>";
					}
				}

				?>
			</table>
		</div>
	</body>
	<script>
		function changeSession(sessionInfo) {
			sessionInfo = JSON.parse(sessionInfo);
			location.href = "?year=" + sessionInfo.year + "&code=" + sessionInfo.code;
		}
	</script>
</html>