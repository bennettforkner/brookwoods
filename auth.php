<?php
	session_start();
	$_SESSION['pw'] = $_GET['pw'];

	echo "

	<script>
		setTimeout(() => {
			location.replace('" . $_GET['redirect_to'] . "');
		},1000);
	</script>

	";