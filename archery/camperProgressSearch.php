<?php
	
	require "../config.php";
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
			input {
				width:100%;
				padding:10px;
				font-size:18px;
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
			.back_button {
				position:absolute;
				top:10px;
				left:20px;
			}
		</style>
		<div id='content'>
			<?php
				if (isset($_GET['q'])) {
					$q = $_GET['q'];
					$sql = "select distinct P.FirstName,
						P.NickName,
						P.LastName,
						SS.ID as ScoreSheetID,
						P.ID as PersonID,
						SS.Hand
					  FROM Person P
					  LEFT JOIN Archery_ScoreSheet SS ON P.ID = SS.PersonID
					  WHERE CONCAT(FirstName,' ',LastName) like '%" . $q . "%'
					  OR CONCAT(Nickname,' ',LastName) like '%" . $q . "%'
					  order by LastName asc,FirstName asc
					  limit 100";
						$result = $mysqli->query($sql);
					?>

						<div class='button back_button' onclick="location.href = '/archery/camperProgressSearch.php'"><b><</b>&nbsp&nbspBack</div>
						<table>
							<tr>
								<th>First</th>
								<th>Last</th>
								<th></th>
								<th></th>
							</tr>
							<?php
								if ($result->num_rows > 0) {
  									// output data of each row
  									while($row = $result->fetch_assoc()) {
										echo "
											<tr class='data_row'>
												<td>" . $row['FirstName'] . ($row['NickName'] ? (" \"" . $row['NickName'] . "\"") : "") . "</td>
												<td>" . $row['LastName'] . ($row["Hand"] != "RH" && $row["Hand"] != '' ? (" (" . $row['Hand'] . ")") : "") . "</td>
												<td>" . ($row['ScoreSheetID'] ? "<button onclick=\"location.replace('camperProgress.php?scoresheetid=" . $row['ScoreSheetID'] . "')\">View Record</button>" : "") . "</td>
												<td><button onclick=\"parent.location.href = 'edit/camperProgress.php?" . ($row['ScoreSheetID'] ? ("id=" . $row['ScoreSheetID']) : ("id=" . $row['PersonID'] . "&create")) . "';\">" . ($row['ScoreSheetID'] ? "Edit Record" : "Create Record") . "</button></td>
											</tr>
										";
									}
									?></table><?php
								} else {
									?>
								</table>
								No results
									<?php
								}
							?>

					<?php
				} else {
					?>

					<form action='#' method='get'>
						<input id='search' type='text' placeholder='Search for a camper...' name='q'>
					</form>

					<?php
				}
			?>
		</div>
	</body>
	<script>
		document.getElementById('search').focus();
	</script>
</html>
