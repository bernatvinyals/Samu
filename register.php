<?php 
	//Login
	//	CREATE DATABASE db_sumus;
	//CREATE TABLE users(
	//	userID INT PRIMARY KEY,
	//    username VARCHAR(16),
	//    pass VARCHAR(16),
	//    email VARCHAR (60),
	//    confCode INT,
	//    verified INT,
	//    avatarID INT
	//);

	session_start();
	if (!isset($_SESSION["login"])) {
		$_SESSION["login"] = false;
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["username"]) && isset($_POST["password"]) && $_SESSION["login"] != true) {
			$USERNAME = "root";
			$PASSWORD = "";
			$SERVER = "localhost:3306";
			$conn = mysqli_connect($SERVER, $USERNAME, $PASSWORD);

			mysqli_select_db($conn, "db_sumus");

			$queryusername = test_input($_POST["username"]);
			$querypassword = test_input($_POST["password"]);

			$result = mysqli_query($conn, 'SELECT userID, username, pass, avatarID FROM users WHERE username = "'.$queryusername.'" AND pass = "'.$querypassword.'"');
			if (!$result) {
				echo "Error:".mysqli_error($conn); //error page here
			}
			print_r($result);
			$row = mysqli_fetch_assoc($result);
			echo ($queryusername);
			echo ($querypassword);

			if (mysqli_num_rows($result) >=1){	
				$_SESSION["username"] = $_POST["username"];
				$_SESSION["userID"] = $row["userID"];
				$_SESSION["avatarID"] = $row["avatarID"];
				$_SESSION["login"] = true;
			}
			mysqli_free_result($result);
		}
		if ($_SESSION["login"]  == true) {
			header("Location: game.php");
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
	</head>
	<body>
		 <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type="text" name="username" required>
			<input type="password" name="password" required>
			<input type="email" name="email" required>
			<input type="submit" name="" value="Register">
		</form>
	</body>
</html>
