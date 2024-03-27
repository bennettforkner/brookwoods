<?php
	$activitySlug = explode('/',$_SERVER['REQUEST_URI'])[2];
	$path = explode('/',$_SERVER['REQUEST_URI']);
	array_splice($path,1,2);
	$path = explode('?',implode('/',$path))[0];
	$activity = $mysqli->query("SELECT * FROM admin_brookwoods.Activity WHERE Slug = '" . $activitySlug . "'")->fetch_assoc();
	
	if ($path == '') {
		$path = '/campers';
	}
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
			.tab {
				display:inline-block;
				padding:5px 15px;
				cursor:pointer;
				border-radius:5px 5px 0px 0px;
				background-color:#eeeeee;
			}
			.tab:hover {
				background-color:#cccccc;
			}
			#data_tab_content {
				width:100%;
				background-color:#aaaaaa;
				width:100%;
				max-width:100%;
				overflow-y: auto;
			}
		</style>
		<div id='content'>
			<h1 class='header_centered'><?= $activity['Name'] ?> Award System</h1>
			<div id='data_tabs'>
				<div class='tabs'>
					<div class='tab' id='campersTab' onclick="openTab('Campers')" style='background-color:#aaaaaa;'>
						Campers
					</div>
					<div class='tab' onclick="openTab('ActivitySignups')">Activity Signups</div>
					<div class='tab' onclick="openTab('AwardsList')">Awards List</div>
					<div class='tab' onclick="openTab('CamperSearch')">Camper Search</div>
				</div>
				<div id='data_tab_content'>
					<?php include_once(__DIR__ . '/pages' . $path . '.php'); ?>
				</div>
			</div>
		</div>
	</body>


	<script>
		function openTab(tabName) {
			var src = "";
			if (tabName == 'Campers') {
				src = ('/activity/<?= $activity['Name'] ?>/campers?year=' + (new Date().getFullYear()));
			} else if (tabName == 'ActivitySignups') {
				src = '/activity/<?= $activity['Name'] ?>/activitySignups';
			} else if (tabName == 'AwardsList') {
				src = '/activity/<?= $activity['Name'] ?>/awards';
			} else if (tabName == 'CamperSearch') {
				src = '/activity/<?= $activity['Name'] ?>/camperProgressSearch';
			}
			location.href = src;

			var tabs = document.getElementsByClassName('tab');
			for (let i = 0; i < tabs.length; i++) {
				tabs[i].style.backgroundColor = "#eeeeee";
			}
			
			caller.style.backgroundColor = "#aaaaaa";
		}

		//openTab(document.getElementById('campersTab'));

		var tabtoopen = '<?= str_replace('/','',$path) ?>';
		if (tabtoopen != '') {
			document.getElementById('data_tab_content').childNodes[1].src = tabtoopen;
			if (tabtoopen == 'campers') {
				document.getElementById('data_tab_content').childNodes[1].src
					+= ('?year=' + (new Date().getFullYear()));
			}

			var tabs = document.getElementsByClassName('tab');
			for (let i = 0; i < tabs.length; i++) {
				tabs[i].style.backgroundColor = "#eeeeee";
				if (tabtoopen == 'campers') {
					if (tabs[i].innerText == 'Campers') tabs[i].style.backgroundColor = "#aaaaaa";
				} else if (tabtoopen == 'activitySignups') {
					if (tabs[i].innerText == 'Activity Signups') tabs[i].style.backgroundColor = "#aaaaaa";
				} else if (tabtoopen == 'awards') {
					if (tabs[i].innerText == 'Awards List') tabs[i].style.backgroundColor = "#aaaaaa";
				} else if (tabtoopen == 'camperProgressSearch') {
					if (tabs[i].innerText == 'Camper Search') tabs[i].style.backgroundColor = "#aaaaaa";
				}
			}
		}
	</script>
</html>