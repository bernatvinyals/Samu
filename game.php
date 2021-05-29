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
mysqli_free_result($resultInfo);

$resultQTimestamp =  mysqli_query($conn, 'SELECT lastLoginTime+0 FROM users WHERE userID = '.$_SESSION["userID"].'' );
$rowQTimestamp = mysqli_fetch_assoc($resultQTimestamp);
$rDBtime =  mysqli_query($conn, 'SELECT CURRENT_TIMESTAMP()+0');
$rowrDBtime = mysqli_fetch_assoc($rDBtime);
$minutesFromLastLogin = intval(($rowrDBtime["CURRENT_TIMESTAMP()+0"]- $rowQTimestamp["lastLoginTime+0"])/60);


$resultUpgrade = mysqli_query($conn,"UPDATE users SET lastLoginTime = NOW() WHERE users.userID = ".$_SESSION["userID"]."");
if (!$resultUpgrade) {
	die("You must log in first to perform this action.");
}
$result = mysqli_query($conn,"SELECT bID, bLvl FROM playerhasbuild WHERE userID = ".$_SESSION["userID"]."");
if (!$result) {
	die("Error:".mysqli_error($conn));
}
if (mysqli_num_rows($result) > 0) {
	$TotalCredits=0;
	while($row = mysqli_fetch_assoc($result)) {
  		$resultOfBuilding = mysqli_query($conn,"SELECT credits FROM buildings WHERE bID = ".$row["bID"]."");

  		if (!$resultOfBuilding) {
			die("Error:".mysqli_error($conn));
		}
  		$rowOfBuilding = mysqli_fetch_assoc($resultOfBuilding);

  		if ($row["bLvl"]>1) {
  			$TotalCredits += $rowOfBuilding["credits"]*($row["bLvl"]+.2);
  		}else{
			$TotalCredits += $rowOfBuilding["credits"];
  		}
	}
	$selectUserInfo = mysqli_query($conn,"SELECT rep, credits, tokens FROM curxp WHERE userID = ".$_SESSION["userID"]."");
	if (!$selectUserInfo) {
		die("Error:".mysqli_error($conn));
	}
	$rowUserInfo=mysqli_fetch_assoc($selectUserInfo);
	$TotalCredits = $TotalCredits * $minutesFromLastLogin;
	$Tokens=floor($TotalCredits/1000);
	$Credits=$TotalCredits%1000;

	if ($rowUserInfo["credits"]+$Credits>1000){
		$Tokens +=1;
		$Credits = ($rowUserInfo["credits"]-1000)+$Credits;
  		AlterResources($conn,$Credits,$Tokens,true);
	}
	else{
		AlterResources($conn,$Credits,$Tokens,false);
	}
}
function AlterResources($conn,$credits,$tokens,$isNegative)
{
	if ($isNegative) {
		$resultRes = mysqli_query($conn, 'UPDATE curxp SET credits = '.$credits.', tokens = (tokens+'.$tokens.') WHERE curxp.userID = '.$_SESSION["userID"].'');
	}else{
		$resultRes = mysqli_query($conn, 'UPDATE curxp SET credits = (credits+'.$credits.'), tokens = (tokens+'.$tokens.') WHERE curxp.userID = '.$_SESSION["userID"].'');
	}
}
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
		<script type="text/javascript" src="./js/gfx.js"></script>
		<script type="text/javascript">
			<?php 
			echo "credits = ".$credits.";";
			echo "tokens = ".$tokens.";";
			 ?>
		</script>
	</head>
	<body onload="setVarSidebar();updateINFO();setTimeout(upateResources,60000);" >
		<div id="main">
			<div class="topnav">
				<input type="button" value="Log Out" onclick="location.href = 'logout.php'">
				<div><?php echo $_SESSION["username"]; ?></div>
				<div id="userInfo" style="padding:0px;">
					<div id="tokensCount">Tokens: <?php echo $tokens; ?></div>
					<div id="creditsCount">Credits: <?php echo $credits; ?></div>
				</div>
			</div>
			<div class="sidenav">
				<input type="button"  id="Buildings" value="Buildings" onclick="setHudActive(this)">
				<input type="button"  style="display:none;" id="Upgrades" value="Upgrades" onclick="setHudActive(this)">
				<input type="button"  style="display:none;" id="Settings" value="Settings" onclick="setHudActive(this)">
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
			<div id="gameBody" class="game">
				<div id="gameGrid" class="grid-container">
					<?php 
					require "imageUpdateAjax.php";
					?>

				</div>
			</div>
			<div id="shopHUD" class="shop-container" style="display:none;">
				<?php 
				for ($i=0; $i < 4; $i++) { 
					echo "<button "." id='".$i."00"."' class='shop-item' style='background-image: url(./img/".($i+1)."_building.png);' onclick='getInfoOf(".$i.")'>"."</button>";
				} ?>
			</div>
		</div>
		<div id="addins" style="display:none;"></div>
	</body>
	<footer>
	</footer>
</html>
<?php mysqli_close($conn); ?>
