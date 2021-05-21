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
	$tokens = $rowInfo["tokens"];
	$credits = $rowInfo["credits"];
	$albums= $rowInfo["albums"];
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
		<link rel="stylesheet" type="text/css" href="./styles/loading.css">
		<script type="text/javascript" src="./js/loading.js"></script>
		<script type="text/javascript" src="./js/sidebarActions.js"></script>
		<script type="text/javascript">
			<?php 
			echo "credits = ".$credits.";";
			echo "albums = ".$albums.";";
			echo "tokens = ".$tokens.";";
			 ?>
		</script>
	</head>
	<body onload="setVarSidebar();updateINFO();">
		<div id="main">
			<div class="topnav">
				<input type="button" value="Log Out" onclick="location.href = 'logout.php'">
				<div><?php echo $_SESSION["username"]; ?></div>
				<div id="userInfo" style="padding:0px;">
					<div id="tokensCount">Tokens: <?php echo $tokens; ?></div>
					<div id="creditsCount">Credits: <?php echo $credits; ?></div>
					<div id="albumsCount">Albums: <?php echo $albums; ?></div>
				</div>
			</div>
			<div class="sidenav">
				<input type="button"  id="Buildings" value="Buildings" onclick="setHudActive(this)">
				<input type="button"  id="Upgrades" value="Upgrades" onclick="setHudActive(this)">
				<input type="button"  id="Settings" value="Settings" onclick="setHudActive(this)">
				<div id="obj-info" class="obj-info">
				</div>

				<div id="spinner-front">
					<div id="floatingCirclesG">
						<div class="f_circleG" id="frotateG_01"></div>
						<div class="f_circleG" id="frotateG_02"></div>
						<div class="f_circleG" id="frotateG_03"></div>
						<div class="f_circleG" id="frotateG_04"></div>
						<div class="f_circleG" id="frotateG_05"></div>
						<div class="f_circleG" id="frotateG_06"></div>
						<div class="f_circleG" id="frotateG_07"></div>
						<div class="f_circleG" id="frotateG_08"></div>
					</div>
				</div>
			</div>
			<div class="game">
				<div class="grid-container">
					<?php 
					for ($i=0; $i < 9; $i++) { 
						echo "<button "." id='".$i."' class='grid-item' onclick='getInfoOf(".($i+10000).")'>"."</button>";
					} ?>

				</div>
			</div>
			<div id="shopHUD" class="shop-container" style="display:none;">
				<?php 
				for ($i=0; $i < 4; $i++) { 
					echo "<button "." id='".$i."00"."' class='shop-item' onclick='getInfoOf(".$i.")'>"."</button>";
				} ?>
			</div>
		</div>
		<div id="addins" style="display:none;"></div>
	</body>
	<footer>
		
	</footer>
</html>
