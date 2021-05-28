<?php 
//Input Position
session_start();
if (!isset($_SESSION["login"]) || !isset($_GET["id"])) {
	die("You must log in first to perform this action.");
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
echo "Input: Pos: ".$_GET["id"]."<BR>";
$resultUpgrade = mysqli_query($conn, 'SELECT bID, max(bLvl), bLvl FROM playerhasbuild WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["id"].' ');
if (!$resultUpgrade) {
	die("You must log in first to perform this action.");
}
$resultUpgradeCheck = mysqli_fetch_assoc($resultUpgrade);
if(mysqli_num_rows($resultUpgrade) >=1){

	$playerREP =0 ;
	$playerTotalCredits=0;
	$playerIndividualCredits=0;
	$check1=GetResources($conn, $playerREP, $playerTotalCredits, $playerIndividualCredits);
	echo $playerREP." ".$playerTotalCredits;
	echo "--".print_r($resultUpgradeCheck);
	if ($check1 && $resultUpgradeCheck["bID"] >= 1){
		$resultBuy = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, dailyFee FROM buildings WHERE bID = "'.($resultUpgradeCheck["bID"]).'"');
		$resultBuyCheck = mysqli_fetch_assoc($resultBuy);
		if (!$resultBuy) {
			die("You must log in first to perform this action.");
		}
		if ($playerTotalCredits>=($resultBuyCheck["dailyFee"]*$_GET["lvl"]*1.2)) {
			//BUY/Alter

			$resultUpgrded = mysqli_query($conn, 'UPDATE playerhasbuild SET bLvl = '.($resultUpgradeCheck["max(bLvl)"]+1).' WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["id"].' ');
			if (!$resultUpgrded) {
				die("You must log in first to perform this action.");
			}

			$minusTokens=floor(($resultBuyCheck["dailyFee"]*1.2)/1000);
			$minusCredits=($resultBuyCheck["dailyFee"]*1.2)%1000;
			if ($playerIndividualCredits-$minusCredits<0){
				$minusTokens +=1;
				$minusCredits = ($playerIndividualCredits+1000)-$minusCredits;
				AlterResources($conn,$minusCredits,$minusTokens,true);
			}
			else{
				AlterResources($conn,$minusCredits,$minusTokens,false);
			}

			echo "Congrats! <br>You just Bought a ".$resultBuyCheck["bName"];
		}
	}
}
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
function AlterResources($conn,$credits,$tokens,$isNegative)
{
	if ($isNegative) {
		$resultRes = mysqli_query($conn, 'UPDATE curxp SET credits = '.$credits.', tokens = (tokens-'.$tokens.') WHERE curxp.userID = '.$_SESSION["userID"].'');
	}else{
		$resultRes = mysqli_query($conn, 'UPDATE curxp SET credits = (credits-'.$credits.'), tokens = (tokens-'.$tokens.') WHERE curxp.userID = '.$_SESSION["userID"].'');
	}
}
 ?>
