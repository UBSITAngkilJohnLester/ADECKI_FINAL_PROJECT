<?
	require_once "dbconn.php";

	if ($pdo) {
		echo "ok";
	}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>IndieHause</title>
</head>
<body>
	<div>	
		<nav>
			<a href="index.php">Home</a>
			<a href="games.php">Games</a>
			<a href="developer.php">Developers</a>
			<a href="about.php">About Us</a>
			<a href="login\login.php">LogIn</a>
		</nav>
	</div>
</body>
</html>