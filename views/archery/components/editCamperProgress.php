<?php

if (isset($_GET['create'])) {
	$personid = $_GET['id'];

	$sql = "INSERT INTO Archery_ScoreSheet (PersonID) VALUES ('" . $personid . "')";

	$mysqli->query($sql);

	$sql = "SELECT ID FROM Archery_ScoreSheet WHERE PersonID = '" . $personid . "' order by DateCreated desc";

	$result = $mysqli->query($sql);

	$row = $result->fetch_assoc();

	$scoresheetid = $row['ID'];

	header('Location: ?id=' . $scoresheetid);
} else {
	$scoresheetid = $_GET['id'];
}

$sql = "SELECT P.FirstName,P.LastName,SS.Hand
FROM Archery_ScoreSheet SS
LEFT JOIN Person P ON SS.PersonID = P.ID
WHERE SS.ID = '" . $scoresheetid . "'";

$person = $mysqli->query($sql);

$sql = "SELECT *,date_format(DateAwarded,'%Y-%m-%d') as DateAwardedV 
FROM Archery_PersonAward
WHERE ScoreSheetID = '" . $scoresheetid . "'";

$pa = $mysqli->query($sql);

$personawards = array();

if ($pa->num_rows > 0) {
	// output data of each row
	while ($row = $pa->fetch_assoc()) {
		$personawards[$row['AwardID']] = $row;
	}
}

$sql = "SELECT *,CONCAT(RequiredPoints,'@',Distance) as CodeName
FROM Archery_Award
ORDER BY OrderIndex asc";

$awards = $mysqli->query($sql);

$awardsarr = array();
	
if ($awards->num_rows > 0) {
	// output data of each row
	while ($row = $awards->fetch_assoc()) {
		$awardsarr[] = $row;
	}
}

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
				overflow:auto;
			}
			.header_centered {
				text-align:center;
				font-size:45px;
			}
			.button {
				font-size:22px;
				color:white;
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
				top:20px;
				left:20px;
				background-color:#22397d;
			}
			.save_button {
				background-color:green;
			}
			.delete_button {
				background-color:red;
			}
			.input_block {
				width:90%;
				float:left;
				margin-right:6px;
				display:inline-block;
				margin-bottom:30px;
			}
			.award {
				width:100%;
				display:inline-block;
				height:50px;
			}
			input {
				width:100%;
				padding:10px;
				font-size:18px;
				height:40px;
			}
			h3 {
				margin-bottom:5px;
				margin-top:5px;
				color:#22397d;
				text-align:right;
				margin-right:20px;
			}
			label {
				margin-bottom:20px;
				text-decoration:underline;
				font-size:18px;
				display:block;
			}
			#autocompletemonthdiv {
				position:absolute;
				right:50px;
				top:50px;

			}
		</style>
		<div id='content'>
			<div id='autocompletemonthdiv'>
				<input type='checkbox'
					checked
					onchange='toggleAutotypeMonth()'
					style='width:20px;height:20px;float:left;cursor:pointer;'>
				<label style='text-decoration:none;'>Auto-Enter Month</label>
			</div>
			<div class='button back_button' onclick="location.href = '<?= $_GET['back_to'] ?>'">
				<b><</b>&nbsp&nbspBack
			</div>
			<h1 class='header_centered'>Archery Awards for 
				<?php
				$row = $person->fetch_assoc();
				echo ($row['FirstName'] . " " . $row['LastName'] . ($row["Hand"] != "RH"
					? (" (" . $row['Hand'] . ")")
					: ""));
				?>
			</h1>
			<form id='editForm' action='/api/camperProgress.php' method='post' target='post_location'>
				<input type='hidden' name='scoresheetid' value='<?php echo $scoresheetid; ?>'>
				
				<div style='width:25%;float:left;display:inline-block;'>
					<label>Award Name</label>
					<?php
					foreach ($awardsarr as $row) {
						$pa = $personawards[$row['ID']];
						echo "
							<div class='award'>
								<h3>" . $row['CodeName'] . "</h3>
								<h5 style='margin-top:-5;
									text-align:right;
									margin-right:20px;
									color: #22397d88;
								'>" . $row['Name'] . "</h5>
							</div>
						";
					}
					?>
				</div>
				<div style='width:25%;float:left;display:inline-block;'>
					<label>Total Score</label>
					<?php
					foreach ($awardsarr as $row) {
						$pa = $personawards[$row['ID']];
						echo "
								<div class='award'>
								<div class='input_block'>
									<input type='text'
										id='" . $row['ID'] . "'
										name='TotalScore_" . $row['ID'] . "'
										value='" . $pa['TotalScore'] . "'
										autocomplete='off'
										onchange='typeScore(this)'
										requiredpoints='" . $row['RequiredPoints'] . "'>
								</div>
							</div>
						";
					}
					?>
				</div>
				<div style='width:25%;float:left;display:inline-block;'>
					<label>Month / Year</label>
					<?php
					foreach ($awardsarr as $row) {
						$pa = $personawards[$row['ID']];
						echo "
							<div class='award'>
								<div class='input_block'>
									<input type='text'
										id='Month/Year_" . $row['ID'] . "'
										name='Month/Year_" . $row['ID'] . "'
										value='" . $pa['Month/Year'] . "'>
								</div>
							</div>
						";
					}
					?>
				</div>
				<div style='width:25%;float:left;display:inline-block;'>
					<label>Date Awarded</label>
					<?php
					foreach ($awardsarr as $row) {
						$pa = $personawards[$row['ID']];
						echo "
							<div class='award'>
								<div class='input_block'>
									<input type='date'
										name='DateAwarded_" . $row['ID'] . "'
										value='" . $pa['DateAwardedV'] . "'>
								</div>
							</div>
						";
					}
					?>
				</div>
				<a onclick='submitForm()'><div class='button save_button'>Save</div></a>
			</form>
			<iframe id=post_location name=post_location style='display:none;'></iframe>
		</div>
	</body>
	<script>
		$(document).bind("keyup keydown", function(e)
		{
			if(e.ctrlKey && e.which == 83) {
				e.preventDefault();
				submitForm();
			}
		});

		function submitForm(){
			document.getElementById('editForm').submit();
			document.getElementById('post_location').onload = () => {
				location.href = '<?= $_GET['back_to'] ?>';
			}
		}

		let autotypemonth = true;

		function typeScore(caller) {
			let score = caller.value;
			let requiredpoints = caller.getAttribute("requiredpoints");
			let awardid = caller.id;
			let monthyear = "" + ((new Date()).getMonth() + 1) + "/" + (new Date()).getFullYear();

			if (score < (requiredpoints - 5) && score != '') {
				alert("Please enter a value that is more than or equal to " + requiredpoints);
				caller.value = '';
				return;
			} else if (score == '') {
				if (autotypemonth) document.getElementById('Month/Year_' + awardid).value = '';
				return;
			}

			if (document.getElementById('Month/Year_' + awardid).value == '') {
				if (autotypemonth) document.getElementById('Month/Year_' + awardid).value = monthyear;
			}
		}

		function toggleAutotypeMonth() {
			autotypemonth = !autotypemonth;
		}

	</script>
</html>