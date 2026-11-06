<?php
	//session_start();
	date_default_timezone_set('Asia/Manila');
	include "dbconn.php";
	
	//if (!isset($_SESSION['DeveloperID'])) {
	//	header("Location: login.php");
	//	exit;
	//}


	if(isset($_POST['post'])) {
		$Gametitle = $_POST['gametitle'];
		$Genre = $_POST['genre'];
		$DateReleased = date('Y-m-d');
		$Platform = $_POST['platform'];
		$DevID = $_SESSION['DeveloperID'] = 2; // set by the login file

		$insert = "INSERT INTO game (GameTitle, Genre, DateReleased, Platform, DeveloperID) VALUES ('$Gametitle', '$Genre', '$DateReleased', '$Platform', '$DevID')";
		mysqli_query($conn, $insert);

	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<table>
		<form method="post">
			<th>GAME TITLE POSTING</th>
			<tr>
				<td>Game Title</td>
				<td><input type="text" name="gametitle" required></td>
			</tr>
			<tr>
				<td>Game Genre</td>
				<td>
				<select name="genre" required>
					<option selected disabled>Select a Genre</option>
					<option value="Adventure">Adventure</option>
					<option value="Action">Action</option>
					<option value="Metroid">Metroid</option>
					<option value="RPG">RPG</option>
					<option value="Racing">Racing</option>
					<option value="Strategy">Strategy</option>
					<option value="Sim">Sim</option>
					<option value="Horror">Horror</option>
					<option value="Puzzle">Puzzle</option>
					<option value="Sports">Sports</option>					
				</select>
				</td>
			</tr>
			<tr>
				<td>Platform to Play on</td>
				<td>
					<select name="platform" required>
						<option selected disabled>Select a Platform</option>
						<option value="PC">PC</option>
						<option value="Xbox">Xbox</option>
						<option value="PlayStation">PlayStation</option>
						<option value="Handheld Game Console">Handheld Game Console</option>
						<option value="Mobile">Mobile</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><button name="post">Post</button></td>
			</tr>
		</form>
	</table>
</body>
</html>

