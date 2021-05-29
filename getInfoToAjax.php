<?php
session_start();
if ($_SESSION["login"] != true) {
	header("Location: login.php");	
	die();	
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
$resultInfo = mysqli_query($conn, 'SELECT curxp.rep, curxp.credits, curxp.tokens, curxp.albums FROM (curxp INNER JOIN users ON users.username = "'.$_SESSION["username"].'");');
if (!$resultInfo) {
	echo "Error:".mysqli_error($conn);
	header("Location: logout.php");
	die();
	}
$rowInfo = mysqli_fetch_assoc($resultInfo);
$tokens = $rowInfo["tokens"];
$credits = $rowInfo["credits"];
$albums= $rowInfo["albums"];
mysqli_free_result($resultInfo);
mysqli_close($conn);
?>
<div id="tokensCount">Tokens: <?php echo $tokens; ?></div>
<div id="creditsCount">Credits: <?php echo $credits; ?></div>