<?php
	$sql = "select *,CONCAT(Code,' ',Year) as CodeName, CONCAT(Year, ' ', Name) as FullName from Session order by StartDate desc";
	$result = $mysqli->query($sql);

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
	ORDER BY EndDate DESC
	LIMIT 30";

	$allSessions = $mysqli->query($sql);

	$sql = "
		SELECT * FROM `Person` P
		INNER JOIN Camper_Session_Assign CSA ON P.ID = CSA.CamperID
		INNER JOIN Session S ON CSA.SessionID = S.ID
		WHERE S.Year = '" . $year . "'
		AND S.Code = '" . $code . "'
	";
	$campers = $mysqli->query($sql);

?>
<html>
	<head>
		<style>
			button {
				cursor:pointer;
			}
			.button {
				font-size:22px;
				color:black;
				border-radius:5px;
				padding:5px 15px;
				text-decoration:none;
				display:inline-block;
				cursor:pointer;
			}
			.button:hover {
				background-color:#bbbbbb;
			}
		</style>
	</head>
	<body style='margin:20px;'>
		<style>
			#content {
				width:80%;
				max-width:1080px;
				background-color:white;
				margin:auto;
				padding:50px;
				margin-top:50px;
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
		<div id='content'>
			<h2>Session Management</h2>
			<table>
				<tr>
					<th>Session Name</th>
					<th>Code</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
				<?php
				if ($result->num_rows > 0) {
					// output data of each row
					while ($row = $result->fetch_assoc()) {
						echo "<tr>
							<td>" . $row['FullName'] . "</td>
							<td>" . $row['CodeName'] . "</td>
							<td>" . $row['StartDate'] . "</td>
							<td>" . $row['EndDate'] . "</td>
						</tr>";
					}
				}

				?>
			</table>
			<button onclick="location.href = '/archery/createSession'">Create Session</button>
			<br/>
			<br/>
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

			<h3>Connected Campers</h3>
			<table>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
				</tr>
				<?php

				if ($campers->num_rows > 0) {
					// output data of each row
					while ($row = $campers->fetch_assoc()) {
						echo "<tr>
							<td>" . $row['FirstName']
							. ($row['NickName'] ? (" \"" . $row["NickName"]
							. "\"") : "") . "</td>
							<td>" . $row['LastName'] . "</td>
						</tr>";
					}
				}

				?>
			</table>
			<form action="/archery/uploadSessionCampers" method="post" enctype="multipart/form-data">
				<input type="hidden" name="year" value="<?= $year ?>">
				<input type="hidden" name="code" value="<?= $code ?>">
				Upload List of Active Campers:
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" value="Upload List" name="submit">
			</form>
			<p>
				** When uploading the file, please make sure to use the following format:<br/>
				<b>FileMaker Serial Number | First Name | Last Name | Nick Name | Attending Session | Gender</b>
			</p>
		</div>
	</body>
	<script>
		function changeSession(sessionInfo) {
			sessionInfo = JSON.parse(sessionInfo);
			location.href = "?year=" + sessionInfo.year + "&code=" + sessionInfo.code;
		}
	</script>
</html>