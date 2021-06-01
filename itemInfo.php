<?php //Item info
//Ask get
//Input build to get
session_start();
if (!isset($_SESSION["login"])) {
	die("You must log in first to perform this action.");
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");


$notInGrid=false;//Sets check to know if the info is from the store or the Game Grid
//False = Store
if (!isset($_GET["hasToUpgrade"])) {//If there's no parameter as "hasToUpgrade" then set grid as false;  
	$gridSelect=false;
}else{
	$gridSelect=true;
	$_GET["id"]=$_GET["id"]-1;
	//Checks if there's a building in the game, if there is we get it's id and show it's next level
	//If there isn't we Display that there's nothing in there and that the player should buy a building
	$resultInfo = mysqli_query($conn, 'SELECT bID, max(bLvl) FROM playerhasbuild WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["id"].' ');

	$rowInfo = mysqli_fetch_assoc($resultInfo);
	if (!$resultInfo) {
		die("You must log in first to perform this action.");
	}
	if (mysqli_num_rows($resultInfo) >=1 && $rowInfo["bID"] >= 1){
		$GLOBALS["nextLvl"] = $rowInfo["max(bLvl)"]+1;
		$GLOBALS["selected"] = $rowInfo["bID"];
	}else{$notInGrid=true;}
}

//OUTPUT IN CASE THAT THERES NOTHING ON SELECTED GRID
if ($notInGrid) {
	die("Buy a building to have something in this plot");
}

//OUTPUT INFO IN CASE THAT THERE'S SOMETHING IN GRID OR THAT THE ITEM SELECTED EXISTS
//Output preview:
//Building Image
//Name:Tower
//Reputation Req: 1000
//Initial Price:5600
//Income/minute:
//Credits: X
if ($gridSelect == false) {
	$resultInfo = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, credits, dailyFee FROM buildings WHERE bID = "'.($_GET["id"]+1).'"');
	$rowInfo = mysqli_fetch_assoc($resultInfo);
	echo "<div style='background-image: url(./img/".($_GET["id"]+1)."_building.png);padding-top: 100%;background-size: cover;'></div>";
	echo "<h2>Name: ".$rowInfo["bName"]."</h2>";
	echo "<p>Reputation Req: ".$rowInfo["rep"]."</p>";
	echo "<p>Initial Price:".$rowInfo["bPrice"]."</p>";
	echo "<p>Income/minute: <br>  Credits: ".$rowInfo["credits"]."</p>";
	echo '<div class="posSelector-container">';
	$isbuy=true;
	require "imageUpdateAjax.php";
	echo "</div>";
	echo '<input type="button" value="Buy" onclick="buyByIndex('.$_GET["id"].');updateGFX();" name="buy">';//Button to onClick send what the player wants to buy
}else {
	$resultInfo = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, credits, dailyFee FROM buildings WHERE bID = "'.$GLOBALS["selected"].'"'); //SELECT THAT POSITION AND DISPLAY WHAT IT IS
	$rowInfo = mysqli_fetch_assoc($resultInfo);
	echo "<div style='background-image: url(./img/".($GLOBALS["selected"])."_building.png);padding-top: 100%;background-size: cover;'></div>";
	echo "<h2>Name: ".$rowInfo["bName"]." (".($GLOBALS["nextLvl"]-1).")</h2>";
	mysqli_free_result($resultInfo);
	echo "<p>Income/minute: <br>  Credits: ".$rowInfo["credits"]*(($GLOBALS["nextLvl"]-1)*1.2)."</p>";
	echo "<p>Next Level, Income/minute: <br>  Credits: ".$rowInfo["credits"]*(($GLOBALS["nextLvl"])*1.2)."</p>";
	echo '<input type="button" value="Upgrade ('.($rowInfo["dailyFee"]*($GLOBALS["nextLvl"]*1.2)).' Credits)" onclick="updateINFO();upgradeByIndex('.$_GET["id"].",".$GLOBALS["nextLvl"].')" name="upgrade" style="font-size: 1.5rem;" >';
	echo "<input type='button' style='background-color:red;' value='Remove Building' ondblclick='buyPos=".$_GET["id"].";updateGFX();updateINFO();removeBuild();'>";
}
mysqli_close($conn);
 ?>