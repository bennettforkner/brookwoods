<?php
	session_start();
	echo $_GET['pw'];
	$_SESSION['pw'] = $_GET['pw'];

	echo $_SESSION['pw'];

	echo "

	<script>
		setTimeout(() => {
			location.replace('" . $_GET['redirect_to'] . "');
		},1000);
	</script>

	";
