<?php //Item info
//Ask get
//Input build to get
include "globals.php";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);

mysqli_select_db($conn, "db_sumus");
$resultInfo = mysqli_query($conn, 'SELECT bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee FROM buildings WHERE bID = "'.$_GET["id"].'"');
$rowInfo = mysqli_fetch_assoc($resultInfo);
echo "<p>Name:".$rowInfo["bName"]."</p>";
echo "<p>Reputation Req: ".$rowInfo["rep"]."</p>";
echo "<p>Initial Price:".$rowInfo["bPrice"]."</p>";
echo "<p>Daily Fee: ".$rowInfo["dailyFee"]."</p>";
echo "<p>Income/minute: <br>  Credits: ".$rowInfo["credits"]."<br>  Tokens: ".$rowInfo["tokens"]."</p>";
echo '<input type="button" value="Buy" name="buy">';


mysqli_free_result($resultInfo);
mysqli_close($conn);
 ?>