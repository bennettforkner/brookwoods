<?php
	require "../config.php";

	$sql = "select *,CONCAT(RequiredPoints,'@',Distance) as CodeName from Archery_Award order by OrderIndex asc";
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
			<table>
				<tr>
					<th>Award Name</th>
					<th>Code</th>
					<th>Distance</th>
					<th>Required Points</th>
				</tr>
				<?php
					if ($result->num_rows > 0) {
  						// output data of each row
  						while($row = $result->fetch_assoc()) {
							echo "<tr>
								<td>" . $row['Name'] . "</td>
								<td>" . $row['CodeName'] . "</td>
								<td>" . $row['Distance'] . " yds.</td>
								<td>" . $row['RequiredPoints'] . "</td>
							</tr>";
						}
					}

				?>
			</table>
		</div>
	</body>
</html>