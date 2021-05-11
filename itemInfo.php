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


$notInGrid=false;
echo "Input: ".$_GET["id"]."<BR>";
if (!isset($_GET["hasToUpgrade"])) {
	$gridSelect=false;
}else{
	$gridSelect=true;
	//Checks if there's a building in the game, if there is we get it's id and show it's next level
	//If there isn't we Display that there's nothing in there and that the player should buy a building
	$resultInfo = mysqli_query($conn, 'SELECT bID, max(bLvl) FROM playerhasbuild WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["id"].' ');

	$rowInfo = mysqli_fetch_assoc($resultInfo);
	if (!$resultInfo) {
		die("You must log in first to perform this action.");
	}
	if (mysqli_num_rows($resultInfo) >=1 && $rowInfo["bID"] >= 1){
		echo print_r($rowInfo);
		$GLOBALS["nextLvl"] = $rowInfo["max(bLvl)"]+1;
		$GLOBALS["selected"] = $rowInfo["bID"];
	}else{$notInGrid=true;}
}

//OUTPUT IN CASE THAT THERES NOTHING ON SELECTED GRID
if ($notInGrid) {
	die("Buy a building to have something in this plot");
}



//OUTPUT INFO IN CASE THAT THERE'S SOMETHING IN GRID OR THAT THE ITEM SELECTED EXISTS
if ($gridSelect == false) {
	$resultInfo = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee FROM buildings WHERE bID = "'.$_GET["id"].'"');
	$rowInfo = mysqli_fetch_assoc($resultInfo);
	echo "<p>Name:".$rowInfo["bName"]."</p>";
} else {
	$resultInfo = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee FROM buildings WHERE bID = "'.$GLOBALS["selected"].'"'); //SELECT THAT POSITION AND DISPLAY WHAT IT IS
	$rowInfo = mysqli_fetch_assoc($resultInfo);
	echo "<p>Name:".$rowInfo["bName"]." (".($GLOBALS["nextLvl"]-1).")</p>";
}


if ($gridSelect == false) {
	echo "<p>Reputation Req: ".$rowInfo["rep"]."</p>";
	echo "<p>Initial Price:".$rowInfo["bPrice"]."</p>";
	echo "<p>Daily Fee: ".($rowInfo["dailyFee"])."</p>";
}else {
	echo "<p>Current Daily Fee: ".($rowInfo["dailyFee"])."</p>";
}

echo "<p>Income/minute: <br>  Credits: ".$rowInfo["credits"]."<br>  Tokens: ".$rowInfo["tokens"]."</p>";
if ($gridSelect == false) {
	echo '<input type="button" value="Buy" onclick="buyByIndex('.$_GET["id"].')" name="buy">';
}else {
	echo '<input type="button" value="Upgrade ('.($rowInfo["dailyFee"]*$GLOBALS["nextLvl"]*1.2).' Credits)" onclick="upgradeByIndex('.$GLOBALS["selected"].",".$GLOBALS["nextLvl"].')" name="upgrade">';
}


mysqli_free_result($resultInfo);
mysqli_close($conn);
 ?>