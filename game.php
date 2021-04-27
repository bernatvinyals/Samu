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
		<link rel="stylesheet" type="text/css" href="./styles/game.css">
	</head>
	<body>
		<div class="sidenav">Sidebar</div>
		<div class="topnav">
			<ul>
				<li><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
		<div class="game">
			<p><?php echo "Wellcome back ".$_SESSION["username"]; ?></p>
		</div>
	</body>
</html>
