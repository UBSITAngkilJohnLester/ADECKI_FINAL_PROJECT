<?php
	session_start();
	require_once "../dbconn.php";

	// Game ID comes from the link (GET) or the hidden field after posting (POST)
	$GameID = (int)($_POST['gameid'] ?? $_GET['gameid'] ?? 0);

	$gameStmt = $pdo->prepare("SELECT GameTitle FROM game WHERE GameID = ?");
	$gameStmt->execute([$GameID]);
	$game = $gameStmt->fetch();

	if (!$game) {
		header("Location: index.php");  // no valid game chosen
		exit;
	}

	if (isset($_POST['post'])) {
		$Rating    = (int)$_POST['rating'];
		$Feedback  = $_POST['feedback'];
		$Bugreport = $_POST['bugreport'];
		$TesterID  = $_SESSION['TesterID'];

		$Playtime = sprintf('%02d:%02d:%02d',
			(int)$_POST['playtime_hours'],
			(int)$_POST['playtime_minutes'],
			(int)$_POST['playtime_seconds']
	);

		$reviewStmt = $pdo->prepare(
			"INSERT INTO review (rating, feedback, playtime, GameID, TesterID, Bugreport) VALUES (?, ?, ?, ?, ?, ?)");
		$reviewStmt->execute([$Rating, $Feedback, $Playtime, $GameID, $TesterID, $Bugreport]);

		header("Location: index.php");
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
				<td><button name="post">Post</button> |
					<a href="index.php">Back</a>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>