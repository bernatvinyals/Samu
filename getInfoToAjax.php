<?php
session_start();
if ($_SESSION["login"] != true) {
	header("Location: login.php");	
	die();	
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
$resultInfo = mysqli_query($conn, 'SELECT rep, credits, tokens, albums FROM curxp WHERE userID = '.$_SESSION["userID"].';');
if (!$resultInfo) {
	echo "Error:".mysqli_error($conn);
	die();
	}
$rowInfo = mysqli_fetch_assoc($resultInfo);
$tokens = $rowInfo["tokens"];
$credits = $rowInfo["credits"];
$rep= $rowInfo["rep"];
mysqli_free_result($resultInfo);
mysqli_close($conn);
?>
<div id="repCount">Reputation: <?php echo $rep; ?></div>
<div id="tokensCount">Tokens: <?php echo $tokens; ?></div>
<div id="creditsCount">Credits: <?php echo $credits; ?></div>