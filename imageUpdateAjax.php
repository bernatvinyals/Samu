<?php 
if (session_status()==1) {
	session_start();
}
if (!isset($_SESSION["login"])) {
	die("You must log in first to perform this action.");
}
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
mysqli_select_db($conn, "db_sumus");
for ($i=0; $i < 9; $i++) { 
	$resultInfo = mysqli_query($conn, 'SELECT bID, bPos FROM playerhasbuild WHERE userID = "'.$_SESSION["userID"].'" AND bPos='.$i.'' );
	if (!is_null($resultInfo)) {
		$rowInfo = mysqli_fetch_assoc($resultInfo);
	} 
	if ($rowInfo["bID"] > 0 && $rowInfo["bPos"]==$i) {
		echo "<button "." id='".$i."' class='grid-item' style='background-image: url("."./img/".$rowInfo["bID"]."_building.png)'"." onclick='getInfoOf(".($i+10000).")'>"."</button>";
	}else{
		echo "<button alt="."".$rowInfo["bID"]."  ".$rowInfo["bPos"]." "." id='".$i."' class='grid-item' style='background-image: url("."./img/0_building.png".");' onclick='getInfoOf(".($i+10000).")'>"."</button>";
	}
	mysqli_free_result($resultInfo);
} 
?>
