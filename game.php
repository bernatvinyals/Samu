<?php 
	session_start();
	if ($_SESSION["login"] != true) {
		header("Location: login.php");	
		die();	
	}
	include "globals.php";
	$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);

	mysqli_select_db($conn, "db_sumus");
	$resultInfo = mysqli_query($conn, 'SELECT curxp.rep, curxp.credits, curxp.tokens, curxp.albums FROM (curxp INNER JOIN users ON users.username = "'.$_SESSION["username"].'");');
		if (!$resultInfo) {
			echo "Error:".mysqli_error($conn);
			header("Location: logout.php");
			die();
		}
	$rowInfo = mysqli_fetch_assoc($resultInfo);
	$_SESSION["tokens"] = $rowInfo["tokens"];
	$_SESSION["credits"] = $rowInfo["credits"];
	$_SESSION["albums"] = $rowInfo["albums"];
	mysqli_free_result($resultInfo);
	mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Game - Samu</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./styles/fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/game.css">
		<script type="text/javascript" src="./js/sidebarActions.js"></script>
	</head>
	<body onload="setVarSidebar();">
		<div id="hud">
			<div class="topnav">
				<input type="button" value="Log Out" onclick="location.href = 'logout.php'">
				<div><?php echo $_SESSION["username"]; ?></div>
				<div>Tokens: <?php echo $_SESSION["tokens"]; ?></div>
				<div>Credits: <?php echo $_SESSION["credits"]; ?></div>
				<div>Albums: <?php echo $_SESSION["albums"]; ?></div>
			</div>
			<div class="sidenav">
				<input type="button"  id="Buildings" value="Buildings" onclick="setHudActive(this)">
				<input type="button"  id="Upgrades" value="Upgrades" onclick="setHudActive(this)">
				<input type="button"  id="Settings" value="Settings" onclick="setHudActive(this)">
				<div id="obj-info" class="obj-info">
				</div>
			</div>
			<div id="shopHUD" class="shop-container" style="display:none;">
				<?php 
				for ($i=0; $i < 6; $i++) { 
					echo "<button "." id='".$i."00"."' class='shop-item' onclick='getInfoOf(".$i.")'>"."</button>";
				} ?>
			</div>
		</div>

		<div class="game">
			<div class="grid-container">
				<?php 
				for ($i=0; $i < 12; $i++) { 
					echo "<button "." id='".$i."' class='grid-item' onclick='isHudActive(".$i.")'>"."</button>";
				} ?>

			</div>
		</div>
	</body>
	<footer>
		
	</footer>
</html>
