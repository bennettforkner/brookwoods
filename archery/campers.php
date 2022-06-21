<?php
	require "../config.php";

	$where = '';
	$order = "order by LastName asc,FirstName asc";
	if (isset($_GET['sort'])) {
		switch ($_GET['sort']) {
			case "lna":
				$order = "order by LastName asc,FirstName asc";
				break;
			case "awddte":
				$order = "order by CONVERT(INT,SUBSTRING([Month/Year],3,4)) desc,CONVERT(INT,SUBSTRING([Month/Year],1,CHARINDEX('/',[Month/Year]) - 1)) desc";
				break;
			default:
				$order = "order by LastName asc,FirstName asc";
		}
	}

	if (isset($_GET['year']) && strlen($_GET['year']) == 4) {
		$where = "WHERE (`Month/Year` LIKE CONCAT('%'," . $_GET['year'] . ") OR YEAR(MaxDateAwarded) = " . $_GET['year'] . ")";
	}

	$sql = "select DISTINCT * from Archery_Person_Cache
	" . $where . "
	" . $order . "
	";

	$result = $mysqli->query($sql);


	$sql = "
		SELECT DISTINCT Substring_Index(`Month/Year`,'/',-1) as Year
		FROM `Archery_PersonAward`
		ORDER BY Year Desc
	";

	$years = $mysqli->query($sql);

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
		<div id='content'>

			<select id='yearSelect' onchange="changeYear()">
			<?php
				if (!isset($_GET['year']) || $row['Year'] == $_GET['year']) {
					$selected = "selected";
				}
				echo "<option value=" . date("Y") . " " . $selected . ">" . date("Y") . "</option>";
				while($row = $years->fetch_assoc()) {
					$selected = '';
					if (isset($_GET['year']) && $row['Year'] == $_GET['year']) {
						$selected = "selected";
					}
					echo "<option value=" . $row['Year'] . " " . $selected . ">" . $row['Year'] . "</option>";
				}
			?>
			</select>
			<h1 style='text-align:center;'>Current Year Campers</h1>
			<table>
				<tr>
					<th>First</th>
					<th>Last</th>
					<th>Max Award</th>
					<th>Date Awarded</th>
				</tr>
				<?php

					if ($result->num_rows > 0) {
  						// output data of each row
  						while($row = $result->fetch_assoc()) {
							echo "<tr>
								<td>" . $row['FirstName'] . "</td>
								<td>" . $row['LastName'] . "</td>
								<td>" . $row['MaxAward'] . "</td>
								<td>" . $row['MaxAwardDate'] . "</td>
							</tr>";
						}
					}

				?>
			</table>
		</div>
	</body>
	<script>
		function changeYear() {
			location.href = "?year=" + document.getElementById('yearSelect').value;
		}
	</script>
</html>