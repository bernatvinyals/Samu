<?php 
	session_start();
	if ($_SESSION["login"] != true) {
		header("Location: login.php");		
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Game - Samu</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./styles/fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/game.css">
	</head>
	<body>
		<div class="topnav">
			<input type="button" value="Log Out" onclick="location.href = 'logout.php'">
		</div>
		<div class="sidenav">
			<br style="margin-top: 27px;">
			<input type="button" value="Buildings" onclick="">
			<input type="button" value="Upgrades" onclick="">
			<input type="button" value="Settings" onclick="">
		</div>
		<div class="game">
			<p><?php echo "Wellcome back ".$_SESSION["username"]; ?></p>
		</div>
	</body>
</html>
