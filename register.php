<?php 
	session_start();
	if (!isset($_SESSION["login"])) {
		$_SESSION["login"] = false;
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
			include "globals.php";
			$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);

			mysqli_select_db($conn, "db_sumus");

			$queryusername = test_input($_POST["username"]);
			$queryusername = strtolower($queryusername);
			$querypassword = test_input($_POST["password"]);
			$queryemail = test_input($_POST["email"]);

			$result = mysqli_query($conn, 'SELECT username FROM users WHERE username = "'.$queryusername.'"');
			if (mysqli_num_rows($result) >=1){
				header("Location: register.php");
				die();
			}
			if (!$result) {
				echo "Error:".mysqli_error($conn);
				die(); //error page here
			}
			

			mysqli_free_result($result);
			$userResult = mysqli_query($conn, 'INSERT INTO users (username, pass, email, confCode, verified, avatarID) VALUES ("'.$queryusername.'", "'.md5($querypassword).'", "'.$queryemail.'", '.rand(1000,9999).', 1, 1)');
			if (!$userResult) {
				echo "Error:".mysqli_error($conn);
				header("Location: register.php");
				die(); //error page here
			}


			mysqli_free_result($userResult);
			$resultID = mysqli_query($conn, 'SELECT userID, username FROM users WHERE username = "'.$queryusername.'"');
			$userID=0;
			if (mysqli_num_rows($resultID) >=1){
				$row = mysqli_fetch_assoc($resultID);
				$userID = $row["userID"];
			}
			if (!$resultID) {
				echo "Error:".mysqli_error($conn);
				header("Location: register.php");
				die(); //error page here
			}
			mysqli_free_result($resultID);


			//INSERT REQUIRED INFO
			mysqli_free_result($result);
			$result2 = mysqli_query($conn, 'INSERT INTO curxp (userID, rep, credits, tokens, albums) VALUES ('.$userID.', 0, 0, 0, 0);');
			if (!$result) {
				echo "Error:".mysqli_error($conn);
				header("Location: register.php");
			}
			mysqli_free_result($result2);
			header("Location: login.php");
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
		<title>Register - Samu</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./styles/fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/credentials.css">
		<link rel="stylesheet" type="text/css" href="./styles/game.css">
	</head>
	<body>
		<div class="sidenav">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<h1 id="logo" class="neonText">SUMUS</h1>
				<h2>Username (Cannot be renamed):</h2>
				<input type="text" name="username" required maxlength="12" minlength="4">
				<h2>Password:</h2>
				<input type="password" name="password" required minlength="8" maxlength="25">
				<h2>Email:</h2>
				<input type="email" name="email" required>
				<input type="submit" name="" value="Register">
				<p>You already have an account? <a href="login.php">Log In here</a></p>
			</form>
		</div>
	</body>
</html>
