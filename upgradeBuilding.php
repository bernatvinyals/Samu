<?php 
//Input Position
//Checks if Login
session_start();
if (!isset($_SESSION["login"]) || !isset($_GET["id"])) {
	header("Location:login.php");
	die("You must log in first to perform this action.");
}
//Connects to Database
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
//Grabs current Build info
$resultUpgrade = mysqli_query($conn, 'SELECT bID, max(bLvl), bLvl FROM playerhasbuild WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["id"].' ');
if (!$resultUpgrade) {
	die("You must log in first to perform this action.");
}
$resultUpgradeCheck = mysqli_fetch_assoc($resultUpgrade);
if(mysqli_num_rows($resultUpgrade) >=1){
	//Set Variables
	$playerREP =0 ;														//Used to know current Reputation
	$playerTotalCredits=0;												//Combined amount of credits and tokens
	$playerIndividualCredits=0; 										//Player's credits only
	$check1=GetResources($conn, $playerREP, $playerTotalCredits, $playerIndividualCredits);
	if ($check1 && $resultUpgradeCheck["bID"] >= 1){//We check for errors and check that there's a building in that position
		//Pulls the building info of that position
		$resultBuy = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, dailyFee FROM buildings WHERE bID = "'.($resultUpgradeCheck["bID"]).'"');
		$resultBuyCheck = mysqli_fetch_assoc($resultBuy);
		if (!$resultBuy) {
			die("You must log in first to perform this action.");
		}
		if ($playerTotalCredits>=($resultBuyCheck["dailyFee"]*$_GET["lvl"]*1.2)) {//Checks that player has enough credits for the update
			//Change the current lvl for the new one 
			$resultUpgrded = mysqli_query($conn, 'UPDATE playerhasbuild SET bLvl = '.($resultUpgradeCheck["max(bLvl)"]+1).' WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["id"].' ');
			if (!$resultUpgrded) {
				die("You must log in first to perform this action.");
			}
			//Grab the price and split it to ether add to credit count or subtract
			$minusTokens=floor(($resultBuyCheck["dailyFee"]*($resultUpgradeCheck["max(bLvl)"]+1)*1.2)/1000);
			$minusCredits=($resultBuyCheck["dailyFee"]*($resultUpgradeCheck["max(bLvl)"]+1)*1.2)%1000;
			if ($playerIndividualCredits-$minusCredits<0){
				$minusTokens +=1;
				$minusCredits = ($playerIndividualCredits+1000)-$minusCredits;
				AlterResources($conn,$minusCredits,$minusTokens,true);
			}
			else{
				AlterResources($conn,$minusCredits,$minusTokens,false);
			}

			echo "<h2>Congrats!</h2><p>You just Upgraded the ".$resultBuyCheck["bName"]."</p>";
		}
		else{
			echo "<h2>Good luck with that!</h2><p>You can't currently upgrade the ".$resultBuyCheck["bName"]."</p>";
		}
	}
}
//Connects to database and returns Total amount of credits, reputation and just credits
function GetResources ($conn, &$outRep, &$outTotalCredits, &$individualCredits){
	$resultResources = mysqli_query($conn, 'SELECT rep, credits, tokens, albums FROM curxp  WHERE userID = "'.$_SESSION["userID"].'";');
	if (!$resultResources) {
		die("Error:".mysqli_error($conn));
		return fasle;
	}
	$rowResources = mysqli_fetch_assoc($resultResources);
	$outRep = $rowResources["rep"];
	$individualCredits = $rowResources["credits"];
	$outTotalCredits=$rowResources["credits"]+($rowResources["tokens"]*1000);
	return true;
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
