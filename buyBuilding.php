<?php 
session_start();
if (!isset($_SESSION["login"])) {
	die("You must log in first to perform this action.");
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
echo "Input: ".($_GET["id"]+1)."<BR>";
$resultBuy = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, dailyFee FROM buildings WHERE bID = "'.($_GET["id"]+1).'"');
$resultBuyCheck = mysqli_fetch_assoc($resultBuy);
if (!$resultBuy) {
	die("You must log in first to perform this action.");
}
if (mysqli_num_rows($resultBuy) >=1){
	$resultResources = mysqli_query($conn, 'SELECT rep, credits, tokens, albums FROM curxp  WHERE userID = "'.$_SESSION["userID"].'";');
	if (!$resultResources) {
		die("Error:".mysqli_error($conn));
	}
	$rowResources = mysqli_fetch_assoc($resultResources);
	$creditsCalc=$rowResources["credits"]+($rowResources["tokens"]*1000);
	if ($rowResources["rep"]>=$resultBuyCheck["rep"] && $creditsCalc>=$resultBuyCheck["dailyFee"]) {
		$resultPositionCheck = mysqli_query($conn, 'SELECT bID, max(bLvl) FROM playerhasbuild WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["pos"].' ');
		if (!$resultPositionCheck) {
			die("Error:".mysqli_error($conn));
		}else{
			$rowPositionCheck = mysqli_fetch_assoc($resultPositionCheck);
			//Buy Selected Building
			$result = mysqli_query($conn, 'INSERT INTO playerhasbuild (userID, bID, bLvl, bPos, isUpgrading, timestampSec) VALUES ('.$_SESSION["userID"].', '.($_GET["id"]+1).', 1, '.$_GET["pos"].', 0, SYSDATE())');
			if (!$result) {
				echo "Error:".mysqli_error($conn);
				die();
			}
			//Alter Resources
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
	else {
		die("You don't have enough Credits/Tokens or Reputation to buy that!");
	}
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
