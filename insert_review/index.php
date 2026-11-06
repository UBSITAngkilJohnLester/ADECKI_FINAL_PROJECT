<?php
	//session_start();
	include "dbconn.php";

	// Game ID comes from the link (GET) or the hidden field after posting (POST)
	$GameID = (int)($_POST['gameid'] ?? $_GET['gameid'] ?? 0);

	// Look up the game so we can show its title
	$stmt = mysqli_prepare($conn, "SELECT GameTitle FROM game WHERE GameID = ?");
	mysqli_stmt_bind_param($stmt, "i", $GameID);
	mysqli_stmt_execute($stmt);
	$game = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

	if (!$game) {
		header("Location: Tester_games.php");  // no valid game chosen
		exit;
	}

	if (isset($_POST['post'])) {
		$Rating    = (int)$_POST['rating'];
		$Feedback  = $_POST['feedback'];
		$Playtime  = (int)$_POST['playtime'];
		$Bugreport = $_POST['bugreport'];
		$TesterID  = 1; // later: $_SESSION['TesterID']
		$TesterID = 6; //temporary until login is done

		$Playtime = sprintf('%02d:%02d:%02d',
			(int)$_POST['playtime_hours'],
			(int)$_POST['playtime_minutes'],
			(int)$_POST['playtime_seconds']
	);

		$stmt = mysqli_prepare($conn,
			"INSERT INTO review (rating, feedback, playtime, GameID, TesterID, Bugreport) VALUES (?, ?, ?, ?, ?, ?)");
		mysqli_stmt_bind_param($stmt, "isiiis", $Rating, $Feedback, $Playtime, $GameID, $TesterID, $Bugreport);
		mysqli_stmt_execute($stmt);

		header("Location: Tester_games.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Review <?= htmlspecialchars($game['GameTitle']) ?></title>
</head>
<body>
	<form method="post">
		<input type="hidden" name="gameid" value="<?= $GameID ?>">
		<table>
			<tr><th colspan="2">GAME REVIEW POSTING</th></tr>
			<tr>
				<td colspan="2"><h2><?= htmlspecialchars($game['GameTitle']) ?></h2></td>
			</tr>
			<tr>
				<td>Rating</td>
				<td>
					<select name="rating" required>
						<option selected disabled>Rate the Game</option>
						<option value="1">1★</option>
						<option value="2">2★</option>
						<option value="3">3★</option>
						<option value="4">4★</option>
						<option value="5">5★</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Game Feedback</td>
				<td><textarea name="feedback" rows="3"></textarea></td>
			</tr>
			<tr>
            <td>Playtime</td>
            <td>
                <input type="number" name="playtime_hours" min="0" placeholder="Hours" style="width: 70px;"> :
                <input type="number" name="playtime_minutes" min="0" max="59" placeholder="Min" style="width: 50px;"> :
                <input type="number" name="playtime_seconds" min="0" max="59" placeholder="Sec" style="width: 50px;">
            </td>
        </tr>
			<tr>
				<td>Bug Report</td>
				<td><textarea name="bugreport" rows="3" value="Leave blank if none"></textarea></td>
			</tr>
			<tr>
				<td><button name="post">Post</button></td>
			</tr>
		</table>
	</form>
</body>
</html>