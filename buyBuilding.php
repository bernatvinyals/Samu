<?php 
if (session_status()==1) {
	session_start();
}
if (!isset($_SESSION["login"])) {
	if (!isset($_GET["id"])||!isset($_GET["pos"])) {
		header("Location:login.php");
	}
	die("You must log in first to perform this action.");
}
if (!isset($_GET["id"])||!isset($_GET["pos"])) {
	header("Location:login.php");
	die();
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
//Build info
$resultBuy = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, dailyFee FROM buildings WHERE bID = "'.($_GET["id"]+1).'"');
$resultBuyCheck = mysqli_fetch_assoc($resultBuy);
if (!$resultBuy) {
	die("You must log in first to perform this action.");
}
if (mysqli_num_rows($resultBuy) >=1){
	//Grabs player's info
	$resultResources = mysqli_query($conn, 'SELECT rep, credits, tokens, albums FROM curxp  WHERE userID = "'.$_SESSION["userID"].'";');
	if (!$resultResources) {
		die("Error:".mysqli_error($conn));
	}
	$rowResources = mysqli_fetch_assoc($resultResources);
	$creditsCalc=$rowResources["credits"]+($rowResources["tokens"]*1000);
	//Checks player has enough reputation and the correct amount
	if ($rowResources["rep"]>=$resultBuyCheck["rep"] && $creditsCalc>=$resultBuyCheck["bPrice"]) {
		$resultPositionCheck = mysqli_query($conn, 'SELECT bID, max(bLvl) FROM playerhasbuild WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["pos"].' ');
		if (!$resultPositionCheck) {
			die("Error:".mysqli_error($conn));
		}
		else{
			$rowPositionCheck = mysqli_fetch_assoc($resultPositionCheck);
			//Insert Selected Building to player possesion
			$result = mysqli_query($conn, 'INSERT INTO playerhasbuild (userID, bID, bLvl, bPos, isUpgrading, timestampSec) VALUES ('.$_SESSION["userID"].', '.($_GET["id"]+1).', 1, '.$_GET["pos"].', 0, SYSDATE())');
			if (!$result) {
				echo "Error:".mysqli_error($conn);
				die();
			}
			//Grab the price and slit it to ether add to credit count or subtract
			$minusTokens=floor($resultBuyCheck["bPrice"]/1000);
			$minusCredits=0;
			$minusCredits=$resultBuyCheck["bPrice"]%1000;
			if ($rowResources["credits"]-$minusCredits<0){
				$minusTokens +=1;
				$minusCredits = ($rowResources["credits"]+1000)-$minusCredits;
				AlterResources($conn,$minusCredits,$minusTokens,true);
			}
			else{
				AlterResources($conn,$minusCredits,$minusTokens,false);
			}
			//Output
			die("<h2>Congrats!</h2><p>You just Bought a ".$resultBuyCheck["bName"]."</p>");
		}
	}
	else 
	{//Output if player can't buy
		die("<h2>Out of Luck!</h2><br>You don't have enough Credits/Tokens or Reputation to buy a ".$resultBuyCheck["bName"]."!");
	}
}
//Updates database with the updated results
function AlterResources($conn,$credits,$tokens,$isNegative)
{
	if ($isNegative) {
		$resultRes = mysqli_query($conn, 'UPDATE curxp SET credits = '.$credits.', tokens = (tokens-'.$tokens.') WHERE curxp.userID = '.$_SESSION["userID"].'');
	}else{
		$resultRes = mysqli_query($conn, 'UPDATE curxp SET credits = (credits-'.$credits.'), tokens = (tokens-'.$tokens.') WHERE curxp.userID = '.$_SESSION["userID"].'');
	}
}
 ?>
