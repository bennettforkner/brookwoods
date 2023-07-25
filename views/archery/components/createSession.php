<?php

	if (isset($_POST['submitted'])) {
		$year = $_POST['year'];
		$code = $_POST['code'];
		$name = $_POST['name'];
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		$location = $_POST['location'];

		$sql = "INSERT INTO Session (Year, Code, Name, StartDate, EndDate, Location)
			VALUES ('" . $year . "', '" . $code . "', '" . $name . "', '" . $startDate . "', '" . $endDate . "', '" . $location . "')";

		$result = $mysqli->query($sql);

		if ($result) {
			echo "<script>alert('Session created successfully!');location.replace('/archery/sessions');</script>";
		} else {
			echo "<script>alert('Error creating session: " . $mysqli->error . "');</script>";
		}
	}

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
		<div id='content'>
			<h2>Create a Session</h2>
			<form action='' method='post'>
				<input type=hidden name=submitted value='1'>
				<table>
					<tr>
						<td>Year</td>
						<td><input type='text' name='year' value='<?= date("Y") ?>'></td>
					</tr>
					<tr>
						<td>Code</td>
						<td>
							<select name='code'>
								<option selected disabled>Select a Code</option>
								<option value='SW'>SW: Staff Week (test)</option>
								<option value='J1'>J1: July 1</option>
								<option value='J2'>J2: July 2</option>
								<option value='A1'>A1: August 1</option>
								<option value='A2'>A2: August 2</option>
								<option value=''>Other</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td><input type='text' name='name' placeholder='e.g. First Two-Weeks'></td>
					</tr>
					<tr>
						<td>Start Date (Sunday)</td>
						<td><input type='date' name='startDate' value='<?= date("Y-m-d") ?>'></td>
					</tr>
					<tr>
						<td>End Date (Saturday)</td>
						<td><input type='date' name='endDate' value='<?= date("Y-m-d") ?>'></td>
					</tr>
					<tr>
						<td>Location</td>
						<td><input type='text' name='location' value='BWDR'></td>
					</tr>
				</table>
				<input type='submit' value='Save' />
			</form>
		</div>
	</body>
</html>