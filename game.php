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
			<div><?php echo $_SESSION["username"] ?></div>
			<div>Tokens: <?php //echo $_SESSION["tokens"] ?></div>
			<div>Credits: <?php //echo $_SESSION["credits"] ?></div>
			<div>Albums: <?php //echo $_SESSION["albums"] ?></div>
		</div>
		<div class="sidenav">
			<br style="margin-top: 27px;">
			<input type="button" value="Buildings" onclick="">
			<input type="button" value="Upgrades" onclick="">
			<input type="button" value="Settings" onclick="">
			<div class="obj-info">
				<p>Building name</p>
				<p>Gain (20c)</p>
				<p>Next pay</p>
				<input type="button" value="Upgrade" name="upgrade" disabled>
			</div>
		</div>
		<div class="game">
			<div class="grid-container">
				<?php 
				for ($i=0; $i < 12; $i++) { 
					echo "<button "." id='".$i."' class='grid-item' onclick='somefunc(".$i.")'>"."</button>";
				} ?>

			</div>
		</div>
	</body>
</html>
