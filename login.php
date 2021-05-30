<?php 
	//Login
	//	CREATE DATABASE db_sumus;
	//CREATE TABLE users(
	//	userID INT PRIMARY KEY,
	//    username VARCHAR(16),
	//    pass VARCHAR(25),
	//    email VARCHAR (60),
	//    confCode INT,
	//    verified INT,
	//    avatarID INT
	//);
	//INSERT INTO `users` (`userID`, `username`, `pass`, `email`, `confCode`, `verified`, `avatarID`) VALUES ('0', 'admin', 'admin', 'mail@service.com', NULL, NULL, '1');
	//CREATE TABLE curXP(
	//    infID INT PRIMARY KEY,
	//	userID INT,
	//    rep INT,
	//    credits INT,
	//    tokens INT,
	//    albums INT,
	//  	FOREIGN KEY (userID) REFERENCES users(userID)
	//);
	//CREATE TABLE buildings(bID INT PRIMARY KEY, bName VARCHAR(16), bPrice INT, bLvl INT, rep INT, credits INT, tokens INT, dailyFee INT);
	//CREATE TABLE playerHasBuild (userID INT, bID INT, bLvl INT, bPos INT, FOREIGN KEY (userID) REFERENCES users(userID), FOREIGN KEY (bID) REFERENCES buildings(bID));
	session_start();
	if (!isset($_SESSION["login"])) {
		$_SESSION["login"] = false;
	}
	if ($_SESSION["login"]  == true) {
		header("Location: game.php");
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["username"]) && isset($_POST["password"]) && $_SESSION["login"] != true) {
			include "globals.php";
			$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);

			mysqli_select_db($conn, "db_sumus");



//Check login
			$queryusername = test_input($_POST["username"]);
			$querypassword = test_input($_POST["password"]);

			$result = mysqli_query($conn, 'SELECT userID, username, pass, verified, avatarID FROM users WHERE username = "'.$queryusername.'" AND pass = "'.md5($querypassword).'"');
			if (!$result) {
				echo "Error:".mysqli_error($conn);
				header("Location: login.php");
				die();
			}
			$row = mysqli_fetch_assoc($result);



//Save Player Var if login = true
			if (mysqli_num_rows($result) >=1){	
				if ($row["verified"]==0) {
					header("Location: login.php");//TODO vefification page
					die();
				}

				$_SESSION["username"] = $_POST["username"];
				$_SESSION["userID"] = $row["userID"];
				$_SESSION["avatarID"] = $row["avatarID"];
				$_SESSION["login"] = true;
			}
			mysqli_free_result($result);
		}
		if ($_SESSION["login"]  == true) {
			mysqli_close($conn);
			header("Location: game.php");
			die();
		}
		mysqli_close($conn);
	}
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Log In - Samu</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./styles/fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/credentials.css">
		<link rel="stylesheet" type="text/css" href="./styles/game.css">
	</head>
	<body>
		<div class="sidenav">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<h1 id="logo" class="neonText">SUMUS</h1>
				<h2>Username:</h2>
				<input type="text" name="username" required maxlength="12" minlength="4">
				<h2>Password:</h2>
				<input type="password" name="password" required  maxlength="25">
				<input type="submit" name="" value="Log In">
				<p>Don't have an account? <a href="register.php">Register right here</a></p>
			</form>
		</div>
	</body>
</html>
