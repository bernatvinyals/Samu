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
$result = mysqli_query($conn, 'CREATE TABLE users(userID INT PRIMARY KEY AUTO_INCREMENT,username VARCHAR(16),pass VARCHAR(25),email VARCHAR (60),confCode INT,verified INT,avatarID INT,lastLoginTime TIMESTAMP NOT NULL);');
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

$result = mysqli_query($conn, 'CREATE TABLE playerhasbuild (userID INT, bID INT, bLvl INT, bPos INT, isUpgrading INT, timestampSec TIMESTAMP NOT NULL,FOREIGN KEY (userID) REFERENCES users(userID), FOREIGN KEY (bID) REFERENCES buildings(bID));');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

//BUILDING INSERTS
$result = mysqli_query($conn, 'INSERT INTO buildings(bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee) VALUES (1,"Studio",0,1,0,10,0,300)');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'INSERT INTO buildings(bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee) VALUES (2,"Merch Store",100,1,100,30,0,800)');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'INSERT INTO buildings(bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee) VALUES (3,"Museum",600,1,600,200,0,5000)');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);

$result = mysqli_query($conn, 'INSERT INTO buildings(bID, bName, bPrice, bLvl, rep, credits, tokens, dailyFee) VALUES (4, "Tower",5600,1,1000,460,0,5000)');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);
$fecha = date_create();
$result = mysqli_query($conn, 'INSERT INTO playerhasbuild (userID, bID, bLvl, bPos, isUpgrading, timestampSec) VALUES (1, 2, 1, 2, 0, SYSDATE())');
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

$result = mysqli_query($conn, 'INSERT INTO curxp (userID, rep, credits, tokens, albums) VALUES (1, 1000, 900, 9, 150);');
if (!$result) {
	echo "Error:".mysqli_error($conn);
	die();
}
mysqli_free_result($result);
?>