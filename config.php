<?php

	$config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/config.json'), true);

	session_start();
	echo "
		<head>
		  <title>BW/DR Archery</title>
		  <link rel='icon' type='image/x-icon' href='/img/favicon.ico'>
		</head>
	";
	echo "

	<script>

	if (!" . (isset($_SESSION['pw']) ? 'true' : 'false') . ") {
		let pw = prompt('Please enter the password');
		location.replace('/auth.php?pw=' + pw + '&redirect_to=" . $_SERVER['REQUEST_URI'] . "');
	}

	</script>

	";

	if (!isset($_SESSION['pw']) || $_SESSION['pw'] != $config['site_password']) {
		$_SESSION['pw'] = null;
		die('unauthorized');
	}

	$servername = $config['mysql']['hostname'];
	$username = $config['mysql']['username'];
	$password = $config['mysql']['password'];
	$dbname = $config['mysql']['database'];

	$mysqli = new mysqli($servername, $username, $password, $dbname);