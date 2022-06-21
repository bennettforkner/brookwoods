<?php
	
	require "../config.php";

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
			}
			table {
				border-collapse:collapse;
				width:100%;
			}
			th,td {
				text-align:left;
				border-color:black;
				border-width:1px;
				border-style:solid;
				padding:3px;
			}
			.button {
				font-size:22px;
				color:black;
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
				top:10px;
				left:20px;
			}
			input,select {
				padding:5px;
				font-size:16px;
				margin-bottom:15px;
			}
		</style>
		<div id='content'>
			<div class='button back_button' onclick="location.href = '/archery/camperProgressSearch.php'"><b><</b>&nbsp&nbspBack</div>
			<form action='edit/endpoints/createPerson.php' method='post'>
				<input type='text' name='FirstName' placeholder='First Name'>
				<input type='text' name='LastName' placeholder='Last Name'>
				<select name='Gender'>
					<option value selected>Choose a Gender...</option>
					<option value='F'>Female</option>
					<option value='M'>Male</option>
				</select>
				<select name='Type'>
					<option value selected>Choose a Person Type...</option>
					<option value='Camper'>Camper</option>
					<option value='Alumni'>Alumni</option>
					<option value='Staff'>Staff</option>
				</select>
				<input type='submit' value='Create Person'>
			</form>

		</div>
	</body>
</html>
