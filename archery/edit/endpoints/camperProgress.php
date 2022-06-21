<?php
	
	require "../../../config.php";

	
	$scoresheetid = $_POST['scoresheetid'];

	$sql = "Select ID FROM Archery_Award";

	$result = $mysqli->query($sql);

	$errorids = array();

	while ($awardid = $result->fetch_assoc()['ID']) {
		$totalscore = $_POST['TotalScore_' . $awardid];
		$monthyear = $_POST['Month/Year_' . $awardid];
		$dateawarded = $_POST['DateAwarded_' . $awardid];

		if ($totalscore == '' || $totalscore == NULL) {

			$sql = "DELETE FROM Archery_PersonAward WHERE AwardID = '" . $awardid . "' AND ScoreSheetID = '" . $scoresheetid . "'";

			$res4 = $mysqli->query($sql);

			continue;
		}

		$sql = "Select ID FROM Archery_PersonAward WHERE AwardID = '" . $awardid . "' AND ScoreSheetID = '" . $scoresheetid . "'";

		echo $sql;

		$res2 = $mysqli->query($sql);
		
		$row_count = $res2->num_rows;

		var_dump($row_count);
   
		if ($row_count > 0) {

			// Edit record
			$sql = "UPDATE Archery_PersonAward
   SET TotalScore = '" . $totalscore . "'
      ,`Month/Year` = " . ($monthyear ? ("'" . $monthyear . "'") : "NULL") . "
      ,DateAwarded = " . ($dateawarded ? ("'" . $dateawarded . "'") : "NULL") . "
      WHERE ScoreSheetID = '" . $scoresheetid . "'
      AND AwardID = '" . $awardid . "'";

		} else {

			// Create record
			$sql = "INSERT INTO Archery_PersonAward
           (ScoreSheetID
           ,AwardID
           ,TotalScore
           ,`Month/Year`
           ,DateAwarded)
     VALUES
           ('" . $scoresheetid . "'
           ,'" . $awardid . "'
           ,'" . $totalscore . "'
           ," . ($monthyear ? ("'" . $monthyear . "'") : "NULL") . "
           ," . ($dateawarded ? ("'" . $dateawarded . "'") : "NULL") . ")";

		}
		//echo $sql;
		$res3 = $mysqli->query($sql);

		var_dump($res3);
		if ($res3) {
			echo "<p style='color:green;'>Award " . $awardid . " entered successfully.</p>";
		} else {
			echo "<p style='color:red;'>Award " . $awardid . " failed: " . $sql . "</p>";
			$errorids[] = $awardid;
		}

	}
	if (count($errorids) == 0)
		echo "<script>window.close();</script>";