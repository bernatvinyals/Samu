<?php 
session_start();
if (!isset($_SESSION["login"]) || !isset($_GET["pos"])) {
	die("You must log in first to perform this action.");
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
echo "Input: Pos: ".$_GET["pos"]."<BR>";
$resultUpgrade = mysqli_query($conn, 'DELETE  FROM playerhasbuild WHERE userID = '.$_SESSION["userID"].' AND bPos ='.$_GET["pos"].' ');
if (!$resultUpgrade) {
	die("You must log in first to perform this action.");
}else{
	echo "You sussesfully removed this building.";
}
 ?>
