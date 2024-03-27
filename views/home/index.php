<?php

$sql = "SELECT * FROM admin_brookwoods.Activity ORDER BY Name ASC";
$activities = $mysqli->query($sql);



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
			}
		</style>
		<div id='content'>
			<h1 class='header_centered'>Camp Brookwoods Web App</h1>
			<div id='funtion_buttons'>
				<?php
					while ($row = $activities->fetch_assoc()) {
						echo "<a href='/activity/" . $row['Slug'] . "'><img src='" . $row['LogoPath'] . "'></a>";
					}
				?>
				<a href='/people'>
					<img src='/static/img/person_icon.png'>
				</a>
			</div>
		</div>
	</body>
</html>