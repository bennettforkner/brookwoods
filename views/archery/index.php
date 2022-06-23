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
				height:30vw;
				background-color:#aaaaaa;
			}
			#data_tab_content iframe {
				width:100%;
				max-width:100%;
				height:100%;
				border-width:0px;
			}
		</style>
		<div id='content'>
			<h1 class='header_centered'>Archery Award System</h1>
			<div id='data_tabs'>
				<div class='tabs'>
					<div class='tab' id='campersTab' onclick="openTab(this)" style='background-color:#aaaaaa;'>
						Campers
					</div>
					<div class='tab' onclick="openTab(this)">Activity Signups</div>
					<div class='tab' onclick="openTab(this)">Awards</div>
					<div class='tab' onclick="openTab(this)">Camper Progress</div>
					<div class='tab' onclick="openTab(this)">Create Person</div>
				</div>
				<div id='data_tab_content'>
					<iframe></iframe>
				</div>
			</div>
		</div>
	</body>


	<script>
		function openTab(caller) {
			var src = "";
			if (caller.innerText == 'Campers') {
				src = ('/archery/campers?year=' + (new Date().getFullYear()));
			} else if (caller.innerText == 'Activity Signups') {
				src = '/archery/activitySignups';
			} else if (caller.innerText == 'Awards') {
				src = '/archery/awards';
			} else if (caller.innerText == 'Camper Progress') {
				src = '/archery/camperProgressSearch';
			} else if (caller.innerText == 'Create Person') {
				src = '/archery/createPerson';
			}
			document.getElementById('data_tab_content').childNodes[1].src = src;

			var tabs = document.getElementsByClassName('tab');
			for (let i = 0; i < tabs.length; i++) {
				tabs[i].style.backgroundColor = "#eeeeee";
			}
			
			caller.style.backgroundColor = "#aaaaaa";
		}

		openTab(document.getElementById('campersTab'));

		var tabtoopen = '<?= isset($_GET['tab']) ? $_GET['tab'] : "" ?>';
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
					if (tabs[i].innerText == 'Awards') tabs[i].style.backgroundColor = "#aaaaaa";
				} else if (tabtoopen == 'camperProgressSearch') {
					if (tabs[i].innerText == 'Camper Progress') tabs[i].style.backgroundColor = "#aaaaaa";
				} else if (tabtoopen == 'createPerson') {
					if (tabs[i].innerText == 'Create Person') tabs[i].style.backgroundColor = "#aaaaaa";
				}
			}
		}
	</script>
</html>