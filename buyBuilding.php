<?php 
session_start();
if (!isset($_SESSION["login"])) {
	die("You must log in first to perform this action.");
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
echo "Input: ".$_GET["id"]."<BR>";
$resultBuy = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, dailyFee FROM buildings WHERE bID = "'.$_GET["id"].'"');
$resultBuyCheck = mysqli_fetch_assoc($resultBuy);
if (!$resultBuy) {
		die("You must log in first to perform this action.");
	}
	if (mysqli_num_rows($resultBuy) >=1){
		//TODO CHECK WITH playerInfo

		$resultResources = mysqli_query($conn, 'SELECT rep, credits, tokens, albums FROM curxp  WHERE userID = "'.$_SESSION["userID"].'";');
		if (!$resultResources) {
			die("Error:".mysqli_error($conn));
		}
		$rowResources = mysqli_fetch_assoc($resultResources);
		$creditsCalc=$rowResources["credits"]+($rowResources["tokens"]*1000);
		if ($rowResources["rep"]>=$resultBuyCheck["rep"] && $creditsCalc>=$resultBuyCheck["dailyFee"]) {
			//TODO: Ask Position and alter/Insert table playerHasBuilds
			
			echo "Congrats! <br>You just Bought a ".$resultBuyCheck["bName"];

		}
		else {
			die("You don't have enough Credits/Tokens to buy that!");
		}

	}
 ?>
