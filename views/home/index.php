<?php
	$activities = $_db->getActivities();
?>
<html>
	<head></head>
	<body style='background-color:#22397d'>
		<style>
			#content {
				width:80%;
				max-width:1080px;
				background-color:white;
				margin:auto;
				padding:50px;
				margin-top:50px;
			}
			.header_centered {
				text-align:center;
				font-size:45px;
			}
			#funtion_buttons a img {
				width:19%;
				height:15vw;
				max-height:200px;
			}
			#funtion_buttons a img:hover {
				background-color:#bbbbbb;
				background:filter(80%);
				filter: brightness(80%);
			}
		</style>
		<div id='content'>
			<h1 class='header_centered'>Camp Brookwoods Web App</h1>
			<div id='funtion_buttons' style='display: flex;'>
				<?php foreach ($activities as $activity) { ?>
					<div>
						<a href='/<?= $activity['slug'] ?>' style='text-decoration: none;color: inherit;margin: 15px;'>
							<img src='<?= $activity['icon_path'] ?>' style='width: 120px; height: 120px;'>
						</a>
						<h4 style='text-align: center;font-size: 24px;margin: 10px;'><?= $activity['name'] ?></h4>
					</div>
				<?php } ?>
			</div>
		</div>
	</body>
</html>