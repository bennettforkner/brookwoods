<?php
	
	require "../../config.php";

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
			<h1 class='header_centered'>Archery Award Editor</h1>
		</div>
	</body>
</html>