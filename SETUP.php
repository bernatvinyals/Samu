<?php 
//DATABASE SERVER SETUP WITH A DEFAULT ADMIN ACCOUNT
$USERNAME = "root";
$PASSWORD = "";
$SERVER = "localhost:3306";
$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);
$result = mysqli_query($conn, 'CREATE DATABASE db_sumus');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

mysqli_select_db($conn, "db_sumus");
$result = mysqli_query($conn, 'CREATE TABLE users(userID INT PRIMARY KEY AUTO_INCREMENT,username VARCHAR(16),pass VARCHAR(25),email VARCHAR (60),confCode INT,verified INT,avatarID INT);');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'CREATE TABLE curXP(infID INT PRIMARY KEY AUTO_INCREMENT, userID INT,rep INT,credits INT,tokens INT,albums INT,FOREIGN KEY (userID) REFERENCES users(userID));');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'CREATE TABLE buildings(bID INT PRIMARY KEY, bName VARCHAR(16), bPrice INT, bLvl INT, rep INT, credits INT, tokens INT, dailyFee INT);');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'CREATE TABLE playerHasBuild (userID INT, bID INT, bLvl INT, bPos INT, FOREIGN KEY (userID) REFERENCES users(userID), FOREIGN KEY (bID) REFERENCES buildings(bID));');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

//BUILDING INSERTS
$result = mysqli_query($conn, 'INSERT INTO buildings(bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee) VALUES (0,"Studio",0,1,0,10,0,300)');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'INSERT INTO buildings(bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee) VALUES (1,"Merch Store",100,1,100,30,0,800)');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'INSERT INTO buildings(bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee) VALUES (2,"Museum",600,1,600,200,0,5000)');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'INSERT INTO buildings(bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee) VALUES (3, "Tower",5600,1,1000,46,0,5000)');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);









//USER INSERTS
$result = mysqli_query($conn, 'INSERT INTO users (userID, username, pass, email, confCode, verified, avatarID) VALUES (0, "admin", "admin", "mail@service.com", 0000, 1, 1);');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'INSERT INTO curxp (userID, rep, credits, tokens, albums) VALUES (0, 10, 200, 3, 150);');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);
?>