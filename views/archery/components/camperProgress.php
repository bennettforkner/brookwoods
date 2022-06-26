<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	$sql = "SELECT PA.ID,
	CONCAT(RequiredPoints,'@',A.Distance) as Code,
	PA.TotalScore,
	PA.`Month/Year` as MonthYear,
	date_format(PA.DateAwarded,'%m-%d-%Y') as DateAwarded,
	A.Name as AwardName
  FROM Archery_PersonAward PA
  LEFT JOIN Archery_Award A ON PA.AwardID = A.ID
  LEFT JOIN Archery_ScoreSheet SS ON PA.ScoreSheetID = SS.ID
  WHERE SS.ID = " . $_GET['scoresheetid'] . "
  ORDER BY A.OrderIndex asc";
	$result = $mysqli->query($sql);

?>

<html>
	<body>
		<style>
			#content {
				width:80%;
				max-width:1080px;
				background-color:white;
				margin:auto;
				padding:50px;
				margin-top:50px;
				position:relative;
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
			.back_button {
				position:absolute;
				top:10px;
				left:20px;
			}
		</style>
		<div id='content'>
			<div class='button back_button' onclick="location.href = '/archery/camperProgressSearch'">
				<b><</b>&nbsp&nbspBack
			</div>
			<table>
				<tr>
					<th>Name</th>
					<th>Code</th>
					<th>Score</th>
					<th>Date Awarded</th>
				</tr>
				<?php
				if ($result->num_rows > 0) {
					// output data of each row
					while ($row = $result->fetch_assoc()) {
						echo "
							<tr>
								<td>" . $row['AwardName'] . "</td>
								<td>" . $row['Code'] . "</td>
								<td>" . $row['TotalScore'] . "</td>
								<td>" . ($row['DateAwarded'] ? $row['DateAwarded'] : $row['MonthYear']) . "</td>

							</tr>
						";
					}
				}
				?>
			</table>
		</div>
	</body>
</html>
