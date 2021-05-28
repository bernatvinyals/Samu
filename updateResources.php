<?php //Save on js the amount of something is generating 
//per minute so every minute it adds 
if (session_status()==1) {
	session_start();
}
if (!isset($_SESSION["login"])) {
	die("You must log in first to perform this action.");
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
/*
JS:
while cada minut => 
php:
actualitzar la ultima vegada que amb logueiga,
en 1 minut cuant? <= sql aumar Currency
*/
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
  		print_r($rowOfBuilding);
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
	$Tokens=floor($TotalCredits/1000);
	$Credits=$TotalCredits%1000;
	if ($rowUserInfo["credits"]+$Credits>1000){
		$Tokens +=1;
		$Credits = ($rowUserInfo["credits"]-1000)+$Credits;
		echo "1 ".$Credits."  ".$Tokens;
  		AlterResources($conn,$Credits,$Tokens,true);
	}
	else{
		echo "0 ".$Credits."  ".$Tokens;
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