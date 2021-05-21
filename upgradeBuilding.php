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
$resultUpgradeCheck = mysqli_fetch_assoc($resultBuy);
if (!$resultUpgrade) {
	die("You must log in first to perform this action.");
}
if(mysqli_num_rows($resultUpgradeCheck) >=1){

	$playerREP;
	$playerTotalCredits;
	GetResources($conn, $playerREP, $playerTotalCredits);
	if (mysqli_num_rows($resultInfo) >=1 && $rowInfo["bID"] >= 1){
		echo print_r($rowInfo);
		$GLOBALS["nextLvl"] = $resultUpgradeCheck["max(bLvl)"]+1;


		$resultBuy = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, dailyFee FROM buildings WHERE bID = "'.($resultUpgradeCheck["bID"]+1).'"');
		$resultBuyCheck = mysqli_fetch_assoc($resultBuy);
		if (!$resultBuy) {
			die("You must log in first to perform this action.");
		}
		if ($playerTotalCredits>=($resultBuyCheck["dailyFee"]*$GLOBALS["nextLvl"]*1.2)) {
			//BUY/Alter

			

			$minusTokens=floor($resultBuyCheck["dailyFee"]/1000);
			$minusCredits=$resultBuyCheck["dailyFee"]%1000;
			if ($rowResources["credits"]-$minusCredits<0){
				$minusTokens +=1;
				$minusCredits = ($rowResources["credits"]+1000)-$minusCredits;
				AlterResources($conn,$minusCredits,$minusTokens,true);
			}
			else{
				AlterResources($conn,$minusCredits,$minusTokens,false);
			}
			echo "Congrats! <br>You just Bought a ".$resultBuyCheck["bName"];
		}
	}
}
function GetResources ($conn, $outRep, $outTotalCredits){
	$resultResources = mysqli_query($conn, 'SELECT rep, credits, tokens, albums FROM curxp  WHERE userID = "'.$_SESSION["userID"].'";');
	if (!$resultResources) {
		die("Error:".mysqli_error($conn));
	}
	$rowResources = mysqli_fetch_assoc($resultResources);
	$outRep = $rowResources["rep"];
	$outTotalCredits=$rowResources["credits"]+($rowResources["tokens"]*1000);
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
