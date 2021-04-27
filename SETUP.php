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
$result = mysqli_query($conn, 'CREATE TABLE users(userID INT PRIMARY KEY,username VARCHAR(16),pass VARCHAR(25),email VARCHAR (60),confCode INT,verified INT,avatarID INT);');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'CREATE TABLE curXP(infID INT PRIMARY KEY, userID INT,rep INT,credits INT,tokens INT,albums INT,FOREIGN KEY (userID) REFERENCES users(userID));');
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

$result = mysqli_query($conn, 'INSERT INTO users (userID, username, pass, email, confCode, verified, avatarID) VALUES (0, admin, admin, mail@service.com, 0000, 1, 1);');
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